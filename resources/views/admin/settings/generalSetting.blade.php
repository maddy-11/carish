@extends('admin.layouts.app')

@section('content')
<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">
	<div class="d-md-none h-search-col search-col col-12 collapse" id="searchsection">
		<div class="input-group custom-input-group mb-3">
			<input type="text" class="form-control" placeholder="Search">
			<div class="align-items-center input-group-prepend">
				<span class="input-group-text fa fa-search"></span>
			</div>
		</div>
	</div>
	<div class="col-lg-8 col-md-7 col-sm-7  title-col">
		<h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">General Settings</h3>
	</div>
	<div class="col-lg-4 col-md-5 col-sm-5 search-col text-right"></div>
</div>

<h5 style="color: red;">Note : Double Click to edit setting</h5>
<div class="row">
	<div class="col-12 col-md-6 dr-personal-prof mb-4">
		<div class="bg-white custompadding customborder h d-flex flex-column">
			<div class="section-header">
				<div class="row">
					<div class="col">
						<h3 class="mb-1 text-capitalize">Logo Setting</h3>
					</div>
					<div class="col">
						<a href="{{url('admin/edit/general-settings')}}" class="btn btn-success pull-right">Edit</a>
					</div>
				</div>

			</div>
			<div class="row">
				<div class="col-sm-4 col-3 personal-profile pr-0 pr-sm-3">
					<h6 class="text-capitalize font-weight-bold mb-1">Active Logo:</h6>
					@if($settings == '')
					<img src="https://summer.pes.edu/wp-content/uploads/2019/02/default-2.jpg" id="faviconshow" style="width: 100px;height: 100px" />
					@else
					<img src="{{url('public/uploads/'.$settings->logo)}}" id="blah" style="width: 100px;height: 100px" />
					@endif
				</div>
				<div class="col-sm-4 col-3 personal-profile pr-0 pr-sm-3">
					<h6 class="text-capitalize font-weight-bold mb-1">Active Small Logo:</h6>
					@if($settings == '')
					<img src="https://summer.pes.edu/wp-content/uploads/2019/02/default-2.jpg" id="faviconshow" style="width: 100px;height: 100px" />
					@else
					<img src="{{url('public/uploads/'.$settings->small_logo)}}" id="imgshow" style="width: 100px;height: 100px" />
					@endif
				</div>
				<div class="col-sm-4 col-3 personal-profile pr-0 pr-sm-3">
					<h6 class="text-capitalize font-weight-bold mb-1">Active Favicon:</h6>
					@if($settings == '')
					<img src="https://summer.pes.edu/wp-content/uploads/2019/02/default-2.jpg" id="faviconshow" style="width: 100px;height: 100px" />
					@else
					<img src="{{url('public/uploads/'.$settings->favicon)}}" id="faviconshow" style="width: 100px;height: 100px" />
					@endif
				</div>
			</div>
		</div>

		<div class="bg-white custompadding customborder h d-flex flex-column mt-4">
			<div class="section-header">
				<h3 class="mb-1 text-capitalize">Footer Section</h3>
			</div>
			<div class="row">
				<div class="col-6">
					<h6 class="text-capitalize font-weight-bold mb-1">Facebook Link:</h6>
					<p class="mb-0">
						<span class="m-l-15 inputDoubleClick" id="facebook_link" data-fieldvalue="{{@$settings->facebook_link}}">
							{{@$settings->facebook_link !== null ? @$settings->facebook_link : '--'}}
						</span>
						<input type="text" name="facebook_link" class="d-none fieldFocus" id="" value="{{(@$settings->facebook_link !=null ) ? $settings->facebook_link : ''}}">
					</p>
					<br>

					<h6 class="text-capitalize font-weight-bold mb-1">Twitter Link:</h6>
					<p class="mb-0">
						<span class="m-l-15 inputDoubleClick" id="twitter_link" data-fieldvalue="{{@$settings->twitter_link}}">
							{{@$settings->twitter_link !== null ? @$settings->twitter_link : '--'}}
						</span>
						<input type="text" name="twitter_link" class="d-none fieldFocus" id="" value="{{(@$settings->twitter_link !=null ) ? $settings->twitter_link : ''}}">
					</p>


				</div>

				<div class="col-6">

					<h6 class="text-capitalize font-weight-bold mb-1">Linkedin Link:</h6>
					<p class="mb-0">
						<span class="m-l-15 inputDoubleClick" id="linkedin_link" data-fieldvalue="{{@$settings->linkedin_link}}">
							{{@$settings->linkedin_link !== null ? @$settings->linkedin_link : '--'}}
						</span>
						<input type="text" name="linkedin_link" class="d-none fieldFocus" id="" value="{{(@$settings->linkedin_link !=null ) ? $settings->linkedin_link : ''}}">
					</p>
					<br>

					<h6 class="text-capitalize font-weight-bold mb-1">instragram Link:</h6>
					<p class="mb-0">
						<span class="m-l-15 inputDoubleClick" id="instagram_link" data-fieldvalue="{{@$settings->instagram_link}}">
							{{@$settings->instagram_link !== null ? @$settings->instagram_link : '--'}}
						</span>
						<input type="text" name="instagram_link" class="d-none fieldFocus" id="" value="{{(@$settings->instagram_link !=null ) ? $settings->instagram_link : ''}}">
					</p>
					<br>

				</div>
			</div>
		</div>

		<div class="bg-white custompadding customborder h d-flex flex-column mt-4">
			<div class="section-header">
				<h3 class="mb-1 text-capitalize">Invoice Setting</h3>
			</div>
			<div class="row">
				<div class="col-6">
					<h6 class="text-capitalize font-weight-bold mb-1">Bank Accounts:</h6>
					@if($settings == '')
					@else
					<p class="mb-0">
						<span class="m-l-15 inputDoubleClick" id="bank_detail" data-fieldvalue="{{@$settings->bank_detail}}">
							{!!nl2br(e(@$settings->bank_detail)) !== null ? nl2br(e(@$settings->bank_detail)) : '--'!!}
						</span>
						<textarea name="bank_detail" class="d-none fieldFocus" rows="7" cols="50">{!! nl2br(e(@$settings->bank_detail)) != null ? nl2br(e(@$settings->bank_detail)) : ' ' !!}</textarea>
					</p>
					@endif
					<br>
				</div>



				<div class="col-6">
							<h6 class="text-capitalize font-weight-bold mb-1">Invocie Expiry Days :</h6>
							<p class="mb-0">
								<span class="m-l-15 inputDoubleClick" id="invoice_expiry_days" data-fieldvalue="{{@$settings->invoice_expiry_days}}">
									{{$settings->invoice_expiry_days !== null ? $settings->invoice_expiry_days : '--'}}
								</span>

								<input type="number" name="invoice_expiry_days" class="d-none fieldFocus" value="{{@$settings->invoice_expiry_days}}">
							</p>
						</div>

			</div>
		</div>


	</div>

	<div class="col-12 col-md-6 dr-personal-prof mb-4 ">
		<div class="bg-white customborder custompadding d-flex flex-column">
			<div class="section-header">
				<h3 class="mb-1 text-capitalize">Website Details</h3>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<h6 class="text-capitalize font-weight-bold mb-1">Title:</h6>
					@if($settings == '')
					@else
					<p class="mb-0">
						<span class="m-l-15 inputDoubleClick" id="title" data-fieldvalue="{{@$settings->title}}">
							{{$settings->title != null ? $settings->title : '--'}}
						</span>

						<input type="text" name="title" class="d-none fieldFocus" value="{{@$settings->title}}">
					</p>
					@endif
					<br>
					<h6 class="text-capitalize font-weight-bold mb-1">Business Name:</h6>
					@if($settings == '')
					@else
					<p class="mb-0">
						<span class="m-l-15 inputDoubleClick" id="business_name" data-fieldvalue="{{@$settings->business_name}}">
							{{$settings->business_name != null ? $settings->business_name : '--'}}
						</span>

						<input type="text" name="business_name" class="d-none fieldFocus" value="{{@$settings->business_name}}">
					</p>
					@endif
					<br>
					<h6 class="text-capitalize font-weight-bold mb-1">Website Link:</h6>
					@if($settings == '')
					@else
					<p class="mb-0">
						<span class="m-l-15 inputDoubleClick" id="website_link" data-fieldvalue="{{@$settings->website_link}}">
							{{$settings->website_link != null ? $settings->website_link : '--'}}
						</span>

						<input type="text" name="website_link" class="d-none fieldFocus" value="{{@$settings->website_link}}">
					</p>
					@endif
					<br>
					<h6 class="text-capitalize font-weight-bold mb-1">Registry Number:</h6>
					@if($settings == '')
					@else
					<p class="mb-0">
						<span class="m-l-15 inputDoubleClick" id="registry_number" data-fieldvalue="{{@$settings->registry_number}}">
							{{$settings->registry_number != null ? $settings->registry_number : '--'}}
						</span>

						<input type="text" name="registry_number" class="d-none fieldFocus" value="{{@$settings->registry_number}}">
					</p>
					@endif
					<br>
					<h6 class="text-capitalize font-weight-bold mb-1">Default Language:</h6>
					@if($settings == '')
					@else
					<p class="mb-0">{{$settings->default_language != null ? $settings->default_language : '--'}}</p>
					@endif
					<br>
					<h6 class="text-capitalize font-weight-bold mb-1">Business E-mail:</h6>
					@if($settings == '')
					@else
					<p class="mb-0">
						<span class="m-l-15 inputDoubleClick" id="business_email" data-fieldvalue="{{@$settings->business_email}}">
							{{$settings->business_email != null ? $settings->business_email : '--'}}
						</span>

						<input type="text" name="business_email" class="d-none fieldFocus" value="{{@$settings->business_email}}">
					</p>
					@endif



				</div>
				<div class="col-sm-6">

					<h6 class="text-capitalize font-weight-bold mb-1">Carish Fax:</h6>
					@if($settings == '')
					@else
					<p class="mb-0">
						<span class="m-l-15 inputDoubleClick" id="fax" data-fieldvalue="{{@$settings->fax}}">
							{{$settings->fax != null ? $settings->fax : '--'}}
						</span>

						<input type="text" name="fax" class="d-none fieldFocus" value="{{@$settings->fax}}">
					</p>
					@endif
					<br>

					<h6 class="text-capitalize font-weight-bold mb-1">Phone Number:</h6>
					@if($settings == '')
					@else
					<p class="mb-0">
						<span class="m-l-15 inputDoubleClick" id="phone_number" data-fieldvalue="{{@$settings->phone_number}}">
							{{$settings->phone_number != null ? $settings->phone_number : '--'}}
						</span>

						<input type="text" name="phone_number" class="d-none fieldFocus" value="{{@$settings->phone_number}}">
					</p>
					@endif
					<br>
					<h6 class="text-capitalize font-weight-bold mb-1">Site Address:</h6>
					@if($settings == '')
					@else
					<p class="mb-0">
						<span class="m-l-15 inputDoubleClick" id="address" data-fieldvalue="{{@$settings->address}}">
							{{$settings->address != null ? $settings->address : '--'}}
						</span>

						<input type="text" name="address" class="d-none fieldFocus" value="{{@$settings->address}}">
					</p>
					@endif
					<br>
					<h6 class="text-capitalize font-weight-bold mb-1">Site Other Info:</h6>
					@if($settings == '')
					@else
					<p class="mb-0">
						<span class="m-l-15 inputDoubleClick" id="other_info" data-fieldvalue="{{@$settings->other_info}}">
							{{$settings->other_info != null ? $settings->other_info : '--'}}
						</span>

						<input type="text" name="other_info" class="d-none fieldFocus" value="{{@$settings->other_info}}">
					</p>
					@endif
					<br>
					<h6 class="text-capitalize font-weight-bold mb-1">Complaint E-mail:</h6>
					@if($settings == '')
					@else
					<p class="mb-0">
						<span class="m-l-15 inputDoubleClick" id="complaint_email" data-fieldvalue="{{@$settings->complaint_email}}">
							{{$settings->complaint_email != null ? $settings->complaint_email : '--'}}
						</span>

						<input type="text" name="complaint_email" class="d-none fieldFocus" value="{{@$settings->complaint_email}}">
					</p>
					@endif



				</div>

				
			</div>

		</div>

		<div class="bg-white custompadding customborder h d-flex flex-column mt-4">
			<div class="section-header">
				<h3 class="mb-1 text-capitalize">Ads Settings</h3>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="row">
						<div class="col-6">
							<h6 class="text-capitalize font-weight-bold mb-1">Ads Limit For Individual User:</h6>
							<p class="mb-0">
								<span class="m-l-15 inputDoubleClick" id="ads_limit" data-fieldvalue="{{@$settings->ads_limit}}">
									{{$settings->ads_limit !== null ? $settings->ads_limit : '--'}}
								</span>

								<input type="number" name="ads_limit" class="d-none fieldFocus" value="{{@$settings->ads_limit}}">
							</p>
						</div>
						<div class="col-6">
							<h6 class="text-capitalize font-weight-bold mb-1">Spare Parts Limit For Individual User:</h6>
							<p class="mb-0">
								<span class="m-l-15 inputDoubleClick" id="spare_parts_limit" data-fieldvalue="{{@$settings->spare_parts_limit}}">
									{{$settings->spare_parts_limit !== null ? $settings->spare_parts_limit : '--'}}
								</span>

								<input type="number" name="spare_parts_limit" class="d-none fieldFocus" value="{{@$settings->spare_parts_limit}}">
							</p>
						</div>

						<div class="col-6">
							<h6 class="text-capitalize font-weight-bold mb-1">Ads Limit For Business User:</h6>
							<p class="mb-0">
								<span class="m-l-15 inputDoubleClick" id="b_ads_limit" data-fieldvalue="{{@$settings->b_ads_limit}}">
									{{$settings->b_ads_limit !== null ? $settings->b_ads_limit : '--'}}
								</span>

								<input type="number" name="b_ads_limit" class="d-none fieldFocus" value="{{@$settings->b_ads_limit}}">
							</p>
						</div>
						<div class="col-6">
							<h6 class="text-capitalize font-weight-bold mb-1">Spare Parts Limit For Business User:</h6>
							<p class="mb-0">
								<span class="m-l-15 inputDoubleClick" id="spare_parts_limit" data-fieldvalue="{{@$settings->b_spare_parts_limit}}">
									{{$settings->b_spare_parts_limit !== null ? $settings->b_spare_parts_limit : '--'}}
								</span>

								<input type="number" name="b_spare_parts_limit" class="d-none fieldFocus" value="{{@$settings->b_spare_parts_limit}}">
							</p>
						</div>
						<div class="col-6">
							<h6 class="text-capitalize font-weight-bold mb-1">Offer Service Limit For Business User:</h6>
							<p class="mb-0">
								<span class="m-l-15 inputDoubleClick" id="b_service_limit" data-fieldvalue="{{@$settings->b_service_limit}}">
									{{$settings->b_service_limit !== null ? $settings->b_service_limit : '--'}}
								</span>

								<input type="number" name="b_service_limit" class="d-none fieldFocus" value="{{@$settings->b_service_limit}}">
							</p>
						</div>
						<div class="col-6">
							<h6 class="text-capitalize font-weight-bold mb-1"></h6>
							<p class="mb-0"></p>
						</div>
						
						<div class="col-6">
							<h6 class="text-capitalize font-weight-bold mb-1">Show Ads Per page:</h6>
							<p class="mb-0">
								<span class="m-l-15 inputDoubleClick" id="perpage_ads" data-fieldvalue="{{@$settings->perpage_ads}}">
									{{$settings->perpage_ads !== null ? $settings->perpage_ads : '--'}}
								</span>

								<input type="number" name="perpage_ads" class="d-none fieldFocus" value="{{@$settings->perpage_ads}}">
							</p>
						</div>
						<div class="col-6">
							<h6 class="text-capitalize font-weight-bold mb-1">Show Spare Parts Per page:</h6>
							<p class="mb-0">
								<span class="m-l-15 inputDoubleClick" id="perpage_spareparts" data-fieldvalue="{{@$settings->perpage_spareparts}}">
									{{$settings->perpage_spareparts !== null ? $settings->perpage_spareparts : '--'}}
								</span>

								<input type="number" name="perpage_spareparts" class="d-none fieldFocus" value="{{@$settings->perpage_spareparts}}">
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@push('custom-scripts')
<script type="text/javascript">
	// to make fields double click editable
	$(document).on("dblclick", ".inputDoubleClick", function() {
		$x = $(this);
		$(this).addClass('d-none');
		$(this).after('<span class="spinner"><i class="fa fa-spinner"></i></span>');

		setTimeout(function() {

			$('.spinner').remove();
			$x.next().removeClass('d-none');
			$x.next().addClass('active');
			$x.next().focus();
			var num = $x.next().val();
			$x.next().focus().val('').val(num);
		}, 300);

	});

	$(document).on('keypress keyup focusout', '.fieldFocus', function(e) {

		var old_value = $(this).prev().data('fieldvalue');
		if (e.keyCode === 27 && $(this).hasClass('active')) {
			var fieldvalue = $(this).prev().data('fieldvalue');
			var thisPointer = $(this);
			thisPointer.addClass('d-none');

			thisPointer.val(fieldvalue);
			thisPointer.removeClass('active');
			thisPointer.prev().removeClass('d-none');
		}

		var fieldvalue = $(this).prev().data('fieldvalue');
		var old_value = $(this).prev().data('fieldvalue');
		var new_value = $(this).val();

		if ((e.keyCode === 13 || e.which === 0) && $(this).hasClass('active')) {

			if ($(this).val().length < 1) {
				toastr.error('Warning!', 'Please Enter Atleast 1 Character.', {
					"positionClass": "toast-bottom-right"
				});
				return false;
			}

			if ($(this).val().length < 1) {
				return false;
			} else if (fieldvalue == new_value) {
				var thisPointer = $(this);
				thisPointer.addClass('d-none');

				thisPointer.removeClass('active');
				thisPointer.prev().removeClass('d-none');
			} else {
				var thisPointer = $(this);
				thisPointer.addClass('d-none');

				thisPointer.removeClass('active');
				thisPointer.prev().removeClass('d-none');
				if (new_value != '') {
					$(this).prev().removeData('fieldvalue');
					$(this).prev().data('fieldvalue', new_value);
					$(this).attr('value', new_value);
					$(this).prev().html(new_value);
				}
				saveGeneralSetting(thisPointer, thisPointer.attr('name'), thisPointer.val(), old_value);
			}

		}
	});

	function saveGeneralSetting(thisPointer, field_name, field_value, old_value) {
		console.log(thisPointer + ' ' + ' ' + field_name + ' ' + field_value + ' ' + old_value);
		var setting_id = "{{$settings->id}}";
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		});
		$.ajax({
			method: "post",
			url: "{{ url('save-general-setting-data') }}",
			dataType: 'json',
			// data: {field_name:field_name,field_value:field_value,prod_detail_id:prod_detail_id},
			data: 'setting_id=' + setting_id + '&' + field_name + '=' + field_value + '&' + 'old_value' + '=' + old_value,
			beforeSend: function() {
				$('#loader_modal').modal({
					backdrop: 'static',
					keyboard: false
				});
				$("#loader_modal").modal('show');
			},
			success: function(data) {

				$("#loader_modal").modal('hide');
				if (field_name == "facebook_link") {
					$("#facebook_link").html(data.facebook_link);
				}

				toastr.success('Success!', 'Information updated successfully.', {
					"positionClass": "toast-bottom-right"
				});
				window.location.reload();
			},

		});
	}
</script>
@endpush


@endsection