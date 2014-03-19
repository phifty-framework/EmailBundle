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
    }

}
