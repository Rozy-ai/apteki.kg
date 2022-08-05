$(document).ready(function() {
    $(".phone_mask").mask("+7(999) 999-99-99");

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


    $(document).on('click', '#favorite', function () {
        let elem = $(this);
        let id = elem.attr("data-article");
        $.get('/api/user/favorites?id=' + id, function(data) {
            elem.find("i").toggleClass('fas far');
        }, "json");
    });
});
