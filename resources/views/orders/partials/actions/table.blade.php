<?php
$lastStatusAlisas=$order->status->pluck('alias')->last();
?>
@if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('chief') || auth()->user()->hasRole('driver'))
    @if(auth()->user()->hasRole('admin'))
    <script>
        function setSelectedOrderId(id){
            $("#form-assing-driver").attr("action", "updatestatus/assigned_to_driver/"+id);
        }
    </script>
    <td>
        @if($lastStatusAlisas == "just_created")
            <a href="{{'updatestatus/accepted_by_admin/'.$order->id }}" class="btn btn-success btn-sm order-action">{{ __('Accept') }}</a>
            <a href="{{'updatestatus/rejected_by_admin/'.$order->id }}" class="btn btn-danger btn-sm order-action">{{ __('Reject') }}</a>
        @elseif(($lastStatusAlisas == "accepted_by_restaurant"||$lastStatusAlisas == "rejected_by_driver")&&$order->delivery_method.""!="2")
            <button type="button" class="btn btn-primary btn-sm order-action" onClick=(setSelectedOrderId({{ $order->id }}))  data-toggle="modal" data-target="#modal-asign-driver">{{ __('Assign to driver') }}</a>
        @elseif($lastStatusAlisas == "prepared"&&$order->driver==null)
            <button type="button" class="btn btn-primary btn-sm order-action" onClick=(setSelectedOrderId({{ $order->id }}))  data-toggle="modal" data-target="#modal-asign-driver">{{ __('Assign to driver') }}</a>
        @else
            <small>{{ __('No actions for you right now!') }}</small>
        @endif
    </td>
    @endif
    @if(auth()->user()->hasRole('chief'))
   <td>
    @if($lastStatusAlisas == "accepted_by_admin")
        <a href="{{ url('updatestatus/accepted_by_restaurant/'.$order->id) }}" class="btn btn-primary">{{ __('Accept') }}</a>
        <a href="{{ url('updatestatus/rejected_by_restaurant/'.$order->id) }}" class="btn btn-danger">{{ __('Reject') }}</a>
    
    @elseif($lastStatusAlisas == "accepted_by_driver"&&$order->delivery_method.""!="2")
    <a href="{{ url('updatestatus/prepared/'.$order->id) }}" class="btn btn-primary">{{ __('Prepared') }}</a>
   
        @else
        <p>{{ __('No actions for you right now!') }}</p>
     @endif
   </td>
    @endif

    @if(auth()->user()->hasRole('driver'))
   <td>
      @if($lastStatusAlisas == "assigned_to_driver")
        <a href="{{ url('updatestatus/accepted_by_driver/'.$order->id) }}" class="btn btn-primary">{{ __('Accept') }}</a>
        <a href="{{ url('updatestatus/rejected_by_driver/'.$order->id) }}" class="btn btn-danger">{{ __('Reject') }}</a>
    
      @elseif($lastStatusAlisas == "prepared"&&$order->delivery_method.""!="2")
      <a href="{{ url('updatestatus/picked_up/'.$order->id) }}" class="btn btn-primary">{{ __('Picked up') }}</a>
      @elseif($lastStatusAlisas == "picked_up"&&$order->delivery_method.""!="2")
      <a href="{{ url('updatestatus/delivered/'.$order->id) }}" class="btn btn-primary">{{ __('delivered') }}</a>
    
      @else
        <p>{{ __('No actions for you right now!') }}</p>
     @endif
   </td>
    @endif

@endif
