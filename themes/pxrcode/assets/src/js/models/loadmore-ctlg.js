jQuery(function ($) {

   const $window = $(window);

   $.fn.pxr_load_more_gl = function () {

      const $this = $(this),
         sorter = $this.find('.pxr-ctlg-section__sorter'),
         articles = $this.find('.pxr-ctlg-section__articles'),
         maxPage = articles.data('maxpage');

      let page = 2,
         loading = false;

      if (maxPage > 1) {
         articles.after('<div class="loadmore-container"><div class="load-wrapper"><div class="loadmore_gallery fade-animation"><span>' + pxrloadmore.button_text + '</span>' + '</div></div></div>');
      }

      sorter.on('click', function () {
         page = 2;
      });

      $this.on('click', '.loadmore_gallery', function () {

         const button = $this.find('.loadmore_gallery'),
            buttonWrapper = button.parent(),
            termid = $this.find('.pxr-ctlg-section__articles').data('termid');

         buttonWrapper.animate({ opacity: '0' }, 100);

         if (!loading) {
            loading = true;

            const data = {
               action: 'pxr_ajax_load_more',
               nonce: pxrloadmore.nonce,
               page: page,
               termid: termid,
               query: pxrloadmore.query,
            };

            $.post(pxrloadmore.url, data, function (res) {
               if (res.success) {

                  const $content = $(res.data),
                     content = $this.find('.pxr-ctlg-section__content');

                  content.find('.pxr-ctlg-section__articles >*:last-child').after($content);

                  const maxPage = content.find('.pxr-ctlg-section__articles').data('maxpage'),
                     button = $this.find('.loadmore_gallery'),
                     buttonWrapper = button.parent();

                  //Hide the Load More button if no more posts to load
                  if (page >= maxPage) {
                     button.hide();
                  } else {
                     page = page + 1;
                     const button = buttonWrapper.html('<div class="loadmore_gallery fade-animation"><span>' + pxrloadmore.button_text + '</span>' + '</div>');
                     button.animate({ opacity: '1' }, 100);
                  }

                  const fadeAnimation = content.find('.fade-animation');
                  setTimeout(function () {
                     fadeAnimation.each(function () {
                        if ($(this).offset().top < $window.scrollTop() + ($window.height() / 10) * 8) {
                           $(this).addClass('loaded-animation');
                        }
                     });
                  }, 200)

                  loading = false;
                  return false;
               } else {
                  // console.log(res);
               }
            }).fail(function (xhr, textStatus, e) {
               // console.log(xhr.responseText);
            });
         };
      })
   }

   if ($('.pxr-ctlg-section').length) {
      $('.pxr-ctlg-section').each(function () {
         $(this).pxr_load_more_gl();
      });
   }

});