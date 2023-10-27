@extends('admin.layouts.app')

@section('content')

<!-- <div class="row mb-3">
  <div class="col-md-8 title-col">
    <h3 class="maintitle text-uppercase fontbold">Suggestions</h3>
  </div>
 
</div>
 -->
 <div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Suggestions</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="float: right">Add Suggestion</button>
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
       <h5 class="mb-1">Suggestions</h5>
      </div>
      <div class="table-responsive">
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
              <tr>
                  <!-- <th>Sr No.</th> -->
                  <th>Action</th>
                  <th>Title</th>
                  <th>Sentence</th>
                  
              </tr>
          </thead>
          <tbody>
            
            @foreach($suggestion_decs as $suggestion)
                <tr id="suggestion_id_{{$suggestion->suggesstion_id}}">
                    <!-- <td>{{$loop->iteration }}</td> -->
                   <td>
                    <div class="d-flex text-center">
                      <a data-toggle="modal" class="actionicon bg-info editaction"  data-id = "{{$suggestion->suggesstion_id}}"><i class="fa fa-pencil"></i></a>

                      <a data-toggle="modal" href='#deleteModal' class="actionicon bg-danger deleteaction delete-btn" data-id = "{{$suggestion->suggesstion_id}}"><i class="fa fa-close"></i></a>
                    </div>
                  </td>  
                  <td>{{$suggestion->title}}</td>
                  <td>{{$suggestion->sentence}}</td>
                 

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
                    <th>Title</th>
                    <th>Sentence</th>
                    <th>Action</th>

                </tr>
                </thead>
                <tbody>
               @foreach($suggestions as $suggestion)
                    <tr id="suggestion_id_{{$suggestion->id}}">
                        <td>{{$loop->iteration }}</td>
                      <td>{{$suggestion->title}}</td>
                      <td>{{$suggestion->sentence}}</td>
                        <td>
                        	<button class="btn btn-success" title="edit" data-toggle="modal" data-target="#editmodal{{$suggestion->id}}"><i class="fa fa-edit"></i></button>
                          <button class="btn btn-danger delete-btn" title="delete" data-id = "{{$suggestion->id}}"><i class="fa fa-trash"></i></button>
                        	
                        </td>


                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    
</div> -->

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">    
      <!-- Modal content-->
    <form action="{{url('add/suggestion')}}" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}

      <div class="modal-content">
        <div class="modal-header">         
          <h4 class="modal-title">Add Suggestion</h4>
        </div>

        <div class="modal-body">

            <ul class="nav nav-tabs" role="tablist">
                @foreach($languages as $language)
                <li class="nav-item">
                  <a class="nav-link @if($loop->iteration == 1) active @endif" data-toggle="tab" href="#{{$language->language_code }}" role="tab">{{$language->language_title}}</a>
                </li> 
                @endforeach

            </ul>

            <div class="tab-content"> 
                @foreach($languages as $language)
                <div class="tab-pane @if($loop->iteration == 1) active @endif" id="{{$language->language_code }}" role="tabpanel">
                  <div class="form-group">
                      <label for="name">Title In {{$language->language_title}}:</label>
                       <input required type="text" name="{{$language->language_code}}_add_title" class="form-control" >

                      <label for="name">Suggestion In {{$language->language_title}}:</label>
                      <input required type="text-area" name="{{$language->language_code}}_add_suggestion" class="form-control" >

                  </div> 
                </div> 
                @endforeach
            </div>

        </div>


        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn" style="color: white; background-color: #5a386b">Add Suggestion</button>  
        </div>
      </div>
    </form>      
    </div>  
</div>

<div class="modal fade" id="editmodal" >
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <!-- <h4 class="modal-title">Modal Header</h4> -->
        </div>
        <div class="modal-body">
          <form action="{{url('update/suggestion')}}" id="editSuggestion" class="editSuggestion" method="post">
        @csrf
      <div class="modal-body">
        <input type="hidden" name="suggestion_id" id="suggestion_id">
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
                       <input required type="text" name="{{$language->language_code}}_edit_title" id="{{$language->language_code}}_edit_title" class="form-control" >

                      <label for="name">Suggestion In {{$language->language_title}}:</label>
                      <input required type="text-area" name="{{$language->language_code}}_edit_suggestion" id="{{$language->language_code}}_edit_suggestion" class="form-control" >

                  </div> 
                </div> 
                @endforeach
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        
        <input type="submit" class="btn btn-primary" name="submit" value="update">
      </div>
      </form>
        </div>
      </div>
      
    </div>
</div>
  

  @push('custom-scripts')
  <script>
      $('#myTable').DataTable({
          searching: false,
          lengthMenu: [100, 200, 300, 400],
      });

      // @if(Session::has('message'))
      //   toastr.success('Success!',"{{Session::get('message')}}" ,{"positionClass": "toast-bottom-right"});
      // @endif

      $(function(e){
      $(document).on('click', '.delete-btn', function(){
      var id = $(this).data('id');
      swal({
          title: "Alert!",
          text: "Are you sure you want to Delete this Suggestion?",
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
                url:"{{ route('delete-suggestion') }}",
                
                success:function(data){
                    if(data.success == true){
                     $("#suggestion_id_"+id).remove();
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

      $(document).on('click', '.editaction', function(){
      var id = $(this).data('id');
      // alert(id);
      $.ajax({
                method:"get",
                dataType:"json",
                data:{id:id},
                url:"{{ url('edit/suggestions') }}",
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
                      $('#suggestion_id').val(data.e_suggesstion[0]['suggesstion_id']);

                     for( var i=0 ; i < data.e_suggesstion.length ; i++)
                     {
                      if(data.e_suggesstion[i]['language_id'] == 1)
                      {
                        $('#et_edit_title').val(data.e_suggesstion[i]['title']);
                        $('#et_edit_suggestion').val(data.e_suggesstion[i]['sentence']);

                      }
                      else if(data.e_suggesstion[i]['language_id'] == 2)
                      {
                        $('#en_edit_title').val(data.e_suggesstion[i]['title']);
                        $('#en_edit_suggestion').val(data.e_suggesstion[i]['sentence']);
                      }
                      else if(data.e_suggesstion[i]['language_id'] == 3)
                      {
                        $('#ru_edit_title').val(data.e_suggesstion[i]['title']);
                        $('#ru_edit_suggestion').val(data.e_suggesstion[i]['sentence']);
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
   });
  </script>
  @endpush

@endsection