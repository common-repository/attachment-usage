<?php
namespace AttachmentUsage\SettingsLib;

class Tabbed_Menu_Page extends Menu_Page{
    
    protected $template = 'tabbed_menu_page';
    protected $menu_tabs_holder;
    
    
    public function __construct(array $page_elements, array $options, array $settings, array $tabs) {
        parent::__construct($page_elements, $options, $settings);
        $this->menu_tabs_holder = new Menu_Tabs_Holder($tabs);
        $this->data['tabs'] = $this->menu_tabs_holder->get_tabs();
        $this->data['tabs_clicked'] = $this->menu_tabs_holder->check_tab_clicked();
        $this->data['active_tab'] = $this->menu_tabs_holder->get_active_tab();
    }
    
}
