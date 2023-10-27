@extends('layouts.app')
@section('title') {{ __('findServicePage.pageTitle') }} @endsection
@push('styles')
<style type="text/css">
    .expand_success {
        background: #ddd;
    }

    /*for loader*/
    .loader {
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 80px;
        height: 80px;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
        margin: auto;
        margin-top: 100px;
    }


    /* Safari */
    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .allow_scroll {
        max-height: 648px;
        min-height: 648px;
        overflow-y: scroll;
    }

    .allow_scroll::-webkit-scrollbar {
        width: 7px;
        background-color: #eee;
    }

    .allow_scroll::-webkit-scrollbar-thumb {
        background-color: #ccc;
        border-radius: 0px;
    }

    .allow_scroll::-webkit-scrollbar-thumb:hover {
        background-color: #aaa;
        /*border:1px solid #333333;*/
    }

    .allow_scroll::-webkit-scrollbar-thumb:active {
        background-color: #aaa;
        /*border:1px solid #333333;*/
    }

    .allow_scroll::-webkit-scrollbar-track {
        /*border:1px gray solid;*/
        /*border-radius:10px;*/
        /*-webkit-box-shadow:0 0 6px gray inset;*/
    }

    @media (max-width: 991px) {
        .auto_parts_list {
            display: flex !important;
        }

        .auto_parts_list>div {
            width: 50%;
        }

        .auto_parts_list>div>li {
            margin-right: 12px;
        }

        .allow_scroll {
            min-height: auto !important;
            max-height: auto !important;
        }
    }

    /* .mainLoader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('{{asset("public/assets/img/loading1.gif")}}') 50% 50% no-repeat rgba(249,249,249,0.1);
    } */
