/*
     _ _      _       _
 ___| (_) ___| | __  (_)___
/ __| | |/ __| |/ /  | / __|
\__ \ | | (__|   < _ | \__ \
|___/_|_|\___|_|\_(_)/ |___/
                   |__/

 Version: 1.8.1
  Author: Ken Wheeler
 Website: http://kenwheeler.github.io
    Docs: http://kenwheeler.github.io/slick
    Repo: http://github.com/kenwheeler/slick
  Issues: http://github.com/kenwheeler/slick/issues

 */
/* global window, document, define, jQuery, setInterval, clearInterval */
;(function(factory) {
    'use strict';
    if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory);
    } else if (typeof exports !== 'undefined') {
        module.exports = factory(require('jquery'));
    } else {
        factory(jQuery);
    }

}(function($) {
    'use strict';
    var Slick = window.Slick || {};

    Slick = (function() {

        var instanceUid = 0;

        function Slick(element, settings) {

            var _ = this, dataSettings;

            _.defaults = {
                accessibility: true,
                adaptiveHeight: false,
                appendArrows: $(element),
                appendDots: $(element),
                arrows: true,
                asNavFor: null,
                prevArrow: '<button class="slick-prev" aria-label="Previous" type="button">Previous</button>',
                nextArrow: '<button class="slick-next" aria-label="Next" type="button">Next</button>',
                autoplay: false,
                autoplaySpeed: 3000,
                centerMode: false,
                centerPadding: '50px',
                cssEase: 'ease',
                customPaging: function(slider, i) {
                    return $('<button type="button" />').text(i + 1);
                },
                dots: false,
                dotsClass: 'slick-dots',
                draggable: true,
                easing: 'linear',
                edgeFriction: 0.35,
                fade: false,
                focusOnSelect: false,
                focusOnChange: false,
                infinite: true,
                initialSlide: 0,
                lazyLoad: 'ondemand',
                mobileFirst: false,
                pauseOnHover: true,
                pauseOnFocus: true,
                pauseOnDotsHover: false,
                respondTo: 'window',
                responsive: null,
                rows: 1,
                rtl: false,
                slide: '',
                slidesPerRow: 1,
                slidesToShow: 1,
                slidesToScroll: 1,
                speed: 500,
                swipe: true,
                swipeToSlide: false,
                touchMove: true,
                touchThreshold: 5,
                useCSS: true,
                useTransform: true,
                variableWidth: false,
                vertical: false,
                verticalSwiping: false,
                waitForAnimate: true,
                zIndex: 1000
            };

            _.initials = {
                animating: false,
                dragging: false,
                autoPlayTimer: null,
                currentDirection: 0,
                currentLeft: null,
                currentSlide: 0,
                direction: 1,
                $dots: null,
                listWidth: null,
                listHeight: null,
                loadIndex: 0,
                $nextArrow: null,
                $prevArrow: null,
                scrolling: false,
                slideCount: null,
                slideWidth: null,
                $slideTrack: null,
                $slides: null,
                sliding: false,
                slideOffset: 0,
                swipeLeft: null,
                swiping: false,
                $list: null,
                touchObject: {},
                transformsEnabled: false,
                unslicked: false
            };

            $.extend(_, _.initials);

            _.activeBreakpoint = null;
            _.animType = null;
            _.animProp = null;
            _.breakpoints = [];
            _.breakpointSettings = [];
            _.cssTransitions = false;
            _.focussed = false;
            _.interrupted = false;
            _.hidden = 'hidden';
            _.paused = true;
            _.positionProp = null;
            _.respondTo = null;
            _.rowCount = 1;
            _.shouldClick = true;
            _.$slider = $(element);
            _.$slidesCache = null;
            _.transformType = null;
            _.transitionType = null;
            _.visibilityChange = 'visibilitychange';
            _.windowWidth = 0;
            _.windowTimer = null;

            dataSettings = $(element).data('slick') || {};

            _.options = $.extend({}, _.defaults, settings, dataSettings);

            _.currentSlide = _.options.initialSlide;

            _.originalSettings = _.options;

            if (typeof document.mozHidden !== 'undefined') {
                _.hidden = 'mozHidden';
                _.visibilityChange = 'mozvisibilitychange';
            } else if (typeof document.webkitHidden !== 'undefined') {
                _.hidden = 'webkitHidden';
                _.visibilityChange = 'webkitvisibilitychange';
            }

            _.autoPlay = $.proxy(_.autoPlay, _);
            _.autoPlayClear = $.proxy(_.autoPlayClear, _);
            _.autoPlayIterator = $.proxy(_.autoPlayIterator, _);
            _.changeSlide = $.proxy(_.changeSlide, _);
            _.clickHandler = $.proxy(_.clickHandler, _);
            _.selectHandler = $.proxy(_.selectHandler, _);
            _.setPosition = $.proxy(_.setPosition, _);
            _.swipeHandler = $.proxy(_.swipeHandler, _);
            _.dragHandler = $.proxy(_.dragHandler, _);
            _.keyHandler = $.proxy(_.keyHandler, _);

            _.instanceUid = instanceUid++;

            // A simple way to check for HTML strings
            // Strict HTML recognition (must start with <)
            // Extracted from jQuery v1.11 source
            _.htmlExpr = /^(?:\s*(<[\w\W]+>)[^>]*)$/;


            _.registerBreakpoints();
            _.init(true);

        }

        return Slick;

    }());

    Slick.prototype.activateADA = function() {
        var _ = this;

        _.$slideTrack.find('.slick-active').attr({
            'aria-hidden': 'false'
        }).find('a, input, button, select').attr({
            'tabindex': '0'
        });

    };

    Slick.prototype.addSlide = Slick.prototype.slickAdd = function(markup, index, addBefore) {

        var _ = this;

        if (typeof(index) === 'boolean') {
            addBefore = index;
            index = null;
        } else if (index < 0 || (index >= _.slideCount)) {
            return false;
        }

        _.unload();

        if (typeof(index) === 'number') {
            if (index === 0 && _.$slides.length === 0) {
                $(markup).appendTo(_.$slideTrack);
            } else if (addBefore) {
                $(markup).insertBefore(_.$slides.eq(index));
            } else {
                $(markup).insertAfter(_.$slides.eq(index));
            }
        } else {
            if (addBefore === true) {
                $(markup).prependTo(_.$slideTrack);
            } else {
                $(markup).appendTo(_.$slideTrack);
            }
        }

        _.$slides = _.$slideTrack.children(this.options.slide);

        _.$slideTrack.children(this.options.slide).detach();

        _.$slideTrack.append(_.$slides);

        _.$slides.each(function(index, element) {
            $(element).attr('data-slick-index', index);
        });

        _.$slidesCache = _.$slides;

        _.reinit();

    };

    Slick.prototype.animateHeight = function() {
        var _ = this;
        if (_.options.slidesToShow === 1 && _.options.adaptiveHeight === true && _.options.vertical === false) {
            var targetHeight = _.$slides.eq(_.currentSlide).outerHeight(true);
            _.$list.animate({
                height: targetHeight
            }, _.options.speed);
        }
    };

    Slick.prototype.animateSlide = function(targetLeft, callback) {

        var animProps = {},
            _ = this;

        _.animateHeight();

        if (_.options.rtl === true && _.options.vertical === false) {
            targetLeft = -targetLeft;
        }
        if (_.transformsEnabled === false) {
            if (_.options.vertical === false) {
                _.$slideTrack.animate({
                    left: targetLeft
                }, _.options.speed, _.options.easing, callback);
            } else {
                _.$slideTrack.animate({
                    top: targetLeft
                }, _.options.speed, _.options.easing, callback);
            }

        } else {

            if (_.cssTransitions === false) {
                if (_.options.rtl === true) {
                    _.currentLeft = -(_.currentLeft);
                }
                $({
                    animStart: _.currentLeft
                }).animate({
                    animStart: targetLeft
                }, {
                    duration: _.options.speed,
                    easing: _.options.easing,
                    step: function(now) {
                        now = Math.ceil(now);
                        if (_.options.vertical === false) {
                            animProps[_.animType] = 'translate(' +
                                now + 'px, 0px)';
                            _.$slideTrack.css(animProps);
                        } else {
                            animProps[_.animType] = 'translate(0px,' +
                                now + 'px)';
                            _.$slideTrack.css(animProps);
                        }
                    },
                    complete: function() {
                        if (callback) {
                            callback.call();
                        }
                    }
                });

            } else {

                _.applyTransition();
                targetLeft = Math.ceil(targetLeft);

                if (_.options.vertical === false) {
                    animProps[_.animType] = 'translate3d(' + targetLeft + 'px, 0px, 0px)';
                } else {
                    animProps[_.animType] = 'translate3d(0px,' + targetLeft + 'px, 0px)';
                }
                _.$slideTrack.css(animProps);

                if (callback) {
                    setTimeout(function() {

                        _.disableTransition();

                        callback.call();
                    }, _.options.speed);
                }

            }

        }

    };

    Slick.prototype.getNavTarget = function() {

        var _ = this,
            asNavFor = _.options.asNavFor;

        if ( asNavFor && asNavFor !== null ) {
            asNavFor = $(asNavFor).not(_.$slider);
        }

        return asNavFor;

    };

    Slick.prototype.asNavFor = function(index) {

        var _ = this,
            asNavFor = _.getNavTarget();

        if ( asNavFor !== null && typeof asNavFor === 'object' ) {
            asNavFor.each(function() {
                var target = $(this).slick('getSlick');
                if(!target.unslicked) {
                    target.slideHandler(index, true);
                }
            });
        }

    };

    Slick.prototype.applyTransition = function(slide) {

        var _ = this,
            transition = {};

        if (_.options.fade === false) {
            transition[_.transitionType] = _.transformType + ' ' + _.options.speed + 'ms ' + _.options.cssEase;
        } else {
            transition[_.transitionType] = 'opacity ' + _.options.speed + 'ms ' + _.options.cssEase;
        }

        if (_.options.fade === false) {
            _.$slideTrack.css(transition);
        } else {
            _.$slides.eq(slide).css(transition);
        }

    };

    Slick.prototype.autoPlay = function() {

        var _ = this;

        _.autoPlayClear();

        if ( _.slideCount > _.options.slidesToShow ) {
            _.autoPlayTimer = setInterval( _.autoPlayIterator, _.options.autoplaySpeed );
        }

    };

    Slick.prototype.autoPlayClear = function() {

        var _ = this;

        if (_.autoPlayTimer) {
            clearInterval(_.autoPlayTimer);
        }

    };

    Slick.prototype.autoPlayIterator = function() {

        var _ = this,
            slideTo = _.currentSlide + _.options.slidesToScroll;

        if ( !_.paused && !_.interrupted && !_.focussed ) {

            if ( _.options.infinite === false ) {

                if ( _.direction === 1 && ( _.currentSlide + 1 ) === ( _.slideCount - 1 )) {
                    _.direction = 0;
                }

                else if ( _.direction === 0 ) {

                    slideTo = _.currentSlide - _.options.slidesToScroll;

                    if ( _.currentSlide - 1 === 0 ) {
                        _.direction = 1;
                    }

                }

            }

            _.slideHandler( slideTo );

        }

    };

    Slick.prototype.buildArrows = function() {

        var _ = this;

        if (_.options.arrows === true ) {

            _.$prevArrow = $(_.options.prevArrow).addClass('slick-arrow');
            _.$nextArrow = $(_.options.nextArrow).addClass('slick-arrow');

            if( _.slideCount > _.options.slidesToShow ) {

                _.$prevArrow.removeClass('slick-hidden').removeAttr('aria-hidden tabindex');
                _.$nextArrow.removeClass('slick-hidden').removeAttr('aria-hidden tabindex');

                if (_.htmlExpr.test(_.options.prevArrow)) {
                    _.$prevArrow.prependTo(_.options.appendArrows);
                }

                if (_.htmlExpr.test(_.options.nextArrow)) {
                    _.$nextArrow.appendTo(_.options.appendArrows);
                }

                if (_.options.infinite !== true) {
                    _.$prevArrow
                        .addClass('slick-disabled')
                        .attr('aria-disabled', 'true');
                }

            } else {

                _.$prevArrow.add( _.$nextArrow )

                    .addClass('slick-hidden')
                    .attr({
                        'aria-disabled': 'true',
                        'tabindex': '-1'
                    });

            }

        }

    };

    Slick.prototype.buildDots = function() {

        var _ = this,
            i, dot;

        if (_.options.dots === true && _.slideCount > _.options.slidesToShow) {

            _.$slider.addClass('slick-dotted');

            dot = $('<ul />').addClass(_.options.dotsClass);

            for (i = 0; i <= _.getDotCount(); i += 1) {
                dot.append($('<li />').append(_.options.customPaging.call(this, _, i)));
            }

            _.$dots = dot.appendTo(_.options.appendDots);

            _.$dots.find('li').first().addClass('slick-active');

        }

    };

    Slick.prototype.buildOut = function() {

        var _ = this;

        _.$slides =
            _.$slider
                .children( _.options.slide + ':not(.slick-cloned)')
                .addClass('slick-slide');

        _.slideCount = _.$slides.length;

        _.$slides.each(function(index, element) {
            $(element)
                .attr('data-slick-index', index)
                .data('originalStyling', $(element).attr('style') || '');
        });

        _.$slider.addClass('slick-slider');

        _.$slideTrack = (_.slideCount === 0) ?
            $('<div class="slick-track"/>').appendTo(_.$slider) :
            _.$slides.wrapAll('<div class="slick-track"/>').parent();

        _.$list = _.$slideTrack.wrap(
            '<div class="slick-list"/>').parent();
        _.$slideTrack.css('opacity', 0);

        if (_.options.centerMode === true || _.options.swipeToSlide === true) {
            _.options.slidesToScroll = 1;
        }

        $('img[data-lazy]', _.$slider).not('[src]').addClass('slick-loading');

        _.setupInfinite();

        _.buildArrows();

        _.buildDots();

        _.updateDots();


        _.setSlideClasses(typeof _.currentSlide === 'number' ? _.currentSlide : 0);

        if (_.options.draggable === true) {
            _.$list.addClass('draggable');
        }

    };

    Slick.prototype.buildRows = function() {

        var _ = this, a, b, c, newSlides, numOfSlides, originalSlides,slidesPerSection;

        newSlides = document.createDocumentFragment();
        originalSlides = _.$slider.children();

        if(_.options.rows > 0) {

            slidesPerSection = _.options.slidesPerRow * _.options.rows;
            numOfSlides = Math.ceil(
                originalSlides.length / slidesPerSection
            );

            for(a = 0; a < numOfSlides; a++){
                var slide = document.createElement('div');

                for(b = 0; b < _.options.rows; b++) {
                    var row = document.createElement('div');
                    row.setAttribute('class', 'slick-slide-inners');
                    for(c = 0; c < _.options.slidesPerRow; c++) {
                        var target = (a * slidesPerSection + ((b * _.options.slidesPerRow) + c));
                        if (originalSlides.get(target)) {
                            row.appendChild(originalSlides.get(target));
                        }
                    }
                    slide.appendChild(row);
                }
                newSlides.appendChild(slide);
            }

            _.$slider.empty().append(newSlides);
            _.$slider.children().children().children()
                .css({
                    'width':(100 / _.options.slidesPerRow) + '%',
                    'display': 'inline-block'
                });

        }

    };

    Slick.prototype.checkResponsive = function(initial, forceUpdate) {

        var _ = this,
            breakpoint, targetBreakpoint, respondToWidth, triggerBreakpoint = false;
        var sliderWidth = _.$slider.width();
        var windowWidth = window.innerWidth || $(window).width();

        if (_.respondTo === 'window') {
            respondToWidth = windowWidth;
        } else if (_.respondTo === 'slider') {
            respondToWidth = sliderWidth;
        } else if (_.respondTo === 'min') {
            respondToWidth = Math.min(windowWidth, sliderWidth);
        }

        if ( _.options.responsive &&
            _.options.responsive.length &&
            _.options.responsive !== null) {

            targetBreakpoint = null;

            for (breakpoint in _.breakpoints) {
                if (_.breakpoints.hasOwnProperty(breakpoint)) {
                    if (_.originalSettings.mobileFirst === false) {
                        if (respondToWidth < _.breakpoints[breakpoint]) {
                            targetBreakpoint = _.breakpoints[breakpoint];
                        }
                    } else {
                        if (respondToWidth > _.breakpoints[breakpoint]) {
                            targetBreakpoint = _.breakpoints[breakpoint];
                        }
                    }
                }
            }

            if (targetBreakpoint !== null) {
                if (_.activeBreakpoint !== null) {
                    if (targetBreakpoint !== _.activeBreakpoint || forceUpdate) {
                        _.activeBreakpoint =
                            targetBreakpoint;
                        if (_.breakpointSettings[targetBreakpoint] === 'unslick') {
                            _.unslick(targetBreakpoint);
                        } else {
                            _.options = $.extend({}, _.originalSettings,
                                _.breakpointSettings[
                                    targetBreakpoint]);
                            if (initial === true) {
                                _.currentSlide = _.options.initialSlide;
                            }
                            _.refresh(initial);
                        }
                        triggerBreakpoint = targetBreakpoint;
                    }
                } else {
                    _.activeBreakpoint = targetBreakpoint;
                    if (_.breakpointSettings[targetBreakpoint] === 'unslick') {
                        _.unslick(targetBreakpoint);
                    } else {
                        _.options = $.extend({}, _.originalSettings,
                            _.breakpointSettings[
                                targetBreakpoint]);
                        if (initial === true) {
                            _.currentSlide = _.options.initialSlide;
                        }
                        _.refresh(initial);
                    }
                    triggerBreakpoint = targetBreakpoint;
                }
            } else {
                if (_.activeBreakpoint !== null) {
                    _.activeBreakpoint = null;
                    _.options = _.originalSettings;
                    if (initial === true) {
                        _.currentSlide = _.options.initialSlide;
                    }
                    _.refresh(initial);
                    triggerBreakpoint = targetBreakpoint;
                }
            }

            // only trigger breakpoints during an actual break. not on initialize.
            if( !initial && triggerBreakpoint !== false ) {
                _.$slider.trigger('breakpoint', [_, triggerBreakpoint]);
            }
        }

    };

    Slick.prototype.changeSlide = function(event, dontAnimate) {

        var _ = this,
            $target = $(event.currentTarget),
            indexOffset, slideOffset, unevenOffset;

        // If target is a link, prevent default action.
        if($target.is('a')) {
            event.preventDefault();
        }

        // If target is not the <li> element (ie: a child), find the <li>.
        if(!$target.is('li')) {
            $target = $target.closest('li');
        }

        unevenOffset = (_.slideCount % _.options.slidesToScroll !== 0);
        indexOffset = unevenOffset ? 0 : (_.slideCount - _.currentSlide) % _.options.slidesToScroll;

        switch (event.data.message) {

            case 'previous':
                slideOffset = indexOffset === 0 ? _.options.slidesToScroll : _.options.slidesToShow - indexOffset;
                if (_.slideCount > _.options.slidesToShow) {
                    _.slideHandler(_.currentSlide - slideOffset, false, dontAnimate);
                }
                break;

            case 'next':
                slideOffset = indexOffset === 0 ? _.options.slidesToScroll : indexOffset;
                if (_.slideCount > _.options.slidesToShow) {
                    _.slideHandler(_.currentSlide + slideOffset, false, dontAnimate);
                }
                break;

            case 'index':
                var index = event.data.index === 0 ? 0 :
                    event.data.index || $target.index() * _.options.slidesToScroll;

                _.slideHandler(_.checkNavigable(index), false, dontAnimate);
                $target.children().trigger('focus');
                break;

            default:
                return;
        }

    };

    Slick.prototype.checkNavigable = function(index) {

        var _ = this,
            navigables, prevNavigable;

        navigables = _.getNavigableIndexes();
        prevNavigable = 0;
        if (index > navigables[navigables.length - 1]) {
            index = navigables[navigables.length - 1];
        } else {
            for (var n in navigables) {
                if (index < navigables[n]) {
                    index = prevNavigable;
                    break;
                }
                prevNavigable = navigables[n];
            }
        }

        return index;
    };

    Slick.prototype.cleanUpEvents = function() {

        var _ = this;

        if (_.options.dots && _.$dots !== null) {

            $('li', _.$dots)
                .off('click.slick', _.changeSlide)
                .off('mouseenter.slick', $.proxy(_.interrupt, _, true))
                .off('mouseleave.slick', $.proxy(_.interrupt, _, false));

            if (_.options.accessibility === true) {
                _.$dots.off('keydown.slick', _.keyHandler);
            }
        }

        _.$slider.off('focus.slick blur.slick');

        if (_.options.arrows === true && _.slideCount > _.options.slidesToShow) {
            _.$prevArrow && _.$prevArrow.off('click.slick', _.changeSlide);
            _.$nextArrow && _.$nextArrow.off('click.slick', _.changeSlide);

            if (_.options.accessibility === true) {
                _.$prevArrow && _.$prevArrow.off('keydown.slick', _.keyHandler);
                _.$nextArrow && _.$nextArrow.off('keydown.slick', _.keyHandler);
            }
        }

        _.$list.off('touchstart.slick mousedown.slick', _.swipeHandler);
        _.$list.off('touchmove.slick mousemove.slick', _.swipeHandler);
        _.$list.off('touchend.slick mouseup.slick', _.swipeHandler);
        _.$list.off('touchcancel.slick mouseleave.slick', _.swipeHandler);

        _.$list.off('click.slick', _.clickHandler);

        $(document).off(_.visibilityChange, _.visibility);

        _.cleanUpSlideEvents();

        if (_.options.accessibility === true) {
            _.$list.off('keydown.slick', _.keyHandler);
        }

        if (_.options.focusOnSelect === true) {
            $(_.$slideTrack).children().off('click.slick', _.selectHandler);
        }

        $(window).off('orientationchange.slick.slick-' + _.instanceUid, _.orientationChange);

        $(window).off('resize.slick.slick-' + _.instanceUid, _.resize);

        $('[draggable!=true]', _.$slideTrack).off('dragstart', _.preventDefault);

        $(window).off('load.slick.slick-' + _.instanceUid, _.setPosition);

    };

    Slick.prototype.cleanUpSlideEvents = function() {

        var _ = this;

        _.$list.off('mouseenter.slick', $.proxy(_.interrupt, _, true));
        _.$list.off('mouseleave.slick', $.proxy(_.interrupt, _, false));

    };

    Slick.prototype.cleanUpRows = function() {

        var _ = this, originalSlides;

        if(_.options.rows > 0) {
            originalSlides = _.$slides.children().children();
            originalSlides.removeAttr('style');
            _.$slider.empty().append(originalSlides);
        }

    };

    Slick.prototype.clickHandler = function(event) {

        var _ = this;

        if (_.shouldClick === false) {
            event.stopImmediatePropagation();
            event.stopPropagation();
            event.preventDefault();
        }

    };

    Slick.prototype.destroy = function(refresh) {

        var _ = this;

        _.autoPlayClear();

        _.touchObject = {};

        _.cleanUpEvents();

        $('.slick-cloned', _.$slider).detach();

        if (_.$dots) {
            _.$dots.remove();
        }

        if ( _.$prevArrow && _.$prevArrow.length ) {

            _.$prevArrow
                .removeClass('slick-disabled slick-arrow slick-hidden')
                .removeAttr('aria-hidden aria-disabled tabindex')
                .css('display','');

            if ( _.htmlExpr.test( _.options.prevArrow )) {
                _.$prevArrow.remove();
            }
        }

        if ( _.$nextArrow && _.$nextArrow.length ) {

            _.$nextArrow
                .removeClass('slick-disabled slick-arrow slick-hidden')
                .removeAttr('aria-hidden aria-disabled tabindex')
                .css('display','');

            if ( _.htmlExpr.test( _.options.nextArrow )) {
                _.$nextArrow.remove();
            }
        }


        if (_.$slides) {

            _.$slides
                .removeClass('slick-slide slick-active slick-center slick-visible slick-current')
                .removeAttr('aria-hidden')
                .removeAttr('data-slick-index')
                .each(function(){
                    $(this).attr('style', $(this).data('originalStyling'));
                });

            _.$slideTrack.children(this.options.slide).detach();

            _.$slideTrack.detach();

            _.$list.detach();

            _.$slider.append(_.$slides);
        }

        _.cleanUpRows();

        _.$slider.removeClass('slick-slider');
        _.$slider.removeClass('slick-initialized');
        _.$slider.removeClass('slick-dotted');

        _.unslicked = true;

        if(!refresh) {
            _.$slider.trigger('destroy', [_]);
        }

    };

    Slick.prototype.disableTransition = function(slide) {

        var _ = this,
            transition = {};

        transition[_.transitionType] = '';

        if (_.options.fade === false) {
            _.$slideTrack.css(transition);
        } else {
            _.$slides.eq(slide).css(transition);
        }

    };

    Slick.prototype.fadeSlide = function(slideIndex, callback) {

        var _ = this;

        if (_.cssTransitions === false) {

            _.$slides.eq(slideIndex).css({
                zIndex: _.options.zIndex
            });

            _.$slides.eq(slideIndex).animate({
                opacity: 1
            }, _.options.speed, _.options.easing, callback);

        } else {

            _.applyTransition(slideIndex);

            _.$slides.eq(slideIndex).css({
                opacity: 1,
                zIndex: _.options.zIndex
            });

            if (callback) {
                setTimeout(function() {

                    _.disableTransition(slideIndex);

                    callback.call();
                }, _.options.speed);
            }

        }

    };

    Slick.prototype.fadeSlideOut = function(slideIndex) {

        var _ = this;

        if (_.cssTransitions === false) {

            _.$slides.eq(slideIndex).animate({
                opacity: 0,
                zIndex: _.options.zIndex - 2
            }, _.options.speed, _.options.easing);

        } else {

            _.applyTransition(slideIndex);

            _.$slides.eq(slideIndex).css({
                opacity: 0,
                zIndex: _.options.zIndex - 2
            });

        }

    };

    Slick.prototype.filterSlides = Slick.prototype.slickFilter = function(filter) {

        var _ = this;

        if (filter !== null) {

            _.$slidesCache = _.$slides;

            _.unload();

            _.$slideTrack.children(this.options.slide).detach();

            _.$slidesCache.filter(filter).appendTo(_.$slideTrack);

            _.reinit();

        }

    };

    Slick.prototype.focusHandler = function() {

        var _ = this;

        // If any child element receives focus within the slider we need to pause the autoplay
        _.$slider
            .off('focus.slick blur.slick')
            .on(
                'focus.slick',
                '*', 
                function(event) {
                    var $sf = $(this);

                    setTimeout(function() {
                        if( _.options.pauseOnFocus ) {
                            if ($sf.is(':focus')) {
                                _.focussed = true;
                                _.autoPlay();
                            }
                        }
                    }, 0);
                }
            ).on(
                'blur.slick',
                '*', 
                function(event) {
                    var $sf = $(this);

                    // When a blur occurs on any elements within the slider we become unfocused
                    if( _.options.pauseOnFocus ) {
                        _.focussed = false;
                        _.autoPlay();
                    }
                }
            );
    };

    Slick.prototype.getCurrent = Slick.prototype.slickCurrentSlide = function() {

        var _ = this;
        return _.currentSlide;

    };

    Slick.prototype.getDotCount = function() {

        var _ = this;

        var breakPoint = 0;
        var counter = 0;
        var pagerQty = 0;

        if (_.options.infinite === true) {
            if (_.slideCount <= _.options.slidesToShow) {
                 ++pagerQty;
            } else {
                while (breakPoint < _.slideCount) {
                    ++pagerQty;
                    breakPoint = counter + _.options.slidesToScroll;
                    counter += _.options.slidesToScroll <= _.options.slidesToShow ? _.options.slidesToScroll : _.options.slidesToShow;
                }
            }
        } else if (_.options.centerMode === true) {
            pagerQty = _.slideCount;
        } else if(!_.options.asNavFor) {
            pagerQty = 1 + Math.ceil((_.slideCount - _.options.slidesToShow) / _.options.slidesToScroll);
        }else {
            while (breakPoint < _.slideCount) {
                ++pagerQty;
                breakPoint = counter + _.options.slidesToScroll;
                counter += _.options.slidesToScroll <= _.options.slidesToShow ? _.options.slidesToScroll : _.options.slidesToShow;
            }
        }

        return pagerQty - 1;

    };

    Slick.prototype.getLeft = function(slideIndex) {

        var _ = this,
            targetLeft,
            verticalHeight,
            verticalOffset = 0,
            targetSlide,
            coef;

        _.slideOffset = 0;
        verticalHeight = _.$slides.first().outerHeight(true);

        if (_.options.infinite === true) {
            if (_.slideCount > _.options.slidesToShow) {
                _.slideOffset = (_.slideWidth * _.options.slidesToShow) * -1;
                coef = -1

                if (_.options.vertical === true && _.options.centerMode === true) {
                    if (_.options.slidesToShow === 2) {
                        coef = -1.5;
                    } else if (_.options.slidesToShow === 1) {
                        coef = -2
                    }
                }
                verticalOffset = (verticalHeight * _.options.slidesToShow) * coef;
            }
            if (_.slideCount % _.options.slidesToScroll !== 0) {
                if (slideIndex + _.options.slidesToScroll > _.slideCount && _.slideCount > _.options.slidesToShow) {
                    if (slideIndex > _.slideCount) {
                        _.slideOffset = ((_.options.slidesToShow - (slideIndex - _.slideCount)) * _.slideWidth) * -1;
                        verticalOffset = ((_.options.slidesToShow - (slideIndex - _.slideCount)) * verticalHeight) * -1;
                    } else {
                        _.slideOffset = ((_.slideCount % _.options.slidesToScroll) * _.slideWidth) * -1;
                        verticalOffset = ((_.slideCount % _.options.slidesToScroll) * verticalHeight) * -1;
                    }
                }
            }
        } else {
            if (slideIndex + _.options.slidesToShow > _.slideCount) {
                _.slideOffset = ((slideIndex + _.options.slidesToShow) - _.slideCount) * _.slideWidth;
                verticalOffset = ((slideIndex + _.options.slidesToShow) - _.slideCount) * verticalHeight;
            }
        }

        if (_.slideCount <= _.options.slidesToShow) {
            _.slideOffset = 0;
            verticalOffset = 0;
        }

        if (_.options.centerMode === true && _.slideCount <= _.options.slidesToShow) {
            _.slideOffset = ((_.slideWidth * Math.floor(_.options.slidesToShow)) / 2) - ((_.slideWidth * _.slideCount) / 2);
        } else if (_.options.centerMode === true && _.options.infinite === true) {
            _.slideOffset += _.slideWidth * Math.floor(_.options.slidesToShow / 2) - _.slideWidth;
        } else if (_.options.centerMode === true) {
            _.slideOffset = 0;
            _.slideOffset += _.slideWidth * Math.floor(_.options.slidesToShow / 2);
        }

        if (_.options.vertical === false) {
            targetLeft = ((slideIndex * _.slideWidth) * -1) + _.slideOffset;
        } else {
            targetLeft = ((slideIndex * verticalHeight) * -1) + verticalOffset;
        }

        if (_.options.variableWidth === true) {

            if (_.slideCount <= _.options.slidesToShow || _.options.infinite === false) {
                targetSlide = _.$slideTrack.children('.slick-slide').eq(slideIndex);
            } else {
                targetSlide = _.$slideTrack.children('.slick-slide').eq(slideIndex + _.options.slidesToShow);
            }

            if (_.options.rtl === true) {
                if (targetSlide[0]) {
                    targetLeft = (_.$slideTrack.width() - targetSlide[0].offsetLeft - targetSlide.width()) * -1;
                } else {
                    targetLeft =  0;
                }
            } else {
                targetLeft = targetSlide[0] ? targetSlide[0].offsetLeft * -1 : 0;
            }

            if (_.options.centerMode === true) {
                if (_.slideCount <= _.options.slidesToShow || _.options.infinite === false) {
                    targetSlide = _.$slideTrack.children('.slick-slide').eq(slideIndex);
                } else {
                    targetSlide = _.$slideTrack.children('.slick-slide').eq(slideIndex + _.options.slidesToShow + 1);
                }

                if (_.options.rtl === true) {
                    if (targetSlide[0]) {
                        targetLeft = (_.$slideTrack.width() - targetSlide[0].offsetLeft - targetSlide.width()) * -1;
                    } else {
                        targetLeft =  0;
                    }
                } else {
                    targetLeft = targetSlide[0] ? targetSlide[0].offsetLeft * -1 : 0;
                }

                targetLeft += (_.$list.width() - targetSlide.outerWidth()) / 2;
            }
        }

        return targetLeft;

    };

    Slick.prototype.getOption = Slick.prototype.slickGetOption = function(option) {

        var _ = this;

        return _.options[option];

    };

    Slick.prototype.getNavigableIndexes = function() {

        var _ = this,
            breakPoint = 0,
            counter = 0,
            indexes = [],
            max;

        if (_.options.infinite === false) {
            max = _.slideCount;
        } else {
            breakPoint = _.options.slidesToScroll * -1;
            counter = _.options.slidesToScroll * -1;
            max = _.slideCount * 2;
        }

        while (breakPoint < max) {
            indexes.push(breakPoint);
            breakPoint = counter + _.options.slidesToScroll;
            counter += _.options.slidesToScroll <= _.options.slidesToShow ? _.options.slidesToScroll : _.options.slidesToShow;
        }

        return indexes;

    };

    Slick.prototype.getSlick = function() {

        return this;

    };

    Slick.prototype.getSlideCount = function() {

        var _ = this,
            slidesTraversed, swipedSlide, swipeTarget, centerOffset;

        centerOffset = _.options.centerMode === true ? Math.floor(_.$list.width() / 2) : 0;
        swipeTarget = (_.swipeLeft * -1) + centerOffset;

        if (_.options.swipeToSlide === true) {

            _.$slideTrack.find('.slick-slide').each(function(index, slide) {

                var slideOuterWidth, slideOffset, slideRightBoundary;
                slideOuterWidth = $(slide).outerWidth();
                slideOffset = slide.offsetLeft;
                if (_.options.centerMode !== true) {
                    slideOffset += (slideOuterWidth / 2);
                }

                slideRightBoundary = slideOffset + (slideOuterWidth);

                if (swipeTarget < slideRightBoundary) {
                    swipedSlide = slide;
                    return false;
                }
            });

            slidesTraversed = Math.abs($(swipedSlide).attr('data-slick-index') - _.currentSlide) || 1;

            return slidesTraversed;

        } else {
            return _.options.slidesToScroll;
        }

    };

    Slick.prototype.goTo = Slick.prototype.slickGoTo = function(slide, dontAnimate) {

        var _ = this;

        _.changeSlide({
            data: {
                message: 'index',
                index: parseInt(slide)
            }
        }, dontAnimate);

    };

    Slick.prototype.init = function(creation) {

        var _ = this;

        if (!$(_.$slider).hasClass('slick-initialized')) {

            $(_.$slider).addClass('slick-initialized');

            _.buildRows();
            _.buildOut();
            _.setProps();
            _.startLoad();
            _.loadSlider();
            _.initializeEvents();
            _.updateArrows();
            _.updateDots();
            _.checkResponsive(true);
            _.focusHandler();

        }

        if (creation) {
            _.$slider.trigger('init', [_]);
        }

        if (_.options.accessibility === true) {
            _.initADA();
        }

        if ( _.options.autoplay ) {

            _.paused = false;
            _.autoPlay();

        }

    };

    Slick.prototype.initADA = function() {
        var _ = this,
                numDotGroups = Math.ceil(_.slideCount / _.options.slidesToShow),
                tabControlIndexes = _.getNavigableIndexes().filter(function(val) {
                    return (val >= 0) && (val < _.slideCount);
                });

        _.$slides.add(_.$slideTrack.find('.slick-cloned')).attr({
            'aria-hidden': 'true',
            'tabindex': '-1'
        }).find('a, input, button, select').attr({
            'tabindex': '-1'
        });

        if (_.$dots !== null) {
            _.$slides.not(_.$slideTrack.find('.slick-cloned')).each(function(i) {
                var slideControlIndex = tabControlIndexes.indexOf(i);

                $(this).attr({
                    'role': 'tabpanel',
                    'id': 'slick-slide' + _.instanceUid + i,
                    'tabindex': -1
                });

                if (slideControlIndex !== -1) {
                   var ariaButtonControl = 'slick-slide-control' + _.instanceUid + slideControlIndex
                   if ($('#' + ariaButtonControl).length) {
                     $(this).attr({
                         'aria-describedby': ariaButtonControl
                     });
                   }
                }
            });

            _.$dots.attr('role', 'tablist').find('li').each(function(i) {
                var mappedSlideIndex = tabControlIndexes[i];

                $(this).attr({
                    'role': 'presentation'
                });

                $(this).find('button').first().attr({
                    'role': 'tab',
                    'id': 'slick-slide-control' + _.instanceUid + i,
                    'aria-controls': 'slick-slide' + _.instanceUid + mappedSlideIndex,
                    'aria-label': (i + 1) + ' of ' + numDotGroups,
                    'aria-selected': null,
                    'tabindex': '-1'
                });

            }).eq(_.currentSlide).find('button').attr({
                'aria-selected': 'true',
                'tabindex': '0'
            }).end();
        }

        for (var i=_.currentSlide, max=i+_.options.slidesToShow; i < max; i++) {
          if (_.options.focusOnChange) {
            _.$slides.eq(i).attr({'tabindex': '0'});
          } else {
            _.$slides.eq(i).removeAttr('tabindex');
          }
        }

        _.activateADA();

    };

    Slick.prototype.initArrowEvents = function() {

        var _ = this;

        if (_.options.arrows === true && _.slideCount > _.options.slidesToShow) {
            _.$prevArrow
               .off('click.slick')
               .on('click.slick', {
                    message: 'previous'
               }, _.changeSlide);
            _.$nextArrow
               .off('click.slick')
               .on('click.slick', {
                    message: 'next'
               }, _.changeSlide);

            if (_.options.accessibility === true) {
                _.$prevArrow.on('keydown.slick', _.keyHandler);
                _.$nextArrow.on('keydown.slick', _.keyHandler);
            }
        }

    };

    Slick.prototype.initDotEvents = function() {

        var _ = this;

        if (_.options.dots === true && _.slideCount > _.options.slidesToShow) {
            $('li', _.$dots).on('click.slick', {
                message: 'index'
            }, _.changeSlide);

            if (_.options.accessibility === true) {
                _.$dots.on('keydown.slick', _.keyHandler);
            }
        }

        if (_.options.dots === true && _.options.pauseOnDotsHover === true && _.slideCount > _.options.slidesToShow) {

            $('li', _.$dots)
                .on('mouseenter.slick', $.proxy(_.interrupt, _, true))
                .on('mouseleave.slick', $.proxy(_.interrupt, _, false));

        }

    };

    Slick.prototype.initSlideEvents = function() {

        var _ = this;

        if ( _.options.pauseOnHover ) {

            _.$list.on('mouseenter.slick', $.proxy(_.interrupt, _, true));
            _.$list.on('mouseleave.slick', $.proxy(_.interrupt, _, false));

        }

    };

    Slick.prototype.initializeEvents = function() {

        var _ = this;

        _.initArrowEvents();

        _.initDotEvents();
        _.initSlideEvents();

        _.$list.on('touchstart.slick mousedown.slick', {
            action: 'start'
        }, _.swipeHandler);
        _.$list.on('touchmove.slick mousemove.slick', {
            action: 'move'
        }, _.swipeHandler);
        _.$list.on('touchend.slick mouseup.slick', {
            action: 'end'
        }, _.swipeHandler);
        _.$list.on('touchcancel.slick mouseleave.slick', {
            action: 'end'
        }, _.swipeHandler);

        _.$list.on('click.slick', _.clickHandler);

        $(document).on(_.visibilityChange, $.proxy(_.visibility, _));

        if (_.options.accessibility === true) {
            _.$list.on('keydown.slick', _.keyHandler);
        }

        if (_.options.focusOnSelect === true) {
            $(_.$slideTrack).children().on('click.slick', _.selectHandler);
        }

        $(window).on('orientationchange.slick.slick-' + _.instanceUid, $.proxy(_.orientationChange, _));

        $(window).on('resize.slick.slick-' + _.instanceUid, $.proxy(_.resize, _));

        $('[draggable!=true]', _.$slideTrack).on('dragstart', _.preventDefault);

        $(window).on('load.slick.slick-' + _.instanceUid, _.setPosition);
        $(_.setPosition);

    };

    Slick.prototype.initUI = function() {

        var _ = this;

        if (_.options.arrows === true && _.slideCount > _.options.slidesToShow) {

            _.$prevArrow.show();
            _.$nextArrow.show();

        }

        if (_.options.dots === true && _.slideCount > _.options.slidesToShow) {

            _.$dots.show();

        }

    };

    Slick.prototype.keyHandler = function(event) {

        var _ = this;
         //Dont slide if the cursor is inside the form fields and arrow keys are pressed
        if(!event.target.tagName.match('TEXTAREA|INPUT|SELECT')) {
            if (event.keyCode === 37 && _.options.accessibility === true) {
                _.changeSlide({
                    data: {
                        message: _.options.rtl === true ? 'next' :  'previous'
                    }
                });
            } else if (event.keyCode === 39 && _.options.accessibility === true) {
                _.changeSlide({
                    data: {
                        message: _.options.rtl === true ? 'previous' : 'next'
                    }
                });
            }
        }

    };

    Slick.prototype.lazyLoad = function() {

        var _ = this,
            loadRange, cloneRange, rangeStart, rangeEnd;

        function loadImages(imagesScope) {

            $('img[data-lazy]', imagesScope).each(function() {

                var image = $(this),
                    imageSource = $(this).attr('data-lazy'),
                    imageSrcSet = $(this).attr('data-srcset'),
                    imageSizes  = $(this).attr('data-sizes') || _.$slider.attr('data-sizes'),
                    imageToLoad = document.createElement('img');

                imageToLoad.onload = function() {

                    image
                        .animate({ opacity: 0 }, 100, function() {

                            if (imageSrcSet) {
                                image
                                    .attr('srcset', imageSrcSet );

                                if (imageSizes) {
                                    image
                                        .attr('sizes', imageSizes );
                                }
                            }

                            image
                                .attr('src', imageSource)
                                .animate({ opacity: 1 }, 200, function() {
                                    image
                                        .removeAttr('data-lazy data-srcset data-sizes')
                                        .removeClass('slick-loading');
                                });
                            _.$slider.trigger('lazyLoaded', [_, image, imageSource]);
                        });

                };

                imageToLoad.onerror = function() {

                    image
                        .removeAttr( 'data-lazy' )
                        .removeClass( 'slick-loading' )
                        .addClass( 'slick-lazyload-error' );

                    _.$slider.trigger('lazyLoadError', [ _, image, imageSource ]);

                };

                imageToLoad.src = imageSource;

            });

        }

        if (_.options.centerMode === true) {
            if (_.options.infinite === true) {
                rangeStart = _.currentSlide + (_.options.slidesToShow / 2 + 1);
                rangeEnd = rangeStart + _.options.slidesToShow + 2;
            } else {
                rangeStart = Math.max(0, _.currentSlide - (_.options.slidesToShow / 2 + 1));
                rangeEnd = 2 + (_.options.slidesToShow / 2 + 1) + _.currentSlide;
            }
        } else {
            rangeStart = _.options.infinite ? _.options.slidesToShow + _.currentSlide : _.currentSlide;
            rangeEnd = Math.ceil(rangeStart + _.options.slidesToShow);
            if (_.options.fade === true) {
                if (rangeStart > 0) rangeStart--;
                if (rangeEnd <= _.slideCount) rangeEnd++;
            }
        }

        loadRange = _.$slider.find('.slick-slide').slice(rangeStart, rangeEnd);

        if (_.options.lazyLoad === 'anticipated') {
            var prevSlide = rangeStart - 1,
                nextSlide = rangeEnd,
                $slides = _.$slider.find('.slick-slide');

            for (var i = 0; i < _.options.slidesToScroll; i++) {
                if (prevSlide < 0) prevSlide = _.slideCount - 1;
                loadRange = loadRange.add($slides.eq(prevSlide));
                loadRange = loadRange.add($slides.eq(nextSlide));
                prevSlide--;
                nextSlide++;
            }
        }

        loadImages(loadRange);

        if (_.slideCount <= _.options.slidesToShow) {
            cloneRange = _.$slider.find('.slick-slide');
            loadImages(cloneRange);
        } else
        if (_.currentSlide >= _.slideCount - _.options.slidesToShow) {
            cloneRange = _.$slider.find('.slick-cloned').slice(0, _.options.slidesToShow);
            loadImages(cloneRange);
        } else if (_.currentSlide === 0) {
            cloneRange = _.$slider.find('.slick-cloned').slice(_.options.slidesToShow * -1);
            loadImages(cloneRange);
        }

    };

    Slick.prototype.loadSlider = function() {

        var _ = this;

        _.setPosition();

        _.$slideTrack.css({
            opacity: 1
        });

        _.$slider.removeClass('slick-loading');

        _.initUI();

        if (_.options.lazyLoad === 'progressive') {
            _.progressiveLazyLoad();
        }

    };

    Slick.prototype.next = Slick.prototype.slickNext = function() {

        var _ = this;

        _.changeSlide({
            data: {
                message: 'next'
            }
        });

    };

    Slick.prototype.orientationChange = function() {

        var _ = this;

        _.checkResponsive();
        _.setPosition();

    };

    Slick.prototype.pause = Slick.prototype.slickPause = function() {

        var _ = this;

        _.autoPlayClear();
        _.paused = true;

    };

    Slick.prototype.play = Slick.prototype.slickPlay = function() {

        var _ = this;

        _.autoPlay();
        _.options.autoplay = true;
        _.paused = false;
        _.focussed = false;
        _.interrupted = false;

    };

    Slick.prototype.postSlide = function(index) {

        var _ = this;

        if( !_.unslicked ) {

            _.$slider.trigger('afterChange', [_, index]);

            _.animating = false;

            if (_.slideCount > _.options.slidesToShow) {
                _.setPosition();
            }

            _.swipeLeft = null;

            if ( _.options.autoplay ) {
                _.autoPlay();
            }

            if (_.options.accessibility === true) {
                _.initADA();

                if (_.options.focusOnChange) {
                    var $currentSlide = $(_.$slides.get(_.currentSlide));
                    $currentSlide.attr('tabindex', 0).focus();
                }
            }

        }

    };

    Slick.prototype.prev = Slick.prototype.slickPrev = function() {

        var _ = this;

        _.changeSlide({
            data: {
                message: 'previous'
            }
        });

    };

    Slick.prototype.preventDefault = function(event) {

        event.preventDefault();

    };

    Slick.prototype.progressiveLazyLoad = function( tryCount ) {

        tryCount = tryCount || 1;

        var _ = this,
            $imgsToLoad = $( 'img[data-lazy]', _.$slider ),
            image,
            imageSource,
            imageSrcSet,
            imageSizes,
            imageToLoad;

        if ( $imgsToLoad.length ) {

            image = $imgsToLoad.first();
            imageSource = image.attr('data-lazy');
            imageSrcSet = image.attr('data-srcset');
            imageSizes  = image.attr('data-sizes') || _.$slider.attr('data-sizes');
            imageToLoad = document.createElement('img');

            imageToLoad.onload = function() {

                if (imageSrcSet) {
                    image
                        .attr('srcset', imageSrcSet );

                    if (imageSizes) {
                        image
                            .attr('sizes', imageSizes );
                    }
                }

                image
                    .attr( 'src', imageSource )
                    .removeAttr('data-lazy data-srcset data-sizes')
                    .removeClass('slick-loading');

                if ( _.options.adaptiveHeight === true ) {
                    _.setPosition();
                }

                _.$slider.trigger('lazyLoaded', [ _, image, imageSource ]);
                _.progressiveLazyLoad();

            };

            imageToLoad.onerror = function() {

                if ( tryCount < 3 ) {

                    /**
                     * try to load the image 3 times,
                     * leave a slight delay so we don't get
                     * servers blocking the request.
                     */
                    setTimeout( function() {
                        _.progressiveLazyLoad( tryCount + 1 );
                    }, 500 );

                } else {

                    image
                        .removeAttr( 'data-lazy' )
                        .removeClass( 'slick-loading' )
                        .addClass( 'slick-lazyload-error' );

                    _.$slider.trigger('lazyLoadError', [ _, image, imageSource ]);

                    _.progressiveLazyLoad();

                }

            };

            imageToLoad.src = imageSource;

        } else {

            _.$slider.trigger('allImagesLoaded', [ _ ]);

        }

    };

    Slick.prototype.refresh = function( initializing ) {

        var _ = this, currentSlide, lastVisibleIndex;

        lastVisibleIndex = _.slideCount - _.options.slidesToShow;

        // in non-infinite sliders, we don't want to go past the
        // last visible index.
        if( !_.options.infinite && ( _.currentSlide > lastVisibleIndex )) {
            _.currentSlide = lastVisibleIndex;
        }

        // if less slides than to show, go to start.
        if ( _.slideCount <= _.options.slidesToShow ) {
            _.currentSlide = 0;

        }

        currentSlide = _.currentSlide;

        _.destroy(true);

        $.extend(_, _.initials, { currentSlide: currentSlide });

        _.init();

        if( !initializing ) {

            _.changeSlide({
                data: {
                    message: 'index',
                    index: currentSlide
                }
            }, false);

        }

    };

    Slick.prototype.registerBreakpoints = function() {

        var _ = this, breakpoint, currentBreakpoint, l,
            responsiveSettings = _.options.responsive || null;

        if ( $.type(responsiveSettings) === 'array' && responsiveSettings.length ) {

            _.respondTo = _.options.respondTo || 'window';

            for ( breakpoint in responsiveSettings ) {

                l = _.breakpoints.length-1;

                if (responsiveSettings.hasOwnProperty(breakpoint)) {
                    currentBreakpoint = responsiveSettings[breakpoint].breakpoint;

                    // loop through the breakpoints and cut out any existing
                    // ones with the same breakpoint number, we don't want dupes.
                    while( l >= 0 ) {
                        if( _.breakpoints[l] && _.breakpoints[l] === currentBreakpoint ) {
                            _.breakpoints.splice(l,1);
                        }
                        l--;
                    }

                    _.breakpoints.push(currentBreakpoint);
                    _.breakpointSettings[currentBreakpoint] = responsiveSettings[breakpoint].settings;

                }

            }

            _.breakpoints.sort(function(a, b) {
                return ( _.options.mobileFirst ) ? a-b : b-a;
            });

        }

    };

    Slick.prototype.reinit = function() {

        var _ = this;

        _.$slides =
            _.$slideTrack
                .children(_.options.slide)
                .addClass('slick-slide');

        _.slideCount = _.$slides.length;

        if (_.currentSlide >= _.slideCount && _.currentSlide !== 0) {
            _.currentSlide = _.currentSlide - _.options.slidesToScroll;
        }

        if (_.slideCount <= _.options.slidesToShow) {
            _.currentSlide = 0;
        }

        _.registerBreakpoints();

        _.setProps();
        _.setupInfinite();
        _.buildArrows();
        _.updateArrows();
        _.initArrowEvents();
        _.buildDots();
        _.updateDots();
        _.initDotEvents();
        _.cleanUpSlideEvents();
        _.initSlideEvents();

        _.checkResponsive(false, true);

        if (_.options.focusOnSelect === true) {
            $(_.$slideTrack).children().on('click.slick', _.selectHandler);
        }

        _.setSlideClasses(typeof _.currentSlide === 'number' ? _.currentSlide : 0);

        _.setPosition();
        _.focusHandler();

        _.paused = !_.options.autoplay;
        _.autoPlay();

        _.$slider.trigger('reInit', [_]);

    };

    Slick.prototype.resize = function() {

        var _ = this;

        if ($(window).width() !== _.windowWidth) {
            clearTimeout(_.windowDelay);
            _.windowDelay = window.setTimeout(function() {
                _.windowWidth = $(window).width();
                _.checkResponsive();
                if( !_.unslicked ) { _.setPosition(); }
            }, 50);
        }
    };

    Slick.prototype.removeSlide = Slick.prototype.slickRemove = function(index, removeBefore, removeAll) {

        var _ = this;

        if (typeof(index) === 'boolean') {
            removeBefore = index;
            index = removeBefore === true ? 0 : _.slideCount - 1;
        } else {
            index = removeBefore === true ? --index : index;
        }

        if (_.slideCount < 1 || index < 0 || index > _.slideCount - 1) {
            return false;
        }

        _.unload();

        if (removeAll === true) {
            _.$slideTrack.children().remove();
        } else {
            _.$slideTrack.children(this.options.slide).eq(index).remove();
        }

        _.$slides = _.$slideTrack.children(this.options.slide);

        _.$slideTrack.children(this.options.slide).detach();

        _.$slideTrack.append(_.$slides);

        _.$slidesCache = _.$slides;

        _.reinit();

    };

    Slick.prototype.setCSS = function(position) {

        var _ = this,
            positionProps = {},
            x, y;

        if (_.options.rtl === true) {
            position = -position;
        }
        x = _.positionProp == 'left' ? Math.ceil(position) + 'px' : '0px';
        y = _.positionProp == 'top' ? Math.ceil(position) + 'px' : '0px';

        positionProps[_.positionProp] = position;

        if (_.transformsEnabled === false) {
            _.$slideTrack.css(positionProps);
        } else {
            positionProps = {};
            if (_.cssTransitions === false) {
                positionProps[_.animType] = 'translate(' + x + ', ' + y + ')';
                _.$slideTrack.css(positionProps);
            } else {
                positionProps[_.animType] = 'translate3d(' + x + ', ' + y + ', 0px)';
                _.$slideTrack.css(positionProps);
            }
        }

    };

    Slick.prototype.setDimensions = function() {

        var _ = this;

        if (_.options.vertical === false) {
            if (_.options.centerMode === true) {
                _.$list.css({
                    padding: ('0px ' + _.options.centerPadding)
                });
            }
        } else {
            _.$list.height(_.$slides.first().outerHeight(true) * _.options.slidesToShow);
            if (_.options.centerMode === true) {
                _.$list.css({
                    padding: (_.options.centerPadding + ' 0px')
                });
            }
        }

        _.listWidth = _.$list.width();
        _.listHeight = _.$list.height();


        if (_.options.vertical === false && _.options.variableWidth === false) {
            _.slideWidth = Math.ceil(_.listWidth / _.options.slidesToShow);
            _.$slideTrack.width(Math.ceil((_.slideWidth * _.$slideTrack.children('.slick-slide').length)));

        } else if (_.options.variableWidth === true) {
            _.$slideTrack.width(5000 * _.slideCount);
        } else {
            _.slideWidth = Math.ceil(_.listWidth);
            _.$slideTrack.height(Math.ceil((_.$slides.first().outerHeight(true) * _.$slideTrack.children('.slick-slide').length)));
        }

        var offset = _.$slides.first().outerWidth(true) - _.$slides.first().width();
        if (_.options.variableWidth === false) _.$slideTrack.children('.slick-slide').width(_.slideWidth - offset);

    };

    Slick.prototype.setFade = function() {

        var _ = this,
            targetLeft;

        _.$slides.each(function(index, element) {
            targetLeft = (_.slideWidth * index) * -1;
            if (_.options.rtl === true) {
                $(element).css({
                    position: 'relative',
                    right: targetLeft,
                    top: 0,
                    zIndex: _.options.zIndex - 2,
                    opacity: 0
                });
            } else {
                $(element).css({
                    position: 'relative',
                    left: targetLeft,
                    top: 0,
                    zIndex: _.options.zIndex - 2,
                    opacity: 0
                });
            }
        });

        _.$slides.eq(_.currentSlide).css({
            zIndex: _.options.zIndex - 1,
            opacity: 1
        });

    };

    Slick.prototype.setHeight = function() {

        var _ = this;

        if (_.options.slidesToShow === 1 && _.options.adaptiveHeight === true && _.options.vertical === false) {
            var targetHeight = _.$slides.eq(_.currentSlide).outerHeight(true);
            _.$list.css('height', targetHeight);
        }

    };

    Slick.prototype.setOption =
    Slick.prototype.slickSetOption = function() {

        /**
         * accepts arguments in format of:
         *
         *  - for changing a single option's value:
         *     .slick("setOption", option, value, refresh )
         *
         *  - for changing a set of responsive options:
         *     .slick("setOption", 'responsive', [{}, ...], refresh )
         *
         *  - for updating multiple values at once (not responsive)
         *     .slick("setOption", { 'option': value, ... }, refresh )
         */

        var _ = this, l, item, option, value, refresh = false, type;

        if( $.type( arguments[0] ) === 'object' ) {

            option =  arguments[0];
            refresh = arguments[1];
            type = 'multiple';

        } else if ( $.type( arguments[0] ) === 'string' ) {

            option =  arguments[0];
            value = arguments[1];
            refresh = arguments[2];

            if ( arguments[0] === 'responsive' && $.type( arguments[1] ) === 'array' ) {

                type = 'responsive';

            } else if ( typeof arguments[1] !== 'undefined' ) {

                type = 'single';

            }

        }

        if ( type === 'single' ) {

            _.options[option] = value;


        } else if ( type === 'multiple' ) {

            $.each( option , function( opt, val ) {

                _.options[opt] = val;

            });


        } else if ( type === 'responsive' ) {

            for ( item in value ) {

                if( $.type( _.options.responsive ) !== 'array' ) {

                    _.options.responsive = [ value[item] ];

                } else {

                    l = _.options.responsive.length-1;

                    // loop through the responsive object and splice out duplicates.
                    while( l >= 0 ) {

                        if( _.options.responsive[l].breakpoint === value[item].breakpoint ) {

                            _.options.responsive.splice(l,1);

                        }

                        l--;

                    }

                    _.options.responsive.push( value[item] );

                }

            }

        }

        if ( refresh ) {

            _.unload();
            _.reinit();

        }

    };

    Slick.prototype.setPosition = function() {

        var _ = this;

        _.setDimensions();

        _.setHeight();

        if (_.options.fade === false) {
            _.setCSS(_.getLeft(_.currentSlide));
        } else {
            _.setFade();
        }

        _.$slider.trigger('setPosition', [_]);

    };

    Slick.prototype.setProps = function() {

        var _ = this,
            bodyStyle = document.body.style;

        _.positionProp = _.options.vertical === true ? 'top' : 'left';

        if (_.positionProp === 'top') {
            _.$slider.addClass('slick-vertical');
        } else {
            _.$slider.removeClass('slick-vertical');
        }

        if (bodyStyle.WebkitTransition !== undefined ||
            bodyStyle.MozTransition !== undefined ||
            bodyStyle.msTransition !== undefined) {
            if (_.options.useCSS === true) {
                _.cssTransitions = true;
            }
        }

        if ( _.options.fade ) {
            if ( typeof _.options.zIndex === 'number' ) {
                if( _.options.zIndex < 3 ) {
                    _.options.zIndex = 3;
                }
            } else {
                _.options.zIndex = _.defaults.zIndex;
            }
        }

        if (bodyStyle.OTransform !== undefined) {
            _.animType = 'OTransform';
            _.transformType = '-o-transform';
            _.transitionType = 'OTransition';
            if (bodyStyle.perspectiveProperty === undefined && bodyStyle.webkitPerspective === undefined) _.animType = false;
        }
        if (bodyStyle.MozTransform !== undefined) {
            _.animType = 'MozTransform';
            _.transformType = '-moz-transform';
            _.transitionType = 'MozTransition';
            if (bodyStyle.perspectiveProperty === undefined && bodyStyle.MozPerspective === undefined) _.animType = false;
        }
        if (bodyStyle.webkitTransform !== undefined) {
            _.animType = 'webkitTransform';
            _.transformType = '-webkit-transform';
            _.transitionType = 'webkitTransition';
            if (bodyStyle.perspectiveProperty === undefined && bodyStyle.webkitPerspective === undefined) _.animType = false;
        }
        if (bodyStyle.msTransform !== undefined) {
            _.animType = 'msTransform';
            _.transformType = '-ms-transform';
            _.transitionType = 'msTransition';
            if (bodyStyle.msTransform === undefined) _.animType = false;
        }
        if (bodyStyle.transform !== undefined && _.animType !== false) {
            _.animType = 'transform';
            _.transformType = 'transform';
            _.transitionType = 'transition';
        }
        _.transformsEnabled = _.options.useTransform && (_.animType !== null && _.animType !== false);
    };


    Slick.prototype.setSlideClasses = function(index) {

        var _ = this,
            centerOffset, allSlides, indexOffset, remainder;

        allSlides = _.$slider
            .find('.slick-slide')
            .removeClass('slick-active slick-center slick-current')
            .attr('aria-hidden', 'true');

        _.$slides
            .eq(index)
            .addClass('slick-current');

        if (_.options.centerMode === true) {

            var evenCoef = _.options.slidesToShow % 2 === 0 ? 1 : 0;

            centerOffset = Math.floor(_.options.slidesToShow / 2);

            if (_.options.infinite === true) {

                if (index >= centerOffset && index <= (_.slideCount - 1) - centerOffset) {
                    _.$slides
                        .slice(index - centerOffset + evenCoef, index + centerOffset + 1)
                        .addClass('slick-active')
                        .attr('aria-hidden', 'false');

                } else {

                    indexOffset = _.options.slidesToShow + index;
                    allSlides
                        .slice(indexOffset - centerOffset + 1 + evenCoef, indexOffset + centerOffset + 2)
                        .addClass('slick-active')
                        .attr('aria-hidden', 'false');

                }

                if (index === 0) {

                    allSlides
                        .eq( _.options.slidesToShow + _.slideCount + 1 )
                        .addClass('slick-center');

                } else if (index === _.slideCount - 1) {

                    allSlides
                        .eq(_.options.slidesToShow)
                        .addClass('slick-center');

                }

            }

            _.$slides
                .eq(index)
                .addClass('slick-center');

        } else {

            if (index >= 0 && index <= (_.slideCount - _.options.slidesToShow)) {

                _.$slides
                    .slice(index, index + _.options.slidesToShow)
                    .addClass('slick-active')
                    .attr('aria-hidden', 'false');

            } else if (allSlides.length <= _.options.slidesToShow) {

                allSlides
                    .addClass('slick-active')
                    .attr('aria-hidden', 'false');

            } else {

                remainder = _.slideCount % _.options.slidesToShow;
                indexOffset = _.options.infinite === true ? _.options.slidesToShow + index : index;

                if (_.options.slidesToShow == _.options.slidesToScroll && (_.slideCount - index) < _.options.slidesToShow) {

                    allSlides
                        .slice(indexOffset - (_.options.slidesToShow - remainder), indexOffset + remainder)
                        .addClass('slick-active')
                        .attr('aria-hidden', 'false');

                } else {

                    allSlides
                        .slice(indexOffset, indexOffset + _.options.slidesToShow)
                        .addClass('slick-active')
                        .attr('aria-hidden', 'false');

                }

            }

        }

        if (_.options.lazyLoad === 'ondemand' || _.options.lazyLoad === 'anticipated') {
            _.lazyLoad();
        }
    };

    Slick.prototype.setupInfinite = function() {

        var _ = this,
            i, slideIndex, infiniteCount;

        if (_.options.fade === true) {
            _.options.centerMode = false;
        }

        if (_.options.infinite === true && _.options.fade === false) {

            slideIndex = null;

            if (_.slideCount > _.options.slidesToShow) {

                if (_.options.centerMode === true) {
                    infiniteCount = _.options.slidesToShow + 1;
                } else {
                    infiniteCount = _.options.slidesToShow;
                }

                for (i = _.slideCount; i > (_.slideCount -
                        infiniteCount); i -= 1) {
                    slideIndex = i - 1;
                    $(_.$slides[slideIndex]).clone(true).attr('id', '')
                        .attr('data-slick-index', slideIndex - _.slideCount)
                        .prependTo(_.$slideTrack).addClass('slick-cloned');
                }
                for (i = 0; i < infiniteCount  + _.slideCount; i += 1) {
                    slideIndex = i;
                    $(_.$slides[slideIndex]).clone(true).attr('id', '')
                        .attr('data-slick-index', slideIndex + _.slideCount)
                        .appendTo(_.$slideTrack).addClass('slick-cloned');
                }
                _.$slideTrack.find('.slick-cloned').find('[id]').each(function() {
                    $(this).attr('id', '');
                });

            }

        }

    };

    Slick.prototype.interrupt = function( toggle ) {

        var _ = this;

        if( !toggle ) {
            _.autoPlay();
        }
        _.interrupted = toggle;

    };

    Slick.prototype.selectHandler = function(event) {

        var _ = this;

        var targetElement =
            $(event.target).is('.slick-slide') ?
                $(event.target) :
                $(event.target).parents('.slick-slide');

        var index = parseInt(targetElement.attr('data-slick-index'));

        if (!index) index = 0;

        if (_.slideCount <= _.options.slidesToShow) {

            _.slideHandler(index, false, true);
            return;

        }

        _.slideHandler(index);

    };

    Slick.prototype.slideHandler = function(index, sync, dontAnimate) {

        var targetSlide, animSlide, oldSlide, slideLeft, targetLeft = null,
            _ = this, navTarget;

        sync = sync || false;

        if (_.animating === true && _.options.waitForAnimate === true) {
            return;
        }

        if (_.options.fade === true && _.currentSlide === index) {
            return;
        }

        if (sync === false) {
            _.asNavFor(index);
        }

        targetSlide = index;
        targetLeft = _.getLeft(targetSlide);
        slideLeft = _.getLeft(_.currentSlide);

        _.currentLeft = _.swipeLeft === null ? slideLeft : _.swipeLeft;

        if (_.options.infinite === false && _.options.centerMode === false && (index < 0 || index > _.getDotCount() * _.options.slidesToScroll)) {
            if (_.options.fade === false) {
                targetSlide = _.currentSlide;
                if (dontAnimate !== true && _.slideCount > _.options.slidesToShow) {
                    _.animateSlide(slideLeft, function() {
                        _.postSlide(targetSlide);
                    });
                } else {
                    _.postSlide(targetSlide);
                }
            }
            return;
        } else if (_.options.infinite === false && _.options.centerMode === true && (index < 0 || index > (_.slideCount - _.options.slidesToScroll))) {
            if (_.options.fade === false) {
                targetSlide = _.currentSlide;
                if (dontAnimate !== true && _.slideCount > _.options.slidesToShow) {
                    _.animateSlide(slideLeft, function() {
                        _.postSlide(targetSlide);
                    });
                } else {
                    _.postSlide(targetSlide);
                }
            }
            return;
        }

        if ( _.options.autoplay ) {
            clearInterval(_.autoPlayTimer);
        }

        if (targetSlide < 0) {
            if (_.slideCount % _.options.slidesToScroll !== 0) {
                animSlide = _.slideCount - (_.slideCount % _.options.slidesToScroll);
            } else {
                animSlide = _.slideCount + targetSlide;
            }
        } else if (targetSlide >= _.slideCount) {
            if (_.slideCount % _.options.slidesToScroll !== 0) {
                animSlide = 0;
            } else {
                animSlide = targetSlide - _.slideCount;
            }
        } else {
            animSlide = targetSlide;
        }

        _.animating = true;

        _.$slider.trigger('beforeChange', [_, _.currentSlide, animSlide]);

        oldSlide = _.currentSlide;
        _.currentSlide = animSlide;

        _.setSlideClasses(_.currentSlide);

        if ( _.options.asNavFor ) {

            navTarget = _.getNavTarget();
            navTarget = navTarget.slick('getSlick');

            if ( navTarget.slideCount <= navTarget.options.slidesToShow ) {
                navTarget.setSlideClasses(_.currentSlide);
            }

        }

        _.updateDots();
        _.updateArrows();

        if (_.options.fade === true) {
            if (dontAnimate !== true) {

                _.fadeSlideOut(oldSlide);

                _.fadeSlide(animSlide, function() {
                    _.postSlide(animSlide);
                });

            } else {
                _.postSlide(animSlide);
            }
            _.animateHeight();
            return;
        }

        if (dontAnimate !== true && _.slideCount > _.options.slidesToShow) {
            _.animateSlide(targetLeft, function() {
                _.postSlide(animSlide);
            });
        } else {
            _.postSlide(animSlide);
        }

    };

    Slick.prototype.startLoad = function() {

        var _ = this;

        if (_.options.arrows === true && _.slideCount > _.options.slidesToShow) {

            _.$prevArrow.hide();
            _.$nextArrow.hide();

        }

        if (_.options.dots === true && _.slideCount > _.options.slidesToShow) {

            _.$dots.hide();

        }

        _.$slider.addClass('slick-loading');

    };

    Slick.prototype.swipeDirection = function() {

        var xDist, yDist, r, swipeAngle, _ = this;

        xDist = _.touchObject.startX - _.touchObject.curX;
        yDist = _.touchObject.startY - _.touchObject.curY;
        r = Math.atan2(yDist, xDist);

        swipeAngle = Math.round(r * 180 / Math.PI);
        if (swipeAngle < 0) {
            swipeAngle = 360 - Math.abs(swipeAngle);
        }

        if ((swipeAngle <= 45) && (swipeAngle >= 0)) {
            return (_.options.rtl === false ? 'left' : 'right');
        }
        if ((swipeAngle <= 360) && (swipeAngle >= 315)) {
            return (_.options.rtl === false ? 'left' : 'right');
        }
        if ((swipeAngle >= 135) && (swipeAngle <= 225)) {
            return (_.options.rtl === false ? 'right' : 'left');
        }
        if (_.options.verticalSwiping === true) {
            if ((swipeAngle >= 35) && (swipeAngle <= 135)) {
                return 'down';
            } else {
                return 'up';
            }
        }

        return 'vertical';

    };

    Slick.prototype.swipeEnd = function(event) {

        var _ = this,
            slideCount,
            direction;

        _.dragging = false;
        _.swiping = false;

        if (_.scrolling) {
            _.scrolling = false;
            return false;
        }

        _.interrupted = false;
        _.shouldClick = ( _.touchObject.swipeLength > 10 ) ? false : true;

        if ( _.touchObject.curX === undefined ) {
            return false;
        }

        if ( _.touchObject.edgeHit === true ) {
            _.$slider.trigger('edge', [_, _.swipeDirection() ]);
        }

        if ( _.touchObject.swipeLength >= _.touchObject.minSwipe ) {

            direction = _.swipeDirection();

            switch ( direction ) {

                case 'left':
                case 'down':

                    slideCount =
                        _.options.swipeToSlide ?
                            _.checkNavigable( _.currentSlide + _.getSlideCount() ) :
                            _.currentSlide + _.getSlideCount();

                    _.currentDirection = 0;

                    break;

                case 'right':
                case 'up':

                    slideCount =
                        _.options.swipeToSlide ?
                            _.checkNavigable( _.currentSlide - _.getSlideCount() ) :
                            _.currentSlide - _.getSlideCount();

                    _.currentDirection = 1;

                    break;

                default:


            }

            if( direction != 'vertical' ) {

                _.slideHandler( slideCount );
                _.touchObject = {};
                _.$slider.trigger('swipe', [_, direction ]);

            }

        } else {

            if ( _.touchObject.startX !== _.touchObject.curX ) {

                _.slideHandler( _.currentSlide );
                _.touchObject = {};

            }

        }

    };

    Slick.prototype.swipeHandler = function(event) {

        var _ = this;

        if ((_.options.swipe === false) || ('ontouchend' in document && _.options.swipe === false)) {
            return;
        } else if (_.options.draggable === false && event.type.indexOf('mouse') !== -1) {
            return;
        }

        _.touchObject.fingerCount = event.originalEvent && event.originalEvent.touches !== undefined ?
            event.originalEvent.touches.length : 1;

        _.touchObject.minSwipe = _.listWidth / _.options
            .touchThreshold;

        if (_.options.verticalSwiping === true) {
            _.touchObject.minSwipe = _.listHeight / _.options
                .touchThreshold;
        }

        switch (event.data.action) {

            case 'start':
                _.swipeStart(event);
                break;

            case 'move':
                _.swipeMove(event);
                break;

            case 'end':
                _.swipeEnd(event);
                break;

        }

    };

    Slick.prototype.swipeMove = function(event) {

        var _ = this,
            edgeWasHit = false,
            curLeft, swipeDirection, swipeLength, positionOffset, touches, verticalSwipeLength;

        touches = event.originalEvent !== undefined ? event.originalEvent.touches : null;

        if (!_.dragging || _.scrolling || touches && touches.length !== 1) {
            return false;
        }

        curLeft = _.getLeft(_.currentSlide);

        _.touchObject.curX = touches !== undefined ? touches[0].pageX : event.clientX;
        _.touchObject.curY = touches !== undefined ? touches[0].pageY : event.clientY;

        _.touchObject.swipeLength = Math.round(Math.sqrt(
            Math.pow(_.touchObject.curX - _.touchObject.startX, 2)));

        verticalSwipeLength = Math.round(Math.sqrt(
            Math.pow(_.touchObject.curY - _.touchObject.startY, 2)));

        if (!_.options.verticalSwiping && !_.swiping && verticalSwipeLength > 4) {
            _.scrolling = true;
            return false;
        }

        if (_.options.verticalSwiping === true) {
            _.touchObject.swipeLength = verticalSwipeLength;
        }

        swipeDirection = _.swipeDirection();

        if (event.originalEvent !== undefined && _.touchObject.swipeLength > 4) {
            _.swiping = true;
            event.preventDefault();
        }

        positionOffset = (_.options.rtl === false ? 1 : -1) * (_.touchObject.curX > _.touchObject.startX ? 1 : -1);
        if (_.options.verticalSwiping === true) {
            positionOffset = _.touchObject.curY > _.touchObject.startY ? 1 : -1;
        }


        swipeLength = _.touchObject.swipeLength;

        _.touchObject.edgeHit = false;

        if (_.options.infinite === false) {
            if ((_.currentSlide === 0 && swipeDirection === 'right') || (_.currentSlide >= _.getDotCount() && swipeDirection === 'left')) {
                swipeLength = _.touchObject.swipeLength * _.options.edgeFriction;
                _.touchObject.edgeHit = true;
            }
        }

        if (_.options.vertical === false) {
            _.swipeLeft = curLeft + swipeLength * positionOffset;
        } else {
            _.swipeLeft = curLeft + (swipeLength * (_.$list.height() / _.listWidth)) * positionOffset;
        }
        if (_.options.verticalSwiping === true) {
            _.swipeLeft = curLeft + swipeLength * positionOffset;
        }

        if (_.options.fade === true || _.options.touchMove === false) {
            return false;
        }

        if (_.animating === true) {
            _.swipeLeft = null;
            return false;
        }

        _.setCSS(_.swipeLeft);

    };

    Slick.prototype.swipeStart = function(event) {

        var _ = this,
            touches;

        _.interrupted = true;

        if (_.touchObject.fingerCount !== 1 || _.slideCount <= _.options.slidesToShow) {
            _.touchObject = {};
            return false;
        }

        if (event.originalEvent !== undefined && event.originalEvent.touches !== undefined) {
            touches = event.originalEvent.touches[0];
        }

        _.touchObject.startX = _.touchObject.curX = touches !== undefined ? touches.pageX : event.clientX;
        _.touchObject.startY = _.touchObject.curY = touches !== undefined ? touches.pageY : event.clientY;

        _.dragging = true;

    };

    Slick.prototype.unfilterSlides = Slick.prototype.slickUnfilter = function() {

        var _ = this;

        if (_.$slidesCache !== null) {

            _.unload();

            _.$slideTrack.children(this.options.slide).detach();

            _.$slidesCache.appendTo(_.$slideTrack);

            _.reinit();

        }

    };

    Slick.prototype.unload = function() {

        var _ = this;

        $('.slick-cloned', _.$slider).remove();

        if (_.$dots) {
            _.$dots.remove();
        }

        if (_.$prevArrow && _.htmlExpr.test(_.options.prevArrow)) {
            _.$prevArrow.remove();
        }

        if (_.$nextArrow && _.htmlExpr.test(_.options.nextArrow)) {
            _.$nextArrow.remove();
        }

        _.$slides
            .removeClass('slick-slide slick-active slick-visible slick-current')
            .attr('aria-hidden', 'true')
            .css('width', '');

    };

    Slick.prototype.unslick = function(fromBreakpoint) {

        var _ = this;
        _.$slider.trigger('unslick', [_, fromBreakpoint]);
        _.destroy();

    };

    Slick.prototype.updateArrows = function() {

        var _ = this,
            centerOffset;

        centerOffset = Math.floor(_.options.slidesToShow / 2);

        if ( _.options.arrows === true &&
            _.slideCount > _.options.slidesToShow &&
            !_.options.infinite ) {

            _.$prevArrow.removeClass('slick-disabled').attr('aria-disabled', 'false');
            _.$nextArrow.removeClass('slick-disabled').attr('aria-disabled', 'false');

            if (_.currentSlide === 0) {

                _.$prevArrow.addClass('slick-disabled').attr('aria-disabled', 'true');
                _.$nextArrow.removeClass('slick-disabled').attr('aria-disabled', 'false');

            } else if (_.currentSlide >= _.slideCount - _.options.slidesToShow && _.options.centerMode === false) {

                _.$nextArrow.addClass('slick-disabled').attr('aria-disabled', 'true');
                _.$prevArrow.removeClass('slick-disabled').attr('aria-disabled', 'false');

            } else if (_.currentSlide >= _.slideCount - 1 && _.options.centerMode === true) {

                _.$nextArrow.addClass('slick-disabled').attr('aria-disabled', 'true');
                _.$prevArrow.removeClass('slick-disabled').attr('aria-disabled', 'false');

            }

        }

    };

    Slick.prototype.updateDots = function() {

        var _ = this;

        if (_.$dots !== null) {

            _.$dots
                .find('li')
                    .removeClass('slick-active')
                    .end();

            _.$dots
                .find('li')
                .eq(Math.floor(_.currentSlide / _.options.slidesToScroll))
                .addClass('slick-active');

        }

    };

    Slick.prototype.visibility = function() {

        var _ = this;

        if ( _.options.autoplay ) {

            if ( document[_.hidden] ) {

                _.interrupted = true;

            } else {

                _.interrupted = false;

            }

        }

    };

    $.fn.slick = function() {
        var _ = this,
            opt = arguments[0],
            args = Array.prototype.slice.call(arguments, 1),
            l = _.length,
            i,
            ret;
        for (i = 0; i < l; i++) {
            if (typeof opt == 'object' || typeof opt == 'undefined')
                _[i].slick = new Slick(_[i], opt);
            else
                ret = _[i].slick[opt].apply(_[i].slick, args);
            if (typeof ret != 'undefined') return ret;
        }
        return _;
    };

}));
/*  jQuery Nice Select - v1.0
    https://github.com/hernansartorio/jquery-nice-select
    Made by Hernán Sartorio  */
!function(e){e.fn.niceSelect=function(t){function s(t){t.after(e("<div></div>").addClass("nice-select").addClass(t.attr("class")||"").addClass(t.attr("disabled")?"disabled":"").attr("tabindex",t.attr("disabled")?null:"0").html('<span class="current"></span><ul class="list"></ul>'));var s=t.next(),n=t.find("option"),i=t.find("option:selected");s.find(".current").html(i.data("display")||i.text()),n.each(function(t){var n=e(this),i=n.data("display");s.find("ul").append(e("<li></li>").attr("data-value",n.val()).attr("data-display",i||null).addClass("option"+(n.is(":selected")?" selected":"")+(n.is(":disabled")?" disabled":"")).html(n.text()))})}if("string"==typeof t)return"update"==t?this.each(function(){var t=e(this),n=e(this).next(".nice-select"),i=n.hasClass("open");n.length&&(n.remove(),s(t),i&&t.next().trigger("click"))}):"destroy"==t?(this.each(function(){var t=e(this),s=e(this).next(".nice-select");s.length&&(s.remove(),t.css("display",""))}),0==e(".nice-select").length&&e(document).off(".nice_select")):console.log('Method "'+t+'" does not exist.'),this;this.hide(),this.each(function(){var t=e(this);t.next().hasClass("nice-select")||s(t)}),e(document).off(".nice_select"),e(document).on("click.nice_select",".nice-select",function(t){var s=e(this);e(".nice-select").not(s).removeClass("open"),s.toggleClass("open"),s.hasClass("open")?(s.find(".option"),s.find(".focus").removeClass("focus"),s.find(".selected").addClass("focus")):s.focus()}),e(document).on("click.nice_select",function(t){0===e(t.target).closest(".nice-select").length&&e(".nice-select").removeClass("open").find(".option")}),e(document).on("click.nice_select",".nice-select .option:not(.disabled)",function(t){var s=e(this),n=s.closest(".nice-select");n.find(".selected").removeClass("selected"),s.addClass("selected");var i=s.data("display")||s.text();n.find(".current").text(i),n.prev("select").val(s.data("value")).trigger("change")}),e(document).on("keydown.nice_select",".nice-select",function(t){var s=e(this),n=e(s.find(".focus")||s.find(".list .option.selected"));if(32==t.keyCode||13==t.keyCode)return s.hasClass("open")?n.trigger("click"):s.trigger("click"),!1;if(40==t.keyCode){if(s.hasClass("open")){var i=n.nextAll(".option:not(.disabled)").first();i.length>0&&(s.find(".focus").removeClass("focus"),i.addClass("focus"))}else s.trigger("click");return!1}if(38==t.keyCode){if(s.hasClass("open")){var l=n.prevAll(".option:not(.disabled)").first();l.length>0&&(s.find(".focus").removeClass("focus"),l.addClass("focus"))}else s.trigger("click");return!1}if(27==t.keyCode)s.hasClass("open")&&s.trigger("click");else if(9==t.keyCode&&s.hasClass("open"))return!1});var n=document.createElement("a").style;return n.cssText="pointer-events:auto","auto"!==n.pointerEvents&&e("html").addClass("no-csspointerevents"),this}}(jQuery);
/**
 * handle counter
 * @writable text input is manual write
 */
;(function () {
    'use strict';
    $.fn.handleCounter = function (options) {
        var $input,
            $btnMinus,
            $btnPlugs,
            minimum,
            maximize,
            writable,
            onChange,
            onMinimum,
            onMaximize;

        var $handleCounter = this;
        $btnMinus = $handleCounter.find('.counter-minus');
        $input = $handleCounter.find('input');
        $btnPlugs = $handleCounter.find('.counter-plus');

        var defaultOpts = {
            writable: true,
            minimum: 1,
            maximize: null,
            onChange: function(){},
            onMinimum: function(){},
            onMaximize: function(){}
        };

        var settings = $.extend({}, defaultOpts, options);
        minimum = settings.minimum;
        maximize = settings.maximize;
        writable = settings.writable;
        onChange = settings.onChange;
        onMinimum = settings.onMinimum;
        onMaximize = settings.onMaximize;
        //validate minimum, reverting to default if needed
        if (!$.isNumeric(minimum)) {
            minimum = defaultOpts.minimum
        }
        if (!$.isNumeric(maximize)) {
            maximize = defaultOpts.maximize
        }
        var inputVal = $input.val();
        if (isNaN(parseInt(inputVal))) {
            inputVal = $input.val(0).val()
        }
        if (!writable) {
            $input.prop('disabled', true)
        }

        changeVal(inputVal);
        $input.val(inputVal);
        $btnMinus.click(function () {
            var num = parseInt($input.val());
            if (num > minimum) {
                $input.val(num - 1);
                changeVal(num - 1)
            }
        });
        $btnPlugs.click(function () {
            var num = parseInt($input.val());
            if (maximize==null||num < maximize) {
                $input.val(num + 1);
                changeVal(num + 1)
            }
        });
        var keyUpTime;
        $input.keyup(function () {
            clearTimeout(keyUpTime);
            keyUpTime = setTimeout(function() {
                var num = $input.val();
                if (num == ''){
                    num = minimum;
                    $input.val(minimum)
                }
                var reg = new RegExp("^[\\d]*$");
                if (isNaN(parseInt(num)) || !reg.test(num)) {
                    $input.val($input.attr('data-num'));
                    changeVal($input.attr('data-num'))
                } else if (num < minimum) {
                    $input.val(minimum);
                    changeVal(minimum)
                }else if (maximize!=null&&num > maximize) {
                    $input.val(maximize);
                    changeVal(maximize)
                } else {
                    changeVal(num)
                }
            },300)
        });
        $input.focus(function () {
            var num = $input.val();
            if (num == 0) $input.select();
        });

        function changeVal(num) {
            $input.attr('data-num', num);
            $btnMinus.prop('disabled', false);
            $btnPlugs.prop('disabled', false);
            if (num <= minimum) {
                $btnMinus.prop('disabled', true);
                onMinimum.call(this, num)
            } else if (maximize!=null&&num >= maximize) {
                $btnPlugs.prop('disabled', true);
                onMaximize.call(this, num)
            }
            onChange.call(this, num)
        }
        return $handleCounter
    };
})(jQuery);
/*! nouislider - 14.2.0 - 3/27/2020 */
!function(t){"function"==typeof define&&define.amd?define([],t):"object"==typeof exports?module.exports=t():window.noUiSlider=t()}(function(){"use strict";var lt="14.2.0";function ut(t){t.parentElement.removeChild(t)}function s(t){return null!=t}function ct(t){t.preventDefault()}function i(t){return"number"==typeof t&&!isNaN(t)&&isFinite(t)}function pt(t,e,r){0<r&&(ht(t,e),setTimeout(function(){mt(t,e)},r))}function ft(t){return Math.max(Math.min(t,100),0)}function dt(t){return Array.isArray(t)?t:[t]}function e(t){var e=(t=String(t)).split(".");return 1<e.length?e[1].length:0}function ht(t,e){t.classList&&!/\s/.test(e)?t.classList.add(e):t.className+=" "+e}function mt(t,e){t.classList?t.classList.remove(e):t.className=t.className.replace(new RegExp("(^|\\b)"+e.split(" ").join("|")+"(\\b|$)","gi")," ")}function gt(t){var e=void 0!==window.pageXOffset,r="CSS1Compat"===(t.compatMode||"");return{x:e?window.pageXOffset:r?t.documentElement.scrollLeft:t.body.scrollLeft,y:e?window.pageYOffset:r?t.documentElement.scrollTop:t.body.scrollTop}}function c(t,e){return 100/(e-t)}function p(t,e){return 100*e/(t[1]-t[0])}function f(t,e){for(var r=1;t>=e[r];)r+=1;return r}function r(t,e,r){if(r>=t.slice(-1)[0])return 100;var n,i,o=f(r,t),a=t[o-1],s=t[o],l=e[o-1],u=e[o];return l+(i=r,p(n=[a,s],n[0]<0?i+Math.abs(n[0]):i-n[0])/c(l,u))}function n(t,e,r,n){if(100===n)return n;var i,o,a=f(n,t),s=t[a-1],l=t[a];return r?(l-s)/2<n-s?l:s:e[a-1]?t[a-1]+(i=n-t[a-1],o=e[a-1],Math.round(i/o)*o):n}function o(t,e,r){var n;if("number"==typeof e&&(e=[e]),!Array.isArray(e))throw new Error("noUiSlider ("+lt+"): 'range' contains invalid value.");if(!i(n="min"===t?0:"max"===t?100:parseFloat(t))||!i(e[0]))throw new Error("noUiSlider ("+lt+"): 'range' value isn't numeric.");r.xPct.push(n),r.xVal.push(e[0]),n?r.xSteps.push(!isNaN(e[1])&&e[1]):isNaN(e[1])||(r.xSteps[0]=e[1]),r.xHighestCompleteStep.push(0)}function a(t,e,r){if(e)if(r.xVal[t]!==r.xVal[t+1]){r.xSteps[t]=p([r.xVal[t],r.xVal[t+1]],e)/c(r.xPct[t],r.xPct[t+1]);var n=(r.xVal[t+1]-r.xVal[t])/r.xNumSteps[t],i=Math.ceil(Number(n.toFixed(3))-1),o=r.xVal[t]+r.xNumSteps[t]*i;r.xHighestCompleteStep[t]=o}else r.xSteps[t]=r.xHighestCompleteStep[t]=r.xVal[t]}function l(t,e,r){var n;this.xPct=[],this.xVal=[],this.xSteps=[r||!1],this.xNumSteps=[!1],this.xHighestCompleteStep=[],this.snap=e;var i=[];for(n in t)t.hasOwnProperty(n)&&i.push([t[n],n]);for(i.length&&"object"==typeof i[0][0]?i.sort(function(t,e){return t[0][0]-e[0][0]}):i.sort(function(t,e){return t[0]-e[0]}),n=0;n<i.length;n++)o(i[n][1],i[n][0],this);for(this.xNumSteps=this.xSteps.slice(0),n=0;n<this.xNumSteps.length;n++)a(n,this.xNumSteps[n],this)}l.prototype.getMargin=function(t){var e=this.xNumSteps[0];if(e&&t/e%1!=0)throw new Error("noUiSlider ("+lt+"): 'limit', 'margin' and 'padding' must be divisible by step.");return 2===this.xPct.length&&p(this.xVal,t)},l.prototype.toStepping=function(t){return t=r(this.xVal,this.xPct,t)},l.prototype.fromStepping=function(t){return function(t,e,r){if(100<=r)return t.slice(-1)[0];var n,i=f(r,e),o=t[i-1],a=t[i],s=e[i-1],l=e[i];return n=[o,a],(r-s)*c(s,l)*(n[1]-n[0])/100+n[0]}(this.xVal,this.xPct,t)},l.prototype.getStep=function(t){return t=n(this.xPct,this.xSteps,this.snap,t)},l.prototype.getDefaultStep=function(t,e,r){var n=f(t,this.xPct);return(100===t||e&&t===this.xPct[n-1])&&(n=Math.max(n-1,1)),(this.xVal[n]-this.xVal[n-1])/r},l.prototype.getNearbySteps=function(t){var e=f(t,this.xPct);return{stepBefore:{startValue:this.xVal[e-2],step:this.xNumSteps[e-2],highestStep:this.xHighestCompleteStep[e-2]},thisStep:{startValue:this.xVal[e-1],step:this.xNumSteps[e-1],highestStep:this.xHighestCompleteStep[e-1]},stepAfter:{startValue:this.xVal[e],step:this.xNumSteps[e],highestStep:this.xHighestCompleteStep[e]}}},l.prototype.countStepDecimals=function(){var t=this.xNumSteps.map(e);return Math.max.apply(null,t)},l.prototype.convert=function(t){return this.getStep(this.toStepping(t))};var u={to:function(t){return void 0!==t&&t.toFixed(2)},from:Number};function d(t){if("object"==typeof(e=t)&&"function"==typeof e.to&&"function"==typeof e.from)return!0;var e;throw new Error("noUiSlider ("+lt+"): 'format' requires 'to' and 'from' methods.")}function h(t,e){if(!i(e))throw new Error("noUiSlider ("+lt+"): 'step' is not numeric.");t.singleStep=e}function m(t,e){if("object"!=typeof e||Array.isArray(e))throw new Error("noUiSlider ("+lt+"): 'range' is not an object.");if(void 0===e.min||void 0===e.max)throw new Error("noUiSlider ("+lt+"): Missing 'min' or 'max' in 'range'.");if(e.min===e.max)throw new Error("noUiSlider ("+lt+"): 'range' 'min' and 'max' cannot be equal.");t.spectrum=new l(e,t.snap,t.singleStep)}function g(t,e){if(e=dt(e),!Array.isArray(e)||!e.length)throw new Error("noUiSlider ("+lt+"): 'start' option is incorrect.");t.handles=e.length,t.start=e}function v(t,e){if("boolean"!=typeof(t.snap=e))throw new Error("noUiSlider ("+lt+"): 'snap' option must be a boolean.")}function b(t,e){if("boolean"!=typeof(t.animate=e))throw new Error("noUiSlider ("+lt+"): 'animate' option must be a boolean.")}function S(t,e){if("number"!=typeof(t.animationDuration=e))throw new Error("noUiSlider ("+lt+"): 'animationDuration' option must be a number.")}function x(t,e){var r,n=[!1];if("lower"===e?e=[!0,!1]:"upper"===e&&(e=[!1,!0]),!0===e||!1===e){for(r=1;r<t.handles;r++)n.push(e);n.push(!1)}else{if(!Array.isArray(e)||!e.length||e.length!==t.handles+1)throw new Error("noUiSlider ("+lt+"): 'connect' option doesn't match handle count.");n=e}t.connect=n}function w(t,e){switch(e){case"horizontal":t.ort=0;break;case"vertical":t.ort=1;break;default:throw new Error("noUiSlider ("+lt+"): 'orientation' option is invalid.")}}function y(t,e){if(!i(e))throw new Error("noUiSlider ("+lt+"): 'margin' option must be numeric.");if(0!==e&&(t.margin=t.spectrum.getMargin(e),!t.margin))throw new Error("noUiSlider ("+lt+"): 'margin' option is only supported on linear sliders.")}function E(t,e){if(!i(e))throw new Error("noUiSlider ("+lt+"): 'limit' option must be numeric.");if(t.limit=t.spectrum.getMargin(e),!t.limit||t.handles<2)throw new Error("noUiSlider ("+lt+"): 'limit' option is only supported on linear sliders with 2 or more handles.")}function C(t,e){if(!i(e)&&!Array.isArray(e))throw new Error("noUiSlider ("+lt+"): 'padding' option must be numeric or array of exactly 2 numbers.");if(Array.isArray(e)&&2!==e.length&&!i(e[0])&&!i(e[1]))throw new Error("noUiSlider ("+lt+"): 'padding' option must be numeric or array of exactly 2 numbers.");if(0!==e){if(Array.isArray(e)||(e=[e,e]),!(t.padding=[t.spectrum.getMargin(e[0]),t.spectrum.getMargin(e[1])])===t.padding[0]||!1===t.padding[1])throw new Error("noUiSlider ("+lt+"): 'padding' option is only supported on linear sliders.");if(t.padding[0]<0||t.padding[1]<0)throw new Error("noUiSlider ("+lt+"): 'padding' option must be a positive number(s).");if(100<t.padding[0]+t.padding[1])throw new Error("noUiSlider ("+lt+"): 'padding' option must not exceed 100% of the range.")}}function N(t,e){switch(e){case"ltr":t.dir=0;break;case"rtl":t.dir=1;break;default:throw new Error("noUiSlider ("+lt+"): 'direction' option was not recognized.")}}function U(t,e){if("string"!=typeof e)throw new Error("noUiSlider ("+lt+"): 'behaviour' must be a string containing options.");var r=0<=e.indexOf("tap"),n=0<=e.indexOf("drag"),i=0<=e.indexOf("fixed"),o=0<=e.indexOf("snap"),a=0<=e.indexOf("hover"),s=0<=e.indexOf("unconstrained");if(i){if(2!==t.handles)throw new Error("noUiSlider ("+lt+"): 'fixed' behaviour must be used with 2 handles");y(t,t.start[1]-t.start[0])}if(s&&(t.margin||t.limit))throw new Error("noUiSlider ("+lt+"): 'unconstrained' behaviour cannot be used with margin or limit");t.events={tap:r||o,drag:n,fixed:i,snap:o,hover:a,unconstrained:s}}function P(t,e){if(!1!==e)if(!0===e){t.tooltips=[];for(var r=0;r<t.handles;r++)t.tooltips.push(!0)}else{if(t.tooltips=dt(e),t.tooltips.length!==t.handles)throw new Error("noUiSlider ("+lt+"): must pass a formatter for all handles.");t.tooltips.forEach(function(t){if("boolean"!=typeof t&&("object"!=typeof t||"function"!=typeof t.to))throw new Error("noUiSlider ("+lt+"): 'tooltips' must be passed a formatter or 'false'.")})}}function V(t,e){d(t.ariaFormat=e)}function k(t,e){d(t.format=e)}function A(t,e){if("boolean"!=typeof(t.keyboardSupport=e))throw new Error("noUiSlider ("+lt+"): 'keyboardSupport' option must be a boolean.")}function M(t,e){t.documentElement=e}function O(t,e){if("string"!=typeof e&&!1!==e)throw new Error("noUiSlider ("+lt+"): 'cssPrefix' must be a string or `false`.");t.cssPrefix=e}function L(t,e){if("object"!=typeof e)throw new Error("noUiSlider ("+lt+"): 'cssClasses' must be an object.");if("string"==typeof t.cssPrefix)for(var r in t.cssClasses={},e)e.hasOwnProperty(r)&&(t.cssClasses[r]=t.cssPrefix+e[r]);else t.cssClasses=e}function vt(e){var r={margin:0,limit:0,padding:0,animate:!0,animationDuration:300,ariaFormat:u,format:u},n={step:{r:!1,t:h},start:{r:!0,t:g},connect:{r:!0,t:x},direction:{r:!0,t:N},snap:{r:!1,t:v},animate:{r:!1,t:b},animationDuration:{r:!1,t:S},range:{r:!0,t:m},orientation:{r:!1,t:w},margin:{r:!1,t:y},limit:{r:!1,t:E},padding:{r:!1,t:C},behaviour:{r:!0,t:U},ariaFormat:{r:!1,t:V},format:{r:!1,t:k},tooltips:{r:!1,t:P},keyboardSupport:{r:!0,t:A},documentElement:{r:!1,t:M},cssPrefix:{r:!0,t:O},cssClasses:{r:!0,t:L}},i={connect:!1,direction:"ltr",behaviour:"tap",orientation:"horizontal",keyboardSupport:!0,cssPrefix:"noUi-",cssClasses:{target:"target",base:"base",origin:"origin",handle:"handle",handleLower:"handle-lower",handleUpper:"handle-upper",touchArea:"touch-area",horizontal:"horizontal",vertical:"vertical",background:"background",connect:"connect",connects:"connects",ltr:"ltr",rtl:"rtl",textDirectionLtr:"txt-dir-ltr",textDirectionRtl:"txt-dir-rtl",draggable:"draggable",drag:"state-drag",tap:"state-tap",active:"active",tooltip:"tooltip",pips:"pips",pipsHorizontal:"pips-horizontal",pipsVertical:"pips-vertical",marker:"marker",markerHorizontal:"marker-horizontal",markerVertical:"marker-vertical",markerNormal:"marker-normal",markerLarge:"marker-large",markerSub:"marker-sub",value:"value",valueHorizontal:"value-horizontal",valueVertical:"value-vertical",valueNormal:"value-normal",valueLarge:"value-large",valueSub:"value-sub"}};e.format&&!e.ariaFormat&&(e.ariaFormat=e.format),Object.keys(n).forEach(function(t){if(!s(e[t])&&void 0===i[t]){if(n[t].r)throw new Error("noUiSlider ("+lt+"): '"+t+"' is required.");return!0}n[t].t(r,s(e[t])?e[t]:i[t])}),r.pips=e.pips;var t=document.createElement("div"),o=void 0!==t.style.msTransform,a=void 0!==t.style.transform;r.transformRule=a?"transform":o?"msTransform":"webkitTransform";return r.style=[["left","top"],["right","bottom"]][r.dir][r.ort],r}function D(t,v,o){var l,u,a,c,i,s,e,p,f=window.navigator.pointerEnabled?{start:"pointerdown",move:"pointermove",end:"pointerup"}:window.navigator.msPointerEnabled?{start:"MSPointerDown",move:"MSPointerMove",end:"MSPointerUp"}:{start:"mousedown touchstart",move:"mousemove touchmove",end:"mouseup touchend"},d=window.CSS&&CSS.supports&&CSS.supports("touch-action","none")&&function(){var t=!1;try{var e=Object.defineProperty({},"passive",{get:function(){t=!0}});window.addEventListener("test",null,e)}catch(t){}return t}(),h=t,y=v.spectrum,b=[],S=[],m=[],g=0,x={},w=t.ownerDocument,E=v.documentElement||w.documentElement,C=w.body,N=-1,U=0,P=1,V=2,k="rtl"===w.dir||1===v.ort?0:100;function A(t,e){var r=w.createElement("div");return e&&ht(r,e),t.appendChild(r),r}function M(t,e){var r=A(t,v.cssClasses.origin),n=A(r,v.cssClasses.handle);return A(n,v.cssClasses.touchArea),n.setAttribute("data-handle",e),v.keyboardSupport&&(n.setAttribute("tabindex","0"),n.addEventListener("keydown",function(t){return function(t,e){if(L()||D(e))return!1;var r=["Left","Right"],n=["Down","Up"],i=["PageDown","PageUp"],o=["Home","End"];v.dir&&!v.ort?r.reverse():v.ort&&!v.dir&&(n.reverse(),i.reverse());var a,s=t.key.replace("Arrow",""),l=s===i[0],u=s===i[1],c=s===n[0]||s===r[0]||l,p=s===n[1]||s===r[1]||u,f=s===o[0],d=s===o[1];if(!(c||p||f||d))return!0;if(t.preventDefault(),p||c){var h=c?0:1,m=st(e),g=m[h];if(null===g)return!1;!1===g&&(g=y.getDefaultStep(S[e],c,10)),(u||l)&&(g*=5),g=Math.max(g,1e-7),g*=c?-1:1,a=b[e]+g}else a=d?v.spectrum.xVal[v.spectrum.xVal.length-1]:v.spectrum.xVal[0];return rt(e,y.toStepping(a),!0,!0),J("slide",e),J("update",e),J("change",e),J("set",e),!1}(t,e)})),n.setAttribute("role","slider"),n.setAttribute("aria-orientation",v.ort?"vertical":"horizontal"),0===e?ht(n,v.cssClasses.handleLower):e===v.handles-1&&ht(n,v.cssClasses.handleUpper),r}function O(t,e){return!!e&&A(t,v.cssClasses.connect)}function r(t,e){return!!v.tooltips[e]&&A(t.firstChild,v.cssClasses.tooltip)}function L(){return h.hasAttribute("disabled")}function D(t){return u[t].hasAttribute("disabled")}function z(){i&&(G("update.tooltips"),i.forEach(function(t){t&&ut(t)}),i=null)}function H(){z(),i=u.map(r),$("update.tooltips",function(t,e,r){if(i[e]){var n=t[e];!0!==v.tooltips[e]&&(n=v.tooltips[e].to(r[e])),i[e].innerHTML=n}})}function j(e,i,o){var a=w.createElement("div"),s=[];s[U]=v.cssClasses.valueNormal,s[P]=v.cssClasses.valueLarge,s[V]=v.cssClasses.valueSub;var l=[];l[U]=v.cssClasses.markerNormal,l[P]=v.cssClasses.markerLarge,l[V]=v.cssClasses.markerSub;var u=[v.cssClasses.valueHorizontal,v.cssClasses.valueVertical],c=[v.cssClasses.markerHorizontal,v.cssClasses.markerVertical];function p(t,e){var r=e===v.cssClasses.value,n=r?s:l;return e+" "+(r?u:c)[v.ort]+" "+n[t]}return ht(a,v.cssClasses.pips),ht(a,0===v.ort?v.cssClasses.pipsHorizontal:v.cssClasses.pipsVertical),Object.keys(e).forEach(function(t){!function(t,e,r){if((r=i?i(e,r):r)!==N){var n=A(a,!1);n.className=p(r,v.cssClasses.marker),n.style[v.style]=t+"%",U<r&&((n=A(a,!1)).className=p(r,v.cssClasses.value),n.setAttribute("data-value",e),n.style[v.style]=t+"%",n.innerHTML=o.to(e))}}(t,e[t][0],e[t][1])}),a}function F(){c&&(ut(c),c=null)}function R(t){F();var m,g,v,b,e,r,S,x,w,n=t.mode,i=t.density||1,o=t.filter||!1,a=function(t,e,r){if("range"===t||"steps"===t)return y.xVal;if("count"===t){if(e<2)throw new Error("noUiSlider ("+lt+"): 'values' (>= 2) required for mode 'count'.");var n=e-1,i=100/n;for(e=[];n--;)e[n]=n*i;e.push(100),t="positions"}return"positions"===t?e.map(function(t){return y.fromStepping(r?y.getStep(t):t)}):"values"===t?r?e.map(function(t){return y.fromStepping(y.getStep(y.toStepping(t)))}):e:void 0}(n,t.values||!1,t.stepped||!1),s=(m=i,g=n,v=a,b={},e=y.xVal[0],r=y.xVal[y.xVal.length-1],x=S=!1,w=0,(v=v.slice().sort(function(t,e){return t-e}).filter(function(t){return!this[t]&&(this[t]=!0)},{}))[0]!==e&&(v.unshift(e),S=!0),v[v.length-1]!==r&&(v.push(r),x=!0),v.forEach(function(t,e){var r,n,i,o,a,s,l,u,c,p,f=t,d=v[e+1],h="steps"===g;if(h&&(r=y.xNumSteps[e]),r||(r=d-f),!1!==f&&void 0!==d)for(r=Math.max(r,1e-7),n=f;n<=d;n=(n+r).toFixed(7)/1){for(u=(a=(o=y.toStepping(n))-w)/m,p=a/(c=Math.round(u)),i=1;i<=c;i+=1)b[(s=w+i*p).toFixed(5)]=[y.fromStepping(s),0];l=-1<v.indexOf(n)?P:h?V:U,!e&&S&&n!==d&&(l=0),n===d&&x||(b[o.toFixed(5)]=[n,l]),w=o}}),b),l=t.format||{to:Math.round};return c=h.appendChild(j(s,o,l))}function T(){var t=l.getBoundingClientRect(),e="offset"+["Width","Height"][v.ort];return 0===v.ort?t.width||l[e]:t.height||l[e]}function B(n,i,o,a){var e=function(t){return!!(t=function(t,e,r){var n,i,o=0===t.type.indexOf("touch"),a=0===t.type.indexOf("mouse"),s=0===t.type.indexOf("pointer");0===t.type.indexOf("MSPointer")&&(s=!0);if(o){var l=function(t){return t.target===r||r.contains(t.target)||t.target.shadowRoot&&t.target.shadowRoot.contains(r)};if("touchstart"===t.type){var u=Array.prototype.filter.call(t.touches,l);if(1<u.length)return!1;n=u[0].pageX,i=u[0].pageY}else{var c=Array.prototype.find.call(t.changedTouches,l);if(!c)return!1;n=c.pageX,i=c.pageY}}e=e||gt(w),(a||s)&&(n=t.clientX+e.x,i=t.clientY+e.y);return t.pageOffset=e,t.points=[n,i],t.cursor=a||s,t}(t,a.pageOffset,a.target||i))&&(!(L()&&!a.doNotReject)&&(e=h,r=v.cssClasses.tap,!((e.classList?e.classList.contains(r):new RegExp("\\b"+r+"\\b").test(e.className))&&!a.doNotReject)&&(!(n===f.start&&void 0!==t.buttons&&1<t.buttons)&&((!a.hover||!t.buttons)&&(d||t.preventDefault(),t.calcPoint=t.points[v.ort],void o(t,a))))));var e,r},r=[];return n.split(" ").forEach(function(t){i.addEventListener(t,e,!!d&&{passive:!0}),r.push([t,e])}),r}function q(t){var e,r,n,i,o,a,s=100*(t-(e=l,r=v.ort,n=e.getBoundingClientRect(),i=e.ownerDocument,o=i.documentElement,a=gt(i),/webkit.*Chrome.*Mobile/i.test(navigator.userAgent)&&(a.x=0),r?n.top+a.y-o.clientTop:n.left+a.x-o.clientLeft))/T();return s=ft(s),v.dir?100-s:s}function X(t,e){"mouseout"===t.type&&"HTML"===t.target.nodeName&&null===t.relatedTarget&&_(t,e)}function Y(t,e){if(-1===navigator.appVersion.indexOf("MSIE 9")&&0===t.buttons&&0!==e.buttonsProperty)return _(t,e);var r=(v.dir?-1:1)*(t.calcPoint-e.startCalcPoint);Z(0<r,100*r/e.baseSize,e.locations,e.handleNumbers)}function _(t,e){e.handle&&(mt(e.handle,v.cssClasses.active),g-=1),e.listeners.forEach(function(t){E.removeEventListener(t[0],t[1])}),0===g&&(mt(h,v.cssClasses.drag),et(),t.cursor&&(C.style.cursor="",C.removeEventListener("selectstart",ct))),e.handleNumbers.forEach(function(t){J("change",t),J("set",t),J("end",t)})}function I(t,e){if(e.handleNumbers.some(D))return!1;var r;1===e.handleNumbers.length&&(r=u[e.handleNumbers[0]].children[0],g+=1,ht(r,v.cssClasses.active));t.stopPropagation();var n=[],i=B(f.move,E,Y,{target:t.target,handle:r,listeners:n,startCalcPoint:t.calcPoint,baseSize:T(),pageOffset:t.pageOffset,handleNumbers:e.handleNumbers,buttonsProperty:t.buttons,locations:S.slice()}),o=B(f.end,E,_,{target:t.target,handle:r,listeners:n,doNotReject:!0,handleNumbers:e.handleNumbers}),a=B("mouseout",E,X,{target:t.target,handle:r,listeners:n,doNotReject:!0,handleNumbers:e.handleNumbers});n.push.apply(n,i.concat(o,a)),t.cursor&&(C.style.cursor=getComputedStyle(t.target).cursor,1<u.length&&ht(h,v.cssClasses.drag),C.addEventListener("selectstart",ct,!1)),e.handleNumbers.forEach(function(t){J("start",t)})}function n(t){t.stopPropagation();var i,o,a,e=q(t.calcPoint),r=(i=e,a=!(o=100),u.forEach(function(t,e){if(!D(e)){var r=S[e],n=Math.abs(r-i);(n<o||n<=o&&r<i||100===n&&100===o)&&(a=e,o=n)}}),a);if(!1===r)return!1;v.events.snap||pt(h,v.cssClasses.tap,v.animationDuration),rt(r,e,!0,!0),et(),J("slide",r,!0),J("update",r,!0),J("change",r,!0),J("set",r,!0),v.events.snap&&I(t,{handleNumbers:[r]})}function W(t){var e=q(t.calcPoint),r=y.getStep(e),n=y.fromStepping(r);Object.keys(x).forEach(function(t){"hover"===t.split(".")[0]&&x[t].forEach(function(t){t.call(s,n)})})}function $(t,e){x[t]=x[t]||[],x[t].push(e),"update"===t.split(".")[0]&&u.forEach(function(t,e){J("update",e)})}function G(t){var n=t&&t.split(".")[0],i=n&&t.substring(n.length);Object.keys(x).forEach(function(t){var e=t.split(".")[0],r=t.substring(e.length);n&&n!==e||i&&i!==r||delete x[t]})}function J(r,n,i){Object.keys(x).forEach(function(t){var e=t.split(".")[0];r===e&&x[t].forEach(function(t){t.call(s,b.map(v.format.to),n,b.slice(),i||!1,S.slice(),s)})})}function K(t,e,r,n,i,o){return 1<u.length&&!v.events.unconstrained&&(n&&0<e&&(r=Math.max(r,t[e-1]+v.margin)),i&&e<u.length-1&&(r=Math.min(r,t[e+1]-v.margin))),1<u.length&&v.limit&&(n&&0<e&&(r=Math.min(r,t[e-1]+v.limit)),i&&e<u.length-1&&(r=Math.max(r,t[e+1]-v.limit))),v.padding&&(0===e&&(r=Math.max(r,v.padding[0])),e===u.length-1&&(r=Math.min(r,100-v.padding[1]))),!((r=ft(r=y.getStep(r)))===t[e]&&!o)&&r}function Q(t,e){var r=v.ort;return(r?e:t)+", "+(r?t:e)}function Z(t,n,r,e){var i=r.slice(),o=[!t,t],a=[t,!t];e=e.slice(),t&&e.reverse(),1<e.length?e.forEach(function(t,e){var r=K(i,t,i[t]+n,o[e],a[e],!1);!1===r?n=0:(n=r-i[t],i[t]=r)}):o=a=[!0];var s=!1;e.forEach(function(t,e){s=rt(t,r[t]+n,o[e],a[e])||s}),s&&e.forEach(function(t){J("update",t),J("slide",t)})}function tt(t,e){return v.dir?100-t-e:t}function et(){m.forEach(function(t){var e=50<S[t]?-1:1,r=3+(u.length+e*t);u[t].style.zIndex=r})}function rt(t,e,r,n){return!1!==(e=K(S,t,e,r,n,!1))&&(function(t,e){S[t]=e,b[t]=y.fromStepping(e);var r="translate("+Q(10*(tt(e,0)-k)+"%","0")+")";u[t].style[v.transformRule]=r,nt(t),nt(t+1)}(t,e),!0)}function nt(t){if(a[t]){var e=0,r=100;0!==t&&(e=S[t-1]),t!==a.length-1&&(r=S[t]);var n=r-e,i="translate("+Q(tt(e,n)+"%","0")+")",o="scale("+Q(n/100,"1")+")";a[t].style[v.transformRule]=i+" "+o}}function it(t,e){return null===t||!1===t||void 0===t?S[e]:("number"==typeof t&&(t=String(t)),t=v.format.from(t),!1===(t=y.toStepping(t))||isNaN(t)?S[e]:t)}function ot(t,e){var r=dt(t),n=void 0===S[0];e=void 0===e||!!e,v.animate&&!n&&pt(h,v.cssClasses.tap,v.animationDuration),m.forEach(function(t){rt(t,it(r[t],t),!0,!1)});for(var i=1===m.length?0:1;i<m.length;++i)m.forEach(function(t){rt(t,S[t],!0,!0)});et(),m.forEach(function(t){J("update",t),null!==r[t]&&e&&J("set",t)})}function at(){var t=b.map(v.format.to);return 1===t.length?t[0]:t}function st(t){var e=S[t],r=y.getNearbySteps(e),n=b[t],i=r.thisStep.step,o=null;if(v.snap)return[n-r.stepBefore.startValue||null,r.stepAfter.startValue-n||null];!1!==i&&n+i>r.stepAfter.startValue&&(i=r.stepAfter.startValue-n),o=n>r.thisStep.startValue?r.thisStep.step:!1!==r.stepBefore.step&&n-r.stepBefore.highestStep,100===e?i=null:0===e&&(o=null);var a=y.countStepDecimals();return null!==i&&!1!==i&&(i=Number(i.toFixed(a))),null!==o&&!1!==o&&(o=Number(o.toFixed(a))),[o,i]}return ht(e=h,v.cssClasses.target),0===v.dir?ht(e,v.cssClasses.ltr):ht(e,v.cssClasses.rtl),0===v.ort?ht(e,v.cssClasses.horizontal):ht(e,v.cssClasses.vertical),ht(e,"rtl"===getComputedStyle(e).direction?v.cssClasses.textDirectionRtl:v.cssClasses.textDirectionLtr),l=A(e,v.cssClasses.base),function(t,e){var r=A(e,v.cssClasses.connects);u=[],(a=[]).push(O(r,t[0]));for(var n=0;n<v.handles;n++)u.push(M(e,n)),m[n]=n,a.push(O(r,t[n+1]))}(v.connect,l),(p=v.events).fixed||u.forEach(function(t,e){B(f.start,t.children[0],I,{handleNumbers:[e]})}),p.tap&&B(f.start,l,n,{}),p.hover&&B(f.move,l,W,{hover:!0}),p.drag&&a.forEach(function(t,e){if(!1!==t&&0!==e&&e!==a.length-1){var r=u[e-1],n=u[e],i=[t];ht(t,v.cssClasses.draggable),p.fixed&&(i.push(r.children[0]),i.push(n.children[0])),i.forEach(function(t){B(f.start,t,I,{handles:[r,n],handleNumbers:[e-1,e]})})}}),ot(v.start),v.pips&&R(v.pips),v.tooltips&&H(),$("update",function(t,e,a,r,s){m.forEach(function(t){var e=u[t],r=K(S,t,0,!0,!0,!0),n=K(S,t,100,!0,!0,!0),i=s[t],o=v.ariaFormat.to(a[t]);r=y.fromStepping(r).toFixed(1),n=y.fromStepping(n).toFixed(1),i=y.fromStepping(i).toFixed(1),e.children[0].setAttribute("aria-valuemin",r),e.children[0].setAttribute("aria-valuemax",n),e.children[0].setAttribute("aria-valuenow",i),e.children[0].setAttribute("aria-valuetext",o)})}),s={destroy:function(){for(var t in v.cssClasses)v.cssClasses.hasOwnProperty(t)&&mt(h,v.cssClasses[t]);for(;h.firstChild;)h.removeChild(h.firstChild);delete h.noUiSlider},steps:function(){return m.map(st)},on:$,off:G,get:at,set:ot,setHandle:function(t,e,r){if(!(0<=(t=Number(t))&&t<m.length))throw new Error("noUiSlider ("+lt+"): invalid handle number, got: "+t);rt(t,it(e,t),!0,!0),J("update",t),r&&J("set",t)},reset:function(t){ot(v.start,t)},__moveHandles:function(t,e,r){Z(t,e,S,r)},options:o,updateOptions:function(e,t){var r=at(),n=["margin","limit","padding","range","animate","snap","step","format","pips","tooltips"];n.forEach(function(t){void 0!==e[t]&&(o[t]=e[t])});var i=vt(o);n.forEach(function(t){void 0!==e[t]&&(v[t]=i[t])}),y=i.spectrum,v.margin=i.margin,v.limit=i.limit,v.padding=i.padding,v.pips?R(v.pips):F(),v.tooltips?H():z(),S=[],ot(e.start||r,t)},target:h,removePips:F,removeTooltips:z,pips:R}}return{__spectrum:l,version:lt,create:function(t,e){if(!t||!t.nodeName)throw new Error("noUiSlider ("+lt+"): create requires a single element, got: "+t);if(t.noUiSlider)throw new Error("noUiSlider ("+lt+"): Slider was already initialized.");var r=D(t,vt(e),e);return t.noUiSlider=r}}});
/*
	By Osvaldas Valutis, www.osvaldas.info
	Available for use under the MIT License
*/

!function(n,t,e,i){"use strict";var o=function(){var n=e.body||e.documentElement,n=n.style;return""==n.WebkitTransition?"-webkit-":""==n.MozTransition?"-moz-":""==n.OTransition?"-o-":""==n.transition?"":!1},r=o()===!1?!1:!0,a=function(n,t,e){var i={},r=o();i[r+"transform"]="translateX("+t+")",i[r+"transition"]=r+"transform "+e+"s linear",n.css(i)},u="ontouchstart"in t,d=t.navigator.pointerEnabled||t.navigator.msPointerEnabled,c=function(n){if(u)return!0;if(!d||"undefined"==typeof n||"undefined"==typeof n.pointerType)return!1;if("undefined"!=typeof n.MSPOINTER_TYPE_MOUSE){if(n.MSPOINTER_TYPE_MOUSE!=n.pointerType)return!0}else if("mouse"!=n.pointerType)return!0;return!1};n.fn.imageLightbox=function(i){var i=n.extend({selector:'id="imagelightbox"',animationSpeed:250,preloadNext:!0,enableKeyboard:!0,quitOnEnd:!1,quitOnImgClick:!1,quitOnDocClick:!0,onStart:!1,onEnd:!1,onLoadStart:!1,onLoadEnd:!1},i),o=n([]),f=n(),l=n(),p=0,g=0,s=0,h=!1,m=function(){if(!l.length)return!0;var e=.8*n(t).width(),i=.9*n(t).height(),o=new Image;o.src=l.attr("src"),o.onload=function(){if(p=o.width,g=o.height,p>e||g>i){var r=p/g>e/i?p/e:g/i;p/=r,g/=r}l.css({width:p+"px",height:g+"px",top:(n(t).height()-g)/2+"px",left:(n(t).width()-p)/2+"px"})}},v=function(t){if(h)return!1;if(t="undefined"==typeof t?!1:"left"==t?1:-1,l.length){if(t!==!1&&(o.length<2||i.quitOnEnd===!0&&(-1===t&&0==o.index(f)||1===t&&o.index(f)==o.length-1)))return E(),!1;var e={opacity:0};r?a(l,100*t-s+"px",i.animationSpeed/1e3):e.left=parseInt(l.css("left"))+100*t+"px",l.animate(e,i.animationSpeed,function(){x()}),s=0}h=!0,i.onLoadStart!==!1&&i.onLoadStart(),setTimeout(function(){l=n("<img "+i.selector+" />").attr("src",f.attr("href")).on("load",function(){l.appendTo("body"),m();var e={opacity:1};if(l.css("opacity",0),r)a(l,-100*t+"px",0),setTimeout(function(){a(l,"0px",i.animationSpeed/1e3)},50);else{var u=parseInt(l.css("left"));e.left=u+"px",l.css("left",u-100*t+"px")}if(l.animate(e,i.animationSpeed,function(){h=!1,i.onLoadEnd!==!1&&i.onLoadEnd()}),i.preloadNext){var d=o.eq(o.index(f)+1);d.length||(d=o.eq(0)),n("<img />").attr("src",d.attr("href"))}}).on("error",function(){i.onLoadEnd!==!1&&i.onLoadEnd()});var e=0,u=0,g=0;l.on(d?"pointerup MSPointerUp":"click",function(n){if(n.preventDefault(),i.quitOnImgClick)return E(),!1;if(c(n.originalEvent))return!0;var t=(n.pageX||n.originalEvent.pageX)-n.target.offsetLeft;f=o.eq(o.index(f)-(p/2>t?1:-1)),f.length||(f=o.eq(p/2>t?o.length:0)),v(p/2>t?"left":"right")}).on("touchstart pointerdown MSPointerDown",function(n){return!c(n.originalEvent)||i.quitOnImgClick?!0:(r&&(g=parseInt(l.css("left"))),void(e=n.originalEvent.pageX||n.originalEvent.touches[0].pageX))}).on("touchmove pointermove MSPointerMove",function(n){return!c(n.originalEvent)||i.quitOnImgClick?!0:(n.preventDefault(),u=n.originalEvent.pageX||n.originalEvent.touches[0].pageX,s=e-u,void(r?a(l,-s+"px",0):l.css("left",g-s+"px")))}).on("touchend touchcancel pointerup pointercancel MSPointerUp MSPointerCancel",function(n){return!c(n.originalEvent)||i.quitOnImgClick?!0:void(Math.abs(s)>50?(f=o.eq(o.index(f)-(0>s?1:-1)),f.length||(f=o.eq(0>s?o.length:0)),v(s>0?"right":"left")):r?a(l,"0px",i.animationSpeed/1e3):l.animate({left:g+"px"},i.animationSpeed/2))})},i.animationSpeed+100)},x=function(){return l.length?(l.remove(),void(l=n())):!1},E=function(){return l.length?void l.animate({opacity:0},i.animationSpeed,function(){x(),h=!1,i.onEnd!==!1&&i.onEnd()}):!1},y=function(t){t.each(function(){o=o.add(n(this))}),t.on("click.imageLightbox",function(t){return t.preventDefault(),h?!1:(h=!1,i.onStart!==!1&&i.onStart(),f=n(this),void v())})};return n(t).on("resize",m),i.quitOnDocClick&&n(e).on(u?"touchend":"click",function(t){l.length&&!n(t.target).is(l)&&E()}),i.enableKeyboard&&n(e).on("keyup",function(n){return l.length?(n.preventDefault(),27==n.keyCode&&E(),void((37==n.keyCode||39==n.keyCode)&&(f=o.eq(o.index(f)-(37==n.keyCode?1:-1)),f.length||(f=o.eq(37==n.keyCode?o.length:0)),v(37==n.keyCode?"left":"right")))):!0}),y(n(this)),this.switchImageLightbox=function(n){var t=o.eq(n);if(t.length){var e=o.index(f);f=t,v(e>n?"left":"right")}return this},this.addToImageLightbox=function(n){y(n)},this.quitImageLightbox=function(){return E(),this},this}}(jQuery,window,document);
/*
    jQuery Masked Input Plugin
    Copyright (c) 2007 - 2015 Josh Bush (digitalbush.com)
    Licensed under the MIT license (http://digitalbush.com/projects/masked-input-plugin/#license)
    Version: 1.4.1
*/
!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):a("object"==typeof exports?require("jquery"):jQuery)}(function(a){var b,c=navigator.userAgent,d=/iphone/i.test(c),e=/chrome/i.test(c),f=/android/i.test(c);a.mask={definitions:{9:"[0-9]",a:"[A-Za-z]","*":"[A-Za-z0-9]"},autoclear:!0,dataName:"rawMaskFn",placeholder:"_"},a.fn.extend({caret:function(a,b){var c;if(0!==this.length&&!this.is(":hidden"))return"number"==typeof a?(b="number"==typeof b?b:a,this.each(function(){this.setSelectionRange?this.setSelectionRange(a,b):this.createTextRange&&(c=this.createTextRange(),c.collapse(!0),c.moveEnd("character",b),c.moveStart("character",a),c.select())})):(this[0].setSelectionRange?(a=this[0].selectionStart,b=this[0].selectionEnd):document.selection&&document.selection.createRange&&(c=document.selection.createRange(),a=0-c.duplicate().moveStart("character",-1e5),b=a+c.text.length),{begin:a,end:b})},unmask:function(){return this.trigger("unmask")},mask:function(c,g){var h,i,j,k,l,m,n,o;if(!c&&this.length>0){h=a(this[0]);var p=h.data(a.mask.dataName);return p?p():void 0}return g=a.extend({autoclear:a.mask.autoclear,placeholder:a.mask.placeholder,completed:null},g),i=a.mask.definitions,j=[],k=n=c.length,l=null,a.each(c.split(""),function(a,b){"?"==b?(n--,k=a):i[b]?(j.push(new RegExp(i[b])),null===l&&(l=j.length-1),k>a&&(m=j.length-1)):j.push(null)}),this.trigger("unmask").each(function(){function h(){if(g.completed){for(var a=l;m>=a;a++)if(j[a]&&C[a]===p(a))return;g.completed.call(B)}}function p(a){return g.placeholder.charAt(a<g.placeholder.length?a:0)}function q(a){for(;++a<n&&!j[a];);return a}function r(a){for(;--a>=0&&!j[a];);return a}function s(a,b){var c,d;if(!(0>a)){for(c=a,d=q(b);n>c;c++)if(j[c]){if(!(n>d&&j[c].test(C[d])))break;C[c]=C[d],C[d]=p(d),d=q(d)}z(),B.caret(Math.max(l,a))}}function t(a){var b,c,d,e;for(b=a,c=p(a);n>b;b++)if(j[b]){if(d=q(b),e=C[b],C[b]=c,!(n>d&&j[d].test(e)))break;c=e}}function u(){var a=B.val(),b=B.caret();if(o&&o.length&&o.length>a.length){for(A(!0);b.begin>0&&!j[b.begin-1];)b.begin--;if(0===b.begin)for(;b.begin<l&&!j[b.begin];)b.begin++;B.caret(b.begin,b.begin)}else{for(A(!0);b.begin<n&&!j[b.begin];)b.begin++;B.caret(b.begin,b.begin)}h()}function v(){A(),B.val()!=E&&B.change()}function w(a){if(!B.prop("readonly")){var b,c,e,f=a.which||a.keyCode;o=B.val(),8===f||46===f||d&&127===f?(b=B.caret(),c=b.begin,e=b.end,e-c===0&&(c=46!==f?r(c):e=q(c-1),e=46===f?q(e):e),y(c,e),s(c,e-1),a.preventDefault()):13===f?v.call(this,a):27===f&&(B.val(E),B.caret(0,A()),a.preventDefault())}}function x(b){if(!B.prop("readonly")){var c,d,e,g=b.which||b.keyCode,i=B.caret();if(!(b.ctrlKey||b.altKey||b.metaKey||32>g)&&g&&13!==g){if(i.end-i.begin!==0&&(y(i.begin,i.end),s(i.begin,i.end-1)),c=q(i.begin-1),n>c&&(d=String.fromCharCode(g),j[c].test(d))){if(t(c),C[c]=d,z(),e=q(c),f){var k=function(){a.proxy(a.fn.caret,B,e)()};setTimeout(k,0)}else B.caret(e);i.begin<=m&&h()}b.preventDefault()}}}function y(a,b){var c;for(c=a;b>c&&n>c;c++)j[c]&&(C[c]=p(c))}function z(){B.val(C.join(""))}function A(a){var b,c,d,e=B.val(),f=-1;for(b=0,d=0;n>b;b++)if(j[b]){for(C[b]=p(b);d++<e.length;)if(c=e.charAt(d-1),j[b].test(c)){C[b]=c,f=b;break}if(d>e.length){y(b+1,n);break}}else C[b]===e.charAt(d)&&d++,k>b&&(f=b);return a?z():k>f+1?g.autoclear||C.join("")===D?(B.val()&&B.val(""),y(0,n)):z():(z(),B.val(B.val().substring(0,f+1))),k?b:l}var B=a(this),C=a.map(c.split(""),function(a,b){return"?"!=a?i[a]?p(b):a:void 0}),D=C.join(""),E=B.val();B.data(a.mask.dataName,function(){return a.map(C,function(a,b){return j[b]&&a!=p(b)?a:null}).join("")}),B.one("unmask",function(){B.off(".mask").removeData(a.mask.dataName)}).on("focus.mask",function(){if(!B.prop("readonly")){clearTimeout(b);var a;E=B.val(),a=A(),b=setTimeout(function(){B.get(0)===document.activeElement&&(z(),a==c.replace("?","").length?B.caret(0,a):B.caret(a))},10)}}).on("blur.mask",v).on("keydown.mask",w).on("keypress.mask",x).on("input.mask paste.mask",function(){B.prop("readonly")||setTimeout(function(){var a=A(!0);B.caret(a),h()},0)}),e&&f&&B.off("input.mask").on("input.mask",u),A()})}})});
/*! Select2 4.0.5 | https://github.com/select2/select2/blob/master/LICENSE.md */!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):"object"==typeof module&&module.exports?module.exports=function(b,c){return void 0===c&&(c="undefined"!=typeof window?require("jquery"):require("jquery")(b)),a(c),c}:a(jQuery)}(function(a){var b=function(){if(a&&a.fn&&a.fn.select2&&a.fn.select2.amd)var b=a.fn.select2.amd;var b;return function(){if(!b||!b.requirejs){b?c=b:b={};var a,c,d;!function(b){function e(a,b){return v.call(a,b)}function f(a,b){var c,d,e,f,g,h,i,j,k,l,m,n,o=b&&b.split("/"),p=t.map,q=p&&p["*"]||{};if(a){for(a=a.split("/"),g=a.length-1,t.nodeIdCompat&&x.test(a[g])&&(a[g]=a[g].replace(x,"")),"."===a[0].charAt(0)&&o&&(n=o.slice(0,o.length-1),a=n.concat(a)),k=0;k<a.length;k++)if("."===(m=a[k]))a.splice(k,1),k-=1;else if(".."===m){if(0===k||1===k&&".."===a[2]||".."===a[k-1])continue;k>0&&(a.splice(k-1,2),k-=2)}a=a.join("/")}if((o||q)&&p){for(c=a.split("/"),k=c.length;k>0;k-=1){if(d=c.slice(0,k).join("/"),o)for(l=o.length;l>0;l-=1)if((e=p[o.slice(0,l).join("/")])&&(e=e[d])){f=e,h=k;break}if(f)break;!i&&q&&q[d]&&(i=q[d],j=k)}!f&&i&&(f=i,h=j),f&&(c.splice(0,h,f),a=c.join("/"))}return a}function g(a,c){return function(){var d=w.call(arguments,0);return"string"!=typeof d[0]&&1===d.length&&d.push(null),o.apply(b,d.concat([a,c]))}}function h(a){return function(b){return f(b,a)}}function i(a){return function(b){r[a]=b}}function j(a){if(e(s,a)){var c=s[a];delete s[a],u[a]=!0,n.apply(b,c)}if(!e(r,a)&&!e(u,a))throw new Error("No "+a);return r[a]}function k(a){var b,c=a?a.indexOf("!"):-1;return c>-1&&(b=a.substring(0,c),a=a.substring(c+1,a.length)),[b,a]}function l(a){return a?k(a):[]}function m(a){return function(){return t&&t.config&&t.config[a]||{}}}var n,o,p,q,r={},s={},t={},u={},v=Object.prototype.hasOwnProperty,w=[].slice,x=/\.js$/;p=function(a,b){var c,d=k(a),e=d[0],g=b[1];return a=d[1],e&&(e=f(e,g),c=j(e)),e?a=c&&c.normalize?c.normalize(a,h(g)):f(a,g):(a=f(a,g),d=k(a),e=d[0],a=d[1],e&&(c=j(e))),{f:e?e+"!"+a:a,n:a,pr:e,p:c}},q={require:function(a){return g(a)},exports:function(a){var b=r[a];return void 0!==b?b:r[a]={}},module:function(a){return{id:a,uri:"",exports:r[a],config:m(a)}}},n=function(a,c,d,f){var h,k,m,n,o,t,v,w=[],x=typeof d;if(f=f||a,t=l(f),"undefined"===x||"function"===x){for(c=!c.length&&d.length?["require","exports","module"]:c,o=0;o<c.length;o+=1)if(n=p(c[o],t),"require"===(k=n.f))w[o]=q.require(a);else if("exports"===k)w[o]=q.exports(a),v=!0;else if("module"===k)h=w[o]=q.module(a);else if(e(r,k)||e(s,k)||e(u,k))w[o]=j(k);else{if(!n.p)throw new Error(a+" missing "+k);n.p.load(n.n,g(f,!0),i(k),{}),w[o]=r[k]}m=d?d.apply(r[a],w):void 0,a&&(h&&h.exports!==b&&h.exports!==r[a]?r[a]=h.exports:m===b&&v||(r[a]=m))}else a&&(r[a]=d)},a=c=o=function(a,c,d,e,f){if("string"==typeof a)return q[a]?q[a](c):j(p(a,l(c)).f);if(!a.splice){if(t=a,t.deps&&o(t.deps,t.callback),!c)return;c.splice?(a=c,c=d,d=null):a=b}return c=c||function(){},"function"==typeof d&&(d=e,e=f),e?n(b,a,c,d):setTimeout(function(){n(b,a,c,d)},4),o},o.config=function(a){return o(a)},a._defined=r,d=function(a,b,c){if("string"!=typeof a)throw new Error("See almond README: incorrect module build, no module name");b.splice||(c=b,b=[]),e(r,a)||e(s,a)||(s[a]=[a,b,c])},d.amd={jQuery:!0}}(),b.requirejs=a,b.require=c,b.define=d}}(),b.define("almond",function(){}),b.define("jquery",[],function(){var b=a||$;return null==b&&console&&console.error&&console.error("Select2: An instance of jQuery or a jQuery-compatible library was not found. Make sure that you are including jQuery before Select2 on your web page."),b}),b.define("select2/utils",["jquery"],function(a){function b(a){var b=a.prototype,c=[];for(var d in b){"function"==typeof b[d]&&("constructor"!==d&&c.push(d))}return c}var c={};c.Extend=function(a,b){function c(){this.constructor=a}var d={}.hasOwnProperty;for(var e in b)d.call(b,e)&&(a[e]=b[e]);return c.prototype=b.prototype,a.prototype=new c,a.__super__=b.prototype,a},c.Decorate=function(a,c){function d(){var b=Array.prototype.unshift,d=c.prototype.constructor.length,e=a.prototype.constructor;d>0&&(b.call(arguments,a.prototype.constructor),e=c.prototype.constructor),e.apply(this,arguments)}function e(){this.constructor=d}var f=b(c),g=b(a);c.displayName=a.displayName,d.prototype=new e;for(var h=0;h<g.length;h++){var i=g[h];d.prototype[i]=a.prototype[i]}for(var j=(function(a){var b=function(){};a in d.prototype&&(b=d.prototype[a]);var e=c.prototype[a];return function(){return Array.prototype.unshift.call(arguments,b),e.apply(this,arguments)}}),k=0;k<f.length;k++){var l=f[k];d.prototype[l]=j(l)}return d};var d=function(){this.listeners={}};return d.prototype.on=function(a,b){this.listeners=this.listeners||{},a in this.listeners?this.listeners[a].push(b):this.listeners[a]=[b]},d.prototype.trigger=function(a){var b=Array.prototype.slice,c=b.call(arguments,1);this.listeners=this.listeners||{},null==c&&(c=[]),0===c.length&&c.push({}),c[0]._type=a,a in this.listeners&&this.invoke(this.listeners[a],b.call(arguments,1)),"*"in this.listeners&&this.invoke(this.listeners["*"],arguments)},d.prototype.invoke=function(a,b){for(var c=0,d=a.length;c<d;c++)a[c].apply(this,b)},c.Observable=d,c.generateChars=function(a){for(var b="",c=0;c<a;c++){b+=Math.floor(36*Math.random()).toString(36)}return b},c.bind=function(a,b){return function(){a.apply(b,arguments)}},c._convertData=function(a){for(var b in a){var c=b.split("-"),d=a;if(1!==c.length){for(var e=0;e<c.length;e++){var f=c[e];f=f.substring(0,1).toLowerCase()+f.substring(1),f in d||(d[f]={}),e==c.length-1&&(d[f]=a[b]),d=d[f]}delete a[b]}}return a},c.hasScroll=function(b,c){var d=a(c),e=c.style.overflowX,f=c.style.overflowY;return(e!==f||"hidden"!==f&&"visible"!==f)&&("scroll"===e||"scroll"===f||(d.innerHeight()<c.scrollHeight||d.innerWidth()<c.scrollWidth))},c.escapeMarkup=function(a){var b={"\\":"&#92;","&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;","/":"&#47;"};return"string"!=typeof a?a:String(a).replace(/[&<>"'\/\\]/g,function(a){return b[a]})},c.appendMany=function(b,c){if("1.7"===a.fn.jquery.substr(0,3)){var d=a();a.map(c,function(a){d=d.add(a)}),c=d}b.append(c)},c}),b.define("select2/results",["jquery","./utils"],function(a,b){function c(a,b,d){this.$element=a,this.data=d,this.options=b,c.__super__.constructor.call(this)}return b.Extend(c,b.Observable),c.prototype.render=function(){var b=a('<ul class="select2-results__options" role="tree"></ul>');return this.options.get("multiple")&&b.attr("aria-multiselectable","true"),this.$results=b,b},c.prototype.clear=function(){this.$results.empty()},c.prototype.displayMessage=function(b){var c=this.options.get("escapeMarkup");this.clear(),this.hideLoading();var d=a('<li role="treeitem" aria-live="assertive" class="select2-results__option"></li>'),e=this.options.get("translations").get(b.message);d.append(c(e(b.args))),d[0].className+=" select2-results__message",this.$results.append(d)},c.prototype.hideMessages=function(){this.$results.find(".select2-results__message").remove()},c.prototype.append=function(a){this.hideLoading();var b=[];if(null==a.results||0===a.results.length)return void(0===this.$results.children().length&&this.trigger("results:message",{message:"noResults"}));a.results=this.sort(a.results);for(var c=0;c<a.results.length;c++){var d=a.results[c],e=this.option(d);b.push(e)}this.$results.append(b)},c.prototype.position=function(a,b){b.find(".select2-results").append(a)},c.prototype.sort=function(a){return this.options.get("sorter")(a)},c.prototype.highlightFirstItem=function(){var a=this.$results.find(".select2-results__option[aria-selected]"),b=a.filter("[aria-selected=true]");b.length>0?b.first().trigger("mouseenter"):a.first().trigger("mouseenter"),this.ensureHighlightVisible()},c.prototype.setClasses=function(){var b=this;this.data.current(function(c){var d=a.map(c,function(a){return a.id.toString()});b.$results.find(".select2-results__option[aria-selected]").each(function(){var b=a(this),c=a.data(this,"data"),e=""+c.id;null!=c.element&&c.element.selected||null==c.element&&a.inArray(e,d)>-1?b.attr("aria-selected","true"):b.attr("aria-selected","false")})})},c.prototype.showLoading=function(a){this.hideLoading();var b=this.options.get("translations").get("searching"),c={disabled:!0,loading:!0,text:b(a)},d=this.option(c);d.className+=" loading-results",this.$results.prepend(d)},c.prototype.hideLoading=function(){this.$results.find(".loading-results").remove()},c.prototype.option=function(b){var c=document.createElement("li");c.className="select2-results__option";var d={role:"treeitem","aria-selected":"false"};b.disabled&&(delete d["aria-selected"],d["aria-disabled"]="true"),null==b.id&&delete d["aria-selected"],null!=b._resultId&&(c.id=b._resultId),b.title&&(c.title=b.title),b.children&&(d.role="group",d["aria-label"]=b.text,delete d["aria-selected"]);for(var e in d){var f=d[e];c.setAttribute(e,f)}if(b.children){var g=a(c),h=document.createElement("strong");h.className="select2-results__group";a(h);this.template(b,h);for(var i=[],j=0;j<b.children.length;j++){var k=b.children[j],l=this.option(k);i.push(l)}var m=a("<ul></ul>",{class:"select2-results__options select2-results__options--nested"});m.append(i),g.append(h),g.append(m)}else this.template(b,c);return a.data(c,"data",b),c},c.prototype.bind=function(b,c){var d=this,e=b.id+"-results";this.$results.attr("id",e),b.on("results:all",function(a){d.clear(),d.append(a.data),b.isOpen()&&(d.setClasses(),d.highlightFirstItem())}),b.on("results:append",function(a){d.append(a.data),b.isOpen()&&d.setClasses()}),b.on("query",function(a){d.hideMessages(),d.showLoading(a)}),b.on("select",function(){b.isOpen()&&(d.setClasses(),d.highlightFirstItem())}),b.on("unselect",function(){b.isOpen()&&(d.setClasses(),d.highlightFirstItem())}),b.on("open",function(){d.$results.attr("aria-expanded","true"),d.$results.attr("aria-hidden","false"),d.setClasses(),d.ensureHighlightVisible()}),b.on("close",function(){d.$results.attr("aria-expanded","false"),d.$results.attr("aria-hidden","true"),d.$results.removeAttr("aria-activedescendant")}),b.on("results:toggle",function(){var a=d.getHighlightedResults();0!==a.length&&a.trigger("mouseup")}),b.on("results:select",function(){var a=d.getHighlightedResults();if(0!==a.length){var b=a.data("data");"true"==a.attr("aria-selected")?d.trigger("close",{}):d.trigger("select",{data:b})}}),b.on("results:previous",function(){var a=d.getHighlightedResults(),b=d.$results.find("[aria-selected]"),c=b.index(a);if(0!==c){var e=c-1;0===a.length&&(e=0);var f=b.eq(e);f.trigger("mouseenter");var g=d.$results.offset().top,h=f.offset().top,i=d.$results.scrollTop()+(h-g);0===e?d.$results.scrollTop(0):h-g<0&&d.$results.scrollTop(i)}}),b.on("results:next",function(){var a=d.getHighlightedResults(),b=d.$results.find("[aria-selected]"),c=b.index(a),e=c+1;if(!(e>=b.length)){var f=b.eq(e);f.trigger("mouseenter");var g=d.$results.offset().top+d.$results.outerHeight(!1),h=f.offset().top+f.outerHeight(!1),i=d.$results.scrollTop()+h-g;0===e?d.$results.scrollTop(0):h>g&&d.$results.scrollTop(i)}}),b.on("results:focus",function(a){a.element.addClass("select2-results__option--highlighted")}),b.on("results:message",function(a){d.displayMessage(a)}),a.fn.mousewheel&&this.$results.on("mousewheel",function(a){var b=d.$results.scrollTop(),c=d.$results.get(0).scrollHeight-b+a.deltaY,e=a.deltaY>0&&b-a.deltaY<=0,f=a.deltaY<0&&c<=d.$results.height();e?(d.$results.scrollTop(0),a.preventDefault(),a.stopPropagation()):f&&(d.$results.scrollTop(d.$results.get(0).scrollHeight-d.$results.height()),a.preventDefault(),a.stopPropagation())}),this.$results.on("mouseup",".select2-results__option[aria-selected]",function(b){var c=a(this),e=c.data("data");if("true"===c.attr("aria-selected"))return void(d.options.get("multiple")?d.trigger("unselect",{originalEvent:b,data:e}):d.trigger("close",{}));d.trigger("select",{originalEvent:b,data:e})}),this.$results.on("mouseenter",".select2-results__option[aria-selected]",function(b){var c=a(this).data("data");d.getHighlightedResults().removeClass("select2-results__option--highlighted"),d.trigger("results:focus",{data:c,element:a(this)})})},c.prototype.getHighlightedResults=function(){return this.$results.find(".select2-results__option--highlighted")},c.prototype.destroy=function(){this.$results.remove()},c.prototype.ensureHighlightVisible=function(){var a=this.getHighlightedResults();if(0!==a.length){var b=this.$results.find("[aria-selected]"),c=b.index(a),d=this.$results.offset().top,e=a.offset().top,f=this.$results.scrollTop()+(e-d),g=e-d;f-=2*a.outerHeight(!1),c<=2?this.$results.scrollTop(0):(g>this.$results.outerHeight()||g<0)&&this.$results.scrollTop(f)}},c.prototype.template=function(b,c){var d=this.options.get("templateResult"),e=this.options.get("escapeMarkup"),f=d(b,c);null==f?c.style.display="none":"string"==typeof f?c.innerHTML=e(f):a(c).append(f)},c}),b.define("select2/keys",[],function(){return{BACKSPACE:8,TAB:9,ENTER:13,SHIFT:16,CTRL:17,ALT:18,ESC:27,SPACE:32,PAGE_UP:33,PAGE_DOWN:34,END:35,HOME:36,LEFT:37,UP:38,RIGHT:39,DOWN:40,DELETE:46}}),b.define("select2/selection/base",["jquery","../utils","../keys"],function(a,b,c){function d(a,b){this.$element=a,this.options=b,d.__super__.constructor.call(this)}return b.Extend(d,b.Observable),d.prototype.render=function(){var b=a('<span class="select2-selection" role="combobox"  aria-haspopup="true" aria-expanded="false"></span>');return this._tabindex=0,null!=this.$element.data("old-tabindex")?this._tabindex=this.$element.data("old-tabindex"):null!=this.$element.attr("tabindex")&&(this._tabindex=this.$element.attr("tabindex")),b.attr("title",this.$element.attr("title")),b.attr("tabindex",this._tabindex),this.$selection=b,b},d.prototype.bind=function(a,b){var d=this,e=(a.id,a.id+"-results");this.container=a,this.$selection.on("focus",function(a){d.trigger("focus",a)}),this.$selection.on("blur",function(a){d._handleBlur(a)}),this.$selection.on("keydown",function(a){d.trigger("keypress",a),a.which===c.SPACE&&a.preventDefault()}),a.on("results:focus",function(a){d.$selection.attr("aria-activedescendant",a.data._resultId)}),a.on("selection:update",function(a){d.update(a.data)}),a.on("open",function(){d.$selection.attr("aria-expanded","true"),d.$selection.attr("aria-owns",e),d._attachCloseHandler(a)}),a.on("close",function(){d.$selection.attr("aria-expanded","false"),d.$selection.removeAttr("aria-activedescendant"),d.$selection.removeAttr("aria-owns"),d.$selection.focus(),d._detachCloseHandler(a)}),a.on("enable",function(){d.$selection.attr("tabindex",d._tabindex)}),a.on("disable",function(){d.$selection.attr("tabindex","-1")})},d.prototype._handleBlur=function(b){var c=this;window.setTimeout(function(){document.activeElement==c.$selection[0]||a.contains(c.$selection[0],document.activeElement)||c.trigger("blur",b)},1)},d.prototype._attachCloseHandler=function(b){a(document.body).on("mousedown.select2."+b.id,function(b){var c=a(b.target),d=c.closest(".select2");a(".select2.select2-container--open").each(function(){var b=a(this);this!=d[0]&&b.data("element").select2("close")})})},d.prototype._detachCloseHandler=function(b){a(document.body).off("mousedown.select2."+b.id)},d.prototype.position=function(a,b){b.find(".selection").append(a)},d.prototype.destroy=function(){this._detachCloseHandler(this.container)},d.prototype.update=function(a){throw new Error("The `update` method must be defined in child classes.")},d}),b.define("select2/selection/single",["jquery","./base","../utils","../keys"],function(a,b,c,d){function e(){e.__super__.constructor.apply(this,arguments)}return c.Extend(e,b),e.prototype.render=function(){var a=e.__super__.render.call(this);return a.addClass("select2-selection--single"),a.html('<span class="select2-selection__rendered"></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span>'),a},e.prototype.bind=function(a,b){var c=this;e.__super__.bind.apply(this,arguments);var d=a.id+"-container";this.$selection.find(".select2-selection__rendered").attr("id",d),this.$selection.attr("aria-labelledby",d),this.$selection.on("mousedown",function(a){1===a.which&&c.trigger("toggle",{originalEvent:a})}),this.$selection.on("focus",function(a){}),this.$selection.on("blur",function(a){}),a.on("focus",function(b){a.isOpen()||c.$selection.focus()}),a.on("selection:update",function(a){c.update(a.data)})},e.prototype.clear=function(){this.$selection.find(".select2-selection__rendered").empty()},e.prototype.display=function(a,b){var c=this.options.get("templateSelection");return this.options.get("escapeMarkup")(c(a,b))},e.prototype.selectionContainer=function(){return a("<span></span>")},e.prototype.update=function(a){if(0===a.length)return void this.clear();var b=a[0],c=this.$selection.find(".select2-selection__rendered"),d=this.display(b,c);c.empty().append(d),c.prop("title",b.title||b.text)},e}),b.define("select2/selection/multiple",["jquery","./base","../utils"],function(a,b,c){function d(a,b){d.__super__.constructor.apply(this,arguments)}return c.Extend(d,b),d.prototype.render=function(){var a=d.__super__.render.call(this);return a.addClass("select2-selection--multiple"),a.html('<ul class="select2-selection__rendered"></ul>'),a},d.prototype.bind=function(b,c){var e=this;d.__super__.bind.apply(this,arguments),this.$selection.on("click",function(a){e.trigger("toggle",{originalEvent:a})}),this.$selection.on("click",".select2-selection__choice__remove",function(b){if(!e.options.get("disabled")){var c=a(this),d=c.parent(),f=d.data("data");e.trigger("unselect",{originalEvent:b,data:f})}})},d.prototype.clear=function(){this.$selection.find(".select2-selection__rendered").empty()},d.prototype.display=function(a,b){var c=this.options.get("templateSelection");return this.options.get("escapeMarkup")(c(a,b))},d.prototype.selectionContainer=function(){return a('<li class="select2-selection__choice"><span class="select2-selection__choice__remove" role="presentation">&times;</span></li>')},d.prototype.update=function(a){if(this.clear(),0!==a.length){for(var b=[],d=0;d<a.length;d++){var e=a[d],f=this.selectionContainer(),g=this.display(e,f);f.append(g),f.prop("title",e.title||e.text),f.data("data",e),b.push(f)}var h=this.$selection.find(".select2-selection__rendered");c.appendMany(h,b)}},d}),b.define("select2/selection/placeholder",["../utils"],function(a){function b(a,b,c){this.placeholder=this.normalizePlaceholder(c.get("placeholder")),a.call(this,b,c)}return b.prototype.normalizePlaceholder=function(a,b){return"string"==typeof b&&(b={id:"",text:b}),b},b.prototype.createPlaceholder=function(a,b){var c=this.selectionContainer();return c.html(this.display(b)),c.addClass("select2-selection__placeholder").removeClass("select2-selection__choice"),c},b.prototype.update=function(a,b){var c=1==b.length&&b[0].id!=this.placeholder.id;if(b.length>1||c)return a.call(this,b);this.clear();var d=this.createPlaceholder(this.placeholder);this.$selection.find(".select2-selection__rendered").append(d)},b}),b.define("select2/selection/allowClear",["jquery","../keys"],function(a,b){function c(){}return c.prototype.bind=function(a,b,c){var d=this;a.call(this,b,c),null==this.placeholder&&this.options.get("debug")&&window.console&&console.error&&console.error("Select2: The `allowClear` option should be used in combination with the `placeholder` option."),this.$selection.on("mousedown",".select2-selection__clear",function(a){d._handleClear(a)}),b.on("keypress",function(a){d._handleKeyboardClear(a,b)})},c.prototype._handleClear=function(a,b){if(!this.options.get("disabled")){var c=this.$selection.find(".select2-selection__clear");if(0!==c.length){b.stopPropagation();for(var d=c.data("data"),e=0;e<d.length;e++){var f={data:d[e]};if(this.trigger("unselect",f),f.prevented)return}this.$element.val(this.placeholder.id).trigger("change"),this.trigger("toggle",{})}}},c.prototype._handleKeyboardClear=function(a,c,d){d.isOpen()||c.which!=b.DELETE&&c.which!=b.BACKSPACE||this._handleClear(c)},c.prototype.update=function(b,c){if(b.call(this,c),!(this.$selection.find(".select2-selection__placeholder").length>0||0===c.length)){var d=a('<span class="select2-selection__clear">&times;</span>');d.data("data",c),this.$selection.find(".select2-selection__rendered").prepend(d)}},c}),b.define("select2/selection/search",["jquery","../utils","../keys"],function(a,b,c){function d(a,b,c){a.call(this,b,c)}return d.prototype.render=function(b){var c=a('<li class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="-1" autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false" role="textbox" aria-autocomplete="list" /></li>');this.$searchContainer=c,this.$search=c.find("input");var d=b.call(this);return this._transferTabIndex(),d},d.prototype.bind=function(a,b,d){var e=this;a.call(this,b,d),b.on("open",function(){e.$search.trigger("focus")}),b.on("close",function(){e.$search.val(""),e.$search.removeAttr("aria-activedescendant"),e.$search.trigger("focus")}),b.on("enable",function(){e.$search.prop("disabled",!1),e._transferTabIndex()}),b.on("disable",function(){e.$search.prop("disabled",!0)}),b.on("focus",function(a){e.$search.trigger("focus")}),b.on("results:focus",function(a){e.$search.attr("aria-activedescendant",a.id)}),this.$selection.on("focusin",".select2-search--inline",function(a){e.trigger("focus",a)}),this.$selection.on("focusout",".select2-search--inline",function(a){e._handleBlur(a)}),this.$selection.on("keydown",".select2-search--inline",function(a){if(a.stopPropagation(),e.trigger("keypress",a),e._keyUpPrevented=a.isDefaultPrevented(),a.which===c.BACKSPACE&&""===e.$search.val()){var b=e.$searchContainer.prev(".select2-selection__choice");if(b.length>0){var d=b.data("data");e.searchRemoveChoice(d),a.preventDefault()}}});var f=document.documentMode,g=f&&f<=11;this.$selection.on("input.searchcheck",".select2-search--inline",function(a){if(g)return void e.$selection.off("input.search input.searchcheck");e.$selection.off("keyup.search")}),this.$selection.on("keyup.search input.search",".select2-search--inline",function(a){if(g&&"input"===a.type)return void e.$selection.off("input.search input.searchcheck");var b=a.which;b!=c.SHIFT&&b!=c.CTRL&&b!=c.ALT&&b!=c.TAB&&e.handleSearch(a)})},d.prototype._transferTabIndex=function(a){this.$search.attr("tabindex",this.$selection.attr("tabindex")),this.$selection.attr("tabindex","-1")},d.prototype.createPlaceholder=function(a,b){this.$search.attr("placeholder",b.text)},d.prototype.update=function(a,b){var c=this.$search[0]==document.activeElement;this.$search.attr("placeholder",""),a.call(this,b),this.$selection.find(".select2-selection__rendered").append(this.$searchContainer),this.resizeSearch(),c&&this.$search.focus()},d.prototype.handleSearch=function(){if(this.resizeSearch(),!this._keyUpPrevented){var a=this.$search.val();this.trigger("query",{term:a})}this._keyUpPrevented=!1},d.prototype.searchRemoveChoice=function(a,b){this.trigger("unselect",{data:b}),this.$search.val(b.text),this.handleSearch()},d.prototype.resizeSearch=function(){this.$search.css("width","25px");var a="";if(""!==this.$search.attr("placeholder"))a=this.$selection.find(".select2-selection__rendered").innerWidth();else{a=.75*(this.$search.val().length+1)+"em"}this.$search.css("width",a)},d}),b.define("select2/selection/eventRelay",["jquery"],function(a){function b(){}return b.prototype.bind=function(b,c,d){var e=this,f=["open","opening","close","closing","select","selecting","unselect","unselecting"],g=["opening","closing","selecting","unselecting"];b.call(this,c,d),c.on("*",function(b,c){if(-1!==a.inArray(b,f)){c=c||{};var d=a.Event("select2:"+b,{params:c});e.$element.trigger(d),-1!==a.inArray(b,g)&&(c.prevented=d.isDefaultPrevented())}})},b}),b.define("select2/translation",["jquery","require"],function(a,b){function c(a){this.dict=a||{}}return c.prototype.all=function(){return this.dict},c.prototype.get=function(a){return this.dict[a]},c.prototype.extend=function(b){this.dict=a.extend({},b.all(),this.dict)},c._cache={},c.loadPath=function(a){if(!(a in c._cache)){var d=b(a);c._cache[a]=d}return new c(c._cache[a])},c}),b.define("select2/diacritics",[],function(){return{"Ⓐ":"A","Ａ":"A","À":"A","Á":"A","Â":"A","Ầ":"A","Ấ":"A","Ẫ":"A","Ẩ":"A","Ã":"A","Ā":"A","Ă":"A","Ằ":"A","Ắ":"A","Ẵ":"A","Ẳ":"A","Ȧ":"A","Ǡ":"A","Ä":"A","Ǟ":"A","Ả":"A","Å":"A","Ǻ":"A","Ǎ":"A","Ȁ":"A","Ȃ":"A","Ạ":"A","Ậ":"A","Ặ":"A","Ḁ":"A","Ą":"A","Ⱥ":"A","Ɐ":"A","Ꜳ":"AA","Æ":"AE","Ǽ":"AE","Ǣ":"AE","Ꜵ":"AO","Ꜷ":"AU","Ꜹ":"AV","Ꜻ":"AV","Ꜽ":"AY","Ⓑ":"B","Ｂ":"B","Ḃ":"B","Ḅ":"B","Ḇ":"B","Ƀ":"B","Ƃ":"B","Ɓ":"B","Ⓒ":"C","Ｃ":"C","Ć":"C","Ĉ":"C","Ċ":"C","Č":"C","Ç":"C","Ḉ":"C","Ƈ":"C","Ȼ":"C","Ꜿ":"C","Ⓓ":"D","Ｄ":"D","Ḋ":"D","Ď":"D","Ḍ":"D","Ḑ":"D","Ḓ":"D","Ḏ":"D","Đ":"D","Ƌ":"D","Ɗ":"D","Ɖ":"D","Ꝺ":"D","Ǳ":"DZ","Ǆ":"DZ","ǲ":"Dz","ǅ":"Dz","Ⓔ":"E","Ｅ":"E","È":"E","É":"E","Ê":"E","Ề":"E","Ế":"E","Ễ":"E","Ể":"E","Ẽ":"E","Ē":"E","Ḕ":"E","Ḗ":"E","Ĕ":"E","Ė":"E","Ë":"E","Ẻ":"E","Ě":"E","Ȅ":"E","Ȇ":"E","Ẹ":"E","Ệ":"E","Ȩ":"E","Ḝ":"E","Ę":"E","Ḙ":"E","Ḛ":"E","Ɛ":"E","Ǝ":"E","Ⓕ":"F","Ｆ":"F","Ḟ":"F","Ƒ":"F","Ꝼ":"F","Ⓖ":"G","Ｇ":"G","Ǵ":"G","Ĝ":"G","Ḡ":"G","Ğ":"G","Ġ":"G","Ǧ":"G","Ģ":"G","Ǥ":"G","Ɠ":"G","Ꞡ":"G","Ᵹ":"G","Ꝿ":"G","Ⓗ":"H","Ｈ":"H","Ĥ":"H","Ḣ":"H","Ḧ":"H","Ȟ":"H","Ḥ":"H","Ḩ":"H","Ḫ":"H","Ħ":"H","Ⱨ":"H","Ⱶ":"H","Ɥ":"H","Ⓘ":"I","Ｉ":"I","Ì":"I","Í":"I","Î":"I","Ĩ":"I","Ī":"I","Ĭ":"I","İ":"I","Ï":"I","Ḯ":"I","Ỉ":"I","Ǐ":"I","Ȉ":"I","Ȋ":"I","Ị":"I","Į":"I","Ḭ":"I","Ɨ":"I","Ⓙ":"J","Ｊ":"J","Ĵ":"J","Ɉ":"J","Ⓚ":"K","Ｋ":"K","Ḱ":"K","Ǩ":"K","Ḳ":"K","Ķ":"K","Ḵ":"K","Ƙ":"K","Ⱪ":"K","Ꝁ":"K","Ꝃ":"K","Ꝅ":"K","Ꞣ":"K","Ⓛ":"L","Ｌ":"L","Ŀ":"L","Ĺ":"L","Ľ":"L","Ḷ":"L","Ḹ":"L","Ļ":"L","Ḽ":"L","Ḻ":"L","Ł":"L","Ƚ":"L","Ɫ":"L","Ⱡ":"L","Ꝉ":"L","Ꝇ":"L","Ꞁ":"L","Ǉ":"LJ","ǈ":"Lj","Ⓜ":"M","Ｍ":"M","Ḿ":"M","Ṁ":"M","Ṃ":"M","Ɱ":"M","Ɯ":"M","Ⓝ":"N","Ｎ":"N","Ǹ":"N","Ń":"N","Ñ":"N","Ṅ":"N","Ň":"N","Ṇ":"N","Ņ":"N","Ṋ":"N","Ṉ":"N","Ƞ":"N","Ɲ":"N","Ꞑ":"N","Ꞥ":"N","Ǌ":"NJ","ǋ":"Nj","Ⓞ":"O","Ｏ":"O","Ò":"O","Ó":"O","Ô":"O","Ồ":"O","Ố":"O","Ỗ":"O","Ổ":"O","Õ":"O","Ṍ":"O","Ȭ":"O","Ṏ":"O","Ō":"O","Ṑ":"O","Ṓ":"O","Ŏ":"O","Ȯ":"O","Ȱ":"O","Ö":"O","Ȫ":"O","Ỏ":"O","Ő":"O","Ǒ":"O","Ȍ":"O","Ȏ":"O","Ơ":"O","Ờ":"O","Ớ":"O","Ỡ":"O","Ở":"O","Ợ":"O","Ọ":"O","Ộ":"O","Ǫ":"O","Ǭ":"O","Ø":"O","Ǿ":"O","Ɔ":"O","Ɵ":"O","Ꝋ":"O","Ꝍ":"O","Ƣ":"OI","Ꝏ":"OO","Ȣ":"OU","Ⓟ":"P","Ｐ":"P","Ṕ":"P","Ṗ":"P","Ƥ":"P","Ᵽ":"P","Ꝑ":"P","Ꝓ":"P","Ꝕ":"P","Ⓠ":"Q","Ｑ":"Q","Ꝗ":"Q","Ꝙ":"Q","Ɋ":"Q","Ⓡ":"R","Ｒ":"R","Ŕ":"R","Ṙ":"R","Ř":"R","Ȑ":"R","Ȓ":"R","Ṛ":"R","Ṝ":"R","Ŗ":"R","Ṟ":"R","Ɍ":"R","Ɽ":"R","Ꝛ":"R","Ꞧ":"R","Ꞃ":"R","Ⓢ":"S","Ｓ":"S","ẞ":"S","Ś":"S","Ṥ":"S","Ŝ":"S","Ṡ":"S","Š":"S","Ṧ":"S","Ṣ":"S","Ṩ":"S","Ș":"S","Ş":"S","Ȿ":"S","Ꞩ":"S","Ꞅ":"S","Ⓣ":"T","Ｔ":"T","Ṫ":"T","Ť":"T","Ṭ":"T","Ț":"T","Ţ":"T","Ṱ":"T","Ṯ":"T","Ŧ":"T","Ƭ":"T","Ʈ":"T","Ⱦ":"T","Ꞇ":"T","Ꜩ":"TZ","Ⓤ":"U","Ｕ":"U","Ù":"U","Ú":"U","Û":"U","Ũ":"U","Ṹ":"U","Ū":"U","Ṻ":"U","Ŭ":"U","Ü":"U","Ǜ":"U","Ǘ":"U","Ǖ":"U","Ǚ":"U","Ủ":"U","Ů":"U","Ű":"U","Ǔ":"U","Ȕ":"U","Ȗ":"U","Ư":"U","Ừ":"U","Ứ":"U","Ữ":"U","Ử":"U","Ự":"U","Ụ":"U","Ṳ":"U","Ų":"U","Ṷ":"U","Ṵ":"U","Ʉ":"U","Ⓥ":"V","Ｖ":"V","Ṽ":"V","Ṿ":"V","Ʋ":"V","Ꝟ":"V","Ʌ":"V","Ꝡ":"VY","Ⓦ":"W","Ｗ":"W","Ẁ":"W","Ẃ":"W","Ŵ":"W","Ẇ":"W","Ẅ":"W","Ẉ":"W","Ⱳ":"W","Ⓧ":"X","Ｘ":"X","Ẋ":"X","Ẍ":"X","Ⓨ":"Y","Ｙ":"Y","Ỳ":"Y","Ý":"Y","Ŷ":"Y","Ỹ":"Y","Ȳ":"Y","Ẏ":"Y","Ÿ":"Y","Ỷ":"Y","Ỵ":"Y","Ƴ":"Y","Ɏ":"Y","Ỿ":"Y","Ⓩ":"Z","Ｚ":"Z","Ź":"Z","Ẑ":"Z","Ż":"Z","Ž":"Z","Ẓ":"Z","Ẕ":"Z","Ƶ":"Z","Ȥ":"Z","Ɀ":"Z","Ⱬ":"Z","Ꝣ":"Z","ⓐ":"a","ａ":"a","ẚ":"a","à":"a","á":"a","â":"a","ầ":"a","ấ":"a","ẫ":"a","ẩ":"a","ã":"a","ā":"a","ă":"a","ằ":"a","ắ":"a","ẵ":"a","ẳ":"a","ȧ":"a","ǡ":"a","ä":"a","ǟ":"a","ả":"a","å":"a","ǻ":"a","ǎ":"a","ȁ":"a","ȃ":"a","ạ":"a","ậ":"a","ặ":"a","ḁ":"a","ą":"a","ⱥ":"a","ɐ":"a","ꜳ":"aa","æ":"ae","ǽ":"ae","ǣ":"ae","ꜵ":"ao","ꜷ":"au","ꜹ":"av","ꜻ":"av","ꜽ":"ay","ⓑ":"b","ｂ":"b","ḃ":"b","ḅ":"b","ḇ":"b","ƀ":"b","ƃ":"b","ɓ":"b","ⓒ":"c","ｃ":"c","ć":"c","ĉ":"c","ċ":"c","č":"c","ç":"c","ḉ":"c","ƈ":"c","ȼ":"c","ꜿ":"c","ↄ":"c","ⓓ":"d","ｄ":"d","ḋ":"d","ď":"d","ḍ":"d","ḑ":"d","ḓ":"d","ḏ":"d","đ":"d","ƌ":"d","ɖ":"d","ɗ":"d","ꝺ":"d","ǳ":"dz","ǆ":"dz","ⓔ":"e","ｅ":"e","è":"e","é":"e","ê":"e","ề":"e","ế":"e","ễ":"e","ể":"e","ẽ":"e","ē":"e","ḕ":"e","ḗ":"e","ĕ":"e","ė":"e","ë":"e","ẻ":"e","ě":"e","ȅ":"e","ȇ":"e","ẹ":"e","ệ":"e","ȩ":"e","ḝ":"e","ę":"e","ḙ":"e","ḛ":"e","ɇ":"e","ɛ":"e","ǝ":"e","ⓕ":"f","ｆ":"f","ḟ":"f","ƒ":"f","ꝼ":"f","ⓖ":"g","ｇ":"g","ǵ":"g","ĝ":"g","ḡ":"g","ğ":"g","ġ":"g","ǧ":"g","ģ":"g","ǥ":"g","ɠ":"g","ꞡ":"g","ᵹ":"g","ꝿ":"g","ⓗ":"h","ｈ":"h","ĥ":"h","ḣ":"h","ḧ":"h","ȟ":"h","ḥ":"h","ḩ":"h","ḫ":"h","ẖ":"h","ħ":"h","ⱨ":"h","ⱶ":"h","ɥ":"h","ƕ":"hv","ⓘ":"i","ｉ":"i","ì":"i","í":"i","î":"i","ĩ":"i","ī":"i","ĭ":"i","ï":"i","ḯ":"i","ỉ":"i","ǐ":"i","ȉ":"i","ȋ":"i","ị":"i","į":"i","ḭ":"i","ɨ":"i","ı":"i","ⓙ":"j","ｊ":"j","ĵ":"j","ǰ":"j","ɉ":"j","ⓚ":"k","ｋ":"k","ḱ":"k","ǩ":"k","ḳ":"k","ķ":"k","ḵ":"k","ƙ":"k","ⱪ":"k","ꝁ":"k","ꝃ":"k","ꝅ":"k","ꞣ":"k","ⓛ":"l","ｌ":"l","ŀ":"l","ĺ":"l","ľ":"l","ḷ":"l","ḹ":"l","ļ":"l","ḽ":"l","ḻ":"l","ſ":"l","ł":"l","ƚ":"l","ɫ":"l","ⱡ":"l","ꝉ":"l","ꞁ":"l","ꝇ":"l","ǉ":"lj","ⓜ":"m","ｍ":"m","ḿ":"m","ṁ":"m","ṃ":"m","ɱ":"m","ɯ":"m","ⓝ":"n","ｎ":"n","ǹ":"n","ń":"n","ñ":"n","ṅ":"n","ň":"n","ṇ":"n","ņ":"n","ṋ":"n","ṉ":"n","ƞ":"n","ɲ":"n","ŉ":"n","ꞑ":"n","ꞥ":"n","ǌ":"nj","ⓞ":"o","ｏ":"o","ò":"o","ó":"o","ô":"o","ồ":"o","ố":"o","ỗ":"o","ổ":"o","õ":"o","ṍ":"o","ȭ":"o","ṏ":"o","ō":"o","ṑ":"o","ṓ":"o","ŏ":"o","ȯ":"o","ȱ":"o","ö":"o","ȫ":"o","ỏ":"o","ő":"o","ǒ":"o","ȍ":"o","ȏ":"o","ơ":"o","ờ":"o","ớ":"o","ỡ":"o","ở":"o","ợ":"o","ọ":"o","ộ":"o","ǫ":"o","ǭ":"o","ø":"o","ǿ":"o","ɔ":"o","ꝋ":"o","ꝍ":"o","ɵ":"o","ƣ":"oi","ȣ":"ou","ꝏ":"oo","ⓟ":"p","ｐ":"p","ṕ":"p","ṗ":"p","ƥ":"p","ᵽ":"p","ꝑ":"p","ꝓ":"p","ꝕ":"p","ⓠ":"q","ｑ":"q","ɋ":"q","ꝗ":"q","ꝙ":"q","ⓡ":"r","ｒ":"r","ŕ":"r","ṙ":"r","ř":"r","ȑ":"r","ȓ":"r","ṛ":"r","ṝ":"r","ŗ":"r","ṟ":"r","ɍ":"r","ɽ":"r","ꝛ":"r","ꞧ":"r","ꞃ":"r","ⓢ":"s","ｓ":"s","ß":"s","ś":"s","ṥ":"s","ŝ":"s","ṡ":"s","š":"s","ṧ":"s","ṣ":"s","ṩ":"s","ș":"s","ş":"s","ȿ":"s","ꞩ":"s","ꞅ":"s","ẛ":"s","ⓣ":"t","ｔ":"t","ṫ":"t","ẗ":"t","ť":"t","ṭ":"t","ț":"t","ţ":"t","ṱ":"t","ṯ":"t","ŧ":"t","ƭ":"t","ʈ":"t","ⱦ":"t","ꞇ":"t","ꜩ":"tz","ⓤ":"u","ｕ":"u","ù":"u","ú":"u","û":"u","ũ":"u","ṹ":"u","ū":"u","ṻ":"u","ŭ":"u","ü":"u","ǜ":"u","ǘ":"u","ǖ":"u","ǚ":"u","ủ":"u","ů":"u","ű":"u","ǔ":"u","ȕ":"u","ȗ":"u","ư":"u","ừ":"u","ứ":"u","ữ":"u","ử":"u","ự":"u","ụ":"u","ṳ":"u","ų":"u","ṷ":"u","ṵ":"u","ʉ":"u","ⓥ":"v","ｖ":"v","ṽ":"v","ṿ":"v","ʋ":"v","ꝟ":"v","ʌ":"v","ꝡ":"vy","ⓦ":"w","ｗ":"w","ẁ":"w","ẃ":"w","ŵ":"w","ẇ":"w","ẅ":"w","ẘ":"w","ẉ":"w","ⱳ":"w","ⓧ":"x","ｘ":"x","ẋ":"x","ẍ":"x","ⓨ":"y","ｙ":"y","ỳ":"y","ý":"y","ŷ":"y","ỹ":"y","ȳ":"y","ẏ":"y","ÿ":"y","ỷ":"y","ẙ":"y","ỵ":"y","ƴ":"y","ɏ":"y","ỿ":"y","ⓩ":"z","ｚ":"z","ź":"z","ẑ":"z","ż":"z","ž":"z","ẓ":"z","ẕ":"z","ƶ":"z","ȥ":"z","ɀ":"z","ⱬ":"z","ꝣ":"z","Ά":"Α","Έ":"Ε","Ή":"Η","Ί":"Ι","Ϊ":"Ι","Ό":"Ο","Ύ":"Υ","Ϋ":"Υ","Ώ":"Ω","ά":"α","έ":"ε","ή":"η","ί":"ι","ϊ":"ι","ΐ":"ι","ό":"ο","ύ":"υ","ϋ":"υ","ΰ":"υ","ω":"ω","ς":"σ"}}),b.define("select2/data/base",["../utils"],function(a){function b(a,c){b.__super__.constructor.call(this)}return a.Extend(b,a.Observable),b.prototype.current=function(a){throw new Error("The `current` method must be defined in child classes.")},b.prototype.query=function(a,b){throw new Error("The `query` method must be defined in child classes.")},b.prototype.bind=function(a,b){},b.prototype.destroy=function(){},b.prototype.generateResultId=function(b,c){var d=b.id+"-result-";return d+=a.generateChars(4),null!=c.id?d+="-"+c.id.toString():d+="-"+a.generateChars(4),d},b}),b.define("select2/data/select",["./base","../utils","jquery"],function(a,b,c){function d(a,b){this.$element=a,this.options=b,d.__super__.constructor.call(this)}return b.Extend(d,a),d.prototype.current=function(a){var b=[],d=this;this.$element.find(":selected").each(function(){var a=c(this),e=d.item(a);b.push(e)}),a(b)},d.prototype.select=function(a){var b=this;if(a.selected=!0,c(a.element).is("option"))return a.element.selected=!0,void this.$element.trigger("change");if(this.$element.prop("multiple"))this.current(function(d){var e=[];a=[a],a.push.apply(a,d);for(var f=0;f<a.length;f++){var g=a[f].id;-1===c.inArray(g,e)&&e.push(g)}b.$element.val(e),b.$element.trigger("change")});else{var d=a.id;this.$element.val(d),this.$element.trigger("change")}},d.prototype.unselect=function(a){var b=this;if(this.$element.prop("multiple")){if(a.selected=!1,c(a.element).is("option"))return a.element.selected=!1,void this.$element.trigger("change");this.current(function(d){for(var e=[],f=0;f<d.length;f++){var g=d[f].id;g!==a.id&&-1===c.inArray(g,e)&&e.push(g)}b.$element.val(e),b.$element.trigger("change")})}},d.prototype.bind=function(a,b){var c=this;this.container=a,a.on("select",function(a){c.select(a.data)}),a.on("unselect",function(a){c.unselect(a.data)})},d.prototype.destroy=function(){this.$element.find("*").each(function(){c.removeData(this,"data")})},d.prototype.query=function(a,b){var d=[],e=this;this.$element.children().each(function(){var b=c(this);if(b.is("option")||b.is("optgroup")){var f=e.item(b),g=e.matches(a,f);null!==g&&d.push(g)}}),b({results:d})},d.prototype.addOptions=function(a){b.appendMany(this.$element,a)},d.prototype.option=function(a){var b;a.children?(b=document.createElement("optgroup"),b.label=a.text):(b=document.createElement("option"),void 0!==b.textContent?b.textContent=a.text:b.innerText=a.text),void 0!==a.id&&(b.value=a.id),a.disabled&&(b.disabled=!0),a.selected&&(b.selected=!0),a.title&&(b.title=a.title);var d=c(b),e=this._normalizeItem(a);return e.element=b,c.data(b,"data",e),d},d.prototype.item=function(a){var b={};if(null!=(b=c.data(a[0],"data")))return b;if(a.is("option"))b={id:a.val(),text:a.text(),disabled:a.prop("disabled"),selected:a.prop("selected"),title:a.prop("title")};else if(a.is("optgroup")){b={text:a.prop("label"),children:[],title:a.prop("title")};for(var d=a.children("option"),e=[],f=0;f<d.length;f++){var g=c(d[f]),h=this.item(g);e.push(h)}b.children=e}return b=this._normalizeItem(b),b.element=a[0],c.data(a[0],"data",b),b},d.prototype._normalizeItem=function(a){c.isPlainObject(a)||(a={id:a,text:a}),a=c.extend({},{text:""},a);var b={selected:!1,disabled:!1};return null!=a.id&&(a.id=a.id.toString()),null!=a.text&&(a.text=a.text.toString()),null==a._resultId&&a.id&&null!=this.container&&(a._resultId=this.generateResultId(this.container,a)),c.extend({},b,a)},d.prototype.matches=function(a,b){return this.options.get("matcher")(a,b)},d}),b.define("select2/data/array",["./select","../utils","jquery"],function(a,b,c){function d(a,b){var c=b.get("data")||[];d.__super__.constructor.call(this,a,b),this.addOptions(this.convertToOptions(c))}return b.Extend(d,a),d.prototype.select=function(a){var b=this.$element.find("option").filter(function(b,c){return c.value==a.id.toString()});0===b.length&&(b=this.option(a),this.addOptions(b)),d.__super__.select.call(this,a)},d.prototype.convertToOptions=function(a){function d(a){return function(){return c(this).val()==a.id}}for(var e=this,f=this.$element.find("option"),g=f.map(function(){return e.item(c(this)).id}).get(),h=[],i=0;i<a.length;i++){var j=this._normalizeItem(a[i]);if(c.inArray(j.id,g)>=0){var k=f.filter(d(j)),l=this.item(k),m=c.extend(!0,{},j,l),n=this.option(m);k.replaceWith(n)}else{var o=this.option(j);if(j.children){var p=this.convertToOptions(j.children);b.appendMany(o,p)}h.push(o)}}return h},d}),b.define("select2/data/ajax",["./array","../utils","jquery"],function(a,b,c){function d(a,b){this.ajaxOptions=this._applyDefaults(b.get("ajax")),null!=this.ajaxOptions.processResults&&(this.processResults=this.ajaxOptions.processResults),d.__super__.constructor.call(this,a,b)}return b.Extend(d,a),d.prototype._applyDefaults=function(a){var b={data:function(a){return c.extend({},a,{q:a.term})},transport:function(a,b,d){var e=c.ajax(a);return e.then(b),e.fail(d),e}};return c.extend({},b,a,!0)},d.prototype.processResults=function(a){return a},d.prototype.query=function(a,b){function d(){var d=f.transport(f,function(d){var f=e.processResults(d,a);e.options.get("debug")&&window.console&&console.error&&(f&&f.results&&c.isArray(f.results)||console.error("Select2: The AJAX results did not return an array in the `results` key of the response.")),b(f)},function(){d.status&&"0"===d.status||e.trigger("results:message",{message:"errorLoading"})});e._request=d}var e=this;null!=this._request&&(c.isFunction(this._request.abort)&&this._request.abort(),this._request=null);var f=c.extend({type:"GET"},this.ajaxOptions);"function"==typeof f.url&&(f.url=f.url.call(this.$element,a)),"function"==typeof f.data&&(f.data=f.data.call(this.$element,a)),this.ajaxOptions.delay&&null!=a.term?(this._queryTimeout&&window.clearTimeout(this._queryTimeout),this._queryTimeout=window.setTimeout(d,this.ajaxOptions.delay)):d()},d}),b.define("select2/data/tags",["jquery"],function(a){function b(b,c,d){var e=d.get("tags"),f=d.get("createTag");void 0!==f&&(this.createTag=f);var g=d.get("insertTag");if(void 0!==g&&(this.insertTag=g),b.call(this,c,d),a.isArray(e))for(var h=0;h<e.length;h++){var i=e[h],j=this._normalizeItem(i),k=this.option(j);this.$element.append(k)}}return b.prototype.query=function(a,b,c){function d(a,f){for(var g=a.results,h=0;h<g.length;h++){var i=g[h],j=null!=i.children&&!d({results:i.children},!0);if((i.text||"").toUpperCase()===(b.term||"").toUpperCase()||j)return!f&&(a.data=g,void c(a))}if(f)return!0;var k=e.createTag(b);if(null!=k){var l=e.option(k);l.attr("data-select2-tag",!0),e.addOptions([l]),e.insertTag(g,k)}a.results=g,c(a)}var e=this;if(this._removeOldTags(),null==b.term||null!=b.page)return void a.call(this,b,c);a.call(this,b,d)},b.prototype.createTag=function(b,c){var d=a.trim(c.term);return""===d?null:{id:d,text:d}},b.prototype.insertTag=function(a,b,c){b.unshift(c)},b.prototype._removeOldTags=function(b){this._lastTag;this.$element.find("option[data-select2-tag]").each(function(){this.selected||a(this).remove()})},b}),b.define("select2/data/tokenizer",["jquery"],function(a){function b(a,b,c){var d=c.get("tokenizer");void 0!==d&&(this.tokenizer=d),a.call(this,b,c)}return b.prototype.bind=function(a,b,c){a.call(this,b,c),this.$search=b.dropdown.$search||b.selection.$search||c.find(".select2-search__field")},b.prototype.query=function(b,c,d){function e(b){var c=g._normalizeItem(b);if(!g.$element.find("option").filter(function(){return a(this).val()===c.id}).length){var d=g.option(c);d.attr("data-select2-tag",!0),g._removeOldTags(),g.addOptions([d])}f(c)}function f(a){g.trigger("select",{data:a})}var g=this;c.term=c.term||"";var h=this.tokenizer(c,this.options,e);h.term!==c.term&&(this.$search.length&&(this.$search.val(h.term),this.$search.focus()),c.term=h.term),b.call(this,c,d)},b.prototype.tokenizer=function(b,c,d,e){for(var f=d.get("tokenSeparators")||[],g=c.term,h=0,i=this.createTag||function(a){return{id:a.term,text:a.term}};h<g.length;){var j=g[h];if(-1!==a.inArray(j,f)){var k=g.substr(0,h),l=a.extend({},c,{term:k}),m=i(l);null!=m?(e(m),g=g.substr(h+1)||"",h=0):h++}else h++}return{term:g}},b}),b.define("select2/data/minimumInputLength",[],function(){function a(a,b,c){this.minimumInputLength=c.get("minimumInputLength"),a.call(this,b,c)}return a.prototype.query=function(a,b,c){if(b.term=b.term||"",b.term.length<this.minimumInputLength)return void this.trigger("results:message",{message:"inputTooShort",args:{minimum:this.minimumInputLength,input:b.term,params:b}});a.call(this,b,c)},a}),b.define("select2/data/maximumInputLength",[],function(){function a(a,b,c){this.maximumInputLength=c.get("maximumInputLength"),a.call(this,b,c)}return a.prototype.query=function(a,b,c){if(b.term=b.term||"",this.maximumInputLength>0&&b.term.length>this.maximumInputLength)return void this.trigger("results:message",{message:"inputTooLong",args:{maximum:this.maximumInputLength,input:b.term,params:b}});a.call(this,b,c)},a}),b.define("select2/data/maximumSelectionLength",[],function(){function a(a,b,c){this.maximumSelectionLength=c.get("maximumSelectionLength"),a.call(this,b,c)}return a.prototype.query=function(a,b,c){var d=this;this.current(function(e){var f=null!=e?e.length:0;if(d.maximumSelectionLength>0&&f>=d.maximumSelectionLength)return void d.trigger("results:message",{message:"maximumSelected",args:{maximum:d.maximumSelectionLength}});a.call(d,b,c)})},a}),b.define("select2/dropdown",["jquery","./utils"],function(a,b){function c(a,b){this.$element=a,this.options=b,c.__super__.constructor.call(this)}return b.Extend(c,b.Observable),c.prototype.render=function(){var b=a('<span class="select2-dropdown"><span class="select2-results"></span></span>');return b.attr("dir",this.options.get("dir")),this.$dropdown=b,b},c.prototype.bind=function(){},c.prototype.position=function(a,b){},c.prototype.destroy=function(){this.$dropdown.remove()},c}),b.define("select2/dropdown/search",["jquery","../utils"],function(a,b){function c(){}return c.prototype.render=function(b){var c=b.call(this),d=a('<span class="select2-search select2-search--dropdown"><input class="select2-search__field" type="search" tabindex="-1" autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false" role="textbox" /></span>');return this.$searchContainer=d,this.$search=d.find("input"),c.prepend(d),c},c.prototype.bind=function(b,c,d){var e=this;b.call(this,c,d),this.$search.on("keydown",function(a){e.trigger("keypress",a),e._keyUpPrevented=a.isDefaultPrevented()}),this.$search.on("input",function(b){a(this).off("keyup")}),this.$search.on("keyup input",function(a){e.handleSearch(a)}),c.on("open",function(){e.$search.attr("tabindex",0),e.$search.focus(),window.setTimeout(function(){e.$search.focus()},0)}),c.on("close",function(){e.$search.attr("tabindex",-1),e.$search.val("")}),c.on("focus",function(){c.isOpen()||e.$search.focus()}),c.on("results:all",function(a){if(null==a.query.term||""===a.query.term){e.showSearch(a)?e.$searchContainer.removeClass("select2-search--hide"):e.$searchContainer.addClass("select2-search--hide")}})},c.prototype.handleSearch=function(a){if(!this._keyUpPrevented){var b=this.$search.val();this.trigger("query",{term:b})}this._keyUpPrevented=!1},c.prototype.showSearch=function(a,b){return!0},c}),b.define("select2/dropdown/hidePlaceholder",[],function(){function a(a,b,c,d){this.placeholder=this.normalizePlaceholder(c.get("placeholder")),a.call(this,b,c,d)}return a.prototype.append=function(a,b){b.results=this.removePlaceholder(b.results),a.call(this,b)},a.prototype.normalizePlaceholder=function(a,b){return"string"==typeof b&&(b={id:"",text:b}),b},a.prototype.removePlaceholder=function(a,b){for(var c=b.slice(0),d=b.length-1;d>=0;d--){var e=b[d];this.placeholder.id===e.id&&c.splice(d,1)}return c},a}),b.define("select2/dropdown/infiniteScroll",["jquery"],function(a){function b(a,b,c,d){this.lastParams={},a.call(this,b,c,d),this.$loadingMore=this.createLoadingMore(),this.loading=!1}return b.prototype.append=function(a,b){this.$loadingMore.remove(),this.loading=!1,a.call(this,b),this.showLoadingMore(b)&&this.$results.append(this.$loadingMore)},b.prototype.bind=function(b,c,d){var e=this;b.call(this,c,d),c.on("query",function(a){e.lastParams=a,e.loading=!0}),c.on("query:append",function(a){e.lastParams=a,e.loading=!0}),this.$results.on("scroll",function(){var b=a.contains(document.documentElement,e.$loadingMore[0]);if(!e.loading&&b){e.$results.offset().top+e.$results.outerHeight(!1)+50>=e.$loadingMore.offset().top+e.$loadingMore.outerHeight(!1)&&e.loadMore()}})},b.prototype.loadMore=function(){this.loading=!0;var b=a.extend({},{page:1},this.lastParams);b.page++,this.trigger("query:append",b)},b.prototype.showLoadingMore=function(a,b){return b.pagination&&b.pagination.more},b.prototype.createLoadingMore=function(){var b=a('<li class="select2-results__option select2-results__option--load-more"role="treeitem" aria-disabled="true"></li>'),c=this.options.get("translations").get("loadingMore");return b.html(c(this.lastParams)),b},b}),b.define("select2/dropdown/attachBody",["jquery","../utils"],function(a,b){function c(b,c,d){this.$dropdownParent=d.get("dropdownParent")||a(document.body),b.call(this,c,d)}return c.prototype.bind=function(a,b,c){var d=this,e=!1;a.call(this,b,c),b.on("open",function(){d._showDropdown(),d._attachPositioningHandler(b),e||(e=!0,b.on("results:all",function(){d._positionDropdown(),d._resizeDropdown()}),b.on("results:append",function(){d._positionDropdown(),d._resizeDropdown()}))}),b.on("close",function(){d._hideDropdown(),d._detachPositioningHandler(b)}),this.$dropdownContainer.on("mousedown",function(a){a.stopPropagation()})},c.prototype.destroy=function(a){a.call(this),this.$dropdownContainer.remove()},c.prototype.position=function(a,b,c){b.attr("class",c.attr("class")),b.removeClass("select2"),b.addClass("select2-container--open"),b.css({position:"absolute",top:-999999}),this.$container=c},c.prototype.render=function(b){var c=a("<span></span>"),d=b.call(this);return c.append(d),this.$dropdownContainer=c,c},c.prototype._hideDropdown=function(a){this.$dropdownContainer.detach()},c.prototype._attachPositioningHandler=function(c,d){var e=this,f="scroll.select2."+d.id,g="resize.select2."+d.id,h="orientationchange.select2."+d.id,i=this.$container.parents().filter(b.hasScroll);i.each(function(){a(this).data("select2-scroll-position",{x:a(this).scrollLeft(),y:a(this).scrollTop()})}),i.on(f,function(b){var c=a(this).data("select2-scroll-position");a(this).scrollTop(c.y)}),a(window).on(f+" "+g+" "+h,function(a){e._positionDropdown(),e._resizeDropdown()})},c.prototype._detachPositioningHandler=function(c,d){var e="scroll.select2."+d.id,f="resize.select2."+d.id,g="orientationchange.select2."+d.id;this.$container.parents().filter(b.hasScroll).off(e),a(window).off(e+" "+f+" "+g)},c.prototype._positionDropdown=function(){var b=a(window),c=this.$dropdown.hasClass("select2-dropdown--above"),d=this.$dropdown.hasClass("select2-dropdown--below"),e=null,f=this.$container.offset();f.bottom=f.top+this.$container.outerHeight(!1);var g={height:this.$container.outerHeight(!1)};g.top=f.top,g.bottom=f.top+g.height;var h={height:this.$dropdown.outerHeight(!1)},i={top:b.scrollTop(),bottom:b.scrollTop()+b.height()},j=i.top<f.top-h.height,k=i.bottom>f.bottom+h.height,l={left:f.left,top:g.bottom},m=this.$dropdownParent;"static"===m.css("position")&&(m=m.offsetParent());var n=m.offset();l.top-=n.top,l.left-=n.left,c||d||(e="below"),k||!j||c?!j&&k&&c&&(e="below"):e="above",("above"==e||c&&"below"!==e)&&(l.top=g.top-n.top-h.height),null!=e&&(this.$dropdown.removeClass("select2-dropdown--below select2-dropdown--above").addClass("select2-dropdown--"+e),this.$container.removeClass("select2-container--below select2-container--above").addClass("select2-container--"+e)),this.$dropdownContainer.css(l)},c.prototype._resizeDropdown=function(){var a={width:this.$container.outerWidth(!1)+"px"};this.options.get("dropdownAutoWidth")&&(a.minWidth=a.width,a.position="relative",a.width="auto"),this.$dropdown.css(a)},c.prototype._showDropdown=function(a){this.$dropdownContainer.appendTo(this.$dropdownParent),this._positionDropdown(),this._resizeDropdown()},c}),b.define("select2/dropdown/minimumResultsForSearch",[],function(){function a(b){for(var c=0,d=0;d<b.length;d++){var e=b[d];e.children?c+=a(e.children):c++}return c}function b(a,b,c,d){this.minimumResultsForSearch=c.get("minimumResultsForSearch"),this.minimumResultsForSearch<0&&(this.minimumResultsForSearch=1/0),a.call(this,b,c,d)}return b.prototype.showSearch=function(b,c){return!(a(c.data.results)<this.minimumResultsForSearch)&&b.call(this,c)},b}),b.define("select2/dropdown/selectOnClose",[],function(){function a(){}return a.prototype.bind=function(a,b,c){var d=this;a.call(this,b,c),b.on("close",function(a){d._handleSelectOnClose(a)})},a.prototype._handleSelectOnClose=function(a,b){if(b&&null!=b.originalSelect2Event){var c=b.originalSelect2Event;if("select"===c._type||"unselect"===c._type)return}var d=this.getHighlightedResults();if(!(d.length<1)){var e=d.data("data");null!=e.element&&e.element.selected||null==e.element&&e.selected||this.trigger("select",{data:e})}},a}),b.define("select2/dropdown/closeOnSelect",[],function(){function a(){}return a.prototype.bind=function(a,b,c){var d=this;a.call(this,b,c),b.on("select",function(a){d._selectTriggered(a)}),b.on("unselect",function(a){d._selectTriggered(a)})},a.prototype._selectTriggered=function(a,b){var c=b.originalEvent;c&&c.ctrlKey||this.trigger("close",{originalEvent:c,originalSelect2Event:b})},a}),b.define("select2/i18n/en",[],function(){return{errorLoading:function(){return"The results could not be loaded."},inputTooLong:function(a){var b=a.input.length-a.maximum,c="Please delete "+b+" character";return 1!=b&&(c+="s"),c},inputTooShort:function(a){return"Please enter "+(a.minimum-a.input.length)+" or more characters"},loadingMore:function(){return"Loading more results…"},maximumSelected:function(a){var b="You can only select "+a.maximum+" item";return 1!=a.maximum&&(b+="s"),b},noResults:function(){return"No results found"},searching:function(){return"Searching…"}}}),b.define("select2/defaults",["jquery","require","./results","./selection/single","./selection/multiple","./selection/placeholder","./selection/allowClear","./selection/search","./selection/eventRelay","./utils","./translation","./diacritics","./data/select","./data/array","./data/ajax","./data/tags","./data/tokenizer","./data/minimumInputLength","./data/maximumInputLength","./data/maximumSelectionLength","./dropdown","./dropdown/search","./dropdown/hidePlaceholder","./dropdown/infiniteScroll","./dropdown/attachBody","./dropdown/minimumResultsForSearch","./dropdown/selectOnClose","./dropdown/closeOnSelect","./i18n/en"],function(a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,A,B,C){function D(){this.reset()}return D.prototype.apply=function(l){if(l=a.extend(!0,{},this.defaults,l),null==l.dataAdapter){if(null!=l.ajax?l.dataAdapter=o:null!=l.data?l.dataAdapter=n:l.dataAdapter=m,l.minimumInputLength>0&&(l.dataAdapter=j.Decorate(l.dataAdapter,r)),l.maximumInputLength>0&&(l.dataAdapter=j.Decorate(l.dataAdapter,s)),l.maximumSelectionLength>0&&(l.dataAdapter=j.Decorate(l.dataAdapter,t)),l.tags&&(l.dataAdapter=j.Decorate(l.dataAdapter,p)),null==l.tokenSeparators&&null==l.tokenizer||(l.dataAdapter=j.Decorate(l.dataAdapter,q)),null!=l.query){var C=b(l.amdBase+"compat/query");l.dataAdapter=j.Decorate(l.dataAdapter,C)}if(null!=l.initSelection){var D=b(l.amdBase+"compat/initSelection");l.dataAdapter=j.Decorate(l.dataAdapter,D)}}if(null==l.resultsAdapter&&(l.resultsAdapter=c,null!=l.ajax&&(l.resultsAdapter=j.Decorate(l.resultsAdapter,x)),null!=l.placeholder&&(l.resultsAdapter=j.Decorate(l.resultsAdapter,w)),l.selectOnClose&&(l.resultsAdapter=j.Decorate(l.resultsAdapter,A))),null==l.dropdownAdapter){if(l.multiple)l.dropdownAdapter=u;else{var E=j.Decorate(u,v);l.dropdownAdapter=E}if(0!==l.minimumResultsForSearch&&(l.dropdownAdapter=j.Decorate(l.dropdownAdapter,z)),l.closeOnSelect&&(l.dropdownAdapter=j.Decorate(l.dropdownAdapter,B)),null!=l.dropdownCssClass||null!=l.dropdownCss||null!=l.adaptDropdownCssClass){var F=b(l.amdBase+"compat/dropdownCss");l.dropdownAdapter=j.Decorate(l.dropdownAdapter,F)}l.dropdownAdapter=j.Decorate(l.dropdownAdapter,y)}if(null==l.selectionAdapter){if(l.multiple?l.selectionAdapter=e:l.selectionAdapter=d,null!=l.placeholder&&(l.selectionAdapter=j.Decorate(l.selectionAdapter,f)),l.allowClear&&(l.selectionAdapter=j.Decorate(l.selectionAdapter,g)),l.multiple&&(l.selectionAdapter=j.Decorate(l.selectionAdapter,h)),null!=l.containerCssClass||null!=l.containerCss||null!=l.adaptContainerCssClass){var G=b(l.amdBase+"compat/containerCss");l.selectionAdapter=j.Decorate(l.selectionAdapter,G)}l.selectionAdapter=j.Decorate(l.selectionAdapter,i)}if("string"==typeof l.language)if(l.language.indexOf("-")>0){var H=l.language.split("-"),I=H[0];l.language=[l.language,I]}else l.language=[l.language];if(a.isArray(l.language)){var J=new k;l.language.push("en");for(var K=l.language,L=0;L<K.length;L++){var M=K[L],N={};try{N=k.loadPath(M)}catch(a){try{M=this.defaults.amdLanguageBase+M,N=k.loadPath(M)}catch(a){l.debug&&window.console&&console.warn&&console.warn('Select2: The language file for "'+M+'" could not be automatically loaded. A fallback will be used instead.');continue}}J.extend(N)}l.translations=J}else{var O=k.loadPath(this.defaults.amdLanguageBase+"en"),P=new k(l.language);P.extend(O),l.translations=P}return l},D.prototype.reset=function(){function b(a){function b(a){return l[a]||a}return a.replace(/[^\u0000-\u007E]/g,b)}function c(d,e){if(""===a.trim(d.term))return e;if(e.children&&e.children.length>0){for(var f=a.extend(!0,{},e),g=e.children.length-1;g>=0;g--){null==c(d,e.children[g])&&f.children.splice(g,1)}return f.children.length>0?f:c(d,f)}var h=b(e.text).toUpperCase(),i=b(d.term).toUpperCase();return h.indexOf(i)>-1?e:null}this.defaults={amdBase:"./",amdLanguageBase:"./i18n/",closeOnSelect:!0,debug:!1,dropdownAutoWidth:!1,escapeMarkup:j.escapeMarkup,language:C,matcher:c,minimumInputLength:0,maximumInputLength:0,maximumSelectionLength:0,minimumResultsForSearch:0,selectOnClose:!1,sorter:function(a){return a},templateResult:function(a){return a.text},templateSelection:function(a){return a.text},theme:"default",width:"resolve"}},D.prototype.set=function(b,c){var d=a.camelCase(b),e={};e[d]=c;var f=j._convertData(e);a.extend(this.defaults,f)},new D}),b.define("select2/options",["require","jquery","./defaults","./utils"],function(a,b,c,d){function e(b,e){if(this.options=b,null!=e&&this.fromElement(e),this.options=c.apply(this.options),e&&e.is("input")){var f=a(this.get("amdBase")+"compat/inputData");this.options.dataAdapter=d.Decorate(this.options.dataAdapter,f)}}return e.prototype.fromElement=function(a){var c=["select2"];null==this.options.multiple&&(this.options.multiple=a.prop("multiple")),null==this.options.disabled&&(this.options.disabled=a.prop("disabled")),null==this.options.language&&(a.prop("lang")?this.options.language=a.prop("lang").toLowerCase():a.closest("[lang]").prop("lang")&&(this.options.language=a.closest("[lang]").prop("lang"))),null==this.options.dir&&(a.prop("dir")?this.options.dir=a.prop("dir"):a.closest("[dir]").prop("dir")?this.options.dir=a.closest("[dir]").prop("dir"):this.options.dir="ltr"),a.prop("disabled",this.options.disabled),a.prop("multiple",this.options.multiple),a.data("select2Tags")&&(this.options.debug&&window.console&&console.warn&&console.warn('Select2: The `data-select2-tags` attribute has been changed to use the `data-data` and `data-tags="true"` attributes and will be removed in future versions of Select2.'),a.data("data",a.data("select2Tags")),a.data("tags",!0)),a.data("ajaxUrl")&&(this.options.debug&&window.console&&console.warn&&console.warn("Select2: The `data-ajax-url` attribute has been changed to `data-ajax--url` and support for the old attribute will be removed in future versions of Select2."),a.attr("ajax--url",a.data("ajaxUrl")),a.data("ajax--url",a.data("ajaxUrl")));var e={};e=b.fn.jquery&&"1."==b.fn.jquery.substr(0,2)&&a[0].dataset?b.extend(!0,{},a[0].dataset,a.data()):a.data();var f=b.extend(!0,{},e);f=d._convertData(f);for(var g in f)b.inArray(g,c)>-1||(b.isPlainObject(this.options[g])?b.extend(this.options[g],f[g]):this.options[g]=f[g]);return this},e.prototype.get=function(a){return this.options[a]},e.prototype.set=function(a,b){this.options[a]=b},e}),b.define("select2/core",["jquery","./options","./utils","./keys"],function(a,b,c,d){var e=function(a,c){null!=a.data("select2")&&a.data("select2").destroy(),this.$element=a,this.id=this._generateId(a),c=c||{},this.options=new b(c,a),e.__super__.constructor.call(this);var d=a.attr("tabindex")||0;a.data("old-tabindex",d),a.attr("tabindex","-1");var f=this.options.get("dataAdapter");this.dataAdapter=new f(a,this.options);var g=this.render();this._placeContainer(g);var h=this.options.get("selectionAdapter");this.selection=new h(a,this.options),this.$selection=this.selection.render(),this.selection.position(this.$selection,g);var i=this.options.get("dropdownAdapter");this.dropdown=new i(a,this.options),this.$dropdown=this.dropdown.render(),this.dropdown.position(this.$dropdown,g);var j=this.options.get("resultsAdapter");this.results=new j(a,this.options,this.dataAdapter),this.$results=this.results.render(),this.results.position(this.$results,this.$dropdown);var k=this;this._bindAdapters(),this._registerDomEvents(),this._registerDataEvents(),this._registerSelectionEvents(),this._registerDropdownEvents(),this._registerResultsEvents(),this._registerEvents(),this.dataAdapter.current(function(a){k.trigger("selection:update",{data:a})}),a.addClass("select2-hidden-accessible"),a.attr("aria-hidden","true"),this._syncAttributes(),a.data("select2",this)};return c.Extend(e,c.Observable),e.prototype._generateId=function(a){var b="";return b=null!=a.attr("id")?a.attr("id"):null!=a.attr("name")?a.attr("name")+"-"+c.generateChars(2):c.generateChars(4),b=b.replace(/(:|\.|\[|\]|,)/g,""),b="select2-"+b},e.prototype._placeContainer=function(a){a.insertAfter(this.$element);var b=this._resolveWidth(this.$element,this.options.get("width"));null!=b&&a.css("width",b)},e.prototype._resolveWidth=function(a,b){var c=/^width:(([-+]?([0-9]*\.)?[0-9]+)(px|em|ex|%|in|cm|mm|pt|pc))/i;if("resolve"==b){var d=this._resolveWidth(a,"style");return null!=d?d:this._resolveWidth(a,"element")}if("element"==b){var e=a.outerWidth(!1);return e<=0?"auto":e+"px"}if("style"==b){var f=a.attr("style");if("string"!=typeof f)return null;for(var g=f.split(";"),h=0,i=g.length;h<i;h+=1){var j=g[h].replace(/\s/g,""),k=j.match(c);if(null!==k&&k.length>=1)return k[1]}return null}return b},e.prototype._bindAdapters=function(){this.dataAdapter.bind(this,this.$container),this.selection.bind(this,this.$container),this.dropdown.bind(this,this.$container),this.results.bind(this,this.$container)},e.prototype._registerDomEvents=function(){var b=this;this.$element.on("change.select2",function(){b.dataAdapter.current(function(a){b.trigger("selection:update",{data:a})})}),this.$element.on("focus.select2",function(a){b.trigger("focus",a)}),this._syncA=c.bind(this._syncAttributes,this),this._syncS=c.bind(this._syncSubtree,this),this.$element[0].attachEvent&&this.$element[0].attachEvent("onpropertychange",this._syncA);var d=window.MutationObserver||window.WebKitMutationObserver||window.MozMutationObserver;null!=d?(this._observer=new d(function(c){a.each(c,b._syncA),a.each(c,b._syncS)}),this._observer.observe(this.$element[0],{attributes:!0,childList:!0,subtree:!1})):this.$element[0].addEventListener&&(this.$element[0].addEventListener("DOMAttrModified",b._syncA,!1),this.$element[0].addEventListener("DOMNodeInserted",b._syncS,!1),this.$element[0].addEventListener("DOMNodeRemoved",b._syncS,!1))},e.prototype._registerDataEvents=function(){var a=this;this.dataAdapter.on("*",function(b,c){a.trigger(b,c)})},e.prototype._registerSelectionEvents=function(){var b=this,c=["toggle","focus"];this.selection.on("toggle",function(){b.toggleDropdown()}),this.selection.on("focus",function(a){b.focus(a)}),this.selection.on("*",function(d,e){-1===a.inArray(d,c)&&b.trigger(d,e)})},e.prototype._registerDropdownEvents=function(){var a=this;this.dropdown.on("*",function(b,c){a.trigger(b,c)})},e.prototype._registerResultsEvents=function(){var a=this;this.results.on("*",function(b,c){a.trigger(b,c)})},e.prototype._registerEvents=function(){var a=this;this.on("open",function(){a.$container.addClass("select2-container--open")}),this.on("close",function(){a.$container.removeClass("select2-container--open")}),this.on("enable",function(){a.$container.removeClass("select2-container--disabled")}),this.on("disable",function(){a.$container.addClass("select2-container--disabled")}),this.on("blur",function(){a.$container.removeClass("select2-container--focus")}),this.on("query",function(b){a.isOpen()||a.trigger("open",{}),this.dataAdapter.query(b,function(c){a.trigger("results:all",{data:c,query:b})})}),this.on("query:append",function(b){this.dataAdapter.query(b,function(c){a.trigger("results:append",{data:c,query:b})})}),this.on("keypress",function(b){var c=b.which;a.isOpen()?c===d.ESC||c===d.TAB||c===d.UP&&b.altKey?(a.close(),b.preventDefault()):c===d.ENTER?(a.trigger("results:select",{}),b.preventDefault()):c===d.SPACE&&b.ctrlKey?(a.trigger("results:toggle",{}),b.preventDefault()):c===d.UP?(a.trigger("results:previous",{}),b.preventDefault()):c===d.DOWN&&(a.trigger("results:next",{}),b.preventDefault()):(c===d.ENTER||c===d.SPACE||c===d.DOWN&&b.altKey)&&(a.open(),b.preventDefault())})},e.prototype._syncAttributes=function(){this.options.set("disabled",this.$element.prop("disabled")),this.options.get("disabled")?(this.isOpen()&&this.close(),this.trigger("disable",{})):this.trigger("enable",{})},e.prototype._syncSubtree=function(a,b){var c=!1,d=this;if(!a||!a.target||"OPTION"===a.target.nodeName||"OPTGROUP"===a.target.nodeName){if(b)if(b.addedNodes&&b.addedNodes.length>0)for(var e=0;e<b.addedNodes.length;e++){var f=b.addedNodes[e];f.selected&&(c=!0)}else b.removedNodes&&b.removedNodes.length>0&&(c=!0);else c=!0;c&&this.dataAdapter.current(function(a){d.trigger("selection:update",{data:a})})}},e.prototype.trigger=function(a,b){var c=e.__super__.trigger,d={open:"opening",close:"closing",select:"selecting",unselect:"unselecting"};if(void 0===b&&(b={}),a in d){var f=d[a],g={prevented:!1,name:a,args:b};if(c.call(this,f,g),g.prevented)return void(b.prevented=!0)}c.call(this,a,b)},e.prototype.toggleDropdown=function(){this.options.get("disabled")||(this.isOpen()?this.close():this.open())},e.prototype.open=function(){this.isOpen()||this.trigger("query",{})},e.prototype.close=function(){this.isOpen()&&this.trigger("close",{})},e.prototype.isOpen=function(){return this.$container.hasClass("select2-container--open")},e.prototype.hasFocus=function(){return this.$container.hasClass("select2-container--focus")},e.prototype.focus=function(a){this.hasFocus()||(this.$container.addClass("select2-container--focus"),this.trigger("focus",{}))},e.prototype.enable=function(a){this.options.get("debug")&&window.console&&console.warn&&console.warn('Select2: The `select2("enable")` method has been deprecated and will be removed in later Select2 versions. Use $element.prop("disabled") instead.'),null!=a&&0!==a.length||(a=[!0]);var b=!a[0];this.$element.prop("disabled",b)},e.prototype.data=function(){this.options.get("debug")&&arguments.length>0&&window.console&&console.warn&&console.warn('Select2: Data can no longer be set using `select2("data")`. You should consider setting the value instead using `$element.val()`.');var a=[];return this.dataAdapter.current(function(b){a=b}),a},e.prototype.val=function(b){if(this.options.get("debug")&&window.console&&console.warn&&console.warn('Select2: The `select2("val")` method has been deprecated and will be removed in later Select2 versions. Use $element.val() instead.'),null==b||0===b.length)return this.$element.val();var c=b[0];a.isArray(c)&&(c=a.map(c,function(a){return a.toString()})),this.$element.val(c).trigger("change")},e.prototype.destroy=function(){this.$container.remove(),this.$element[0].detachEvent&&this.$element[0].detachEvent("onpropertychange",this._syncA),null!=this._observer?(this._observer.disconnect(),this._observer=null):this.$element[0].removeEventListener&&(this.$element[0].removeEventListener("DOMAttrModified",this._syncA,!1),this.$element[0].removeEventListener("DOMNodeInserted",this._syncS,!1),this.$element[0].removeEventListener("DOMNodeRemoved",this._syncS,!1)),this._syncA=null,this._syncS=null,this.$element.off(".select2"),this.$element.attr("tabindex",this.$element.data("old-tabindex")),this.$element.removeClass("select2-hidden-accessible"),this.$element.attr("aria-hidden","false"),this.$element.removeData("select2"),this.dataAdapter.destroy(),this.selection.destroy(),this.dropdown.destroy(),this.results.destroy(),this.dataAdapter=null,this.selection=null,this.dropdown=null,this.results=null},e.prototype.render=function(){var b=a('<span class="select2 select2-container"><span class="selection"></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>');return b.attr("dir",this.options.get("dir")),this.$container=b,this.$container.addClass("select2-container--"+this.options.get("theme")),b.data("element",this.$element),b},e}),b.define("jquery-mousewheel",["jquery"],function(a){return a}),b.define("jquery.select2",["jquery","jquery-mousewheel","./select2/core","./select2/defaults"],function(a,b,c,d){if(null==a.fn.select2){var e=["open","close","destroy"];a.fn.select2=function(b){if("object"==typeof(b=b||{}))return this.each(function(){var d=a.extend(!0,{},b);new c(a(this),d)}),this;if("string"==typeof b){var d,f=Array.prototype.slice.call(arguments,1);return this.each(function(){var c=a(this).data("select2");null==c&&window.console&&console.error&&console.error("The select2('"+b+"') method was called on an element that is not using Select2."),d=c[b].apply(c,f)}),a.inArray(b,e)>-1?this:d}throw new Error("Invalid arguments for Select2: "+b)}}return null==a.fn.select2.defaults&&(a.fn.select2.defaults=d),c}),{define:b.define,require:b.require}}(),c=b.require("jquery.select2");return a.fn.select2.amd=b,c});
/*
 * jQuery Countdown - v1.2.8
 * http://github.com/kemar/jquery.countdown
 * Licensed MIT
 */

(function ($, window, document, undefined) {

    "use strict";

    /*
     * .countDown()
     *
     * Description:
     *      Unobtrusive and easily skinable countdown jQuery plugin.
     *
     * Usage:
     *      $(element).countDown()
     *
     *      $(element) is a valid <time> or any other HTML tag containing a text representation of a date/time
     *      or duration remaining before a deadline expires.
     *      If $(element) is a <time> tag, the datetime attribute is checked first.
     *          <time datetime="2013-12-13T17:43:00">Friday, December 13th, 2013 5:43pm</time>
     *          <time>2012-12-08T14:30:00+0100</time>
     *          <time>PT01H01M15S</time>
     *          <h1>600 days, 3:59:12</h1>
     *
     *      The text representation of a date/time or duration can be:
     *      - a valid duration string:
     *          PT00M10S
     *          PT01H01M15S
     *          P2DT20H00M10S
     *      - a valid global date and time string with its timezone offset:
     *          2012-12-08T14:30:00.432+0100
     *          2012-12-08T05:30:00-0800
     *          2012-12-08T13:30Z
     *      - a valid time string:
     *          12:30
     *          12:30:39
     *          12:30:39.929
     *      - a human readable duration string:
     *          2h 0m
     *          4h 18m 3s
     *          24h00m59s
     *          600 jours, 3:59:12
     *          600 days, 3:59:12
     *      - the output of a JavaScript Date.parse() parsable string:
     *          Date.toDateString() => Sat Dec 20 2014
     *          Date.toGMTString()  => Sat, 20 Dec 2014 09:24:00 GMT
     *          Date.toUTCString()  => Sat, 20 Dec 2014 09:24:00 GMT
     *
     *      If $(element) is not a <time> tag, a new one is created and appended to $(element).
     *
     * Literature, resources and inspiration:
     *      JavaScript Date reference:
     *          https://developer.mozilla.org/docs/JavaScript/Reference/Global_Objects/Date
     *      About the <time> element:
     *          https://html.spec.whatwg.org/multipage/semantics.html#the-time-element
     *          http://www.w3.org/TR/html5/text-level-semantics.html#the-time-element
     *          http://wiki.whatwg.org/wiki/Time_element
     *      <time> history:
     *          http://www.brucelawson.co.uk/2012/best-of-time/
     *          http://www.webmonkey.com/2011/11/w3c-adds-time-element-back-to-html5/
     *      Formats:
     *          http://en.wikipedia.org/wiki/ISO_8601
     *      jQuery plugin syntax:
     *          https://github.com/jquery-boilerplate/jquery-patterns
     *          https://github.com/jquery-boilerplate/jquery-boilerplate/wiki/Extending-jQuery-Boilerplate
     *          http://frederictonug.net/jquery-plugin-development-with-the-jquery-boilerplate
     *
     * Example of generated HTML markup:
     *      <time class="countdown" datetime="P12DT05H16M22S">
     *          <span class="item item-dd">
     *              <span class="dd"></span>
     *              <span class="label label-dd">days</span>
     *          </span>
     *          <span class="separator separator-dd">,</span>
     *          <span class="item item-hh">
     *              <span class="hh-1"></span>
     *              <span class="hh-2"></span>
     *              <span class="label label-hh">hours</span>
     *          </span>
     *          <span class="separator">:</span>
     *          <span class="item item-mm">
     *              <span class="mm-1"></span>
     *              <span class="mm-2"></span>
     *              <span class="label label-mm">minutes</span>
     *          </span>
     *          <span class="separator">:</span>
     *          <span class="item item-ss">
     *              <span class="ss-1"></span>
     *              <span class="ss-2"></span>
     *              <span class="label label-ss">seconds</span>
     *          </span>
     *      </time>
     */

    var pluginName = 'countDown';

    var defaults = {
        css_class: 'countdown',
        always_show_days: false,
        with_labels: true,
        with_seconds: true,
        with_separators: false,
        with_dd_leading_zero: true,
        with_hh_leading_zero: true,
        with_mm_leading_zero: true,
        with_ss_leading_zero: true,
        label_dd: 'Дней',
        label_hh: 'Часов',
        label_mm: 'Минут',
        label_ss: 'Секунд',
        separator: ':',
        separator_days: ','
    };

    function CountDown(element, options) {
        this.element = $(element);
        this.options = $.extend({}, defaults, options);
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    $.extend(CountDown.prototype, {

        init: function () {
            if (this.element.children().length) {
                return;
            }
            if (this.element.attr('datetime')) {  // Try to parse the datetime attribute first.
                this.endDate = this.parseEndDate(this.element.attr('datetime'));
            }
            if (this.endDate === undefined) {  // Fallback on the text content.
                this.endDate = this.parseEndDate(this.element.text());
            }
            if (this.endDate === undefined) {  // Unable to parse a date.
                return;
            }
            if (this.element.is('time')) {
                this.timeElement = this.element;
            } else {
                this.timeElement = $('<time></time>');
                this.element.html(this.timeElement);
            }
            this.markup();
            this.setTimeoutDelay = this.sToMs(1);
            this.daysVisible = true;
            this.timeElement.on('time.elapsed', this.options.onTimeElapsed);
            this.timeElement.on('time.tick', this.options.onTick);
            this.doCountDown();
        },

        parseEndDate: function (str) {

            var d;

            d = this.parseDuration(str);
            if (d instanceof Date) {
                return d;
            }

            d = this.parseDateTime(str);
            if (d instanceof Date) {
                return d;
            }

            d = this.parseHumanReadableDuration(str);
            if (d instanceof Date) {
                return d;
            }

            // Try to parse a string representation of a date.
            // https://developer.mozilla.org/docs/Web/JavaScript/Reference/Global_Objects/Date/parse
            d = Date.parse(str);
            if (!isNaN(d)) {
                return new Date(d);
            }

        },

        // Convert a valid duration string representing a duration to a Date object.
        //
        // https://html.spec.whatwg.org/multipage/infrastructure.html#valid-duration-string
        // http://en.wikipedia.org/wiki/ISO_8601#Durations
        // i.e.: P2DT20H00M10S, PT01H01M15S, PT00M10S, P2D, P2DT20H00M10.55S
        //
        // RegExp:
        // /^
        //    P                     => duration designator (historically called "period")
        //    (?:(\d+)D)?           => (days) followed by the letter "D" (optional)
        //    T?                    => the letter "T" that precedes the time components of the representation (optional)
        //    (?:(\d+)H)?           => (hours) followed by the letter "H" (optional)
        //    (?:(\d+)M)?           => (minutes) followed by the letter "M" (optional)
        //    (
        //         ?:(\d+)          => (seconds) (optional)
        //         (?:\.(\d{1,3}))? => (milliseconds) full stop character (.) and fractional part of second (optional)
        //         S                => followed by the letter "S"
        //    )?
        // $/
        parseDuration: function (str) {
            var timeArray = str.match(/^P(?:(\d+)D)?T?(?:(\d+)H)?(?:(\d+)M)?(?:(\d+)(?:\.(\d{1,3}))?S)?$/);
            if (timeArray) {
                var d, dd, hh, mm, ss, ms;
                dd = timeArray[1] ? this.dToMs(timeArray[1]) : 0;
                hh = timeArray[2] ? this.hToMs(timeArray[2]) : 0;
                mm = timeArray[3] ? this.mToMs(timeArray[3]) : 0;
                ss = timeArray[4] ? this.sToMs(timeArray[4]) : 0;
                ms = timeArray[5] ? parseInt(timeArray[5], 10) : 0;
                d = new Date();
                d.setTime(d.getTime() + dd + hh + mm + ss + ms);
                return d;
            }
        },

        // Convert a valid global date and time string to a Date object.
        // https://html.spec.whatwg.org/multipage/infrastructure.html#valid-global-date-and-time-string
        //
        // 2012-12-08T13:30:39+0100
        //     => ["2012-12-08T13:30:39+0100", "2012", "12", "08", "13", "30", "39", undefined, "+0100"]
        // 2012-12-08T06:54-0800
        //     => ["2012-12-08T06:54-0800", "2012", "12", "08", "06", "54", undefined, undefined, "-0800"]
        // 2012-12-08 13:30Z
        //     => ["2012-12-08 13:30Z", "2012", "12", "08", "13", "30", undefined, undefined, "Z"]
        // 2013-12-08 06:54:39.929-10:30
        //     => ["2013-12-08 06:54:39.929-08:30", "2013", "12", "08", "06", "54", "39", "929", "-10:30"]
        //
        // RegExp:
        // ^
        //     (\d{4,})         => (year) (four or more ASCII digits)
        //     -                => hyphen-minus
        //     (\d{2})          => (month)
        //     -                => hyphen-minus
        //     (\d{2})          => (day)
        //     [T\s]            => T or space
        //     (\d{2})          => (hours)
        //     :                => colon
        //     (\d{2})          => (minutes)
        //     (?:\:(\d{2}))?   => colon and (seconds) (optional)
        //     (?:\.(\d{1,3}))? => full stop character (.) and fractional part of second (milliseconds) (optional)
        //     ([Z\+\-\:\d]+)?  => time-zone (offset) string (optional)
        // $
        parseDateTime: function (str) {
            var timeArray = str.match(
                /^(\d{4,})-(\d{2})-(\d{2})[T\s](\d{2}):(\d{2})(?:\:(\d{2}))?(?:\.(\d{1,3}))?([Z\+\-\:\d]+)?$/);
            if (timeArray) {

                // Convert UTC offset from string to milliseconds.
                // +01:00 => ["+01:00", "+", "01", "00"] => -360000
                // -08:00 => ["-08:00", "-", "08", "00"] => 28800000
                // +05:30 => ["+05:30", "+", "05", "30"] => -19800000
                var offset = timeArray[8] ? timeArray[8].match(/^([\+\-])?(\d{2}):?(\d{2})$/) : undefined;

                // Time difference between UTC and the given time zone in milliseconds.
                var utcOffset = 0;
                if (offset) {
                    utcOffset = this.hToMs(offset[2]) + this.mToMs(offset[3]);
                    utcOffset = (offset[1] === '-') ? utcOffset : -utcOffset;
                }

                var d, yy, mo, dd, hh, mm, ss, ms;
                yy = timeArray[1];
                mo = timeArray[2] - 1;
                dd = timeArray[3];
                hh = timeArray[4] || 0;
                mm = timeArray[5] || 0;
                ss = timeArray[6] || 0;
                ms = timeArray[7] || 0;
                d = new Date(Date.UTC(yy, mo, dd, hh, mm, ss, ms));

                d.setTime(d.getTime() + utcOffset);

                return d;

            }
        },

        // Convert a string representing a human readable duration to a Date object.
        // Hours and minutes are mandatory.
        //
        // 600 days, 3:59:12 => ["600 days, 3:59:12", "600", "3", "59", "12", undefined]
        //           3:59:12 => ["3:59:12", undefined, "3", "59", "12", undefined]
        //             00:01 => ["00:01", undefined, "00", "01", undefined, undefined]
        //          00:00:59 => ["00:00:59", undefined, "00", "00", "59", undefined]
        //         240:00:59 => ["240:00:59", undefined, "240", "00", "59", undefined]
        //         4h 18m 3s => ["4h 18m 3s", undefined, "4", "18", "3", undefined]
        //     1d 0h 00m 59s => ["1d 0h 00m 59s", "1", "0", "00", "59", undefined]
        //             2h 0m => ["2h 0m", undefined, "2", "0", undefined, undefined]
        //         24h00m59s => ["24h00m59s", undefined, "24", "00", "59", undefined]
        //      12:30:39.929 => ["12:30:39.929", undefined, "12", "30", "39", "929"]
        //
        // RegExp:
        // /^
        //     (?:(\d+).+\s)?   => (days) followed by any character 0 or more times and a space (optional)
        //     (\d+)[h:]\s?     => (hours) followed by "h" or ":" and an optional space
        //     (\d+)[m:]?\s?    => (minutes) followed by "m" or ":" and an optional space
        //     (\d+)?[s]?       => (seconds) followed by an optional space (optional)
        //     (?:\.(\d{1,3}))? => (milliseconds) full stop character (.) and fractional part of second (optional)
        // $/
        parseHumanReadableDuration: function (str) {
            var timeArray = str.match(/^(?:(\d+).+\s)?(\d+)[h:]\s?(\d+)[m:]?\s?(\d+)?[s]?(?:\.(\d{1,3}))?$/);
            if (timeArray) {
                var d, dd, hh, mm, ss, ms;
                d = new Date();
                dd = timeArray[1] ? this.dToMs(timeArray[1]) : 0;
                hh = timeArray[2] ? this.hToMs(timeArray[2]) : 0;
                mm = timeArray[3] ? this.mToMs(timeArray[3]) : 0;
                ss = timeArray[4] ? this.sToMs(timeArray[4]) : 0;
                ms = timeArray[5] ? parseInt(timeArray[5], 10) : 0;
                d.setTime(d.getTime() + dd + hh + mm + ss + ms);
                return d;
            }
        },

        // Convert seconds to milliseconds.
        sToMs: function (s) {
            return parseInt(s, 10) * 1000;
        },

        // Convert minutes to milliseconds.
        mToMs: function (m) {
            return parseInt(m, 10) * 60 * 1000;
        },

        // Convert hours to milliseconds.
        hToMs: function (h) {
            return parseInt(h, 10) * 60 * 60 * 1000;
        },

        // Convert days to milliseconds.
        dToMs: function (d) {
            return parseInt(d, 10) * 24 * 60 * 60 * 1000;
        },

        // Extract seconds (0-59) from the given timedelta expressed in milliseconds.
        // A timedelta represents a duration, the difference between two dates or times.
        msToS: function (ms) {
            return parseInt((ms / 1000) % 60, 10);
        },

        // Extract minutes (0-59) from the given timedelta expressed in milliseconds.
        msToM: function (ms) {
            return parseInt((ms / 1000 / 60) % 60, 10);
        },

        // Extract hours (0-23) from the given timedelta expressed in milliseconds.
        msToH: function (ms) {
            return parseInt((ms / 1000 / 60 / 60) % 24, 10);
        },

        // Extract the number of days from the given timedelta expressed in milliseconds.
        msToD: function (ms) {
            return parseInt((ms / 1000 / 60 / 60 / 24), 10);
        },

        markup: function () {
            // Prepare the HTML content of the <time> element.
            var html = [
                '<div class="item item-dd">',
                '<div class="item-wrap">',
                '<div class="item-bg dd-1"></div>',
                '<div class="item-bg dd-2"></div>',
                '</div>',
                '<div class="label label-dd">', this.options.label_dd, '</div>',
                '</div>',
                // '<span class="separator separator-dd">', this.options.separator_days, '</span>',
                '<div class="item item-hh">',
                '<div class="item-wrap">',
                '<div class="item-bg hh-1"></div>',
                '<div class="item-bg hh-2"></div>',
                '</div>',
                '<div class="label label-hh">', this.options.label_hh, '</div>',
                '</div>',
                // '<span class="separator">', this.options.separator, '</span>',
                '<div class="item item-mm">',
                '<div class="item-wrap">',
                '<div class="item-bg mm-1"></div>',
                '<div class="item-bg mm-2"></div>',
                '</div>',
                '<div class="label label-mm">', this.options.label_mm, '</div>',
                '</div>',
                // '<span class="separator">', this.options.separator, '</span>',
                '<div class="item item-ss">',
                '<div class="item-wrap">',
                '<div class="item-bg ss-1"></div>',
                '<div class="item-bg ss-2"></div>',
                '</div>',
                '<div class="label label-ss">', this.options.label_ss, '</div>',
                '</div>'
            ];
            this.timeElement.html(html.join(''));
            // Customize HTML according to options.
            if (!this.options.with_labels) {
                this.timeElement.find('.label').remove();
            }
            if (!this.options.with_separators) {
                this.timeElement.find('.separator').remove();
            }
            if (!this.options.with_seconds) {
                this.timeElement.find('.item-ss').remove();
                this.timeElement.find('.separator').last().remove();
            }
            // Cache elements.
            this.item_dd       = this.timeElement.find('.item-dd');
            //this.separator_dd  = this.timeElement.find('.separator-dd');
            this.remaining_dd1  = this.timeElement.find('.dd-1');
            this.remaining_dd2  = this.timeElement.find('.dd-2');
            this.remaining_hh1 = this.timeElement.find('.hh-1');
            this.remaining_hh2 = this.timeElement.find('.hh-2');
            this.remaining_mm1 = this.timeElement.find('.mm-1');
            this.remaining_mm2 = this.timeElement.find('.mm-2');
            this.remaining_ss1 = this.timeElement.find('.ss-1');
            this.remaining_ss2 = this.timeElement.find('.ss-2');
            // Set the css class of the <time> element.
            this.timeElement.addClass(this.options.css_class);
        },

        doCountDown: function () {
            // Calculate the difference between the two dates in milliseconds.
            var ms = this.endDate.getTime() - new Date().getTime();
            // Extract seconds, minutes, hours and days from the timedelta expressed in milliseconds.
            var ss = this.msToS(ms);
            var mm = this.msToM(ms);
            var hh = this.msToH(ms);
            var dd = this.msToD(ms);
            // Prevent display of negative values.
            if (ms <= 0) {
                ss = mm = hh = dd = 0;
            }
            // Update display.
            // Use a space instead of 0 when no leading zero is required.
            this.displayRemainingTime({
                'ss': ss < 10 ? (this.options.with_ss_leading_zero ? '0' : ' ') + ss.toString() : ss.toString(),
                'mm': mm < 10 ? (this.options.with_mm_leading_zero ? '0' : ' ') + mm.toString() : mm.toString(),
                'hh': hh < 10 ? (this.options.with_hh_leading_zero ? '0' : ' ') + hh.toString() : hh.toString(),
                'dd': dd < 10 ? (this.options.with_dd_leading_zero ? '0' : ' ') + dd.toString() : dd.toString()
            });
            // If seconds are hidden, stop the counter as soon as there is no minute left.
            if (!this.options.with_seconds && dd === 0 && mm === 0 && hh === 0) {
                ss = 0;
            }
            if (dd === 0 && mm === 0 && hh === 0 && ss === 0) {
                return this.timeElement.trigger('time.elapsed');
            }
            // Reload it.
            var self = this;
            window.setTimeout(function () { self.doCountDown(); }, self.setTimeoutDelay);
            return this.timeElement.trigger('time.tick', ms);
        },

        /**
         * Display the remaining time.
         *
         * @param {Object} remaining - an object literal containing a string representation
         * of days, hours, minutes and seconds remaining.
         * E.g. with leading zeros:
         * { dd: "600", hh: "03", mm: "59", ss: "11" }
         * Or without leading zeros:
         * { dd: "600", hh: " 3", mm: " 9", ss: "11" }
         */
        displayRemainingTime: function (remaining) {
            // Format the datetime attribute of the <time> element to an ISO 8601 duration.
            // https://html.spec.whatwg.org/multipage/semantics.html#datetime-value
            // I.e.: <time datetime="P2DT00H00M30S">2 00:00:00</time>
            var attr = [];
            attr.push('P');
            if (remaining.dd !== '0') {
                attr.push(remaining.dd, 'D');
            }
            attr.push('T', remaining.hh, 'H', remaining.mm, 'M');
            if (this.options.with_seconds) {
                attr.push(remaining.ss, 'S');
            }
            this.timeElement.attr('datetime', attr.join(''));
            // Remove days if necessary.
            if (this.daysVisible && !this.options.always_show_days && remaining.dd === '0') {
                this.item_dd.remove();
                this.separator_dd.remove();
                this.daysVisible = false;
            }
            // Update countdown values.
            // Use `trim` to convert spaces to empty string when there are no leading zeros.
            this.remaining_dd1.text(remaining.dd[0].trim());
            this.remaining_dd2.text(remaining.dd[1]);
            this.remaining_hh1.text(remaining.hh[0].trim());
            this.remaining_hh2.text(remaining.hh[1]);
            this.remaining_mm1.text(remaining.mm[0].trim());
            this.remaining_mm2.text(remaining.mm[1]);
            this.remaining_ss1.text(remaining.ss[0].trim());
            this.remaining_ss2.text(remaining.ss[1]);
        }

    });

    $.fn[pluginName] = function (options) {

        var args = arguments;

        // If the first parameter is an object (options) or was omitted, instantiate a new plugin instance.
        if (options === undefined || typeof options === 'object') {
            return this.each(function () {
                if (!$.data(this, 'plugin_' + pluginName)) {
                    $.data(this, 'plugin_' + pluginName, new CountDown(this, options));
                }
            });
        }

        // Allow any public function (i.e. a function whose name isn't 'init' or doesn't start with an underscore)
        // to be called via the jQuery plugin, e.g. $(element).countDown('functionName', arg1, arg2).
        else if (typeof options === 'string' && options[0] !== '_' && options !== 'init') {

            // Cache the method call to make it possible to return a value.
            var returns;

            this.each(function () {
                var instance = $.data(this, 'plugin_' + pluginName);

                // Tests that there's already a plugin instance and checks that the requested public method exists.
                if (instance instanceof CountDown && typeof instance[options] === 'function') {
                    // Call the method of our plugin instance, and pass it the supplied arguments.
                    returns = instance[options].apply(instance, Array.prototype.slice.call(args, 1));
                }

                // Allow instances to be destroyed via the 'destroy' method.
                if (options === 'destroy') {
                    $.data(this, 'plugin_' + pluginName, null);
                }

            });

            // If the earlier cached method gives a value back return the value,
            // otherwise return this to preserve chainability.
            return returns !== undefined ? returns : this;

        }

    };

})(window.jQuery, window, document);
/**
 *     Блокировака прокрутки при открытии модалок
 **/

// блокируем прокрутку
function scrollLock() {
	var pagePosition = window.scrollY;
	// Если одна модалка открывает другую модалку, то не надо задавать все еще раз
	if ( document.body.classList.contains('scroll-lock') ) {
		return false;
	}

	document.body.classList.add('scroll-lock');
	document.body.dataset.position = pagePosition;
	document.body.style.top = -pagePosition + 'px';
	if ( window.innerWidth > 991) {
		document.body.style.paddingRight = '8px';
	}
}

// востанавливаем прокрутку
function scrollUnlock() {
	var pagePosition = document.body.dataset.position;
	document.body.style.top = '';
	document.body.style.paddingRight = '';
	document.body.classList.remove('scroll-lock');
	window.scroll({top: pagePosition, left: 0});
	document.body.removeAttribute('data-position');
}
const $body = $('body');
const IS_LOGGED = $body.data('login');

function notify(text, timeout = 4000) {
  const $close = $('<button></button>');
  const $message = $('<div class="pig-notify">' + text + '</div>');
  $message.append($close);

  $body.append($message);

  setTimeout(function () {
    $message.fadeOut(function () {
      $(this).remove();
    });
  }, timeout)

  $close.on('click', function () {
    $message.fadeOut(function () {
      $(this).remove();
    });
  });
}

function visiblePortionPayment(totalPrice) {
  const $option = $('input[value="3"]').closest('.js-payment-item');
  if (totalPrice <= 500 || totalPrice >= 50000) {
    $option.hide();
  } else {
    $option.show();
  }
}

const LANGUAGES = {
  'ru-RU': {
    'required': 'Необходимо заполнить',
    'wrong-confirm-code': 'Код указан не верно',
    'sms': 'СМС',
    'fav-added': 'Добавлено в список желаний',
    'fav-add': 'Добавить в список желаний',
    'reserve-thanks': 'Спасибо за резервирование заказа',
    'your-order': 'Ваш заказ',
    'awaits-you': 'будет дожидаться вас в магазине',
    'schedule': 'Режим работы',
    'hide-receiver-fields': 'Скрыть данные получателя',
    'specify-receiver-fields': 'Указать данные получателя',
    'choose-size': 'Выберите размер',
    'stock-watch-success': 'Вы успешно подписались на уведомления о наличии товара',
    'cancel-stock-sub': 'Отменить уведомление',
    'stock-sub': 'Сообщить о наличии',
    'search': 'Поиск',
    'up-to-5': 'До 5 мес',
    'copy-loc': 'Координаты скопированы',
  },
  'ua-UA': {
    'required': 'Нобхідно заповнити',
    'wrong-confirm-code': 'Код вказаний не вірно',
    'sms': 'СМС',
    'fav-added': 'Добавлено в список бажань',
    'fav-add': 'Добавити в список бажань',
    'reserve-thanks': 'Дякуємо за резервування замовлення',
    'your-order': 'Ваше замовлення',
    'awaits-you': 'буде чекати вас в магазині',
    'schedule': 'Режим роботи',
    'hide-receiver-fields': 'Сховати дані одержувача',
    'specify-receiver-fields': 'Вказати дані одержувача',
    'choose-size': 'Виберіть розмір',
    'stock-watch-success': 'Ви успішно підписались на сповіщення про наявність товару',
    'cancel-stock-sub': 'Відмінити повідомлення',
    'stock-sub': 'Повідомити про наявність',
    'search': 'Пошук',
    'up-to-5': 'До 5 міс',
    'copy-loc': 'Координати скопійовані',
  },
  'en-EN': {
    'required': 'This field is required',
    'wrong-confirm-code': 'Entered code is wrong',
    'sms': 'SMS',
    'fav-added': 'Added to wishlist',
    'fav-add': 'Add to wishlist',
    'reserve-thanks': 'Thank you for your reservation',
    'your-order': 'Your order',
    'awaits-you': 'awaits you at store',
    'schedule': 'Schedule',
    'hide-receiver-fields': 'Hide receiver details',
    'specify-receiver-fields': 'Specify receiver fields',
    'choose-size': 'Choose size',
    'stock-watch-success': 'You have successfully subscribed to the product stock notifications',
    'cancel-stock-sub': 'Cancel subscribe',
    'stock-sub': 'Inform about availability',
    'search': 'Search',
    'up-to-5': 'Up to 5 months',
    'copy-loc': 'Coordinates is copied',
  },
}

function _tr($tr_code) {
  return LANGUAGES[$('html').attr('lang')][$tr_code];
}

function currentLang() {
  return $('html').attr('lang').substring(0, 2);
}

function currencySign() {
  return $('html').attr('data-currency');
}

function windowOpen(url, width, height) {
  var leftPosition, topPosition;
  //Allow for borders.
  leftPosition = (window.screen.width / 2) - ((width / 2) + 10);
  //Allow for title and status bars.
  topPosition = (window.screen.height / 2) - ((height / 2) + 50);
  //Open the window.
  window.open(url, "Window2",
    "status=no,height=" + height + ",width=" + width + ",resizable=yes,left="
    + leftPosition + ",top=" + topPosition + ",screenX=" + leftPosition + ",screenY="
    + topPosition + ",toolbar=no,menubar=no,scrollbars=no,location=no,directories=no");
}

function initSizeSwitch() {
  const $items = $(this).find('.sizes-switch__item');
  $items.on('click', function () {
    if (!$(this).hasClass('sizes-switch__item--stock')) {
      return;
    }

    $items.removeClass('sizes-switch__item--active');
    $(this).addClass('sizes-switch__item--active');
  });
}


function openModal(target) {
  $('#overlay').fadeIn(200, function () {
    $(target).css('display', 'block').animate({opacity: 1}, 200);
  });
  scrollLock();
}

function closeModal(target) {
  $(target).animate({opacity: 0}, 200, function () {
      $(this).css('display', 'none');
      $('#overlay').fadeOut(400);
    }
  );
  scrollUnlock();
}

function initCarousel(elem) {
  $(elem).not('.slick-initialized').slick({
    slidesToShow: 4,
    sliderToScroll: 1,
    dots: false,
    prevArrow: '<button type="button" class="slick_prev"></button>',
    nextArrow: '<button type="button" class="slick_next"></button>',
    rows: 0,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 2,
        }
      }
    ]
  });
}

function isGiftSelected() {
  const $gifts = $('.product-gifts');

  if ($gifts.length) {
    if ($('.product-gifts__item.active').length === 0) {
      console.log('error');
      const $title = $gifts.find('.product-sizes__title');
      $('.gift-error').remove();
      $title.after('<div class="gift-error">' + $title.data('error') + '</div>');
      $('html, body').animate({scrollTop: $gifts.offset().top}, 300);
      return false;
    }
  }
  return true;
}

function formatPriceWithSpace(price) {
  return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
}

function showSpinnerOverlay(target) {
  $(target).append('<div class="spinner-overlay"><div class="spinner"></divc></div>');
}

function hideSpinnerOverlay(target) {
  $(target).find('.spinner-overlay').remove();
}

function extractNumberQty(string) {
  return string.split(' ')[0];
}

function updateStringQty(string, number) {
  return string.replace(/\d+/g, number);
}

function subscribeStockWatch(product_id, email, cb) {
  const lang = $('html').data('lang');
  const prefix = lang ? '/' + lang : '';
  const url = prefix + '/products/set-stock-watch';
  const data = {
    product_id: product_id,
    email: email
  }
  $.post(url, data, function (res) {
    closeModal('.modal--subscribe');
    notify(res.message);
    cb(res);
  }).fail(function (err) {
    console.log(err);
  });
}


// обрезать текст отзыва
function addMoreBtnToComments() {
  const block = $('.product-reviews');

  if (block.hasClass('short-comments')) {
    return;
  }
  block.addClass('short-comments');

  $('.product-reviews__comments').each(function () {
    const comment = $(this);
    const moreButton = $('<button class="js-comment-more"></button>');
    if (comment.outerHeight() > 60) {
      comment.after(moreButton)
    }

    moreButton.click(function () {
      comment.toggleClass('height-auto');
    });
  });
}
const isComparePage = $body.find('.p-compare').length;

if (isComparePage === 0) {
// lazy on document loaded
  slickLazyLoad();
// lazy on scroll
  $(window).on('scroll', slickLazyLoad);
}

function slickLazyLoad() {
  const scrollTop = $(this).scrollTop();
  const scrollBottom = scrollTop + $(this).height();

  $('.product-card__body').each(function () {
    const itemTop = $(this).offset().top;
    const colors = $(this).find('.product-card__color');
    if (!colors.length) {
      $(this).parents('.product-card').addClass('no-colors');
    }

    if (!$(this).hasClass('loaded') && scrollBottom >= itemTop) {
      initProductCardSlider($(this), 6);
      $(this).addClass('loaded');
    }
  });
}

function initProductCardSlider(element, colorCountSlider) {
  var sliderImg = element.find('.js-product-card-img-slider');
  var sliderColor = element.find('.js-product-card-color-slider');

  sliderImg.not('.slick-initialized').slick({
    arrows: false,
    fade: true,
    dots: false,
    slidesToShow: 1,
    slidesToScroll: 1,
    speed: 200,
    lazyLoad: 'ondemand',
    touchMove: false,
    swipe: false,
    draggable: false,
    asNavFor: sliderColor
  });

  sliderColor.not('.slick-initialized').slick({
    fade: false,
    prevArrow: '<span class="product-card__arrow product-card__arrow--left"><svg version="1.1" fill="#BBBBBB" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"\n' +
      '\t viewBox="0 0 256 256" style="enable-background:new 0 0 256 256;" xml:space="preserve">\n' +
      '\t\t<polygon points="207.093,30.187 176.907,0 48.907,128 176.907,256 207.093,225.813 109.28,128"/>\t\n' +
      '</svg></span>',
    nextArrow: '<span class="product-card__arrow product-card__arrow--right"><svg fill="#BBBBBB" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"\n' +
      '\t viewBox="0 0 256 256" style="enable-background:new 0 0 256 256;" xml:space="preserve">\n' +
      '\t\t<polygon points="79.093,0 48.907,30.187 146.72,128 48.907,225.813 79.093,256 207.093,128"/>\t\n' +
      '</svg></span>',
    dots: false,
    slidesToShow: colorCountSlider,
    slidesToScroll: 1,
    speed: 200,
    infinite: true,
    focusOnSelect: true,
    rows: 0,
    asNavFor: sliderImg,
    responsive: [
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 4
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 5
        }
      },
      {
        breakpoint: 450,
        settings: {
          slidesToShow: 3
        }
      },
    ]
  });

}

$(document).on('click', '.js-product-card-color', function () {
  /**
   *  Меняем картинку товара по клику на цвет товара
   * */
  var slider = $(this).closest('.js-product-card-color-slider').prev('.js-product-card-img-slider');
  slider.slick('slickGoTo', $(this).data('slickIndex'));

  let $productCard = $(this).closest('.product-card');

  /**
   *  Меняем ссылку у названия товара по клику на цвет товара
   * */
  var link = slider.find('.slick-active a').attr('href');
  var $titleLink = $productCard.find('.product-card__name-link');
  $titleLink.attr('href', link);

  /**
   *  меняем id товара в наименовании товара для добавления в избранное
   * */
  var $title = $productCard.find('.product-card__name');
  var id = $(this).find('img').attr('data-product-id');


  $title.attr('data-product-id', id);

  /**
   *  Смена название товара
   * */
  let currentProduct = $productCard.find('.slick-slide.slick-current .product-card__img-link');
  let nameProduct = currentProduct.attr('data-product-name');
  $title.find('.product-card__name-link').text(nameProduct);


  /**
   *  Смена стоимости
   */
  // меняем цену товара
  //let priceProduct = currentProduct.attr('data-product-price');
  //let oldPriceProduct = currentProduct.attr('data-product-old-price');
  //var priceProduct = 0;
  // var oldPriceProduct = 0;


  $.ajax({
    url: '/stock/price/current-price',
    method: 'post',
    data: {
      id: id
    },
    success: function (data) {
      let priceProduct = data['price'];
      let oldPriceProduct = data['oldPrice'];


      //Смена окончательной стоимости
      $productCard.find('.js-product-new-price').text(priceProduct);

      //Сменя стоимости до скидки
      if (oldPriceProduct === 0) {
        $productCard.find('.product-card__price--old').fadeOut(0);
        $productCard.find('.js-product-old-price').text(oldPriceProduct);
      } else {
        $productCard.find('.product-card__price--old').fadeIn(0);
        $productCard.find('.js-product-old-price').text(oldPriceProduct);
      }

    }
  });


  // //Смена окончательной стоимости
  // $productCard.find('.js-product-new-price').text(priceProduct);
  //
  // //Сменя стоимости до скидки
  // if (oldPriceProduct === "0") {
  //   $productCard.find('.product-card__price--old').fadeOut(0);
  //   $productCard.find('.js-product-old-price').text(oldPriceProduct);
  // } else {
  //   $productCard.find('.product-card__price--old').fadeIn(0);
  //   $productCard.find('.js-product-old-price').text(oldPriceProduct);
  // }

  /**
   *  Смена лейб
   * */
  setLabel();

  function setLabel() {
    // тут лежит JSON
    let productLabelJson = currentProduct.attr('data-product-label');

    const isSubscribed = currentProduct.attr('data-stock-subscribe');
    const $cartButton = $productCard.find('.js-open-modal-size')
    const $subscribeButton = $productCard.find('.js-open-stock-subscribe')
    let wrapLabel = $productCard.find('.js-product-card-labels');
    wrapLabel.empty();
    $cartButton.show();
    $subscribeButton
      .attr('data-product_id', id)
      .removeClass('active')
      .hide();

    if (+isSubscribed) {
      $subscribeButton.addClass('active');
    }

    if (!productLabelJson) return false;

    let productLabelArr = JSON.parse(productLabelJson);

    wrapLabel.empty();

    for (let i = 0; i < productLabelArr.length; i++) {
      let html;

      if (productLabelArr[i].label === "sale") {
        html = `<span class="product-card__label background_sale">${productLabelArr[i].name}</span>`;
      } else if (productLabelArr[i].label === "new") {
        html = `<span class="product-card__label background_new">${productLabelArr[i].name}</span>`;
      } else if (productLabelArr[i].label === "stock_shares") {
        html = `<span class="product-card__label background_stock_shares">${productLabelArr[i].name}</span>`;
      } else if (productLabelArr[i].label === "hit") {
        html = `<span class="product-card__label background_hit">${productLabelArr[i].name}</span>`;
      } else if (productLabelArr[i].label === "recommend") {
        html = `<span class="product-card__label background_recommend">${productLabelArr[i].name}</span>`;
      } else if (productLabelArr[i].label === "not_available") {
        $cartButton.hide();
        $subscribeButton.show();
        html = `<span class="product-card__label background_not_available">${productLabelArr[i].name}</span>`;
      }

      wrapLabel.prepend(html);
    }
  }
});

function compProductCardSlider() {
  var $productItem = $(document).find('.p-compare-slider-col');
  $productItem.each(function () {
    var _self = $(this);
    var $colorsParent = _self.find('.js-compare-height-colors');
    var slider = _self.find('.js-product-card-img-slider');

    $('.p-compare-slider').on('setPosition', function () {
      $colorsParent.on('click', '.product-colors__item', function (e) {
        _self.find('.product-colors__item').removeClass('_active');
        $(this).addClass('_active');
        // Меняем картинку товара по клику на цвет товара
        slider.slick('slickGoTo', $(this).index());

        // Меняем ссылку у названия товара по клику на цвет товара
        var link = slider.find('.slick-active a').attr('href');
        var $titleLink = _self.find('.product-card__name-link');
        $titleLink.attr('href', link);

        // меняем название товара
        let currentProduct = _self.find('.slick-slide.slick-current .product-card__img-link');
        let nameProduct = currentProduct.attr('data-product-name');
        _self.find('.product-card__name-link').text(nameProduct);

        // меняем цену товара
        let priceProduct = currentProduct.attr('data-product-price');
        let oldPriceProduct = currentProduct.attr('data-product-old-price');

        //Смена окончательной стоимости
        _self.find('.js-product-new-price').text(priceProduct);

        //Смена стоимости до скидки
        if (oldPriceProduct === "0") {
          _self.find('.product-card__price--old').fadeOut(0);
          _self.find('.js-product-old-price').text(oldPriceProduct);
        } else {
          _self.find('.product-card__price--old').fadeIn(0);
          _self.find('.js-product-old-price').text(oldPriceProduct);
        }
      });
    })
  });
}

compProductCardSlider()
/*! Magnific Popup - v1.1.0 - 2016-02-20
* http://dimsemenov.com/plugins/magnific-popup/
* Copyright (c) 2016 Dmitry Semenov; */
;(function (factory) { 
if (typeof define === 'function' && define.amd) { 
 // AMD. Register as an anonymous module. 
 define(['jquery'], factory); 
 } else if (typeof exports === 'object') { 
 // Node/CommonJS 
 factory(require('jquery')); 
 } else { 
 // Browser globals 
 factory(window.jQuery || window.Zepto); 
 } 
 }(function($) { 

/*>>core*/
/**
 * 
 * Magnific Popup Core JS file
 * 
 */


/**
 * Private static constants
 */
var CLOSE_EVENT = 'Close',
	BEFORE_CLOSE_EVENT = 'BeforeClose',
	AFTER_CLOSE_EVENT = 'AfterClose',
	BEFORE_APPEND_EVENT = 'BeforeAppend',
	MARKUP_PARSE_EVENT = 'MarkupParse',
	OPEN_EVENT = 'Open',
	CHANGE_EVENT = 'Change',
	NS = 'mfp',
	EVENT_NS = '.' + NS,
	READY_CLASS = 'mfp-ready',
	REMOVING_CLASS = 'mfp-removing',
	PREVENT_CLOSE_CLASS = 'mfp-prevent-close';


/**
 * Private vars 
 */
/*jshint -W079 */
var mfp, // As we have only one instance of MagnificPopup object, we define it locally to not to use 'this'
	MagnificPopup = function(){},
	_isJQ = !!(window.jQuery),
	_prevStatus,
	_window = $(window),
	_document,
	_prevContentType,
	_wrapClasses,
	_currPopupType;


/**
 * Private functions
 */
var _mfpOn = function(name, f) {
		mfp.ev.on(NS + name + EVENT_NS, f);
	},
	_getEl = function(className, appendTo, html, raw) {
		var el = document.createElement('div');
		el.className = 'mfp-'+className;
		if(html) {
			el.innerHTML = html;
		}
		if(!raw) {
			el = $(el);
			if(appendTo) {
				el.appendTo(appendTo);
			}
		} else if(appendTo) {
			appendTo.appendChild(el);
		}
		return el;
	},
	_mfpTrigger = function(e, data) {
		mfp.ev.triggerHandler(NS + e, data);

		if(mfp.st.callbacks) {
			// converts "mfpEventName" to "eventName" callback and triggers it if it's present
			e = e.charAt(0).toLowerCase() + e.slice(1);
			if(mfp.st.callbacks[e]) {
				mfp.st.callbacks[e].apply(mfp, $.isArray(data) ? data : [data]);
			}
		}
	},
	_getCloseBtn = function(type) {
		if(type !== _currPopupType || !mfp.currTemplate.closeBtn) {
			mfp.currTemplate.closeBtn = $( mfp.st.closeMarkup.replace('%title%', mfp.st.tClose ) );
			_currPopupType = type;
		}
		return mfp.currTemplate.closeBtn;
	},
	// Initialize Magnific Popup only when called at least once
	_checkInstance = function() {
		if(!$.magnificPopup.instance) {
			/*jshint -W020 */
			mfp = new MagnificPopup();
			mfp.init();
			$.magnificPopup.instance = mfp;
		}
	},
	// CSS transition detection, http://stackoverflow.com/questions/7264899/detect-css-transitions-using-javascript-and-without-modernizr
	supportsTransitions = function() {
		var s = document.createElement('p').style, // 's' for style. better to create an element if body yet to exist
			v = ['ms','O','Moz','Webkit']; // 'v' for vendor

		if( s['transition'] !== undefined ) {
			return true; 
		}
			
		while( v.length ) {
			if( v.pop() + 'Transition' in s ) {
				return true;
			}
		}
				
		return false;
	};



/**
 * Public functions
 */
MagnificPopup.prototype = {

	constructor: MagnificPopup,

	/**
	 * Initializes Magnific Popup plugin. 
	 * This function is triggered only once when $.fn.magnificPopup or $.magnificPopup is executed
	 */
	init: function() {
		var appVersion = navigator.appVersion;
		mfp.isLowIE = mfp.isIE8 = document.all && !document.addEventListener;
		mfp.isAndroid = (/android/gi).test(appVersion);
		mfp.isIOS = (/iphone|ipad|ipod/gi).test(appVersion);
		mfp.supportsTransition = supportsTransitions();

		// We disable fixed positioned lightbox on devices that don't handle it nicely.
		// If you know a better way of detecting this - let me know.
		mfp.probablyMobile = (mfp.isAndroid || mfp.isIOS || /(Opera Mini)|Kindle|webOS|BlackBerry|(Opera Mobi)|(Windows Phone)|IEMobile/i.test(navigator.userAgent) );
		_document = $(document);

		mfp.popupsCache = {};
	},

	/**
	 * Opens popup
	 * @param  data [description]
	 */
	open: function(data) {

		var i;

		if(data.isObj === false) { 
			// convert jQuery collection to array to avoid conflicts later
			mfp.items = data.items.toArray();

			mfp.index = 0;
			var items = data.items,
				item;
			for(i = 0; i < items.length; i++) {
				item = items[i];
				if(item.parsed) {
					item = item.el[0];
				}
				if(item === data.el[0]) {
					mfp.index = i;
					break;
				}
			}
		} else {
			mfp.items = $.isArray(data.items) ? data.items : [data.items];
			mfp.index = data.index || 0;
		}

		// if popup is already opened - we just update the content
		if(mfp.isOpen) {
			mfp.updateItemHTML();
			return;
		}
		
		mfp.types = []; 
		_wrapClasses = '';
		if(data.mainEl && data.mainEl.length) {
			mfp.ev = data.mainEl.eq(0);
		} else {
			mfp.ev = _document;
		}

		if(data.key) {
			if(!mfp.popupsCache[data.key]) {
				mfp.popupsCache[data.key] = {};
			}
			mfp.currTemplate = mfp.popupsCache[data.key];
		} else {
			mfp.currTemplate = {};
		}



		mfp.st = $.extend(true, {}, $.magnificPopup.defaults, data ); 
		mfp.fixedContentPos = mfp.st.fixedContentPos === 'auto' ? !mfp.probablyMobile : mfp.st.fixedContentPos;

		if(mfp.st.modal) {
			mfp.st.closeOnContentClick = false;
			mfp.st.closeOnBgClick = false;
			mfp.st.showCloseBtn = false;
			mfp.st.enableEscapeKey = false;
		}
		

		// Building markup
		// main containers are created only once
		if(!mfp.bgOverlay) {

			// Dark overlay
			mfp.bgOverlay = _getEl('bg').on('click'+EVENT_NS, function() {
				mfp.close();
			});

			mfp.wrap = _getEl('wrap').attr('tabindex', -1).on('click'+EVENT_NS, function(e) {
				if(mfp._checkIfClose(e.target)) {
					mfp.close();
				}
			});

			mfp.container = _getEl('container', mfp.wrap);
		}

		mfp.contentContainer = _getEl('content');
		if(mfp.st.preloader) {
			mfp.preloader = _getEl('preloader', mfp.container, mfp.st.tLoading);
		}


		// Initializing modules
		var modules = $.magnificPopup.modules;
		for(i = 0; i < modules.length; i++) {
			var n = modules[i];
			n = n.charAt(0).toUpperCase() + n.slice(1);
			mfp['init'+n].call(mfp);
		}
		_mfpTrigger('BeforeOpen');


		if(mfp.st.showCloseBtn) {
			// Close button
			if(!mfp.st.closeBtnInside) {
				mfp.wrap.append( _getCloseBtn() );
			} else {
				_mfpOn(MARKUP_PARSE_EVENT, function(e, template, values, item) {
					values.close_replaceWith = _getCloseBtn(item.type);
				});
				_wrapClasses += ' mfp-close-btn-in';
			}
		}

		if(mfp.st.alignTop) {
			_wrapClasses += ' mfp-align-top';
		}

	

		if(mfp.fixedContentPos) {
			mfp.wrap.css({
				overflow: mfp.st.overflowY,
				overflowX: 'hidden',
				overflowY: mfp.st.overflowY
			});
		} else {
			mfp.wrap.css({ 
				top: _window.scrollTop(),
				position: 'absolute'
			});
		}
		if( mfp.st.fixedBgPos === false || (mfp.st.fixedBgPos === 'auto' && !mfp.fixedContentPos) ) {
			mfp.bgOverlay.css({
				height: _document.height(),
				position: 'absolute'
			});
		}

		

		if(mfp.st.enableEscapeKey) {
			// Close on ESC key
			_document.on('keyup' + EVENT_NS, function(e) {
				if(e.keyCode === 27) {
					mfp.close();
				}
			});
		}

		_window.on('resize' + EVENT_NS, function() {
			mfp.updateSize();
		});


		if(!mfp.st.closeOnContentClick) {
			_wrapClasses += ' mfp-auto-cursor';
		}
		
		if(_wrapClasses)
			mfp.wrap.addClass(_wrapClasses);


		// this triggers recalculation of layout, so we get it once to not to trigger twice
		var windowHeight = mfp.wH = _window.height();

		
		var windowStyles = {};

		if( mfp.fixedContentPos ) {
            if(mfp._hasScrollBar(windowHeight)){
                var s = mfp._getScrollbarSize();
                if(s) {
                    windowStyles.marginRight = s;
                }
            }
        }

		if(mfp.fixedContentPos) {
			if(!mfp.isIE7) {
				windowStyles.overflow = 'hidden';
			} else {
				// ie7 double-scroll bug
				$('body, html').css('overflow', 'hidden');
			}
		}

		
		
		var classesToadd = mfp.st.mainClass;
		if(mfp.isIE7) {
			classesToadd += ' mfp-ie7';
		}
		if(classesToadd) {
			mfp._addClassToMFP( classesToadd );
		}

		// add content
		mfp.updateItemHTML();

		_mfpTrigger('BuildControls');

		// remove scrollbar, add margin e.t.c
		$('html').css(windowStyles);
		
		// add everything to DOM
		mfp.bgOverlay.add(mfp.wrap).prependTo( mfp.st.prependTo || $(document.body) );

		// Save last focused element
		mfp._lastFocusedEl = document.activeElement;
		
		// Wait for next cycle to allow CSS transition
		setTimeout(function() {
			
			if(mfp.content) {
				mfp._addClassToMFP(READY_CLASS);
				mfp._setFocus();
			} else {
				// if content is not defined (not loaded e.t.c) we add class only for BG
				mfp.bgOverlay.addClass(READY_CLASS);
			}
			
			// Trap the focus in popup
			_document.on('focusin' + EVENT_NS, mfp._onFocusIn);

		}, 16);

		mfp.isOpen = true;
		mfp.updateSize(windowHeight);
		_mfpTrigger(OPEN_EVENT);

		return data;
	},

	/**
	 * Closes the popup
	 */
	close: function() {
		if(!mfp.isOpen) return;
		_mfpTrigger(BEFORE_CLOSE_EVENT);

		mfp.isOpen = false;
		// for CSS3 animation
		if(mfp.st.removalDelay && !mfp.isLowIE && mfp.supportsTransition )  {
			mfp._addClassToMFP(REMOVING_CLASS);
			setTimeout(function() {
				mfp._close();
			}, mfp.st.removalDelay);
		} else {
			mfp._close();
		}
	},

	/**
	 * Helper for close() function
	 */
	_close: function() {
		_mfpTrigger(CLOSE_EVENT);

		var classesToRemove = REMOVING_CLASS + ' ' + READY_CLASS + ' ';

		mfp.bgOverlay.detach();
		mfp.wrap.detach();
		mfp.container.empty();

		if(mfp.st.mainClass) {
			classesToRemove += mfp.st.mainClass + ' ';
		}

		mfp._removeClassFromMFP(classesToRemove);

		if(mfp.fixedContentPos) {
			var windowStyles = {marginRight: ''};
			if(mfp.isIE7) {
				$('body, html').css('overflow', '');
			} else {
				windowStyles.overflow = '';
			}
			$('html').css(windowStyles);
		}
		
		_document.off('keyup' + EVENT_NS + ' focusin' + EVENT_NS);
		mfp.ev.off(EVENT_NS);

		// clean up DOM elements that aren't removed
		mfp.wrap.attr('class', 'mfp-wrap').removeAttr('style');
		mfp.bgOverlay.attr('class', 'mfp-bg');
		mfp.container.attr('class', 'mfp-container');

		// remove close button from target element
		if(mfp.st.showCloseBtn &&
		(!mfp.st.closeBtnInside || mfp.currTemplate[mfp.currItem.type] === true)) {
			if(mfp.currTemplate.closeBtn)
				mfp.currTemplate.closeBtn.detach();
		}


		if(mfp.st.autoFocusLast && mfp._lastFocusedEl) {
			$(mfp._lastFocusedEl).focus(); // put tab focus back
		}
		mfp.currItem = null;	
		mfp.content = null;
		mfp.currTemplate = null;
		mfp.prevHeight = 0;

		_mfpTrigger(AFTER_CLOSE_EVENT);
	},
	
	updateSize: function(winHeight) {

		if(mfp.isIOS) {
			// fixes iOS nav bars https://github.com/dimsemenov/Magnific-Popup/issues/2
			var zoomLevel = document.documentElement.clientWidth / window.innerWidth;
			var height = window.innerHeight * zoomLevel;
			mfp.wrap.css('height', height);
			mfp.wH = height;
		} else {
			mfp.wH = winHeight || _window.height();
		}
		// Fixes #84: popup incorrectly positioned with position:relative on body
		if(!mfp.fixedContentPos) {
			mfp.wrap.css('height', mfp.wH);
		}

		_mfpTrigger('Resize');

	},

	/**
	 * Set content of popup based on current index
	 */
	updateItemHTML: function() {
		var item = mfp.items[mfp.index];

		// Detach and perform modifications
		mfp.contentContainer.detach();

		if(mfp.content)
			mfp.content.detach();

		if(!item.parsed) {
			item = mfp.parseEl( mfp.index );
		}

		var type = item.type;

		_mfpTrigger('BeforeChange', [mfp.currItem ? mfp.currItem.type : '', type]);
		// BeforeChange event works like so:
		// _mfpOn('BeforeChange', function(e, prevType, newType) { });

		mfp.currItem = item;

		if(!mfp.currTemplate[type]) {
			var markup = mfp.st[type] ? mfp.st[type].markup : false;

			// allows to modify markup
			_mfpTrigger('FirstMarkupParse', markup);

			if(markup) {
				mfp.currTemplate[type] = $(markup);
			} else {
				// if there is no markup found we just define that template is parsed
				mfp.currTemplate[type] = true;
			}
		}

		if(_prevContentType && _prevContentType !== item.type) {
			mfp.container.removeClass('mfp-'+_prevContentType+'-holder');
		}

		var newContent = mfp['get' + type.charAt(0).toUpperCase() + type.slice(1)](item, mfp.currTemplate[type]);
		mfp.appendContent(newContent, type);

		item.preloaded = true;

		_mfpTrigger(CHANGE_EVENT, item);
		_prevContentType = item.type;

		// Append container back after its content changed
		mfp.container.prepend(mfp.contentContainer);

		_mfpTrigger('AfterChange');
	},


	/**
	 * Set HTML content of popup
	 */
	appendContent: function(newContent, type) {
		mfp.content = newContent;

		if(newContent) {
			if(mfp.st.showCloseBtn && mfp.st.closeBtnInside &&
				mfp.currTemplate[type] === true) {
				// if there is no markup, we just append close button element inside
				if(!mfp.content.find('.mfp-close').length) {
					mfp.content.append(_getCloseBtn());
				}
			} else {
				mfp.content = newContent;
			}
		} else {
			mfp.content = '';
		}

		_mfpTrigger(BEFORE_APPEND_EVENT);
		mfp.container.addClass('mfp-'+type+'-holder');

		mfp.contentContainer.append(mfp.content);
	},


	/**
	 * Creates Magnific Popup data object based on given data
	 * @param  {int} index Index of item to parse
	 */
	parseEl: function(index) {
		var item = mfp.items[index],
			type;

		if(item.tagName) {
			item = { el: $(item) };
		} else {
			type = item.type;
			item = { data: item, src: item.src };
		}

		if(item.el) {
			var types = mfp.types;

			// check for 'mfp-TYPE' class
			for(var i = 0; i < types.length; i++) {
				if( item.el.hasClass('mfp-'+types[i]) ) {
					type = types[i];
					break;
				}
			}

			item.src = item.el.attr('data-mfp-src');
			if(!item.src) {
				item.src = item.el.attr('href');
			}
		}

		item.type = type || mfp.st.type || 'inline';
		item.index = index;
		item.parsed = true;
		mfp.items[index] = item;
		_mfpTrigger('ElementParse', item);

		return mfp.items[index];
	},


	/**
	 * Initializes single popup or a group of popups
	 */
	addGroup: function(el, options) {
		var eHandler = function(e) {
			e.mfpEl = this;
			mfp._openClick(e, el, options);
		};

		if(!options) {
			options = {};
		}

		var eName = 'click.magnificPopup';
		options.mainEl = el;

		if(options.items) {
			options.isObj = true;
			el.off(eName).on(eName, eHandler);
		} else {
			options.isObj = false;
			if(options.delegate) {
				el.off(eName).on(eName, options.delegate , eHandler);
			} else {
				options.items = el;
				el.off(eName).on(eName, eHandler);
			}
		}
	},
	_openClick: function(e, el, options) {
		var midClick = options.midClick !== undefined ? options.midClick : $.magnificPopup.defaults.midClick;


		if(!midClick && ( e.which === 2 || e.ctrlKey || e.metaKey || e.altKey || e.shiftKey ) ) {
			return;
		}

		var disableOn = options.disableOn !== undefined ? options.disableOn : $.magnificPopup.defaults.disableOn;

		if(disableOn) {
			if($.isFunction(disableOn)) {
				if( !disableOn.call(mfp) ) {
					return true;
				}
			} else { // else it's number
				if( _window.width() < disableOn ) {
					return true;
				}
			}
		}

		if(e.type) {
			e.preventDefault();

			// This will prevent popup from closing if element is inside and popup is already opened
			if(mfp.isOpen) {
				e.stopPropagation();
			}
		}

		options.el = $(e.mfpEl);
		if(options.delegate) {
			options.items = el.find(options.delegate);
		}
		mfp.open(options);
	},


	/**
	 * Updates text on preloader
	 */
	updateStatus: function(status, text) {

		if(mfp.preloader) {
			if(_prevStatus !== status) {
				mfp.container.removeClass('mfp-s-'+_prevStatus);
			}

			if(!text && status === 'loading') {
				text = mfp.st.tLoading;
			}

			var data = {
				status: status,
				text: text
			};
			// allows to modify status
			_mfpTrigger('UpdateStatus', data);

			status = data.status;
			text = data.text;

			mfp.preloader.html(text);

			mfp.preloader.find('a').on('click', function(e) {
				e.stopImmediatePropagation();
			});

			mfp.container.addClass('mfp-s-'+status);
			_prevStatus = status;
		}
	},


	/*
		"Private" helpers that aren't private at all
	 */
	// Check to close popup or not
	// "target" is an element that was clicked
	_checkIfClose: function(target) {

		if($(target).hasClass(PREVENT_CLOSE_CLASS)) {
			return;
		}

		var closeOnContent = mfp.st.closeOnContentClick;
		var closeOnBg = mfp.st.closeOnBgClick;

		if(closeOnContent && closeOnBg) {
			return true;
		} else {

			// We close the popup if click is on close button or on preloader. Or if there is no content.
			if(!mfp.content || $(target).hasClass('mfp-close') || (mfp.preloader && target === mfp.preloader[0]) ) {
				return true;
			}

			// if click is outside the content
			if(  (target !== mfp.content[0] && !$.contains(mfp.content[0], target))  ) {
				if(closeOnBg) {
					// last check, if the clicked element is in DOM, (in case it's removed onclick)
					if( $.contains(document, target) ) {
						return true;
					}
				}
			} else if(closeOnContent) {
				return true;
			}

		}
		return false;
	},
	_addClassToMFP: function(cName) {
		mfp.bgOverlay.addClass(cName);
		mfp.wrap.addClass(cName);
	},
	_removeClassFromMFP: function(cName) {
		this.bgOverlay.removeClass(cName);
		mfp.wrap.removeClass(cName);
	},
	_hasScrollBar: function(winHeight) {
		return (  (mfp.isIE7 ? _document.height() : document.body.scrollHeight) > (winHeight || _window.height()) );
	},
	_setFocus: function() {
		(mfp.st.focus ? mfp.content.find(mfp.st.focus).eq(0) : mfp.wrap).focus();
	},
	_onFocusIn: function(e) {
		if( e.target !== mfp.wrap[0] && !$.contains(mfp.wrap[0], e.target) ) {
			mfp._setFocus();
			return false;
		}
	},
	_parseMarkup: function(template, values, item) {
		var arr;
		if(item.data) {
			values = $.extend(item.data, values);
		}
		_mfpTrigger(MARKUP_PARSE_EVENT, [template, values, item] );

		$.each(values, function(key, value) {
			if(value === undefined || value === false) {
				return true;
			}
			arr = key.split('_');
			if(arr.length > 1) {
				var el = template.find(EVENT_NS + '-'+arr[0]);

				if(el.length > 0) {
					var attr = arr[1];
					if(attr === 'replaceWith') {
						if(el[0] !== value[0]) {
							el.replaceWith(value);
						}
					} else if(attr === 'img') {
						if(el.is('img')) {
							el.attr('src', value);
						} else {
							el.replaceWith( $('<img>').attr('src', value).attr('class', el.attr('class')) );
						}
					} else {
						el.attr(arr[1], value);
					}
				}

			} else {
				template.find(EVENT_NS + '-'+key).html(value);
			}
		});
	},

	_getScrollbarSize: function() {
		// thx David
		if(mfp.scrollbarSize === undefined) {
			var scrollDiv = document.createElement("div");
			scrollDiv.style.cssText = 'width: 99px; height: 99px; overflow: scroll; position: absolute; top: -9999px;';
			document.body.appendChild(scrollDiv);
			mfp.scrollbarSize = scrollDiv.offsetWidth - scrollDiv.clientWidth;
			document.body.removeChild(scrollDiv);
		}
		return mfp.scrollbarSize;
	}

}; /* MagnificPopup core prototype end */




/**
 * Public static functions
 */
$.magnificPopup = {
	instance: null,
	proto: MagnificPopup.prototype,
	modules: [],

	open: function(options, index) {
		_checkInstance();

		if(!options) {
			options = {};
		} else {
			options = $.extend(true, {}, options);
		}

		options.isObj = true;
		options.index = index || 0;
		return this.instance.open(options);
	},

	close: function() {
		return $.magnificPopup.instance && $.magnificPopup.instance.close();
	},

	registerModule: function(name, module) {
		if(module.options) {
			$.magnificPopup.defaults[name] = module.options;
		}
		$.extend(this.proto, module.proto);
		this.modules.push(name);
	},

	defaults: {

		// Info about options is in docs:
		// http://dimsemenov.com/plugins/magnific-popup/documentation.html#options

		disableOn: 0,

		key: null,

		midClick: false,

		mainClass: '',

		preloader: true,

		focus: '', // CSS selector of input to focus after popup is opened

		closeOnContentClick: false,

		closeOnBgClick: true,

		closeBtnInside: true,

		showCloseBtn: true,

		enableEscapeKey: true,

		modal: false,

		alignTop: false,

		removalDelay: 0,

		prependTo: null,

		fixedContentPos: 'auto',

		fixedBgPos: 'auto',

		overflowY: 'auto',

		closeMarkup: '<button title="%title%" type="button" class="mfp-close">&#215;</button>',

		tClose: 'Close (Esc)',

		tLoading: 'Loading...',

		autoFocusLast: true

	}
};



$.fn.magnificPopup = function(options) {
	_checkInstance();

	var jqEl = $(this);

	// We call some API method of first param is a string
	if (typeof options === "string" ) {

		if(options === 'open') {
			var items,
				itemOpts = _isJQ ? jqEl.data('magnificPopup') : jqEl[0].magnificPopup,
				index = parseInt(arguments[1], 10) || 0;

			if(itemOpts.items) {
				items = itemOpts.items[index];
			} else {
				items = jqEl;
				if(itemOpts.delegate) {
					items = items.find(itemOpts.delegate);
				}
				items = items.eq( index );
			}
			mfp._openClick({mfpEl:items}, jqEl, itemOpts);
		} else {
			if(mfp.isOpen)
				mfp[options].apply(mfp, Array.prototype.slice.call(arguments, 1));
		}

	} else {
		// clone options obj
		options = $.extend(true, {}, options);

		/*
		 * As Zepto doesn't support .data() method for objects
		 * and it works only in normal browsers
		 * we assign "options" object directly to the DOM element. FTW!
		 */
		if(_isJQ) {
			jqEl.data('magnificPopup', options);
		} else {
			jqEl[0].magnificPopup = options;
		}

		mfp.addGroup(jqEl, options);

	}
	return jqEl;
};

/*>>core*/

/*>>inline*/

var INLINE_NS = 'inline',
	_hiddenClass,
	_inlinePlaceholder,
	_lastInlineElement,
	_putInlineElementsBack = function() {
		if(_lastInlineElement) {
			_inlinePlaceholder.after( _lastInlineElement.addClass(_hiddenClass) ).detach();
			_lastInlineElement = null;
		}
	};

$.magnificPopup.registerModule(INLINE_NS, {
	options: {
		hiddenClass: 'hide', // will be appended with `mfp-` prefix
		markup: '',
		tNotFound: 'Content not found'
	},
	proto: {

		initInline: function() {
			mfp.types.push(INLINE_NS);

			_mfpOn(CLOSE_EVENT+'.'+INLINE_NS, function() {
				_putInlineElementsBack();
			});
		},

		getInline: function(item, template) {

			_putInlineElementsBack();

			if(item.src) {
				var inlineSt = mfp.st.inline,
					el = $(item.src);

				if(el.length) {

					// If target element has parent - we replace it with placeholder and put it back after popup is closed
					var parent = el[0].parentNode;
					if(parent && parent.tagName) {
						if(!_inlinePlaceholder) {
							_hiddenClass = inlineSt.hiddenClass;
							_inlinePlaceholder = _getEl(_hiddenClass);
							_hiddenClass = 'mfp-'+_hiddenClass;
						}
						// replace target inline element with placeholder
						_lastInlineElement = el.after(_inlinePlaceholder).detach().removeClass(_hiddenClass);
					}

					mfp.updateStatus('ready');
				} else {
					mfp.updateStatus('error', inlineSt.tNotFound);
					el = $('<div>');
				}

				item.inlineElement = el;
				return el;
			}

			mfp.updateStatus('ready');
			mfp._parseMarkup(template, {}, item);
			return template;
		}
	}
});

/*>>inline*/

/*>>ajax*/
var AJAX_NS = 'ajax',
	_ajaxCur,
	_removeAjaxCursor = function() {
		if(_ajaxCur) {
			$(document.body).removeClass(_ajaxCur);
		}
	},
	_destroyAjaxRequest = function() {
		_removeAjaxCursor();
		if(mfp.req) {
			mfp.req.abort();
		}
	};

$.magnificPopup.registerModule(AJAX_NS, {

	options: {
		settings: null,
		cursor: 'mfp-ajax-cur',
		tError: '<a href="%url%">The content</a> could not be loaded.'
	},

	proto: {
		initAjax: function() {
			mfp.types.push(AJAX_NS);
			_ajaxCur = mfp.st.ajax.cursor;

			_mfpOn(CLOSE_EVENT+'.'+AJAX_NS, _destroyAjaxRequest);
			_mfpOn('BeforeChange.' + AJAX_NS, _destroyAjaxRequest);
		},
		getAjax: function(item) {

			if(_ajaxCur) {
				$(document.body).addClass(_ajaxCur);
			}

			mfp.updateStatus('loading');

			var opts = $.extend({
				url: item.src,
				success: function(data, textStatus, jqXHR) {
					var temp = {
						data:data,
						xhr:jqXHR
					};

					_mfpTrigger('ParseAjax', temp);

					mfp.appendContent( $(temp.data), AJAX_NS );

					item.finished = true;

					_removeAjaxCursor();

					mfp._setFocus();

					setTimeout(function() {
						mfp.wrap.addClass(READY_CLASS);
					}, 16);

					mfp.updateStatus('ready');

					_mfpTrigger('AjaxContentAdded');
				},
				error: function() {
					_removeAjaxCursor();
					item.finished = item.loadError = true;
					mfp.updateStatus('error', mfp.st.ajax.tError.replace('%url%', item.src));
				}
			}, mfp.st.ajax.settings);

			mfp.req = $.ajax(opts);

			return '';
		}
	}
});

/*>>ajax*/

/*>>image*/
var _imgInterval,
	_getTitle = function(item) {
		if(item.data && item.data.title !== undefined)
			return item.data.title;

		var src = mfp.st.image.titleSrc;

		if(src) {
			if($.isFunction(src)) {
				return src.call(mfp, item);
			} else if(item.el) {
				return item.el.attr(src) || '';
			}
		}
		return '';
	};

$.magnificPopup.registerModule('image', {

	options: {
		markup: '<div class="mfp-figure">'+
					'<div class="mfp-close"></div>'+
					'<figure>'+
						'<div class="mfp-img"></div>'+
						'<figcaption>'+
							'<div class="mfp-bottom-bar">'+
								'<div class="mfp-title"></div>'+
								'<div class="mfp-counter"></div>'+
							'</div>'+
						'</figcaption>'+
					'</figure>'+
				'</div>',
		cursor: 'mfp-zoom-out-cur',
		titleSrc: 'title',
		verticalFit: true,
		tError: '<a href="%url%">The image</a> could not be loaded.'
	},

	proto: {
		initImage: function() {
			var imgSt = mfp.st.image,
				ns = '.image';

			mfp.types.push('image');

			_mfpOn(OPEN_EVENT+ns, function() {
				if(mfp.currItem.type === 'image' && imgSt.cursor) {
					$(document.body).addClass(imgSt.cursor);
				}
			});

			_mfpOn(CLOSE_EVENT+ns, function() {
				if(imgSt.cursor) {
					$(document.body).removeClass(imgSt.cursor);
				}
				_window.off('resize' + EVENT_NS);
			});

			_mfpOn('Resize'+ns, mfp.resizeImage);
			if(mfp.isLowIE) {
				_mfpOn('AfterChange', mfp.resizeImage);
			}
		},
		resizeImage: function() {
			var item = mfp.currItem;
			if(!item || !item.img) return;

			if(mfp.st.image.verticalFit) {
				var decr = 0;
				// fix box-sizing in ie7/8
				if(mfp.isLowIE) {
					decr = parseInt(item.img.css('padding-top'), 10) + parseInt(item.img.css('padding-bottom'),10);
				}
				item.img.css('max-height', mfp.wH-decr);
			}
		},
		_onImageHasSize: function(item) {
			if(item.img) {

				item.hasSize = true;

				if(_imgInterval) {
					clearInterval(_imgInterval);
				}

				item.isCheckingImgSize = false;

				_mfpTrigger('ImageHasSize', item);

				if(item.imgHidden) {
					if(mfp.content)
						mfp.content.removeClass('mfp-loading');

					item.imgHidden = false;
				}

			}
		},

		/**
		 * Function that loops until the image has size to display elements that rely on it asap
		 */
		findImageSize: function(item) {

			var counter = 0,
				img = item.img[0],
				mfpSetInterval = function(delay) {

					if(_imgInterval) {
						clearInterval(_imgInterval);
					}
					// decelerating interval that checks for size of an image
					_imgInterval = setInterval(function() {
						if(img.naturalWidth > 0) {
							mfp._onImageHasSize(item);
							return;
						}

						if(counter > 200) {
							clearInterval(_imgInterval);
						}

						counter++;
						if(counter === 3) {
							mfpSetInterval(10);
						} else if(counter === 40) {
							mfpSetInterval(50);
						} else if(counter === 100) {
							mfpSetInterval(500);
						}
					}, delay);
				};

			mfpSetInterval(1);
		},

		getImage: function(item, template) {

			var guard = 0,

				// image load complete handler
				onLoadComplete = function() {
					if(item) {
						if (item.img[0].complete) {
							item.img.off('.mfploader');

							if(item === mfp.currItem){
								mfp._onImageHasSize(item);

								mfp.updateStatus('ready');
							}

							item.hasSize = true;
							item.loaded = true;

							_mfpTrigger('ImageLoadComplete');

						}
						else {
							// if image complete check fails 200 times (20 sec), we assume that there was an error.
							guard++;
							if(guard < 200) {
								setTimeout(onLoadComplete,100);
							} else {
								onLoadError();
							}
						}
					}
				},

				// image error handler
				onLoadError = function() {
					if(item) {
						item.img.off('.mfploader');
						if(item === mfp.currItem){
							mfp._onImageHasSize(item);
							mfp.updateStatus('error', imgSt.tError.replace('%url%', item.src) );
						}

						item.hasSize = true;
						item.loaded = true;
						item.loadError = true;
					}
				},
				imgSt = mfp.st.image;


			var el = template.find('.mfp-img');
			if(el.length) {
				var img = document.createElement('img');
				img.className = 'mfp-img';
				if(item.el && item.el.find('img').length) {
					img.alt = item.el.find('img').attr('alt');
				}
				item.img = $(img).on('load.mfploader', onLoadComplete).on('error.mfploader', onLoadError);
				img.src = item.src;

				// without clone() "error" event is not firing when IMG is replaced by new IMG
				// TODO: find a way to avoid such cloning
				if(el.is('img')) {
					item.img = item.img.clone();
				}

				img = item.img[0];
				if(img.naturalWidth > 0) {
					item.hasSize = true;
				} else if(!img.width) {
					item.hasSize = false;
				}
			}

			mfp._parseMarkup(template, {
				title: _getTitle(item),
				img_replaceWith: item.img
			}, item);

			mfp.resizeImage();

			if(item.hasSize) {
				if(_imgInterval) clearInterval(_imgInterval);

				if(item.loadError) {
					template.addClass('mfp-loading');
					mfp.updateStatus('error', imgSt.tError.replace('%url%', item.src) );
				} else {
					template.removeClass('mfp-loading');
					mfp.updateStatus('ready');
				}
				return template;
			}

			mfp.updateStatus('loading');
			item.loading = true;

			if(!item.hasSize) {
				item.imgHidden = true;
				template.addClass('mfp-loading');
				mfp.findImageSize(item);
			}

			return template;
		}
	}
});

/*>>image*/

/*>>zoom*/
var hasMozTransform,
	getHasMozTransform = function() {
		if(hasMozTransform === undefined) {
			hasMozTransform = document.createElement('p').style.MozTransform !== undefined;
		}
		return hasMozTransform;
	};

$.magnificPopup.registerModule('zoom', {

	options: {
		enabled: false,
		easing: 'ease-in-out',
		duration: 300,
		opener: function(element) {
			return element.is('img') ? element : element.find('img');
		}
	},

	proto: {

		initZoom: function() {
			var zoomSt = mfp.st.zoom,
				ns = '.zoom',
				image;

			if(!zoomSt.enabled || !mfp.supportsTransition) {
				return;
			}

			var duration = zoomSt.duration,
				getElToAnimate = function(image) {
					var newImg = image.clone().removeAttr('style').removeAttr('class').addClass('mfp-animated-image'),
						transition = 'all '+(zoomSt.duration/1000)+'s ' + zoomSt.easing,
						cssObj = {
							position: 'fixed',
							zIndex: 9999,
							left: 0,
							top: 0,
							'-webkit-backface-visibility': 'hidden'
						},
						t = 'transition';

					cssObj['-webkit-'+t] = cssObj['-moz-'+t] = cssObj['-o-'+t] = cssObj[t] = transition;

					newImg.css(cssObj);
					return newImg;
				},
				showMainContent = function() {
					mfp.content.css('visibility', 'visible');
				},
				openTimeout,
				animatedImg;

			_mfpOn('BuildControls'+ns, function() {
				if(mfp._allowZoom()) {

					clearTimeout(openTimeout);
					mfp.content.css('visibility', 'hidden');

					// Basically, all code below does is clones existing image, puts in on top of the current one and animated it

					image = mfp._getItemToZoom();

					if(!image) {
						showMainContent();
						return;
					}

					animatedImg = getElToAnimate(image);

					animatedImg.css( mfp._getOffset() );

					mfp.wrap.append(animatedImg);

					openTimeout = setTimeout(function() {
						animatedImg.css( mfp._getOffset( true ) );
						openTimeout = setTimeout(function() {

							showMainContent();

							setTimeout(function() {
								animatedImg.remove();
								image = animatedImg = null;
								_mfpTrigger('ZoomAnimationEnded');
							}, 16); // avoid blink when switching images

						}, duration); // this timeout equals animation duration

					}, 16); // by adding this timeout we avoid short glitch at the beginning of animation


					// Lots of timeouts...
				}
			});
			_mfpOn(BEFORE_CLOSE_EVENT+ns, function() {
				if(mfp._allowZoom()) {

					clearTimeout(openTimeout);

					mfp.st.removalDelay = duration;

					if(!image) {
						image = mfp._getItemToZoom();
						if(!image) {
							return;
						}
						animatedImg = getElToAnimate(image);
					}

					animatedImg.css( mfp._getOffset(true) );
					mfp.wrap.append(animatedImg);
					mfp.content.css('visibility', 'hidden');

					setTimeout(function() {
						animatedImg.css( mfp._getOffset() );
					}, 16);
				}

			});

			_mfpOn(CLOSE_EVENT+ns, function() {
				if(mfp._allowZoom()) {
					showMainContent();
					if(animatedImg) {
						animatedImg.remove();
					}
					image = null;
				}
			});
		},

		_allowZoom: function() {
			return mfp.currItem.type === 'image';
		},

		_getItemToZoom: function() {
			if(mfp.currItem.hasSize) {
				return mfp.currItem.img;
			} else {
				return false;
			}
		},

		// Get element postion relative to viewport
		_getOffset: function(isLarge) {
			var el;
			if(isLarge) {
				el = mfp.currItem.img;
			} else {
				el = mfp.st.zoom.opener(mfp.currItem.el || mfp.currItem);
			}

			var offset = el.offset();
			var paddingTop = parseInt(el.css('padding-top'),10);
			var paddingBottom = parseInt(el.css('padding-bottom'),10);
			offset.top -= ( $(window).scrollTop() - paddingTop );


			/*

			Animating left + top + width/height looks glitchy in Firefox, but perfect in Chrome. And vice-versa.

			 */
			var obj = {
				width: el.width(),
				// fix Zepto height+padding issue
				height: (_isJQ ? el.innerHeight() : el[0].offsetHeight) - paddingBottom - paddingTop
			};

			// I hate to do this, but there is no another option
			if( getHasMozTransform() ) {
				obj['-moz-transform'] = obj['transform'] = 'translate(' + offset.left + 'px,' + offset.top + 'px)';
			} else {
				obj.left = offset.left;
				obj.top = offset.top;
			}
			return obj;
		}

	}
});



/*>>zoom*/

/*>>iframe*/

var IFRAME_NS = 'iframe',
	_emptyPage = '//about:blank',

	_fixIframeBugs = function(isShowing) {
		if(mfp.currTemplate[IFRAME_NS]) {
			var el = mfp.currTemplate[IFRAME_NS].find('iframe');
			if(el.length) {
				// reset src after the popup is closed to avoid "video keeps playing after popup is closed" bug
				if(!isShowing) {
					el[0].src = _emptyPage;
				}

				// IE8 black screen bug fix
				if(mfp.isIE8) {
					el.css('display', isShowing ? 'block' : 'none');
				}
			}
		}
	};

$.magnificPopup.registerModule(IFRAME_NS, {

	options: {
		markup: '<div class="mfp-iframe-scaler">'+
					'<div class="mfp-close"></div>'+
					'<iframe class="mfp-iframe" src="//about:blank" frameborder="0" allowfullscreen></iframe>'+
				'</div>',

		srcAction: 'iframe_src',

		// we don't care and support only one default type of URL by default
		patterns: {
			youtube: {
				index: 'youtube.com',
				id: 'v=',
				src: '//www.youtube.com/embed/%id%?autoplay=1'
			},
			vimeo: {
				index: 'vimeo.com/',
				id: '/',
				src: '//player.vimeo.com/video/%id%?autoplay=1'
			},
			gmaps: {
				index: '//maps.google.',
				src: '%id%&output=embed'
			}
		}
	},

	proto: {
		initIframe: function() {
			mfp.types.push(IFRAME_NS);

			_mfpOn('BeforeChange', function(e, prevType, newType) {
				if(prevType !== newType) {
					if(prevType === IFRAME_NS) {
						_fixIframeBugs(); // iframe if removed
					} else if(newType === IFRAME_NS) {
						_fixIframeBugs(true); // iframe is showing
					}
				}// else {
					// iframe source is switched, don't do anything
				//}
			});

			_mfpOn(CLOSE_EVENT + '.' + IFRAME_NS, function() {
				_fixIframeBugs();
			});
		},

		getIframe: function(item, template) {
			var embedSrc = item.src;
			var iframeSt = mfp.st.iframe;

			$.each(iframeSt.patterns, function() {
				if(embedSrc.indexOf( this.index ) > -1) {
					if(this.id) {
						if(typeof this.id === 'string') {
							embedSrc = embedSrc.substr(embedSrc.lastIndexOf(this.id)+this.id.length, embedSrc.length);
						} else {
							embedSrc = this.id.call( this, embedSrc );
						}
					}
					embedSrc = this.src.replace('%id%', embedSrc );
					return false; // break;
				}
			});

			var dataObj = {};
			if(iframeSt.srcAction) {
				dataObj[iframeSt.srcAction] = embedSrc;
			}
			mfp._parseMarkup(template, dataObj, item);

			mfp.updateStatus('ready');

			return template;
		}
	}
});



/*>>iframe*/

/*>>gallery*/
/**
 * Get looped index depending on number of slides
 */
var _getLoopedId = function(index) {
		var numSlides = mfp.items.length;
		if(index > numSlides - 1) {
			return index - numSlides;
		} else  if(index < 0) {
			return numSlides + index;
		}
		return index;
	},
	_replaceCurrTotal = function(text, curr, total) {
		return text.replace(/%curr%/gi, curr + 1).replace(/%total%/gi, total);
	};

$.magnificPopup.registerModule('gallery', {

	options: {
		enabled: false,
		arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>',
		preload: [0,2],
		navigateByImgClick: true,
		arrows: true,

		tPrev: 'Previous (Left arrow key)',
		tNext: 'Next (Right arrow key)',
		tCounter: '%curr% of %total%'
	},

	proto: {
		initGallery: function() {

			var gSt = mfp.st.gallery,
				ns = '.mfp-gallery';

			mfp.direction = true; // true - next, false - prev

			if(!gSt || !gSt.enabled ) return false;

			_wrapClasses += ' mfp-gallery';

			_mfpOn(OPEN_EVENT+ns, function() {

				if(gSt.navigateByImgClick) {
					mfp.wrap.on('click'+ns, '.mfp-img', function() {
						if(mfp.items.length > 1) {
							mfp.next();
							return false;
						}
					});
				}

				_document.on('keydown'+ns, function(e) {
					if (e.keyCode === 37) {
						mfp.prev();
					} else if (e.keyCode === 39) {
						mfp.next();
					}
				});
			});

			_mfpOn('UpdateStatus'+ns, function(e, data) {
				if(data.text) {
					data.text = _replaceCurrTotal(data.text, mfp.currItem.index, mfp.items.length);
				}
			});

			_mfpOn(MARKUP_PARSE_EVENT+ns, function(e, element, values, item) {
				var l = mfp.items.length;
				values.counter = l > 1 ? _replaceCurrTotal(gSt.tCounter, item.index, l) : '';
			});

			_mfpOn('BuildControls' + ns, function() {
				if(mfp.items.length > 1 && gSt.arrows && !mfp.arrowLeft) {
					var markup = gSt.arrowMarkup,
						arrowLeft = mfp.arrowLeft = $( markup.replace(/%title%/gi, gSt.tPrev).replace(/%dir%/gi, 'left') ).addClass(PREVENT_CLOSE_CLASS),
						arrowRight = mfp.arrowRight = $( markup.replace(/%title%/gi, gSt.tNext).replace(/%dir%/gi, 'right') ).addClass(PREVENT_CLOSE_CLASS);

					arrowLeft.click(function() {
						mfp.prev();
					});
					arrowRight.click(function() {
						mfp.next();
					});

					mfp.container.append(arrowLeft.add(arrowRight));
				}
			});

			_mfpOn(CHANGE_EVENT+ns, function() {
				if(mfp._preloadTimeout) clearTimeout(mfp._preloadTimeout);

				mfp._preloadTimeout = setTimeout(function() {
					mfp.preloadNearbyImages();
					mfp._preloadTimeout = null;
				}, 16);
			});


			_mfpOn(CLOSE_EVENT+ns, function() {
				_document.off(ns);
				mfp.wrap.off('click'+ns);
				mfp.arrowRight = mfp.arrowLeft = null;
			});

		},
		next: function() {
			mfp.direction = true;
			mfp.index = _getLoopedId(mfp.index + 1);
			mfp.updateItemHTML();
		},
		prev: function() {
			mfp.direction = false;
			mfp.index = _getLoopedId(mfp.index - 1);
			mfp.updateItemHTML();
		},
		goTo: function(newIndex) {
			mfp.direction = (newIndex >= mfp.index);
			mfp.index = newIndex;
			mfp.updateItemHTML();
		},
		preloadNearbyImages: function() {
			var p = mfp.st.gallery.preload,
				preloadBefore = Math.min(p[0], mfp.items.length),
				preloadAfter = Math.min(p[1], mfp.items.length),
				i;

			for(i = 1; i <= (mfp.direction ? preloadAfter : preloadBefore); i++) {
				mfp._preloadItem(mfp.index+i);
			}
			for(i = 1; i <= (mfp.direction ? preloadBefore : preloadAfter); i++) {
				mfp._preloadItem(mfp.index-i);
			}
		},
		_preloadItem: function(index) {
			index = _getLoopedId(index);

			if(mfp.items[index].preloaded) {
				return;
			}

			var item = mfp.items[index];
			if(!item.parsed) {
				item = mfp.parseEl( index );
			}

			_mfpTrigger('LazyLoad', item);

			if(item.type === 'image') {
				item.img = $('<img class="mfp-img" />').on('load.mfploader', function() {
					item.hasSize = true;
				}).on('error.mfploader', function() {
					item.hasSize = true;
					item.loadError = true;
					_mfpTrigger('LazyLoadError', item);
				}).attr('src', item.src);
			}


			item.preloaded = true;
		}
	}
});

/*>>gallery*/

/*>>retina*/

var RETINA_NS = 'retina';

$.magnificPopup.registerModule(RETINA_NS, {
	options: {
		replaceSrc: function(item) {
			return item.src.replace(/\.\w+$/, function(m) { return '@2x' + m; });
		},
		ratio: 1 // Function or number.  Set to 1 to disable.
	},
	proto: {
		initRetina: function() {
			if(window.devicePixelRatio > 1) {

				var st = mfp.st.retina,
					ratio = st.ratio;

				ratio = !isNaN(ratio) ? ratio : ratio();

				if(ratio > 1) {
					_mfpOn('ImageHasSize' + '.' + RETINA_NS, function(e, item) {
						item.img.css({
							'max-width': item.img[0].naturalWidth / ratio,
							'width': '100%'
						});
					});
					_mfpOn('ElementParse' + '.' + RETINA_NS, function(e, item) {
						item.src = st.replaceSrc(item, ratio);
					});
				}
			}

		}
	}
});

/*>>retina*/
 _checkInstance(); }));
/*!
 * jQuery Cookie Plugin v1.4.1
 * https://github.com/carhartl/jquery-cookie
 *
 * Copyright 2013 Klaus Hartl
 * Released under the MIT license
 */
(function (factory) {
	if (typeof define === 'function' && define.amd) {
		// AMD
		define(['jquery'], factory);
	} else if (typeof exports === 'object') {
		// CommonJS
		factory(require('jquery'));
	} else {
		// Browser globals
		factory(jQuery);
	}
}(function ($) {

	var pluses = /\+/g;

	function encode(s) {
		return config.raw ? s : encodeURIComponent(s);
	}

	function decode(s) {
		return config.raw ? s : decodeURIComponent(s);
	}

	function stringifyCookieValue(value) {
		return encode(config.json ? JSON.stringify(value) : String(value));
	}

	function parseCookieValue(s) {
		if (s.indexOf('"') === 0) {
			// This is a quoted cookie as according to RFC2068, unescape...
			s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
		}

		try {
			// Replace server-side written pluses with spaces.
			// If we can't decode the cookie, ignore it, it's unusable.
			// If we can't parse the cookie, ignore it, it's unusable.
			s = decodeURIComponent(s.replace(pluses, ' '));
			return config.json ? JSON.parse(s) : s;
		} catch(e) {}
	}

	function read(s, converter) {
		var value = config.raw ? s : parseCookieValue(s);
		return $.isFunction(converter) ? converter(value) : value;
	}

	var config = $.cookie = function (key, value, options) {

		// Write

		if (value !== undefined && !$.isFunction(value)) {
			options = $.extend({}, config.defaults, options);

			if (typeof options.expires === 'number') {
				var days = options.expires, t = options.expires = new Date();
				t.setTime(+t + days * 864e+5);
			}

			return (document.cookie = [
				encode(key), '=', stringifyCookieValue(value),
				options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
				options.path    ? '; path=' + options.path : '',
				options.domain  ? '; domain=' + options.domain : '',
				options.secure  ? '; secure' : ''
			].join(''));
		}

		// Read

		var result = key ? undefined : {};

		// To prevent the for loop in the first place assign an empty array
		// in case there are no cookies at all. Also prevents odd result when
		// calling $.cookie().
		var cookies = document.cookie ? document.cookie.split('; ') : [];

		for (var i = 0, l = cookies.length; i < l; i++) {
			var parts = cookies[i].split('=');
			var name = decode(parts.shift());
			var cookie = parts.join('=');

			if (key && key === name) {
				// If second argument (value) is a function it's a converter...
				result = read(cookie, value);
				break;
			}

			// Prevent storing a cookie that we couldn't decode.
			if (!key && (cookie = read(cookie)) !== undefined) {
				result[name] = cookie;
			}
		}

		return result;
	};

	config.defaults = {};

	$.removeCookie = function (key, options) {
		if ($.cookie(key) === undefined) {
			return false;
		}

		// Must not alter options, thus extending a fresh object...
		$.cookie(key, '', $.extend({}, options, { expires: -1 }));
		return !$.cookie(key);
	};

}));
//TABS
function tabs_initialization() {
  $('ul.s_tabs_list').each(function () {
    $(this).find('li').each(function (i) {

      $(this).on("click ", function () {
        var that = $(this);
        tabsInit(that);
        addMoreBtnToComments();
      });

      $(this).on("keydown", function (e) {
        if (e.keyCode === 13) {
          var that = $(this);
          tabsInit(that);
        }
      });

      function tabsInit(thisElem) {
        thisElem.addClass('active').siblings().removeClass('active')
          .closest('.s_tabs').find('.s_tabs_content').removeClass('active').eq(i).addClass('active');

        // Выходим, если не надо перерасчет слайдера.
        if (thisElem.hasClass('js-init-product-media-slider')) {
          return false;
        }

        const $currentTab = thisElem.closest('.s_tabs').find('.s_tabs_content.active');
        const carousel = $currentTab.find('.carousel-1c');
        const products = carousel.find('.slick-initialized');

        if (products.length) {
          products.slick('unslick');
          initCarousel(carousel);
          $currentTab.find('.product-card__body').each(function () {
            initProductCardSlider($(this), 7);
          });
        } else {
          $currentTab.find('.slick-initialized').slick('setPosition');
        }
      }
    });
  });
}
tabs_initialization();

//Вариант с слайдером slick
$('ul.s_tabs_list.s_tabs_list--slick').each(function () {
  $(this).find('.slick-slide').each(function (i) {
    $(this).on("click", function () {
      $('.slick-slide').removeClass('slick-current');
      $(this).addClass('active').siblings().removeClass('active')
        .closest('.s_tabs.s_tabs--slick').find('.s_tabs_content').removeClass('active').eq(i).addClass('active');

    });
  });
});

// Табы на нативном js
// стили в frontend/web/src/scss/template/tabs/_pg-tab.scss
var settingsTab = {
  wrapper: '.js-tab',
  navigation: '.js-tab-nav',
  content: '.js-tab-content'
};

initTabs(settingsTab);

function initTabs(settings) {
  // обвертка таба
  var wrapper = document.querySelector(settings.wrapper);

  // если нет родительского элемента, то выходим из инициализации таба
  if (!wrapper) {
    return false;
  }

  // находим элементы внутри родительского элемента, что бы избежать конфликта с другим табом
  var navigation = wrapper.querySelectorAll(settings.navigation);
  var content = wrapper.querySelectorAll(settings.content);

  // вешаем клики на меню табов
  for (var i = 0; i < navigation.length; i++) {
    navigation[i].addEventListener('click', function () {
      // Находим и удаляем активный предыдущий таб
      var activeNav = wrapper.querySelector(settings.navigation + '.active');
      var activeTab = wrapper.querySelector(settings.content + '.active');
      activeNav.classList.remove('active');
      activeTab.classList.remove('active');

      // вычисляем порядковый номер на котором был клик
      for (var l = 0; l < navigation.length; l++) {
        if (navigation[l] === this) {
          // Активируем нужный таб по клику
          this.classList.add('active');
          content[l].classList.add('active');

          // дополнительный вызов не касающийся таба
          // setPositionProductCard();
        }
      }
    });
  }
}

// Перерисовка слайдера в карточке товара
function setPositionProductCard() {
  var sliderImg = $('.js-product-card-img-slider');
  var sliderColor = $('.js-product-card-img-slider');
  if (sliderImg && sliderColor) {
    $('.js-product-card-img-slider').slick('setPosition');
    $('.js-product-card-color-slider').slick('setPosition');
  }
}


window.addEventListener('load', function() {

	// setTimeout(initLoader, 400);
	
	initLoader();
	function initLoader() {
	  var body = document.querySelector('body');
	  body.classList.remove('loader-is-run');
	  body.querySelector('.loader').remove();
	}

	initCatalogMenu();
	
	function initCatalogMenu() {
		var mainMenuLi = document.querySelectorAll('.js-cat-menu-li');
	
		// меняем ширину второго меню на 1 и 2 колонки
		if (mainMenuLi.length) {
			for (var i = 0; i < mainMenuLi.length; i++) {
				mainMenuLi[i].addEventListener('mouseenter', function () {
					var subMenu = this.querySelector('.js-cat-menu-sub');
					var subMenuItem = subMenu.querySelectorAll('.js-cat-menu-link');
	
					if (subMenuItem.length > 11) {
						subMenu.classList.add('is-two-columns');
					}
				});
	
				mainMenuLi[i].addEventListener('mouseleave', function () {
					var subMenu = this.querySelector('.js-cat-menu-sub');
					subMenu.classList.remove('is-two-columns');
				});
			}
		}
	}
	
	$('.header-cat-menu_sub').parent().addClass('header-cat-menu__item--show-sub');
	
	$(document).on('click', '.js-cat-menu-sub-show', function () {
	
		//$(this).next().next().toggleClass('is-visible');
		//$(this).toggleClass('toggle');
	
		if ($(this).next().next().css('display') == 'none') {
	
			$(this).next().next().slideDown( "fast", function() {});
			$(this).addClass('toggle');
	
			$(this).closest('.header-cat-menu__item').parent().addClass('toggle');
	
		} else {
	
			$(this).next().next().slideUp( "fast", function() {});
			$(this).removeClass('toggle');
	
			$(this).closest('.header-cat-menu__item').parent().removeClass('toggle');
	
		}
	
	});

    $( function()
    
    {
    
        $('.js-open-modal-grid-size').imageLightbox(
            {
                selector:       'id="imagelightbox"',   // string;
                allowedTypes:   'png|jpg|jpeg|gif',     // string;
                animationSpeed: 250,                    // integer;
                preloadNext:    true,                   // bool;            silently preload the next image
                enableKeyboard: true,                   // bool;            enable keyboard shortcuts (arrows Left/Right and Esc)
                quitOnEnd:      false,                  // bool;            quit after viewing the last image
                quitOnImgClick: false,                  // bool;            quit when the viewed image is clicked
                quitOnDocClick: true,                   // bool;            quit when anything but the viewed image is clicked
                onStart:        false,                  // function/bool;   calls function when the lightbox starts
                onEnd:          false,                  // function/bool;   calls function when the lightbox quits
                onLoadStart:    false,                  // function/bool;   calls function when the image load begins
                onLoadEnd:      false                   // function/bool;   calls function when the image finishes loading
            });
    
    });
    
    // $(document).on('click', '.js-open-modal-grid-size', function () {
    //     setTimeout(function(){$('#imagelightbox').wrapAll('<div id="imagelightbox" class="imagelightbox-wrap"></div>');}, 1000);
    // });
	var overlay = $('#overlay');
	var overlay_search = $('#overlay-search');
	
	$('.header-cat__but').click(function () {
	  if ($(this).next().css('display') == 'block') {
	    $(this).next().slideUp("fast", function () {
	    });
	    $(this).removeClass('b_arrow_up');
	    $(this).parent().parent().nextAll().find('.header-cat__nav').prev().removeClass('b_arrow_up');
	  } else {
	    $(this).next().slideDown("fast", function () {
	    });
	    $(this).addClass('b_arrow_up');
	
	    $(this).parent().parent().prevAll().find('.header-cat__nav').slideUp("fast", function () {
	    }).prev().removeClass('b_arrow_up');
	    $(this).parent().parent().nextAll().find('.header-cat__nav').slideUp("fast", function () {
	    }).prev().removeClass('b_arrow_up');
	  }
	});
	
	//ACCORDION
	$('.js-toggle-slide').click(function () {
	  if ($(this).next().css('display') == 'block') {
	    $(this).next().slideUp("fast", function () {
	    });
	    $(this).removeClass('b_arrow_up');
	  } else {
	    $(this).next().slideDown("fast", function () {
	    });
	    $(this).parent().prevAll().find('.js-toggle-cont').slideUp("fast", function () {
	    });
	    $(this).parent().nextAll().find('.js-toggle-cont').slideUp("fast", function () {
	    });
	    $(this).addClass('b_arrow_up');
	    $(this).parent().nextAll().find('.js-toggle-slide').removeClass('b_arrow_up');
	    $(this).parent().prevAll().find('.js-toggle-slide').removeClass('b_arrow_up');
	  }
	});
	
	//OTHER TOGGLE
	$('.js-toggle-other-slide').click(function () {
	  if ($(this).next().css('display') == 'block') {
	    $(this).next().slideUp("fast", function () {
	    });
	    $(this).removeClass('toggle');
	  } else {
	    $(this).next().slideDown("fast", function () {
	    });
	    $(this).addClass('toggle');
	  }
	});
	$('.cart-promo__close').click(function () {
	  if ($(this).parent().next().css('display') == 'block') {
	    $(this).parent().next().slideDown("fast", function () {
	    });
	    $(this).parent().addClass('toggle');
	  } else {
	    $(this).parent().next().slideUp("fast", function () {
	    });
	    $(this).parent().removeClass('toggle');
	  }
	});
	
	// изменять высоту корзины на мобильных устройствах с выдвигающимся url bar
	$(window).on('resize', function () {
	  $('.modal--cart').outerHeight(window.innerHeight);
	});
	
	//menu catalog - show, hidden
	$('.header-cat__show').click(function () {
	  $(this).css('display', 'none');
	  $('.header-cat__show._hidden').css('display', 'block');
	  $(this).prev().toggleClass('_show');
	  $(this).parent().parent().parent().toggleClass('_show');
	});
	$('.header-cat__show._hidden').click(function () {
	  $('.header-cat__show').css('display', 'block');
	  $(this).parent().parent().toggleClass('_show');
	  $(this).parent().parent().parent().parent().parent().toggleClass('_show');
	});
	
	//BURGERS BUTTON MOBILE
	$('.js-toggle-show.js-toggle-show_cat').click(function () {
	  $(this).closest('.header-burgers').parent().next().toggleClass('hidden-content_show');
	  $(this).toggleClass('b_arrow_up');
	
	  $('.header-burgers').find('.search-form_mob').removeClass('hidden-content_show');
	  overlay_search.fadeOut(400);
	  $('.header-burger-content').removeClass('hidden-content_show');
	  $('.cart-m-popup').removeClass('_show');
	  $('.js-toggle-show.js-toggle-show_menu').removeClass('close');
	});
	
	//menu
	$('.js-toggle-show.js-toggle-show_menu').click(function () {
	  $(this).next().toggleClass('hidden-content_show');
	  $(this).toggleClass('close');
	  $('body').toggleClass('no-scroll')
	
	  $('.header-burgers').find('.search-form_mob').removeClass('hidden-content_show');
	  overlay_search.fadeOut(400);
	  $('.header-cat-mobile').removeClass('hidden-content_show');
	  $('.cart-m-popup').removeClass('_show');
	  $('.header-burger-content').outerHeight(window.innerHeight - 106);
	});
	
	// header dropdowns
	$('.dd-1__current').on('click', function () {
	  if (!$(this).parent().hasClass('active')) {
	    $('.dd-1').removeClass('active');
	    $(this).parent().addClass('active');
	  } else {
	    $('.dd-1').removeClass('active');
	  }
	});
	
	$('body').click(function (e) {
	
	  if ($(e.target).closest('.dd-1').length === 0) {
	    $('.dd-1').removeClass('active');
	  }
	  if ($(e.target).closest('.header-burgers-col.header-burgers-col--right').length === 0) {
	    $(this).removeClass('no-scroll');
	  }
	})
	/****** Selects */
	$('.s_select_box_value').click(function () {
	  $('.cart-m-popup').removeClass('_show');
	  $(this).parent().toggleClass('_show b_arrow_up');
	  $(this).parent().parent().toggleClass('_overflow_hidden');
	
	  $(this).parent().parent().nextAll().removeClass('_overflow_hidden').find('.switch ').removeClass('_show b_arrow_up');
	  $(this).parent().parent().prevAll().removeClass('_overflow_hidden').find('.switch ').removeClass('_show b_arrow_up');
	
	  $('.header-row_bot').removeClass('search-form_show');
	});
	$('li').click(function () {
	  $(this).nextAll().removeClass('selected');
	  $(this).prevAll().removeClass('selected');
	  $(this).addClass('selected');
	  $(this).closest(".s_select_box").find('.s_select_box_value span').text($(this).text()).parent().parent().removeClass('_show b_arrow_up');
	  $(this).parent().parent().parent().parent().removeClass('_overflow_hidden');
	});
	
	//SEARCH - HIDDEN/SHOW
	$('.header-ordering-col_search').click(function () {
	  $('.header-row_bot').addClass('search-form_show');
	
	  $('.header-ordering-col_call').css('display', 'none');
	
	  $('.cart-m-popup').removeClass('_show');
	  $('.switch').removeClass('_show b_arrow_up')
	});
	
	$('.search-form__close').click(function () {
	  $('.header-row_bot').removeClass('search-form_show');
	  $('.header-ordering-col_call').css('display', 'block');
	});
	
	//COLOR CHECK
	$('.product-card-slider-wrap__item').click(function () {
	  $(this).addClass('_active');
	  $(this).prevAll().removeClass('_active');
	  $(this).nextAll().removeClass('_active');
	});
	$('.product-colors__item').click(function () {
	  $(this).addClass('_active');
	  $(this).prevAll().removeClass('_active');
	  $(this).nextAll().removeClass('_active');
	});
	
	
	//SIZES CHECK
	// $(document).on('click', '.sizes-switch__item', function () {
	//   if (!$(this).hasClass('sizes-switch__item--stock')) {
	//     return;
	//   }
	//
	//   $('.sizes-switch__item').removeClass('sizes-switch__item--active');
	//   $(this).addClass('sizes-switch__item--active');
	// });
	
	$('.sizes-switch').each(initSizeSwitch);
	
	
	//SIZES COLORS
	$('.switch-color__item').click(function () {
	  $(this).addClass('switch-color__item--active');
	  $(this).prevAll().removeClass('switch-color__item--active');
	  $(this).nextAll().removeClass('switch-color__item--active');
	});
	
	//toggle view products card
	$(document).on('click', '.js-toggle-view', function () {
	  $(this).nextAll().removeClass('views-buttons-but--active');
	  $(this).prevAll().removeClass('views-buttons-but--active');
	  $(this).toggleClass('views-buttons-but--active');
	});
	
	$(document).on('click', '.views-buttons-but--view-1', function () {
	  $('.js-toggle-views').removeClass('product-card-wrap--view-2');
	  $('.js-toggle-views').removeClass('product-card-wrap--view-3');
	  var sliderImg2 = $('.js-product-card-img-slider.slick-initialized');
	  var sliderColor2 = $('.js-product-card-color-slider.slick-initialized');
	  sliderImg2.slick('unslick');
	  sliderColor2.slick('unslick');
	
	  $('.page-content-inner').find('.product-card__body').each(function () {
	    initProductCardSlider($(this), 7);
	  });
	
	  $(document).on('click', '.js-product-card-color', function () {
	    var actIndex = +($(this).attr('data-slick-index'));
	    var slider = $(this).closest('.js-product-card-color-slider').prev('.js-product-card-img-slider');
	    slider[0].slick.slickGoTo(parseInt(actIndex));
	  });
	});
	
	$(document).on('click', '.views-buttons-but--view-2', function () {
	  $('.js-toggle-views').addClass('product-card-wrap--view-2');
	  $('.js-toggle-views').removeClass('product-card-wrap--view-3');
	  var sliderImg2 = $('.js-product-card-img-slider.slick-initialized');
	  var sliderColor2 = $('.js-product-card-color-slider.slick-initialized');
	  sliderImg2.slick('unslick');
	  sliderColor2.slick('unslick');
	
	  $('.js-toggle-views').addClass('product-card-wrap--view-2');
	  $('.js-toggle-views').removeClass
	
	  $('.page-content-inner').find('.product-card__body').each(function () {
	    initProductCardSlider($(this), 4);
	  });
	
	  $(document).on('click', '.js-product-card-color', function () {
	    var actIndex = +($(this).attr('data-slick-index'));
	    var slider = $(this).closest('.js-product-card-color-slider').prev('.js-product-card-img-slider');
	    slider[0].slick.slickGoTo(parseInt(actIndex));
	  });
	});
	
	$(document).on('click', '.views-buttons-but--view-3', function () {
	
	  $('.js-toggle-views').addClass('product-card-wrap--view-3');
	  $('.js-toggle-views').removeClass('product-card-wrap--view-2');
	  var sliderImg2 = $('.js-product-card-img-slider.slick-initialized');
	  var sliderColor2 = $('.js-product-card-color-slider.slick-initialized');
	  sliderImg2.slick('unslick');
	  sliderColor2.slick('unslick');
	  $('.js-toggle-views').addClass('product-card-wrap--view-3');
	  $('.js-toggle-views').removeClass
	
	  $('.page-content-inner').find('.product-card__body').each(function () {
	    initProductCardSlider($(this), 7);
	  });
	
	  $(document).on('click', '.js-product-card-color', function () {
	    var actIndex = +($(this).attr('data-slick-index'));
	    var slider = $(this).closest('.js-product-card-color-slider').prev('.js-product-card-img-slider');
	    slider[0].slick.slickGoTo(parseInt(actIndex));
	  });
	
	  //Добавляем класс если в карточке товара больше двух ЛЕЙБЛОВ
	  if ($('.product-card-labels').hasClass('product-card-labels--3')) {
	    $('.product-card').addClass('product-card-more-labels--3');
	  }
	
	});
	
	//header cart popup - show, hidden
	$(document).on('click', '.header-ordering__icon.header-ordering__icon_cart', function () {
	  if ($(window).width() < 992) {
	    $('#overlay').fadeIn(200,
	      function () {
	        $('.modal--cart')
	          .outerHeight(window.innerHeight)
	          .css('display', 'flex')
	          .animate({opacity: 1}, 200);
	        scrollLock();
	      }
	    );
	  } else {
	    $(this).next().toggleClass('_show');
	  }
	  $(this).toggleClass('active');
	  $('.header-options-col').removeClass('_overflow_hidden');
	  $('.switch ').removeClass('_show b_arrow_up');
	  $('.header-row_bot').removeClass('search-form_show');
	  $('.header-comp-list').removeClass('_show');
	  $('.js-open-comp-list').removeClass('active');
	});
	
	//popup compare in header
	$(document).on('click', '.js-open-comp-list', function () {
	
	  $(this).next().toggleClass('_show');
	  $(this).toggleClass('active');
	  $('.header-ordering__icon_cart').removeClass('active');
	  $('.cart-m-popup').removeClass('_show');
	});
	
	//DEFAULT TOGGLE - HEIGHT
	$(document).on('click', '.js-toggle-h-prev', function () {
	  $(this).toggleClass('sidebar-item__arrow--arrow-up');
	  $(this).prev().toggleClass('toggle-prev-h-show');
	});
	//DEFAULT TOGGLE - VISIBLE
	$(document).on('click', '.js-toggle-v-next', function (e) {
	  if ($(e.target).closest(".check-color__label,.check-color__input").length == 0) {
	    $(this).next().toggleClass('toggle-prev-v-show');
	  }
	});
	
	/****** Изминение количества в инпуте */
	jQuery('.js-minus').click(function () {
	  var jQueryinput = jQuery(this).parent().find('input');
	  var count = parseInt(jQueryinput.val()) - 1;
	  count = count < 1 ? 1 : count;
	  jQueryinput.val(count);
	  jQueryinput.change();
	  return false;
	});
	jQuery('.js-plus').click(function () {
	  var jQueryinput = jQuery(this).parent().find('input');
	  jQueryinput.val(parseInt(jQueryinput.val()) + 1);
	  jQueryinput.change();
	  return false;
	});
	
	//CLICK body
	$('body').click(function (e) {
	  if ($(e.target).closest(".h-icon-button,.check-color-popup,.js-toggle-v-next,.s_select_box_value,.header-ordering__icon_cart,.cart-m-popup,.header-ordering__icon_search,.search-form,.js-toggle-show,.hidden-content_show,.js-toggle-sidebar,.sidebar-mob-content,.check-txt").length == 0) {
	    $('.header-ordering__icon_cart, .h-icon-button__icon').removeClass('active');
	    $('.switch').removeClass('_show b_arrow_up');
	    $('.cart-m-popup').removeClass('_show');
	    $('.header-options-col').removeClass('_overflow_hidden');
	    $('.header-row_bot').removeClass('search-form_show');
	    $('.hidden-content_hidden').removeClass('hidden-content_show');
	    $('.toggle-prev-v-show').removeClass('toggle-prev-v-show');
	    $('.js-toggle-show.js-toggle-show_menu').removeClass('close');
	    $('.header-ordering-col_call').css('display', 'block');
	    $('.header-comp-list').removeClass('_show');
	  }
	});
	
	//Скрывает и открывет кнопке показать больше, если контента больше
	//страница продукта, высота описания товара
	var heightSizeProduct = document.getElementById('js-product-size');
	var heightDescProduct = document.getElementById('js-height');
	
	//Высота содержимого блоков в сайтбаре на стр категорий
	var heightSidebarColors = document.getElementById('js-height-colors');
	var heightSidebarManufactured = document.getElementById('js-height-manufactured');
	var heightSidebarAtributes = document.getElementById('js-height-atributes');
	
	$(document).ready(function () {
	
	  /******* Блоки в сайтбаре на стр категорий */
	
	  //Фильтр цветов
	  if (heightSidebarColors) {
	    var heightBlockColor = heightSidebarColors.clientHeight;
	
	    if (heightBlockColor < 195) {
	      $('.sidebar-item__arrow--colors').css('display', 'none');
	    } else {
	      $('.sidebar-item__arrow--colors').css('display', 'block');
	    }
	    if (heightBlockColor < 2) {
	      $('.sidebar-item--colors').css('display', 'none');
	    }
	  }
	
	  //Фильтр производителей
	  if (heightSidebarManufactured) {
	    var heightBlockManufactured = heightSidebarManufactured.clientHeight;
	
	    if (heightBlockManufactured < 184) {
	      $('.filter-brands_checkbox').removeClass('sidebar-item-content--scroll');
	    }
	    if (heightBlockManufactured < 2) {
	      $('.sidebar-item--manufactured').css('display', 'none');
	    }
	  }
	
	  //Фильтр атрибутов
	  if (heightSidebarAtributes) {
	    var heightBlockAtributes = heightSidebarAtributes.clientHeight;
	
	    if (heightBlockAtributes < 184) {
	      $('.sidebar-item__arrow--atributes').css('display', 'none');
	    } else {
	      $('.sidebar-item__arrow--atributes').css('display', 'block');
	    }
	    if (heightBlockAtributes < 2) {
	      $('.sidebar-item--atributes').css('display', 'none');
	    }
	  }
	
	});
	
	
	// show main search in header
	function showMainSearch() {
	  var $mainSearch = $('.main-search');
	  var $input = $mainSearch.find('.main-search__input');
	  var $window = $(window);
	
	  $('.js-open-main-search').on('click', function () {
	    $('.main-search').addClass('is-visible');
	    $input.focus();
	    if ($window.width() <= 992) {
	      $('#overlay').fadeIn(150);
	      scrollLock();
	    }
	  });
	
	  $('.js-close-main-search').on('click', function () {
	    hide()
	  });
	
	  $('body').click(function (e) {
	    if ($(e.target).closest('.nav-with-search, .header-burgers-col--middle, .main-search').length === 0) {
	      hide()
	    }
	  });
	
	  function hide() {
	    if ($mainSearch.hasClass('is-visible')) {
	      $mainSearch.removeClass('is-visible');
	      $input.val('');
	      if ($window.width() <= 992) {
	        $('#overlay').fadeOut(150);
	        scrollUnlock();
	      }
	    }
	  }
	
	  function checkSize() {
	    if ($window.width() <= 992) {
	      $mainSearch.prependTo('body');
	    } else {
	      $mainSearch.prependTo('.nav-with-search');
	    }
	  }
	
	  checkSize();
	}
	
	showMainSearch();
	
	// фильтр городов и отображение на карте на странице магазины
	function showMap() {
	  let markers = [];
	  let $cityItems = $('.desc-accord-item');
	
	  function expandStoreInfo(id) {
	    collapseAllStores();
	    const parent = $cityItems.filter('[data-id="' + id + '"]');
	    parent.find('.js-toggle-slide').addClass('b_arrow_up');
	    parent.find('.js-toggle-cont').slideDown();
	  }
	
	  function collapseAllStores() {
	    $cityItems.find('.js-toggle-slide').removeClass('b_arrow_up');
	    $cityItems.find('.js-toggle-cont').slideUp();
	  }
	
	  function clearMarkers() {
	    if (markers.length > 0) {
	      for (let i = 0; i < markers.length; i++) {
	        markers[i].marker.setMap(null);
	      }
	      markers = [];
	    }
	  }
	
	  function addMarker(location, showInfo) {
	    const lat = parseFloat(location.coords.lat);
	    const lng = parseFloat(location.coords.lng);
	    const marker = new google.maps.Marker({
	      position: {lat: lat, lng: lng},
	      markerId: location.id,
	      map: shopsMap
	    });
	    const info = new google.maps.InfoWindow({
	      content: '<div class="p-2"><h1 class="text-danger mb-2">' + location.name + '</h1><h3>' + location.address + '</h3></div>'
	    });
	    if (showInfo) {
	      info.open(shopsMap, marker);
	    }
	    marker.addListener('click', function () {
	      for (let i = 0; i < markers.length; i++) {
	        markers[i].info.close(shopsMap, markers[i].marker);
	      }
	
	      expandStoreInfo(this.markerId);
	      info.open(shopsMap, this);
	    });
	    markers.push({
	      marker: marker,
	      info: info,
	      id: location.id
	    });
	  }
	
	  function zoomBounds() {
	    const bounds = new google.maps.LatLngBounds();
	    for (let i = 0; i < markers.length; i++) {
	      bounds.extend(markers[i].marker.position);
	    }
	    shopsMap.fitBounds(bounds);
	  }
	
	  function zoomMarker(center, zoom = 16) {
	    shopsMap.setCenter(center);
	    shopsMap.setZoom(zoom);
	  }
	
	  // отобразить магазин по нажатию на карте
	  $cityItems.on('click', function () {
	    const id = $(this).data('id');
	    const center = {
	      lat: parseFloat($(this).data('lat')),
	      lng: parseFloat($(this).data('lng'))
	    }
	
	    for (let i = 0; i < markers.length; i++) {
	      markers[i].info.close(shopsMap, markers[i].marker);
	    }
	
	    const marker = markers.find(function (item) {
	      return item.id === id;
	    });
	    marker.info.open(shopsMap, marker.marker);
	    zoomMarker(center);
	  });
	
	// центер карты берем из первого елемента
	  let center = {
	    lat: parseFloat($cityItems.first().data('lat')),
	    lng: parseFloat($cityItems.first().data('lng')),
	  }
	
	// создаем карту
	  let shopsMap = new google.maps.Map(document.getElementById('p-shops-map'), {
	    center: center,
	    zoom: 6
	  });
	
	  shopsMap.addListener('click', function () {
	    for (let i = 0; i < markers.length; i++) {
	      markers[i].info.close(shopsMap, markers[i].marker);
	    }
	    collapseAllStores();
	  });
	
	// отобразить все маркеры
	  function showAllMarkers() {
	    $cityItems.each(function (i, el) {
	      addMarker({
	        coords: {lat: $(el).data('lat'), lng: $(el).data('lng')},
	        address: $(el).data('address'),
	        name: $(el).data('name'),
	        id: $(el).data('id'),
	      });
	    });
	  }
	
	  showAllMarkers();
	
	// отобразить города по фильтру
	  $(document).on('click', '.js-city-select .option', function () {
	    let value = $(this).data('value');
	    const $visibleItems = $cityItems.filter('[title="' + value + '"]');
	
	    clearMarkers();
	    // отобразить все магазины
	    if (value === 'all') {
	      showAllMarkers();
	      zoomBounds();
	
	      $cityItems.show();
	      return;
	    }
	
	    // отобразить групу магазинов
	    $visibleItems.each(function (i, el) {
	      const pos = {
	        lat: parseFloat($(el).data('lat')),
	        lng: parseFloat($(el).data('lng'))
	      };
	      addMarker({
	        coords: pos,
	        address: $(el).data('address'),
	        name: $(el).data('name'),
	        id: $(el).data('id')
	      });
	      if ($visibleItems.length > 1) {
	        zoomBounds();
	      } else {
	        zoomMarker(pos);
	      }
	    });
	
	    $cityItems.hide();
	    $visibleItems.show();
	  });
	
	// раскрыть магазин если в url есть параметр
	  let storeId = location.hash.substr(1);
	  if (storeId) {
	    let $store = $('.desc-accord-item[data-id="' + storeId + '"]');
	    let id = $store.data('id');
	    $store.find('header').addClass('b_arrow_up');
	    $store.find('article').slideDown();
	    const pos = {
	      lat: parseFloat($store.data('lat')),
	      lng: parseFloat($store.data('lng'))
	    };
	    const marker = markers.find(function (item) {
	      return item.id === id;
	    });
	    marker.info.open(shopsMap, marker.marker);
	    zoomMarker(pos);
	  }
	}
	
	// если на странице есть карта то вызываем функцию
	if ($('#p-shops-map').length !== 0) {
	  showMap();
	}
	
	// blog nav slider
	$('.js-blog-nav').on('afterChange', function (e, slick) {
	}).slick({
	  rows: 0,
	  slidesToShow: 8,
	  draggable: false,
	  variableWidth: true,
	  infinite: false,
	  responsive: [
	    {
	      breakpoint: 576,
	      settings: {
	        slidesToShow: 3,
	      }
	    },
	    {
	      breakpoint: 768,
	      settings: {
	        slidesToShow: 6,
	      }
	    },
	  ]
	});
	
	// скопировать геолокацию
	$('.js-copy-location').on('click', function (e) {
	  const copyLocation = $(this).closest('.desc-accord-cont').find('.p-shop-location input');
	  copyLocation[0].select();
	  document.execCommand("copy");
	  copyLocation.blur();
	  notify(_tr('copy-loc'));
	});
	
	
	$('.select-1').select2({
	  minimumResultsForSearch: Infinity
	});
	
	$('.select-popup').select2({
	  minimumResultsForSearch: Infinity,
	  dropdownParent: $('.popup-shop'),
	});
	
	// select2 для полей "ЛИЧНЫЙ КАБИНЕТ: ОБЩИЕ ДАННЫЕ"
	$('.field-profileform-country select, .field-profileform-city select').select2();
	$('.modal-select.simple-filter')
	  .on('select2:open', function () {
	    $('.select2-search__field').attr('placeholder', _tr('search'));
	  })
	  .select2({
	    dropdownParent: $('.modal--quik-buy'),
	    language: {
	      noResults: function () {
	        return 'Результатов не найдено';
	      },
	    },
	    escapeMarkup: function (markup) {
	      return markup;
	    },
	  });
	// select2
	$('.modal-select:not(.simple-filter)')
	  .on('select2:open', function () {
	    $('.select2-search__field').attr('placeholder', _tr('search'));
	  })
	  .select2({
	    matcher: function (params, data) {
	      // If there are no search terms, return all of the data
	      if ($.trim(params.term) === '') {
	        return data;
	      }
	
	      // `params.term` should be the term that is used for searching
	      // `data.text` is the text that is displayed for the data object
	      if (data.text.toLowerCase().startsWith(params.term.toLowerCase())) {
	        return $.extend({}, data, true);
	      }
	
	      // Return `null` if the term should not be displayed
	      return null;
	    },
	    dropdownParent: $('.modal--quik-buy'),
	    language: {
	      noResults: function () {
	        return 'Результатов не найдено';
	      },
	    },
	    escapeMarkup: function (markup) {
	      return markup;
	    },
	  });
	
	// обрезать весь блок отзывов и показать по нажатию
	$('.js-show-more-reviews').on('click', function () {
	  $('.container-reviews').removeClass('reviews-short');
	  $(this).remove();
	});
	
	// бегущая строка по ховеру
	$('.journal-card__label').hover(
	  function () {
	    const boxWidth = $(this).width();
	    const $text = $(this).find('span');
	    const textWidth = $text.width();
	    const diff = textWidth - boxWidth;
	
	    if (diff > 5) {
	      $text.css('transform', 'translateX(-' + diff + 'px)');
	    }
	  },
	  function () {
	    const $text = $(this).find('span');
	    $text.css('transform', 'translateX(0)');
	  }
	);
	
	// slick карусель: тип 1. Можно использовать где угодно на всю ширину контейнера сайта
	$('.carousel-1').slick({
	  slidesToShow: 4,
	  sliderToScroll: 1,
	  // autoplay: 4000,
	  dots: false,
	  prevArrow: '<button type="button" class="slick_prev"></button>',
	  nextArrow: '<button type="button" class="slick_next"></button>',
	  rows: 0,
	  responsive: [
	    {
	      breakpoint: 1024,
	      settings: {
	        slidesToShow: 2,
	      }
	    }
	  ]
	});
	
	$('.carousel-1b').slick({
	  slidesToShow: 3,
	  sliderToScroll: 1,
	  autoplay: 4000,
	  dots: false,
	  prevArrow: '<button type="button" class="slick_prev"></button>',
	  nextArrow: '<button type="button" class="slick_next"></button>',
	  rows: 0,
	  responsive: [
	    {
	      breakpoint: 1024,
	      settings: {
	        slidesToShow: 2,
	      }
	    }
	  ]
	});
	
	$('.carousel-1c:not(.unslick)').slick({
	  slidesToShow: 4,
	  sliderToScroll: 1,
	  dots: false,
	  prevArrow: '<button type="button" class="slick_prev"></button>',
	  nextArrow: '<button type="button" class="slick_next"></button>',
	  rows: 0,
	  responsive: [
	    {
	      breakpoint: 1024,
	      settings: {
	        slidesToShow: 2,
	      }
	    }
	  ]
	});
	
	
	// отображение промо баннера
	function startPromoBanners() {
	
	  $('.js-popup-banner').each(function () {
	    const minutes = parseInt($(this).data('repeat-minutes')) || 5;
	    const cookieExpires = new Date(new Date().getTime() + minutes * 60 * 1000);
	    const $close = $(this).find('.js-close-banner');
	    const $popup = $(this);
	    const $banners = $(this).find('.promo-banner');
	    const bannersLength = $banners.length - 1;
	    let index = 0;
	    const duration = parseInt($(this).data('duration')) * 1000;
	    const timeout = parseInt($(this).data('timeout')) * 1000 || 3000;
	    let interval;
	
	    if (duration && $banners.length > 1) {
	      $banners.append('<div class="banner-indicator" style="animation-duration: ' + duration + 'ms"></div>');
	    }
	
	    setTimeout(function () {
	      $popup.show();
	      $banners.eq(0).css('display', 'flex');
	      if (duration && $banners.length > 1) {
	        interval = setInterval(function () {
	          index < bannersLength ? index++ : index = 0;
	          $banners.hide();
	          $banners.eq(index).css('display', 'flex').hide().fadeIn();
	        }, duration);
	      }
	    }, timeout);
	
	    // закрыть промо баннер
	
	    $close.on('click', function () {
	      $popup.remove();
	      clearInterval(interval);
	      $.cookie('promo-banner', 'hidden', {expires: cookieExpires});
	    });
	
	  });
	}
	
	if (!$.cookie('promo-banner')) {
	  startPromoBanners();
	}
	
	
	// фильтр магазинов в попапе резервирования
	$('.js-reserve-filter').on('change', function () {
	  const city = $(this).val();
	  console.log(city)
	  const $stores = $('.popup-shop-table').find('.reserve-store');
	  $stores.hide();
	  $stores.filter('[data-city="' + city + '"]').show();
	});
	
	// открыть корзину для редактирования на странице заказов
	$(document).on('click', '.js-edit-cart', function (e) {
	  e.preventDefault();
	
	  $('#overlay').fadeIn(200,
	    function () {
	      const $proceedShopping = $('.js-proceed-shopping');
	      $('.modal--cart')
	        .outerHeight(window.innerHeight)
	        .css('display', 'flex')
	        .animate({opacity: 1}, 200);
	      scrollLock();
	      // скрыть кнопку оформить заказ
	      $('.proceed-order').hide();
	      // изменить текст кнопки
	      $proceedShopping.text($proceedShopping.data('alt'));
	      // повесить класс для проверки
	      $('body').addClass('active-edit-cart');
	    }
	  );
	
	});
	
	
	// загружать по ховеру картинку в главном меню
	$('.header-cat-menu__item_sub').on('mouseenter', function () {
	  const img = $(this).find('.js-cat-menu-img-src');
	  const src = img.data('lazy');
	  if (img.attr('src')) {
	    return;
	  }
	  img.attr('src', src);
	  img.removeAttr('data-lazy');
	});
	
	
	$('.slider-2').slick({
	  dots: false,
	  prevArrow: '<button type="button" class="slick_prev"></button>',
	  nextArrow: '<button type="button" class="slick_next"></button>',
	  rows: 0,
	});
	
	$('.slider-3').slick({
	  dots: false,
	  autoplay: 4000,
	  prevArrow: '<button type="button" class="slick_prev"></button>',
	  nextArrow: '<button type="button" class="slick_next"></button>',
	  rows: 0,
	});
	
	// init magnific gallery
	$('.js-gallery').each(function () {
	  $(this).find('a').magnificPopup({
	    type: 'image',
	    removalDelay: 300,
	    mainClass: 'mfp-zoom-in',
	    gallery: {
	      enabled: true,
	      tCounter: ''
	    }
	  });
	});
	
	
	// show more reserved items on page /account/reserve
	$('.js-show-more-reserve').on('click', function () {
	  $('.account-reserve-items').toggleClass('short');
	  const altText = $(this).data('alt');
	  const text = $(this).text();
	  $(this).text(altText);
	  $(this).data('alt', text);
	});
	
	// show city input on page /account/account
	$('#profileform-countryid').on('change', function () {
	  if ($(this).val() !== '804') {
	    $('.js-account-city-ukraine').hide();
	    $('.js-account-city-others').show();
	  } else {
	    $('.js-account-city-ukraine').show();
	    $('.js-account-city-others').hide();
	  }
	}).trigger('change');
	
	// выбор подарка и его размера в карточке товара
	$(document).on('click', '.product-gifts__item', function (e) {
	  e.preventDefault();
	  const sizes = $(this).data('sizes');
	  const product_id = $(this).data('id');
	  const $oldButton = $('.js-product-add-cart-main');
	  const $sizesSwitch = modalSize.find('.sizes-switch');
	
	  // change button
	  $oldButton.after('<button class="btn btn--trans btn--lx js-confirm-gift-size"><span class="btn__inner">Выбрать</span></button>');
	  $oldButton.remove();
	
	  // show sizes
	  $sizesSwitch.empty();
	  $.each(sizes, function (k, v) {
	    let classString = 'sizes-switch__item sizes-switch__item--stock';
	    if (k === 0) {
	      classString += ' sizes-switch__item--active';
	    }
	    const $item = $('<div data-product-id="' + product_id + '" data-option-id="' + v.option_id + '" class="' + classString + '">' + v.name + '</div>');
	    $sizesSwitch.append($item);
	  });
	  $sizesSwitch.each(initSizeSwitch);
	
	  overlay.fadeIn(400,
	    function () {
	      $(modalSize)
	        .css('display', 'flex')
	        .animate({opacity: 1}, 200);
	    });
	  scrollLock();
	});
	
	$(document).on('click', '.js-confirm-gift-size', function () {
	
	  const $selected = modalSize.find('.sizes-switch__item--active');
	
	  if ($selected.length > 0) {
	    const $addToCartButton = $('.js-product-add-cart');
	    const product_id = $selected.data('product-id');
	    $addToCartButton.attr('data-gift-id', product_id);
	    $addToCartButton.attr('data-gift-option-id', $selected.data('option-id'));
	    $addToCartButton.attr('data-gift-option-name', $selected.text());
	
	    // fill input values for fast buy
	    $('#fastform-presentid').val(product_id);
	    $('#fastform-presentoptionid').val($selected.data('option-id'));
	    $('#fastform-presentoptionname').val($selected.text());
	
	    // highlight selected gift
	    $('.product-gifts__item').removeClass('active');
	    $('[data-id="' + product_id + '"]').addClass('active');
	
	    // remove validation error
	    $('.gift-error').remove();
	
	    // and close popup
	    modalSize
	      .animate({opacity: 0}, 200,
	        function () {
	          $(this).css('display', 'none');
	          overlay.fadeOut(400);
	        }
	      );
	    scrollUnlock()
	  }
	});
	
	// autocomplete form main search
	function searchAutocomplete() {
	  let debounce = null;
	  const $input = $('.main-search__input');
	  const $container = $('.search-autocomplete');
	
	  $input.on('input focus', function () {
	    const text = $(this).val().toLowerCase();
	    if (text.length > 2) {
	      clearTimeout(debounce);
	      debounce = setTimeout(function () {
	        $.get('/' + currentLang() + '/search-ajax', {text: text}, function (data) {
	          let html = '';
	          if (data.length > 0) {
	            $.each(data, function (k, v) {
	              const old_price = v.price_old !== '0' ? '<span class="price-2 line-through"><small>' + currencySign() + '</small> ' + v.price_old + '</span>' : '';
	              const title = v.name.toLowerCase().replace(text, '<span class="text-red">' + text + '</span>');
	              html += '<div class="row no-gutters"><a class="stretched-link" href="' + v.url + '"></a><div class="col-auto">' +
	                '<img src="' + v.image + '" alt="' + v.name + '"></div>' +
	                '<div class="col"><div>' + title + '</div><div>' +
	                '<span class="price-1 mr-2"><small>' + v.sign + '</small> ' + v.price + '</span>' +
	                old_price + '</div></div></div>';
	            });
	            $container.show();
	          }
	          $container.html(html);
	        });
	      }, 200);
	    } else {
	      $container.hide();
	    }
	  });
	}
	
	searchAutocomplete();
	
	// подписать пользователя на уведомления о наличии товара
	$(document).on('click', '.js-open-stock-subscribe', function () {
	  const email = $(this).data('email');
	  const $button = $(this);
	  const $currentItem = $(this).closest('.product-card').find('.slick-slide.slick-current .product-card__img-link');
	  const product_id = $currentItem.data('product-id') || $(this).data('product_id');
	
	  const onSuccess = function (res) {
	    const btnInner = $button.find('span.btn__inner');
	    if (res.subscription) {
	      $button.addClass('active');
	      $currentItem.attr('data-stock-subscribe', 1);
	      if (btnInner.length) {
	        btnInner.text(_tr('cancel-stock-sub'));
	      }
	    } else {
	      $button.removeClass('active');
	      $currentItem.attr('data-stock-subscribe', 0);
	      if (btnInner.length) {
	        btnInner.text(_tr('stock-sub'));
	      }
	    }
	  };
	
	  if (IS_LOGGED && email) {
	    subscribeStockWatch(product_id, email, onSuccess);
	    return;
	  }
	
	  openModal('.modal--subscribe');
	
	  $('#form-stock-watch').on('submit', function (e) {
	    e.preventDefault();
	    const email = $(this).find('input[name="email"]').val();
	    subscribeStockWatch(product_id, email, onSuccess);
	  });
	});
    var overlay = $('#overlay');
    
    $(document).on('click', '.js-toggle-sidebar', function() {
    
        if($(this).next().css('left') == '-331px') {
            $(this).next().css('left','-14px');
            overlay.fadeIn(400);
        } else {
            $(this).next().css('left','-331px');
            overlay.fadeOut(400);
        }
    
    });
    
    $(document).on('click', '#overlay', function() {
        $('.js-toggle-sidebar').next().css('left','-331px');
        overlay.fadeOut(400);
    });
    
    $(document).on('click', '.js-toggle-sidebar-close', function() {
        $('.js-toggle-sidebar').next().css('left','-331px');
        overlay.fadeOut(400);
    });
    $(document).width();
    
    $(document).ready(function () {
    
        if (heightDescProduct) {
    
            var heightBlock = heightDescProduct.clientHeight;
    
            if( heightBlock < 512 ) {
                $('.product-desc-but--show').css('display','none');
            } else {
                $('#js-height').addClass('_open');
                $('.product-desc-but--show').css('display','block');
                $('.product-desc-but--show').click(function () {
    
                    if($(this).css('display') == 'block') {
                        $('#js-height').removeClass('_open');
                        $(this).prev().css("max-height",'100%');
                        $(this).css('display','none');
                        $(this).next().css('display','block');
                    }
                });
            }
        }
    
        $('.product-desc-but--hidden').click(function () {
            if($(this).css('display') == 'block') {
                $('#js-height').addClass('_open');
                $(this).prev().prev().css("max-height",'512px');
                $(this).css('display','none');
                $(this).prev().css('display','block');
            }
        });
    
        //page product size
        if (heightSizeProduct) {
    
            let heightBlock = heightSizeProduct.clientHeight;
    
            if( heightBlock < 120 ) {
                $('.js-sizes-link-show').css('display','none');
            } else {
                $('.js-sizes-link-show').css('display','block');
                $('.js-sizes-link-show').click(function () {
                    if($(this).css('display') == 'block') {
                        $(this).prev().css("max-height",'100%');
                        $(this).prev().css("overflow",'visible');
                        $(this).css('display','none');
                        $(this).next().css('display','block');
                    }
                });
            }
    
        }
    
    
    
        $(document).on('click', '.js-open-modal-shop', function() {
    
            function pauseForPopapSizesHeight(){
    
                var heightPopupShopSize = document.getElementById('js-popup-shop-size-height');
    
                //Popup shop size
                if (heightPopupShopSize) {
    
                    var heightPopupShopSizes = heightPopupShopSize.clientHeight;
    
                    if( heightPopupShopSizes < 34 ) {
                        $('.js-popup-shop-size-but').css('display','none');
    
                    } else {
                        $('.js-popup-shop-size-but').css('display','block');
                    }
                }
            }
            setTimeout(pauseForPopapSizesHeight, 1000);
        });
    
        $(document).on('click', '.js-popup-shop-size-but', function () {
    
            $(this).toggleClass('_show');
    
            $(this).closest('.popup-shop-table-row--bot').prev().children('.popup-shop-table-size').css('height','auto');
    
            if( $(this).hasClass('_show') ) {
                $(this).text($(this).data('hide'));
    
            } else {
                $(this).text($(this).data('show'));
                $(this).closest('.popup-shop-table-row--bot').prev().children('.popup-shop-table-size').css('height','33');
            }
        });
    
    
    
        let productPageWight = $(window).outerWidth();
        if(productPageWight < 601) {
    
            $('.js-sizes-hidden').click(function () {
                if($(this).css('display') == 'block') {
                    $(this).prev().prev().css("max-height",'140px');
                    $(this).prev().prev().css("overflow",'hidden');
                    $(this).css('display','none');
                    $(this).prev().css('display','block');
                }
            });
    
        } else {
    
            $('.js-sizes-hidden').click(function () {
    
                if($(this).css('display') == 'block') {
    
                    $(this).prev().prev().css("max-height",'118px');
                    $(this).prev().prev().css("overflow",'hidden');
                    $(this).css('display','none');
                    $(this).prev().css('display','block');
                }
            });
        }
    
        //view other comments
        $(document).on('click', '.js-answers', function () {
    
            if($(this).closest('.product-reviews-bot').next().css('display') == 'none') {
                $(this).closest('.product-reviews-bot').next().slideDown( "fast", function() {});
            } else {
                $(this).closest('.product-reviews-bot').next().slideUp( "fast", function() {});
            }
        });
    });
    var num = $('.js-timer');
    for (var i = 0; i < num.length; i++) {
    	num.eq(i).countDown();
    }
    initRating();
    
    function initRating() {
    	let rating = document.querySelector('.js-rating');
    
    	// выходим если нет блока с рейтиногом
    	if (!rating) {
    		return false;
    	}
    
    	let stars = rating.querySelectorAll('.js-rating-star');
    	let input = rating.querySelector('.js-rating-input');
    
    	// Вешаем на все звезды событие
    	for (let i = 0; i < stars.length; i++) {
    		stars[i].addEventListener('click', function () {
    			// Меняем акивный класс
    			let active = rating.querySelector('.js-rating-star.is-active');
    			if (active) {
    				active.classList.remove('is-active');
    			}
    
    			this.classList.add('is-active');
    
    			// Меняем значение в инпуте
    			input.value = this.getAttribute('data-vote');
    			// console.log(input.value);
    		});
    	}
    }
    function initAccumulationProgress() {
    	// контейнер для графика накопительной скидки
    	let container = document.querySelector('.js-accumulation-progress');
    	if (!container) {
    		return false;
    	}
    	// Координаты контейнера для вычисления на сколько надо подвинуть ползунок
    	let rectContainer = container.getBoundingClientRect();
    
    	// Сколько потратил клиент в магазине - идет с бека
    	let totalMoney = container.getAttribute('data-total-money');
    	console.log(totalMoney);
    	// Активная линия
    	let progressLine = container.querySelector('.js-progress-line');
    
    	// Все уровни скидок
    	let accumulationPoint = container.querySelectorAll('.js-accumulation-point');
    
    	//активная скидка - порядковый номер
    	let currentAccumulationPoint;
    
    	// сколько потрачено для достижения текущего уровня и сколько до следующего
    	let startAccumulationPoint = 0;
    	let endAccumulationPoint;
    
    	// Скидка уже больше не будет - достигнут предел
    	if ( +totalMoney > getNumber(accumulationPoint[accumulationPoint.length - 1].getAttribute('data-money') ) ) {
    
    		// Закрашиваем пройденные уровни и текущий
    		for ( let i = 0; i < accumulationPoint.length; i++ ) {
    			accumulationPoint[i].classList.add('active');
    		}
    
    		//активная скидка - порядковый номер
    		currentAccumulationPoint = accumulationPoint.length;
    
    		// растояние от левого края до элемента - активного уровня скидки и контейнера
    		let rectAccumulationPoint = accumulationPoint[currentAccumulationPoint-1].getBoundingClientRect();
    		let rectContainer = container.getBoundingClientRect();
    
    		// ширина от левого края контейнера до активного уровня скидки
    		let left = rectAccumulationPoint.left - rectContainer.left;
    
    		// двигаем ползунок
    		progressLine.style.width = left + 'px';
    	}
    	// промежуточные уровни скидки
    	else {
    		for (let i = 0; i < accumulationPoint.length; i++) {
    			let accumulationPointMoney = getNumber(accumulationPoint[i].getAttribute('data-money'));
    
    			// если потрачено меньше уровня, то не зайдет в проверку,
    			// остануться данный предыдущего цикла с предыдущий уровня, он же и будет текущим
    			if ( +totalMoney < accumulationPointMoney  ) {
    				//активная скидка - порядковый номер
    				currentAccumulationPoint = i;
    
    				// Вычисляем рамки денежные между уровнями (текущим и следующим, где будем заполнять линию)
    				if ( i === 0 ) {
    					endAccumulationPoint = getNumber(accumulationPoint[i].getAttribute('data-money'));
    
    					// растояние от левого края до элемента - активного уровня скидки
    					let rectAccumulationPoint = accumulationPoint[currentAccumulationPoint].getBoundingClientRect();
    
    					// Полоска от 0 до первого уровня скидки
    					let widthStep = rectAccumulationPoint.left - rectContainer.left;
    
    					// Формула для вычисления на сколько надо подвинуть ползунок
    					let activeWidthStep = ( +totalMoney / (endAccumulationPoint / 100) ) * (widthStep / 100);
    
    					// двигаем ползунок
    					progressLine.style.width = activeWidthStep + 'px';
    
    				} else {
    					startAccumulationPoint = getNumber(accumulationPoint[i-1].getAttribute('data-money'));
    					endAccumulationPoint = getNumber(accumulationPoint[i].getAttribute('data-money'));
    
    					// Вычисляем на сколько надо подвинуть до текущего уровня
    					// растояние от левого края до элемента - активного уровня скидки
    					let rectAccumulationPoint = accumulationPoint[currentAccumulationPoint-1].getBoundingClientRect();
    					let widthToCurrentStep = rectAccumulationPoint.left - rectContainer.left;
    
    					// Сколько надо потратить денег, что бы пройти уровень
    					let maneyAccumulationPoint = endAccumulationPoint - startAccumulationPoint;
    
    					// полоска от текущего уровня до следующего
    					let rectAccumulationNextPoint = accumulationPoint[currentAccumulationPoint].getBoundingClientRect();
    					let widthToNextStep = rectAccumulationNextPoint.left - rectContainer.left;
    					let currentStepWidth = widthToNextStep - widthToCurrentStep;
    
    					// Формула для вычисления на сколько надо подвинуть ползунок
    					let activeWidthStep = ( ( +totalMoney - startAccumulationPoint ) / (maneyAccumulationPoint / 100) ) * (currentStepWidth / 100) + widthToCurrentStep;
    
    					// двигаем ползунок
    					progressLine.style.width = activeWidthStep + 'px';
    				}
    
    				break;
    
    			} else if ( +totalMoney === accumulationPointMoney ) {
    				//активная скидка - порядковый номер
    				currentAccumulationPoint = i+1;
    			}
    		}
    
    		// Закрашиваем пройденные уровни и текущий
    		for ( let i = 0; i < currentAccumulationPoint; i++ ) {
    			accumulationPoint[i].classList.add('active');
    		}
    	}
    
    	// Удаляет из строки не числа и возвращает число
    	function getNumber(num) {
    		return Number(num.replace(/[^0-9\.]+/g,""));
    	}
    }
    
    initAccumulationProgress();
    
    window.addEventListener('resize', initAccumulationProgress);
    // google.maps.event.addDomListener(window, 'load', init);
    // function init() {
    //     var mapOptions = {
    // // How zoomed in you want the map to start at (always required)
    //         zoom: 11,
    //
    // // The latitude and longitude to center the map (always required)
    //         center: new google.maps.LatLng(48.254861, 25.949917),
    //
    // // How you would like to style the map.
    // // This is where you would paste any style found on Snazzy Maps.
    //         styles: [
    //             {
    //                 "featureType": "administrative",
    //                 "elementType": "labels.text.fill",
    //                 "stylers": [
    //                     {
    //                         "color": "#444444"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "administrative.neighborhood",
    //                 "elementType": "geometry.fill",
    //                 "stylers": [
    //                     {
    //                         "visibility": "on"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "administrative.neighborhood",
    //                 "elementType": "labels.text.fill",
    //                 "stylers": [
    //                     {
    //                         "visibility": "on"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "landscape",
    //                 "elementType": "all",
    //                 "stylers": [
    //                     {
    //                         "color": "#f2f2f2"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "landscape.man_made",
    //                 "elementType": "geometry.fill",
    //                 "stylers": [
    //                     {
    //                         "visibility": "on"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "landscape.man_made",
    //                 "elementType": "labels.text.fill",
    //                 "stylers": [
    //                     {
    //                         "visibility": "on"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "poi",
    //                 "elementType": "all",
    //                 "stylers": [
    //                     {
    //                         "visibility": "off"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "poi.attraction",
    //                 "elementType": "geometry.fill",
    //                 "stylers": [
    //                     {
    //                         "visibility": "off"
    //                     },
    //                     {
    //                         "color": "#cb1010"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "poi.attraction",
    //                 "elementType": "labels.text.fill",
    //                 "stylers": [
    //                     {
    //                         "visibility": "off"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "poi.attraction",
    //                 "elementType": "labels.icon",
    //                 "stylers": [
    //                     {
    //                         "visibility": "off"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "poi.park",
    //                 "elementType": "geometry.fill",
    //                 "stylers": [
    //                     {
    //                         "visibility": "off"
    //                     },
    //                     {
    //                         "hue": "#00ff66"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "poi.park",
    //                 "elementType": "geometry.stroke",
    //                 "stylers": [
    //                     {
    //                         "visibility": "off"
    //                     },
    //                     {
    //                         "color": "#d81d1d"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "poi.park",
    //                 "elementType": "labels.text.fill",
    //                 "stylers": [
    //                     {
    //                         "visibility": "off"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "poi.park",
    //                 "elementType": "labels.icon",
    //                 "stylers": [
    //                     {
    //                         "visibility": "off"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "road",
    //                 "elementType": "all",
    //                 "stylers": [
    //                     {
    //                         "saturation": -100
    //                     },
    //                     {
    //                         "lightness": 45
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "road.highway",
    //                 "elementType": "all",
    //                 "stylers": [
    //                     {
    //                         "visibility": "simplified"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "road.arterial",
    //                 "elementType": "labels.icon",
    //                 "stylers": [
    //                     {
    //                         "visibility": "off"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "transit",
    //                 "elementType": "all",
    //                 "stylers": [
    //                     {
    //                         "visibility": "off"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "transit.line",
    //                 "elementType": "geometry.fill",
    //                 "stylers": [
    //                     {
    //                         "visibility": "off"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "transit.line",
    //                 "elementType": "labels.text.fill",
    //                 "stylers": [
    //                     {
    //                         "visibility": "off"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "transit.line",
    //                 "elementType": "labels.icon",
    //                 "stylers": [
    //                     {
    //                         "visibility": "on"
    //                     },
    //                     {
    //                         "color": "#d31818"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "transit.station.airport",
    //                 "elementType": "geometry.fill",
    //                 "stylers": [
    //                     {
    //                         "visibility": "on"
    //                     },
    //                     {
    //                         "color": "#2d014d"
    //                     },
    //                     {
    //                         "saturation": "29"
    //                     },
    //                     {
    //                         "lightness": "-3"
    //                     },
    //                     {
    //                         "weight": "6.14"
    //                     },
    //                     {
    //                         "gamma": "1.55"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "transit.station.airport",
    //                 "elementType": "geometry.stroke",
    //                 "stylers": [
    //                     {
    //                         "visibility": "off"
    //                     },
    //                     {
    //                         "weight": "6.72"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "transit.station.airport",
    //                 "elementType": "labels.text.fill",
    //                 "stylers": [
    //                     {
    //                         "visibility": "off"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "transit.station.airport",
    //                 "elementType": "labels.text.stroke",
    //                 "stylers": [
    //                     {
    //                         "visibility": "off"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "transit.station.airport",
    //                 "elementType": "labels.icon",
    //                 "stylers": [
    //                     {
    //                         "visibility": "on"
    //                     },
    //                     {
    //                         "gamma": "2.46"
    //                     },
    //                     {
    //                         "lightness": "-2"
    //                     },
    //                     {
    //                         "saturation": "100"
    //                     },
    //                     {
    //                         "hue": "#1800ff"
    //                     },
    //                     {
    //                         "weight": "6.43"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "water",
    //                 "elementType": "all",
    //                 "stylers": [
    //                     {
    //                         "color": "#46bcec"
    //                     },
    //                     {
    //                         "visibility": "on"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "water",
    //                 "elementType": "geometry.fill",
    //                 "stylers": [
    //                     {
    //                         "visibility": "on"
    //                     },
    //                     {
    //                         "color": "#b7e5f8"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "water",
    //                 "elementType": "labels.text.fill",
    //                 "stylers": [
    //                     {
    //                         "visibility": "off"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "water",
    //                 "elementType": "labels.text.stroke",
    //                 "stylers": [
    //                     {
    //                         "visibility": "on"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "water",
    //                 "elementType": "labels.icon",
    //                 "stylers": [
    //                     {
    //                         "visibility": "off"
    //                     }
    //                 ]
    //             }
    //         ]
    //
    //     };
    //
    //     var mapElement = document.getElementById('map2');
    //
    // // Create the Google Map using our element and options defined above
    //     var map = new google.maps.Map(mapElement, mapOptions);
    //
    // // Let's also add a marker while we're at it
    //     var marker = new google.maps.Marker({
    //         position: new google.maps.LatLng(48.254861, 25.949917),
    //         map: map,
    //         title: 'Мы тут!!',
    //         icon: '/img/map_point.png'
    //     });
    // }


    /*
	*   Страницы
	* */
    $(document).ready(function () {
    
      //Высота содержимого в описании на стр Брендов
      const $text = $('.js-height-brands-desc');
    
      //Высота описания на стр Брендов
      if ($text.length) {
        const heightBlock = $text.outerHeight();
    
        if (heightBlock < 140) {
          $('.js-brands-view-desc').hide();
        } else {
          $('.js-brands-view-desc').show();
        }
      }
    
    });
    
    //view sizes table
    $(document).on('click', '.js-brands-view-desc', function () {
    
      $(this).prev().toggleClass('brand-head__desc--show');
    
    });
    $('.p-compare-slider')
      .on('init', function () {
          $('.sizes-switch').each(initSizeSwitch);
          $('.product-card__body').each(function () {
              initProductCardSlider($(this), 6);
          });
      })
      .slick({
        centerMode: false,
        arrows: true,
        dots: false,
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 5000,
        prevArrow:'.p-compare-slider__arrow.p-compare-slider__arrow--prev',
        nextArrow:'.p-compare-slider__arrow.p-compare-slider__arrow--next',
        responsive:
            [
                {
                    breakpoint: 1365,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
    
    
    });
    
    //Функционал скролла стрелок
    $(window).on('scroll',function() {
    
        var arrow = $('.p-compare-slider__arrow');
    
        //Вычисляем расстояние от верха экрана до стрелок слайдера+ динамично измеряем положение стрелок
        if (arrow.length ) {
            var offsetTop = arrow.offset().top + $(window).scrollTop();
        }
    
        //Вычисляем расстояние от верха экрана, до блока - ЯКОРЯ
        var ancor = $('.js-ancor');
    
        if (ancor.length ) {
            var offsetAncor = ancor.offset().top;
        }
    
        //console.log(arrow,'Стрелка');
        //console.log(x,'Якорь'); 
    
        var cssValuesChange = {
            "position":"absolute",
            "top": offsetAncor - 480
        }
    
        var cssValuesDefault = {
            "position":"fixed",
            "top": "initial"
        }
    
        //Если высота стрелок равно или больше блока ancor и (минус высота хедера), то выполняем условие...
        if(offsetTop >= offsetAncor) {
    
            console.log('РАВНО');
    
            $('.js-arrow-compare').css(cssValuesChange);
    
        } else {
    
            $('.js-arrow-compare').css(cssValuesDefault);
    
        }
    
    });
    
    scroll()
    
    
    
    
    //Открываем часть скрытого текста, если его больше чем 5 строк
    $(document).ready(function () {
    
        var num = $('.p-compare-slider-col');
    
        for (var i = 0; i < num.length; i++) {
    
            //Блоки размеров
            $('.js-compare-height-sizes').eq(i).attr('id', 'js-compare-height-sizes-'+i);
    
            //Блоки цветов
            $('.js-compare-height-colors').eq(i).attr('id', 'js-compare-height-colors-'+i);
    
            //Текст ОПИСАНИЕ
            $('.js-compare-height-desc').eq(i).attr('id', 'js-compare-height-desc-'+i);
    
            //Текст ДОП. ИНФОРМАЦИЯ
            $('.js-compare-height-extra').eq(i).attr('id', 'js-compare-height-extra-'+i);
    
            //Текст ХАРАКТЕРИСТИК
            $('.js-compare-height-character').eq(i).attr('id', 'js-compare-height-character-'+i);
    
    
            //Высота содержимого в - РАЗМЕРАХ
            var heightCompareSizes = document.getElementById('js-compare-height-sizes-'+i);
    
            //Высота содержимого в - ЦВЕТАХ
            var heightCompareColors = document.getElementById('js-compare-height-colors-'+i);
    
            //Высота содержимого в - ОПИСАНИЕ
            var heightCompareDescriptions = document.getElementById('js-compare-height-desc-'+i);
    
            //Высота содержимого в - ХАРАКТЕРИСТИКАХ
            var heightCompareCharacteristic = document.getElementById('js-compare-height-character-'+i);
    
            //Высота содержимого в - ДОП. ИНФОРМАЦИЯ
            var heightCompareExtra = document.getElementById('js-compare-height-extra-'+i);
    
            //Высота ЦВЕТОВ
            if (heightCompareSizes) {
    
                //ОПИСАНИЕ
                var heightBlockCompareSize = heightCompareSizes.clientHeight;
    
                if( heightBlockCompareSize < 51 ) {
    
                    $(heightCompareSizes).closest('.p-compare-param-inner--sizes').next().css('opacity','0');
    
                } else {
    
                    $(heightCompareSizes).closest('.p-compare-param-inner--sizes').next().css('opacity','1');
    
                }
    
                if( heightBlockCompareSize < 2 ) {
    
                    $(heightCompareSizes).closest('.p-compare-param-inner--sizes').next().css('opacity','0');
    
                }
    
            }
    
            //Высота РАЗМЕРОВ
            if (heightCompareColors) {
    
                //ОПИСАНИЕ
                var heightBlockCompareColor = heightCompareColors.clientHeight;
    
                if( heightBlockCompareColor < 39 ) {
    
                    $(heightCompareColors).closest('.p-compare-param-inner--colors').next().css('opacity','0');
    
                } else {
    
                    $(heightCompareColors).closest('.p-compare-param-inner--colors').next().css('opacity','1');
    
                }
    
                if( heightBlockCompareColor < 2 ) {
    
                    $(heightCompareColors).closest('.p-compare-param-inner--colors').next().css('opacity','0');
    
                }
    
            }
    
            //Высота описания
            if (heightCompareDescriptions) {
    
                //ОПИСАНИЕ
                var heightBlockCompareDesc = heightCompareDescriptions.clientHeight;
    
                if( heightBlockCompareDesc < 114 ) {
    
                    $(heightCompareDescriptions).next().css('display','none');
    
                } else {
    
                    $(heightCompareDescriptions).next().css('display','flex');
    
                }
    
                if( heightBlockCompareDesc < 2 ) {
    
                    $(heightCompareDescriptions).next().css('display','none');
    
                }
    
            }
    
            if (heightCompareCharacteristic) {
    
                //ХАРАКТЕРИСТИКИ
                var heightBlockCompareChar = heightCompareCharacteristic.clientHeight;
    
                if( heightBlockCompareChar < 164 ) { 
    
                    $(heightCompareCharacteristic).parent().removeClass('_shadow');
    
                    $(heightCompareCharacteristic).next().css('display','none');
    
                } else {
    
                    $(heightCompareCharacteristic).parent().addClass('_shadow');
    
                    $(heightCompareCharacteristic).next().css('display','flex');
    
                }
    
                if( heightBlockCompareChar < 2 ) {
    
                    $(heightCompareCharacteristic).next().css('display','none');
    
                }
    
            }
    
            if (heightCompareExtra) {
    
                //ДОП. ИНФОРМАЦИЯ
                var heightBlockCompareExtra = heightCompareExtra.clientHeight;
    
                $('.js-compare-view-char-but').click(function () {
    
                });
    
                if( heightBlockCompareExtra < 114 ) {
    
                    $(heightCompareExtra).next().css('display','none');
    
                } else {
    
                    $(heightCompareExtra).next().css('display','flex');
    
                }
                if( heightBlockCompareExtra < 2 ) {
    
                    $(heightCompareExtra).next().css('display','none');
    
                }
            }
    
        }//for
    
        //Открыть дополнительные размеры
        $(document).on('click', '.js-compare-view-size-but', function () {
    
            $('.js-compare-view-size-but').prev().toggleClass('p-compare-options--show');
    
    
            //Подсчет самого длинного блока - ОПИСАНИЯ
            var maxHeight = Math.max.apply(null, $('.p-compare-slider-col .p-compare-param--sizes').map(function () {
                return this.clientHeight;
            }));
    
            //Добавляем высоту всем блокам ОПИСАНИЯ, как в самом длинном блоке
            if( $('.js-compare-view-size-but').prev().hasClass('p-compare-options--show') ) {
    
                $('.js-compare-view-size-but').text('Скрыть');
    
                $('.p-compare-slider-col .p-compare-param--sizes').css('height',maxHeight);
    
            } else {
    
                $('.js-compare-view-size-but').text('Показать все размеры');
    
                $('.p-compare-slider-col .p-compare-param--sizes').css('height', 'auto');
    
            }
    
        });
    
        //Открыть дополнительные размеры
        $(document).on('click', '.js-compare-view-color-but', function () {
    
            $('.js-compare-view-color-but').prev().toggleClass('p-compare-options--show');
    
    
            //Подсчет самого длинного блока - ОПИСАНИЯ
            var maxHeight = Math.max.apply(null, $('.p-compare-slider-col .p-compare-param--colors').map(function () {
                return this.clientHeight;
            }));
    
            //Добавляем высоту всем блокам ОПИСАНИЯ, как в самом длинном блоке
            if( $('.js-compare-view-color-but').prev().hasClass('p-compare-options--show') ) {
    
                $('.js-compare-view-color-but').text('Скрыть');
    
                $('.p-compare-slider-col .p-compare-param--colors').css('height',maxHeight);
    
            } else {
    
                $('.js-compare-view-color-but').text('Показать все цвета');
    
                $('.p-compare-slider-col .p-compare-param--colors').css('height', 'auto');
    
            }
    
        });
    
        //Открыть дополнительный текст в ОПИСАНИИ
        $(document).on('click', '.js-compare-view-desc-but', function () {
    
            $('.js-compare-view-desc-but').toggleClass('_transform');
            $('.js-compare-view-desc-but').closest('.p-compare-options-bot').parent().toggleClass('p-compare-options--show');
    
    
            //Подсчет самого длинного блока - ОПИСАНИЯ
            var maxHeight = Math.max.apply(null, $('.p-compare-slider-col #js-compare-option-desc-height').map(function () {
                return this.clientHeight;
            }));
    
            //Добавляем высоту всем блокам ОПИСАНИЯ, как в самом длинном блоке
            if( $('.js-compare-view-desc-but').closest('.p-compare-options-bot').parent().hasClass('p-compare-options--show') ) {
    
                $('.p-compare-slider-col #js-compare-option-desc-height').css('height',maxHeight);
    
            } else {
    
                $('.p-compare-slider-col #js-compare-option-desc-height').css('height', 'auto');
    
            }
    
        });
    
        //Открыть дополнительный блок ХАРАКТЕРИСТИК
        $(document).on('click', '.js-compare-view-char-but', function () {
    
            //var compareForShadowShow = $(this).closest('.p-compare-options-bot').prev().height();
    
            $('.js-compare-view-char-but').toggleClass('_transform');
    
            $('.js-compare-view-char-but').closest('.p-compare-options-bot').parent().toggleClass('p-compare-options-inner--show');
    
    
            //Подсчет самого длинного блока - ХАРАКТЕРИСТИК
            var maxHeightChar = Math.max.apply(null, $('.p-compare-slider-col .p-compare-options--character').map(function () {
                return this.clientHeight;
            }));
    
            //Добавляем высоту всем блокам ХАРАКТЕРИСТИКИ, как в самом длинном блоке
            if( $('.js-compare-view-char-but').closest('.p-compare-options-bot').parent().hasClass('p-compare-options-inner--show') ) {
    
                $('.p-compare-slider-col .p-compare-options--character').css('height',maxHeightChar);
    
                $('.js-compare-view-char-but').closest('.p-compare-options-bot').parent().removeClass('_shadow');
    
            } else {
    
                // if( compareForShadowShow > 164 ) {
                //
                //     $('.js-compare-view-char-but').closest('.p-compare-options-bot').parent().addClass('_shadow');
                //
                // }
    
                $('.js-compare-view-char-but').closest('.p-compare-options-bot').parent().addClass('_shadow');
    
                $('.p-compare-slider-col .p-compare-options--character').css('height', 'auto');
    
            }
    
        });
    
        //Открыть дополнительный текст в ДОП. ИНФОРМАЦИИ
        $(document).on('click', '.js-compare-view-extra-but', function () {
    
            $('.js-compare-view-extra-but').toggleClass('_transform');
            $('.js-compare-view-extra-but').closest('.p-compare-options-bot').parent().toggleClass('p-compare-options--show');
    
            //Подсчет самого длинного блока - ОПИСАНИЯ
            var maxHeightExtra = Math.max.apply(null, $('.p-compare-slider-col .p-compare-options--last').map(function () {
                return this.clientHeight;
    
            }));
            //console.log(maxHeightExtra);
            //Добавляем высоту всем блокам ОПИСАНИЯ, как в самом длинном блоке
            if( $('.js-compare-view-extra-but').closest('.p-compare-options-bot').parent().hasClass('p-compare-options--show') ) {
    
                $('.p-compare-slider-col .p-compare-options--last').css('height',maxHeightExtra);
                //console.log(maxHeightExtra);
            } else {
    
                $('.p-compare-slider-col .p-compare-options--last').css('height', 'auto');
                //console.log('noClass',maxHeightExtra);
    
            }
    
        });
    
    });
    


	var $heroSlider = $('.slider-main-wrap');
	var $heroSliderCurrent = $('.js-hero-slider-current');
	var $heroSliderTotal = $('.js-hero-slider-total');
	
	$heroSlider.on('init', function(event, slick) {
	    $heroSliderTotal.text('0' + slick.slideCount);
	});
	
	$heroSlider.slick({
	    arrows: true,
	    dots: false,
	    fade: true,
	    autoplay: true,
	    autoplaySpeed: 10000,
	    pauseOnFocus: false,
	    pauseOnHover: false,
	    slidesToShow: 1,
	    slidesToScroll: 1,
	    appendArrows:'.slider-arrows',
	    prevArrow:'.slider-arrow.slider-arrow__prev',
	    nextArrow:'.slider-arrow.slider-arrow__next'
	});
	
	$heroSlider.on('afterChange', function(event, slick, currentSlide){
	    $heroSliderCurrent.text(currentSlide + 1);
	});
	$('.brands-slider-wrap').slick({
	    centerMode: false,
	    arrows: true,
	    dots: false,
	    slidesToShow: 9,
	    slidesToScroll: 1,
	    autoplay: true,
	    autoplaySpeed: 5000,
	    appendArrows:'.brands-arrows',
	    prevArrow:'.brands-arrows__arrow.brands-arrows__arrow_prev',
	    nextArrow:'.brands-arrows__arrow.brands-arrows__arrow_next',
	    responsive:
	        [
	            {
	                breakpoint: 1367,
	                settings: {
	                    slidesToShow: 7
	                }
	            },
	            {
	                breakpoint: 1023,
	                settings: {
	                    slidesToShow: 4
	                }
	            },
	            {
	                breakpoint: 766,
	                settings: {
	                    slidesToShow: 2
	                }
	            }
	        ]
	});
	// Слайдер - "Вы смотрели товары"
	var sliderWatchedGoods = {
		slider: '.js-slider-watched-goods',
		slides: '.product-card-col',
		arrowPrev: '.js-slider-watched-goods-arrows .js-slider-arrows-prev',
		arrowNext: '.js-slider-watched-goods-arrows .js-slider-arrows-next',
		maxSlide: 4
	};
	initExtraSlider(sliderWatchedGoods);
	
	
	// Слайдер - "Покупатели так же смотрят"
	var sliderAlsoWatching = {
		slider: '.js-slider-also-watching',
		slides: '.product-card-col',
		arrowPrev: '.js-slider-also-watching-arrows .js-slider-arrows-prev',
		arrowNext: '.js-slider-also-watching-arrows .js-slider-arrows-next',
		maxSlide: 4
	};
	initExtraSlider(sliderAlsoWatching);
	
	//Слайдер личного кабинета, вкладка "Только для вас"
	var sliderOnlyForYou = {
		slider: '.js-slider-only-for-you',
		slides: '.product-card-col',
		arrowPrev: '.js-slider-only-for-you-arrows .js-slider-arrows-prev',
		arrowNext: '.js-slider-only-for-you-arrows .js-slider-arrows-next',
		maxSlide: 3
	};
	initExtraSlider(sliderOnlyForYou);
	
	
	var sliderOnlyForYouLook = {
		slider: '.js-slider-only-for-you-look',
		slides: '.product-card-col',
		arrowPrev: '.js-slider-only-for-you-look-arrows .js-slider-arrows-prev',
		arrowNext: '.js-slider-only-for-you-look-arrows .js-slider-arrows-next',
		maxSlide: 3
	};
	initExtraSlider(sliderOnlyForYouLook);
	
	
	
	// Слайдеры в табах,
	// начинаемсо второго nth-child, потому что первый элемент в выборке не слайдер
	var sliderTabs1 = {
		slider: '.js-tab-slider-wrap:nth-child(2) .js-tab-slider',
		slides: '.js-tab-slider-wrap:nth-child(2) .product-card-col',
		arrowPrev: '.js-tab-slider-wrap:nth-child(2) .js-tab-slider-prev',
		arrowNext: '.js-tab-slider-wrap:nth-child(2) .js-tab-slider-next',
		maxSlide: 4
	};
	initExtraSlider(sliderTabs1);
	
	var sliderTabs2 = {
		slider: '.js-tab-slider-wrap:nth-child(3) .js-tab-slider',
		slides: '.js-tab-slider-wrap:nth-child(3) .product-card-col',
		arrowPrev: '.js-tab-slider-wrap:nth-child(3) .js-tab-slider-prev',
		arrowNext: '.js-tab-slider-wrap:nth-child(3) .js-tab-slider-next',
		maxSlide: 4
	};
	initExtraSlider(sliderTabs2);
	
	var sliderTabs3 = {
		slider: '.js-tab-slider-wrap:nth-child(4) .js-tab-slider',
		slides: '.js-tab-slider-wrap:nth-child(4) .product-card-col',
		arrowPrev: '.js-tab-slider-wrap:nth-child(4) .js-tab-slider-prev',
		arrowNext: '.js-tab-slider-wrap:nth-child(4) .js-tab-slider-next',
		maxSlide: 4
	};
	initExtraSlider(sliderTabs3);
	
	
	var sliderTabs4 = {
		slider: '.js-tab-slider-wrap:nth-child(5) .js-tab-slider',
		slides: '.js-tab-slider-wrap:nth-child(5) .product-card-col',
		arrowPrev: '.js-tab-slider-wrap:nth-child(5) .js-tab-slider-prev',
		arrowNext: '.js-tab-slider-wrap:nth-child(5) .js-tab-slider-next',
		maxSlide: 4
	};
	
	initExtraSlider(sliderTabs4);
	
	
	function initExtraSlider(settings) {
		// слайдер и слайды
		var slider = document.querySelector(settings.slider);
		if (!slider) return false;
	
		var slide = slider.querySelectorAll(settings.slides);
	
		// стрелки
		var arrowPrev = document.querySelector(settings.arrowPrev);
		// дизейблим стрелку "предыдущий" слайд в начале
		arrowPrev.classList.add('is-disable');
		var arrowNext = document.querySelector(settings.arrowNext);
	
		// параметры для вычислений
		var numberActiveSlide;
		if (window.innerWidth > 1023) {
			numberActiveSlide = settings.maxSlide;
		} else {
			numberActiveSlide = 2;
		}
	
		var numberSlide = slide.length;
		var position = 0;
	
		arrowNext.addEventListener('click', function () {
	
			arrowPrev.classList.remove('is-disable');
	
			if ( position === (numberSlide - numberActiveSlide) ) {
				return false;
			}
	
			var translateX = getNumber(slider.style.transform);
			slider.style.transform = 'translateX(-' + (translateX + (slider.offsetWidth / numberActiveSlide)) + 'px)';
			position += 1;
	
			// добавляем некликабельность стрелке
			if ( position === (numberSlide - numberActiveSlide) ) {
				this.classList.add('is-disable');
			}
		});
	
		arrowPrev.addEventListener('click', function () {
	
			arrowNext.classList.remove('is-disable');
	
			if (position === 0) {
				return false;
			}
	
			var translateX = getNumber(slider.style.transform);
	
			slider.style.transform = 'translateX(-' + (translateX - (slider.offsetWidth / numberActiveSlide)) + 'px)';
			position -= 1;
	
			// добавляем некликабельность стрелке
			if (position === 0) {
				this.classList.add('is-disable');
			}
		});
	
		// вычисляем или нужны стрелки
		appendArrow();
		function appendArrow() {
			// показываем стрелки, а ниже опять их скрываем если надо
			arrowPrev.style.display = 'block';
			arrowNext.style.display = 'block';
	
			if (window.innerWidth > 1023) {
				if (slide.length <= settings.maxSlide) {
					arrowPrev.style.display = 'none';
					arrowNext.style.display = 'none';
				}
			} else {
				if (slide.length <= 2) {
					arrowPrev.style.display = 'none';
					arrowNext.style.display = 'none';
				}
			}
		}
	
	
		// перерисовка слайдера
		window.addEventListener('resize', function() {
			// перерисовываем с расчетом ширины новых карточек + на сколько карточек прокручено
			slider.style.transform = 'translateX(0px)';
			position = 0;
			arrowPrev.classList.add('is-disable');
			arrowNext.classList.remove('is-disable');
	
			//кол-во слайдов, смотрим в сss
			if (window.innerWidth > 1023) {
				numberActiveSlide = settings.maxSlide;
			} else {
				numberActiveSlide = 2;
			}
	
			// вычисляем или нужны стрелки при ресайзе
			appendArrow();
		});
	
		// свайп табов
		var eventTouch = null;
	
		slider.addEventListener('touchstart', function (e) {
			eventTouch = e;
	
			this.addEventListener('touchmove', listenAxis);
			function listenAxis(e) {
				if (eventTouch) {
					if (e.touches[0].pageX - eventTouch.touches[0].pageX < 0) {
						arrowNext.click();
					} else if (e.touches[0].pageX - eventTouch.touches[0].pageX > 0) {
						arrowPrev.click();
					}
				}
				this.removeEventListener('touchmove', listenAxis);
			}
	
			this.addEventListener('touchend', listenTouchend);
			function listenTouchend() {
				eventTouch = null;
				this.removeEventListener('touchend', listenTouchend);
			}
		});
	
		// для выделения числа из css свойства
		function getNumber(num) {
			return Number(num.replace(/[^0-9\.]+/g,""));
		}
	}
	$('.cat-slider-wrap').not('.slick-initialized').slick({
	    centerMode: false,
	    arrows: true,
	    dots: false,
	    slidesToShow: 8,
	    autoplay: false,
	    autoplaySpeed: 5000,
	    slidesToScroll: 1,
	    appendArrows:'.cat-slider-arrows',
	    prevArrow:'<div class="cat-slider-arrow cat-slider-arrow_prev" tabindex="0"></div>',
	    nextArrow:'<div class="cat-slider-arrow cat-slider-arrow_next" tabindex="0"></div>',
	    responsive:
	        [
	            {
	                breakpoint: 1025,
	                settings: {
	                    slidesToShow: 6
	                }
	            },
	            {
	                breakpoint: 769,
	                settings: {
	                    slidesToShow: 3
	                }
	            },
	            {
	                breakpoint: 376,
	                settings: {
	                    slidesToShow: 2
	                }
	            }
	        ]
	});
    if ($('.product-slider-thumbs-media--autonom').length < 2) {
      for (let i = $('.product-slider-thumbs-media--autonom').length; i < 2; i++)
    
        $('.product-slider-thumbs').addClass('_amount')
    }
    
    if ($('.product-slider-thumbs-media--autonom').length < 1) {
      for (let i = $('.product-slider-thumbs-media--autonom').length; i < 1; i++)
    
        $('.product-slider-thumbs').addClass('_full');
    }
    
    if ($('.product-slider-thumbs-media--item').length < 4) {
      for (let i = $('.product-slider-thumbs-media--item').length; i < 4; i++)
        $(".product-slider-thumbs-items").append("<div class='product-slider-thumbs-media product-slider-thumbs-media--item _disabled'><div class='product-slider-thumbs-inner'></div></div>");
    
      function sayHi() {
        $('.product-slider-thumbs-media--item._disabled').closest('.slick-slide').css('pointer-events', 'none');
      }
    
      setTimeout(sayHi, 2000);
    
    }
    
    if ($('.product-slider-thumbs-media--item').length <= 4) {
      $(".product-slider-arrows-wrap").css("display", "none");
    }
    
    
    $('.js-switch-product-images').on('click', function () {
    
      $(this).toggleClass('active');
    
      const mainImages = $('.product-slider-images:not(.product-alt-image), .product-slider-thumbs-items:not(.product-alt-thumbs)')
      const additionalImages = $('.product-alt-image, .product-alt-thumbs');
    
      if ($(this).hasClass('active')) {
        mainImages.hide().removeClass('active');
        additionalImages.show().addClass('active').slick('setPosition');
      } else {
        additionalImages.hide().removeClass('active');
        mainImages.show().addClass('active').slick('setPosition');
      }
      buildProductModalSlider($('.product-slider-images.active').find('.product-slider-images-media__img'));
    });
    
    function buildProductModalSlider($images) {
      $('.slider-popup').remove();
      const $close = $('<button type="button" class="close"aria-label="Close"><span aria-hidden="true">×</span></button>');
      const $arrowLeft = $('<button type="button" class="slick_prev"></button>');
      const $arrowRight = $('<button type="button" class="slick_next"></button>');
      const $modal = $('<div class="slider-popup"></div>');
      const title = $('.product__name.mob-hide-x1279').text();
      const $sliderContainer = $('<div class="product-modal-container"></div>')
      const $slider = $('<div class="product-modal-slider"></div>')
      const $thumbs = $('<div class="product-modal-thumbs"></div>')
      $images.clone().removeClass().appendTo($slider);
      $images.clone().removeClass().appendTo($thumbs);
      $modal.append($close);
      $modal.append('<div class="slider-popup__title">' + title + '</div>');
      $sliderContainer.append($slider);
      $sliderContainer.append($thumbs);
      $sliderContainer.appendTo($modal);
      $arrowLeft.appendTo($modal);
      $arrowRight.appendTo($modal);
      $modal.appendTo('body');
    
      // open modal
      $(document).on('click', '.product-slider-images-media', function () {
        const slideIndex = $(this).closest('.slick-slide').data('slick-index');
        overlay.fadeIn(300);
        $modal.css('display', 'flex');
        slickInit(slideIndex);
        scrollLock();
      });
    
      // close modal
      overlay.on('click', function () {
        $modal.hide();
        overlay.fadeOut(300);
        scrollUnlock();
      });
    
      $close.on('click', function () {
        $modal.hide();
        overlay.fadeOut(300);
        scrollUnlock();
      });
    
    
      function slickInit(slideIndex = 0) {
        $slider.not('.slick-initialized').slick({
          rows: 0,
          slidesToShow: 1,
          slidesToScroll: 1,
          asNavFor: $thumbs,
          dots: false,
          prevArrow: $arrowLeft,
          nextArrow: $arrowRight,
        });
        $thumbs.not('.slick-initialized').slick({
          rows: 0,
          asNavFor: $slider,
          arrows: false,
          dots: false,
          focusOnSelect: true,
          infinite: true,
          slidesToShow: 5,
          slidesToScroll: 1,
          responsive:
            [
              {
                breakpoint: 479,
                settings: {
                  slidesToShow: 3
                }
              }
            ]
        });
        setTimeout(function () {
          $slider.slick('slickGoTo', slideIndex, true);
        }, 50);
      }
    }
    
    buildProductModalSlider($('.product-slider-images.active').find('.product-slider-images-media__img'));
    
    $('.product-slider-images').not('.slick-initialized').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      fade: true,
      asNavFor: '.product-slider-thumbs-items',
      infinite: true,
      arrows: true,
      autoplay: 7000,
      dots: false,
      swipe: false,
      //appendArrows:'.product-slider-arrows',
      prevArrow: '<button type="button" class="slick_prev"></button>',
      nextArrow: '<button type="button" class="slick_next"></button>',
      responsive:
        [
          {
            breakpoint: 766,
            settings: {
              swipe: true
            }
          }
        ]
    });
    
    $('.product-slider-thumbs-items').not('.slick-initialized').slick({
      asNavFor: '.product-slider-images',
      arrows: false,
      dots: false,
      centerMode: false,
      focusOnSelect: true,
      infinite: true,
      slidesToShow: 4,
      slidesToScroll: 1,
      //variableWidth: true,
      responsive:
        [
          {
            breakpoint: 479,
            settings: {
              slidesToShow: 3
            }
          }
        ]
    });
    
    $('.js-video').click(function () {
      $('.product-slider-modal--video').show();
      $('.product-slider-modal--video-3d').hide();
    });
    
    $('.js-video-3d').click(function () {
      $('.product-slider-modal--video-3d').show();
      $('.product-slider-modal--video').hide();
    });
    
    $('body').on('click', '.product-slider-thumbs-media--item', function () {
      $('.product-slider-modal--video-3d, .product-slider-modal--video').hide();
    });
    
    $('.product-slider-thumbs-media--autonom').click(function () {
      $(this).addClass('slick-current');
    
      $(this).prev().removeClass('slick-current');
      $(this).next().removeClass('slick-current');
    
      $(this).parent().prev().find('.slick-current').removeClass('slick-current');
    });
    
    $('.product-slider-thumbs-items .slick-slide').click(function () {
      $(this).closest('.product-slider-thumbs-col--left').next().find('.slick-current').removeClass('slick-current');
    });
    
    var $heroSliderJournal = $('.js-slider-journal');
    var $heroSliderJournalThumbs = $('.js-slider-journal-thumbs');
    $heroSliderJournal.slick({
        asNavFor: '.js-slider-journal-thumbs',
        arrows: true,
        dots: false,
        fade: true,
        autoplay: true,
        autoplaySpeed: 5000,
        pauseOnFocus: false,
        pauseOnHover: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        appendArrows:'.slider-arrows',
        prevArrow:'.slider-arrow.slider-arrow__prev',
        nextArrow:'.slider-arrow.slider-arrow__next'
    });
    $heroSliderJournalThumbs.slick({
        asNavFor: '.js-slider-journal',
        arrows: false,
        dots: false,
        centerMode: false,
        focusOnSelect: true,
        infinite: true,
        vertical: true,
        slidesToShow: 3,
        slidesToScroll: 1
    });
    var $heroSliderAccountThumbs = $('.js-slider-account-thumbs');
    $heroSliderAccountThumbs.slick({
        arrows: true,
        dots: false,
        centerMode: false,
        focusOnSelect: true,
        infinite: false,
        slidesToShow: 8,
        slidesToScroll: 1,
        prevArrow:'.account-tabs-nav-but--prev',
        nextArrow:'.account-tabs-nav-but--next',
        responsive:
            [
                {
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 5
                    }
                },
                {
                    breakpoint: 599,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 400,
                    settings: {
                        slidesToShow: 2
                    }
                }
            ]
    });
    
    $('.js-slider-account-thumbs').on('afterChange', function (event, slick, currentSlide) {
    
        if(currentSlide === 0) {
            $('.account-tabs-nav-but--prev').removeClass('show');
            $('.account-tabs-nav-list').removeClass('_show');
        }
        else {
            $('.account-tabs-nav-but--prev').addClass('show');
            $('.account-tabs-nav-list').addClass('_show');
        }
    
    });
    
    $('.account-tabs-nav-but--prev,.account-tabs-nav-but--next').click(function () {
        $(this).closest('.account-tabs-nav').find('.slick-slide').removeClass('active');
    });
    
    $('.slick-current').addClass('active');
    var $heroSliderTableSize = $('.js-slider-table-size');
    $heroSliderTableSize.slick({
        arrows: true,
        dots: false,
        centerMode: false,
        focusOnSelect: true,
        infinite: false,
        slidesToShow: 6,
        slidesToScroll: 1,
        prevArrow:'.account-table-size-slider-but--prev',
        nextArrow:'.account-table-size-slider-but--next',
        responsive:
            [
                {
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 4
                    }
                }
            ]
    });
    var $heroSliderActions = $('.js-slider-action');
    var $heroSliderActionslThumbs = $('.js-slider-actions-thumbs');
    
    $heroSliderActions.slick({
        asNavFor: $heroSliderActionslThumbs,
        arrows: true,
        dots: false,
        fade: true,
        autoplay: 5000,
        autoplaySpeed: 10000,
        pauseOnFocus: false,
        pauseOnHover: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        appendArrows:'.slider-arrows',
        prevArrow:'.slider-arrow.slider-arrow__prev',
        nextArrow:'.slider-arrow.slider-arrow__next'
    });
    
    $heroSliderActionslThumbs.slick({
        asNavFor: $heroSliderActions,
        arrows: false,
        dots: false,
        fade: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        touchMove: false,
        swipe: false,
        draggable: false
    });


	
	
	//Модальное видео окно
	var btnOpenVideo = document.querySelectorAll('.js-video-modal-open');
	var btnCloseVideo = document.querySelector('.js-modal-video-close');
	
	//открытие видео
	if(btnOpenVideo.length) {
		(function () {
			for (var i = 0; i < btnOpenVideo.length; i++) {
				btnOpenVideo[i].addEventListener('click', function() {
					scrollLock();
					openVideo(this);
				});
			}
		})();
	}
	
	//закрытие по крестику
	if (btnCloseVideo) {
		btnCloseVideo.addEventListener('click', function() {
			scrollUnlock();
			closeVideo();
		});
	}
	
	
	document.addEventListener('mouseup', function (event) {
		var body = document.querySelector('body');
		var modalVideo = document.querySelector('.video-modal-window');
	
		// Закрываем модалку c видео если клик мимо
		if (body.classList.contains('modal-video-is-open')) {
			if (!modalVideo.contains(event.target)) {
				//запускаем прокрутку scroll-lock.js
				scrollUnlock();
				// Закрываем модалку и удаляем видео modal-video.js
				closeVideo();
			}
		}
	});
	
	function openVideo(currentTis) {
		var body = document.querySelector('body');
		var idVideo = currentTis.getAttribute('data-video-src');
		var videoFrame = document.querySelector('.js-modal-video-youtube');
		var query = '?rel=0&showinfo=0&autoplay=1';
		var srcVideo = "https://www.youtube.com/embed/" + idVideo + query;
	
		replaceTag(videoFrame, 'iframe');
	
		videoFrame = document.querySelector('.js-modal-video-youtube');
	
		body.classList.add('modal-video-is-open');
	
		if ( videoFrame.getAttribute('src') === '' ) {
			videoFrame.setAttribute('src', srcVideo);
		}
		else if ( videoFrame.getAttribute('src') === srcVideo ) {
			return false;
		}
		else if ( videoFrame.getAttribute('src') !== srcVideo ) {
			videoFrame.setAttribute('src', srcVideo);
		}
	}
	
	function closeVideo() {
		var body = document.querySelector('body');
		var videoFrame = document.querySelector('.js-modal-video-youtube');
		body.classList.remove('modal-video-is-open');
		body.setAttribute('style', '');
		videoFrame.setAttribute('src', '');
	}
	
	// переделываем div в iframe
	function replaceTag(element, newTagName) {
		// Создаём новый тэг.
		var newTag = document.createElement(newTagName);
	
		// Вставляем новый тэг перед старым.
		element.parentElement.insertBefore(newTag, element);
	
		// Переносим в новый тэг атрибуты старого с их значениями.
		for (var i = 0, attrs = element.attributes, count = attrs.length; i < count; ++i)
			newTag.setAttribute(attrs[i].name, attrs[i].value);
	
		// Переносим в новый тэг все дочерние элементы старого.
		var childNodes = element.childNodes;
		while (childNodes.length > 0)
			newTag.appendChild(childNodes[0]);
	
		// Удаляем старый тэг.
		element.parentElement.removeChild(element);
	}
    var open_modal = $('.js-open-modal-call');
    var close = $('.modal__close--call, #overlay');
    var modal = $('.modal--call');
    
    open_modal.click( function(event){
        event.preventDefault();
        var div = $(this).attr('href');
        overlay.fadeIn(400,
            function(){
                $(modal)
                    .css('display', 'flex')
                    .animate({opacity: 1}, 200);
                $('form.auxiliary_form').show().trigger('reset');
                $('.reserve-success-text').remove();
            });
        scrollLock()
    });
    close.click( function(){
        modal
            .animate({opacity: 0}, 200,
                function(){
                    $(this).css('display', 'none');
                    overlay.fadeOut(400);
                }
            );
        scrollUnlock()
    });
    
    $('.modal__close, #overlay').on('click', function () {
      $('.modal')
        .animate({opacity: 0}, 200,
          function(){
            $(this).css('display', 'none');
            overlay.fadeOut(400);
          }
        );
      scrollUnlock()
    });
    // var openModalSize = $('.js-open-modal-size');
    // var closeModalSize = $('.modal__close--size');
    var modalSize = $('.modal--size');
    
    $(document).on('click', '.js-open-modal-size', function (event) {
      event.preventDefault();
      const sizesImage = $(this).data('table_size');
      const $sizesSwitch = modalSize.find('.sizes-switch');
      const $button = modalSize.find('.js-popup-table-sizes-open');
    
      overlay.fadeIn(400,
        function () {
          $(modalSize).find('.js-popup-table-sizes').hide();
          $(modalSize).find('.modal-content--size').show();
          if (sizesImage) {
            $(modalSize).find('.modal-size-table__img').attr('src', sizesImage);
            $button.show();
          } else {
            $button.hide();
          }
          $(modalSize)
            .css('display', 'flex')
            .animate({opacity: 1}, 200);
        });
      $sizesSwitch.each(initSizeSwitch);
      scrollLock();
    });
    
    $(document).on('click', '.modal__close--size', function () {
      modalSize
        .animate({opacity: 0}, 200,
          function () {
            $(this).css('display', 'none');
            overlay.fadeOut(400);
          }
        );
    
      // $('.js-popup-table-sizes-open').closest('.modal-content--size').next().slideUp( "fast", function() {});
      scrollUnlock()
    });
    
    //view sizes table
    $(document).on('click', '.js-popup-table-sizes-open', function () {
    
      // if($('.js-popup-table-sizes').css('display') == 'none') {
      //     $(this).closest('.modal-content--size').next().slideDown( "fast", function() {});
      // } else {
      //     $(this).closest('.modal-content--size').next().slideUp( "fast", function() {});
      // }
      const $arrowBack = $('<button class="close-size-table">Вернуться к размерам</button>');
      const $sizes = $(this).closest('.modal-content--size');
      $sizes.hide();
      $sizes.next().show();
      if (!$('.close-size-table').length) {
        $sizes.next().prepend($arrowBack);
      }
    
    });
    
    $(document).on('click', '.close-size-table', function () {
      const $table = $(this).closest('.modal-size-table');
      $table.hide();
      $table.prev().show();
    });
    
    var openModalCart = $('.js-open-modal-cart');
    var modalCart = $('.modal--cart');
    var modalSize = $('.modal--size');
    const $body = $('body');
    
    openModalCart.click(function (event) {
      event.preventDefault();
    
      modalSize.css('display', 'none');
    
      overlay.fadeIn(400,
        function () {
          $(modalCart)
            .css('display', 'flex')
            .animate({opacity: 1}, 200);
        });
    
      scrollLock();
    });
    
    
    $(document).on('click', '.js-modal-close-cart, #overlay', function () {
      // добавить стобытия для закрытия модальной корзины
      if ($body.hasClass('active-edit-cart')) {
        const deliveryMethod = $('.js-delivery-method:checked').data('id');
        const $addressSelect = $('#couriernpform-city');
        const $officeSelect = $('#officenpform-city');
        const country = $('#deliveryform-country').val();
        const promoCode = $('.js-promo-data-input').val();
        const params = {
          country: country,
          token: promoCode
        };
    
        if (country !== 'УКРАИНА') {
          $(document).trigger('modal-cart-close', params);
        }
    
        // проверяем выбрана ли доставка по адресу
        if (deliveryMethod === 1) {
          if ($addressSelect.val() !== 'promt') {
            params.deliveryMethod = deliveryMethod;
            params.city = $addressSelect.val();
            $(document).trigger('modal-cart-close', params);
          }
        }
    
        // проверяем выбрана ли доставка в отделение
        if (deliveryMethod === 2) {
          if ($officeSelect.val() !== 'promt') {
            params.deliveryMethod = deliveryMethod;
            params.city = $officeSelect.val();
            $(document).trigger('modal-cart-close', params);
          }
        }
    
    
        //получение url взависимости от страны
        let url = getUrl(params['country']);
    
        //пересчет доставки
        recalculationCostDelivery(url, params);
    
    
        $body.removeClass('active-edit-cart');
    
      }
    
      modalCart
        .animate({opacity: 0}, 200,
          function () {
            $(this).css('display', 'none');
            overlay.fadeOut(400);
          }
        );
      modalSize
        .animate({opacity: 0}, 200,
          function () {
            $(this).css('display', 'none');
            overlay.fadeOut(400);
          }
        );
      scrollUnlock();
    });
    
    //пересчет доставки для украины
    /**
     * string url
     * object params{country deliveryId cityId}
     * */
    function recalculationCostDelivery(url, params)
    {
        //ajax
        $.ajax({
          method: "post",
          data: {
            params: params
          },
          url: url,
          dataType: 'json',
          'success': function (data) {
              let wrapperElement = $('.js-wrapper-order-cart');
              wrapperElement.empty();
              wrapperElement.append(data['view']);
            if (data.deliveryCost && data.deliveryCost !== 0) {
              $('.js-order-cost-office-np').text(data.deliveryCost);
              $('.js-order-cost-address').text(data.deliveryCost);
              $('#orderform-cost').val(data.deliveryCost);
            } else {
              $('#orderform-cost').val(data.hryvnia);
            }
    
    
              let euroNum = data['euroNum'];
    
            // TODO - ОЛЕГ: надо подставить еще конвертированную стоимость в евро
              // верстка уже готова, просто подставить данные в переменной euroNum с бека
              var euro = document.querySelector('.js-abroad-euro');
              var usd = document.querySelector('.js-abroad-usd');
              euro.textContent = "(" + euroNum + ")";
              usd.textContent = "(" + data['dollarNum'] + ")";
    
    
          },
          'error': function (response) {
          }
        });
    }
    
    function getUrl(country) {
      if (country === '804') {
        return '/' + currentLang() + '/nova-poshta/recalculation-cost';
      }
    
      return '/ukr-pochta/recalculation-price-int';
    }
    var openModalLogin = $('.js-open-modal-login');
    var openModalSignin = $('.js-open-modal-signin');
    var closeModalLogin = $('.modal__close--login, #overlay');
    var modalLogin = $('.modal--login');
    
    openModalLogin.on('click', function(event){
        event.preventDefault();
    
        // Топорно, нужно будет потом отрефакторить
        // Сдесь мы вызываем клик на первый таб для показа формы авторизации
        // Нужно из-за наличия двух кнопок - вход и регистрации
        // $('ul.s_tabs_list li:nth-child(1)').trigger('click');
    
        overlay.fadeIn(200,
            function(){
                $(modalLogin)
                    .css('display', 'block')
                    .animate({opacity: 1}, 200);
            });
        scrollLock();
    });
    
    openModalSignin.on('click', function(event){
        event.preventDefault();
    
        // Топорно, нужно будет потом отрефакторить
        // Сдесь мы вызываем клик на второй таб для показа формы регистрации
        // Нужно из-за наличия двух кнопок - вход и регистрации
        // $('ul.s_tabs_list li:nth-child(2)').trigger('click');
    
        overlay.fadeIn(200,
            function(){
                $(modalLogin)
                    .css('display', 'block')
                    .animate({opacity: 1}, 200);
            });
        scrollLock();
    });
    
    closeModalLogin.on('click', function(){
        modalLogin
            .animate({opacity: 0}, 200,
                function(){
                    $(this).css('display', 'none');
                    overlay.fadeOut(200);
                }
            );
        scrollUnlock();
    });
    
    //transform effect
    $('.js-link-transformed').on('click', function(){
        $(this).closest('.modal--login').toggleClass('transform');
    });
    $('.js-register-height-login').on('click', function(){
        $(this).closest('.modal--login').removeClass('modal-register-height');
    });
    $('.js-register-height-reg').on('click', function(){
        $(this).closest('.modal--login').addClass('modal-register-height');
    });
    var openModalShop = $('.js-open-modal-shop');
    var closeModalShop = $('.modal__close--shop, #overlay');
    var modalModalShop = $('.modal--shop');
    
    openModalShop.click(function (event) {
      event.preventDefault();
    
      // удаляем сообщение об успешном резервировании
      $('.reserve-success-text').remove();
      $('.popup-shop').show();
    
      // gift validation
      if (!isGiftSelected()) {
        return false;
      }
    
      // auth validation
      if (!IS_LOGGED) {
        openModal('.modal--login');
        return;
      }
    
    
      var div = $(this).attr('href');
      overlay.fadeIn(400,
        function () {
          $(modalModalShop)
            .css('display', 'flex')
            .animate({opacity: 1}, 200);
        });
      scrollLock();
    });
    closeModalShop.click(function () {
      modalModalShop
        .animate({opacity: 0}, 200,
          function () {
            $(this).css('display', 'none');
            overlay.fadeOut(400);
          }
        );
      scrollUnlock();
    });
    
    // $('.popup-shop-table').scroll(function(){
    //     var the_top = $('.popup-shop-table').scrollTop();
    //     if (the_top > 1) {
    //         $('.popup-shop-table').addClass('fixed');
    //     }
    //     else {
    //         $('.popup-shop-table').removeClass('fixed');
    //     }
    // });
    
    
    $('.modal__close--watch, #overlay').click(function () {
      $('.modal.modal--watch')
        .animate({opacity: 0}, 200,
          function () {
            $(this).css('display', 'none');
            overlay.fadeOut(400);
            $('.modal--watch').find('.text-success').remove();
          }
        );
      scrollUnlock();
    });
    
    // открыть модальное окно "следить за ценой и скидками"
    $('.js-modal-watch').on('click', function () {
      const productId = $('.page--product').data('product_id');
      const data = {product: productId};
    
      if ($(this).hasClass('watch-active')) {
        unfollowPriceRequest(data);
        return;
      }
      openModal('.modal--watch');
    
      if (!IS_LOGGED) {
        $('#follow-price').show();
      } else {
        followPriceRequest(data);
      }
    });
    
    $('#follow-price').on('submit', function (e) {
      e.preventDefault();
      const email = $(this).find('.input-1').val();
      const productId = $('.page--product').data('product_id');
      const data = {product: productId};
    
      if (!IS_LOGGED) {
        data.email = email;
      }
      followPriceRequest(data);
    });
    
    function followPriceRequest(data) {
      $.post('/' + currentLang() + '/price-watch/add', data, function (res) {
        $('.js-modal-watch').addClass('watch-active');
        $('.product-watches__txt').text(function () {
          $(this).text($(this).data('unset-text'));
        });
        if (!$('.follow-price-success').length) {
          $('#follow-price').after('<div class="follow-price-success">' + res.msg + '</div>');
        }
        if (!IS_LOGGED) {
          $('#follow-price').hide();
        }
      }).fail(function (err) {
        console.log(err);
        closeModal('.modal--watch');
      });
    }
    
    function unfollowPriceRequest(data) {
      $.post('/' + currentLang() + '/price-watch/delete', data, function (res) {
        $('.js-modal-watch').removeClass('watch-active');
        $('.product-watches__txt').text(function () {
          $(this).text($(this).data('set-text'));
        });
        notify(res.msg);
      }).fail(function (err) {
        console.log(err);
      });
    }
    var openModalQuikBuy = $('.js-open-modal-quik-buy');
    var closeModalQuikBuy = $('.modal__close--quik-buy, #overlay');
    var modalQuikBuy = $('.modal--quik-buy');
    
    openModalQuikBuy.click(function (event) {
      event.preventDefault();
      const $button = $(this);
      const is_compare = $button.closest('.p-compare-buttons').length;
      let productColor;
      let productName;
      let productSize;
    
    
      if (!isGiftSelected()) {
        return false;
      }
    
      var div = $(this).attr('href');
      overlay.fadeIn(400,
        function () {
          $(modalQuikBuy)
            .css('display', 'flex')
            .animate({opacity: 1}, 200);
          if (is_compare) {
            const $parent = $button.parents('.p-compare-slider-col-inner');
            productName = $parent.find('a.product-card__name-link').text();
            productColor = $parent.find('.product-colors__item._active img').attr('alt');
            productSize = $parent.find('.sizes-switch__item--active').text();
          } else {
            productColor = $('.product-colors__item._active img').attr('alt');
            productName = $('h1.product__name.mob-hide-x1279').text();
            productSize = $('.sizes-switch__item--active').text().slice(0, -1);
          }
          modalQuikBuy.find('h2').find('span').remove();
          modalQuikBuy.find('h2').append('<span class="text-danger">' + productName + ', ' + productColor + ', ' + productSize + '</span>');
          $fastformCitySelect = $('#fastform-city');
          if ($fastformCitySelect.val() !== 'promt') {
            $('#fastform-city').trigger('change');
          }
        });
      scrollLock()
    });
    closeModalQuikBuy.click(function () {
      modalQuikBuy
        .animate({opacity: 0}, 200,
          function () {
            $(this).css('display', 'none');
            overlay.fadeOut(400);
          }
        );
      scrollUnlock()
    });
    var openModalReview = $('.js-open-modal-review');
    var openModalReviewChild = $('.js-open-modal-review-child');
    var closeModalReview = $('.modal__close--review, #overlay');
    var modalReview = $('.modal--review');
    
    var modalReviewChild = $('.modal--review-child');
    
    openModalReview.on('click', function(){
        overlay.fadeIn(400,
            function(){
                $(modalReview)
                    .css('display', 'flex')
                    .animate({opacity: 1}, 200);
            });
        scrollLock();
    });
    
    openModalReviewChild.on('click', function(){
        overlay.fadeIn(400,
            function(){
                $(modalReviewChild)
                    .css('display', 'flex')
                    .animate({opacity: 1}, 200);
            });
        scrollLock();
    });
    closeModalReview.on('click', function(){
        modalReview
            .animate({opacity: 0}, 200,
                function(){
                    $(this).css('display', 'none');
                    overlay.fadeOut(400);
                }
            );
    
        modalReviewChild
            .animate({opacity: 0}, 200,
                function(){
                    $(this).css('display', 'none');
                    overlay.fadeOut(400);
                }
            );
    
    
        scrollUnlock();
    });
    var openModalShopVideo = $('.js-open-modal-shop-video');
    var closeModalShopVideo = $('.modal__close--shop-video, #overlay');
    var modalShopVideo = $('.modal--shop-video');
    
    openModalShopVideo.click( function(event){
        event.preventDefault();
        var div = $(this).attr('href');
        overlay.fadeIn(400,
            function(){
                $(modalShopVideo)
                    .css('display', 'flex')
                    .animate({opacity: 1}, 200);
            });
        scrollLock();
    });
    closeModalShopVideo.click( function(){
        modalShopVideo
            .animate({opacity: 0}, 200,
                function(){
                    $(this).css('display', 'none');
                    overlay.fadeOut(400);
                }
            );
        scrollUnlock();
    });
    
    var openModalShopVideo2 = $('.js-open-modal-shop-video2');
    var closeModalShopVideo2 = $('.modal__close--shop-video2, #overlay');
    var modalShopVideo2 = $('.modal--shop-video2');
    
    openModalShopVideo2.click( function(event){
        event.preventDefault();
        var div = $(this).attr('href');
        overlay.fadeIn(400,
            function(){
                $(modalShopVideo2)
                    .css('display', 'flex')
                    .animate({opacity: 1}, 200);
            });
        scrollLock();
    });
    closeModalShopVideo2.click( function(){
        modalShopVideo2
            .animate({opacity: 0}, 200,
                function(){
                    $(this).css('display', 'none');
                    overlay.fadeOut(400);
                }
            );
        scrollUnlock()
    });
    
    var openModalShopVideo3 = $('.js-open-modal-shop-video3');
    var closeModalShopVideo3 = $('.modal__close--shop-video3, #overlay');
    var modalShopVideo3 = $('.modal--shop-video3');
    
    openModalShopVideo3.click( function(event){
        event.preventDefault();
        var div = $(this).attr('href');
        overlay.fadeIn(400,
            function(){
                $(modalShopVideo3)
                    .css('display', 'flex')
                    .animate({opacity: 1}, 200);
            });
        scrollLock()
    });
    closeModalShopVideo3.click( function(){
        modalShopVideo3
            .animate({opacity: 0}, 200,
                function(){
                    $(this).css('display', 'none');
                    overlay.fadeOut(400);
                }
            );
        scrollUnlock()
    });
    var openModalMap = $('.js-open-modal-map');
    var closeModalMap = $('.modal__close--map, #overlay');
    var modalMap = $('.modal--map');
    
    openModalMap.click( function(event){
        event.preventDefault();
        var div = $(this).attr('href');
        overlay.fadeIn(400,
            function(){
                $(modalMap)
                    .css('display', 'flex')
                    .animate({opacity: 1}, 200);
            });
        scrollLock()
    });
    closeModalMap.click( function(){
        modalMap
            .animate({opacity: 0}, 200,
                function(){
                    $(this).css('display', 'none');
                    overlay.fadeOut(400);
                }
            );
        scrollUnlock()
    });
    var openModalImgSize = $('.js-open-modal-img-size');
    var closeModalImgSize = $('.modal__close--img-size, #overlay');
    var modalImgSize = $('.modal--img-size');
    
    openModalImgSize.click( function(event){
        event.preventDefault();
        var div = $(this).attr('href');
        overlay.fadeIn(400,
            function(){
                $(modalImgSize)
                    .css('display', 'flex')
                    .animate({opacity: 1}, 200);
            });
        //scrollLock()
    });
    closeModalImgSize.click( function(){
        modalImgSize
            .animate({opacity: 0}, 200,
                function(){
                    $(this).css('display', 'none');
                    overlay.fadeOut(400);
                }
            );
        //scrollUnlock()
    });
    var openModalPageVideos = $('.js-open-modal-page-videos');
    var closeModalPageVideos = $('.modal__close--page-videos, #overlay');
    var modalPageVideos = $('.modal--page-videos');
    
    openModalPageVideos.click( function(event){
        event.preventDefault();
        var div = $(this).attr('href');
        overlay.fadeIn(400,
            function(){
                $(modalPageVideos)
                    .css('display', 'flex')
                    .animate({opacity: 1}, 200);
            });
        scrollLock()
    });
    closeModalPageVideos.click( function(){
        modalPageVideos
            .animate({opacity: 0}, 200,
                function(){
                    $(this).css('display', 'none');
                    overlay.fadeOut(400);
                }
            );
        scrollUnlock()
    });


    initDropDownPhones();
    
    function initDropDownPhones() {
    	var dropDownPhones = document.querySelectorAll('.js-phones-dropdown');
    
    	if (dropDownPhones.length) {
    		for (var i = 0; i < dropDownPhones.length; i++) {
    			dropDownPhones[i].addEventListener('click', dropDown);
    		}
    	}
    
    	function dropDown() {
    		this.classList.toggle('is-open');
    	}
    }
    //Высота содержимого элементов фильтра
    var heightFilterCatItems = document.getElementById('js-height-filter-cat-items');
    
    if (heightFilterCatItems) {
    
        //ОПИСАНИЕ
        var heightBlockFilterCatItems = heightFilterCatItems.clientHeight;
    
        console.log(heightBlockFilterCatItems);
    
        if( heightBlockFilterCatItems < 291 ) {
    
            $(heightFilterCatItems).parent().css('height','auto');
    
            $(heightFilterCatItems).parent().next().css('display','none');
    
        } else {
    
            $(heightFilterCatItems).parent().next().css('display','flex');
    
        }
    
        if( heightBlockFilterCatItems < 2 ) {
    
            $(heightFilterCatItems).next().css('display','none');
    
        }
    
    }
    
    //Открыть дополнительный текст в ОПИСАНИИ
    $(document).on('click', '.js-filter-cat-but', function () {
    
        $('.js-filter-cat-but').toggleClass('filter-cat__arrow--transform');
        $('.js-filter-cat-but').prev().toggleClass('filter-cat-items--show');
    
    });

	/*
	*   Компоненты для форм
	* */
	initNiceSelect();
	
	function initNiceSelect() {
		var niceSelect = $('[data-nice-select]');
		var niceSelectClass = $('.js-nice-select');
	
		niceSelect.niceSelect();
		niceSelectClass.niceSelect();
	}
	// initHandleCounter();
	
	function initHandleCounter() {
		var $handleCounter = $('[data-handle-counter]');
		// var $handleButton = $('[data-handle-counter] button');
	
		for(var i = 0; i < $handleCounter.length; i++) {
			$handleCounter.eq(i).handleCounter({
				minimum: 1,
				maximize: 9999
			});
		}
	}
	initRequiredField();
	
	function initRequiredField() {
		var requiredInput = $('.field-input');
	
		for (var i = 0; i < requiredInput.length; i++) {
			checkValue(requiredInput.eq(i));
		}
	
		requiredInput.on('focus', function() {
			$(this).closest('.field ').find('.js-field-required').fadeOut(0);
			$(this).closest('.b-field ').find('.js-field-required').fadeOut(0);
		});
	
		requiredInput.on('blur', function() {
			var that = this;
			setTimeout(function () {
				checkValue(that);
			}, 50);
		});
		
		
		function checkValue(elem) {
			if ( $(elem).val() !== '' ) {
				$(elem).closest('.field ').find('.js-field-required').fadeOut(0);
				$(elem).closest('.b-field ').find('.js-field-required').fadeOut(0);
			}
			else {
				$(elem).closest('.field ').find('.js-field-required').fadeIn(0);
				$(elem).closest('.b-field ').find('.js-field-required').fadeIn(0);
			}
		}
	}
	// Документация по ренжу - https://refreshless.com/nouislider/
	// Небольшой туториал - https://www.youtube.com/watch?v=NSq3Yh2tVQM
	
	// elem.noUiSlider.on('change', function (values) {
	// 	console.log(values); // массив с значением из ренжа
	// 	console.log(elem.noUiSlider); // обьект с его методами - можно посмотреть какие есть
	// });
	
	// elem.noUiSlider.on('update', function (values, handle) {
	// 	someElem.innerHTML = parseInt(values[handle]);
	// });
	
	// console.log(elem.noUiSlider.get()); // метод - получает данные из ренжа
	
	
	// Ренж цены в каталоге
	// initFilterPriceRange();
	// function initFilterPriceRange() {
	// 	var filterPriceRange = document.querySelector('.js-filter-price');
	//
	// 	if ( filterPriceRange ) {
	// 		// Берем все настройки с data атрибутов, куда они попадают с админки
	// 		var valueMin = +filterPriceRange.getAttribute('data-value-min');
	// 		var valueMax = +filterPriceRange.getAttribute('data-value-max');
	// 		var step = +filterPriceRange.getAttribute('data-step');
	// 		var min = +filterPriceRange.getAttribute('data-min');
	// 		var max = +filterPriceRange.getAttribute('data-max');
	//
	// 		noUiSlider.create(filterPriceRange, {
	// 			start: [valueMin, valueMax],
	// 			connect: true,
	// 			range: {
	// 				'min': min,
	// 				'max': max
	// 			},
	// 			step: step
	// 		});
	//
	// 		var priceValues = [
	// 			document.querySelector('.js-filter-price-min'),
	// 			document.querySelector('.js-filter-price-max')
	// 		];
	//
	// 		filterPriceRange.noUiSlider.on('update', function (values, handle) {
	// 			priceValues[handle].innerHTML = parseInt(values[handle]);
	// 		});
	// 	}
	// }

	/*
	*   Файлы с бекенда
	* */
	function generateSizes(data, giftId, container) {
	  container.empty();
	  $.each(data, function (k, v) {
	    const $sizeButton = $('<div class="sizes-switch__item sizes-switch__item--stock"' +
	      ' data-option-id="' + v.option_id + '">' + v.name + '</div>')
	    $sizeButton.on('click', function () {
	      $('#gift-sizes .sizes-switch__item').removeClass('sizes-switch__item--active');
	      $(this).addClass('sizes-switch__item--active');
	      $('.js-product-add-cart-main')
	        .attr('data-option-id', v.option_id)
	        .attr('data-gift-name', v.name)
	        .attr('data-gift-id', giftId);
	    });
	    container.append($sizeButton);
	    if (k === 0) {
	      $sizeButton.trigger('click');
	    }
	  });
	}
	
	/* НАЧАЛО
	**==================== Добавление товара в корзину ====================*/
	
	// ответ сервера обновляем корзину
	function updateCart(data) {
	  let wrapperElement = $('.wrapper-popup-cart');
	  wrapperElement.empty();
	  wrapperElement.append(data['view']);
	
	  // Удаляем старую корзину и вставляем новую
	  $('.js-wrapper-header-cart').remove();
	  $('.header-cart').append(data['viewHeader']);
	
	
	  $('#overlay').fadeIn(400,
	    function () {
	      $('.modal--cart')
	        .outerHeight(window.innerHeight)
	        .css('display', 'flex')
	        .animate({opacity: 1}, 200);
	    }
	  );
	
	  initProductCounter();
	}
	
	// Добавление товара в корзину со страницы сравнения
	$('.js-compare-add-cart').on('click', function (e) {
	  // Удаляем класс для пустой корзины
	  $('.modal--cart').removeClass('cart-is-empty');
	
	  e.preventDefault();
	
	  let $productCard = $(this).parents('.p-compare-slider-col-inner');
	  let $option = $productCard.find('.sizes-switch__item--active');
	  let $selectedColor = $productCard.find('.product-colors__item._active');
	
	  let data = {
	    option: $option.data('option_id'),
	    optionName: $option.text(),
	    productColorImage: $selectedColor.find('img').attr('src'),
	    productId: $selectedColor.find('img').data('product-id'),
	    quantity: 1
	  };
	  $.ajax({
	    url: '/' + currentLang() + '/cart/add',
	    method: 'post',
	    data: data,
	    success: function (data) {
	      if (data['success'] === true) {
	        updateCart(data);
	      }
	
	      scrollLock();
	    }
	  });
	});
	
	// Добавление товара в корзину со страницы товара
	$('.js-product-add-cart').on('click', function (e) {
	
	  if (!isGiftSelected()) {
	    return false;
	  }
	
	  // Удаляем класс для пустой корзины
	  $('.modal--cart').removeClass('cart-is-empty');
	
	  e.preventDefault();
	  //get collection sizes
	  let sizeElements = $('.js-product-size');
	  let colorElements = $('.product-colors__item');
	  let optionId;
	  let optionName;
	  let productId;
	  let productColorImage;
	  let quantity = 1;
	
	
	  //present
	  let presentProductId = $(this).data('gift-id');
	  let presentOptionId = $(this).attr('data-gift-option-id');
	  let presentOptionName = '';
	  let sizeElementsPresent = $('.js-sizes-switch-present .sizes-switch__item');
	
	
	  $(".product-gifts__item ").each(function (row, element) {
	    let currentElement = $(element);
	    if (currentElement.hasClass('active')) {
	      presentProductId = currentElement.data('id');
	    }
	  });
	
	
	  sizeElements.each(function (index, value) {
	    let currentElement = $(value);
	    if (currentElement.hasClass('sizes-switch__item--active')) {
	      optionId = currentElement.data('option_id');
	      productId = currentElement.data('product_id');
	      optionName = currentElement.text();
	    }
	  });
	
	  sizeElementsPresent.each(function (index, value) {
	    let currentElement = $(value);
	    if (currentElement.hasClass('sizes-switch__item--active')) {
	      presentOptionName = currentElement.text();
	    }
	  });
	
	  colorElements.each(function (index, value) {
	    let currentElement = $(value);
	    if (currentElement.hasClass('_active')) {
	      let currentImgActive = currentElement.find('img');
	      productColorImage = currentImgActive.attr('src');
	    }
	  });
	
	
	  $.ajax({
	    url: '/' + currentLang() +'/cart/add',
	    method: 'post',
	    data: {
	      'productId': productId,
	      'quantity': quantity,
	      'option': optionId,
	      'optionName': optionName,
	      'productColorImage': productColorImage,
	      'presentOptionId': presentOptionId,
	      'presentOptionName': presentOptionName,
	      'presentProductId': presentProductId,
	      'languageId': currentLang()
	    },
	    success: function (data) {
	      if (data['success'] === true) {
	        updateCart(data);
	      }
	
	      scrollLock();
	    }
	  });
	});
	
	//Добавление товара в корзину не со страницы товара
	function initOpenModalSize() {
	
	  // Модалка с размерами
	  let modalSize = document.querySelector('.modal--size');
	
	  // Выходим, если нет модалки
	  if (!modalSize) {
	    return false;
	  }
	
	  // Клик по кнопке-иконке корзина на карточке товара
	  // ловим событие на документе, что бы ловить и элементы добавлены динамически
	  document.addEventListener('click', function (event) {
	    let target = event.target.closest('.js-open-modal-size');
	    if (!target) return false;
	
	    // Удаляем класс для пустой корзины
	    $('.modal--cart').removeClass('cart-is-empty');
	
	    // карточка товара
	    let productCard = target.closest('.product-card');
	
	    // Находим ссылку на товар с данными о товаре - размер и id
	    let productLink = productCard.querySelector('.js-product-card-img-slider .slick-current .product-card__img-link');
	
	    // Ссылка на изображение товара
	    let productImg = productCard.querySelector('.js-product-card-color-slider .slick-current img');
	    let productUrlImg;
	    if (productImg) {
	      productUrlImg = productImg.getAttribute('src');
	    } else {
	      productUrlImg = '/images/colors/000000002.jpg'
	    }
	
	    // ID товара
	    let productId = productLink.getAttribute('data-product-id');
	
	    // тут лежит JSON
	    let productSizeJson = productLink.getAttribute('data-sizes');
	
	    // массив с option_id (id размера) и name (наименование размера)
	    let productSizeArr = JSON.parse(productSizeJson);
	    if (!productSizeArr) return;
	
	    // Кнопка "Добавить в корзину"
	    let btnAddToCard = modalSize.querySelector('.js-product-add-cart-main');
	
	    // Контейнер где лежат кнопки выбора цвета в модалке
	    let sizeContainer = modalSize.querySelector('.sizes-switch');
	    sizeContainer.innerHTML = ''; // Очищаем
	
	    // Рисуем кнопка с выбором размера
	    for (let i = 0; i < productSizeArr.length; i++) {
	      // Создаем кнопку размера
	      let sizeButton = document.createElement('div');
	      const disabled = parseInt(productSizeArr[i].quantity) === 0;
	
	      // Задаем атрибут, что бы мжно было с клавиатуры переключать
	      sizeButton.setAttribute('tabindex', '0');
	
	      // Если кнопка первая, то задаем ей активный класс
	      if (i === 0) {
	        sizeButton.classList.add(
	          "sizes-switch__item",
	          "sizes-switch__item--stock",
	          "sizes-switch__item--active"
	        );
	      } else {
	        if (!disabled) {
	          sizeButton.classList.add(
	            "sizes-switch__item",
	            "sizes-switch__item--stock"
	          );
	        } else {
	          sizeButton.classList.add(
	            "sizes-switch__item",
	          );
	        }
	      }
	      // Передаем название размера в кнопку
	      sizeButton.textContent = productSizeArr[i].name;
	
	      // Передаем данные для дальнейших манипуляций
	      // 'option'
	      sizeButton.setAttribute('data-option-id', productSizeArr[i].option_id);
	      // 'optionName'
	      sizeButton.setAttribute('data-option-name', productSizeArr[i].name);
	
	      // Закидываем элемент в верстку
	      sizeContainer.append(sizeButton);
	
	      // Клик по кнопке выбора размера, что бы менять option и optionName
	      sizeButton.addEventListener('click', function () {
	        // 'option'
	        let option = this.getAttribute('data-option-id');
	        btnAddToCard.setAttribute('data-option-id', option);
	        // 'optionName'
	        let optionName = this.getAttribute('data-option-name');
	        btnAddToCard.setAttribute('data-option-name', optionName);
	      });
	    }
	
	    // Передаем в кнопку все параметры
	    // 'productId'
	    btnAddToCard.setAttribute('data-product-id', productId);
	    // 'quantity'
	    let quantity = 1;
	    btnAddToCard.setAttribute('data-quantity', quantity);
	    // 'option'
	    btnAddToCard.setAttribute('data-option-id', productSizeArr[0].option_id);
	    // 'optionName'
	    btnAddToCard.setAttribute('data-option-name', productSizeArr[0].name);
	    // 'productColorImage'
	    btnAddToCard.setAttribute('data-color-image-url', productUrlImg);
	
	    // делаем запрос на получение подароков товара и его размеров
	    $.ajax({
	      url: '/present/index',
	      data: {
	        id: productId
	      },
	      success: function (res) {
	        if (res.success && res.presents.length) {
	          $('#choose-gift').show();
	          $('#modal-gifts-select')
	            .on('change', function (e) {
	              const sizes = $.grep(res.presents, function (el) {
	                return el.id === +e.target.value
	              })[0].sizes;
	              generateSizes(sizes, e.target.value, $('#gift-sizes'));
	            })
	            .select2({
	              minimumResultsForSearch: Infinity,
	              dropdownParent: $('.modal--size'),
	              data: res.presents,
	              templateSelection: function (state) {
	                if (!state.id) {
	                  return state.text;
	                }
	                const $state = $(
	                  '<span class="select2-product"><img/><span></span></span>'
	                );
	                $state.find('span').text(state.text);
	                $state.find('img').attr('src', state.image);
	
	                return $state;
	              },
	              templateResult: function (state) {
	                if (!state.id) {
	                  return state.text;
	                }
	                const $state = $(
	                  '<span class="select2-product"><img src="' + state.image + '"/> ' + state.text + '</span>'
	                );
	                return $state;
	              }
	            })
	            .trigger('change');
	        } else {
	          $('#choose-gift').hide();
	        }
	      }
	    });
	
	
	  }, true);
	
	
	  // Кнопка "Добавить в корзину"
	  let btnAddToCard = modalSize.querySelector('.js-product-add-cart-main');
	  if (btnAddToCard) {
	    btnAddToCard.addEventListener('click', function () {
	
	      let productId = this.getAttribute('data-product-id');
	      let quantity = 1;
	      let optionId = this.getAttribute('data-option-id');
	      let optionName = this.getAttribute('data-option-name');
	      let productColorImage = this.getAttribute('data-color-image-url');
	      let giftOptionId = this.getAttribute('data-option-id');
	      let giftId = this.getAttribute('data-gift-id');
	      let presentOptionName = this.getAttribute('data-gift-name');
	
	      $.ajax({
	        url: '/' + currentLang() + '/cart/add',
	        method: 'post',
	        data: {
	          'productId': productId,
	          'quantity': quantity,
	          'option': optionId,
	          'optionName': optionName,
	          'productColorImage': productColorImage,
	          'presentProductId': giftId,
	          'presentOptionId': giftOptionId,
	          'presentOptionName': presentOptionName,
	          'languageId': currentLang()
	        },
	        success: function (data) {
	          if (data['success'] === true) {
	            $('.modal--size').attr('style', '');
	            updateCart(data);
	          }
	
	          scrollLock();
	        }
	      });
	    })
	  }
	}
	
	initOpenModalSize();
	/* Конец
	**==================== Добавление товара в корзину ====================*/
	
	
	/* НАЧАЛО
	**================== Удаление товара из корзины ====================*/
	// Удаление из корзины в хедере
	$(document).on('click', '.js-header-remove-product-cart', function () {
	  // Параметры для ajax запросы
	  let productId = $(this).data('product-id');
	  let optionId = $(this).data('option');
	
	  // Вычисляем обвертку корзины в хедере, а то их там сейчас 4 шт....
	  let $wrapperCards = $(this).closest('.js-wrapper-header-cart');
	
	  // Удаляем блок с товаром по клику
	  $(this).closest('.js-header-product-cart').remove();
	  $wrapperCards.find('[data-id="' + productId + '"][data-option="' + optionId + '"]').remove();
	
	  // Зайдет в блок если не осталось товаров в корзине - меняем html что бы показать, что корзина пуста
	  if (!$wrapperCards.find('.js-header-product-cart').length) {
	    let $cartPopup = $wrapperCards.find('.cart-m-popup');
	    let innerEmptyCart = '<div class="cart-m-popup-inner"></div><span class="cart__empty">Корзина пустая</span>';
	    $cartPopup.html(innerEmptyCart);
	  }
	
	
	  // Удаляем товар из корзины в открытой корзины на странице оформления
	  let $openCart = $('.js-product-cart');
	
	  // Удаляем блок с товаром по клику
	  $('.js-remove-product-cart[data-product-id="' + productId + '"]').closest('.js-cart-card').remove();
	
	  // Зайдет в блок если не осталось товаров в корзине - меняем html что бы показать, что корзина пуста
	  if (!$openCart.find('.js-remove-product-cart').length) {
	    // Добавляем в корзину надпись, если она пуста
	    let innerEmptyCart = '<div class="title-h2 title--red text-center mt-4">Ваша корзина пуста</div>';
	    $openCart.html(innerEmptyCart);
	    $openCart.css({
	      'display': 'flex',
	      'justify-content': 'center',
	      'align-items': 'center',
	      'overflow-y': 'hidden',
	      'padding-right': '0'
	    });
	  }
	
	  $.ajax({
	    url: '/cart/remove',
	    method: 'post',
	    data: {
	      'productId': productId,
	      'optionId': optionId
	    },
	    success: function (data) {
	      if (data['success'] === true) {
	        deleteProductCard(data);
	      }
	    }
	  });
	});
	
	// Удаление из попап корзины
	$(document).on('click', '.js-remove-product-cart', function () {
	  // Параметры для ajax запросы
	  let productId = $(this).data('product-id');
	  let optionId = $(this).data('option');
	
	  // Вычисляем обвертку корзины
	  let $wrapperCards = $(this).closest('.js-product-cart');
	  // удаляем все подарки товара
	  $(this).closest('.js-cart-card').nextAll('.product-cart-presents').remove();
	
	  // Удаляем блок с товаром по клику
	  $(this).closest('.js-cart-card').remove();
	  $wrapperCards.find('[data-id="' + productId + '"][data-option="' + optionId + '"]').remove();
	
	  // Зайдет в блок если не осталось товаров в корзине - меняем html что бы показать, что корзина пуста
	  if (!$wrapperCards.find('.js-cart-card').length) {
	
	    if (window.location.pathname === '/checkout/simplecheckout') {
	      window.location.replace('/');
	    }
	    // Добавляем в корзину надпись, если она пуста
	    let innerEmptyCart = '<div class="title-h2 title--red text-center mt-4">Ваша корзина пуста</div>';
	    $wrapperCards.html(innerEmptyCart);
	    $wrapperCards.css({
	      'display': 'flex',
	      'justify-content': 'center',
	      'align-items': 'center',
	      'overflow-y': 'hidden',
	      'padding-right': '0'
	    });
	
	    // Скрываем элементы
	    $('.modal--cart').addClass('cart-is-empty');
	  }
	
	
	  // Удаляем товар из корзины в хедере
	  $('.js-header-remove-product-cart[data-product-id="' + productId + '"]').closest('.js-header-product-cart').remove();
	  if (!$('.js-header-remove-product-cart').length) {
	    let $cartPopup = $('.js-wrapper-header-cart .cart-m-popup');
	    let innerEmptyCart = '<div class="cart-m-popup-inner"></div><span class="cart__empty">Корзина пустая</span>';
	    $cartPopup.html(innerEmptyCart);
	  }
	
	  $.ajax({
	    url: '/cart/remove',
	    method: 'post',
	    data: {
	      'productId': productId,
	      'optionId': optionId
	    },
	    success: function (data) {
	      if (data['success'] === true) {
	        deleteProductCard(data);
	      }
	    }
	  });
	});
	
	function deleteProductCard(data) {
	  // Меняем стоимость товаров в попап корзинке
	  $('.js-cart-popup-cost-total').text(data['total']);
	
	  // Если товаров 0, то не отображать 0 в хедере под иконкой корзины
	  if (+data['quantity'] === 0) {
	    $('.js-cart-quantity-items').text('');
	  } else {
	    $('.js-cart-quantity-items').text(data['quantity']);
	  }
	
	  // Меняем стоимость товаров - функционал не реализован на обычных страницах
	  $('.js-discount-money').text(data['discountMoney']);
	  // if ( data['discountPercent'] ) {
	  //     $('.js-discount-percent').text(data['discountPercent']);
	  // }
	}
	
	/* КОНЕЦ
	**================== Удаление товара из корзины ====================*/
	
	
	$('.js-delivery-method').on('change', function () {
	  let idPayment = $(this).data('id');
	});
	
	$('.js-promo-discount').on('click', function () {
	  let promo = $('.promo-form__input').val();
	
	  $.ajax({
	    url: '/' + currentLang() + '/checkout/promo',
	    method: 'post',
	    data: {
	      'promo': promo
	    },
	    success: function (data) {
	
	    }
	  });
	
	});
	
	
	/* НАЧАЛО
	* *=========== Функционал счетчика - каунтер товара ==========*/
	// 1. Запускаем плагин счетчика товара
	// 2. Вешаем доплнительно клик на кнопки для перерасчета товара
	initProductCounter();
	
	function initProductCounter() {
	
	  // 1. Запускаем плагин счетчика товара
	  var $handleCounter = $('[data-handle-counter]');
	  for (var i = 0; i < $handleCounter.length; i++) {
	    $handleCounter.eq(i).handleCounter({
	      minimum: 1,
	      maximize: 9999
	    });
	  }
	
	  // 2. Вешаем доплнительно клик на кнопки для перерасчета товара
	  var counters = document.querySelectorAll('.handle-counter');
	  if (!counters.length) {
	    return false;
	  }
	
	  for (let i = 0; i < counters.length; i++) {
	    let plusBtn = counters[i].querySelector('.counter-plus');
	    let minusBtn = counters[i].querySelector('.counter-minus');
	    let input = counters[i].querySelector('.js-change-quantity-product-cart');
	
	    if (plusBtn) {
	      plusBtn.addEventListener('click', function () {
	        const firstPresentCount = $(input).parents('.js-cart-card').next('.product-cart-presents').find('.item-count');
	        const stringQty = firstPresentCount.text();
	        let firstCount = extractNumberQty(stringQty);
	        firstCount++
	        firstPresentCount.text(updateStringQty(stringQty, firstCount));
	        changeQuantityProduct(input);
	      });
	    }
	
	    if (minusBtn) {
	      minusBtn.addEventListener('click', function () {
	        changeQuantityProduct(input);
	        const allNextPresents = $(input).parents('.js-cart-card').nextAll('.product-cart-presents');
	        const lastItem = allNextPresents.last();
	        const lastQty = lastItem.find('.item-count');
	        let lastCount = extractNumberQty(lastQty.text());
	        if (lastCount > 1) {
	          const text = lastQty.text();
	          lastCount--;
	          lastQty.text(updateStringQty(text, lastCount));
	        } else {
	          lastItem.remove();
	        }
	      });
	    }
	  }
	}
	
	// Изменения кол-ва товара при вводе в поле
	$(document).on('change', '.js-change-quantity-product-cart', function () {
	  changeQuantityProduct(this);
	});
	
	// Функция отправляет запрос для перерасчета стоимости и смены вьюхи
	// input - может бысть строка-селектор или Nod-элемент (нативная выборка)
	function changeQuantityProduct(input) {
	  let productId = $(input).data('product-id');
	  let optionId = $(input).data('option');
	  let quantity = $(input).val();
	
	
	  $.ajax({
	    url: '/cart/quantity',
	    method: 'post',
	    data: {
	      'productId': productId,
	      'quantity': quantity,
	      'optionId': optionId
	    },
	    success: function (data) {
	      if (data['success'] === true) {
	        const $costTotal = $('.js-cart-popup-cost-total');
	        const $delivery = $('.js-order-cart-delivery-cost');
	        visiblePortionPayment(data['total']);
	
	        if ($delivery.text() !== '') {
	          $costTotal.attr('data-cost', data['total']);
	          $costTotal.text(data['total'] + parseInt($delivery.text()));
	        } else {
	          $costTotal.attr('data-cost', data['total']);
	          $costTotal.text(data['total']);
	        }
	
	        $('.js-discount-money').text(data['discountMoney']);
	
	        // if ( data['discountPercent'] ) {
	        //     $('.js-discount-percent').text(data['discountPercent']);
	        // }
	      }
	    }
	  });
	}
	
	/* КОНЕЦ
	* *=========== Функционал счетчика - каунтер товара ==========*/
	/* НАЧАЛО
	* *===========Добавить товар в избранное по клику в карточке товара==========*/
	$(document).on('click', '.js-favorite', function () {
	
	  // Выходим если не залогинен, иначе кинет на 404
	  let isLogged = document.body.getAttribute('data-login');
	  isLogged = +isLogged;
	  if (!isLogged) {
	    // вызываем событие клика, что бы открыть модалку для регистрации
	    document.querySelector('.js-open-modal-login').click();
	    return false;
	  }
	
	  let $productImg = $(this).closest('.product-card').find('.js-product-card-img-slider .slick-current .product-card__img-link');
	  let id = $productImg.attr('data-product-id');
	
	  // Находим фото торавав карточке и меняем класс ему и сердечку
	  $productImg.toggleClass('is-favorite-selected');
	
	  // Товар не добавлен - добавляем
	  if ($productImg.hasClass('is-favorite-selected')) {
	    this.classList.add('is-favorite');
	
	    $.ajax({
	      url: '/wishlist/add/' + id,
	      method: 'get',
	      success: function (data) {
	        // Счетчик в хедере
	        counterFavorite();
	      }
	    });
	  }
	  // Товар уже добавлен - удаляем
	  else {
	    this.classList.remove('is-favorite');
	
	    $.ajax({
	      url: '/wishlist/delete',
	      method: 'post',
	      data: {
	        productsList: [id]
	      },
	      success: function (data) {
	        // Счетчик в хедере
	        counterFavorite();
	
	        // очистить на странице wishlist
	        let $container = $('.js-load-favorite-container');
	        $($container).find('[data-product-id="' + id + '"]').remove();
	        const itemsCount = $container.find('.product-card-col').length;
	        if (itemsCount === 0) {
	          showEmptyMessage();
	        }
	      }
	    });
	  }
	
	
	});
	/* КОНЕЦ
	* *===========Добавить товар в избранное по клику в карточке товара==========*/
	
	
	/* НАЧАЛО
	* *===========Смена цвета товара==========*/
	// Смена цвета товара
	// Всем добавленным в избранное товарам добавлен класс для фотографии товара 'is-favorite-selected'
	// После смены цвета смотрим на наличие этого класса и красим сердечко
	$(document).on('click', '.js-product-card-color', function () {
	  var $productImg = $(this).closest('.product-card').find('.js-product-card-img-slider .slick-current .product-card__img-link');
	  var $favoriteIcon = $(this).closest('.product-card').find('.js-favorite');
	
	  if ($productImg.hasClass('is-favorite-selected')) {
	    $favoriteIcon.addClass('is-favorite');
	  } else {
	    $favoriteIcon.removeClass('is-favorite');
	  }
	});
	/* КОНЕЦ
	* *===========Смена цвета товара==========*/
	
	
	/* НАЧАЛО
	* *===========Добавить товар в избранное по клику на странице товара==========*/
	$(document).on('click', '.js-product-favorite', function () {
	  // Выходим если не залогинен, иначе кинет на 404
	  let isLogged = document.body.getAttribute('data-login');
	  isLogged = +isLogged;
	  if (!isLogged) {
	    // вызываем событие клика, что бы открыть модалку для регистрации
	    document.querySelector('.js-open-modal-login').click();
	    return false;
	  }
	
	  let id = this.getAttribute('data-product-id');
	  let textFavoriteBtn;
	  let addedFavoriteAll = this.querySelector('.js-favorite-added-all');
	  let numberAddedFavoriteAll = addedFavoriteAll.textContent;
	
	  // Делаем проверку по классу, если его нет, то товар не добавлен в избранное
	  // Товар не добавлен еще - добавляем в избранное
	  if (!this.classList.contains('is-favorite')) {
	    this.classList.add('is-favorite');
	    textFavoriteBtn = this.querySelector('.product-watches__txt--big');
	    textFavoriteBtn.textContent = _tr('fav-added');
	    addedFavoriteAll.textContent = +numberAddedFavoriteAll + 1;
	
	    $.ajax({
	      url: '/wishlist/add/' + id,
	      method: 'get',
	      success: function (data) {
	        // console.log(data);
	        // Счетчик в хедере
	        counterFavorite();
	      }
	    });
	  }
	  // Товар уже добавлен - удаляем в избранное
	  else {
	    this.classList.remove('is-favorite');
	    textFavoriteBtn = this.querySelector('.product-watches__txt--big');
	    textFavoriteBtn.textContent = _tr('fav-add');
	    addedFavoriteAll.textContent = +numberAddedFavoriteAll - 1;
	
	    $.ajax({
	      url: '/wishlist/delete',
	      method: 'post',
	      data: {
	        productsList: [id]
	      },
	      success: function (data) {
	        // console.log(data);
	        // Счетчик в хедере
	        counterFavorite();
	      }
	    });
	  }
	
	});
	/* КОНЕЦ
	* *===========Добавить товар в избранное по клику на странице товара==========*/
	
	function showEmptyMessage() {
	  let $block = $('.account-col--right');
	
	  let layout = '<div class="favorite-empty">' +
	    '<p class="favorite-empty__title title-h2">Ваш список избранного пуст!</p>' +
	    '<p class="favorite-empty__subtitle title-h2">Выбрать товар можно в каталоге товаров:</p>' +
	    '<div class="favorite-empty__btn">' +
	    '<button class="btn btn--primary btn--primary-red btn--primary-medium">' +
	    '<a href="/categories" class="btn__inner title-h4 title--white">Каталог товаров</a>' +
	    '</button>' +
	    '</div>' +
	    '</div>';
	
	  $block.html(layout);
	}
	
	/* НАЧАЛО
	*=======================Очистить все избранное====================*/
	$('#clear-all-favorite').on('click', function () {
	  $.ajax({
	    url: '/wishlist/delete-all',
	    method: 'post',
	    success: function (data) {
	      // console.log(data);
	      showEmptyMessage();
	
	      // Счетчик в хедере
	      counterFavorite();
	    }
	  });
	});
	/* КОНЕЦ
	*=======================Очистить все избранное====================*/
	
	
	/* НАЧАЛО
	*==========Подгрузка карточек в кабинете по кнопке "ЕЩЕ"=========*/
	// кол-во карточек, которые загружаем изначально
	var offsetFavorite = 6;
	
	$('.js-load-favorite-btn').on('click', function () {
	  let _this = $(this);
	
	  // контейнер куда вставим карточки
	  var containerCard = $('.js-load-favorite-container');
	
	  // подгрузка карточек
	  $.ajax({
	    url: '/account/wishlist',
	    method: 'post',
	    data: {
	      'limit': 6,
	      'offset': offsetFavorite
	    },
	    success: function (data) {
	      // Увеличивае офсет, что бы не загружать те, что уже загружены
	      offsetFavorite += 6;
	
	      // вставляем новые карточки
	      containerCard.append(data);
	
	      // Инициализируем слайдер для карточек
	      // initProductCardSlider(7);
	
	      // кол-во уже загруженых карточек
	      let countCard = $('.product-card-col').length;
	
	      // тут лежит общее кол-во карточек в избранном
	      let totalCountCard = $('[data-total-count]').attr('data-total-count');
	
	      // удаляем кнопку, если нечего загружать
	      if (countCard >= totalCountCard) {
	        _this.remove();
	      }
	    }
	  });
	});
	/* КОНЕЦ
	*==========Подгрузка карточек в кабинете по кнопке "ЕЩЕ"=========*/
	
	
	/* НАЧАЛО
	*=======================Очистить выборочно избранное====================*/
	let deleteCheckedFavorites = document.querySelector('.js-delete-check-favorites');
	
	if (deleteCheckedFavorites) {
	  deleteCheckedFavorites.addEventListener('click', function () {
	    let checkInput = document.querySelectorAll('.js-check-favorite:checked');
	    // Количество карточке, которые подгружены на данный момент
	    let cards = document.querySelectorAll('.product-card-col');
	    console.log(cards.length);
	    // Для хранения массива с id товаров
	    let id = [];
	
	    // Количество удаленных карточек за раз
	    let countDeletedCards = 0;
	
	    for (let i = 0; i < checkInput.length; i++) {
	      let card = checkInput[i].closest('.product-card-col');
	      // Находим все выбранные товары
	      let fav = card.querySelectorAll('.is-favorite-selected');
	
	      // Если в карточке добавлено в избранное несколько товаров,
	      // то надо обойти все
	      if (fav.length) {
	        for (let i = 0; i < fav.length; i++) {
	          id.push(fav[i].getAttribute('data-product-id'));
	        }
	      }
	
	      countDeletedCards += 1;
	    }
	
	    // Удаление карточек из БД
	    $.ajax({
	      url: '/wishlist/delete',
	      method: 'post',
	      data: {
	        productsList: id
	      },
	      success: function (data) {
	        // console.log(data);
	
	        // тут лежит общее кол-во карточек в избранном
	        let $elemWithCounter = $('[data-total-count]');
	        let totalCountCard = $elemWithCounter.attr('data-total-count');
	
	        // Изменяем общее количество, что бы была синхронизация с загрузкой
	        $elemWithCounter.attr('data-total-count', +totalCountCard - countDeletedCards);
	
	        // Кнопка Подгрузить еще
	        let loadFavoriteBtn = $('.js-load-favorite-btn');
	
	        // контейнер куда вставим карточки
	        var containerCard = $('.js-load-favorite-container');
	
	        // подгрузка карточек
	        $.ajax({
	          url: '/account/wishlist',
	          method: 'post',
	          data: {
	            'limit': cards.length,
	            'offset': 0
	          },
	          success: function (data) {
	            // удаляем карточку из html
	            let length = cards.length;
	
	
	            // вставляем новые карточки
	            containerCard.prepend(data);
	
	            for (let i = 0; i < cards.length; i++) {
	              cards[i].remove();
	            }
	
	            // Инициализируем слайдер для карточек
	            initProductCardSlider(7);
	
	            // кол-во уже загруженых карточек
	            let countCard = $('.product-card-col').length;
	
	            // тут лежит общее кол-во карточек в избранном
	            let totalCountCard = $('[data-total-count]').attr('data-total-count');
	
	            // удаляем кнопку, если нечего загружать
	            if (countCard >= totalCountCard) {
	              loadFavoriteBtn.remove();
	            }
	
	            if (!countCard) {
	              let $block = $('.account-col--right');
	
	              let layout = '<div class="favorite-empty">' +
	                '<p class="favorite-empty__title title-h2">Ваш список избранного пуст!</p>' +
	                '<p class="favorite-empty__subtitle title-h2">Выбрать товар можно:</p>' +
	                '<div class="favorite-empty__btn">' +
	                '<button class="btn btn--primary btn--primary-red btn--primary-medium">' +
	                '<a href="/categories" class="btn__inner title-h4 title--white">Каталог товаров</a>' +
	                '</button>' +
	                '</div>' +
	                '</div>';
	
	              $block.html(layout);
	            }
	
	            // Изменяем данные счетчика в хедере
	            counterFavorite();
	          }
	        });
	      }
	    });
	  })
	}
	/* КОНЕЦ
	*=======================Очистить выборочно избранное====================*/
	
	
	/* НАЧАЛО
	*=========================ВОСПОМОГАТЕЛЬНЫЕ ФУНКЦИИ=======================*/
	
	// Изменять счетчик в хедере
	function counterFavorite() {
	  $.ajax({
	    url: '/wishlist/count',
	    method: 'get',
	    success: function (data) {
	      // console.log(data);
	
	      // кол-во добавленных товаров в избранное
	      let counter = data['result'];
	
	      // пока хедеров аж 3 шт, то пишу All
	      let headerIcon = document.querySelectorAll('.js-favorite-counter');
	
	
	      // 0 не надо писать в рахметке счетчика, по этому выходим из функции
	      if (counter === 0) {
	        for (let i = 0; i < headerIcon.length; i++) {
	          headerIcon[i].textContent = '';
	        }
	        return false;
	      }
	      // Вставляем значение счетчика
	      else {
	        for (let i = 0; i < headerIcon.length; i++) {
	          headerIcon[i].textContent = counter;
	        }
	      }
	    }
	  });
	}
	
	/* КОНЕЦ
	*=========================ВОСПОМОГАТЕЛЬНЫЕ ФУНКЦИИ=======================*/
	/* НАЧАЛО
	*=========================Поиск по кнопке=======================*/
	$('.js-search').on('click', function () {
	  search();
	});
	/* КОНЕЦ
	*=========================Поиск по кнопке=======================*/
	
	
	/* НАЧАЛО
	*=========================Поиск по enter=======================*/
	// Вешаем класс когда инпут в фокусе,
	// что бы по ентеру делать поиск
	let $searchInput = $('.js-main-search');
	
	$searchInput.on('focus', function () {
	  $(this).addClass('search-on-focus');
	});
	
	$searchInput.on('blur', function () {
	  $(this).removeClass('search-on-focus');
	});
	
	// Поиск по ентеру
	document.addEventListener('keydown', function (evt) {
	  evt = evt || window.event;
	  var isEnter = false;
	  var elemTrigger = document.querySelector('.search-on-focus');
	
	  if ("key" in evt) {
	    isEnter = (evt.key === "Enter");
	  } else {
	    isEnter = (evt.keyCode === 13);
	  }
	
	  if (isEnter && elemTrigger) {
	    search();
	  }
	});
	
	// вешаем событие закрытия меню на ESC
	document.addEventListener('keydown', function (evt) {
	  evt = evt || window.evt;
	  let isEscape = false;
	
	  if ("key" in evt) {
	    isEscape = (evt.key === "Escape" || evt.key === "Esc");
	  } else {
	    isEscape = (evt.keyCode === 27);
	  }
	
	  if (isEscape) {
	    $('.main-search').removeClass('is-visible');
	  }
	});
	/* КОНЕЦ
	*=========================Поиск по enter=======================*/
	
	
	/* НАЧАЛО
	*============Подгрузка карточек на странице поиска=============*/
	// кол-во карточек, которые загружаем изначально
	var offsetSearch = 12;
	
	$('.js-more-search-btn').on('click', function () {
	  let _this = $(this);
	
	  // контейнер куда вставим карточки
	  var searchText = $(this).attr('data-search-text');
	
	  // контейнер куда вставим карточки
	  var containerCard = $('.js-more-search-container');
	
	  // подгрузка карточек
	  $.ajax({
	    url: '/' + currentLang() + '/search-more/get-more-product',
	    method: 'post',
	    data: {
	      'limit': 12,
	      'offset': offsetSearch,
	      'text': searchText
	    },
	    success: function (data) {
	      // Увеличивае офсет, что бы не загружать те, что уже загружены
	      offsetSearch += 12;
	
	      // вставляем новые карточки
	      containerCard.append(data);
	
	      // Инициализируем слайдер для карточек
	      initProductCardSlider(7);
	
	      // кол-во уже загруженых карточек
	      let countCard = $('.product-card-col').length;
	
	      // тут лежит общее кол-во карточек в избранном
	      let totalCountCard = $('[data-cards-count]').attr('data-cards-count');
	
	      // удаляем кнопку, если нечего загружать
	      if (countCard >= totalCountCard) {
	        _this.remove();
	      }
	    }
	  });
	});
	/* КОНЕЦ
	*============Подгрузка карточек на странице поиска=============*/
	
	
	/* НАЧАЛО
	*=========================ВОСПОМОГАТЕЛЬНЫЕ ФУНКЦИИ=======================*/
	
	// Поиск
	function search() {
	  let inputData = $('.js-search-input').val();
	  if (inputData.trim() === '' || inputData.length < 3) {
	    return;
	  }
	  location.href = '/search/' + inputData;
	}
	
	/* КОНЕЦ
	*=========================ВОСПОМОГАТЕЛЬНЫЕ ФУНКЦИИ=======================*/
	// Product detail comment - for COMMIT
	initProductReview();
	
	function initProductReview() {
		// Если отзыв на отзыв, то подставляем id отзыва
		let reviewId = '';
		let productId;
	
		// модалка
		var $modalReview = $('.modal--review');
	
		// форма в модалке
		var $modalReviewForm = $('.js-product-review-form');
	
		// Поле для вывода ошибки
		var $errorMessage = $('.js-error-message');
	
		// Поля формы
		let $textField = $('.js-product-review-form textarea[name="comment"]');
		let $nameField = $('.js-product-review-form input[name="name"]');
		let $phoneField = $('.js-product-review-form input[name="phone"]');
		let $rating = $('.js-product-review-form .js-rating-input');
	
		if ($phoneField[0]) {
			$phoneField[0].addEventListener('keyup', function(){
				// валидируем добавление букв, при добавлении сразу удаляем добавленый
				this.value = this.value.replace(/[A-Za-zА-Яа-яЁё]/, '');
			});
		}
	
	
	
		// Открываем модалку отзыв на отзыв
		$(document).on('click', '.answer_review', function () {
			$('.js-rating').addClass('no-validation');
	
			// подставляем id отзыва
			reviewId = $(this).data('review_id');
			// подставляем id товара
			productId = $(this).data('product_id');
			resetRating();
			resetFieldsValue();
			deleteErrorMessages();
		});
	
		// ткрываем модалку отзыв на товар
		$(document).on('click', '.send__review', function () {
			$('.js-rating').removeClass('no-validation');
	
			reviewId = '';
			resetRating();
			resetFieldsValue();
			deleteErrorMessages();
		});
	
	    var sendFlag = false;
		// отправляем отзыв - любой
		$(document).on('click', '.js-send-product-review', function () {
			deleteErrorMessages();
	
			// Данные для отправки формы
			let text = $textField.val();
			let name = $nameField.val();
	
			// Если это отзыв на отзыв, то не надо ставить рейтинг,
			// по этому задаем значение по умолчанию
			let rating;
			if ( $('.js-rating').hasClass('no-validation') ) {
				rating = 'no-validation';
			} else {
				rating = $rating.val();
			}
	
	
			// Валидация
			if (!name || !text || !rating) {
	
				let errorEmptyFields = $modalReviewForm.attr('data-empty-fields');
				let errorRatingFields = $modalReviewForm.attr('data-rating-field');
				$errorMessage.html( errorEmptyFields );
	
				if (!name) {
					$nameField.addClass('has-error');
				}
	
				if (!text) {
					$textField.addClass('has-error');
				}
	
				if (name && text && !rating) {
					$errorMessage.html( errorRatingFields );
				}
	
				return false;
			}
	
			var data = {
				"_csrf-frontend": csrfToken,
				product_id: $('.page--product').data('product_id') || productId,
				author: name,
				text: text,
				vote: rating
			};
	
			// Если reviewId не пустое, то это отзыв на отзыв и
			// передаем id отзыва
			if (reviewId !== '') {
				data.answer_review_id = reviewId;
			}
	
	        // Ставим флаг что-бы повторно не отправить
	        if (sendFlag == false) {
	        	sendFlag = true;
	        } else {
	        	return;
	        }
			$.ajax({
				type: 'POST',
				url: "/products/set-review",
				data: data
			}).done(function (response) {
				// закрываем мдалку и востанавливаем прокрутку сайта
				// $modalReview.animate({opacity: 0}, 200,
				// 	function(){
				// 		$(this).css('display', 'none');
				// 		overlay.fadeOut(400);
				// 	}
				// );
				// scrollUnlock();
				$modalReview.find('.popup-review').hide();
	      $('.popup-success').show();
			});
		});
	
	
		// Очищаем выбранный рейтинга
		function resetRating() {
			// Рейтинг
			let currentRating = document.querySelector('.js-rating-star.is-active');
			let inputRating = document.querySelector('.js-rating-input');
	
			if (currentRating) {
				currentRating.classList.remove('is-active');
			}
			inputRating.value = '';
		}
	
		// Удаляем ошибки формы и очищаем что было заполнено
		function resetFieldsValue() {
			$nameField.val('');
			$textField.val('');
			$errorMessage.html('');
			$modalReview.find('.popup-review').show();
			$('.popup-success').hide();
		}
	
		// Удаляем ошибки формы и очищаем что было заполнено
		function deleteErrorMessages() {
			$nameField.removeClass('has-error');
			$textField.removeClass('has-error');
			$errorMessage.html('');
			$('.js-field-required').fadeIn(0)
		}
	}
	$('.js-warning-login').on('click', function () {
	  $('.modal--shop').animate({opacity: 0}, 200,
	    function () {
	      $(this).css('display', 'none');
	      $('.js-open-modal-login').trigger('click');
	      $('.js-register-height-login').trigger('click');
	    }
	  );
	});
	
	$('.js-warning-register').on('click', function () {
	  $('.modal--shop').animate({opacity: 0}, 200,
	    function () {
	      $(this).css('display', 'none');
	      $('.js-open-modal-login').trigger('click');
	      $('.js-register-height-reg').trigger('click');
	    }
	  );
	});
	
	// Броинрование товара в магазине
	$('.js-reserve-product-btn').on('click', function () {
	  // ловим или залогинен юзер
	  let logined = $('[data-login]').attr('data-login');
	
	  // юзер не залогинен
	  if (!+logined) {
	    // $('.popup-shop-bot').addClass('is-show');
	    $('.auth-warning').show();
	    return false;
	  }
	
	  // удаляем сообщение об ошибке
	  $('.js-reserve-product-no-size').remove();
	
	  // Проверяем или выбрали размер
	  let sizeBtn = $('.js-popup-shop-size-height').find('.sizes-switch__item--active');
	  if (!sizeBtn.length) {
	    $(this).closest('tr').find('.popup-shop-table-size').after('<div class="js-reserve-product-no-size text-danger mt-1 w-100">' + _tr('choose-size') + '</div>');
	    return false;
	  }
	
	  const $cartButton = $('.js-product-add-cart');
	  let product = $(this).attr('data-product-id');
	  let option = sizeBtn.attr('data-option-id');
	  let store = $(this).attr('data-store-id');
	  const presentOptionId = $cartButton.attr('data-gift-id');
	  const presentOptionName = $cartButton.attr('data-gift-option-name');
	  const presentProductId = $cartButton.attr('data-gift-option-id');
	
	
	  $.ajax({
	    url: '/create-product-reserve',
	    type: 'POST',
	    data: {
	      product: product,
	      option: option,
	      store: store,
	      presentProductId: presentProductId,
	      presentOptionId: presentOptionId,
	      presentOptionName: presentOptionName
	    },
	    beforeSend: function () {
	      showSpinnerOverlay('.modal--shop');
	    },
	    success: function (data) {
	      hideSpinnerOverlay('.modal--shop');
	      const orderId = data['order_id'];
	      const shopId = data['shop_id'];
	      const address = data['shop_address'];
	      const schedule = data['shop_schedule'];
	      const name = data['shop_name'];
	      $('.popup-shop')
	        .hide()
	        .after('<h2 class="reserve-success-text">' + _tr('reserve-thanks') + '!' +
	          ' ' + _tr('your-order') + ' <span class="text-danger">#' + orderId + '</span> ' + _tr('awaits-you') + ' (' + name + ') <a href="/our-stores#' + shopId + '" target="_blank" class="link-line-dotted--red">' + address + '</a><br/>' + _tr('schedule') + ': ' + schedule + '</h2>');
	    }
	  });
	});


    /*
  * Oleg
  * */
    //показать еще
    $(document).on('click', '.js-promo-apply', function(e){
    
        e.preventDefault();
    
        //получение токена
        let token = getPromo();
        let deliveryCost = $('.js-order-cart-delivery-cost').text();
    
        $.ajax({
            url: '/' + currentLang() + '/checkout/promo',
            method: 'post',
            data: {
                'token' : token,
                'deliveryCost' : deliveryCost
            },
            success: function (data) {
                if(data['success']){
                    $('.js-cart-popup-cost-total').text(data['total']);
                    $('.js-discount-money').text(data['discountMoney']);
    
    
                    let wrapperElement = $('.js-wrapper-order-cart');
                    wrapperElement.empty();
                    wrapperElement.append(data['view']);
    
    
                }else{
    
                    $('.js-promo-error').text(data['message']);
                }
    
            }
        });
    });
    $('.js-check-form-sub').on('click',function(e){
    
    });
    
    //var submitForm = document.querySelector('.js-check-form-sub')
    //получение введенного promo token
    function getPromo() {
        return document.querySelector('.js-promo-data-input').value;
    }

    //показать еще
    $('.js-blog-show-more').on('click',function(){
       let page = getPage($(this));
       let id = getId($(this));
    
       let language = currentLang();
    
        $.ajax({
            method: 'get',
            url: '/'+language+'/blogs/index?page='+page+'&id='+id,
            data: {
    
            },
            dataType: 'json',
            'success': function (data) {
                let element = $('.wrapper-blog-'+id).append(data['view']);
                showButton(data['button'],id);
                $('.js-wrapper-blog-page-'+id).data('page',page + 1)
            },
            'error': function (response) {
    
            }
        });
    });
    
    $('.js-account-order-show-more').on('click',function(){
        let language = currentLang();
        //получение параметра page(следующая страница)
        let page = getPage($(this));
        //запрос
        $.ajax({
            method: 'get',
            url: '/'+language+'/customer/account/order/?page='+page,
            data: {
    
            },
            dataType: 'json',
            'success': function (data) {
                //добавляем в общей блок новую выборку
                let element = $('.wrapper-account-order').append(data['view']);
                let button = data['button'];
                let page = data['page'];
    
    
                //показывать/скрывать кнопку
                if(!button)
                    $('.js-account-order-show-more').css({'display' : 'none'});
                //изменяем параметр data-page
                $('.js-account-order-show-more').data('page',page);
    
    
            },
            'error': function (response) {
    
            }
        });
    
    
    });
    
    
    
    
    //показать еще pages => about
    $('.js-about-blog-show-more').on('click',function(){
    
    
        let page = getPage($(this));
        let id = getId($(this));
    
        $.ajax({
            method: 'get',
            url: '/pages/about?page='+page+'&id='+id,
            data: {
    
            },
            dataType: 'json',
            'success': function (data) {
    
                let element = $('.wrapper-blog-'+id).find('.js-blog-container').append(data['view']);
                showButton(data['button'],id);
                $('.js-wrapper-blog-page-'+id).data('page',page + 1)
            },
            'error': function (response) {
    
            }
        });
    });
    
    
    //добавление like для блога
    $(document).on('click', '.js-blog-add-like', function(){
    
        let id = $(this).data('id');
        let quantity = 1;
    
        $.ajax({
            method: 'post',
            url: '/blogs/like',
            data: {
                id : id,
                quantity : quantity
            },
            dataType: 'json',
            'success': function (data) {
                if(data['success']){
                    $('.js-blog-like-'+id).text(data['like']);
                }else{
                    alert(data['message']);
                }
            },
            'error': function (response) {
    
            }
        });
    });
    
    
    function getPage(element) {
          return element.data('page');
    }
    
    function getId(element) {
          return element.data('id');
    }
    
    function showButton(flagButton,id) {
        if(!flagButton)
            $('.js-wrapper-blog-page-'+id).css({'display' : 'none'})
    }
    var btnAddComment = document.querySelector('.js-btn-add-review');
    var btnAddCommentChild = document.querySelector('.js-add-review-child');
    var btnAddReview = document.querySelector('.js-add-review');
    
    /*навешиваем события*/
    
    //добавление нового комента
    if (btnAddComment) {
      btnAddComment.addEventListener('click', function (e) {
        e.preventDefault();
    
        var $yiiform = $('#js-add-review');
    
        var $modalReviewForm = $yiiform.find('.popup-review');
        let $textField = $('#reviewform-text');
        let $nameField = $('#reviewform-name');
        let $rating = $('#reviewform-rating');
        var $errorMessage = $('.js-error-message');
        let text = $textField.val();
        let name = $nameField.val();
    
        // Если это отзыв на отзыв, то не надо ставить рейтинг,
        // по этому задаем значение по умолчанию
        let rating;
        if ( $('.js-rating').hasClass('no-validation') ) {
          rating = 'no-validation';
        } else {
          rating = $rating.val();
        }
    
        if (!name || !text || !rating) {
    
          let errorEmptyFields = $modalReviewForm.attr('data-empty-fields');
          let errorRatingFields = $modalReviewForm.attr('data-rating-field');
          $errorMessage.html( errorEmptyFields );
    
          if (!name) {
            $nameField.addClass('has-error');
          }
    
          if (!text) {
            $textField.addClass('has-error');
          }
    
          if (name && text && !rating) {
            $errorMessage.html( errorRatingFields );
          }
    
          return false;
        }
    
    
        $.ajax({
          method: $yiiform.attr('method'),
          url: $yiiform.attr('action'),
          data: $yiiform.serializeArray(),
          dataType: 'json',
          complete: function () {
            // reset all
            $nameField.val('').removeClass('has-error');
            $textField.val('').removeClass('has-error');
            $errorMessage.html('');
            let currentRating = document.querySelector('.js-rating-star.is-active');
            let inputRating = document.querySelector('.js-rating-input');
    
            if (currentRating) {
              currentRating.classList.remove('is-active');
            }
            inputRating.value = '';
            $modalReviewForm.hide();
            $('.modal__title').hide();
            $('.popup-success').show();
          },
          'error': function (response) {
    
          }
        });
    
      });
    }
    
    $('.js-add-review-child').on('click', function () {
      $('.js-rating').addClass('no-validation');
      let id = $(this).data('id');
      $('#reviewform-reviewid').val(id);
      $('.popup-review-rating').hide();
      resetReviewForm();
    });
    
    // if(btnAddCommentChild){
    //         btnAddCommentChild.addEventListener('click',function(e)
    //         {
    //                 alert('vbv');
    //                 $('#reviewform-reviewid').val($(this).data('id'));
    //         });
    // }
    
    
    $('.js-btn-show-review').on('click', function () {
    
      let page = $(this).data('page');
      let id = $(this).data('id');
    
      $.ajax({
        method: 'get',
        url: '/blogs/review?page=' + page + '&id=' + id,
        data: {},
        dataType: 'json',
        'success': function (data) {
          $('.journal-one-reviews-items').append(data['view']);
          $('.js-btn-show-review').data('page', page + 1);
          if (!data['button']) {
            $('.js-btn-show-review').css({'display': 'none'});
          }
        },
        'error': function (response) {
    
        }
      });
    });
    
    if (btnAddReview) {
      btnAddReview.addEventListener('click', function (e) {
        $('.popup-review-rating').show();
        $('#reviewform-reviewid').val('');
        resetReviewForm();
      });
    }
    
    function resetReviewForm() {
      $('#js-add-review .popup-review, .modal__title').show();
      $('.popup-success').hide();
    }

    /*backend*/
    

    $(document).on('click', '.subscribe-btn_js', function () {
        let btn = $(this);
        let type = btn.attr('data-type');
        var email = btn.parents('.subscribe-wrapper_js').find('input').val();
        let form = $('html').attr('data-form');
        $.ajax({
            method: 'POST',
            url: "/add-subscribe",
            data: {
                'type': type,
                'email': email,
                [form]: form
            }
        }).done(function (response) {
            notify(response.msg);
            $('.subscribe-form-input').val('')
        });
    })
    $(document).on('click', '.js-chat', function () {
        $(this).toggleClass('isOpen');
    });

	// console.log("%cЧто ищем?🤨", "font-size: 46px; color: #00075");
});
//# sourceMappingURL=main.js.map
