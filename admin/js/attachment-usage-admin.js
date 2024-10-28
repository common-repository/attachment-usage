(function($) {
    'use strict';
    
    var $document = $(document);
    var module = auMediaLibraryBehaviorModule;
    var auMediaLibraryBehavior = module.auMediaLibraryBehavior;

    $document.ready(function(){
        auMediaLibraryBehavior.init();
        auMediaLibraryBehavior.provideCustomBehavior(obj);
        
        $document.on('click', 'button.fetch-attachment-usage', function(e){
            var $currentElm = $(this);
            auMediaLibraryBehavior.ajaxFetchAttachmentContent(e, $currentElm);
        });
        
        $document.on('click', '.au-dismiss-rating-banner', function(e){
            e.preventDefault();
            var spinner = $(this).parent().find('.spinner');
            var nonce = $(this).data('nonce');
            spinner.addClass('show');
            
            $.ajax({
                type : "post",
                dataType : "json",
                url : ajaxurl,
                data : {
                    action: "au_dismiss_rating_banner", 
                    _wpnonce: nonce
                },
                success: function(response){
                    spinner.removeClass('show');
                    $('.au-rating-banner').remove();
                    console.log(response.data);  
                },
                error: function(xhr, error, status){
                    spinner.removeClass('show');
                    $('.au-rating-banner').remove();
                    console.log(error, status);
                }
            });
            
        })
    });
})(jQuery);
