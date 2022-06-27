@extends('layouts.app', ['title' => __('Asset create'),'activePage' => 'Asset create', 'titlePage' => 'Asset create'])
@section('content')
@include('assets.partials.header', ['title' => __('Add Asset')])

<div class="card">
    <div class="card-header">
        Asset Information
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('assets.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">Asset Name</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
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
