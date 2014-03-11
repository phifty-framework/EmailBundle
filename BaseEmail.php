<?php
namespace EmailBundle;
use Phifty\Message\Email;
use EmailBundle\Model\EmailTemplate;
use Exception;

abstract class BaseEmail extends Email
{
    public $useModelTemplate = false;  // 預設是關閉的

    public $templateHandle;

    public $defaultTitle;

    public function getTitle() {

        if ( $this->useModelTemplate ) {    // from db

            if ( $this->templateHandle ) {
                $mailTemplate = new EmailTemplate([ 'handle' => $this->templateHandle ]);                
                return empty($mailTemplate->title) ? $this->defaultTitle : $mailTemplate->title;
            } else {
                throw new Exception("Template handle is empty.");
            }
        } else {
            return $this->defaultTitle;
        }
    }

    public function getContent()
    {
        if ( $this->useModelTemplate ) {    // from db

            if ( $this->templateHandle ) {
                $mailTemplate = new EmailTemplate([ 'handle' => $this->templateHandle ]);
            } else {
                throw new Exception("Template handle is empty.");
            }

            $fsLoader = kernel()->twig->loader;   // framework 提供的 file system loader

            $arrayLoader = new \Twig_Loader_Array(array(
                'email.html' => $mailTemplate->content
            ));
            
            // 把 arrayLoader 跟 fsLoader 丟給 chainLoader
            $chainLoader = new \Twig_Loader_Chain(array($fsLoader, $arrayLoader));

            // 另外 create 一個新的 twig environment
            $twig = new \Twig_Environment($chainLoader);

            return $twig->render('email.html',  $this->getData());

        } else {    // from templates
            return parent::getContent();
        }
    }
}





