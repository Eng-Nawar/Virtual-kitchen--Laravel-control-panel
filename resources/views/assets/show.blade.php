@extends('layouts.app', ['title' => __('Asset show'),'activePage' => 'Asset show', 'titlePage' => 'Asset show'])
@section('content')
@include('assets.partials.header', ['title' => __('')])
<div class="card">
    <div class="card-header">
        Asset Information
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group" >
                <a class="btn btn-default" href="{{ route('assets.index') }}">
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
                            {{ $asset->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Name
                        </th>
                        <td>
                            {{ $asset->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Description
                        </th>
                        <td>
                            {{ $asset->description }}
                        </td>
                    </tr>
                   
                </tbody>
            </table>
            
        </div>
    </div>
</div>



@endsection
