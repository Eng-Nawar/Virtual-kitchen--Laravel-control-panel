@extends('layouts.app', ['title' => __('Expences'), 'activePage' => 'Expences', 'titlePage' => 'Expences'])

@section('content')

<div class="content">
    <div class="container-fluid">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Invoices List</h4>
            <div class="pull-right">
              <a class="btn btn-success" href="{{ route('expences.create') }}"> Add New Invoice</a>
          </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              @if ($message = Session::get('success'))
    <div class="alert alert-success">
      <p>{{ $message }}</p>
    </div>
    @endif

                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                            <tr>
                                <th>Invoice ID </th>
                                <th>Description </th>
                                <th>Amount </th>
                                <th>Date </th>
                                <th>Action</th>
                            </tr>
                            </thead>
                             <tbody>

                             @foreach($invoices as $invoice)
                                 <tr>
                                     <td>{{$invoice->invoices_id}}</td>
                                     <td>{{$invoice->description}}</td>
                                     <td>{{$invoice->amount}}</td>
                                     <td>{{$invoice->created_at->format('Y-m-d')}}</td>
                                     <td>
                                         <a class="btn btn-primary" href="{{route('expences.show', $invoice->invoices_id)}}"><i class="fa fa-bandcamp" ></i></a>
                                         <a class="btn btn-primary" href="{{route('expences.edit', $invoice->invoices_id)}}"><i class="fa fa-edit" ></i></a>

                                         <button class="btn btn-danger waves-effect" type="submit" onclick="deleteTag({{ $invoice->invoices_id }})">
                                             <i class="fa fa-trash-o"></i>
                                         </button>
                                         <form id="delete-form-{{ $invoice->invoices_id }}" action="{{ route('expences.destroy',$invoice->invoices_id) }}" method="POST" style="display: none;">
                                             @csrf
                                             @method('DELETE')
                                         </form>
                                     </td>
                                 </tr>
                             @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>



@endsection

@push('js')
    <script type="text/javascript" src="{{asset('/')}}js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="{{asset('/')}}js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script type="text/javascript">
        function deleteTag(id) {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('delete-form-'+id).submit();
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'Cancelled',
                        'Your data is safe :)',
                        'error'
                    )
                }
            })
        }
    </script>
@endpush
