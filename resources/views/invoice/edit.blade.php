@extends('layouts.app', ['title' => __('Invoice edit'),'activePage' => 'Invoice edit', 'titlePage' => 'Invoice edit'])
@section('content')
@include('assets.partials.header', ['title' => __('')])
<div class="card">
    <div class="card-header">
        Invoice Information
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('expences.update', $invoice->invoices_id) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">Amount</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" name="amount" id="amount" value="{{ old('amount', $invoice->amount) }}" required>
                @if($errors->has('amount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('amount') }}
                    </div>
                @endif
               </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description', $invoice->description) }}</textarea>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
              </div>
           
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                  Save
                </button>
            </div>
        </form>
    </div>
</div>



@endsection
