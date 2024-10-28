<?php
namespace AttachmentUsage\Core;

/*
    The intention of this class is to minimize unnecessary db calls.
    The original function "wp_get_attachment_url" fetches the post by id
    and therefore create queries. https://developer.wordpress.org/reference/functions/wp_get_attachment_url/
    Due to the design of the plugin, all relevant attachment data will be fetched once
    and the relevant information is passed to this class. The rest of the class is 
    mainly based on the function "wp_get_attachment_url"
*/
class File_Url_Handler{
    
    private $attached_file;
    private $guid;
    private $url = '';
    
    
    public function __construct($attached_file, $guid){
        $this->attached_file = $attached_file;
        $this->guid = $guid;
        $this->prepare_url();
    }
    
    private function prepare_url(){
        if(!$this->is_valid_url_path()){
            $this->url = $this->guid;
        }
        $this->prepare_https_scheme();    
    }
    
    private function is_valid_url_path(){
        $url = '';
        $uploads = wp_get_upload_dir();
        $file = $this->attached_file;
        
        if ( $uploads && false === $uploads['error'] ) {
            // Check that the upload base exists in the file location.
            if ( 0 === strpos( $file, $uploads['basedir'] ) ) {
                // Replace file location with url location.
                $url = str_replace( $uploads['basedir'], $uploads['baseurl'], $file );
            } elseif ( false !== strpos( $file, 'wp-content/uploads' ) ) {
                // Get the directory name relative to the basedir (back compat for pre-2.7 uploads)
                $url = trailingslashit( $uploads['baseurl'] . '/' . _wp_get_attachment_relative_path( $file ) ) . wp_basename( $file );
            } else {
                // It's a newly-uploaded file, therefore $file is relative to the basedir.
                $url = $uploads['baseurl'] . "/$file";
            }
        }
        if(!empty($url)){
            $this->url = $url;
            return TRUE;
        }
        return FALSE;
    }
    
    private function prepare_https_scheme(){
        if (is_ssl() && ! is_admin() && 'wp-login.php' !== $GLOBALS['pagenow']){
            $this->url = set_url_scheme( $this->url );
	}
    }
    
    public function get_url(){
        return $this->url;
    }
    
}