</style>
@endpush
@section('content')
@php
use App\ServiceDetail;
use App\Models\Services;
use App\Models\Customers\SubService;
use App\Models\Cars\Make;
$activeLanguage = \Session::get('language');
@endphp
<div class="internal-page-content mt-4 pb-0 sects-bg">
    <div class="bgcolcor bgcolor1 internal-banner text-white cc-page-banner">
        <div class="container">
            <h3 class="font-weight-semibold text-capitalize mb-1">{{__('findServicePage.services')}}</h3>
            <p class="mb-0">{{__('findServicePage.pageTitleDetailedText')}}</p>
        </div>
    </div>
    <div class="container mt-n5">
        <div class="comp-form-bg bg-white border p-md-4 p-3">
            <form class="p-md-2">
                <div class="form-row row">
                    <div class="col-7 col-md-9 col-sm-8 form-group mb-0">
                        <input type="text" id="autoPartSearch" placeholder="" class="form-control">
                        <input type="hidden" id="autopartSelected" class="search_text_submit">
                    </div>
                    <div class="col-5 col-md-3 col-sm-4 form-group mb-0">
                        <input disabled="disabled" type="submit" value="{{__('findServicePage.searchButton')}}" class="btn themebtn3 w-100 pl-3 pr-3 search_check_submit">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Offered Services in Estonia Start Here -->
    <div class="offered-services-section mt-md-5 mt-4">
        <!--  Offered Services row 1 Start Here -->
        @if(@$categories->count() > 0)
        @foreach($categories as $category)
        <div class="offered-services-rows pt-0 pb-0">
            <div class="container">
                <div class="bg-white ml-0 mr-0 mb-2 row">
                    <div class="col-lg-12 p-0">
                        <h4 id="show_category_{{$category->cat_id}}" data-id="{{@$category->cat_id}}" class="show_category align-items-center align-items-md-start d-flex justify-content-start offered-services-title mb-0 p-3 p-lg-4 themecolor expand_success">
                            @if(@$category->image != null && file_exists('public/uploads/image/'.@$category->image))
                            <img src="{{url('public/uploads/image/'.@$category->image)}}" class="img-fluid mr-2" style="width: 30px;height: 24px;">
                            @else
                            <img src="{{url('public/uploads/image/car.png')}}" class="img-fluid mr-2" style="width: 30px;height: 24px;">
                            @endif
                            <a href="javascript:void(0)">
                                {{$category->title}} ({{@$category->category_count($category->cat_id)}})</a>
                        </h4>
                    </div>
                    <div class="all_spares ml-0 mr-0 col-lg-12" id="show_{{@$category->cat_id}}">
                        <div class="row">
                            <div class="border col-12 col-md-3 col-sm-4 f-size1 offered-services-sidebar p-0" data-id="{{@$category->cat_id}}">
                                <div class="collapse d-lg-block show" id="service-bar-collape1">
                                    <div class="p-3 p-lg-4 allow_scroll">
                                        <ul class="list-unstyled offer-ctg-list">
                                            @php
                                            $sub_categories = $category->get_sub_categories($category->cat_id);
                                            $count = intval(ceil($sub_categories->count() / 2));
                                            $looop = $count;
                                            @endphp
                                            <div class="auto_parts_list">
                                                <div>
                                                    @foreach(@$sub_categories as $sub_category)
                                                    <li>
                                                        <a href="javascript:void(0)" data-primary_id="{{@$category->cat_id}}" data-cat_id="{{@$sub_category->sub_cat_id}}">{{$sub_category->title}}
                                                            ({{@$category->sub_category_count($sub_category->sub_cat_id)}})</a>

                                                        @php
                                                        $sub_subCategories = $category->get_sub_subcategories($sub_category->sub_cat_id,$sub_category->is_make);
                                                        @endphp
                                                        @if(!$sub_subCategories->isEmpty())
                                                        <ul class="list-unstyled custdropdown" data-id="{{$category->cat_id}}" style="display: none">
                                                            @foreach(@$sub_subCategories as $sub_subCategory)
                                                            <li><a href="javascript:void(0)" data-id="{{@$category->cat_id}} {{@$sub_category->sub_cat_id}} {{@$sub_subCategory->id}}" class="load_offer_services" data-primary_id="{{@$category->cat_id}}" data-cat_id="{{@$sub_category->sub_cat_id}}" data-sub_id="{{@$sub_subCategory->id}}">{{@$sub_subCategory->title}} ({{@$category->sub_subcategory_count($sub_subCategory->id)}})</a></li>
                                                            @endforeach
                                                        </ul>
                                                        @endif
                                                    </li>
                                                    @php $looop--; @endphp
                                                    @if($looop == 0)
                                                    @php $looop = $count; @endphp
                                                </div>
                                                <div>
                                                    @endif
                                                    @endforeach
                                                </div>
                                            </div>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="border border-left-0 col-12 col-md-9 col-sm-8 offered-services-product p-3 p-lg-4">
                                <div class="text-right view-all-offers mb-2">
                                    <a id="view_all_{{$category->slug}}" target="_blank" href="{{url('find-car-services/'.$category->slug)}}" class="f-size font-weight-semibold themecolor view-all-offers-link">{{__('findServicePage.viewAll')}}</a>
                                </div>
                                <div class="owl-carousel owl-theme services-slider d-md-block d-none mob-view specific_spares_list_{{@$category->cat_id}}">
                                    @php
                                    $allServices = Services::where('status','1')->where('primary_service_id',$category->cat_id)->orderBy('is_featured')->get();
                                    $i = 0;
                                    @endphp
                                    <div class="item">
                                        <div class="row">
                                            @if($allServices->count() > 0)
                                            @foreach($allServices as $singleService)
                                            <div class="col-md-4 col-sm-4 offered-services-col">
                                                <figure class="align-items-center border d-flex justify-content-center mb-0 position-relative text-left">
                                                    @if(@$singleService->services_images[0]->image_name != null &&
                                                    file_exists( public_path() .
                                                    '/uploads/ad_pictures/services/'.$singleService->id.'/'.@$singleService->services_images[0]->image_name))
                                                    <img src="{{url('public/uploads/ad_pictures/services/'.$singleService->id.'/'.@$singleService->services_images[0]->image_name)}}" alt="carish used cars for sale in estonia" class="img-fluid ads_image">
                                                    @else
                                                    <img src="{{url('public/assets/img/serviceavatar.jpg')}}" alt="Service Image" class="img-fluid ads_image">
                                                    @endif

                                                </figure>
                                                <div class="p-lg-3 p-2 border border-top-0">
                                                    <h5 class="font-weight-semibold mb-2 overflow-ellipsis">
                                                        <a target="" href="{{url('service-details/'.@$singleService->id)}}" class="stretched-link">
                                                            {{@$singleService->get_service_ad_title($singleService->id,$activeLanguage['id'])->title}}
                                                        </a>
                                                    </h5>
                                                    <ul class="list-unstyled mb-0 font-weight-semibold">
                                                        <li class="align-items-baseline d-flex"><span class="mr-2"><em class="fa fa-amp-maker fa-map-marker"></em></span>
                                                            {{@$singleService->get_customer->city->name}}
                                                        </li>
                                                    </ul>
                                                </div>

                                            </div>
                                            @php $i++;
                                            @endphp
                                            @if($i == 6)
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="row">
                                            @php $i = 0;
                                            @endphp
                                            @endif
                                            @endforeach

                                            @else
                                            <div class="col-lg-12 text-center">
                                                <h5 class="" style="margin-top: 6%;">{{__('findServicePage.noRecordFound')}}
                                                </h5>
                                            </div>
                                            @endif

                                        </div>
                                    </div>

                                </div>

                                <div class="owl-carousel owl-theme services-slider d-md-none d-block mob-view specific_spares_list_2 owl-loaded owl-drag">
                                    <div class="item">
                                        <div class="row">
                                            <div class="col-12 offered-services-col">
                                                <figure class="align-items-center border d-flex justify-content-center mb-0 position-relative text-left">
                                                    <img src="http://localhost/CarishNew/public/assets/img/serviceavatar.jpg" alt="Service Image" class="img-fluid ads_image">

                                                </figure>
                                                <div class="p-lg-3 p-2 border border-top-0">
                                                    <h5 class="font-weight-semibold mb-2 overflow-ellipsis">
                                                        <a target="" href="http://localhost/CarishNew/service-details/34" class="stretched-link">
                                                            wheel sale
                                                        </a>
                                                    </h5>
                                                    <ul class="list-unstyled mb-0 font-weight-semibold">
                                                        <li class="align-items-baseline d-flex"><span class="mr-2"><em class="fa fa-amp-maker fa-map-marker"></em></span>
                                                            Tallinn
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="row">
                                            <div class="col-12 offered-services-col">
                                                <figure class="align-items-center border d-flex justify-content-center mb-0 position-relative text-left">
                                                    <img src="http://localhost/CarishNew/public/assets/img/serviceavatar.jpg" alt="Service Image" class="img-fluid ads_image">

                                                </figure>
                                                <div class="p-lg-3 p-2 border border-top-0">
                                                    <h5 class="font-weight-semibold mb-2 overflow-ellipsis">
                                                        <a target="" href="http://localhost/CarishNew/service-details/34" class="stretched-link">
                                                            wheel sale
                                                        </a>
                                                    </h5>
                                                    <ul class="list-unstyled mb-0 font-weight-semibold">
                                                        <li class="align-items-baseline d-flex"><span class="mr-2"><em class="fa fa-amp-maker fa-map-marker"></em></span>
                                                            Tallinn
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="row">
                                            <div class="col-12 offered-services-col">
                                                <figure class="align-items-center border d-flex justify-content-center mb-0 position-relative text-left">
                                                    <img src="http://localhost/CarishNew/public/assets/img/serviceavatar.jpg" alt="Service Image" class="img-fluid ads_image">

                                                </figure>
                                                <div class="p-lg-3 p-2 border border-top-0">
                                                    <h5 class="font-weight-semibold mb-2 overflow-ellipsis">
                                                        <a target="" href="http://localhost/CarishNew/service-details/34" class="stretched-link">
                                                            wheel sale
                                                        </a>
                                                    </h5>
                                                    <ul class="list-unstyled mb-0 font-weight-semibold">
                                                        <li class="align-items-baseline d-flex"><span class="mr-2"><em class="fa fa-amp-maker fa-map-marker"></em></span>
                                                            Tallinn
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- Mobile Slider 1 Ends here -->
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
    <!-- Offered Services in Estonia Ends Here -->
