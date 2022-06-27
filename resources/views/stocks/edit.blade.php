@extends('layouts.app', ['title' => __('Stock edit'),'activePage' => 'Stock edit', 'titlePage' => 'Stock edit'])
@section('content')
@include('assets.partials.header', ['title' => __('Edit stock')])


<div class="card">
    <div class="card-header">
        Stock Information
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('stocks.update', $stock->id) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="asset_id">Asset</label>
                <select class="form-control select2 {{ $errors->has('asset') ? 'is-invalid' : '' }}" name="asset_id" id="asset_id" required>
                    @foreach($assets as $id => $asset)
                        <option value="{{ $asset->id }}" {{ ($stock->asset ? $stock->asset->id : old('asset_id')) == $asset->id ? 'selected' : '' }}>{{ $asset->name }}</option>
                    @endforeach
                </select>
                @if($errors->has('asset'))
                    <div class="invalid-feedback">
                        {{ $errors->first('asset') }}
                    </div>
                @endif
                 </div>
            <div class="form-group">
                <label for="current_stock">Current stock</label>
                <input class="form-control {{ $errors->has('current_stock') ? 'is-invalid' : '' }}" type="number" name="current_stock" id="current_stock" value="{{ old('current_stock', $stock->current_stock) }}" step="1">
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