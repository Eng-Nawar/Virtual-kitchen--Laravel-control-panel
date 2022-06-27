@extends('layouts.app', ['title' => __('Drivers'), 'activePage' => 'Drivers', 'titlePage' => 'Drivers'])

@section('content')

<div class="content">
    <div class="container-fluid">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Drivers</h4>
            <div class="pull-right">
              <a class="btn btn-success" href="{{ route('drivers.create') }}"> Create New Driver</a>
          </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              @if ($message = Session::get('success'))
    <div class="alert alert-success">
      <p>{{ $message }}</p>
    </div>
    @endif
   
      <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('Email') }}</th>
                                    <th scope="col">{{ __('Acceptance rating') }}</th>
                                    <th scope="col">{{ __('Creation Date') }}</th>
                                    <th scope="col">{{ __('Active') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($drivers as $driver)
                                    <tr>
                                        <td><a href="{{ route('drivers.edit', $driver) }}">{{ $driver->name }}</a></td>
                                        <td>
                                            <a href="mailto:{{ $driver->email }}">{{ $driver->email }}</a>
                                        </td>
                                        <td>
                                            {{ $driver->acceptancerating }}
                                        </td>
                                        <td>
                                            {{ $driver->created_at }}
                                        </td>
                                        <td>
                                           @if($driver->active == 1)
                                                <span class="badge badge-success">{{ __('Active') }}</span>
                                           @else
                                                <span class="badge badge-warning">{{ __('Not active') }}</span>
                                           @endif
                                        </td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <form action="{{ route('drivers.destroy', $driver) }}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                        @if($driver->active == 0)
                                                            <a class="dropdown-item" href="{{ route('driver.activate', $driver) }}">{{ __('Activate') }}</a>
                                                        @else
                                                            <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to deactivate this driver?") }}') ? this.parentElement.submit() : ''">
                                                                {{ __('Deactivate') }}
                                                            </button>
                                                        @endif
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">
                            {{ $drivers->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        
    </div>
</div>
@endsection
