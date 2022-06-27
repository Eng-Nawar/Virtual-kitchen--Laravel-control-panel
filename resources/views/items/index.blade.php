@extends('layouts.app', ['title' => __(' Menu Management'), 'activePage'=> 'menu', 'titlePage'=> 'Menu'])
@section('title')
    {{__('Menu')}}
@endsection
@section('content')
    @include('items.partials.modals')
    
    <div class="header bg-gradient-primary pb-7 pt-5 pt-md-8">
        <div class="container-fluid">
            <div class="header-body">
            <div class="row align-items-center py-4">
                
                <div class="col-lg-12 col-12 text-right">
                    @if (isset($hasMenuPDf)&&$hasMenuPDf)
                        <a target="_blank" href="{{ route('menupdf.download')}}" class="btn btn-sm btn-danger"><i class="fas fa-file-pdf"></i> {{ __('PDF Menu') }}</a>
                    @endif
                    <button class="btn btn-icon btn-1 btn-sm btn-info" type="button" data-toggle="modal" data-target="#modal-items-category" data-toggle="tooltip" data-placement="top" title="{{ __('Add new category')}}">
                        <span class="btn-inner--icon"><i class="fa fa-plus"></i> {{ __('Add new category') }}</span>
                    </button>
                   
                    @if(config('settings.enable_miltilanguage_menus'))
                        @include('items.partials.languages')
                    @endif
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col">
                                        <h3 class="mb-0" style="color:  #999999">Menu Management @if(config('settings.enable_miltilanguage_menus')) ({{ $currentLanguage}}) @endif</h3>
                                    </div>
                                    <div class="col-auto">
                                        <!--<button class="btn btn-icon btn-1 btn-sm btn-primary" type="button" data-toggle="modal" data-target="#modal-items-category" data-toggle="tooltip" data-placement="top" title="{{ __('Add new category')}}">
                                            <span class="btn-inner--icon"><i class="fa fa-plus"></i> {{ __('Add new category') }}</span>
                                        </button>
                                       
                                        @if(config('settings.enable_miltilanguage_menus'))
                                            @include('items.partials.languages')
                                        @endif-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="col-12">
                        @include('partials.flash')
                    </div>
                    <div class="card-body">
                        @if(count($categories)==0)
                            <div class="col-lg-3" >
                                <a  data-toggle="modal" data-target="#modal-items-category" data-toggle="tooltip" data-placement="top" title="{{ __('Add new category')}}">
                                    <div class="card">
                                        <img class="card-img-top" src="{{ asset('images') }}/default/add_new_item.jpg" alt="...">
                                        <div class="card-body">
                                            <h3 class="card-title text-primary text-uppercase">{{ __('Add first category') }}</h3> 
                                        </div>
                                    </div>
                                </a>
                                <br />
                            </div>
                        @endif
                       
                        @foreach ($categories as $index => $category)
                        @if($category->active == 1)
                        <div class="alert alert-default">
                            <div class="row">
                                <div class="col">
                                    <span class="h1 font-weight-bold mb-0">{{ $category->name }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="row">
                                        <script>
                                            function setSelectedCategoryId(id){
                                                $('#category_id').val(id);
                                            }

                                            

                                        </script>
                                        @if($canAdd)
                                            <button class="btn btn-icon btn-1 btn-sm btn-primary" type="button" data-toggle="modal" data-target="#modal-new-item" data-toggle="tooltip" data-placement="top" title="{{ __('Add item') }} in {{$category->name}}" onClick=(setSelectedCategoryId({{ $category->id }})) >
                                                <span class="btn-inner--icon"><i class="fa fa-plus"></i></span>
                                            </button>
                                        @else
                                            <a href="{{ route('plans.current')}}" class="btn btn-icon btn-1 btn-sm btn-warning" type="button"  >
                                                <span class="btn-inner--icon"><i class="fa fa-plus"></i> {{ __('Menu size limit reaced') }}</span>
                                            </a>
                                        @endif
                                        <button class="btn btn-icon btn-1 btn-sm btn-warning" type="button" id="edit" data-toggle="modal" data-target="#modal-edit-category" data-toggle="tooltip" data-placement="top" title="{{ __('Edit category') }} {{ $category->name }}" data-id="<?= $category->id ?>" data-name="<?= $category->name ?>" >
                                            <span class="btn-inner--icon"><i class="fa fa-edit"></i></span>
                                        </button>

                                       

                                        <form action="{{ route('categories.destroy', $category) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-icon btn-1 btn-sm btn-danger" type="button" onclick="confirm('{{ __("Are you sure you want to delete this category?") }}') ? this.parentElement.submit() : ''" data-toggle="tooltip" data-placement="top" title="{{ __('Delete') }} {{$category->name}}">
                                                <span class="btn-inner--icon"><i class="fa fa-trash"></i></span>
                                            </button>
                                        </form>

                                        @if(count($categories)>1)
                                            <div style="margin-left: 10px; margin-right: 10px">|</div>
                                        @endif

                                         <!-- UP -->
                                         @if ($index!=0)
                                            <a href="{{ route('items.reorder',['up'=>$category->id]) }}"  class="btn btn-icon btn-1 btn-sm btn-success" >
                                                <span class="btn-inner--icon"><i class="fas fa-arrow-up"></i></span>
                                            </a>
                                         @endif
                                         

                                        <!-- DOWN -->
                                        @if ($index+1!=count($categories))
                                            <a href="{{ route('items.reorder',['up'=>$categories[$index+1]->id]) }}" class="btn btn-icon btn-1 btn-sm btn-success">
                                                <span class="btn-inner--icon"><i class="fas fa-arrow-down"></i></span>
                                            </a>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($category->active == 1)
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="row row-grid">
                                    @foreach ( $category->items as $item)
                                        <div class="col-lg-3">
                                            <a href="{{ route('items.edit', $item) }}">
                                                <div class="card">
                                                    <img class="card-img-top" src="{{ asset('/storage/product/'.$item->image) }}" alt="{{ $item->image }}">
                                                    <div class="card-body">
                                                        <h3 class="card-title text-primary text-uppercase">{{ $item->name }}</h3>
                                                        <p class="card-text description mt-3">{{ $item->description }}</p>

                                                        <span class="badge badge-primary badge-pill">{{$item->price  }}</span>

                                                        <p class="mt-3 mb-0 text-sm">
                                                            @if($item->available == 1)
                                                            <span class="text-success mr-2">{{ __("AVAILABLE") }}</span>
                                                            @else
                                                            <span class="text-danger mr-2">{{ __("UNAVAILABLE") }}</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                                <br/>
                                            </a>
                                        </div>
                                    @endforeach
                                    @if($canAdd)
                                    <div class="col-lg-3" >
                                        <a   data-toggle="modal" data-target="#modal-new-item" data-toggle="tooltip" data-placement="top" href="javascript:void(0);" onclick=(setSelectedCategoryId({{ $category->id }}))>
                                            <div class="card">
                                                <img class="card-img-top" src="{{ asset('images') }}/default/add_new_item.jpg" alt="...">
                                                <div class="card-body">
                                                    <h3 class="card-title text-primary text-uppercase">{{ __('Add item') }}</h3>
                                                </div>
                                            </div>
                                        </a>
                                        <br />
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
  $("[data-target='#modal-edit-category']").click(function() {
    var id = $(this).attr('data-id');
    var name = $(this).attr('data-name');


    //$('#cat_id').val(id);
    $('#cat_name').val(name);
    $("#form-edit-category").attr("action", "/categories/"+id);
})
</script>
@endsection