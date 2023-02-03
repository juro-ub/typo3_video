(function ($) {
    $.fn.toggleCommment = function () {
        if ($(this).is(":hidden")) {
            $(this).show();
        } else {
            $(this).hide();
        }
    };
})(jQuery);
$(document).ready(function () {

    $(".commentTreeExpand").unbind('click').click(function () {
        $(this).toggleCommment();
        $(this).next().toggleCommment();
        $(this).parent().parent().children().last().toggleCommment();
    });

    $(".commentTreeCollapse").unbind('click').click(function () {
        $(this).toggleCommment();
        $(this).prev().toggleCommment();
        $(this).parent().parent().children().last().toggleCommment();
    });


    $(".commentTreeExpand").each(function () {
        $(this).hide();
        $(this).next().show();
        $(this).parent().parent().children().last().hide();
    });
});
