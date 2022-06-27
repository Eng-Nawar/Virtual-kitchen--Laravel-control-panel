@extends('layouts.app', ['title' => __('Assets'), 'activePage' => 'Assets', 'titlePage' => 'Assets'])

@section('content')

<div class="content">
    <div class="container-fluid">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Asset List</h4>
            <div class="pull-right">
              <a class="btn btn-success" href="{{ route('assets.create') }}"> Add New Asset</a>
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
                                    <th scope="col">{{ __('ID') }}</th>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('Description') }}</th>
                                  
                                    <th scope="col">{{ __('Actions') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assets as $key => $asset)
                                    <tr>
                                        <td>{{ $asset->id }}</td>
                                        <td style="width: 20%">
                                            {{ $asset->name }}
                                        </td>
                                        <td style="width: 30%">
                                            {{ $asset->description }}
                                        </td>
                                       
                                        <td>
                                           
                                            <a class="btn btn-xs btn-primary" href="{{ route('assets.show', $asset->id) }}">
                                                view
                                            </a>
                                       
        
                                       
                                            <a class="btn btn-xs btn-info" href="{{ route('assets.edit', $asset->id) }}">
                                                edit
                                            </a>
                                      
        
                                       
                                            <form action="{{ route('assets.destroy', $asset->id) }}" method="POST" onsubmit="return confirm('AreYouSure');" style="display: inline-block;">
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
        </div>

        
    </div>
</div>
    @endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('asset_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.assets.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-Asset:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
