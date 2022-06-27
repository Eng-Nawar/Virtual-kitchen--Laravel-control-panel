@extends('layouts.app', ['title' => __('Clients'), 'activePage'=> 'Clients', 'titlePage'=> 'Clients'])

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Clients</h4>
            
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
                                    <th scope="col">{{ __('Owner') }}</th>
                                    <th scope="col">{{ __('Owner email') }}</th>
                                    <th scope="col">{{ __('Creation Date') }}</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $client)
                                    <tr>
                                        <td>{{ $client->name }}</td>
                                        <td>{{ $client->name }}</td>
                                        <td>{{ $client->email }}</td>
                                        <td>{{ $client->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">
                            {{ $clients->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        
    </div>
</div>
@endsection
