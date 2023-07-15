const { split } = require("lodash");

try {
    // window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require("jquery");

    // require('bootstrap');
} catch (e) {}
(function() {
    var path = window.location.pathname.split("/");
    var type = window.location.href.split("?type=");
    var base_path = "http://afpc.pixlogixservice.com";
    product_type = "base";
    if (typeof type[1] != "undefined" && type[1] != "") {
        product_type = type[1];
    }
    if (path[1] == "products") {
        $.ajax({
            dataType: "json",
            type: "GET",
            url:
                base_path +
                "/get-product-details/" +
                $("#product_id").val() +
                "?type=" +
                product_type,
            contentType: "application/json",
            success: function(res) {
                $(".customizer-main-box").html(res.data);
            },
            error: function(xhr, status, error) {
                console.log(xhr.status);
                $(".customizer-main-box").html("");
            }
        });
    }

    if (typeof $(".configure").data("product") != "undefined") {
        var productId = $(".configure").data("product");
        $.ajax({
            dataType: "json",
            type: "GET",
            url: base_path + "/get-configure/" + productId,
            contentType: "application/json",
            success: function(res) {
                if (res.status == true) {
                    var html =
                        '<div class="pf-c" style="--c-xs:12;--c-sm:6;--c-lg:6"><div data-pf-type="Column" class="sc-oeezt OJJCp pf-60_">' +
                        res.base +
                        '</div></div><div class="pf-c" style="--c-xs:12;--c-sm:6;--c-lg:6"><div data-pf-type="Column" class="sc-oeezt OJJCp pf-60_">' +
                        res.recommended +
                        "</div></div>";
                    $(".configure").html(html);
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.status);
                $(".configure").html("");
            }
        }).done(function() {
            // setTimeout(() => {
            // if ($(".configure-data").length) {
            //     $(".configure-data").matchHeight();
            // }
            // }, 500);
        });
    }
    if (typeof $(".gallery_images").data("product") != "undefined") {
        var productId = $(".gallery_images").data("product");
        $.ajax({
            dataType: "json",
            type: "GET",
            url: base_path + "/get-gallery-images/" + productId,
            contentType: "application/json",
            success: function(res) {
                if (res.status == true) {
                    $(".gallery_images").html(res.gallery);
                }
            },

            error: function(xhr, status, error) {
                console.log(xhr.status);
                $(".gallery_images").html("");
            }
        }).done(function() {
            setTimeout(() => {
                $(".slider-for").slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: true,
                    fade: true,
                    asNavFor: ".slider-nav"
                });
                $(".slider-nav").slick({
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    asNavFor: ".slider-for",
                    arrows: false,
                    dots: false,
                    centerMode: true,
                    focusOnSelect: true
                });
            }, 500);
        });
    }

    // var urls = [
    //     "http://afpc.pixlogixservice.com/public/lara-js/css/slick-theme.css",
    //     "http://afpc.pixlogixservice.com/public/lara-js/css/slick.css",
    //     "http://afpc.pixlogixservice.com/public/lara-js/css/style.css",
    // ];
    // for (var i = 0; i < urls.length; i++) {
    //     var s = document.createElement("link");
    //     s.type = "text/css";
    //     s.rel = "stylesheet";
    //     // s.id = "pix_css";
    //     s.href = urls[i];
    //     // var x = document.getElementsByTagName("link")[0];
    //     // x.parentNode.insertBefore(s, x);
    //     // $("#pix_css").remove();
    //     $("body").append(s);
    // }
    // var urls = [
    //     "http://afpc.pixlogixservice.com/public/lara-js/slick.min.js",
    // ];
    // for (var i = 0; i < urls.length; i++) {
    //     s.type = "text/javascript";
    //     s.async = true;
    //     s.src = urls[i];
    //     $("body").append(s);
    // }
})();
