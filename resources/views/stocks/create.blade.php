@extends('layouts.app', ['title' => __('stock create'),'activePage' => 'stock create', 'titlePage' => 'stock create'])
@section('content')
@include('assets.partials.header', ['title' => __('Add stock')])


<div class="card">
    <div class="card-header">
       Stock information
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('stocks.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="asset_id">Asset</label>
                <select class="form-control  " name="asset_id" id="asset_id" required>
                    @foreach($assets as $id => $asset)
                    <option value="" disabled selected hidden >Please select</option>
                     
                    <option value="{{ $asset->id }}" {{ old('asset_id') == $asset->id ? 'selected' : '' }}>{{ $asset->name }}</option>
                    @endforeach
                </select>
                @if($errors->has('asset'))
                    <div class="invalid-feedback">
                        {{ $errors->first('asset') }}
                    </div>
                @endif
                </div>
            <div class="form-group">
                <label for="current_stock">current stock</label>
                <input class="form-control {{ $errors->has('current_stock') ? 'is-invalid' : '' }}" type="number" name="current_stock" id="current_stock" value="{{ old('current_stock', '') }}" step="1">
                @if($errors->has('current_stock'))
                    <div class="invalid-feedback">
                        {{ $errors->first('current_stock') }}
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