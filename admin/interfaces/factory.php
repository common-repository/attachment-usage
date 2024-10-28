<?php
namespace AttachmentUsage\Interfaces;

if(!defined('ABSPATH')){
    exit;
}

interface IFactory{
    public function get_object();
}

