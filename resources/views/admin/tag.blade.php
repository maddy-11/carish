@extends('admin.layouts.app')

@section('content')

<!-- <div class="row mb-3">
  <div class="col-md-8 title-col">
    <h3 class="maintitle text-uppercase fontbold">Tags</h3>
  </div>
 
</div> -->

<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Tags</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
      <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" style="float: right">Add Tag</button>
  </div>

</div>

@if(session()->has('message'))
    <div class="alert alert-success  alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
        {{ session()->get('message') }}
    </div>
@endif


<div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1">{{ __('home.tags') }}</h5>
      </div>
      <div class="table-responsive">
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
              <tr>
                <th>Action</th>
                <th>Sr No.</th>
                <th>Name</th>
                <th>Code</th>
                <th>Suggestion</th>
                <th>Average Fuel</th>
              </tr>
          </thead>
          <tbody> 
            @foreach($tags as $tag)
              @php  
              $tagDescription = $tag->tagsDescription()->where('language_id', 2)->first();
              @endphp
                    <tr id="tag_id_{{$tag->id}}">
                      <td style="color: white;">
                        <a class="actionicon bg-info editaction text-center" title="edit" data-toggle="modal" data-target="#editmodal{{$tag->id}}"><i class="fa fa-pencil"></i></a>
                        <a class="actionicon bg-danger deleteaction delete-btn text-center" title="Delete" data-id = "{{$tag->id}}"><i class="fa fa-close"></i></a>                          
                      </td>
                      <td>{{$loop->iteration }}</td>
                      <td>{{@$tagDescription->name}}</td>
                      <td>{{@$tagDescription->code}}</td>
                      <td>{{@$tag->suggessions !== null ? @$tag->suggessions->suggesstion_descriptions()->where('language_id',2)->pluck('sentence')->first() : '--'}}</td>
                      <td>{{@$tag->average_fuel}}</td>
                    </tr>
                @endforeach
            
            </td>
          </tbody>
      </table>
    </div>
   </div>
  </div>

</div>
  

<!-- <div style="margin-top: 40px">
            <table id="myTable" class="table" >
                <thead>

                <tr>
                    <th>Sr No.</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Action</th>

                </tr>
                </thead>
                <tbody>
               @foreach($tags as $tag)
                    <tr id="tag_id_{{$tag->id}}">
                      <td>{{$loop->iteration }}</td>
                      <td>{{$tag->name}}</td>
                      <td>{{$tag->code}}</td>
                      <td>
                      	<button class="btn btn-success" title="edit" data-toggle="modal" data-target="#editmodal{{$tag->id}}"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-danger delete-btn" title="Delete" data-id = "{{$tag->id}}"><i class="fa fa-trash"></i></button>                        	
                      </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
