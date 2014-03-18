<?php
namespace EmailBundle;
use Phifty\Bundle;

class EmailBundle extends Bundle
{
    public function assets() {
        return array();
    }

    public function defaultConfig() {
        return array();
    }

    public function init() 
    {
        $this->expandRoute('/bs/email_template', 'EmailTemplateCRUDHandler');
        if ( $this->config('Management') ) {
            kernel()->event->register( 'adminui.init_menu' , function($menu) {
                $menu->createCrudMenuItem( 'email_template', _('Email 管理') );
            });
        }
    }
}
