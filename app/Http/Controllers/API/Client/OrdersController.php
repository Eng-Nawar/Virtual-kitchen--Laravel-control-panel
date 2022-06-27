<?php

namespace App\Http\Controllers\API\Client;

use App\Repositories\Orders\OrderRepoGenerator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Orderstatus;
use App\Models\Orderitem;
use App\Models\Items;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Order::where('client_id', auth()->user()->id)->orderBy('id', 'DESC')->limit(50)->with(['restorant', 'status', 'items', 'address', 'driver'])->get(),
            'status' => true,
            'message' => '',
        ]);
    }
   
    public function getorderbyid($id)
    {
        //by client
        $orders = Order::orderBy('created_at', 'desc')->limit(5);
        $orders = $orders->where(['client_id'=>$id]);
        $items = [];
     foreach ($orders->get() as $key => $order) {
         
         $item = [
             'order_id'=>$order->id,
            
             'created'=>$order->created_at,
             'last_status'=>$order->status->pluck('alias')->last(),
          
             'address'=>$order->address ? $order->address : '',
             
             'order_price'=>$order->order_price,
             
           ];
         array_push($items, $item);
     }
      
 
       if(count($items) != 0)
       {
         return response()->json([
             //'data' => Order::where('client_id', auth()->user()->id)->orderBy('id', 'DESC')->limit(50)->with(['restorant', 'status', 'items', 'address', 'driver'])->get(),
             'data' => $items,
             'status' => true,
             'message' => '',
         ]);}
         else 
         {
             return response()->json([
                 //'data' => Order::where('client_id', auth()->user()->id)->orderBy('id', 'DESC')->limit(50)->with(['restorant', 'status', 'items', 'address', 'driver'])->get(),
          
                 'status' => false,
                 'message' => '',
             ]);  
         }
        
    }

    public function getdeliveriesbyid($id)
    {
       //BY DRIVER
       $orders = Order::orderBy('created_at', 'desc');
       $orders = $orders->where(['driver_id'=>$id]);
       $items = [];
    foreach ($orders->get() as $key => $order) {
        if($order->status->pluck('alias')->last() == 'picked_up')
        {
        $item = [
            'order_id'=>$order->id,
           
            //'created'=>$order->created_at,
            'last_status'=>$order->status->pluck('alias')->last(),
            'client_name'=>$order->client ? $order->client->name : '',
            'client_id' => $order->client_id,
            'address'=>$order->address ? $order->address : '',
            
            'order_price'=>$order->order_price,
            
          ];
        array_push($items, $item);
    }
     }

      if(count($items) != 0)
      {
        return response()->json([
            //'data' => Order::where('client_id', auth()->user()->id)->orderBy('id', 'DESC')->limit(50)->with(['restorant', 'status', 'items', 'address', 'driver'])->get(),
            'data' => $items,
            'status' => true,
            'message' => '',
        ]);}
        else 
        {
            return response()->json([
                //'data' => Order::where('client_id', auth()->user()->id)->orderBy('id', 'DESC')->limit(50)->with(['restorant', 'status', 'items', 'address', 'driver'])->get(),
         
                'status' => false,
                'message' => '',
            ]);  
        }
    }
public function updatestatus(Request $request)
        {
        $order = Order::find($request['order_id']);
        //add status delivered
            
        $order_status = new Orderstatus;

        $order_status->order_id = $request['order_id'];
        $order_status->status_id = '7';
        $order_status->user_id = $request['orderBy'];
        $order_status->save();

        //update payment to paid
        $order->payment_status ='paid';
        $order->save();
        return response()->json([
             'status' => true,
        ]);

        }
    public function store(Request $request){
 
        $order = new Order;

        //$order->id = $request->orderId;
        $order->address = $request->address;
        $order->order_price = $request->totalAmount;
        $order->payment_method = $request->paymentDetails;
        $order->client_id = $request->orderBy;
    
        $order->save();
        //add status just created
       
            $order_status = new Orderstatus;

            $order_status->order_id = $order->id;
            $order_status->status_id = '1';
            $order_status->user_id = $request->orderBy;
            $order_status->save();

        // add items

       
        $res1 = str_ireplace( array( '[', ']' ), '', $request->itemIDs);
        $res2 = str_ireplace( array( '[', ']' ), '', $request->itemQty);
    

        $cart_item_ids = (array)$res1;
        $cart_item_qty = (array)$res2;

        //strtok($request->itemIDs, ", ");
        $cart_item_ids_a = explode(', ', $res1);
        $cart_item_qty_a = explode(', ', $res2);

        
       print( $cart_item_ids_a[0] );

        foreach($cart_item_ids_a as $key => $ids)
        {
            $order_item = new Orderitem;

            $order_item->order_id = $order->id;
            $order_item->item_id = $ids;
            $order_item->qty = $cart_item_qty_a[$key];
            $order_item->save();
        }
    
   
        
        return response()->json([
            'status' => true,
            'message' => 'Order created',
            'id'=>$order->id,
        
        ]);
       /* //Init validator
        $validatorOnInit = Validator::make($request->all(), ['vendor_id'=>['required']]);
        if ($validatorOnInit->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validatorOnInit->errors()->first(),
            ]);
        }


        //Data
        $mobileLikeRequest=$request;
        $vendor_id =  $mobileLikeRequest->vendor_id;
        $expedition= $mobileLikeRequest->delivery_method;
        $hasPayment= $mobileLikeRequest->payment_method!="cod";
        $isStripe= $mobileLikeRequest->payment_method=="stripe";

        //Repo Holder
        $orderRepo=OrderRepoGenerator::makeOrderRepo($vendor_id,$mobileLikeRequest,$expedition,$hasPayment,$isStripe,true);
    
        
        //Proceed with validating the data
        $validator=$orderRepo->validateData();
        if ($validator->fails()) { 
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ]);
        }

        //Proceed with making the order
        $validatorOnMaking=$orderRepo->makeOrder();
        if ($validatorOnMaking->fails()) { 
            return response()->json([
                'status' => false,
                'message' => $validatorOnMaking->errors()->first(),
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Order created',
            'id'=>$orderRepo->order->id,
            'paymentLink'=>$orderRepo->paymentRedirect
        ]);
         */
    }
}
