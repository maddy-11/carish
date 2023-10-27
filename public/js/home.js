$(document).ready(function(){
	$("input#car_make_model").keyup(function(a){
		var e=$(this).val();
		$("input#keyword").val("keyword_"+e)});
		$("#car_make_model").autocomplete({
			source:function(e,a){
				$.ajax({
					url:getmakers_versions,
					dataType:"json",
					data:{term:e.term},
					success:function(e){a(e)}
				})},
				select:function(e,a){
					$("#keyword").val('');
					$("#make_models").val(a.item.id);
					var t=a.item.id,s=t.split("#")[0].split("_");
					$("#make_models_combine").val(""),
					"mo"==s[0]&&($("#make_models_combine").val(a.item.make),$("#make_models").val("mo_"+s[1])),
					$.ajax({url:get_versions+"/"+t,method:"get",success:function(e)
					{
						$("#selectVersion").html(e)
					}
					})
				}
			}),
		$("#car_make_model2").autocomplete({
			source:function(e,a){
				$.ajax({
					url:getmakers_versions,
					dataType:"json",
					data:{term:e.term},
					success:function(e){
						a(e)
					}
				})
			},
			select:function(e,a){
				var t=a.item.id;$("#make_models2").val(t);
				var s=t.split("#")[0].split("_");
				$("#make_models_combine2").val(""),
				"mo"==s[0]&&($("#make_models_combine2").val(a.item.make),$("#make_models2").val("mo_"+s[1])),
				$.ajax({
					url:get_versions+"/"+t,method:"get",
					success:function(e){
						$("#selectVersion").html(e)
					}
				})
			}
		}),
		$("header.header").addClass("home-header"),
		$(".selectCity").select2({
			ajax:{
				url:get_cities,
				dataType:"json",
				delay:250,
				processResults:function(e){
					return{results:e}
				},
				cache:!0},
				theme:"bootstrap4",
				width:"style",
				placeholder:"{{ __('home.registeredinanycity') }}",
				allowClear:Boolean($(this).data("allow-clear"))}),
		$("#selectCityReg").select2({
			ajax:{
				url:selectCityReg,
				dataType:"json",
				delay:250,
				processResults:function(e){
					return{results:e}
				},
				cache:!0
			},
				theme:"bootstrap4",
				width:"style",
				placeholder:$(this).attr("placeholder"),
				allowClear:Boolean($(this).data("allow-clear"))
			}),
		$(document).on("click","#search_btn",function(){
			""==$("#make_models").val()?$("#make_models").attr("name",""):$("#car_make_model").attr("name",""),
			$("#simple_search").submit()}),
		$("#selectVersion_old").select2({
			ajax:{
				url:get_versions,
				dataType:"json",
				delay:250,
				processResults:function(e){
					return{results:e}
				},
					cache:!0},
					theme:"bootstrap4",
					width:"style",
					placeholder:$(this).attr("placeholder"),
					allowClear:Boolean($(this).data("allow-clear"))
			}),
		$("#color").select2({
			ajax:{
				url:get_colors,
				dataType:"json",
				delay:250,
				processResults:function(e){
					return{results:e}
				},
				cache:!0
			},
				theme:"bootstrap4",
				width:"style",
				placeholder:$(this).attr("placeholder"),
				allowClear:Boolean($(this).data("allow-clear"))
			}),
		$(".advanced_search_btn").on("click",function(){
			$.ajax({
				url:getcc_versions,
				method:"get",
				success:function(e){
					$("#engineccFrom").append(e),
					$("#engineccTo").append(e)}}),
			$.ajax({
				url:getkw_versions,
				method:"get",
				success:function(e){
					$("#powerFrom").append(e),
					$("#powerTo").append(e)}}),
			$.ajax({
				url:getbody_types,
				method:"get",
				success:function(e){
					$("#body_type").append(e)
				}
			})
		}),
		$.ajax({
			url:get_ads_compared,
			method:"get",
			success:function(e){
				var a="",t="";
				"string"!=typeof e?($.each(e,function(e,s){
					a+='<div class="align-items-center media mb-3">',
					a+='<img class="mr-3 saved-adImg" src="'+s.image+'" alt="Generic placeholder image"><div class="media-body"><h5 class="mb-0"> <a href="JavaScript:void(0);" class="themecolor select-for-compare1" data-value="'+s.ads_id+'" data-text="'+s.make_name+" "+s.model_name+" "+s.version_label+"CC "+s.engine_power+"KW "+s.from_date+"-"+s.to_date+'">'+s.make_name+" "+s.model_name+" "+s.version_label+"CC "+s.engine_power+"KW "+s.from_date+"-"+s.to_date+"</a></h5></div></div>",t+='<div class="align-items-center media mb-3">',
					t+='<img class="mr-3 saved-adImg" src="'+s.image+'" alt="Generic placeholder image"><div class="media-body"><h5 class="mb-0"> <a href="JavaScript:void(0);" class="themecolor select-for-compare2" data-value="'+s.ads_id+'" data-text="'+s.make_name+" "+s.model_name+" "+s.version_label+"CC "+s.engine_power+"KW "+s.from_date+"-"+s.to_date+'">'+s.make_name+" "+s.model_name+" "+s.version_label+"CC "+s.engine_power+"KW "+s.from_date+"-"+s.to_date+"</a></h5></div></div>"
				}),
			$(".saved-cars1").html(a),
			$(".saved-cars2").html(t)):($(".saved-cars1").html(e),
			$(".saved-cars2").html(e))
			}
		}),
		$(".search_check_submit").click(function(e){
			e.preventDefault&&e.preventDefault();
			var a=[];
			$("input.search_check_submit:checkbox:checked").each(function(){
			var e=$(this).data("value");
			a.push(e)
			}),
			$(".search_text_submit").each(function(){
			""!=$(this).val()&&(str=$(this).val(),a.push(str))
			}),
			$(".search_selectbox_submit option:selected").each(function(){
			""!=$(this).val()&&(str=$(this).val(),a.push(str))
			});
			var t=$("#minPrice").val(),s=$("#maxPrice").val();
			if(""!=t||""!=s){
				if(""!=t)t=parseInt(t.replace(/\D/g,""));
				if(""!=s)s=parseInt(s.replace(/\D/g,""));
				var l="price_"+t+"-"+s;a.push(l)
			}
			var o=$("#fromMillage").val(),c=$("#toMillage").val();
			if(""!=o||""!=c){
				var i="millage_"+o+"-"+c;a.push(i)
			}
			var r=$("#powerFrom option:selected").val(),d=$("#powerTo option:selected").val();
			if(""!=r||""!=d){
				var n="power_"+r+"-"+d;
				a.push(n)
			}
			var m=$("#engineccFrom option:selected").val(),v=$("#engineccTo option:selected").val();
			if(""!=m||""!=v){
				var u="enginecc_"+m+"-"+v;a.push(u)
			}
			var _=$("#yearFrom option:selected").val(),h=$("#yearTo option:selected").val();
			if(""!=_||""!=h){
				var p="year_"+_+"-"+h;
				a.push(p)
			}
			var f=$("#tags").val();
			if(Array.isArray(f)&&f.length>0&&null!=f[0])for(var g=0;g<f.length;g++)a.push(f[g]);
			if(a=a.filter(Boolean),a=getUnique(a),Array.isArray(a)&&a.length>0&&null!=a[0]){
				var b=baseUrl+"/find-used-cars/"+a.join([separator="/"]);
				window.location.href=b
			}
	}),
	$(document).on("click","#ads_first_text",function(){
		var e=$("#ads_second").val();
		$.ajax({
			url:get_ads_compared,
			method:"get",
			data:{
				excludedAd:e
			},
			success:function(e){
				var a="";
				"string"!=typeof e?($.each(e,function(e,t){
					a+='<div class="align-items-center media mb-3"><img class="mr-3 saved-adImg" src="'+t.image+'" alt="Generic placeholder image"><div class="media-body"><h5 class="mb-0"> <a href="JavaScript:void(0);" class="themecolor select-for-compare1" data-value="'+t.ads_id+'" data-text="'+t.make_name+" "+t.model_name+" "+t.from_date+"-"+t.to_date+" "+t.version_label+" CC "+t.engine_power+' KW">'+t.make_name+" "+t.model_name+" "+t.from_date+"-"+t.to_date+" "+t.version_label+" CC "+t.engine_power+" KW</a></h5></div></div>"
					}),
					$(".saved-cars1").html(a)):$(".saved-cars1").html(e)
			},
			beforeSend:function(){
					$(".saved-cars1").html("loading data ..."),
					$("#savedCarAd").modal("show")
				}
			})
	}),
	$(document).on("click","#ads_second_text",function(){
		var e=$("#ads_first").val();
		$.ajax({
			url:get_ads_compared,
			method:"get",
			dataType:"json",
			data:{excludedAd:e
			},
			success:function(e){
				var a="";
				"string"!=typeof e?($.each(e,function(e,t){
					a+='<div class="align-items-center media mb-3"><img class="mr-3 saved-adImg" src="'+t.image+'" alt="Generic placeholder image"><div class="media-body"><h5 class="mb-0"> <a href="JavaScript:void(0);" class="themecolor select-for-compare2" data-value="'+t.ads_id+'" data-text="'+t.make_name+" "+t.model_name+" "+t.from_date+"-"+t.to_date+" "+t.version_label+" CC "+t.engine_power+' KW">'+t.make_name+" "+t.model_name+" "+t.from_date+"-"+t.to_date+" "+t.version_label+" CC "+t.engine_power+" KW</a></h5></div></div>"
				}),
				$(".saved-cars2").html(a)):$(".saved-cars2").html(e)},beforeSend:function(){
					$(".saved-cars2").html("loading data ..."),$("#savedCarAd2").modal("show")}
				})
	}),
	$(document).on("click",".select-for-compare1",function(){
		var e=$(this).data("value"),a=$(this).data("text");
		$("#ads_first").val(e),$("#ads_first_text").val(a),
		$("#savedCarAd").modal("hide")
	}),
	$(document).on("click",".select-for-compare2",function(){
		var e=$(this).data("value"),a=$(this).data("text");
		$("#ads_second").val(e),$("#ads_second_text").val(a),$("#savedCarAd2").modal("hide")
	}),
	$(document).on("click",".compare_btn",function(){
		$("#compare_form").submit()
	}),
	$(document).on("click",".clear_compare",function(){
			$("#ads_first_text").val(""),
			$("#ads_second_text").val(""),
			$("#ads_first").val(""),
			$("#ads_second").val("")
	}),
	$.ajax({
			url:categoryMakeModels,
			method:"get",
			dataType:"json",
			success:function(e){
				$("#buCars-tab1").html('<div class="owl-carousel owl-theme text-center" id="browse-cb-make">');
				var a='<div class="item"><div class="row">',
					t=0;
					$.each(e.data,function(e,s){
						a+='<div class="col-lg-2 col-md-3 col-sm-3 col-3 bucSliderCol mb-2"><figure class="align-items-center d-flex justify-content-center"><img src="'+imagespath+"/"+s.make.image+'" class="img-fluid" alt="carish used cars for sale in estonia"></figure><h5 class="font-weight-normal"><a target="" href="'+searchUrl+"/used-car-for-sale/mk_"+s.make.title+'" class="stretched-link">'+s.make.title+"</a></h5></div>",
					12==++t && (t=0, a+='</div></div><div class="item"><div class="row">')
				}),
				a+="</div></div>",
				$("#browse-cb-make").append(a),
				$("#browse-cb-make").owlCarousel({
					loop:!1,margin:15,nav:!0,
					itemsMobile: [500, 1],
					responsive:{0:{items:1}}
				}),
				$("#buCars-tab2").html('<div class="owl-carousel bucSlider btSlider text-center" id="model_slider">');a='<div class="item"><div class="row">';var s=0;$.each(e.cities,function(e,t){a+='<div class="col-lg-2 col-md-2 col-sm-3 col-4 mb-md-4 mb-3 bucModalCol"><a target="" href="'+searchUrl+"/used-car-for-sale/ct_"+t.name+'">'+t.name+"</a></div>",30==++s&&(a+='</div></div><div class="item"><div class="row">',s=0)}),
				a+="</div></div>",
				$("#model_slider").append(a),
				$("#model_slider").owlCarousel({loop:!1,margin:15,nav:!0,responsive:{0:{items:1}}
			}
		)}
	}),
	$.ajax({url:fetchBodyTypes,method:"get",success:function(e){
		$("#buCars-tab3").html('<div class="owl-carousel owl-theme bucSlider btSlider text-center" id="body_types"></div>');
		var a='<div class="item"><div class="row">',
		t=0;$.each(e.data,function(e,s){
			a+='<div class="col-lg-3 col-md-3 col-sm-3 col-4 bucSliderCol mb-4"><figure class="align-items-center d-flex justify-content-center"><img src="'+imagespath+"/"+s.image+'" class="img-fluid" alt="carish used cars for sale in estonia"></figure> <h5 class="font-weight-normal"><a target="" href="'+searchUrl+"/used-car-for-sale/bt_"+s.name+'">'+s.name+"</a></h5></div>",8==++t&&(a+='</div></div><div class="item"><div class="row">',t=0)
		}),
		a+="</div></div>",$("#body_types").append(a),
		$("#body_types").owlCarousel({
			loop:!1,margin:15,nav:!0,responsive:{0:{items:1}}}
			)}
	})
});