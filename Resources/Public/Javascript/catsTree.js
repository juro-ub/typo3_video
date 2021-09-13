require(["jquery"], function ($) {
    (function( $ ){
        $.fn.toggleCat = function() {
            if($(this).is(":hidden")){
                $(this).show();
            }else{
                $(this).hide();
            }
        };
    })( jQuery );
    var $j = $.noConflict();
    $j(document).ready(function () {
        $j(".catsTreeExpand").unbind('click').click(function () {
            $j(this).toggleCat();
            $j(this).next().toggleCat();
            $j(this).parent().parent().children().last().toggleCat();
        });
        $j(".catsTreeCollapse").unbind('click').click(function () {
            $j(this).toggleCat();
            $j(this).prev().toggleCat();
            $j(this).parent().parent().children().last().toggleCat();
        });
    });
});
