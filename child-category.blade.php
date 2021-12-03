@if(!empty($category->subcategory))
    <ol class="dd-list list-group">
        @foreach($category->subcategory as $kk => $sub_category)
            <li class="dd-item list-group-item" data-id="{{ $sub_category['id'] }}" >
                <div class='d-flex justify-content-between align-items-center'>
                    <div class="dd-handle" >{{ $sub_category['name'] }}</div>
                    <div class="dd-option-handle">
                        <button class="btn mb-1 btn-sm btn-info" @click='edit({{$sub_category["id"]}},"{{$sub_category->name}}")' data-toggle="modal" data-target="#modaleditCategory">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        </button>
                        <button @click='add( {{ $sub_category["id"]}},{{count($sub_category->subcategory)+1}} )'  data-toggle="modal" data-target="#modalCategory"  class="btn mb-1 btn-drak btn-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>    
                                            </button>
                        <form action="{{route('admin.categories.destroy',$sub_category['id'])}}" method="post" style="display:inline;">
                            @csrf
                            @method('Delete')
                            <button type="submit" class="btn-sm btn mb-1 btn-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                            </button>
                        </form>
                    </div>
                </div>
                

                @include('layouts.partials.components.child-category', [ 'category' => $sub_category])
            </li>
        @endforeach
    </ol> 
@endif