<?php
namespace EmailBundle;
use Phifty\Message\Email;
use EmailBundle\Model\EmailTemplate;
use Exception;
use ReflectionObject;
use Twig_Loader_Array;
use Twig_Loader_Chain;
use Twig_Environment;
use Twig_Loader_String;

abstract class BaseEmail extends Email
{

    /**
     * @var boolean Should we use the email template from database ?
     */
    public $useModelTemplate = false;  // 預設是關閉的

    /**
     * @var string $templateHandle is used for finding template files or a email 
     *             template entry in database.
     */
    public $templateHandle;


    /**
     * @var string pre-defined email title
     *
     * A title is a part of a subject, that is, subject includes site name as its prefix 
     * and append the title.
     */
    public $defaultTitle;

    /**
     * @var string default language, optional.
     */
    public $lang;

    public function getTitle() {
        if ( $this->useModelTemplate ) {    // from db
            if ( $this->templateHandle ) {
                // get the current locale as it's handle.
                if(!$this->lang) {
                    $this->lang = kernel()->locale->current();
                }
                $mailTemplate = new EmailTemplate(array( 
                    'handle' => $this->templateHandle, 
                    'lang' => $this->lang 
                ));
                if ( empty($mailTemplate->title)) {
                    return $this->defaultTitle;
                } else {
                    $loader = new Twig_Loader_String();
                    $twig = new Twig_Environment($loader);
                    return $twig->render($mailTemplate->title, $this->getData());
                }
            } else {
                throw new Exception("Template handle is empty.");
            }
        }
        return $this->defaultTitle;
    }

    public function getContent()
    {
        if ( $this->useModelTemplate ) {    // from db

            if ( $this->templateHandle ) {
                if(!$this->lang) {
                    $this->lang = kernel()->locale->current();
                }
                $mailTemplate = new EmailTemplate(array( 
                    'handle' => $this->templateHandle, 
                    'lang' => $this->lang 
                ));
            } else {
                throw new Exception("Template handle is empty.");
            }

            $fsLoader = kernel()->twig->loader;   // framework 提供的 file system loader

            // a custom array loader with email.html template
            $arrayLoader = new Twig_Loader_Array(array(
                'email.html' => $mailTemplate->content
            ));
            
            // 把 arrayLoader 跟 fsLoader 丟給 chainLoader
            $chainLoader = new Twig_Loader_Chain(array($fsLoader, $arrayLoader));

            // 另外 create 一個新的 twig environment
            $twig = new \Twig_Environment($chainLoader);

            return $twig->render('email.html',  $this->getData());

        } else {    // from templates
            return parent::getContent();
        }
    }

    /**
     * This method returns a template file path in this format:
     *
     * @return string template file path for twig
     *
     *      @{bundleName}/email/{lang}/{templateHandle}.html
     */
    public function getTemplateSubPath() {
        $ro = new ReflectionObject($this);
        $args = explode('\\',$ro->getNamespaceName());
        $topNs = $args[0]; // top level namespace
        return join('/','email', '@' . $topNs, $lang, $this->templateHandle . '.html');
    }
}





