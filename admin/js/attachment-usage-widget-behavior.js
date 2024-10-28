var auWidgetBehaviorModule = (function($){
    'use strict';
    
    var $document = $(document);
    var module = auMediaLibraryBehaviorModule;
    var auMediaLibraryBehavior = module.auMediaLibraryBehavior;
    
    var auWidgetBehavior = {
        removeWidget: function(){
            console.log("REMOVE");
            this.syncAttachments(obj);
        },
        bindRemove: function(event, widgetContainer){
            var $this = this;
            $('#'+widgetContainer.prop('id')).bind('remove', function(){
                console.log("Inside BIND");
                $this.syncAttachments(obj);
            });
        },        
        syncAttachments: function(paramsObject){
            var attachment_id = 0;
            var nonce = paramsObject.ajax_nonce;
            
            $.ajax({
                type: "post",
                dataType: "json",
                url: ajaxurl,
                data: {
                    action: "fetch_attachment_usage", 
                    attachment_id: attachment_id, 
                    _wpnonce: nonce
                },
                success: function(response) {
                    if(!response.success){
                        alert(response.data);
                    }else{
                        auMediaLibraryBehavior.refreshContent();
                    }                
                },
                error: function(xhr, error, status){
                    console.log(error, status);
                }
            });
        },
        displayWidgetsOfFoundAttachments: function(){
            var searchParams = new URLSearchParams(window.location.search);
            if(searchParams.has('show_widgets') && searchParams.has('widget_elements')){
                var sidebar = searchParams.get('show_widgets');
                var widgets = searchParams.get('widget_elements');
                widgets = widgets.split(',');

                if($('#'+sidebar).parent().hasClass('closed')){
                    $('#'+sidebar+' .handlediv').trigger('click');
                }
                $.each(widgets, function(key,value){
                    var selector = $('#'+sidebar+' [id$='+value+']');
                    if(!selector.hasClass('open')){
                        $('.widget-action', selector).trigger('click');
                    }
                });            
            }
        }
    };
    
    $document.ready(function(){
        auMediaLibraryBehavior.init();
        auMediaLibraryBehavior.provideCustomBehaviorWidgets(obj);
        
        $document.on('widget-added', function(event, widgetContainer) {
            auWidgetBehavior.bindRemove(event, widgetContainer);      
        });
        
        $('div.widget').on('remove', function() {
            auWidgetBehavior.removeWidget();      
        });

        $document.on('widget-updated', function(e, widget){
            auWidgetBehavior.syncAttachments(obj);
        });

        $document.on('click', 'button.add_media, button.select-media', function(){
            auMediaLibraryBehavior.refreshContent();
        });

        $document.on('click', 'button.fetch-attachment-usage', function(e){
            var $currentElm = $(this);
            auMediaLibraryBehavior.ajaxFetchAttachmentContent(e, $currentElm);
        });

        $(window).load(function(){
            auWidgetBehavior.displayWidgetsOfFoundAttachments();
        });

    });
               
})(jQuery);

