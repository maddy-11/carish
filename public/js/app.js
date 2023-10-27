$(document).ready(function () {
    $('#subscribe').on('click', function () {
        var email = $('#email').val();
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (filter.test(email)) {
            $.ajax({
                type: "post",
                dataType: 'json',
                data: new FormData($('#subscribeForm')[0]),
                cache: false,
                contentType: false,
                processData: false,
                url: subscriptionUrl + email,
                beforeSend: function () {
                    // shahsky here
                    //$('#greeting').removeClass('d-none');
                    //$('#subscribeForm').addClass('d-none');
                },
                success: function (data) {

                    setTimeout(function () {
                        $('#greeting').html(data.success);
                        $('#greeting').removeClass('d-none');
                        //$('#subscribeForm').removeClass('d-none');
                    }, 3000);

                }

            });
        }
        else {
            $('#email').css('border-color', 'red');
            return false;
        }


    });



    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());
    gtag('config', 'UA-180079031-1');
    // $("#overlay").fadeOut(2000);

    $('#image-gallery').lightSlider({
        gallery: true,
        item: 1,
        loop: true,
        thumbItem: 4,
        slideMargin: 0,
        enableDrag: false,
        currentPagerPosition: 'left',
        onSliderLoad: function (el) {
            el.lightGallery({
                selector: '#image-gallery .lslide'
            });
            $('#image-gallery').removeClass('cS-hidden');
        }
    });
    //#########################################################
    // Go to Bottom function Start here
    jQuery(function () {
        $('.gotosect').click(function () {
            $(this).parent('li').addClass('active');
            $(this).parent('li').siblings('li').removeClass('active');


            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 50
                    }, 500);
                    return false;
                }
            };

        });
    });

    //###############################################

    var full_path = $('#site_url').val() + '/';

    $('.bucSlider').owlCarousel({
        loop: false,
        margin: 0,
        nav: true,
        responsive: {
            0: {
                items: 1
            }
        }
    })
    $('#services-slider-1, #services-slider-2, #services-slider-3, #services-slider-4, #services-slider-5, #services-slider-6, #services-slider-7').owlCarousel({
        loop: false,
        margin: 0,
        nav: true,
        responsive: {
            0: {
                items: 1
            }
        }
    })
    $('#mob-services-slider-1, #mob-services-slider-2, #mob-services-slider-3, #mob-services-slider-4, #mob-services-slider-5, #mob-services-slider-6, #mob-services-slider-7').owlCarousel({
        loop: false,
        margin: 0,
        nav: true,
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 2,
            }
        }
    })
    $('#feat-UsedCars, #pop-UsedCars').owlCarousel({
        loop: false,
        margin: 20,
        nav: true,
        responsive: {
            0: {
                items: 1,
            },
            768: {
                items: 3,
            },
            992: {
                items: 4,
            }
        }
    })
    $('#cars-parts').owlCarousel({
        loop: false,
        margin: 30,
        nav: true,
        responsive: {
            0: {
                items: 1,
            },
            768: {
                items: 3,
            },
            992: {
                items: 4,
            }
        }
    })
    $('#offered-service').owlCarousel({
        loop: false,
        margin: 30,
        nav: true,
        responsive: {
            0: {
                items: 1,
            },
            768: {
                items: 3,
            },
            992: {
                items: 4,
            }
        }
    })
    $('#browse-cb-categ').owlCarousel({
        loop: false,
        margin: 15,
        nav: true,
        responsive: {
            0: {
                items: 2,
            },
            570: {
                items: 3,
            },
            768: {
                items: 3,
            },
            992: {
                items: 5,
            }
        }
    })
    $('#browse-cb-make').owlCarousel({
        loop: false,
        margin: 15,
        nav: true,
        responsive: {
            0: {
                items: 1,
            }
        }
    })
    $('.gridIcon').on('click', function () {
        $('.listingtab').addClass('gridingCol');
        $('this').addClass('active');
        $('.listIcon').removeClass('active');
        $('.gridListprice').addClass('d-flex mb-2').removeClass('d-none mb-3');
        $('.listingCar-place .negotiable, .listingCar-title .lcPrice').hide();
    });
    $('.listIcon').on('click', function () {
        $('.listingtab').removeClass('gridingCol');
        $(this).addClass('active');
        $('.gridIcon').removeClass('active');
        $('.gridListprice').removeClass('d-flex mb-2').addClass('d-none mb-3');
        $('.listingCar-place .negotiable, .listingCar-title .lcPrice').show();
    });

    $('.searchcol, .searchsubmit').on('click', function () {
        $('.selectCol').removeClass('selectfieldcol');
        $('.advSearchCol').removeClass('adActive');
    });

    $('.show-more-cities').on('click', function () {
        $('#search-by-city-list').toggleClass('searchmorecity');
    });

    $('.version-listings li').on('click', function () {
        $('.addInformation').show();
        $('.postformmodal').modal('hide');
    })

    $('.custdropdown').parent('li').children('a').attr('href', 'javascript:void(0)').append('<em class="fa fa-angle-down"></em>').addClass("align-items-center d-flex justify-content-between");

    $('.offer-ctg-list li').on('click', function () {
        $(".offer-ctg-list li").not(this).children('.custdropdown').hide("slow");
        $(this).children('.custdropdown').slideToggle();
        $(".offer-ctg-list li").not(this).removeClass('offerctgActive');
        $(this).toggleClass('offerctgActive')
    });

    $('.navbar-toggler').on('click', function () {

        if ($('.navbar-collapse').hasClass('collapseShow')) {
            $('.navbar-collapse').hide(300).removeClass('collapseShow');
            $(this).children('span').removeClass('fa-close').addClass('fa-bars');
            $('.mobile-collape-bg').hide();
        } else {
            $('.navbar-collapse').show(300).addClass('collapseShow');
            $(this).children('span').addClass('fa-close').removeClass('fa-bars');
            $('body').append('<div class="mobile-collape-bg"></div>');
        }

    });

    $(document).on('click', '.mobile-collape-bg', function () {
        $('.navbar-collapse').hide(300).removeClass('collapseShow');
        $('.navbar-toggler').children('span').removeClass('fa-close').addClass('fa-bars');
        $('.mobile-collape-bg').hide();
    })


    $('#minPrice').on('keyup', function () {
        var minPrice = $('#minPrice').val();
        if ($(this).val() == "") {
            $('.pr-range-min').html('0')
        } else {
            $('.pr-range-min').html(minPrice + "").show()
            $('.select-prng').hide();
        }

    })
    $('#maxPrice').on('keyup', function () {
        var maxPrice = $('#maxPrice').val();
        var minPrice = $('#minPrice').val();
        if ($(this).val() == "") {
            $('.pr-range-max').html('0');
        } else {
            if (minPrice != '') {
                $('.pr-range-dash').show();
            }
            $('.pr-range-max').html(maxPrice + "").show();
            $('.select-prng').hide();
        }
    })

    $('#minPrice').on('click', function () {
        $('.min-price-list').show()
        $('.max-price-list').hide()
        $('#minPrice').val('');
    });
    $('#maxPrice').on('click', function () {
        $('.min-price-list').hide()
        $('.max-price-list').show()
        $('#maxPrice').val('');
    });

    $(document).on('click', '.min-price-list li', function () {

        $(this).parents('.min-price-list').hide();
        $('.max-price-list').show();
        $('.select-prng').hide();
        var minlistPrice = $(this).text();
        var minPrice = minlistPrice.replace(/\D/g, '');
        var maxPrice = $("#maxPrice").val();

        if (maxPrice != '') {
            var maxPrice = parseInt(maxPrice.replace(/\D/g, ''));
            minPrice = maxPrice;
        }

        $('#minPrice').val(minlistPrice);
        $('.pr-range-min').html(minlistPrice).show();
        var i;
        var maxPrice = +minPrice + 5000;
        minPrice = parseInt(minPrice);
        var maxPriceHtml = '';
        for (i = minPrice + 1000; i <= maxPrice; i += 1000) {
            maxPriceHtml += '<li>' + i + '</li>';
        }
        $(".max-price-list").html(maxPriceHtml);

    });

    /* PRICCES SELECTION IN DROP DOWN */
    $(document).on('change', '#minPrice', function () {

        var minlistPrice = $("#minPrice option:selected").text();
        var minPrice = minlistPrice.replace(/\D/g, '');
        var maxPrice = $("#maxPrice option:selected").val();

        if (maxPrice != '') {
            var maxPrice = $("#maxPrice option:selected").text();
            var maxPrice = parseInt(maxPrice.replace(/\D/g, ''));
            minPrice = maxPrice;
        }

        $("#minPrice option:selected").val(minlistPrice);
        var i;
        var maxPrice = +minPrice + 5000;
        minPrice = parseInt(minPrice);
        var maxPriceHtml = '<option value="">To</option>';
        for (i = minPrice + 1000; i <= maxPrice; i += 1000) {
            maxPriceHtml += '<option value="' + i + '">' + i + ' </option>';
        }
        $("#maxPrice").html(maxPriceHtml);

    });

    $(document).on('click', '.max-price-list li', function () {

        $('.select-prng, .pr-dropdown').hide();
        $(this).parents('.max-price-list').hide();
        var maxlistPrice = $(this).text();
        $('#maxPrice').val(maxlistPrice);
        $('.pr-range-dash').show();
        $('.pr-range-max').html(maxlistPrice).show();

    });


    $('.pricerange').on('click', function () {
        $('.pr-dropdown').toggle(true);
        $('.min-price-list').show();
    });


    $('.mileagerange').on('click', function () {

        $('.pr-dropdown-mileage').toggle(true);
        $('.min-mileage-list').show();

    });

    $(document).on('click', '.min-mileage-list li', function () {

        $(this).parents('.min-mileage-list').hide();
        $('.max-mileage-list').show();
        $('.select-prng-mileage').hide();
        var minlistMileage = $(this).attr('data-id');
        var minMileage = minlistMileage.replace(/\D/g, '');
        var maxMileage = $("#toMillage").val();

        if (maxMileage != '') {
            var maxMileage = parseInt(maxMileage.replace(/\D/g, ''));
            minMileage = maxMileage;
        }

        $('#fromMillage').val(minlistMileage);
        $('.pr-mileage-min').html(minlistMileage + ' Km').show();
        var i;
        var maxMileage = +minMileage + 30;
        minMileage = parseInt(minMileage);
        var maxMileageHtml = '';
        var mi = 10000;
        for (i = 1; i <= 14; i++) {
            maxMileageHtml += '<li data-id=' + mi + '>' + mi + ' Km</li>';
            mi += 10000;
        }
        $(".max-mileage-list").html(maxMileageHtml);

    });

    $(document).on('click', '.max-mileage-list li', function () {

        $('.select-prng-mileage, .pr-dropdown-mileage').hide();
        $(this).parents('.max-mileage-list').hide();
        var maxlistPrice = $(this).attr('data-id');
        $('#toMillage').val(maxlistPrice);
        $('.pr-mileage-dash').show();
        $('.pr-mileage-max').html(maxlistPrice + ' Km').show();

    });


    $(function () {
        $('.select2-field').each(function () {
            $(this).select2({
                theme: 'bootstrap4',
                width: 'style',
                placeholder: $(this).attr('placeholder'),
                allowClear: Boolean($(this).data('allow-clear')),
            });
        });
    });



    $(".custom-file-input").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });


    function getUnique(array) {
        var uniqueArray = [];


        for (var value of array) {
            if (uniqueArray.indexOf(value) === -1) {
                uniqueArray.push(value);
            }
        }
        return uniqueArray;
    }


});