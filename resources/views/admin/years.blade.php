@extends('admin.layouts.app')

@section('content')

<div class="row mb-3">
  <div class="col-md-8 title-col">
    <h3 class="maintitle text-uppercase fontbold">Year</h3>
  </div>
 
</div>

@if(session()->has('message'))
    <div class="alert alert-success  alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
        {{ session()->get('message') }}
    </div>
@endif
  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" style="float: right">Add Year</button>

<div style="margin-top: 40px">
            <table id="myTable" class="table" >
                <thead>

                <tr>
                    <th>Sr No.</th>
                    <th>title</th>
                    <th>Action</th>

                </tr>
                </thead>
                <tbody>
               @foreach($years as $year)
                    <tr>
                        <td>{{$loop->iteration }}</td>
                        <td>{{$year->title}}</td>
                        <td>
                        	<button class="btn btn-success"  data-toggle="modal" title="edit" data-target="#editmodal{{$year->id}}"><i class="fa fa-edit"></i></button>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    
</div>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
         
          <h4 class="modal-title">Add Year</h4>
        </div>
        <div class="modal-body">
        

        <div class="col-md-">
           
            <form action="{{url('add/year')}}" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="name">Years:</label>
                    <input required type="text" name="title" class="form-control" >
                </div>
                
               



        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           <button type="submit" class="btn" style="color: white; background-color: #5a386b">Add Year</button>
            
        </div>
        </form>
      </div>
      
    </div>
  </div>
  
</div>


@foreach($years as $year)
<div class="modal fade" id="editmodal{{$year->id}}" role="dialog">
  <div class="modal-dialog">
    
  <form action="{{url('edit/year')}}" method="POST" enctype="multipart/form-data">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">          
          <h4 class="modal-title">Edit Year</h4>
        </div>
        <div class="modal-body">        
          <input type="hidden" name="id" value="{{$year->id}}">
          {{csrf_field()}}
        <div class="col-md-">
            <h1 style="color: #5a386b">Add Year</h1>
            <div class="form-group">
                <label for="name">Years:</label>
                <input required type="text" name="edit_title" class="form-control" value="{{$year->title}}" >
            </div>
        </div>
   
        </div>
        <div class="modal-footer">
        	 <button type="submit" class="btn" style="color: white; background-color: #5a386b">Edit Year</button>
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
  </script>
  @endpush

@endsection