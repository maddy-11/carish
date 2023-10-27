@extends('admin.layouts.app')

@section('content')

    <div style="overflow-x: auto; width: 100%;">
        <table id="UserAds"  class="table table-responsive">
            <thead>
            <tr>
                <th>User</th>
                <th>City</th>
                <th>Year</th>
                <th>Maker</th>
                <th>Model</th>
                <th>Color</th>
                <th>Bought From</th>
                <th>Millage</th>
                <th>Fuel Average</th>
                <th>Price</th>
                <th>Views</th>
                <th>VAT</th>
                <th>Negotiable</th>
                <th>Status</th>
                <th style="width: 100%">Action</th>
            </tr>
            </thead>

            <tbody>
            @foreach($ads as $ad)
                <tr>
                    <td>{{\App\Models\Customers\Customer::find($ad->customer_id)->customer_firstname}} {{\App\Models\Customers\Customer::find($ad->customer_id)->customer_lastname}}</td>
                    <td>{{\App\City::find($ad->city_id)->name}}</td>
                    <td>{{\App\Year::find($ad->year_id)->title}}</td>
                    <td>{{\App\Car::find($ad->maker_id)->title}}</td>
                    <td>{{\App\Car::find($ad->model_id)->title}}</td>
                    <td>{{\App\Color::find($ad->color_id)->name}}</td>
                    <td>{{$ad->bought_from}}</td>
                    <td>{{$ad->millage}}</td>
                    <td>{{$ad->fuel_average}}</td>
                    <td>{{$ad->price}}</td>
                    <td>{{$ad->views}}</td>
                    <td>@if($ad->vat == 1) Yes @else No @endif</td>
                    <td>@if($ad->neg == 1) Yes @else No @endif</td>
                    @if($ad->status == 0)
                    <td><label class="label label-warning">Pending</label></td>
                    @elseif($ad->status == 1)
                    <td><label class="label label-info">Approved</label></td>
                    @elseif($ad->status == 2)
                    <td><label class="label label-success">Published</label></td>
                    @endif
                    <td>
                        @if($ad->status == 0)
                            <a class="btn btn-primary" title="Approve" href="{{url('admin/approve-ad/'.$ad->id)}}"><i class="fa fa-check-square"></i></a>
                            <a class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        @elseif($ad->status == 1)
                            <a class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        @elseif($ad->status == 2)
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