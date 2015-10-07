define([
    'jquery',
], function($) {
    $.fn.extend({
        adsNote: function(options) {
            // Default value
            var defaults = {
                position: "top-left", // top-left, middle-left, bottom-left, top-right, middle-right, bottom-right,
                bgcolor: "#FC0"
            }
            var opts = $.extend({}, defaults, options);
            return this.each(function() {
                var obj = $(this);
                var contentText = $(".ads-note-content-text", obj);
                var contentImg = $(".ads-note-content-img", obj);
                var contenheight = $(".ads-note-content", obj).height();
                $(".ads-note-box", obj).before('<div class="ads-note-show"><div class="ads-note-show-arrow"></div></div>');
                $(".ads-note-content", obj).append('<div class="ads-note-close"></div>'); // create close button
                $(".ads-note-content", obj).append('<div style="clear:both"></div>');
                // box color
                contentText.css({
                    "background": opts.bgcolor
                });
                $(".ads-note-show", obj).css({
                    "background": opts.bgcolor
                });

                if ((opts.position == "top-left") || (opts.position == "middle-left") || (opts.position == "bottom-left")) {
                    obj.addClass("ads-note-left");
                } else
                if ((opts.position == "top-right") || (opts.position == "middle-right") || (opts.position == "bottom-right")) {
                    obj.addClass("ads-note-right");
                } else
                if (opts.position == "middle-top") {
                    obj.addClass("ads-note-top");
                    $(".ads-note-content-text", obj).before($("div.ads-note-content-img", obj));
                } else
                if (opts.position == "middle-bottom") {
                    obj.addClass("ads-note-bottom");
                }
                //               //fix position
                switch (opts.position) {
                    case "top-left":
                        {
                            obj.css({
                                "position": "fixed",
                                "z-index": 9999,
                                "top": "1%",
                                "left": "0%"
                            });
                            break;
                        }
                    case "middle-left":
                        {
                            obj.css({
                                "position": "fixed",
                                "z-index": 9999,
                                "top": "33%",
                                "left": 0
                            });
                            break;
                        }
                    case "bottom-left":
                        {
                            obj.css({
                                "position": "fixed",
                                "z-index": 9999,
                                "bottom": "1%",
                                "left": 0
                            });
                            break;
                        }
                    case "top-right":
                        {
                            obj.css({
                                "position": "fixed",
                                "z-index": 9999,
                                "top": "1%",
                                "right": "0%"
                            });
                            break;
                        }
                    case "middle-right":
                        {
                            obj.css({
                                "position": "fixed",
                                "z-index": 9999,
                                "right": "0%",
                                "top": "33%",

                            });
                            break;
                        }
                    case "bottom-right":
                        {
                            obj.css({
                                "position": "fixed",
                                "z-index": 9999,
                                "bottom": "1%",
                                "right": "0%"
                            });
                            break;
                        }
                    case "middle-top":
                        {
                            obj.css({
                                "position": "fixed",
                                "z-index": 9999,
                                "top": "0",
                                "left": "40%"
                            });
                            break;
                        }
                    case "middle-bottom":
                        {
                            obj.css({
                                "position": "fixed",
                                "z-index": 9999,
                                "bottom": "0%",
                                "left": "40%"
                            });
                            break;
                        }
                } // end switch


                // event
                if ((opts.position == "bottom-left") || (opts.position == "middle-left") || (opts.position == "top-left")) {
                    $(".ads-note-close", obj).click(function() {
                        $(".ads-note-box", obj).animate({
                            left: '-350px'
                        });
                        $(".ads-note-show", obj).animate({
                            left: '0px'
                        });
                    });
                    $(".ads-note-show", obj).click(function() {
                        $(".ads-note-show", obj).animate({
                            left: '-30px'
                        });
                        $(".ads-note-box", obj).animate({
                            left: '0px'
                        });
                    });

                } //end if

                if (opts.position == "middle-bottom") {
                    $(".ads-note-close", obj).click(function() {
                        $(".ads-note-box", obj).animate({
                            bottom: '-350px'
                        });
                        $(".ads-note-show", obj).animate({
                            bottom: '0px'
                        });
                    });
                    $(".ads-note-show", obj).click(function() {
                        $(".ads-note-show", obj).animate({
                            bottom: '-30px'
                        });
                        $(".ads-note-box", obj).animate({
                            bottom: '0px'
                        });
                    });
                } //end if
                if ((opts.position == "bottom-right") || (opts.position == "middle-right") || (opts.position == "top-right")) {
                    $(".ads-note-close", obj).click(function() {
                        $(".ads-note-box", obj).animate({
                            right: '-350px'
                        });
                        $(".ads-note-show", obj).animate({
                            right: '0px'
                        });
                    });
                    $(".ads-note-show", obj).click(function() {
                        $(".ads-note-show", obj).animate({
                            right: '-30px'
                        });
                        $(".ads-note-box", obj).animate({
                            right: '0px'
                        });
                    });

                } //end if

                $(".ads-note-content", obj).mouseover(function() {
                    $(".ads-note-content", obj).css({
                        "width": "300px",
                        "min-height": contenheight + "px"
                    });
                    contentText.css({
                        "transition": "0.05s",
                        "-webkit-transition": "0.05s",
                        "-o-transition": ".05s",
                        "-ms-transition": ".05s",
                        "-moz-transition": ".05s",
                        "width": "255px"
                    });
                    contentImg.css({
                        "transition": "0.7s",
                        "-webkit-transition": "0.7s",
                        "-o-transition": "0.7s",
                        "-ms-transition": "0.7s",
                        "-moz-transition": "0.7s",
                        "height": "200px"
                    });
                });

                $(".ads-note-content", obj).mouseout(function() {
                    $(".ads-note-content", obj).css({
                        "width": "120px"
                    });
                    contentImg.css({
                        "transition": "0.2s",
                        "-webkit-transition": "0.1s",
                        "-o-transition": ".2s",
                        "-ms-transition": ".2s",
                        "-moz-transition": ".2s",
                        "height": "0px"
                    });
                    contentText.css({
                        "transition": "0.7s",
                        "-webkit-transition": "0.7s",
                        "-o-transition": "0.7s",
                        "-ms-transition": "0.7s",
                        "-moz-transition": "0.7s",
                        "width": "130px"
                    });
                });
                obj.mouseover(function() {
                    obj.css({
                        "z-index": 99999
                    });
                });
                obj.mouseout(function() {
                    obj.css({
                        "z-index": 9999
                    });
                });
                if (opts.position == "middle-top") {
                    $(".ads-note-close", obj).click(function() {
                        $(".ads-note-box", obj).animate({
                            top: '-350px'
                        });
                        $(".ads-note-show", obj).animate({
                            top: '0px'
                        });
                    });
                    $(".ads-note-show").click(function() {
                        $(".ads-note-show", obj).animate({
                            top: '-30px'
                        });
                        $(".ads-note-box", obj).animate({
                            top: '0px'
                        });
                    });
                    $(".ads-note-content", obj).mouseout(function() {
                        $(".ads-note-content", obj).css({
                            "width": "120px"
                        });
                        contentImg.css({
                            "transition": "0.2s",
                            "-webkit-transition": "0.1s",
                            "-o-transition": ".2s",
                            "-ms-transition": ".2s",
                            "-moz-transition": ".2s",
                            "height": "0px"
                        });
                        contentText.css({
                            "transition": "0.2s",
                            "-webkit-transition": "0.2s",
                            "-o-transition": "0.2s",
                            "-ms-transition": "0.2s",
                            "-moz-transition": "0.2s",
                            "width": "130px"
                        });
                    });
                } //end if

            });
        }
    });

});
