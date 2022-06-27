<thead class="thead-light">
    <tr>
        <th scope="col">{{ __('ID') }}</th>
        
        <th class="table-web" scope="col">{{ __('Created') }}</th>
        <th class="table-web" scope="col">{{ __('Method') }}</th>

        <th class="table-web" scope="col">{{ __('Delivery') }}</th>

        <th class="table-web" scope="col">{{ __('Net Price') }}</th>
        
        
        <th class="table-web" scope="col">{{ __('Total Price') }}</th>
        
    </tr>
</thead>
<tbody>
@foreach($orders as $order)
<tr>
    <td>
        
        <a class="btn badge badge-success badge-pill" href="{{ route('orders.show',$order->id )}}">#{{ $order->id }}</a>
    </td>
   

    <td class="table-web">
        {{ $order->created_at }}
    </td>
    <td class="table-web">
        @if(config('app.isft') || config('app.iswp'))
            <span class="badge badge-primary badge-pill">{{ $order->getExpeditionType() }} | {{ __($order->payment_method) }} </span>
        @else
            <span class="badge badge-primary badge-pill">{{ $order->getExpeditionType() }} | {{ __($order->payment_method) }} </span>
        @endif
    </td>
    
  
    <td class="table-web">
       0 SP
    </td>
    <td class="table-web">
        {{  $order->order_price-($order->fee_value+$order->static_fee)}} SP
    </td>
   
    <td class="table-web">
        {{ $order->order_price-($order->fee_value+$order->static_fee)-$order->vatvalue }} SP
    </td>

    
</tr>
   

@endforeach
</tbody>