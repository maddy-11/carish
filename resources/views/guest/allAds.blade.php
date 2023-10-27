@extends('layouts.app')

@section('content')

@php
    $cities = Statichelper::getCities();
    $makers = Statichelper::getCars();
    $years  = Statichelper::getYears();
    $colors = Statichelper::getColors();
@endphp
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <p>{{__('popupAdvanceSearch.advanceSearchTitle')}}</p>
                <form action="{{url('/advance-search-ads')}}" method="post">
                    {{csrf_field()}}
                    <p>{{__('popupAdvanceSearch.city')}}</p>
                    <select name="city"  class="form-control">
                        <option value="" selected disabled="">{{__('popupAdvanceSearch.selectOption')}}</option>
                        @foreach($cities as $city)
                            <option value="{{$city->id}}">{{$city->name}}</option>
                        @endforeach
                    </select>
                    <p>{{__('popupAdvanceSearch.make')}}</p>
                    <select name="maker" class="form-control" onchange="getModels(this)">
                        <option value="" selected disabled="" >{{__('popupAdvanceSearch.selectOption')}}</option>
                        @foreach($makers as $maker)
                            <option value="{{$maker->id}}">{{$maker->title}}</option>
                        @endforeach
                    </select>

                    <p>{{__('popupAdvanceSearch.model')}}</p>
                    <select name="models" disabled id="modelsSelect"  class="form-control">
                        <option value="" selected disabled="">{{__('popupAdvanceSearch.selectOption')}}</option>
                    </select>

                    <p>{{__('popupAdvanceSearch.year')}}</p>
                    <select name="year"  class="form-control">
                        <option value="" selected disabled="">{{__('popupAdvanceSearch.selectOption')}}</option>
                        @foreach($years as $year)
                            <option value="{{$year->id}}">{{$year->title}}</option>
                        @endforeach
                    </select>

                    <p>{{__('popupAdvanceSearch.price')}}</p>
                    <input type="number" class="form-control" name="price_from" placeholder="{{__('popupAdvanceSearch.from')}}">
                    <input type="number" class="form-control" name="price_to" placeholder="{{__('popupAdvanceSearch.to')}}">

                    <p>{{__('popupAdvanceSearch.mileage')}} (KM)</p>
                    <input type="number" class="form-control" name="m_from" placeholder="{{__('popupAdvanceSearch.from')}}">
                    <input type="number" class="form-control" name="m_to" placeholder="{{__('popupAdvanceSearch.to')}}">

                    <p>{{__('popupAdvanceSearch.color')}}</p>
                    <select name="color"  class="form-control">
                        <option value="" selected disabled="">{{__('popupAdvanceSearch.selectOption')}}</option>
                        @foreach($colors as $color)
                            <option value="{{$color->id}}">{{$color->name}}</option>
                        @endforeach
                    </select>

                    <br>
                    <input type="submit" class="btn btn-success" value="Search">
                </form>
            </div>
            <div class="col-md-8 ">
                @foreach($ads as $ad)
                    <div class="row" style="margin-top: 30px;">
                        <div class="col-md-2 col-md-offset-2">
                            <img src="{{url('public/ads/'.$ad->user_id.'/'.\App\AdImage::where('ad_id',$ad->id)->first()->img)}}" style="width: 100%">
                        </div>
                        <div class="col-md-8">
                            <h1>{{\App\Year::find($ad->year_id)->title}} {{\App\Car::find($ad->maker_id)->title}} {{\App\Car::find($ad->model_id)->title}}</h1>
                            <p>Posted : {{date('M dS, Y', strtotime($ad->created_at))}}</p>
                            <p><i class="fas fa-eye"></i> {{$ad->views}} Views</p>
                            @php
                            if(\Illuminate\Support\Facades\Auth::user())
                            {
                                $saved_ads = \App\UserSavedAds::where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->pluck('ad_id')->toArray();
                            }
                            else
                            {
                                $saved_ads = [];
                            }
                            @endphp
                            @if(!in_array($ad->id,$saved_ads))
                            <p><a target="" href="{{url('save-ad/'.$ad->id)}}"><i class="fa fa-heart"></i> Save Ad</a></p>
                            @else
                            <p><i class="fa fa-heart" style="color: red"></i> Saved</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        function getModels(e) {
            var maker = $(e).val();
            $.ajax({
               url : "{{url('get-models-for-maker')}}/"+maker,
               method : "get",
                success : function (data) {
                    $('#modelsSelect').html(data);
                    $('#modelsSelect').attr('disabled',false);
                }
            });

        }
    </script>

@endsection