/*!
 * jQuery Slider Evolution - for jQuery 1.3+
 * http://codecanyon.net/user/aeroalquimia/portfolio?ref=aeroalquimia
 *
 * Copyright 2011, Eduardo Daniel Sada
 * http://codecanyon.net/wiki/buying/howto-buying/licensing/
 *
 * Version: 1.1.5 (08 Jun 2011)
 *
 * Includes jQuery Easing v1.3
 * http://gsgd.co.uk/sandbox/jquery/easing/
 * Copyright (c) 2008 George McGinley Smith
 * jQuery Easing released under the BSD License.
 */
(function ($) {
  if ($.proxy === undefined) {
    $.extend({
      proxy: function (a, b) {
        if (a) {
          proxy = function () {
            return a.apply(b || this, arguments)
          }
        };
        return proxy
      }
    })
  };
  $.extend($.easing, {
    easeOutCubic: function (x, t, b, c, d) {
      return c * ((t = t / d - 1) * t * t + 1) + b
    }
  });
  SliderObject = function (a, b) {
    this.create(a, b)
  };
  $.extend(SliderObject.prototype, {
    version: "1.1.4",
    create: function (a, b) {
      this.defaults = {
        name: 'jquery-slider',
        navigation: true,
        selector: true,
        timer: true,
        control: true,
        pauseOnClick: true,
        pauseOnHover: true,
        loop: true,
        slideshow: true,
        delay: 4500,
        duration: 400,
        bars: 9,
        columns: 7,
        rows: 3,
        speed: 80,
        padding: 8,
        easing: "easeOutCubic",
        transition: 'random',
        onComplete: function () {},
        onSlideshowEnd: function () {}
      };
      this.options = {};
      this.transitions = ['fade', 'square', 'bar', 'squarerandom', 'fountain', 'rain', ];
      this.dom = {};
      this.img = [];
      this.titles = [];
      this.links = [];
      this.imgInc = 0;
      this.imgInterval = 0;
      this.inc = 0;
      this.order = [];
      this.resto = 0;
      this.selectores = [];
      this.direction = 0;
      this.degrees = 0;
      this.timer = 0;
      this.slides = [];
      this.esqueleto = {
        wrapper: [],
        navigation: [],
        timer: [],
        selector: [],
        control: [],
        clock: []
      };
      this.events = {
        clicked: false,
        hovered: false,
        playing: false,
        paused: false,
        stopped: false
      };
      this.element = $(a);
      var c = this.options;
      var d = this;
      var e = this.element.children("div");
      if (e.length < 2) {
        return false
      }
      if (!b['width']) {
        b['width'] = 0;
        b['height'] = 0;
        var f = {};
        e.children().each(function () {
          if ($(this).is("img")) {
            f['width'] = $(this).outerWidth();
            f['height'] = $(this).outerHeight();
            b['width'] = (f['width'] >= b['width']) ? f['width'] : 0;
            b['height'] = (f['height'] >= b['height']) ? f['height'] : 0
          }
        });
        delete f;
        if (b['width'] == 0 || b['height'] == 0) {
          delete b['width'];
          delete b['height']
        }
      }
      this.options = $.extend(true, this.defaults, b);
      var g = this.options.name + '-option';
      $.each(['navigation', 'selector', 'control', 'timer'], function (i, s) {
        if (d.options[s]) {
          g += '-' + s
        }
      });
      this.esqueleto.wrapper = this.element.wrap('<div class="' + this.options.name + '-wrapper ' + g + '" />').parent();
      this.esqueleto.wrapper.css({
        'width': this.options.width,
        'height': this.options.height
      });
      this.element.css({
        'width': this.options.width,
        'height': this.options.height,
        'overflow': 'hidden',
        'position': 'relative'
      });
      e.each(function (i) {
        if (i == 0) {
          $(this).addClass(d.options.name + '-slide-current')
        }
        $(this).addClass(d.options.name + '-slide');
        $(this).addClass(d.options.name + '-slide-' + (i + 1));
        d.selectores = $(d.selectores).add($('<a href="#" class="' + d.options.name + '-selector" rel="' + (i + 1) + '"><span class="' + d.options.name + '-selector-span ' + d.options.name + '-selector-' + (i + 1) + '"><span>' + (i + 1) + '</span></span></a>'));
        if (i == 0) {
          $(d.selectores).addClass(d.options.name + '-selector-current')
        }
      });
      this.esqueleto.selector = $('<div class="' + this.options.name + '-selectors" />').insertAfter(a);
      this.esqueleto.selector.append(this.selectores);
      if (!this.options.selector) {
        this.esqueleto.selector.hide()
      } else {
        if (this.rgbToHex(this.esqueleto.selector.css("color")) == "#FFFFFF") {
          var h = $('.' + this.options.name + '-selector').outerWidth(true);
          h = -((h * e.length) / 2);
          this.esqueleto.selector.css({
            "margin-left": h
          })
        }
      }
      if (this.options.navigation) {
        this.esqueleto.navigation = $('<div class="' + this.options.name + '-navigation" />').insertAfter(a);
        var j = $('<a href="#" class="' + this.options.name + '-navigation-prev" rel="-1"><span>Prev</span></a>');
        var k = $('<a href="#" class="' + this.options.name + '-navigation-next" rel="+1"><span>Next</span></a>');
        this.esqueleto.navigation.append(j, k)
      }
      if (this.options.control) {
        this.esqueleto.control = $('<a href="#" class="' + this.options.name + '-control ' + this.options.name + '-control-pause"><span>Play/Pause</span></a>').insertAfter(a)
      }
      if (this.options.timer) {
        this.esqueleto.timer = $('<div class="' + this.options.name + '-timer"></div>').insertAfter(a);
        this.esqueleto.clock.mask = $('<div class="' + this.options.name + '-timer-mask"></div>');
        this.esqueleto.clock.rotator = $('<div class="' + this.options.name + '-timer-rotator"></div>');
        this.esqueleto.clock.bar = $('<div class="' + this.options.name + '-timer-bar"></div>');
        this.esqueleto.clock.command = this.rgbToHex(this.esqueleto.timer.css("color"));
        this.esqueleto.timer.append(this.esqueleto.clock.mask.append(this.esqueleto.clock.rotator), this.esqueleto.clock.bar)
      }
      this.addEvents();
      if (this.options.slideshow) {
        this.startTimer()
      } else {
        this.stopTimer()
      }
    },
    addEvents: function () {
      var c = this;
      var d = this.esqueleto.wrapper;
      var e = this.options;
      d.hover(function () {
        d.addClass(e.name + '-hovered');
        if (e.pauseOnHover && !c.events.paused) {
          c.events.hovered = true;
          c.pauseTimer()
        }
      }, function () {
        d.removeClass(e.name + '-hovered');
        if (e.pauseOnHover && c.events.hovered) {
          c.startTimer()
        }
        c.events.hovered = false
      });
      this.esqueleto.selector.children("a").click(function (a) {
        if (c.events.playing == false) {
          if ($(this).hasClass(e.name + '-selector-current') == false) {
            var b = c.events.stopped;
            c.stopTimer();
            c.callSlide($(this).attr('rel'));
            if (!e.pauseOnClick && !b) {
              c.startTimer()
            }
          }
        }
        a.preventDefault()
      });
      if (e.navigation) {
        this.esqueleto.navigation.children("a").click(function (a) {
          if (c.events.playing == false) {
            var b = c.events.stopped;
            c.stopTimer();
            c.callSlide($(this).attr("rel"));
            if (!e.pauseOnClick && !b) {
              c.startTimer()
            }
          }
          a.preventDefault()
        })
      };
      if (e.control) {
        this.esqueleto.control.click($.proxy(function (a) {
          if (this.events.stopped) {
            this.startTimer()
          } else {
            this.stopTimer()
          }
          this.events.hovered = false;
          a.preventDefault()
        }, this))
      }
    },
    startTimer: function () {
      if (this.options.timer) {
        if (this.esqueleto.clock.command == "#000000") {
          this.esqueleto.clock.bar.animate({
            "width": "100%"
          }, (this.resto > 0 ? this.resto : this.options.delay), "linear", $.proxy(function () {
            this.callSlide("+1");
            this.resto = 0;
            this.esqueleto.clock.bar.css({
              "width": 0
            });
            this.startTimer()
          }, this))
        } else if (this.esqueleto.clock.command = "#FFFFFF") {
          this.timer = setInterval($.proxy(function () {
            var a = "rotate(" + this.degrees + "deg)";
            this.degrees += 2;
            this.esqueleto.clock.rotator.css({
              "-webkit-transform": a,
              "-moz-transform": a,
              "-o-transform": a,
              "transform": a
            });
            if (navigator.userAgent.indexOf('MSIE') !== -1 || navigator.appVersion.indexOf('Trident/') > 0) {
              this.esqueleto.clock.rotator.get(0).style['msTransform'] = a
            }
            if (this.degrees > 180) {
              this.esqueleto.clock.rotator.addClass(this.options.name + '-timer-rotator-move');
              this.esqueleto.clock.mask.addClass(this.options.name + '-timer-mask-move')
            }
            if (this.degrees > 360) {
              this.esqueleto.clock.rotator.removeClass(this.options.name + '-timer-rotator-move');
              this.esqueleto.clock.mask.removeClass(this.options.name + '-timer-mask-move');
              this.degrees = 0;
              this.callSlide("+1");
              this.resto = 0
            }
          }, this), this.options.delay / 180)
        }
        if (this.options.control) {
          this.esqueleto.control.removeClass(this.options.name + '-control-play');
          this.esqueleto.control.addClass(this.options.name + '-control-pause')
        }
      } else {
        if (!this.timer) {
          this.timer = setInterval($.proxy(function () {
            this.callSlide("+1")
          }, this), this.options.delay)
        }
      }
      this.events.paused = false;
      this.events.stopped = false;
      this.element.trigger("sliderPlay")
    },
    pauseTimer: function () {
      clearInterval(this.timer);
      this.timer = "";
      if (this.options.timer) {
        this.esqueleto.clock.bar.stop(true);
        var a = 100 - (parseInt(this.esqueleto.clock.bar.css("width"), 10) * 100 / this.options.width);
        this.resto = this.options.delay * a / 100
      }
      this.events.paused = true;
      if (this.options.control && !this.events.hovered) {
        this.esqueleto.control.removeClass(this.options.name + '-control-pause');
        this.esqueleto.control.addClass(this.options.name + '-control-play')
      }
      this.element.trigger("sliderPause")
    },
    stopTimer: function () {
      clearInterval(this.timer);
      this.timer = "";
      if (this.options.timer) {
        this.esqueleto.clock.bar.stop();
        this.resto = 0;
        if (this.esqueleto.clock.command == "#000000") {
          this.esqueleto.clock.bar.css({
            "width": 0
          })
        } else if (this.esqueleto.clock.command == "#FFFFFF") {
          this.esqueleto.clock.rotator.removeClass(this.options.name + '-timer-rotator-move');
          this.esqueleto.clock.mask.removeClass(this.options.name + '-timer-mask-move');
          this.degrees = 0;
          var a = "rotate(" + this.degrees + "deg)";
          this.esqueleto.clock.rotator.css({
            "-webkit-transform": a,
            "-moz-transform": a,
            "-o-transform": a,
            "transform": a
          });
          if (navigator.userAgent.indexOf('MSIE') !== -1 || navigator.appVersion.indexOf('Trident/') > 0) {
            this.esqueleto.clock.rotator.get(0).style['msTransform'] = a
          }
        }
      }
      this.events.paused = true;
      this.events.stopped = true;
      this.events.hovered = false;
      if (this.options.control) {
        this.esqueleto.control.removeClass(this.options.name + '-control-pause');
        this.esqueleto.control.addClass(this.options.name + '-control-play')
      }
      this.element.trigger("sliderStop")
    },
    shuffle: function (a) {
      for (var j, x, i = a.length; i; j = parseInt(Math.random() * i, 10), x = a[--i], a[i] = a[j], a[j] = x) {}
      return a
    },
    rgbToHex: function (b) {
      if (b.match(/^#[0-9A-Fa-f]{6}$/)) {
        return b.toUpperCase()
      }
      var c = /rgb\((.+),(.+),(.+)\)/i.exec(b);
      if (!c) {
        return b.toUpperCase()
      }
      var d = parseInt(c[1]);
      var e = parseInt(c[2]);
      var f = parseInt(c[3]);
      var g = function (a) {
          return ((a.length < 2 ? '0' : '') + a).toUpperCase()
          };
      return ('#' + g(d.toString(16)) + g(e.toString(16)) + g(f.toString(16))).toUpperCase()
    },
    callSlide: function (a) {
      if (this.events.playing) {
        return false
      }
      var b = this.element.children("." + this.options.name + '-slide-current');
      var c = this.esqueleto.selector.children("." + this.options.name + '-selector-current');
      if (a == "+1") {
        var d = b.next("." + this.options.name + '-slide');
        var e = c.next();
        if (d.length <= 0) {
          if (this.options.loop) {
            d = this.element.children("." + this.options.name + '-slide').first();
            e = this.selectores.first("a")
          } else {
            this.stopTimer();
            return false
          }
        }
      } else if (a == "-1") {
        var d = b.prev("." + this.options.name + '-slide');
        var e = c.prev("a");
        if (d.length <= 0) {
          d = this.element.children("." + this.options.name + '-slide').last();
          e = this.selectores.last("a")
        }
      } else {
        var d = this.element.children("." + this.options.name + '-slide-' + a);
        var e = this.esqueleto.selector.children("." + this.options.name + '-selector[rel=' + a + ']')
      }
      this.transition(b, c, d, e);
      this.element.trigger("sliderChange", d)
    },
    transition: function (a, b, c, d) {
      if ($.isArray(this.options.transition)) {
        this.transitions = this.options.transition;
        this.options.transition = "random"
      }
      var e = c.attr('class').split(" ")[0].split(this.options.name + "-trans-")[1];
      if (e === undefined) {
        e = this.options.transition
      }
      if (e == "random") {
        var f = '';
        while (f == this.lastTransition || f == '') {
          f = this.shuffle(this.transitions)[0].toLowerCase()
        }
        e = f
      }
      e = e.toLowerCase();
      this.lastTransition = e;
      this["trans" + e](a, b, c, d)
    },
    transfade: function (a, b, c, d) {
      this.events.playing = true;
      c.css({
        "opacity": 1
      }).addClass(this.options.name + '-slide-next');
      b.removeClass(this.options.name + '-selector-current');
      d.addClass(this.options.name + '-selector-current');
      a.stop().animate({
        "opacity": 0
      }, this.options.duration, $.proxy(function () {
        a.removeClass(this.options.name + '-slide-current');
        c.addClass(this.options.name + '-slide-current');
        c.removeClass(this.options.name + '-slide-next');
        this.element.trigger("sliderTransitionFinishes", c);
        this.events.playing = false
      }, this))
    },
    transbar: function (b, d, e, f, g) {
      g = $.extend(true, {
        'direction': 'left'
      }, g);
      this.events.playing = true;
      var h = {
        'width': Math.round(this.options.width / this.options.bars),
        'height': this.options.height
      };
      bar_array = new Array(this.options.bars);
      if (g['direction'] == "right") {
        c = 0;
        for (i = this.options.bars; i > 0; i--) {
          bar_array[c] = i;
          c++
        }
      } else if (g['direction'] == "left") {
        for (i = 1; i <= this.options.bars; i++) {
          bar_array[i] = i
        }
      } else if (g['direction'] == "fountain" || g['direction'] == "rain") {
        var j = 1;
        var k = parseInt(this.options.bars / 2);
        for (i = 1; i <= this.options.bars; i++) {
          bar_array[i - 1] = (k - (parseInt((i) / 2) * j)) + 1;
          j *= -1
        }
      }
      $.each(bar_array, $.proxy(function (i, a) {
        position = (a * h.width) - h.width;
        bar = $('<div class="' + this.options.name + '-bar ' + this.options.name + '-bar-' + a + '"/>');
        bar.css({
          'position': 'absolute',
          'overflow': 'hidden',
          'left': position,
          'z-index': 3,
          'opacity': 0,
          'background-position': '-' + position + 'px top'
        }).css(h);
        if (g['direction'] == "fountain") {
          bar.css({
            'top': this.options.height
          })
        } else if (g['direction'] == "rain") {
          bar.css({
            'top': -this.options.height
          })
        }
        bar.append('<div style="position: absolute; left: -' + position + 'px; width: ' + this.options.width + 'px; height: ' + this.options.height + 'px;">' + e.html() + '</div>');
        this.element.append(bar);
        delay = this.options.speed * i;
        bar.animate({
          'opacity': 0
        }, delay).animate({
          'opacity': 1,
          'top': 0
        }, {
          duration: this.options.duration
        })
      }, this));
      d.removeClass(this.options.name + '-selector-current');
      f.addClass(this.options.name + '-selector-current');
      setTimeout($.proxy(function () {
        e.css({
          "opacity": 1
        }).addClass(this.options.name + '-slide-current');
        b.css({
          "opacity": 0
        }).removeClass(this.options.name + '-slide-current');
        this.element.children("." + this.options.name + '-bar').remove();
        this.events.playing = false;
        this.element.trigger("sliderTransitionFinishes", e)
      }, this), delay + this.options.duration)
    },
    transbarleft: function (a, b, c, d) {
      return this.transbar(a, b, c, d)
    },
    transbarright: function (a, b, c, d) {
      return this.transbar(a, b, c, d, {
        "direction": "right"
      })
    },
    transsquare: function (b, c, d, e, f) {
      f = $.extend(true, {
        'mode': 'acumulative',
        'effect': 'rain'
      }, f);
      this.events.playing = true;
      d.css({
        "opacity": 1
      });
      c.removeClass(this.options.name + '-selector-current');
      e.addClass(this.options.name + '-selector-current');
      var g = Math.round(this.options.width / this.options.columns);
      var h = Math.round(this.options.height / this.options.rows);
      var j = [];
      var k = d.html();
      for (iRow = 1; iRow <= this.options.rows; iRow++) {
        for (iCol = 1; iCol <= this.options.columns; iCol++) {
          j.push(iCol + '' + iRow);
          var l = ((iRow * h) - h);
          var m = ((iCol * g) - g);
          var n = (g * iCol) - g;
          var o = (h * iRow) - h;
          var p = $('<div class="' + this.options.name + '-block ' + this.options.name + '-block-' + iCol + iRow + '" />');
          p.css({
            'overflow': 'hidden',
            'position': 'absolute',
            'width': g,
            'height': h,
            'z-index': 3,
            'top': l,
            'left': m,
            'opacity': 0,
            'background-position': '-' + n + 'px -' + o + 'px'
          });
          p.append('<div style="position: absolute; left: -' + n + 'px; top: -' + o + 'px; width: ' + this.options.width + 'px; height: ' + this.options.height + 'px;">' + k + '</div>');
          this.element.append(p)
        }
      }
      if (f['effect'] == 'random') {
        j = this.shuffle(j)
      } else if (f['effect'] == 'swirl') {
        j = this.arrayswirl(j)
      }
      if (f['mode'] == 'acumulative') {
        var q = 0;
        for (iRow = 1; iRow <= this.options.rows; iRow++) {
          colRow = iRow;
          for (iCol = 1; iCol <= this.options.columns; iCol++) {
            delay = this.options.speed * colRow;
            this.element.children('.' + this.options.name + '-block-' + j[q]).animate({
              'width': g
            }, delay).animate({
              'opacity': 1
            }, this.options.duration);
            q++;
            colRow++
          }
        }
      } else if (f['mode'] == 'dual') {
        $.each(j, $.proxy(function (i, a) {
          delay = this.options.speed * i;
          this.element.children('.' + this.options.name + '-block-' + a).animate({
            'width': g
          }, delay).animate({
            'opacity': 1
          }, this.options.duration)
        }, this))
      } else if (f['mode'] == 'lineal') {
        $.each(j, $.proxy(function (i, a) {
          delay = this.options.speed * i;
          this.element.children('.' + this.options.name + '-block-' + a).animate({
            'width': g
          }, delay).animate({
            'opacity': 1
          }, this.options.duration)
        }, this))
      }
      setTimeout($.proxy(function () {
        d.css({
          "opacity": 1
        }).addClass(this.options.name + '-slide-current');
        b.css({
          "opacity": 0
        }).removeClass(this.options.name + '-slide-current');
        this.element.children("." + this.options.name + '-block').remove();
        this.events.playing = false;
        this.element.trigger("sliderTransitionFinishes", d)
      }, this), delay + this.options.duration)
    },
    transsquarerandom: function (a, b, c, d) {
      return this.transsquare(a, b, c, d, {
        'effect': 'random'
      })
    },
    transslide: function (a, b, c, d, e) {
      e = $.extend(true, {
        'direction': 'left'
      }, e);
      this.events.playing = true;
      c.css({
        "opacity": 1
      });
      b.removeClass(this.options.name + '-selector-current');
      d.addClass(this.options.name + '-selector-current');
      a.removeClass(this.options.name + '-slide-current');
      a.addClass(this.options.name + '-slide-next');
      c.addClass(this.options.name + '-slide-current');
      if (e.direction == "left") {
        c.css({
          "left": this.options.width
        })
      } else if (e.direction == "right") {
        c.css({
          "left": -this.options.width
        })
      } else if (e.direction == "top") {
        c.css({
          "top": -this.options.height
        })
      } else if (e.direction == "bottom") {
        c.css({
          "top": this.options.height
        })
      }
      c.stop().animate({
        "left": 0,
        "top": 0
      }, this.options.duration, this.options.easing, $.proxy(function () {
        a.removeClass(this.options.name + '-slide-next');
        a.css({
          "opacity": 0
        });
        this.events.playing = false;
        this.element.trigger("sliderTransitionFinishes", c)
      }, this))
    },
    transslideleft: function (a, b, c, d) {
      return this.transslide(a, b, c, d, {
        'direction': 'left'
      })
    },
    transslideright: function (a, b, c, d) {
      return this.transslide(a, b, c, d, {
        'direction': 'right'
      })
    },
    transslidetop: function (a, b, c, d) {
      return this.transslide(a, b, c, d, {
        'direction': 'top'
      })
    },
    transslidebottom: function (a, b, c, d) {
      return this.transslide(a, b, c, d, {
        'direction': 'bottom'
      })
    },
    transfountain: function (a, b, c, d) {
      return this.transbar(a, b, c, d, {
        'direction': 'fountain'
      })
    },
    transrain: function (a, b, c, d) {
      return this.transbar(a, b, c, d, {
        'direction': 'rain'
      })
    },
    transexplode: function (a, b, c, d, e) {
      e = $.extend(true, {
        'mode': 'acumulative',
        'effect': 'rain'
      }, e);
      this.events.playing = true;
      c.css({
        "opacity": 0
      });
      b.removeClass(this.options.name + '-selector-current');
      d.addClass(this.options.name + '-selector-current');
      var f = Math.round(this.options.width / this.options.columns);
      var g = Math.round(this.options.height / this.options.rows);
      var h = [];
      var i = c.html();
      for (iRow = 1; iRow <= this.options.rows; iRow++) {
        for (iCol = 1; iCol <= this.options.columns; iCol++) {
          h.push(iCol + '' + iRow);
          var j = ((iRow * g) - g);
          var k = ((iCol * f) - f);
          var l = (f * iCol) - f;
          var m = (g * iRow) - g;
          var n = (iCol - parseInt((this.options.columns + 1) / 2)) * this.options.padding;
          var o = (iRow - parseInt((this.options.rows + 1) / 2)) * this.options.padding;
          var p = $('<div class="' + this.options.name + '-block-clon ' + this.options.name + '-block-clon-' + iCol + iRow + '" />');
          p.css({
            'overflow': 'hidden',
            'position': 'absolute',
            'width': f,
            'height': g,
            'z-index': 2,
            'top': j + o,
            'left': k + n,
            'opacity': 0,
            'background-position': '-' + l + 'px -' + m + 'px'
          });
          p.append('<div style="position: absolute; left: -' + l + 'px; top: -' + m + 'px; width: ' + this.options.width + 'px; height: ' + this.options.height + 'px;">' + i + '</div>');
          this.element.append(p);
          var p = $('<div class="' + this.options.name + '-block ' + this.options.name + '-block-' + iCol + iRow + '" />');
          p.css({
            'overflow': 'hidden',
            'position': 'absolute',
            'width': f,
            'height': g,
            'z-index': 3,
            'top': j,
            'left': k,
            'opacity': 1,
            'background-position': '-' + l + 'px -' + m + 'px'
          });
          p.append('<div style="position: absolute; left: -' + l + 'px; top: -' + m + 'px; width: ' + this.options.width + 'px; height: ' + this.options.height + 'px;">' + a.html() + '</div>');
          this.element.append(p)
        }
      }
      a.css({
        "opacity": 0
      });
      if (e['effect'] == 'random') {
        h = this.shuffle(h)
      } else if (e['effect'] == 'swirl') {
        h = this.arrayswirl(h)
      }
      for (iRow = 1; iRow <= this.options.rows; iRow++) {
        colRow = iRow;
        for (iCol = 1; iCol <= this.options.columns; iCol++) {
          delay = this.options.speed * colRow;
          var n = (iCol - parseInt((this.options.columns + 1) / 2)) * this.options.padding;
          var o = (iRow - parseInt((this.options.rows + 1) / 2)) * this.options.padding;
          this.element.children('.' + this.options.name + '-block-' + iCol + '' + iRow).animate({
            'left': '+=' + n,
            'top': '+=' + o
          }, this.options.duration);
          colRow++
        }
      }
      var q = delay;
      var r = 0;
      for (iRow = 1; iRow <= this.options.rows; iRow++) {
        colRow = iRow;
        for (iCol = 1; iCol <= this.options.columns; iCol++) {
          delay = this.options.speed * colRow;
          this.element.children('.' + this.options.name + '-block-' + h[r]).animate({
            'opacity': 0
          }, delay);
          this.element.children('.' + this.options.name + '-block-clon-' + h[r]).animate({
            'width': f
          }, this.options.duration).animate({
            'opacity': 1
          }, delay).animate({
            'width': f
          }, q - delay);
          r++;
          colRow++
        }
      }
      for (iRow = 1; iRow <= this.options.rows; iRow++) {
        colRow = iRow;
        for (iCol = 1; iCol <= this.options.columns; iCol++) {
          delay = this.options.speed * colRow;
          var n = (iCol - parseInt((this.options.columns + 1) / 2)) * this.options.padding;
          var o = (iRow - parseInt((this.options.rows + 1) / 2)) * this.options.padding;
          this.element.children('.' + this.options.name + '-block-clon-' + iCol + '' + iRow).animate({
            'left': '-=' + n,
            'top': '-=' + o
          }, this.options.duration);
          colRow++
        }
      }
      setTimeout($.proxy(function () {
        c.css({
          "opacity": 1
        }).addClass(this.options.name + '-slide-current');
        a.css({
          "opacity": 0
        }).removeClass(this.options.name + '-slide-current');
        this.element.children("." + this.options.name + '-block').remove();
        this.element.children("." + this.options.name + '-block-clon').remove();
        this.events.playing = false;
        this.element.trigger("sliderTransitionFinishes", c)
      }, this), (q + (this.options.duration * 2)))
    },
    transexploderandom: function (a, b, c, d) {
      return this.transexplode(a, b, c, d, {
        'effect': 'random'
      })
    }
  });
  $.fn.slideshow = function (a, b) {
    if (parseFloat($.fn.jquery) > 1.2 || parseFloat($.fn.jquery) == 1.11) {
      var d = {};
      this.each(function () {
        var s = $(this);
        d = s.data("slider");
        if (!d) {
          d = new SliderObject(this, a, b);
          s.data("slider", d)
        }
      });
      return d
    } else {
      throw "The jQuery version that was loaded is too old. Slider Evolution requires jQuery 1.3+";
    }
  }
})(jQuery);
