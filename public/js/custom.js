var full_path = $("#site_url").val() + "/";
function getUnique(e) {
    var i = [];
    for (var s of e) -1 === i.indexOf(s) && i.push(s);
    return i;
}
$(".bucSlider").owlCarousel({ loop: !1, margin: 0, nav: !0, responsive: { 0: { items: 1 } } }),
    $(".services-slider").owlCarousel({ loop: !1, margin: 0, nav: !0, responsive: { 0: { items: 1 } } }),
    $("#mob-services-slider-1, #mob-services-slider-2, #mob-services-slider-3, #mob-services-slider-4, #mob-services-slider-5, #mob-services-slider-6, #mob-services-slider-7").owlCarousel({
        loop: !1,
        margin: 0,
        nav: !0,
        responsive: { 0: { items: 1 }, 480: { items: 2 } },
    }),
    $("#feat-UsedCars, #pop-UsedCars").owlCarousel({ loop: !1, margin: 20, nav: !0, responsive: { 0: { items: 1 }, 768: { items: 3 }, 992: { items: 4 } } }),
    $("#cars-parts").owlCarousel({ loop: !1, margin: 30, nav: !0, responsive: { 0: { items: 1 }, 768: { items: 3 }, 992: { items: 4 } } }),
    $("#offered-service").owlCarousel({ loop: !1, margin: 30, nav: !0, responsive: { 0: { items: 1 }, 768: { items: 3 }, 992: { items: 4 } } }),
    $("#browse-cb-categ").owlCarousel({ loop: !1, margin: 15, nav: !0, responsive: { 0: { items: 2 }, 570: { items: 3 }, 768: { items: 3 }, 992: { items: 5 } } }),
    $("#browse-cb-make").owlCarousel({ loop: !1, margin: 15, nav: !0, responsive: { 0: { items: 1 } } }),
    $(".gridIcon").on("click", function () {
        $(".listingtab").addClass("gridingCol"),
            $("this").addClass("active"),
            $(".listIcon").removeClass("active"),
            $(".gridListprice").addClass("d-flex mb-2").removeClass("d-none mb-3"),
            $(".listingCar-place .negotiable, .listingCar-title .lcPrice").hide();
    }),
    $(".listIcon").on("click", function () {
        $(".listingtab").removeClass("gridingCol"),
            $(this).addClass("active"),
            $(".gridIcon").removeClass("active"),
            $(".gridListprice").removeClass("d-flex mb-2").addClass("d-none mb-3"),
            $(".listingCar-place .negotiable, .listingCar-title .lcPrice").show();
    }),
    $(".filterDown").on("click", function () {
        $(".filterDown em").hasClass("fa-chevron-circle-down")
            ? $(".filterDown em").addClass("fa-chevron-circle-down").removeClass("fa-chevron-circle-up")
            : $(".filterDown em").addClass("fa-chevron-circle-up").removeClass("fa-chevron-circle-down"),
            $("#searchResultFilter").slideToggle();
    }),
    $(".searchcol, .searchsubmit").on("click", function () {
        $(".selectCol").removeClass("selectfieldcol"), $(".advSearchCol").removeClass("adActive");
    }),
    $(".show-more-cities").on("click", function () {
        $("#search-by-city-list").toggleClass("searchmorecity");
    }),
    $(".message-title").on("click", function () {
        var e = $(this).data("chat_id");
        $.ajax({ method: "get", dataType: "json", data: { chat_id: e }, url: full_path + "user/make-msgs-unread", success: function (e) { } }), $(".messages-col_" + e).show();
    }),
    $(".version-listings li").on("click", function () {
        $(".addInformation").show(), $(".postformmodal").modal("hide");
    }),
    $("#minPrice").on("keyup", function () {
        var e = $("#minPrice").val();
        "" == $(this).val()
            ? $(".pr-range-min").html("0 EUR")
            : ($(".pr-range-min")
                .html(e + " EUR")
                .show(),
                $(".select-prng").hide());
    }),
    $("#maxPrice").on("keyup", function () {
        var e = $("#maxPrice").val();
        "" == $(this).val()
            ? $(".pr-range-max").html("0 EUR")
            : ($(".pr-range-max")
                .html(e + " EUR")
                .show(),
                $(".select-prng").hide());
    }),
    $("#minPrice").on("click", function () {
        $(".min-price-list").show(), $(".max-price-list").hide();
    }),
    $("#maxPrice").on("click", function () {
        $(".min-price-list").hide(), $(".max-price-list").show();
    }),
    $(document).on("click", ".min-price-list li", function () {
        $(this).parents(".min-price-list").hide(), $(".max-price-list").show(), $(".select-prng").hide();
        var e = $(this).text(),
            i = e.replace(/\D/g, "");
        "" != (s = $("#maxPrice").val()) && (i = s = parseInt(s.replace(/\D/g, "")));
        $("#minPrice").val(e), $(".pr-range-min").html(e).show();
        var s = +i + 30;
        i = parseInt(i);
        $(".max-price-list").html("<li>500 EUR</li><li>1000 EUR</li><li>2000 EUR</li><li>3000 EUR</li><li>5000 EUR</li><li>10000 EUR</li>");
    }),
    $(document).on("change", "#minPrice", function () {
        var e = $("#minPrice option:selected").text(),
            i = e.replace(/\D/g, "");
        if ("" != (s = $("#maxPrice option:selected").val())) {
            var s = $("#maxPrice option:selected").text();
            i = s = parseInt(s.replace(/\D/g, ""));
        }
        $("#minPrice option:selected").val(e);
        s = +i + 30;
        i = parseInt(i);
        $("#maxPrice").html(
            '<option value="">To</option><option value="500">500 EUR</option><option value="1000">1000 EUR</option><option value="2000">2000 EUR</option><option value="3000">3000 EUR</option><option value="5000">5000 EUR</option><option value="10000">10000 EUR</option>'
        );
    }),
    $(document).on("click", ".max-price-list li", function () {
        $(".select-prng, .pr-dropdown").hide(), $(this).parents(".max-price-list").hide();
        var e = $(this).text();
        $("#maxPrice").val(e), $(".pr-range-dash").show(), $(".pr-range-max").html(e).show();
    }),
    $(".pricerange").on("click", function () {
        $(".pr-dropdown").toggle(), $(".min-price-list").show();
    }),
    $(document).mouseup(function (e) {
        var i = $(".pr-dropdown-cls");
        i.is(e.target) || 0 !== i.has(e.target).length || i.hide();
    }),
    $(".mileagerange").on("click", function () {
        $(".pr-dropdown-mileage").toggle(), $(".min-mileage-list").show();
    }),
    $(document).on("click", ".min-mileage-list li", function () {
        $(this).parents(".min-mileage-list").hide(), $(".max-mileage-list").show(), $(".select-prng-mileage").hide();
        var e,
            i = $(this).attr("data-id"),
            s = i.replace(/\D/g, "");
        "" != (l = $("#toMillage").val()) && (s = l = parseInt(l.replace(/\D/g, "")));
        $("#fromMillage").val(i),
            $(".pr-mileage-min")
                .html(i + " Km")
                .show();
        var l = +s + 30;
        s = parseInt(s);
        var a = "",
            o = 1e4;
        for (e = 1; e <= 14; e++) (a += "<li data-id=" + o + ">" + o + " Km</li>"), (o += 1e4);
        $(".max-mileage-list").html(a);
    }),
    $(document).on("click", ".max-mileage-list li", function () {
        $(".select-prng-mileage, .pr-dropdown-mileage").hide(), $(this).parents(".max-mileage-list").hide();
        var e = $(this).attr("data-id");
        $("#toMillage").val(e),
            $(".pr-mileage-dash").show(),
            $(".pr-mileage-max")
                .html(e + " Km")
                .show();
    }),
    $(function () {
        $(".select2-field").each(function () {
            $(this).select2({ theme: "bootstrap4", width: "style", placeholder: $(this).attr("placeholder"), allowClear: Boolean($(this).data("allow-clear")) });
        });
    }),
    $(".custom-file-input").on("change", function () {
        var e = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(e);
    }),
    $(document).ready(function () {
        function e() {
            dataLayer.push(arguments);
        }
        $("#subscribe").on("click", function () {
            var e = $("#email").val();
            if (!/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/.test(e)) return $("#email").css("border-color", "red"), !1;
            $.ajax({
                type: "post",
                dataType: "json",
                data: new FormData($("#subscribeForm")[0]),
                cache: !1,
                contentType: !1,
                processData: !1,
                url: subscriptionUrl + e,
                beforeSend: function () {
                    //$("#greeting").removeClass("d-none"), $("#subscribeForm").addClass("d-none");
                },
                success: function (e) {
                    $('#greeting').html(e.success);
                    $('#greeting').removeClass('d-none');
                    //$("#greeting").addClass("d-none"), $("#subscribeForm").removeClass("d-none");

                },
            });
        }),
            (window.dataLayer = window.dataLayer || []),
            e("js", new Date()),
            e("config", "UA-180079031-1"),
            $("#overlay").fadeOut(2e3),
            jQuery(function () {
                $(".gotosect").click(function () {
                    if (($(this).parent("li").addClass("active"), $(this).parent("li").siblings("li").removeClass("active"), location.pathname.replace(/^\//, "") == this.pathname.replace(/^\//, "") && location.hostname == this.hostname)) {
                        var e = $(this.hash);
                        if ((e = e.length ? e : $("[name=" + this.hash.slice(1) + "]")).length) return $("html, body").animate({ scrollTop: e.offset().top - 50 }, 500), !1;
                    }
                });
            });
        $("#site_url").val();
        $(".bucSlider").owlCarousel({ loop: !1, margin: 0, nav: !0, responsive: { 0: { items: 1 } } }),
            $(".services-slider").owlCarousel({ loop: !1, margin: 0, nav: !0, responsive: { 0: { items: 1 } } }),
            $("#mob-services-slider-1, #mob-services-slider-2, #mob-services-slider-3, #mob-services-slider-4, #mob-services-slider-5, #mob-services-slider-6, #mob-services-slider-7").owlCarousel({
                loop: !1,
                margin: 0,
                nav: !0,
                responsive: { 0: { items: 1 }, 480: { items: 2 } },
            }),
            $("#feat-UsedCars, #pop-UsedCars").owlCarousel({ loop: !1, margin: 20, nav: !0, responsive: { 0: { items: 1 }, 768: { items: 3 }, 992: { items: 4 } } }),
            $("#cars-parts").owlCarousel({ loop: !1, margin: 30, nav: !0, responsive: { 0: { items: 1 }, 768: { items: 3 }, 992: { items: 4 } } }),
            $("#offered-service").owlCarousel({ loop: !1, margin: 30, nav: !0, responsive: { 0: { items: 1 }, 768: { items: 3 }, 992: { items: 4 } } }),
            $("#browse-cb-categ").owlCarousel({ loop: !1, margin: 15, nav: !0, responsive: { 0: { items: 2 }, 570: { items: 3 }, 768: { items: 3 }, 992: { items: 5 } } }),
            $("#browse-cb-make").owlCarousel({ loop: !1, margin: 15, nav: !0, responsive: { 0: { items: 1 } } }),
            $(".gridIcon").on("click", function () {
                $(".listingtab").addClass("gridingCol"),
                    $("this").addClass("active"),
                    $(".listIcon").removeClass("active"),
                    $(".gridListprice").addClass("d-flex mb-2").removeClass("d-none mb-3"),
                    $(".listingCar-place .negotiable, .listingCar-title .lcPrice").hide();
            }),
            $(".listIcon").on("click", function () {
                $(".listingtab").removeClass("gridingCol"),
                    $(this).addClass("active"),
                    $(".gridIcon").removeClass("active"),
                    $(".gridListprice").removeClass("d-flex mb-2").addClass("d-none mb-3"),
                    $(".listingCar-place .negotiable, .listingCar-title .lcPrice").show();
            }),
            $(".searchcol, .searchsubmit").on("click", function () {
                $(".selectCol").removeClass("selectfieldcol"), $(".advSearchCol").removeClass("adActive");
            }),
            $(".show-more-cities").on("click", function () {
                $("#search-by-city-list").toggleClass("searchmorecity");
            }),
            $(".version-listings li").on("click", function () {
                $(".addInformation").show(), $(".postformmodal").modal("hide");
            }),
            $(".custdropdown").parent("li").children("a").attr("href", "javascript:void(0)").append('<em class="fa fa-angle-down"></em>').addClass("align-items-center d-flex justify-content-between"),
            $(".offer-ctg-list li").on("click", function () {
                $(".offer-ctg-list li").not(this).children(".custdropdown").hide("slow"),
                    $(this).children(".custdropdown").slideToggle(),
                    $(".offer-ctg-list li").not(this).removeClass("offerctgActive"),
                    $(this).toggleClass("offerctgActive");
            }),
            $(".navbar-toggler").on("click", function () {
                $(".navbar-collapse").hasClass("collapseShow")
                    ? ($(".navbar-collapse").hide(300).removeClass("collapseShow"), $(this).children("span").removeClass("fa-close").addClass("fa-bars"), $(".mobile-collape-bg").hide())
                    : ($(".navbar-collapse").show(300).addClass("collapseShow"), $(this).children("span").addClass("fa-close").removeClass("fa-bars"), $("body").append('<div class="mobile-collape-bg"></div>'));
            }),
            $(document).on("click", ".mobile-collape-bg", function () {
                $(".navbar-collapse").hide(300).removeClass("collapseShow"), $(".navbar-toggler").children("span").removeClass("fa-close").addClass("fa-bars"), $(".mobile-collape-bg").hide();
            }),
            $("#minPrice").on("keyup", function () {
                var e = $("#minPrice").val();
                "" == $(this).val()
                    ? $(".pr-range-min").html("0")
                    : ($(".pr-range-min")
                        .html(e + "")
                        .show(),
                        $(".select-prng").hide());
            }),
            $("#maxPrice").on("keyup", function () {
                var e = $("#maxPrice").val(),
                    i = $("#minPrice").val();
                "" == $(this).val()
                    ? $(".pr-range-max").html("0")
                    : ("" != i && $(".pr-range-dash").show(),
                        $(".pr-range-max")
                            .html(e + "")
                            .show(),
                        $(".select-prng").hide());
            }),
            $("#minPrice").on("click", function () {
                $(".min-price-list").show(), $(".max-price-list").hide(), $("#minPrice").val("");
            }),
            $("#maxPrice").on("click", function () {
                $(".min-price-list").hide(), $(".max-price-list").show(), $("#maxPrice").val("");
            }),
            $(document).on("click", ".min-price-list li", function () {
                $(this).parents(".min-price-list").hide(), $(".max-price-list").show(), $(".select-prng").hide();
                var e,
                    i = $(this).text(),
                    s = i.replace(/\D/g, "");
                "" != (l = $("#maxPrice").val()) && (s = l = parseInt(l.replace(/\D/g, "")));
                $("#minPrice").val(i), $(".pr-range-min").html(i).show();
                var l = +s + 5e3,
                    a = "";
                for (e = (s = parseInt(s)) + 1e3; e <= l; e += 1e3) a += "<li>" + e + "</li>";
                $(".max-price-list").html(a);
            }),
            $(document).on("change", "#minPrice", function () {
                var e,
                    i = $("#minPrice option:selected").text(),
                    s = i.replace(/\D/g, "");
                if ("" != (l = $("#maxPrice option:selected").val())) {
                    var l = $("#maxPrice option:selected").text();
                    s = l = parseInt(l.replace(/\D/g, ""));
                }
                $("#minPrice option:selected").val(i);
                l = +s + 5e3;
                var a = '<option value="">To</option>';
                for (e = (s = parseInt(s)) + 1e3; e <= l; e += 1e3) a += '<option value="' + e + '">' + e + " </option>";
                $("#maxPrice").html(a);
            }),
            $(document).on("click", ".max-price-list li", function () {
                $(".select-prng, .pr-dropdown").hide(), $(this).parents(".max-price-list").hide();
                var e = $(this).text();
                $("#maxPrice").val(e), $(".pr-range-dash").show(), $(".pr-range-max").html(e).show();
            }),
            $(".pricerange").on("click", function () {
                $(".pr-dropdown").toggle(!0), $(".min-price-list").show();
            }),
            $(".mileagerange").on("click", function () {
                $(".pr-dropdown-mileage").toggle(!0), $(".min-mileage-list").show();
            }),
            $(document).on("click", ".min-mileage-list li", function () {
                $(this).parents(".min-mileage-list").hide(), $(".max-mileage-list").show(), $(".select-prng-mileage").hide();
                var e,
                    i = $(this).attr("data-id"),
                    s = i.replace(/\D/g, "");
                "" != (l = $("#toMillage").val()) && (s = l = parseInt(l.replace(/\D/g, "")));
                $("#fromMillage").val(i),
                    $(".pr-mileage-min")
                        .html(i + " Km")
                        .show();
                var l = +s + 30;
                s = parseInt(s);
                var a = "",
                    o = 1e4;
                for (e = 1; e <= 14; e++) (a += "<li data-id=" + o + ">" + o + " Km</li>"), (o += 1e4);
                $(".max-mileage-list").html(a);
            }),
            $(document).on("click", ".max-mileage-list li", function () {
                $(".select-prng-mileage, .pr-dropdown-mileage").hide(), $(this).parents(".max-mileage-list").hide();
                var e = $(this).attr("data-id");
                $("#toMillage").val(e),
                    $(".pr-mileage-dash").show(),
                    $(".pr-mileage-max")
                        .html(e + " Km")
                        .show();
            }),
            $(function () {
                $(".select2-field").each(function () {
                    $(this).select2({ theme: "bootstrap4", width: "style", placeholder: $(this).attr("placeholder"), allowClear: Boolean($(this).data("allow-clear")) });
                });
            }),
            $(".custom-file-input").on("change", function () {
                var e = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(e);
            });
    });
