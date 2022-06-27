@extends('layouts.app', ['title' => __(' Stock Management'), 'activePage'=> 'Stock Management', 'titlePage'=> 'Stock Management'])

@section('content')

<div class="content">
    <div class="container-fluid">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Stock List</h4>
            <div class="pull-right">
              <a class="btn btn-success" href="{{ route('stocks.create') }}"> Add New Stock</a>
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
                        <th>
                            Asset
                        </th>
                       
                       
                        <th>
                            current_stock
                        </th>
                        
                            <th>
                                Add Stock
                            </th>
                            <th>
                                Remove Stock
                            </th>
                        
                        <th>
                           Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stocks as $key => $stock)
                        <tr>
                            <td>
                                {{ $stock->asset->name ?? '' }}
                            </td>
                        
                               
                        
                            <td>
                                {{ $stock->current_stock ?? '' }}
                            </td>
                            
                                <td>
                                    <form action="{{ route('transactions.storeStock', $stock->id) }}" method="POST" style="display: inline-block;" class="form-inline">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="action" value="add">
                                        <input type="number" name="stock" class="form-control form-control-sm col-4" min="1">
                                        <input type="submit" class="btn btn-xs btn-danger" value="ADD">
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('transactions.storeStock', $stock->id) }}" method="POST" style="display: inline-block;" class="form-inline">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="action" value="remove">
                                        <input type="number" name="stock" class="form-control form-control-sm col-4" min="1">
                                        <input type="submit" class="btn btn-xs btn-danger" value="REMOVE">
                                    </form>
                                </td>
                    
                            <td>
                              
                                    <a class="btn btn-xs btn-primary" href="{{ route('stocks.show', $stock->id) }}">
                                        view
                                    </a>
                                    <a class="btn btn-xs btn-info" href="{{ route('stocks.edit', $stock->id) }}">
                                        edit
                                    </a>
                                    <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST" onsubmit="return confirm('AreYouSure');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="delete">
                                    </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
      columnDefs: [{
          orderable: true,
          className: '',
          targets: 0
      }]
  });
  $('.datatable-Stock:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
