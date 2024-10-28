<?php
namespace AttachmentUsage\Core;

class Attachment_Type{
    
    private $document_types = ['application/msword'
        ,'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ,'application/vnd.ms-word.document.macroEnabled.12'
        ,'application/vnd.ms-word.template.macroEnabled.12'
        ,'application/vnd.oasis.opendocument.text','application/vnd.apple.pages'
        ,'application/pdf','application/vnd.ms-xpsdocument','application/oxps,application/rtf'
        ,'application/wordperfect','application/octet-stream'];
    private $archive_types = ['application/x-gzip','application/rar','application/x-tar'
        ,'application/zip','application/x-7z-compressed'];
    private $table_types = ['application/vnd.apple.numbers','application/vnd.oasis.opendocument.spreadsheet'
        ,'application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ,'application/vnd.ms-excel.sheet.macroEnabled.12','application/vnd.ms-excel.sheet.binary.macroEnabled.12'];
    private $media_file_type;
    
    
    public function __construct($media_file_type) {
        $this->media_file_type = $media_file_type;
    }
    
    public function get_attachment_type(){
        switch(TRUE){
            case explode('/',$this->media_file_type)[0] == 'audio':
                return 'audio';
            case explode('/',$this->media_file_type)[0] == 'video':
                return 'video';
            case explode('/',$this->media_file_type)[0] == 'image':
                return 'image';
            case in_array($this->media_file_type, $this->document_types):
                return 'document';
            case in_array($this->media_file_type, $this->archive_types):
                return 'archive';
            case in_array($this->media_file_type, $this->table_types):
                return 'table';
            default:
                return 'custom';
        }
    }
    
}

