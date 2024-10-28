<?php
namespace AttachmentUsage\Interfaces;

if(!defined('ABSPATH')){
    exit;
}

interface IAttachmentOutput{
    public function get_location_info();
    public function get_section_title();
    public function get_edit_link($id);
    public function get_title($id);
}

