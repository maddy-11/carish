@extends('admin.layouts.app')

@section('content')
<style type="text/css">
.invalid-feedback {
     font-size: 100%; 
}
.disabled:disabled{
  opacity:0.5;
  cursor: not-allowed; 
}

</style>

{{-- Content Start from here --}}

<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Make Model Version</h3>
  </div>
  <!-- <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
      <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" style="float: right">Add Google Ad</button>
  </div> -->

</div>

<div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1">Make Model Version</h5>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered example" style="width:100%">
          <thead>
              <tr>
                <th>Action</th>
                <th>Car<br>Number</th>
                <th>Make</th>
                <th>Model</th>
                <th>Variant</th>
                <th>Version</th>
                <th>From<br>Date</th>
                <th>To<br>Date</th>
                <th>CC</th>
                <th>Engine<br>Power</th>
                <th>Created Date</th>
              </tr>
          </thead>
          <tbody>
            
            @foreach($records as $record)
            <tr>
            <td>
            <!--   <a data-toggle="modal" href='#editModal' class="actionicon bg-info editaction text-center" data-target="#editmodal{{$record->id}}" data-id = "{{$record->id}}"><i class="fa fa-pencil"></i></a>  -->
              <a  class="actionicon bg-danger deleteaction delete-btn text-center"  href="{{route('delete-make-model-version',['id'=>$record->id])}}" ><i class="fa fa-close" onclick="return confirm('Are you sure you want to delete the record {{ @$record->car_number }} ?')"></i></a>
            </td>
            @php
            $ads = null;
            $ad_status = null;
            $url = null;
            if($record->car_number !== null)
            {
              $ads         = \App\Ad::where('car_number',$record->car_number)->first();
              $ad_status = @$ads->status;
              if($ad_status == 1)
              {
                $url = "admin/active-ad-details/$ads->id";
              }
              if($ad_status == '0')
              {
                $url = "admin/ad-details/$ads->id";
              }
              if($ad_status == '2')
              {
                $url = "admin/removed-ad-details/$ads->id";
              } 
              if($ad_status == '3')
              {
                $url = "admin/not-approved-ad-details/$ads->id";
              }    
              
            } 
            @endphp
            <td>
              <a href="{{$url !== null ? url($url) : 'javascript:void(0)'}}" target=""><b>{{$record->car_number !== null ? $record->car_number : '--'}}</b></a>
            </td>
            <td>{{$record->make_title !== null ? $record->make_title : '--'}}</td>
            <td>{{$record->model_title !== null ? $record->model_title : '--'}}</td>
            <td>{{$record->variant !== null ? $record->variant : '--'}}</td>
            <td>{{$record->version !== null ? $record->version : '--'}}</td>
            <td>{{$record->from_date !== null ? $record->from_date : '--'}}</td>
            <td>{{$record->to_date !== null ? $record->to_date : '--'}}</td>
            <td>{{$record->cc !== null ? $record->cc : '--'}}</td>
            <td>{{$record->engin_power !== null ? $record->engin_power : '--'}}</td>
            <td>{{$record->created_at !== null ? $record->created_at : '--'}}</td>
            </tr>
            @endforeach
            
            </td>
          </tbody>
      </table>
    </div>
   </div>
  </div>

</div>

@push('custom-scripts')
<script type="text/javascript">
  $(function(e){
    $('.example').DataTable({});

     @if(Session::has('ad_added'))
        toastr.success('Success!',"{{Session::get('ad_added')}}" ,{"positionClass": "toast-bottom-right"});
      @endif

     @if(Session::has('message'))
        toastr.success('Success!',"{{Session::get('message')}}" ,{"positionClass": "toast-bottom-right"});
      @endif

     @if(Session::has('deleted'))
        toastr.success('Success!',"{{Session::get('deleted')}}" ,{"positionClass": "toast-bottom-right"});
      @endif
    
  });
</script>
@endpush
@endsection

