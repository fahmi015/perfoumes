@extends('layouts.main')
@section('styles')
    <style>
        .dataTables_filter label{
            width: 100% !important;
        }
        div.dataTables_wrapper div.dataTables_filter input {
            width: 100% !important;
        }
    </style>
    {{--    <link href="//cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">--}}
    <link rel="stylesheet" type="text/css" href="{{url('')}}/dashboard/plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="{{url('')}}/dashboard/plugins/table/datatable/dt-global_style.css">
    <link rel="stylesheet" href="{{url('')}}/dashboard/assets/css/style.css">
@endsection

@section('content')
<div id='main_app'>
<div class="row layout-top-spacing">
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-content widget-content-area br-6 ">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12 d-flex justify-content-between align-items-center">
                        <h4>{{__('Categories')}}</h4>
                        <div class="pull-right">
                            <button class="btn btn-success" @click='add(0,1)'  data-toggle="modal" data-target="#modalCategory"> {{__('New Category')}}</button>
                        </div>
                    </div>
                    
                </div>

                <div class="row mb-4 mt-4" >
                    @if(count($categories)>0)
                    <div class="col-md-12 dd" id="nestable-wrapper">
                       
                        <ol class="dd-list list-group" id='nestable_add'>
                            @foreach($categories as $k => $category)
                                <li class="dd-item list-group-item" data-id="{{ $category['id'] }}" >
                                    <div class='d-flex justify-content-between align-items-center'>
                                        <div class="dd-handle" >{{ $category['name'] }}</div>
                                        <div class="dd-option-handle">
                                            <button class="btn mb-1 btn-sm btn-info" @click='edit({{$category["id"]}},"{{$category->name}}")' data-toggle="modal" data-target="#modaleditCategory">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                            </button>
                                            <button @click='add({{$category["id"]}},{{count($category->subcategory)+1}})'  data-toggle="modal" data-target="#modalCategory"  class="btn mb-1 btn-drak btn-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>    
                                            </button>
                                            <form action="{{route('admin.categories.destroy',$category->id)}}" method="post" style="display:inline;">
                                                @csrf
                                                @method('Delete')
                                                <button type="submit" class="btn  mb-1 btn-danger btn-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                                </button>
                                            </form>

                                            
                                        </div>
                                    </div>

                                    @if(!empty($category->subcategory))
                                        @include('layouts.partials.components.child-category', [ 'category' => $category])
                                    @endif
                                </li>
                            @endforeach
                        </ol>
                    </div>
                    <div class='col-md-12'>
                    <form action="{{ route('admin.categories.save') }}" method="post">
                        @csrf
                        <textarea style="display: none;" name="nested_category_array" id="nestable-output"></textarea>
                        <button type="submit" class="btn btn-primary d-flex" style="margin-top: 15px;">Save category <span id='save_category' class='mx-2 d-none'><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg></span></button>
                    </form>
                    </div>
                    @else
                    <div class='col-md-12'>    
                        <div class='alert alert-info'>
                            {{__('There are no categories at the moment')}}
                        </div>
                    </div>

                    @endif
                    
                    
                </div>
               
                
            </div>

        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{__('Add Category')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('admin.categories.store')}}" method="POST">
      <div class="modal-body">
        <div class="row" >
            @csrf        
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="name">{{__('name')}}:</label>
                    <input type="text" v-model="name"  placeholder="{{__('name')}}" class="form-control @error('name') is-invalid @enderror" name="name" id="name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="name">{{__('slug')}}:</label>
                    <input type="text" v-model="slug"  placeholder="{{__('slug')}}" class="form-control @error('slug') is-invalid @enderror" name="slug" id="slug">
                </div>
            </div>

            <input type="hidden"  name="parent_id" v-model="parent_id">                        
            <input type="hidden"  name="sort_order" v-model='sort_order'> 
        </div>
      
                
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"> {{__('Close')}}</button>
        <button type="submit" class="btn btn-primary">{{__('Submit')}} </button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modaleditCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{__('Update Category')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form :action="action_update" method="POST">
          @method('PUT')
      <div class="modal-body">
        <div class="row" >
            @csrf        
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="name">{{__('name')}}:</label>
                    <input type="text" v-model="name"  placeholder="{{__('name')}}" class="form-control @error('name') is-invalid @enderror" name="name" id="name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="name">{{__('slug')}}:</label>
                    <input type="text" v-model="slug"  placeholder="{{__('slug')}}" class="form-control @error('slug') is-invalid @enderror" name="slug" id="slug">
                </div>
            </div>
        </div>
      
                
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"> {{__('Close')}}</button>
        <button type="submit" class="btn btn-primary">{{__('Update')}} </button>
      </div>
      </form>
    </div>
  </div>
</div>


</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>

<script src="{{url('')}}/dashboard/assets/js/jquery.nestable.js"></script>

<script src="{{url('')}}/dashboard/assets/js/style.js"></script>

<script>

var app= new Vue({
        el: '#main_app',
        data: {
            id:null,
            parent_id: null,
            sort_order: null,
            name: '',
        },
        computed: {
            slug: function() {
            var slug = this.sanitizeTitle(this.name);
            return slug;
            },
            action_update:function(){
                var url='{{route("admin.categories.update",":this.id") }}';
                
                return url.replace(':this.id', this.id);
            }
        },
        methods: {
            add(parent_id,sort_order){
                this.parent_id=parent_id;
                this.sort_order=sort_order;
                console.log(this.sort_order);
            },
            edit(id,name){
                this.id=id;
                this.name=name;
                console.log(this.name);console.log(this.id);
            },
            sanitizeTitle: function(title) {
                var slug = "";
                // Change to lower case
                var titleLower = title.toLowerCase();
                // Letter "e"
                slug = title.replace(/e|é|è|ẽ|ẻ|ẹ|ê|ế|ề|ễ|ể|ệ/gi, 'e');
                // Letter "a"
                slug = slug.replace(/a|á|à|ã|ả|ạ|ă|ắ|ằ|ẵ|ẳ|ặ|â|ấ|ầ|ẫ|ẩ|ậ/gi, 'a');
                // Letter "o"
                slug = slug.replace(/o|ó|ò|õ|ỏ|ọ|ô|ố|ồ|ỗ|ổ|ộ|ơ|ớ|ờ|ỡ|ở|ợ/gi, 'o');
                // Letter "u"
                slug = slug.replace(/u|ú|ù|ũ|ủ|ụ|ư|ứ|ừ|ữ|ử|ự/gi, 'u');
                // Letter "d"
                slug = slug.replace(/đ/gi, 'd');
                // Trim the last whitespace
                slug = slug.replace(/\s*$/g, '');
                // Change whitespace to "-"
                slug = slug.replace(/\s+/g, '-');
                slug = slug.toLowerCase();
                return slug;
            },
        
            
        }
    })




</script>

@endsection