@extends('admin.layouts.app')

@section('content')

<!-- <div class="row mb-3">
  <div class="col-md-8 title-col">
    <h3 class="maintitle text-uppercase fontbold">Models</h3>
  </div>
 
</div> -->
<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-4 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Models</h3>
  </div>
  <div class="col-lg-8 col-md-5 col-sm-5 search-col text-right">
      
      <button class="btn btn-primary" data-toggle="modal" data-target="#uploadExcel">Upload Excel</button>
      <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#myModal" style="float:right;clear:both">Add Models</button>
      <button type="button" name="bulk_delete" id="bulk_delete" class="btn btn-danger btn-xs">Delete</button>
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
       <h5 class="mb-1"> {{@$maker->title}} MODELS</h5>
       <input type="hidden" name="make_id" value="{{@$maker->id}}" id="make_id">
      </div>
      <div class="table-responsive">

         <table class="table entriestable table-bordered table-models text-center">
        <thead id="sticky">
          <tr>
                <th>
                <input type="checkbox"  id="check_all" >
                </th>
                <th>Action</th>
                <th>Model</th>
                <th>Maker</th>
                <th>Maker Image</th>
                <th>Total Version</th>
          </tr>
        </thead>

      </table>
    </div>
   </div>
  </div>

</div>




<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <form action="{{url('admin/add-model')}}" method="POST" enctype="multipart/form-data">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
             <!-- <h1 style="color: #5a386b">Add Model</h1> -->         
          <h4 class="modal-title" style="color: #5a386b;">Add Model</h4>
        </div>
        <div class="modal-body">       
        <div class="col-md-">           
                {{csrf_field()}}
                    <div class="form-group">
                    <label for="name">Model:</label>
                    <input required type="text" name="title" class="form-control" >
                </div>
                    
                    <div class="form-group">
                      <label for="name">Select Vehicle type:</label>
                       <select name="vehicle_type_id" class="form-control">
                      @foreach($vehicle_types as $vehicle_type)
                          <option value="{{$vehicle_type->vehicle_type_id}}">{{$vehicle_type->title}}</option>
                      @endforeach
                      </select>
                    </div>

                 <div class="form-group">
                    <label for="name">Select Maker:</label>
                     <select name="parent" class="form-control">
                    @foreach($makers as $maker)
                        <option value="{{$maker->id}}">{{$maker->title}}</option>
                    @endforeach
                    </select>
                </div>                       
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="submit" class="btn" style="color: white; background-color: #5a386b">Add Modal</button>           
        </div>
      </div>
      </form>
      
    </div>
</div>  



<!-- Upload excel file  -->
<div class="modal fade" id="uploadExcel"> 
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">   
        <div class="modal-body text-center">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h3 class="text-capitalize fontmed">Upload Excel For Makes,models and variants</h3>
          <div class="mt-3">
          <form method="post" action="{{url('admin/upload-excel-makes')}}" class="upload-excel-form" enctype="multipart/form-data">
            {{csrf_field()}}

            <div class="form-group">
              <a target="" href="{{asset('public/admin/excel/Example_file.xlsx')}}" download><span class="btn btn-success" id="examplefilebtn">Download Example File</span></a>
            </div>

            <div class="form-group">
              <input type="file" name="excel" class="font-weight-bold form-control-lg form-control" >
            </div>           
            
            <div class="form-submit">
              <input type="submit" value="upload" class="btn btn-bg save-btn">
              <input type="reset" value="close" class="btn btn-danger close-btn">
            </div>
            </form>
         </div> 
        </div>
      </div>
    </div>  
  </div>



<div class="modal fade" id="editmodal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
             <!-- <h1 style="color: #5a386b">Add Model</h1> -->         
          <h4 class="modal-title" style="color: #5a386b;">Edit Model</h4>
        </div>

      <form action="{{route('edit-model')}}" method="POST" enctype="multipart/form-data">

        <div class="modal-body">
        

        <div class="col-md-">
           
                {{csrf_field()}}
                <input type="hidden" name="make_model_id" id="make_model_id" value="">
                <div class="form-group">
                    <div class="form-group">
                    <label for="name">Model:</label>
                    <input required type="text" name="edittitle" id="edittitle" value="" class="form-control" >
                </div>
                </div>

                <div class="form-group">
                      <label for="name">Select Vehicle type:</label>
                       <select name="e_vehicle_type_id" id="e_vehicle_type_id" class="form-control">
                      @foreach($vehicle_types as $vehicle_type)
                          <option value="{{$vehicle_type->vehicle_type_id}}">{{$vehicle_type->title}}</option>
                      @endforeach
                      </select>
                </div>

                 <div class="form-group">
                    <label for="name">Select Maker:</label>
                     <select name="editparent" class="form-control" id="model_maker">
                    @foreach($makers as $maker)
                        <option value="{{$maker->id}}" > {{$maker->title}}</option>
                    @endforeach
                    </select>
                </div>
                 
                
                
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn" style="color: white; background-color: #5a386b">Update Modal</button>
           
        </div>
         </form>
      </div>
      
    </div>
  </div>
  

