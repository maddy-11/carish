@extends('admin.layouts.app')

@section('content')
	
<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Add SubAdmin</a></h3>
  </div>
</div>

<div class="row">
  <div class="col-3"></div>
  <div class="col-lg-6 col-6 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1">Add SubAdmin</h5>
      </div>
      <div>

<form action="{{url('admin/create-sub-admin')}}" method="post" enctype="multipart/form-data">
         {{csrf_field()}}
  <div class="form-group">
    <label for="fname">Name:</label>
    <input type="text" class="form-control" id="fname" name="name" required>
  </div>
  
   <div class="form-group">
    <label for="pwd">Role Type:</label>
    <select class="form-control" name="role" required>
      <option class="active">Select Role</option>
      @foreach($roles as $role)
      <option value="{{@$role->id}}" {{@$user->role_id == @$role->id ? 'selected' : ''}}>{{@$role->name}}</option>
      @endforeach
    </select>
  </div>

  <div class="form-group">
    <label for="email">Email:</label>
    <input type="text" class="form-control" id="email" name="email">
  </div>

   <div class="form-group">
    <label for="pwd">Password:</label>
    <input type="password" class="form-control" id="password" name="password">
  </div>

 
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
   </div>
  </div>

</div>
@endsection

