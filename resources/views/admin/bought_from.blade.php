@extends('admin.layouts.app')
@section('content')
<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">
   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Bought From</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
      <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" style="float: right">Add 
      Bought From</button>
  </div>
</div>
<div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1">Bought From</h5>
      </div>
      <div class="table-responsive">
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
              <tr>
                <th>Action</th>
                <th>Name</th>
                <th>Code</th>
                <th>Slug</th>
                <th>Status</th>
              </tr>
          </thead>
          <tbody> 
            @foreach($boughtfrom as $bought)
                    <tr>
                      <td>
                        <div class="d-flex text-center">
                        <a data-toggle="modal" href='#editModal' class="actionicon bg-info editaction" data-target="#editmodal{{$bought->bought_from_id}}" data-id="{{$bought->bought_from_id}}"><i class="fa fa-pencil"></i></a> 
                        <a  class="actionicon bg-danger deleteaction delete-btn"  href="{{route('delete-bought-from',['id'=>$bought->bought_from_id])}}" ><i class="fa fa-close" onclick="return confirm('Are you sure you want to delete the record {{ $bought->title }}{{ $bought->code }} ?')"></i></a>
                        </div>                        
                      </td>
                      <td>{{$bought->title}}</td>
                      <td>{{$bought->code}}</td>
                      <td>{{$bought->slug}}</td>
                      <td>
                      @if($bought->status == 1)
                      Active
                      @else
                      Disable
                      @endif
                      </td>
                    </tr>
                @endforeach
            </td>
          </tbody>
      </table>
    </div>
   </div>
  </div>
</div>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">   
      <!-- Modal content-->
    <form action="{{url('add/bought_from')}}" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">         
          <h4 class="modal-title">Add Bought From</h4>
        </div>
        <div class="modal-body"> 
        <div class="col-md-">           
                {{csrf_field()}}
                 <div class="form-group">
                    <label for="name">Code:</label>
                    <input required type="text" name="code" class="form-control" >
                </div>   
                <ul class="nav nav-tabs" role="tablist">
                @foreach($languages as $language)
                <li class="nav-item">
                  <a class="nav-link @if($loop->iteration == 1) active @endif" data-toggle="tab" href="#e_{{$language->language_code }}" role="tab">{{$language->language_title}}</a>
                </li> 
                @endforeach
            </ul>
              <div class="tab-content"> 
                @foreach($languages as $language)
                <div class="tab-pane @if($loop->iteration == 1) active @endif" id="e_{{$language->language_code }}" role="tabpanel">
                  <div class="form-group">
                      <label for="name">Title In {{$language->language_title}}:</label>
                       <input type="text" name="{{$language->language_code}}_add_title" id="{{$language->language_code}}_add_title" class="form-control" >

                  </div> 
                </div> 
                @endforeach
            </div>           
        </div>
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn" style="color: white; background-color: #5a386b">Add Bought From</button>            
        </div>      
      </div>
    </form>
  </div>  
</div>
@foreach($boughtfrom as $bought)
<div class="modal fade" id="editmodal{{$bought->bought_from_id}}" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Bought From</h4>
        </div>
        <form action="{{url('edit/bought_from')}}" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id" value="{{$bought->bought_from_id}}">
          <input type="hidden" name="boughtfrom_id" id="boughtfrom_id">
          <div class="modal-body">
            {{csrf_field()}}
            <div class="col-md-">
                <div class="form-group">
                    <label for="name">Code:</label>
                    <input required type="text" name="edit_code" class="form-control" value="{{$bought->code}}" >
                </div>
                <div class="form-group">
                    <label for="name">Status:</label>
                    <select name="status" required="required" class="form-control form-control-sm parts_selector">
                      <option value="1"
                       @if($bought->status == '1' ) selected @endif >Active</option>
                      <option value="0" @if($bought->status=='0' ) selected @endif >Disable</option>
                    </select>
                    
                </div>
                <ul class="nav nav-tabs" role="tablist">
                @foreach($languages as $language)
                <li class="nav-item">
                  <a class="nav-link @if($loop->iteration == 1) active @endif" data-toggle="tab" href="#e_{{$language->language_code }}_{{@$bought->bought_from_id}}" role="tab">{{$language->language_title}}</a>
                </li> 
                @endforeach
                </ul>
                <div class="tab-content"> 
                  @foreach($languages as $language)
                  <div class="tab-pane @if($loop->iteration == 1) active @endif" id="e_{{$language->language_code }}_{{@$bought->bought_from_id}}" role="tabpanel">
                  <div class="form-group">
                      <label for="name">Title In {{$language->language_title}}:</label>
                       <input type="text" name="{{$language->language_code}}_edit_title" id="{{$language->language_code}}_edit_title_{{@$bought->bought_from_id}}" class="form-control" >
                  </div>
                  <div class="form-group">
                      <label for="name">Slug In {{$language->language_title}}:</label>
                       <input type="text" readonly="readonly" name="{{$language->language_code}}_edit_slug" id="{{$language->language_code}}_edit_slug_{{@$bought->bought_from_id}}" class="form-control" >
                  </div>
                   
                </div> 
                @endforeach
            </div>
        </div>
   
        </div>
        <div class="modal-footer">
        	 <button type="submit" class="btn" style="color: white; background-color: #5a386b">Edit Bought From</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
      
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

       @if(Session::has('boughtfrom_added'))
        toastr.success('Success!',"{{Session::get('boughtfrom_added')}}" ,{"positionClass": "toast-bottom-right"});
      @endif

       @if(Session::has('boughtfrom_deleted'))
        toastr.success('Success!',"{{Session::get('boughtfrom_deleted')}}" ,{"positionClass": "toast-bottom-right"});
      @endif

      $(document).on('click', '.editaction', function(){
      var id = $(this).data('id');
      $('#boughtfrom_id').val(id);
      $.ajax({
                method:"get",
                dataType:"json",
                data:{id:id},
                url:"{{ url('admin/edit-bought-from') }}",
                beforeSend:function(){
                   $('#loader_modal').modal({
                        backdrop: 'static',
                        keyboard: false
                      });
                   $("#loader_modal").modal('show');
                },
                success:function(data){
                  $("#loader_modal").modal('hide');

                    if(data.success == true){
                    $('#editmodal').modal('show');
                     if(data.bfd.length > 0){

                     $('#boughtfrom_id').val(data.bfd[0]['boughtfrom_id']);

                     for( var i=0 ; i < data.bfd.length ; i++)
                     {
                      if(data.bfd[i]['language_id'] == 1)
                      {
                        $('#et_edit_title_'+id).val(data.bfd[i]['title']);
                        $('#et_edit_slug_'+id).val(data.bfd[i]['slug']);

                      }
                      else if(data.bfd[i]['language_id'] == 2)
                      {
                        $('#en_edit_title_'+id).val(data.bfd[i]['title']);
                        $('#en_edit_slug_'+id).val(data.bfd[i]['slug']);                       
                      }
                      else if(data.bfd[i]['language_id'] == 3)
                      {
                        $('#ru_edit_title_'+id).val(data.bfd[i]['title']);
                        $('#ru_edit_slug_'+id).val(data.bfd[i]['slug']);
                      }
                     }
                   }
                    }
                },
                error: function (request, status, error) {
                  $("#loader_modal").modal('hide');

                }
            })
   });
  </script>
  @endpush
@endsection