<?php

namespace App\Http\Controllers;

use App\Exports\FinancesExport;
use App\Models\Order;

use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Stripe\Account;
use Stripe\AccountLink;
use Stripe\Stripe;

class FinanceController extends Controller
{
    private function getResources()
    {
       
        $drivers = User::role('driver')->where(['active'=>1])->get();
        $clients = User::role('client')->where(['active'=>1])->get();

        $orders = Order::orderBy('created_at', 'desc');

        //Get client's orders
        if (auth()->user()->hasRole('client')) {
            $orders = $orders->where(['client_id'=>auth()->user()->id]);
        ////Get driver's orders
        } elseif (auth()->user()->hasRole('driver')) {
            $orders = $orders->where(['driver_id'=>auth()->user()->id]);
        }

        
        //BY CLIENT
        if (isset($_GET['client_id'])) {
            $orders = $orders->where(['client_id'=>$_GET['client_id']]);
        }

        //BY DRIVER
        if (isset($_GET['driver_id'])) {
            $orders = $orders->where(['driver_id'=>$_GET['driver_id']]);
        }

        //BY DATE FROM
        if (isset($_GET['fromDate']) && strlen($_GET['fromDate']) > 3) {
            //$start = Carbon::parse($_GET['fromDate']);
            $orders = $orders->whereDate('created_at', '>=', $_GET['fromDate']);
        }

        //BY DATE TO
        if (isset($_GET['toDate']) && strlen($_GET['toDate']) > 3) {
            //$end = Carbon::parse($_GET['toDate']);
            $orders = $orders->whereDate('created_at', '<=', $_GET['toDate']);
        }

        return ['orders' => $orders, 'drivers'=>$drivers, 'clients'=>$clients];
    }

    public function adminFinances()
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $resources = $this->getResources();
        $resources['orders'] = $resources['orders']->where('payment_status','paid')->whereNotNull('payment_method');

        //With downloaod
        if (isset($_GET['report'])) {
            $items = [];
            foreach ($resources['orders']->get() as $key => $order) {
                $item = [
                    'order_id'=>$order->id,
                   
                    'created'=>$order->created_at,
                    'last_status'=>$order->status->pluck('alias')->last(),
                    'client_name'=>$order->client?$order->client->name:"",
                    'client_id'=>$order->client_id,
                    'address'=>$order->address ? $order->address->address : '',
                   
                    'driver_name'=>$order->driver ? $order->driver->name : '',
                    'driver_id'=>$order->driver_id,
                    'payment_method'=>$order->payment_method,
                    'srtipe_payment_id'=>$order->srtipe_payment_id,
                  
                    'order_fee'=>$order->fee_value,
                    'restaurant_static_fee'=>$order->static_fee,
                    'platform_fee'=>$order->fee_value + $order->static_fee,
                    'processor_fee'=>$order->payment_processor_fee,
                    'delivery'=>$order->delivery_price,
                    'net_price_with_vat'=>$order->order_price,
                    'vat'=>$order->vatvalue,
                    'net_price'=>$order->order_price - $order->vatvalue,
                    'order_total'=>$order->delivery_price + $order->order_price,
                  ];
                array_push($items, $item);
            }

            return Excel::download(new FinancesExport($items), 'finances_'.time().'.xlsx');
        }

        //CARDS
        $cards = [
            ['title'=>'Orders', 'value'=>0],
            ['title'=>'Total', 'value'=>0, 'isMoney'=>true],
          
            ['title'=>'Net', 'value'=>0, 'isMoney'=>true],

           
            ['title'=>'Deliveries', 'value'=>0],
            ['title'=>'Delivery income', 'value'=>0, 'isMoney'=>true],
            
        ];
        foreach ($resources['orders']->get() as $key => $order) {
            $cards[0]['value'] += 1;
            $cards[1]['value'] += $order->delivery_price + $order->order_price;
           
            $cards[2]['value'] += $order->order_price - $order->fee_value - $order->static_fee;

          
            $cards[3]['value'] += $order->delivery_method.'' == '1' ? 1 : 0;
            $cards[4]['value'] += $order->delivery_price;
               }

        $displayParam = [
            'cards'=> $cards,
            'orders' => $resources['orders']->paginate(10),
        
            'drivers'=>$resources['drivers'],
            'clients'=>$resources['clients'],
            'parameters'=>count($_GET) != 0,
        ];

