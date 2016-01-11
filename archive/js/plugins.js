// Avoid `console` errors in browsers that lack a console.
(function() {
    var method;
    var noop = function () {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
}());

// Place any jQuery/helper plugins in here.
/*---iPhone orientation change zooms in issue resolving code---*/
(function(doc) {
 
	var addEvent = 'addEventListener',
	    type = 'gesturestart',
	    qsa = 'querySelectorAll',
	    scales = [1, 1],
	    meta = qsa in doc ? doc[qsa]('meta[name=viewport]') : [];
 
	function fix() {
		meta.content = 'width=device-width,minimum-scale=' + scales[0] + ',maximum-scale=' + scales[1];
		doc.removeEventListener(type, fix, true);
	}
 
	if ((meta = meta[meta.length - 1]) && addEvent in doc) {
		fix();
		scales = [.25, 1.6];
		doc[addEvent](type, fix, true);
	}
 
}(document));

 /* jQuery corner plugin: Ends*/
 
 
 /*! jQuery Placeholder Plugin - v0.7.0 - 2013-02-18
* http://andrew-jones.com/jquery-placeholder-plugin
* Copyright (c) 2013 Andrew Jones; Licensed MIT */
(function(a){"use strict",a.extend({placeholder:{settings:{focusClass:"placeholderFocus",activeClass:"placeholder",overrideSupport:!1,preventRefreshIssues:!0}}}),a.support.placeholder="placeholder"in document.createElement("input"),a.fn.plVal=a.fn.val,a.fn.val=function(b){if(typeof b=="undefined")return a.fn.plVal.call(this);var c=a(this[0]),d=c.plVal(),e=a(this).plVal(b);return c.hasClass(a.placeholder.settings.activeClass)&&d===c.attr("placeholder")?(c.removeClass(a.placeholder.settings.activeClass),e):c.hasClass(a.placeholder.settings.activeClass)&&c.plVal()===c.attr("placeholder")?"":a.fn.plVal.call(this,b)},a(window).bind("beforeunload.placeholder",function(){var b=a("input."+a.placeholder.settings.activeClass);b.length>0&&b.val("").attr("autocomplete","off")}),a.fn.placeholder=function(b){return b=a.extend({},a.placeholder.settings,b),!b.overrideSupport&&a.support.placeholder?this:this.each(function(){var c=a(this);if(!c.is("[placeholder]"))return;if(c.is(":password"))return;b.preventRefreshIssues&&c.attr("autocomplete","off"),c.bind("focus.placeholder",function(){var c=a(this);this.value===c.attr("placeholder")&&c.hasClass(b.activeClass)&&c.val("").removeClass(b.activeClass).addClass(b.focusClass)}),c.bind("blur.placeholder",function(){var c=a(this);c.removeClass(b.focusClass),this.value===""&&c.val(c.attr("placeholder")).addClass(b.activeClass)}),c.triggerHandler("blur"),c.parents("form").submit(function(){c.triggerHandler("focus.placeholder")})})}})(jQuery);

//Modernizr for input select fields width equal as 100% in ipad 
// enabling box-sizing support
 Modernizr.addTest("boxsizing", function() {
return Modernizr.testAllProps("boxSizing") && (document.documentMode === undefined || document.documentMode > 7);
});


/*
-
-
*/
/*-----Respnsive slimmenu Plugin for Main menu starts-------*/

/**
 * jquery.slimmenu.js
 * http://adnantopal.github.io/slimmenu/
 * Author: @adnantopal
 * Copyright 2013, Adnan Topal (atopal.com)
 * Licensed under the MIT license.
 */
;(function ( $, window, document, undefined )
{
    var pluginName = "slimmenu",
        defaults =
        {
            resizeWidth: '768',
            collapserTitle: 'Main Menu',
            animSpeed: 'medium',
            easingEffect: null,
            indentChildren: false,
            childrenIndenter: '&nbsp;&nbsp;'
        };

    function Plugin( element, options )
    {
        this.element = element;
        this.$elem = $(this.element);
        this.options = $.extend( {}, defaults, options );
        this.init();
    }

    Plugin.prototype = {

        init: function()
        {
            var $options = this.options,
                $menu = this.$elem,
                $collapser = '<div class="menu-collapser">'+$options.collapserTitle+'<div class="collapse-button"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></div></div>',
                $menu_collapser;

            $menu.before($collapser);
            $menu_collapser = $menu.prev('.menu-collapser');

            $menu.on('click', '.sub-collapser', function(e)
            {
                e.preventDefault();
                e.stopPropagation();

                var $parent_li = $(this).closest('li');

                if ($(this).hasClass('expanded'))
                {
                    $(this).removeClass('expanded');
                    $(this).find('i').html('&#9660;');
                    $parent_li.find('>ul').slideUp($options.animSpeed, $options.easingEffect);
                }
                else
                {
                    $(this).addClass('expanded');
                    $(this).find('i').html('&#9650;');
                    $parent_li.find('>ul').slideDown($options.animSpeed, $options.easingEffect);
                }
            });

            $menu_collapser.on('click', '.collapse-button', function(e)
            {
                e.preventDefault();
                $menu.slideToggle($options.animSpeed, $options.easingEffect);
            });

            this.resizeMenu({ data: { el: this.element, options: this.options } });
            $(window).on('resize', { el: this.element, options: this.options }, this.resizeMenu);
        },

        resizeMenu: function(event)
        {
            var $window = $(window),
                $options = event.data.options,
                $menu = $(event.data.el),
                $menu_collapser = $('body').find('.menu-collapser');

            $menu.find('li').each(function()
            {
                if ($(this).has('ul').length)
                {
                    if ($(this).has('.sub-collapser').length)
                    {
                        $(this).children('.sub-collapser i').html('&#9660;');
                    }
                    else
                    {
                        $(this).append('<span class="sub-collapser"><i>&#9660;</i></span>');
                    }
                }

                $(this).children('ul').hide();
                $(this).find('.sub-collapser').removeClass('expanded').children('i').html('&#9660;');
            });

            if ($options.resizeWidth >= $window.width())
            {
                if ($options.indentChildren)
                {
                    $menu.find('ul').each(function()
                    {
                        var $depth = $(this).parents('ul').length;
                        if (!$(this).children('li').children('a').has('i').length)
                        {
                            $(this).children('li').children('a').prepend(Plugin.prototype.indent($depth, $options));
                        }
                    });
                }

                $menu.find('li').has('ul').off('mouseenter mouseleave');
                $menu.addClass('collapsed').hide();
                $menu_collapser.show();
            }
            else
            {
                $menu.find('li').has('ul').on('mouseenter', function()
                {
                    $(this).find('>ul').stop().slideDown($options.animSpeed, $options.easingEffect);
                })
                .on('mouseleave', function()
                {
                    $(this).find('>ul').stop().slideUp($options.animSpeed, $options.easingEffect);
                });

                $menu.find('li > a > i').remove();
                $menu.removeClass('collapsed').show();
                $menu_collapser.hide();
            }
        },

        indent: function(num, options)
        {
            var $indent = '';
            for (var i=0; i < num; i++)
            {
                $indent += options.childrenIndenter;
            }
            return '<i>'+$indent+'</i>';
        }
    };

    $.fn[pluginName] = function ( options )
    {
        return this.each(function ()
        {
            if (!$.data(this, "plugin_" + pluginName))
            {
                $.data(this, "plugin_" + pluginName,
                new Plugin( this, options ));
            }
        });
    };

})( jQuery, window, document );

/*-----Respnsive slimmenu Plugin for Main menu ends-------*/
/*
-
-
*/

