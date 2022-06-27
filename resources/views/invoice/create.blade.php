@extends('layouts.app', ['title' => __('Invoice create'),'activePage' => 'Invoice create', 'titlePage' => 'Invoice create'])
@section('content')
@include('assets.partials.header', ['title' => __('Add Invoice')])

<div class="card">
    <div class="card-header">
        Invoice Information
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('expences.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="amount">Invoice Amount</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" name="amount" id="amount" value="" required>
                @if($errors->has('amount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('amount') }}
                    </div>
                @endif
              </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description') }}</textarea>
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


