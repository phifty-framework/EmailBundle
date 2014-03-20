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

class EmailException extends Exception { }

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

    public static function loadTemplateRecord($handle, $lang = null) {
        $lang = $lang ?: kernel()->locale->current();
        $record = new EmailTemplate(array( 
            'handle' => $handle,
            'lang' => $lang, 
        ));
        if ( $record->id ) {
            return $record;
        }
        return null;
    }

    public function getTitle() {
        $loader = new Twig_Loader_String();
        $twig = new Twig_Environment($loader);

        $titleTemplate = $this->defaultTitle;

        if ( $this->useModelTemplate ) {    // from db
            if ( ! $this->templateHandle ) {
                throw new EmailException("Template handle is not defined.");
            }
            $mailTemplate = self::loadTemplateRecord($this->templateHandle, $this->lang);
            if ( $mailTemplate && $mailTemplate->title ) {
                $titleTemplate = $mailTemplate->title;
            }
        }
        return $twig->render($titleTemplate, $this->getData());
    }

    public function getContent()
    {
        if ( ! $this->useModelTemplate ) {    // from db
            return parent::getContent();
        }

        if ( ! $this->templateHandle ) {
            throw new EmailException("Template handle is empty.");
        }

        $mailTemplate = self::loadTemplateRecord($this->templateHandle, $this->lang);
        if ( ! $mailTemplate ) {
            throw new EmailException("Email template with handle '{$this->templateHandle}' not found.");
        }
        $fsLoader = kernel()->twig->loader;   // framework 提供的 file system loader

        // a custom array loader with _email.html template
        // the "_email.html" must be unique
        $arrayLoader = new Twig_Loader_Array(array(
            '_email.html' => $mailTemplate->content
        ));
        
        // lookup template from the array loader first, then the file system loader.
        $chainLoader = new Twig_Loader_Chain(array($arrayLoader, $fsLoader));

        // create another twig environment for this chained loader.
        $twig = new Twig_Environment($chainLoader);
        return $twig->render('_email.html',  $this->getData());
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
        if ( empty($args) || ! isset($args[0]) ) {
            throw new EmailException("Wrong Namespace For Email template path.");
        }
        $topNs = $args[0]; // top level namespace
        return join('/','email', '@' . $topNs, $lang, $this->templateHandle . '.html');
    }
}