</div>  -->   

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
         
          <h4 class="modal-title">Add Tag</h4>
        </div>
        <div class="modal-body">
        

        <div class="col-md-">
           
            <form action="{{url('add/tag')}}" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
              <ul class="nav nav-tabs" role="tablist">
              @foreach($languages as $language)
              <li class="nav-item">
                <a class="nav-link @if($loop->iteration == 1) active @endif" data-toggle="tab" href="#{{$language->language_code }}" role="tab">{{$language->language_title}}</a>
              </li> 
              @endforeach

            </ul>

            <!-- Tab panes -->
            <div class="tab-content"> 
                @foreach($languages as $language)
                <div class="tab-pane @if($loop->iteration == 1) active @endif" id="{{$language->language_code }}" role="tabpanel">
                <div class="form-group">
                    <label for="name">Tag Details In {{$language->language_title}}:</label>
                    <input required type="text" name="name[{{$language->id}}]" class="form-control" placeholder="Tag Details" >
                    <label for="name">Tag Code In {{$language->language_title}}:</label>
                    <input required type="text" name="code[{{$language->id}}]" class="form-control"  placeholder="Tag Code" >
                </div> 
              </div> 
                @endforeach
            </div>

              <div class="form-group">
                  <label for="name">Show In Suggession:</label>
                  <select name="suggesstion_id" id="suggesstion_id" class="form-control">
                    <option value="">Select Suggession</option>
                    @foreach($suggessions as $suggession)
                    <option value="{{$suggession->suggesstion_id}}">{{$suggession->title}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="name">Average Fuel:</label>
                  <input type="number" pattern="\d*" name="average_fuel" class="form-control" >
                </div>

                {{-- <div class="form-group">
                  <label for="name">Models:</label>
                  <select name="model_id" id="model_id" class="form-control">
                    <option value="">Select Model</option> 
                  </select>
                </div> 
                
                <div class="form-group">
                  <label for="name">Mileage Total:</label>
                <input type="number" pattern="\d*" name="mileage_total" class="form-control" >
                </div>
                <div class="form-group">
                  <label for="name">Mileage Per Year:</label>
                  <input type="number" pattern="\d*" name="mileage_per_year" class="form-control" >
                </div> --}}
                




        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           <button type="submit" class="btn" style="color: white; background-color: #5a386b">Add Tag</button>
            
        </div>
        </form>
      </div>
      
    </div>
  </div>
  
</div>


@foreach($tags as $tag) 
<div class="modal fade" id="editmodal{{$tag->id}}" role="dialog">
  <div class="modal-dialog">    
      <!-- Modal content-->
  <form action="{{url('edit/tags')}}" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">          
          <h4 class="modal-title">Edit Tag</h4>
         
        </div>
        <div class="modal-body">        
          <input type="hidden" name="id" value="{{$tag->id}}">
            {{csrf_field()}}
         <div class="col-md-">
           <!--  <h1 style="color: #5a386b">Edit Tag</h1>      -->      
                
           {{--   @if(empty($tag->tagsDescription))
             @foreach($tag->tagsDescription as $descrip) --}}
            {{-- <div class="form-group">
                    <label for="name">Tag Detail:</label>
                    <input required type="text" name="name[]" class="form-control" value="{{$tag->name}}" >
              <br/>
                    <label for="name">Code:</label>
                    <input required type="text" name="code[]" class="form-control" value="{{$tag->code}}" >
                </div> --}}
                <ul class="nav nav-tabs" role="tablist">
              @foreach($languages as $language)
              <li class="nav-item">
                <a class="nav-link @if($loop->iteration == 1) active @endif" data-toggle="tab" href="#{{$language->language_code}}{{$tag->id}}" role="tab">{{$language->language_title}}</a>
              </li> 
              @endforeach

            </ul>

            <!-- Tab panes -->
            <div class="tab-content"> 
                @foreach($languages as $language)
                <div class="tab-pane @if($loop->iteration == 1) active @endif" id="{{$language->language_code}}{{$tag->id}}" role="tabpanel">
                <div class="form-group">
                    <label for="name_{{$language->language_code}}">Tag Details In {{$language->language_title}}:</label>
                    <input required type="text" name="name_{{$language->language_code}}" class="form-control" placeholder="Tag Details" value="{{
                      $tag->tagsDescription()->where('language_id',$language->id)->pluck('name')->first()
                    }}">
                    <label for="code_{{$language->language_code}}">Tag Code In {{$language->language_title}}:</label>
                    <input required type="text" name="code_{{$language->language_code}}" class="form-control"  placeholder="Tag Code" value="{{
                      $tag->tagsDescription()->where('language_id',$language->id)->pluck('code')->first()
                    }}">
                </div> 
              </div> 
                @endforeach
            </div>
        </div>
      {{--   @endforeach
        @endif --}}

                <div class="form-group">
                  <label for="name">Makes:</label>
                  <select name="make_id" id="edit_make_id" class="form-control">
                    <option value="">Select Make</option>
                    @foreach($makes as $make)
                    <option @if($tag->make_id == $make->id) selected @endif value="{{$make->id}}">{{$make->title}}</option>
                    @endforeach
                  </select>
                </div>

                <div class="form-group">
                  <label for="name">Models:</label>
                  <select name="model_id" id="edit_model_id" class="form-control">
                    <option value="">Select Model</option> 
                  </select>
                </div>

                <div class="form-group">
                  <label for="name">Show In Suggession:</label>
                  <select name="suggesstion_id" id="suggesstion_id" class="form-control">
                    <option value="">Select Suggession</option>
                    @foreach($suggessions as $suggession)
                    <option value="{{$suggession->suggesstion_id}}" {{$tag->suggesstion_id == $suggession->suggesstion_id ? 'selected' : ''}}>{{$suggession->title}}</option>
                    @endforeach
                  </select>
                </div>

          <div class="form-group">
                    <label for="name">Average Fuel:</label>
                    <input type="number" pattern="\d*" name="average_fuel" class="form-control" value="{{$tag->average_fuel}}" >
                </div>
                  <div class="form-group">
                    <label for="name">Mileage Total:</label>
                    <input type="number" pattern="\d*" name="mileage_total" class="form-control" value="{{$tag->mileage_total}}">
                </div>
                  <div class="form-group">
                    <label for="name">Mileage Per Year:</label>
                    <input type="number" pattern="\d*" name="mileage_per_year" class="form-control" value="{{$tag->mileage_per_year}}">
                </div>
   
        </div>
        <div class="modal-footer">
        	 <button type="submit" class="btn" style="color: white; background-color: #5a386b">Edit Tag</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
  </form>     
  </div>
</div>
@endforeach

  @push('custom-scripts')
  <script>
      $('#myTable').DataTable({
          searching: false
      });

      @if(Session::has('message'))
        toastr.success('Success!',"{{Session::get('message')}}" ,{"positionClass": "toast-bottom-right"});
      @endif

      $(function(e){
      $(document).on('change', '#make_id', function(){
        var id = this.value;
            $.ajax({
                method:"get",
                dataType:"text",
                data:{id:id},
                url:"{{ route('get.make.models') }}",
                success:function(data){
                  console.log(data);
                    $("#model_id").append(data);
                }
             });

      });

      $(document).on('click', '.delete-btn', function(){
      var id = $(this).data('id');
      swal({
          title: "Alert!",
          text: "Are you sure you want to Delete this Tag?",
          type: "info",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes!",
          cancelButtonText: "No!",
          closeOnConfirm: true,
          closeOnCancel: true
       },
         function(isConfirm) {
           if (isConfirm){
             $.ajax({
                method:"get",
                dataType:"json",
                data:{id:id},
                url:"{{ route('delete-tag') }}",
                
                success:function(data){
                    if(data.success == true){
                     $("#tag_id_"+id).remove();
                      toastr.success('Success!', data.message ,{"positionClass": "toast-bottom-right"});
                    }
                }
             });
          } 
          else{
              swal("Cancelled", "", "error");
          }
       
    });
   });
   });
  </script>
  @endpush

@endsection