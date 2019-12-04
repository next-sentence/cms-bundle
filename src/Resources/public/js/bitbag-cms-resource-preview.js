(function ( $ ) {
    'use strict';

    $.fn.extend({
        cmsResourcePreview: function(callback) {
            return this.each(function() {
                return $(this).on('click', function(event) {
                    event.preventDefault();

                    if (callback !== undefined) {
                        callback();
                    }
                    
                    var actionButton = $(this);
                    var form = actionButton.closest('form');
                    var url = actionButton.data('url');
                    var root = $('#lwc-cms-resource-preview-modal');

                    createPreview(form, url);

                    return root.modal('show');
                });
            });
        }
    });

    function createPreview(form, url) {
        $('#lwc-cms-resource-preview-modal .ui.loadable').addClass('loading');

        var localeCode = $('#lwc_cms_locale_switch').val();

        $.ajax({
            url: url + '?' + '_locale=' + localeCode,
            type: 'POST',
            data: new FormData(form[0]),
            processData: false,
            contentType: false,
            cache: false,
        }).done(function(response) {
            console.log(response)
            var src = 'data:text/html;charset=utf-8, ' + encodeURIComponent(response);

            $('#lwc-cms-resource-preview-modal iframe').attr('src', src);
            $('#lwc-cms-resource-preview-modal .ui.loadable').removeClass('loading');
        });
    }
})( jQuery );

(function($) {
    $(document).ready(function () {
        $('.lwc-cms-resource-preview').cmsResourcePreview(function () {
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
        })
    });
})(jQuery);
