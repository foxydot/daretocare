jQuery(document).ready(function($){var e=$("#homepage-widgets section.widget").length;$("#homepage-widgets").addClass("cols-"+e);var i=12/e;$("#homepage-widgets section.widget").addClass("col-sm-"+i),$("#homepage-widgets section.widget").addClass("col-xs-12"),$(window).width()<450&&$("a.block").each(function(){var e=$(this).innerHeight(),i=$(this).innerWidth(),s=e/450*$(window).width(),t=i/450*100;$(this).css("height",s+"px").css("width",t+"%")})});