$(function () {
    $('#side-menu').smartmenus({
        markCurrentTree: true,
        keepHighlighted: true,
        hideOnClick: false
    });
    $('#side-menu').smartmenus('itemActivate', $('#side-menu a.current').eq(-1));
    if ($.fn.Zebra_DatePicker) {
        $('.form-date-input').Zebra_DatePicker();
    }

    //var clipboard = new Clipboard('.clipboard-btn');
    $('.console-filter').hide();
    
    $('#toggle-filter').change(function() {
      $('.console-filter').toggle('slow');
    });
    
    
});

$('#navbar-bottom-placeholder').fadeOut();
$(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
        $('#navbar-bottom-placeholder').fadeIn();
    } else {
        $('#navbar-bottom-placeholder').fadeOut();
    }
});
$('#backtotop').click(function () {
    $("html, body").animate({
        scrollTop: 0
    }, 500);
    return false;
});