</div>
<!-- // -->
<!-- Loader Modal -->
<div class="modal" id="loader_modal" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <h3 style="text-align:center;">{{__('findServicePage.pleaseWait')}}</h3>
                <p style="text-align:center;"><img src="{{ asset('public/assets/img/gif/waiting.gif') }}"></p>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('.all_spares').toggle();
        $('.show_category').on('click', function() {
            var id = $(this).data('id');

            $(this).toggleClass('expand_success');
            $('#show_' + id).slideToggle("show");
        });
        $(".search_check_submit").click(function(event) {
            event.preventDefault();
            var value = $('.search_text_submit').val();
            if (value == undefined || value == '') {
                toastr.error('error!', 'Enter Something In The Search Field.', {
                    "positionClass": "toast-bottom-right"
                });
                return false;
            } else {
                var baseUrl = "{{url('/')}}";
                var datavars = [];
                $(".search_text_submit").each(function() {
                    if ($(this).val() != '') {
                        str = $(this).val()
                        datavars.push(str);
                    }
                });
                datavars = getUnique(datavars);
                var search_url = "{{url('find-car-services/')}}/" + datavars.join([separator = '/']);
                window.location.href = search_url;
            }
        });
        $("#autoPartSearch").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{route('get.services.scats')}}/",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                $("input#keyword").val("");
                var selectedValue = ui.item.id;
                $("#autopartSelected").val(selectedValue);

                $(".search_check_submit").attr("disabled", false);
            }
        });


        $('.load_offer_services').on('click', function() {

            $('.mob-view').removeClass('d-none');
            $('.mob-view').addClass('d-sm-block');
            $('.custdropdown li a').removeClass('active_lia');

            var cats = $(this).data('id').split(' ');
            var primary_id = $(this).data('primary_id');
            var cat_id = $(this).data('cat_id');
            var sub_id = $(this).data('sub_id');
            $(this).addClass('active_lia');

            cat = '';
            if (cat_id != '') {
                var cat = 'cat_' + cat_id;
            }
            scat = '';
            if (sub_id != '') {
                var scat = 'scat_' + sub_id;
            }
            var services = "{{url('find-car-services/')}}/ps_" + primary_id + '/' + cat + '/' + scat;
            $("#view_all_" + primary_id).attr("href", services);
            $.ajax({

                method: "get",
                dataType: "json",
                data: {
                    primary_id: primary_id,
                    cat_id: cat_id,
                    sub_id: sub_id
                },
                url: "{{ route('get-specific-offerservices') }}",
                beforeSend: function() {
                    Swal.fire({
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 1500,
                        width: 300,
                        height: 300,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });
                },
                success: function(result) {
                    if (result.success == true) {
                        $('.specific_spares_list_' + primary_id).html(result.html);
                        $('.specific_spares_list_' + primary_id).trigger('destroy.owl.carousel');
                        $('.specific_spares_list_' + primary_id).owlCarousel({
                            loop: !1,
                            margin: 0,
                            nav: !0,
                            responsive: {
                                0: {
                                    items: 1
                                }
                            }
                        });
                    }
                }
            });
        });
    });
</script>
@endpush
@endsection