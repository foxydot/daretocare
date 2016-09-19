jQuery(document).ready(function($) {
    var numwidgets = $('#homepage-widgets section.widget').length;
    $('#homepage-widgets').addClass('cols-'+numwidgets);
    var cols = 12/numwidgets;
    $('#homepage-widgets section.widget').addClass('col-sm-'+cols);
    $('#homepage-widgets section.widget').addClass('col-xs-12');
    if($( window ).width() < 992){
        $('a.block').each(function () {
            var h = $(this).innerHeight();
            var w = $(this).innerWidth();
            var height = (h/450)*$( window ).width();
            var width = (w/450)*100;
            $(this).css('height',height + 'px').css('width',width + '%');
        });
    }
});