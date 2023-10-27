@extends('admin.layouts.app')

@section('content')
<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Cities</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
      <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" style="float: right">Add City</button>
  </div>

</div>

<div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1">Cities</h5>
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
            
            @foreach($cities as $city)
                    <tr>

                      <td>

                        <div class="d-flex text-center">
                        <a data-toggle="modal" href='#editModal' class="actionicon bg-info editaction" data-target="#editmodal{{$city->id}}"><i class="fa fa-pencil"></i></a> 
                        <a  class="actionicon bg-danger deleteaction delete-btn"  href="{{route('delete-city',['id'=>$city->id])}}" ><i class="fa fa-close" onclick="return confirm('Are you sure you want to delete the record {{ $city->name }}{{ $city->code }} ?')"></i></a>
                        </div>                        
                      </td>
                      <td>{{$city->name}}</td>
                      <td>{{$city->code}}</td>


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
               @foreach($cities as $city)
                    <tr>
                        <td>{{$loop->iteration }}</td>
                      <td>{{$city->name}}</td>
                      <td>{{$city->code}}</td>
                        <td>
                        	<button class="btn btn-success"  data-toggle="modal" data-target="#editmodal{{$city->id}}">Edit</button>



                           <a target="" href="{{route('delete-city',['id'=>$city->id])}}"><button onclick="return confirm('Are you sure you want to delete the record {{ $city->name }}{{ $city->code }} ?')" class="btn btn-danger" >Delete</button></a>
                        	
                        </td>


                    </tr>
                @endforeach
                </tbody>
            </table>
</div> -->
   

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">   
      <!-- Modal content-->
    <form action="{{url('add/city')}}" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">         
          <h4 class="modal-title">Add City</h4>
        </div>
        <div class="modal-body">      

        <div class="col-md-">           
                {{csrf_field()}}
                <div class="form-group">
                    <label for="name">City:</label>
                    <input required type="text" name="title" class="form-control" >
                </div>

                 <div class="form-group">
                    <label for="name">Code:</label>
                    <input required type="text" name="code" class="form-control" >
                </div>              
        </div>
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn" style="color: white; background-color: #5a386b">Add City</button>            
        </div>      
      </div>
    </form>
  </div>  
</div>


@foreach($cities as $city)
<div class="modal fade" id="editmodal{{$city->id}}" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          
          <h4 class="modal-title">Edit City</h4>
        </div>
        <div class="modal-body">
        
<form action="{{url('edit/cities')}}" method="POST" enctype="multipart/form-data">
            	<input type="hidden" name="id" value="{{$city->id}}">

                {{csrf_field()}}
        <div class="col-md-">
            <h1 style="color: #5a386b">Edit City</h1>
            
                
                <div class="form-group">
                    <label for="name">City:</label>
                    <input required type="text" name="edit_title" class="form-control" value="{{$city->name}}" >
                </div>

                <div class="form-group">
                    <label for="name">Code:</label>
                    <input required type="text" name="edit_code" class="form-control" value="{{$city->code}}" >
                </div>

        </div>
   
        </div>
        <div class="modal-footer">
        	 <button type="submit" class="btn" style="color: white; background-color: #5a386b">Edit City</button>
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

       @if(Session::has('city_deleted'))
        toastr.success('Success!',"{{Session::get('city_deleted')}}" ,{"positionClass": "toast-bottom-right"});
      @endif
  </script>
  @endpush

@endsection