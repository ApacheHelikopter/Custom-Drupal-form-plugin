(function ($) {

  $('.js-social-media-links a').click(function (evt) {
    $.ajax({
      type: 'POST',
      url: '/ajax/thomas-more-social-media/counter',
      data: {
        'network': $(this).data('network'),
      },
    });
  });

})(jQuery);
