/******************************************
    File Name: custom.js
/****************************************** */

(function($) {
    "use strict";

    /* ==============================================
    AFFIX
    =============================================== */
    $('.megamenu').affix({
        offset: {
            top: 800,
            bottom: function() {
                return (this.bottom = $('.footer').outerHeight(true))
            }
        }
    })


})(jQuery);

/** TEXT ANIMATION **/

var TxtType = function(el, toRotate, period) {
                this.toRotate = toRotate;
                this.el = el;
                this.loopNum = 0;
                this.period = parseInt(period, 10) || 2000;
                this.txt = '';
                this.tick();
                this.isDeleting = false;
            };
         
            TxtType.prototype.tick = function() {
                var i = this.loopNum % this.toRotate.length;
                var fullTxt = this.toRotate[i];
         
                if (this.isDeleting) {
                this.txt = fullTxt.substring(0, this.txt.length - 1);
                } else {
                this.txt = fullTxt.substring(0, this.txt.length + 1);
                }
         
                this.el.innerHTML = '<span class="wrap">'+this.txt+'</span>';
         
                var that = this;
                var delta = 200 - Math.random() * 100;
         
                if (this.isDeleting) { delta /= 2; }
         
                if (!this.isDeleting && this.txt === fullTxt) {
                delta = this.period;
                this.isDeleting = true;
                } else if (this.isDeleting && this.txt === '') {
                this.isDeleting = false;
                this.loopNum++;
                delta = 500;
                }
         
                setTimeout(function() {
                that.tick();
                }, delta);
            };
         
            window.onload = function() {
                var elements = document.getElementsByClassName('typewrite');
                for (var i=0; i<elements.length; i++) {
                    var toRotate = elements[i].getAttribute('data-type');
                    var period = elements[i].getAttribute('data-period');
                    if (toRotate) {
                      new TxtType(elements[i], JSON.parse(toRotate), period);
                    }
                }
                // INJECT CSS
                var css = document.createElement("style");
                css.type = "text/css";
                css.innerHTML = ".typewrite > .wrap { border-right: 0.08em solid #fff}";
                document.body.appendChild(css);
            };   
   

         
          

		 
/** slider js **/

(function( $ ) {
         
         //Function to animate slider captions 
         function doAnimations( elems ) {
         //Cache the animationend event in a variable
         var animEndEv = 'webkitAnimationEnd animationend';
         
         elems.each(function () {
         var $this = $(this),
         $animationType = $this.data('animation');
         $this.addClass($animationType).one(animEndEv, function () {
         $this.removeClass($animationType);
         });
         });
         }
         
         //Variables on page load 
         var $myCarousel = $('#carousel-example-generic'),
         $firstAnimatingElems = $myCarousel.find('.item:first').find("[data-animation ^= 'animated']");
         
         //Initialize carousel 
         $myCarousel.carousel();
         
         //Animate captions in first slide on page load 
         doAnimations($firstAnimatingElems);
         
         //Pause carousel  
         $myCarousel.carousel('pause');
         
         
         //Other slides to be animated on carousel slide event 
         $myCarousel.on('slide.bs.carousel', function (e) {
         var $animatingElems = $(e.relatedTarget).find("[data-animation ^= 'animated']");
         doAnimations($animatingElems);
         });  
         
         })(jQuery);
		 

		 