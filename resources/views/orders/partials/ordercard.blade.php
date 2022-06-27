<div class="card shadow">
    <div class="card-header border-0">
        @if(count($orders))
        <form method="GET">
            
            <br/>
            <div class="tab-content orders-filters">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-daterange datepicker row align-items-center">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">{{ __('Date From') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                            </div>
                                            <input name="fromDate" class="form-control" placeholder="{{ __('Date from') }}" type="text" <?php if(isset($_GET['fromDate'])){echo 'value="'.$_GET['fromDate'].'"';} ?> >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">{{ __('Date to') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                            </div>
                                            <input name="toDate" class="form-control" placeholder="{{ __('Date to') }}" type="text"  <?php if(isset($_GET['toDate'])){echo 'value="'.$_GET['toDate'].'"';} ?>>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                        @if (config('app.isft'))
                        @hasrole('admin|chief')
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-control-label" for="client">{{ __('Filter by Client') }}</label>

                                <select class="form-control select2" id="blabla" name="client_id">
                                    <option disabled selected value> -- {{ __('Select an option') }} -- </option>
                                    @foreach ($clients as $client)
                                        <option  <?php if(isset($_GET['client_id'])&&$_GET['client_id'].""==$client->id.""){echo "selected";} ?>  value="{{ $client->id }}">{{$client->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif
                        @hasrole('admin|chief')
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-control-label" for="driver">{{ __('Filter by Driver') }}</label>
                                <select class="form-control select2" name="driver_id">
                                    <option disabled selected value> -- {{ __('Select an option') }} -- </option>
                                    @foreach ($drivers as $driver)
                                        <option <?php if(isset($_GET['driver_id'])&&$_GET['driver_id'].""==$driver->id.""){echo "selected";} ?>   value="{{ $driver->id }}">{{$driver->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif    
                        @else
                        @endif
                        
                    </div>

                        <div class="col-md-6 offset-md-6">
                            <div class="row">
                                @if ($parameters)
                                    <div class="col-md-4">
                                        <a href="{{ Request::url() }}" class="btn btn-md btn-block">{{ __('Clear Filters') }}</a>
                                    </div>
                                    <div class="col-md-4">
                                    <a href="{{Request::fullUrl()."&report=true" }}" class="btn btn-md btn-success btn-block">{{ __('Download report') }}</a>
                                    </div>
                                @else
                                    <div class="col-md-8"></div>
                                @endif

                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary btn-md btn-block">{{ __('Filter') }}</button>
                                </div>
                        </div>
                    </div>
             </div>
        </form>
        @endif
    </div>
    <div class="col-12">
        @include('partials.flash')
    </div>
    @if(count($orders))
    <div class="table-responsive">
        <table class="table align-items-center">
            @if (isset($financialReport))
                @include('finances.financialdisplay')
            @elseif (config('app.isqrsaas'))
                @include('orders.partials.orderdisplay_local')
            @else
                @include('orders.partials.orderdisplay')
            @endif
        </table>
    </div>
    @endif
    <div class="card-footer py-4">
        @if(count($orders))
        <nav class="d-flex justify-content-end" aria-label="...">
          <?php //  {{ $orders->appends(Request::all())->links() }}?>
        </nav>
        @else
            <h4>{{ __('You don`t have any orders') }} ...</h4>
        @endif
    </div>
</div>