@push('custom-scripts')
  <script>
      $('#myTable').DataTable({
          searching: false
      });

      $('.models_table').DataTable({
          scrollX: true,
          scrollY : '90vh',
          scrollCollapse: true,

      })

      @if(Session::has('message'))
        toastr.success('Success!',"{{Session::get('message')}}" ,{"positionClass": "toast-bottom-right"});
      @endif

      $(function(e){
      $(document).on('click', '.delete-btn', function(){
      var id = $(this).data('id');
      swal({
          title: "Alert!",
          text: "Are you sure you want to Delete this Model?",
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
                url:"{{ route('delete-model') }}",
                
                success:function(data){
                    if(data.success == true){
                     $("#model_id_"+id).remove();
                      toastr.success('Success!', data.message ,{"positionClass": "toast-bottom-right"});
                    }
                    else if(data.success == false)
                    {
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

      $(document).on('click', '#bulk_delete', function(){
        var id = [];

        /*************/
        swal({
          title: "Alert!",
          text: "Are you sure you want to Delete these Models?",
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
             /*******************************/

            $('.student_checkbox:checked').each(function(){
                id.push($(this).val());
            });
            if(id.length > 0)
            {
            alert(id);
                $.ajax({
                    url:"{{ route('models-massremove')}}",
                    method:"get",
                    data:{id:id},
                    success:function(data)
                    {
                        if(data.success == true){
                         // $("#model_id_"+id).remove();
                          toastr.success('Success!', data.message ,{"positionClass": "toast-bottom-right"});
                          window.location.reload();
                        }
                        else if(data.success == false)
                        {
                          toastr.success('Info!', 'Model '+data.model+' cannot be deleted because it is used in ads' ,{"positionClass": "toast-bottom-right"});
                        }
                    }
                });
            }
            else
            {
                // alert("Please select atleast one checkbox");
                toastr.info('Info!', 'Please select atleast one checkbox' ,{"positionClass": "toast-bottom-right"});
            }
        
             /*******************************/
          } 
          else{
              swal("Cancelled", "", "error");
          }
       
    });
        /*************/
        // if(confirm("Are you sure you want to Delete this data?"))
        // {
        //     $('.student_checkbox:checked').each(function(){
        //         id.push($(this).val());
        //     });
        //     if(id.length > 0)
        //     {
        //     alert(id);
        //         $.ajax({
        //             url:"{{ route('models-massremove')}}",
        //             method:"get",
        //             data:{id:id},
        //             success:function(data)
        //             {
        //                 if(data.success == true){
        //                  // $("#model_id_"+id).remove();
        //                   toastr.success('Success!', data.message ,{"positionClass": "toast-bottom-right"});
        //                 }
        //                 else if(data.success == false)
        //                 {
        //                   toastr.success('Success!', 'Model '+data.model+' cannot be deleted because it is used in ads' ,{"positionClass": "toast-bottom-right"});
        //                 }
        //             }
        //         });
        //     }
        //     else
        //     {
        //         alert("Please select atleast one checkbox");
        //     }
        // }
        /*************/

    });

      $(document).on('change' , '#check_all' ,function () {

            if ($(this).is(':checked'))
            {
              // alert('checked');
             $( ".student_checkbox" ).prop( "checked", true );

            }
            else
            {
              // alert('Un checked');
             $( ".student_checkbox" ).prop( "checked", false );

            }

            });

      $(document).on('click', '.editaction', function(){
          var id = $(this).data('id');
          // alert(id);
          $.ajax({
                    method:"get",
                    dataType:"json",
                    data:{id:id},
                    url:"{{ url('admin/edit-make-model') }}",
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
                          console.log(data);
                          $('#editmodal').modal('show');
                          $('#make_model_id').val(data.model['id']);
                          $('#edittitle').val(data.model['name']);
                          $("#model_maker  option[value="+data.model['make_id']+"]").prop("selected", true);
                          $("#e_vehicle_type_id  option[value="+data.model['vehicle_type_id']+"]").prop("selected", true);
                        }
                    },
                    error: function (request, status, error) {
                      $("#loader_modal").modal('hide');

                    }
                })
       });
   });

var table2 = $('.table-models').DataTable({
       processing: true,
        "language": {
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw" style="color:#13436c;"></i><span class="sr-only">Loading...</span> '},
      ordering: false,
      lengthMenu:[50,100,150,200],
      serverSide: true,
      ajax:{
        beforeSend: function(){
          $('#loader_modal').modal({
              backdrop: 'static',
              keyboard: false
            });
          $("#loader_modal").modal('show');
        },
          url:"{!! route('get-models') !!}",
          data: function(data) { data.make_id = $('#make_id').val()},
        },

      scrollX:true,
      scrollY : '90vh',
    scrollCollapse: true,

      columns: [
        { data: 'checkbox', name: 'checkbox' },
        { data: 'action', name: 'action' },
        { data: 'model_name', name: 'model_name' },
        { data: 'maker', name: 'maker' },
        { data: 'maker_image', name: 'maker_image' },
        { data: 'version', name: 'version' },
      ],
     initComplete: function () {
      $('.dataTables_scrollHead').css('overflow', 'auto');

      $('.dataTables_scrollHead').on('scroll', function () {
              $('.dataTables_scrollBody').scrollLeft($(this).scrollLeft());
          });
        }, 
        drawCallback: function(){
        $('#loader_modal').modal('hide');
      }
    });
  </script>
  @endpush


@endsection

