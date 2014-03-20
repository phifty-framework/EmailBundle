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

    public function getSystemMail() {
        $mailConfig = kernel()->config->get('framework','Mail');
        if ( isset($mailConfig['System']) ) {
            $mail = $mailConfig['System'];
            if( preg_match( '#"?(.*?)"??\s+<(.*?)>#i', $mail, $regs) ) {
                return array( $regs[2] => $regs[1] );
            } else {
                return array(
                    $mail => kernel()->getApplicationName(),
                );
            }
        }
        // the default mailer
        return array(
            'no-reply@' . kernel()->getHost() => kernel()->getApplicationName(),
        );
    }

    public function getAdminMail() {
        $mailConfig = kernel()->config->get('framework','Mail');
        if ( isset($mailConfig['Admin']) ) {
            $mail = $mailConfig['Admin'];
            if( preg_match( '#"?(.*?)"??\s+<(.*?)>#i' , $mail ,$regs ) ) {
                return array(
                    /* address => name */
                    $regs[2] => $regs[1],
                );
            } else {
                return array( $mail => 'Administrator' );
            }
        }
        throw new Exception('The Email address of Administrator is not defined.');
    }

}
