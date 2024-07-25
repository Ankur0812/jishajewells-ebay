jQuery(document).ready(function($) {
    $('.jj-copy-button').on('click', function() {
        var productId = $(this).data('product-id');
        const span = $(this).find('.dashicons');
        const copiedText = $(this).data('copied-text');
        const textchange = $(this).find('.jj-button-text');
        console.log(copiedText);
        console.log(textchange);
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'jj_copy_data',
                product_id: productId,
            },
            success: function(response) {
                console.log("Response = ",response.data);
                span.removeClass('dashicons-admin-page');
                span.addClass('dashicons-yes');
                
                textchange.text(copiedText);
                copyTextToClipboard(response.data)
            },
            error: function(xhr, status, error) {
                console.log('AJAX Error:', error);
            }
        });
    });

    $('.jj-copy-button').on('mouseleave', function() {
        const span = $(this).find('.dashicons');
        const defaultText = $(this).data('default-text');
        span.removeClass('dashicons-yes');
        span.addClass('dashicons-admin-page');
        $(this).find('.jj-button-text').text(defaultText);
    });

    function copyTextToClipboard(text) {
        var tempInput = document.createElement('input');
        tempInput.value = text;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);
    }
});
