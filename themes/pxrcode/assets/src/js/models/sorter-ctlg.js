jQuery(function ($) {

   const $window = $(window);

   $.fn.pxr_sorter = function () {

      const $this = $(this);
      let loading = false;

      $this.on('click', '.pxr-ctlg-section__sorter', function () {

         const termid = $(this).data('termid');

         function pxr_sorter_load(callback) {

            if (!loading) {
               loading = true;
               const data = {
                  action: 'pxr_ajax_sorter',
                  nonce: pxrsorter.nonce,
                  query: pxrsorter.query,
                  termid: termid,
               };
               $.post(pxrsorter.url, data, function (res) {

                  if (res.success) {
                     const $content = $(res.data),
                        content = $this.find('.pxr-ctlg-section__content');

                     content.html($content);

                     const articles = $this.find('.pxr-ctlg-section__articles'),
                        maxPage = articles.data('maxpage');

                     articles.attr('data-termid', termid);

                     if (maxPage > 1) {
                        articles.after('<div class="loadmore-container"><div class="load-wrapper"><div class="loadmore_gallery fade-animation"><span>' + pxrloadmore.button_text + '</span>' + '</div></div></div>');
                     }

                     loading = false;
                     callback();

                  } else {
                     //console.log('2');
                  }
               }).fail(function (xhr, textStatus, e) {
                  console.log(xhr.responseText);
               });
            }
         }

         const $container = $this.find('.pxr-ctlg-section__wrapper'),
            fadeAnimation = $container.find('.fade-animation');

         if (fadeAnimation.css('opacity') == 1) {

            fadeAnimation.removeClass('loaded-animation');
            fadeAnimation.addClass('progress-animation');

            pxr_sorter_load(function () {

               const fadeAnimation = $container.find('.fade-animation');
               fadeAnimation.each(function () {
                  if ($(this).offset().top < $window.scrollTop() + ($window.height() / 10) * 8) {
                     $(this).addClass('loaded-animation');
                  }
               });
            });
         }
      })
   }

   if ($('.pxr-ctlg-section').length) {
      $('.pxr-ctlg-section').each(function () {
         $(this).pxr_sorter();
      })
   }

});