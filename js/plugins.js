;(function() {
  'use strict';

  jQuery(function($) {
    $('li > span', '.accordion').click(function() {
      var $this = $(this);
      $this.parent().toggleClass('open');
    });

    $('.module-button').click(function() {
      $(this).parents('.module').toggleClass('active');
    });

  });

}());

var tag = document.createElement('script');

tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var player;
function onYouTubeIframeAPIReady() {

  jQuery(function($) {
    $('#ashley-video').parent().click(function() {
      player = new YT.Player('ashley-video', {
        height: '307',
        width: '530',
        videoId: 'ibbtgsD2sG8',
        events: {
          'onReady': function(e) {
            e.target.playVideo();
          }
        }
      });
    });
  });

}
