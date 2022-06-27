<thead class="thead-light">
    <tr>
        <th scope="col">{{ __('ID') }}</th>
        
        <th class="table-web" scope="col">{{ __('Created') }}</th>
       
        <th class="table-web" scope="col">{{ __('Method') }}</th>
        <th scope="col">{{ __('Last status') }}</th>
        @hasrole('admin|driver|chief')
            <th class="table-web" scope="col">{{ __('Client') }}</th>
        @endif
        @hasrole('admin|driver|chief')
            <th class="table-web" scope="col">{{ __('Address') }}</th>
        @endif
        @hasrole('admin|driver|chief')
            <th class="table-web" scope="col">{{ __('Items') }}</th>
        @endif
        @hasrole('admin|chief')
            <th class="table-web" scope="col">{{ __('Driver') }}</th>
        @endif
        <th class="table-web" scope="col">{{ __('Price') }}</th>
     
        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('chief') || auth()->user()->hasRole('driver'))
            <th scope="col">{{ __('Actions') }}</th>
        @endif
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
        <span class="badge badge-primary badge-pill">{{ $order->payment_method }}</span>
    </td>
    <td>
        @include('orders.partials.laststatus')
    </td>
    @hasrole('admin|chief|driver')
    <td class="table-web">
       {{ $order->client->name }}
    </td>
    @endif
    @hasrole('admin|chief|driver')
        <td class="table-web">
            {{ $order->address?$order->address:"" }}
        </td>
    @endif
    @hasrole('admin|chief|driver')
        <td class="table-web">
            {{ count($order->items) }}
        </td>
    @endif
    @hasrole('admin|chief')
        <td class="table-web">
            {{ !empty($order->driver->name) ? $order->driver->name : "" }}
        </td>
    @endif
    <td class="table-web">
        {{$order->order_price}} SP

    </td>
    
    @include('orders.partials.actions.table',['order' => $order ])
</tr>
@endforeach
</tbody>
