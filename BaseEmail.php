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
            $content = $twig->render($mailTemplate->content, $this->getData());

        } else {    // from templates
            $twig = kernel()->twig->env;
            $content = $twig->loadTemplate($this->getTemplate())->render($this->getData());
        }
        return $content;
    }

    public function send() 
    {
        $content = $this->getContent();

        if ( $this->format && $this->format === 'text/markdown' || $this->format === "markdown" ) {
            if ( ! function_exists('Markdown') ) {
                throw new RuntimeException('Markdown library is not loaded.');
            }
            $this->format = 'text/html';
            $content = Markdown($content);
        }

        if ( $this->format ) {
            $this->message->setBody($content,$this->format);
        } else {
            $this->message->setBody($content);
        }
        echo $this->message;
        return kernel()->mailer->send($this->message);
    }
}