        return view('finances.index', $displayParam);
    }

    public function accountantFinances()
    {
        if (! auth()->user()->hasRole('accountant')) {
            abort(403, 'Unauthorized action.');
        }

 

        //Check if Owner has completed
        $stripe_details_submitted = __('No');
        if (auth()->user()->stripe_account) {
            //Set our key
            Stripe::setApiKey(config('settings.stripe_secret'));

            $stripe_details_submitted = Account::retrieve(
                auth()->user()->stripe_account, []
              )->details_submitted ? __('Yes') : __('No');
        }

        $resources = $this->getResources();

        $resources['orders'] = $resources['orders']->whereNotNull('payment_method')->where('payment_status','paid');

        //With downloaod
        if (isset($_GET['report'])) {
            $items = [];
            foreach ($resources['orders']->get() as $key => $order) {
                $item = [
                    'order_id'=>$order->id,
               
                    'created'=>$order->created_at,
                    'last_status'=>$order->status->pluck('alias')->last(),
                    'client_name'=>$order->client ? $order->client->name : '',
                    'client_id'=>$order->client_id,
                    'address'=>$order->address ? $order->address->address : '',
             
                    'driver_name'=>$order->driver ? $order->driver->name : '',
                    'driver_id'=>$order->driver_id,
                    'payment_method'=>$order->payment_method,
                    'srtipe_payment_id'=>$order->srtipe_payment_id,
                    'restaurant_fee'=>$order->fee,
                    'order_fee'=>$order->fee_value,
                    'restaurant_static_fee'=>$order->static_fee,
                    'platform_fee'=>$order->fee_value + $order->static_fee,
                    'processor_fee'=>$order->payment_processor_fee,
                    'delivery'=>$order->delivery_price,
                    'net_price_with_vat'=>$order->order_price,
                    'vat'=>$order->vatvalue,
                    'net_price'=>$order->order_price - $order->vatvalue,
                    'order_total'=>$order->delivery_price + $order->order_price,
                  ];
                array_push($items, $item);
            }

            return Excel::download(new FinancesExport($items), 'finances_'.time().'.xlsx');
        }

        //CARDS
        $cards = [
            ['title'=>'Orders', 'value'=>0],
            ['title'=>'Total', 'value'=>0, 'isMoney'=>true],
          
            ['title'=>'Net inc. Vat', 'value'=>0, 'isMoney'=>true],

          
            ['title'=>'Net', 'value'=>0, 'isMoney'=>true],
            ['title'=>'Deliveries', 'value'=>0],
            ['title'=>'Delivery cost', 'value'=>0, 'isMoney'=>true],
        ];
        foreach ($resources['orders']->get() as $key => $order) {
            $cards[0]['value'] += 1;
            $cards[1]['value'] += $order->delivery_price + $order->order_price;
          
            $cards[2]['value'] += $order->order_price - $order->fee_value - $order->static_fee;

          
            $cards[3]['value'] += $order->order_price - $order->vatvalue - $order->fee_value - $order->static_fee;
            $cards[4]['value'] += $order->delivery_method.'' == '1' ? 1 : 0;
            $cards[5]['value'] += $order->delivery_price;
        }

        $displayParam = [
            'cards'=> $cards,
            'orders' => $resources['orders']->paginate(10),
    
            'drivers'=>$resources['drivers'],
            'clients'=>$resources['clients'],
            'parameters'=>count($_GET) != 0,
            'stripe_details_submitted'=>$stripe_details_submitted,
            'showFeeTerms'=>true,
            'showStripeConnect'=>true,
           
            'weHaveStripeConnect'=>env('ENABLE_STRIPE_CONNECT', false),
        ];

        return view('finances.index', $displayParam);
    }

    public function connect()
    {

        //Set our key
        Stripe::setApiKey(config('settings.stripe_secret'));

        if (! auth()->user()->stripe_account) {
            //Create account for client
            $account_id = Account::create([
                'type' => 'standard',
            ])->id;

            //Save this id in user object
            auth()->user()->stripe_account = $account_id;
            auth()->user()->update();
        } else {
            $account_id = auth()->user()->stripe_account;
        }

        //Set account
        $account_links = AccountLink::create([
            'account' => $account_id,
            'refresh_url' => route('finances.owner'),
            'return_url' => route('finances.owner'),
            'type' => 'account_onboarding',
            ]);

        return redirect()->away($account_links->url);
    }
}
