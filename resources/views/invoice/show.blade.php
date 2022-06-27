@extends('layouts.app', ['title' => __('Invoice show'),'activePage' => 'Invoice show', 'titlePage' => 'Invoice show'])
@section('content')
@include('assets.partials.header', ['title' => __('')])
<div class="card">
    <div class="card-header">
        Invoice Information
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group" >
                <a class="btn btn-default" href="{{ route('expences.index') }}">
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
                            {{ $invoice->invoices_id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Amount
                        </th>
                        <td>
                            {{ $invoice->amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Description
                        </th>
                        <td>
                            {{ $invoice->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Date
                        </th>
                        <td>
                            {{ $invoice->created_at->format('Y-m-d') }}
                        </td>
                    </tr>
                </tbody>
            </table>
            
        </div>
    </div>
</div>



@endsection



                  