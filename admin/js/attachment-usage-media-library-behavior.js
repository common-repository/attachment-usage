auMediaLibraryBehaviorModule = (function($){
    'use strict';
    
    var $document = $(document);
    var isWpMediaDefined = false;
    const i18nApi = wp.i18n;
    
    var auMediaLibraryBehavior = {

        init: function(){
            if(wp.media !== undefined){
                isWpMediaDefined = true;
            }
        },
        addCustomClass: function(){
            if(isWpMediaDefined){
                wp.media.view.Attachment.Library = wp.media.view.Attachment.Library.extend({
                    className: function (){ 
                        return 'attachment ' + this.model.get('custom_class'); 
                    },
                });
            }
        },
        addFetchAttachmentBtn: function(){
            if(isWpMediaDefined){
                wp.media.view.AttachmentsBrowser = wp.media.view.AttachmentsBrowser.extend({               
                    initialize: function() {
                        _.defaults( this.options, {
                                filters: false,
                                search:  true,
                                date:    true,
                                display: false,
                                sidebar: true,
                                AttachmentView: wp.media.view.Attachment.Library
                        });

                        this.controller.on( 'toggle:upload:attachment', this.toggleUploader, this );
                        this.controller.on( 'edit:selection', this.editSelection );

                        // In the Media Library, the sidebar is used to display errors before the attachments grid.
                        if ( this.options.sidebar && 'errors' === this.options.sidebar ) {
                                this.createSidebar();
                        }

                        /*
                         * For accessibility reasons, place the Inline Uploader before other sections.
                         * This way, in the Media Library, it's right after the Add New button, see ticket #37188.
                         */
                        this.createUploader();

                        /*
                         * Create a multi-purpose toolbar. Used as main toolbar in the Media Library
                         * and also for other things, for example the "Drag and drop to reorder" and
                         * "Suggested dimensions" info in the media modal.
                         */
                        this.createToolbar();
                        this.toolbar.set(
                            'fetch-attachment-btn', 
                            new wp.media.view.Button({
                                tagName:    'button',
                                className:  'fetch-attachment-usage',
                                text: i18nApi.__('Fetch Attachment Usage', 'attachment-usage'),
                                style:    '',
                                size:     'large',
                                disabled: false,
                                attributes: { 
                                    type: 'button',
                                    'data-id': 0,
                                    value: obj.ajax_nonce,
                                    id: 'fetch-usage-nonce-0'
                                },
                                priority: -70,
                            })
                        );
                        // Add a heading before the attachments list.
                        this.createAttachmentsHeading();

                        // Create the list of attachments.
                        this.createAttachments();

                        // For accessibility reasons, place the normal sidebar after the attachments, see ticket #36909.
                        if ( this.options.sidebar && 'errors' !== this.options.sidebar ) {
                                this.createSidebar();
                        }

                        this.updateContent();

                        if ( ! this.options.sidebar || 'errors' === this.options.sidebar ) {
                                this.$el.addClass( 'hide-sidebar' );

                                if ( 'errors' === this.options.sidebar ) {
                                        this.$el.addClass( 'sidebar-for-errors' );
                                }
                        }

                        this.collection.on( 'add remove reset', this.updateContent, this );

                        // The non-cached or cached attachments query has completed.
                        this.collection.on( 'attachments:received', this.announceSearchResults, this );
                    }
                });
            }
        },
        modifyContentAfterAjaxSync: function(){
            if(isWpMediaDefined){
                wp.media.view.AttachmentCompat = wp.media.view.AttachmentCompat.extend({
                    render: function() {
                        var compat = this.model.get('compat');
                        if ( ! compat || ! compat.item ) {
                                return;
                        }

                        this.views.detach();                
                        this.$el.html( compat.item );

                        if($('li.attachment[data-id="'+this.model.id+'"]').length
                                && $('li.attachment[data-id="'+this.model.id+'"]').hasClass('ajax-fetched')){                       
                            var el_html = $('.attachment-usage-wrapper',this.$el);
                            var ajax_fetched_data = JSON.parse(localStorage.getItem('ajax-fetched-attachment-content'));
                            if(this.model.id == ajax_fetched_data.id){
                                el_html[0].innerHTML = ajax_fetched_data.content;
                            }
                        }
                        this.views.render();
                        return this;
                    }
                });
            }
        },
        refreshContent: function(){
            if(isWpMediaDefined && wp.media.frame !== undefined){
                if(wp.media.frame.content.get() !== null){
                    wp.media.frame.content.get().collection.props.set({ignore: (+ new Date())});
                    wp.media.frame.content.get().options.selection.reset();
                }else{
                    wp.media.frame.library.props.set ({ignore: (+ new Date())});
                }
            }
        },
        provideCustomBehavior: function(paramsObject){
            if(paramsObject.render_fetch_attachment_button){
                this.addFetchAttachmentBtn();
            }
            if(paramsObject.display_custom_class){
                this.addCustomClass();
            }
            this.modifyContentAfterAjaxSync();
        },
        provideCustomBehaviorWidgets: function(paramsObject){
            if(paramsObject.display_custom_class){
                this.addCustomClass();
            }
            this.modifyContentAfterAjaxSync();
        },
        ajaxFetchAttachmentContent: function(e, $currentElm){
            e.preventDefault();
            var attachment_id = $currentElm.data('id');
            var spinner = $currentElm.parent().find('span.spinner');
            spinner.addClass('show');
            var nonce = $currentElm.val();

            $.ajax({
                type : "post",
                dataType : "json",
                url : ajaxurl,
                data : {
                    action: "fetch_attachment_usage", 
                    attachment_id: attachment_id, 
                    _wpnonce: nonce
                },
                success: function(response) {
                    spinner.removeClass('show');
                    if(!response.success){
                        alert(response.data);
                    }else{
                        if(response.data.content !== null) {
                            jQuery('body .attachment-usage-wrapper').html(response.data.content);                       
                            var attachment_elm = $('li.attachment[data-id="'+attachment_id+'"]');
                            var ajax_content = {id: attachment_id, content: response.data.content};
                            localStorage.setItem('ajax-fetched-attachment-content', JSON.stringify(ajax_content));

                            if(obj.display_custom_class){
                                if(response.data.is_found && attachment_elm.length){
                                    attachment_elm.removeClass('not-found');
                                    attachment_elm.addClass('found');
                                }else{
                                    attachment_elm.removeClass('found');
                                    attachment_elm.addClass('not-found');
                                }
                            }
                            attachment_elm.addClass('ajax-fetched');
                        }else{
                            location.reload();
                        }
                    }                },
                error: function(xhr, error, status){
                    console.log(error, status);
                    spinner.removeClass('show');
                }
            });
        }
    };
    
    return {auMediaLibraryBehavior: auMediaLibraryBehavior};
})(jQuery);