@extends('layouts.app', ['title' => __('stock info'),'activePage' => 'stock info', 'titlePage' => 'stock info'])
@section('content')
@include('assets.partials.header', ['title' => __('View stock')])

<div class="card">
    <div class="card-header">
        Stock Information
    </div>

    <div class="card-body">
        <div class="form-group" >
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('stocks.index') }}">
                    Back to list
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            ID
                        </th>
                        <td>
                            {{ $stock->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Asset
                        </th>
                        <td>
                            {{ $stock->asset->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            current stock
                        </th>
                        <td>
                            {{ $stock->current_stock }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <h4 class="text-center">
                History of {{ $stock->asset->name }}
                @if(count($stock->asset->transactions) == 0)
                    is empty
                @endif
            </h4>
            @if(count($stock->asset->transactions) > 0)
            <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="w-75">User</th>
                            <th>Amount</th>
                        </tr>
                        @foreach($stock->asset->transactions as $transaction)
                            <tr>
                                <td>
                                    {{ $transaction->user->name }}
                                    ({{ $transaction->user->email }})
                                    
                                </td>
                                <td>{{ $transaction->stock }}</td>
                            </tr>
                        @endforeach
                    </thead>
                </table>
            @endif
           
        </div>
    </div>
</div>



@endsection
