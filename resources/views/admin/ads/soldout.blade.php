@extends('admin.layouts.app')

@section('content')

<!-- <div class="row" style="float: right; display: none;">
    <button type="button" class="btn btn-primary" id="pending">Pending</button>
    <button type="button" class="btn btn-success" id="remove">Remove</button>
    <button type="button" class="btn btn-warning" id="soldout">SoldOut</button>
    <button type="button" class="btn btn-danger" id="reject">Rejected</button>
</div> -->

    <div style="overflow-x: auto; width: 100%;">
        <table id="UserAds"  class="table table-responsive">
            <thead>
            <tr>
                <!-- <th>Choose Operation</th> -->
                <th>Maker</th>
                <th>Model</th>
                <th>Detail</th>
                <th>Bought From</th>
                <th>Year</th>
                <th>Color</th>
                <th>Price</th>
                <th>Customer</th>
                <th>Status</th>
                <th>Is Featured</th>
                <th style="width: 100%">Action</th>
            </tr>
            </thead>

            <tbody>
            @foreach($ads as $ad)
            
                <tr>
                    <!-- <td><input type="checkbox" name="checkbox" id="check">
                    <input type="hidden" name="ad_id" value="{{$ad->id}}" id="ad_id">  
                    </td> -->
                    <td>{{@$ad->maker->title}}</td>
                    <td>{{@$ad->model->name}}</td>
                    <td style="white-space: nowrap;">{{@$ad->versions->name}}</td>
                    <td>{{@$ad->city->name}}</td>
                    <td>{{@$ad->year}}</td>
                    <td>{{@$ad->color->name}}</td>
                    <td>{{$ad->price}}</td>
                    <td>{{\App\Models\Customers\Customer::find($ad->customer_id)->customer_firstname}} {{\App\Models\Customers\Customer::find($ad->customer_id)->customer_lastname}}</td>
                    

                    @if($ad->status == 0)
                   <td><label class="label label-warning">Pending</label></td>
                    @elseif($ad->status == 1)
                    <td><label class="label label-info">Approved</label></td>
                    @elseif($ad->status == 2)
                    <td><label class="label label-primary">Removed</label></td>
                    @elseif($ad->status == 3)
                    <td><label class="label label-success">SoldOut</label></td>
                    @elseif($ad->status == 4)
                    <td><label class="label label-danger">Rejected</label></td>
                    @endif
                    <td>    
                       @if($ad->is_featured == 'false')
                        <button id="isFeatured" type="button" data-id="{{$ad->id}}"><i class="fa fa-check-square"></i></button>
                       @endif
                    </td>
                    <td> 

                        @if($ad->status == 0)
                            <a class="btn btn-primary" title="Approve" href="{{url('admin/approve-ad/'.$ad->id)}}"><i class="fa fa-check-square"></i></a>
                            <a class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        @elseif($ad->status == 1)
                            <a class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        @elseif($ad->status == 2)
                            <a class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        @elseif($ad->status == 3)
                        <a class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        @elseif($ad->status == 4)
                        <a class="btn btn-danger"><i class="fa fa-trash"></i></a>     
                        @endif

                    </td>
                   
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    @push('custom-scripts')
    <script>
        $('#UserAds').DataTable();
    </script>


    @endpush

@endsection