<?php
namespace EmailBundle;
use Phifty\Message\Email;
use EmailBundle\Model\EmailTemplate;
use Exception;

abstract class BaseEmail extends Email
{
    public $useModelTemplate = false;  // 預設是關閉的

    public $templateHandle;

    public function getContent()
    {
        if ( $this->useModelTemplate ) {    // from db

            if ( $this->templateHandle ) {
                $mailTemplate = new EmailTemplate([ 'handle' => $this->templateHandle ]);
                // reset subject from db
                $this['subject'] = kernel()->getApplicationName() . ' - ' . $mailTemplate->subject;
                $this->setSubject( $this['subject'] );
            } else {
                throw new Exception("Template handle is empty.");
            }

            $loader = new \Twig_Loader_String();
            $twig = new \Twig_Environment($loader);
            return $twig->render($mailTemplate->content, $this->getData());
        } else {    // from templates
            return parent::getContent();
        }
    }
}





