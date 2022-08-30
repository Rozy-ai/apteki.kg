$(document).ready(function() {
    $(".phone_mask").mask("+7(999) 999-99-99");

    var globalTimeout;
    $('#search-form .search-suggest').css('width', $(".block-search").width() + 2 + "px");
    $("#search-form .form-search").change(initTimer).keyup(initTimer);

    /*$("#search-form .form-search").blur(function() {
        $('#search-form .search-suggest').hide();
        $('#search-form .block-search').removeClass("type-search-suggest")
        $('#search-form .block-search').addClass("type-search-default")
    });*/

    function initTimer() {
        if (globalTimeout) clearTimeout(globalTimeout);
        globalTimeout = setTimeout(handler, 100);
    }

    function handler() {
        let q = $("#search-form .form-search").val();
        if (q.length == 0) {
            $('#search-form .search-suggest').hide();
            $('#search-form .block-search').removeClass("type-search-suggest")
            $('#search-form .block-search').addClass("type-search-default")
            return
        }

        $.get('/api/product/search?q=' + q, function(data) {
            if(data.success) {
                $('#search-form .search-suggest').html(data.html)
                $('#search-form .search-suggest').show();
                $('#search-form .block-search').removeClass("type-search-default")
                $('#search-form .block-search').addClass("type-search-suggest")
            } else {
                $('#search-form .search-suggest').hide();
                $('#search-form .block-search').removeClass("type-search-suggest")
                $('#search-form .block-search').addClass("type-search-default")
            }
        }, "json");
    }

    $(document).on('click', '#button-list', function () {
      if ($(this).hasClass('active')) {
        return
      }
      $(this).addClass('active')
      $("#button-map").removeClass('active');
      $(".availability-list").show();
      $("#availability-map").hide();
    });

    $(document).on('click', '#button-map', function () {
        if ($(this).hasClass('active')) {
            return
        }
        $(this).addClass('active')
        $("#button-list").removeClass('active');
        $("#availability-map").show();
        $(".availability-list").hide();
    });

    $(document).on('click', '#showAvailability', function () {
        $(this).hide();
        $(".availability-list").addClass('show')
    });

    $(document).on('click', '#product-menu a', function () {
        if ($(this).hasClass('active')) {
          return
        }
        $("#product-menu .active").removeClass('active');
        $(this).addClass('active')
    });


    $(document).on('click', '.category_link', function (event) {
        let id = $(this).attr("data-category");
        if ($("#sub-" + id).length) {
            event.preventDefault();
            $("#sub-menu").modal('show')
            $(".sub-category.show").removeClass('show')
            $("#sub-" + id).addClass('show');
        }
    });

    $(document).on('click', '#favorite', function () {
        let elem = $(this);
        let id = elem.attr("data-article");
        $.get('/api/user/favorites?id=' + id, function(data) {
            elem.find("i").toggleClass('fas far');
        }, "json");
    });
});
