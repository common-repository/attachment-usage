auMediaFrameModule = (function($){
    'use strict';
    
    var $document = $(document);
    var attachmentUploader;
    const i18nApi = wp.i18n;
    
    var auAttachmentFrame = {
        checkValidType: function(type){
            var supportedTypes = ['image', 'application'];
            if($.inArray(type, supportedTypes) !== -1){
                return true;
            }
            return false;
        },
        initAttachmentLibrary: function($el, $attachmentType){
            if(wp.media !== undefined){
                attachmentUploader = wp.media.frames.file_frame = wp.media({
                    title: i18nApi.__('Choose Attachment', 'attachment-usage'),
                    className: 'replace media-frame mode-select wp-core-ui hide-menu',
                    library:{
                        type:$attachmentType
                    },               
                    button:{
                        text: i18nApi.__('Choose Attachment', 'attachment-usage')
                    },
                    multiple: false                
                });
                
                attachmentUploader.on('select', function(){
                    auAttachmentFrame.selectAttachment($el, $attachmentType);
                });
                attachmentUploader.states.get('library').get('library').observe( wp.Uploader.queue );           
                attachmentUploader.open();
            }
        },
        selectAttachment: function($el, $attachmentType){
            var attachment = attachmentUploader.state().get('selection').first().toJSON();
            var parentElm = $el.parent();
            
            if($attachmentType === 'image'){
                parentElm.find('img.preview-holder').prop('src', attachment.url);
            }else if($attachmentType === 'application'){
                parentElm.find('a.file-link').prop('href', attachment.url);
                parentElm.find('a.file-link').html(attachment.title);
            }
            parentElm.find('input[type="hidden"]').val(attachment.id);
            parentElm.find('.remove-attachment').removeClass('hide');
            $('body .replace.media-frame .compat-attachment-fields').remove();
            attachmentUploader.states.get('library').get('library').observe( wp.Uploader.queue );           
        },
        removeAttachment: function($el, $attachmentType){
            var parentElm = $el.parent();
            
            if($attachmentType === 'image')
                parentElm.find('img.preview-holder').removeAttr('src');
            else if($attachmentType === 'application'){
                parentElm.find('a.file-link').removeAttr('href');
                parentElm.find('a.file-link').html('');
            }
            parentElm.find('.remove-attachment').addClass('hide');
            parentElm.find('input[type="hidden"]').val(0);
        }
    };
    
    $document.on('click', 'button.upload-attachment', function(e){
        e.preventDefault();
        var $el = $(this);
        var $attachmentType = $el.data('type');
        
        if(auAttachmentFrame.checkValidType($attachmentType)){
            auAttachmentFrame.initAttachmentLibrary($el, $attachmentType);
        }
    }); 

    $document.on('click', '.remove-attachment', function(e){
        e.preventDefault();
        var $el = $(this);
        var btn = $el.parent().find('button');
        var $attachmentType = btn.data('type');
        
        if(auAttachmentFrame.checkValidType($attachmentType)){
            auAttachmentFrame.removeAttachment($el, $attachmentType);
        }
    });

    
})(jQuery);