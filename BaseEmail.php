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
     * @var string default language, optional.
     */
    public $lang;

    public $bundle;

    public function __construct() {
        parent::__construct();
        $this->bundle = $this->findBundle();
        if ( $this->bundle ) {
            $this->useModelTemplate = $this->bundle->config('UseModelTemplate');
        }
    }


    // find bundle object
    public function findBundle() {
        $ro = new ReflectionObject($this);
        $args = explode('\\',$ro->getNamespaceName());
        if ( count($args) > 0 ) {
            $ns = $args[0];
            return kernel()->bundle($ns);
        }
    }

    public static function loadTemplateRecord($handle, $lang = null) {
        $lang = $this->getLang();
        $record = new EmailTemplate(array( 
            'handle' => $handle,
            'lang' => $lang, 
        ));
        if ( $record->id ) {
            return $record;
        }
        return null;
    }

    public function getLang() {
        return $this->lang ?: kernel()->locale->current();
    }


    /**
     *
     */
    public function renderSubject() 
    {
        if ( ! $this->useModelTemplate ) {    // from db
            return parent::renderSubject();
        }

        $loader = new Twig_Loader_String();
        $twig = new Twig_Environment($loader);
        $subjectTpl = kernel()->getApplicationName() . ' - ' . $this->title();
        if ( ! $this->templateHandle ) {
            throw new EmailException("Template handle is not defined.");
        }
        $mailTemplate = self::loadTemplateRecord($this->templateHandle, $this->lang);
        if ( $mailTemplate && $mailTemplate->title ) {
            $subjectTpl = kernel()->getApplicationName() . ' - ' . $mailTemplate->title;
        }
        return $twig->render($subjectTpl, $this->getData());
    }

    public function renderContent()
    {
        if ( ! $this->useModelTemplate ) {    // from file system
            return parent::renderContent();
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
            '_email.html' => $mailTemplate->content,
        ));
        
        // lookup template from the array loader first, then the file system loader.
        $chainLoader = new Twig_Loader_Chain(array($arrayLoader, $fsLoader));

        // create another twig environment for this chained loader.
        $twig = new Twig_Environment($chainLoader);
        return $twig->render('_email.html',  $this->getData());
    }

    public function template() {
        return $this->getTemplateSubPath();
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
        return join('/',array('@' . $topNs, 'email', $this->getLang(), $this->templateHandle . '.html') );
    }
}


