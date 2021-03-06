jQuery(document).ready(function($) {	
    $('*:first-child').addClass('first-child');
    $('*:last-child').addClass('last-child');
    $('*:nth-child(even)').addClass('even');
    $('*:nth-child(odd)').addClass('odd');
	
	var numwidgets = $('#footer-widgets div.widget').length;
	$('#footer-widgets').addClass('cols-'+numwidgets);

    $('.su-tabs-nav').addClass(function(){
        var numtabs = $(this).children('span').length;
        return 'tabs-'+numtabs;
    });
    
	$.each(['show', 'hide'], function (i, ev) {
        var el = $.fn[ev];
        $.fn[ev] = function () {
          this.trigger(ev);
          return el.apply(this, arguments);
        };
      });

    $('.nav-secondary ul.menu>li').before(function(){
        if(!$(this).hasClass('first-child') && !$(this).hasClass('large') && $(this).hasClass('menu-item') && $(this).css('display')!='none'){
            return '<li class="separator">|</li>';
        }
    });
    $('.nav-footer ul.menu>li').after(function(){
        if(!$(this).hasClass('last-child') && $(this).hasClass('menu-item') && $(this).css('display')!='none'){
            return '<li class="separator">|</li>';
        }
    });
	
	$('.section.expandable .expand').click(function(){
	    var target = $(this).parents('.section-body').find('.content');
	    console.log(target);
	    if(target.hasClass('open')){
            target.removeClass('open');
            $(this).html('MORE <i class="fa fa-angle-down"></i>');
	    } else {
	        target.addClass('open');
	        $(this).html('LESS <i class="fa fa-angle-up"></i>');
	    }
	});
	
	
    $('a').not('[href*="mailto:"]').each(function () {
        var isInternalLink = new RegExp('/' + window.location.hostname + '/');
        if ( ! isInternalLink.test(this.href)) {
            $(this).attr('target', '_blank');
        }
    });
	
});