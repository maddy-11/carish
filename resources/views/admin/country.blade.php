@extends('admin.layouts.app')

@section('content')
<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Countries</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
      <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" style="float: right">Add Country</button>
  </div>

</div>

<div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1">Countries</h5>
      </div>
      <div class="table-responsive">
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
              <tr>
                <th>Action</th>
                <th>Name</th>
                <th>Code</th>
              </tr>
          </thead>
          <tbody>
            
            @foreach($countries as $country)
                    <tr>

                      <td>

                        <div class="d-flex text-center">
                        <a data-toggle="modal" href='#editModal' class="actionicon bg-info editaction" data-target="#editmodal{{$country->id}}" data-id = "{{$country->id}}"><i class="fa fa-pencil"></i></a> 
                        <a  class="actionicon bg-danger deleteaction delete-btn"  href="{{route('delete-country',['id'=>$country->id])}}" ><i class="fa fa-close" onclick="return confirm('Are you sure you want to delete the record {{ $country->name }}{{ $country->code }} ?')"></i></a>
                        </div>                        
                      </td>
                      <td>{{$country->name}}</td>
                      <td>{{$country->code}}</td>


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
    <form action="{{url('add/country')}}" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">         
          <h4 class="modal-title">Add Country</h4>
        </div>
        <div class="modal-body">      

        <div class="col-md-">           
                {{csrf_field()}}
               <!--  <div class="form-group">
                    <label for="name">Country:</label>
                    <input required type="text" name="title" class="form-control" >
                </div> -->

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
          <button type="submit" class="btn" style="color: white; background-color: #5a386b">Add Country</button>            
        </div>      
      </div>
    </form>
  </div>  
</div>


@foreach($countries as $country)
<div class="modal fade" id="editmodal{{$country->id}}" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          
          <h4 class="modal-title">Edit Country</h4>
        </div>
        <div class="modal-body">
        
<form action="{{url('edit/countries')}}" method="POST" enctype="multipart/form-data">
            	<input type="hidden" name="id" value="{{$country->id}}">
           <input type="hidden" name="country_id" id="country_id">


                {{csrf_field()}}
        <div class="col-md-">
            
               <!--  <div class="form-group">
                    <label for="name">Country:</label>
                    <input required type="text" name="edit_title" class="form-control" value="{{$country->name}}" >
                </div> -->

                <div class="form-group">
                    <label for="name">Code:</label>
                    <input required type="text" name="edit_code" class="form-control" value="{{$country->code}}" >
                </div>

                 <ul class="nav nav-tabs" role="tablist">
                @foreach($languages as $language)
                <li class="nav-item">
                  <a class="nav-link @if($loop->iteration == 1) active @endif" data-toggle="tab" href="#e_{{$language->language_code }}_{{@$country->id}}" role="tab">{{$language->language_title}}</a>
                </li> 
                @endforeach

            </ul>

              <div class="tab-content"> 
                @foreach($languages as $language)
                <div class="tab-pane @if($loop->iteration == 1) active @endif" id="e_{{$language->language_code }}_{{@$country->id}}" role="tabpanel">
                  <div class="form-group">
                      <label for="name">Title In {{$language->language_title}}:</label>
                       <input type="text" name="{{$language->language_code}}_edit_title" id="{{$language->language_code}}_edit_title_{{@$country->id}}" class="form-control" >

                  </div> 
                </div> 
                @endforeach
            </div>

        </div>
   
        </div>
        <div class="modal-footer">
        	 <button type="submit" class="btn" style="color: white; background-color: #5a386b">Edit Country</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
      
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

       @if(Session::has('country_added'))
        toastr.success('Success!',"{{Session::get('country_added')}}" ,{"positionClass": "toast-bottom-right"});
      @endif

       @if(Session::has('country_deleted'))
        toastr.success('Success!',"{{Session::get('country_deleted')}}" ,{"positionClass": "toast-bottom-right"});
      @endif

      $(document).on('click', '.editaction', function(){
      var id = $(this).data('id');
      // alert(id);
      $('#country_id').val(id);
      $.ajax({
                method:"get",
                dataType:"json",
                data:{id:id},
                url:"{{ url('admin/edit-country') }}",
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
                     // alert(data.e_suggesstion[0]['suggesstion_id']);
                     if(data.spareparts.length > 0){
                      // alert('hi');
                      $('#country_id').val(data.spareparts[0]['country_id']);

                     for( var i=0 ; i < data.spareparts.length ; i++)
                     {
                      if(data.spareparts[i]['language_id'] == 1)
                      {
                        $('#et_edit_title_'+id).val(data.spareparts[i]['title']);

                      }
                      else if(data.spareparts[i]['language_id'] == 2)
                      {
                        $('#en_edit_title_'+id).val(data.spareparts[i]['title']);
                       
                      }
                      else if(data.spareparts[i]['language_id'] == 3)
                      {
                        $('#ru_edit_title_'+id).val(data.spareparts[i]['title']);
                       
                      }
                     }
                   }

                    // $('#version_id').val(data.e_version['id']);
                    // $('#v_name').val(data.e_version['label']);
                    // $('#v_from_date').val(data.e_version['from_date']);
                    // $('#v_to_date').val(data.e_version['to_date']);
                    // $('#v_kw').val(data.e_version['kilowatt']);
                    // $('#v_cc').val(data.e_version['cc']);
                    // var slctVal = data.e_version['body_type_id'];
                    // console.log(slctVal);
                    // $('#edit_body_type option[value='+slctVal+']').prop('selected', true);
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