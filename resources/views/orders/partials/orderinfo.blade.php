
<div class="card-body">
  
    
     <hr class="my-4" />
 
     @if (config('app.isft'))
         <h6 class="heading-small text-muted mb-4">{{ __('Client Information') }}</h6>
         <div class="pl-lg-4">
             <h3>{{ $order->client->name }}</h3>
             <h4>{{ $order->client->email }}</h4>
             <h4>{{ $order->address?$order->address->address:"" }}</h4>
 
        
             @if(!empty($order->client->phone))
             <br/>
             <h4>{{ __('Contact')}}: {{ $order->client->phone }}</h4>
             @endif
         </div>
         <hr class="my-4" />
     
     @endif
     
 
 
     
     <h6 class="heading-small text-muted mb-4">{{ __('Order') }}</h6>
     <?php 
                 $currency=config('settings.cashier_currency');
                
             ?>
     <ul id="order-items">
         @foreach($order->items as $item)
             <?php 
                 $theItemPrice= ($item->pivot->variant_price?$item->pivot->variant_price:$item->price);
             ?>
             <li><h4>{{ $item->pivot->qty." X ".$item->name }} - {{$theItemPrice }} =  ( {{ $item->pivot->qty*$theItemPrice}} )
                 @hasrole('admin|driver|chief|accountant')
                     @if($item->pivot->vatvalue>0))
                     <span class="small">-- {{ __('VAT ').$item->pivot->vat."%: "}} ( {{  $item->pivot->vatvalue}} )</span>
                     @endif
                 @endif
             </h4>
                 @if (strlen($item->pivot->variant_name)>2)
                     <br />
                     <table class="table align-items-center">
                         <thead class="thead-light">
                             <tr>
                                 @foreach ($item->options as $option)
                                     <th>{{ $option->name }}</th>
                                 @endforeach
 
 
                             </tr>
                         </thead>
                         <tbody class="list">
                             <tr>
                                 @foreach (explode(",",$item->pivot->variant_name) as $optionValue)
                                     <td>{{ $optionValue }}</td>
                                 @endforeach
                             </tr>
                         </tbody>
                     </table>
                 @endif
 
                 @if (strlen($item->pivot->extras)>2)
                     <br /><span>{{ __('Extras') }}</span><br />
                     <ul>
                         @foreach(json_decode($item->pivot->extras) as $extra)
                             <li> {{  $extra }}</li>
                         @endforeach
                     </ul><br />
                 @endif
                 <br />
             </li>
         @endforeach
     </ul>
     @if(!empty($order->comment))
        <br/>
        <h4>{{ __('Comment') }}: {{ $order->comment }}</h4>
     @endif
     @if(strlen($order->phone)>2)
        <h4>{{ __('Phone') }}: {{ $order->phone }}</h4>
     @endif
     <br />
     @if(!empty($order->time_to_prepare))
     <br/>
     <h4>{{ __('Time to prepare') }}: {{ $order->time_to_prepare ." " .__('minutes')}}</h4>
     <br/>
     @endif
     @hasrole('admin|driver|chief|accountant')
     <h5>{{ __("NET") }}: {{ $order->order_price-$order->vatvalue}}</h5>
     
 
     @endif
     <h4>{{ __("Sub Total") }}: {{ $order->order_price}}</h4>
     @if(config('app.isft'))
     <h4>{{ __("Delivery") }}: {{ $order->delivery_price}}</h4>
     @endif
     <hr />
     <h3>{{ __("TOTAL") }}: {{ $order->delivery_price+$order->order_price}}</h3>
     <hr />
     <h4>{{ __("Payment method") }}: {{ __(strtoupper($order->payment_method)) }}</h4>
     <h4>{{ __("Payment status") }}: {{ __(ucfirst($order->payment_status)) }}</h4>
     @if ($order->payment_status=="unpaid"&&strlen($order->payment_link)>5)
         <button onclick="location.href='{{$order->payment_link}}'" class="btn btn-success">{{ __('Pay now') }}</button>
     @endif
     <hr />
     @if(config('app.isft') || config('app.iswp'))
         <h4>{{ __("Delivery method") }}: {{ $order->getExpeditionType() }}</h4>
         @else
           @if ($order->delivery_method!=3)
               @endif
     @endif

     @if(isset($custom_data)&&count($custom_data)>0)
        <hr />
        <h3>{{ __(config('settings.label_on_custom_fields')) }}</h3>
        @foreach ($custom_data as $keyCutom => $itemValue)
            <h4>{{ __("custom.".$keyCutom) }}: {{ $itemValue }}</h4>
        @endforeach
     @endif

     
 
 
 </div>