<?php

namespace EmailBundle;

use Phifty\Message\Email;
use EmailBundle\Model\EmailTemplate;
use Exception;
use ReflectionObject;
use Twig_Loader_Array;
use Twig_Loader_Chain;
use Twig_Environment;
use Twig_Extensions_Extension_Text;
use Twig_Extensions_Extension_I18n;

class EmailException extends Exception
{
}


/**
 * A BaseEmail class composite the Swift_Message class and extends from Phifty\Email
 *
 * It can read templates from database or use the template from file system.
 *
 * A simple use case could be something like this:
 *
 *
 * @code
 * $email = new UserEmail;
 *
 *
 * // you can set the arguments manually
 * $email->setArguments([ ... ]);
 *
 * // or through the array access interface
 * $email['username'] = 'John ';
 * $email['phone'] = '123456';
 * $email->send();
 *
 * @code
 */
abstract class BaseEmail extends Email
{
    /**
     * @var bool Should we use the email template from database ?
     */
    public $useModelTemplate = false;  // 預設是關閉的

    /**
     * @var string is used for finding template files or a email 
     *             template entry in database.
     */
    public $templateHandle;

    /**
     * @var string default language, optional.
     */
    public $lang;

    public $bundle;

    public function __construct()
    {
        parent::__construct();

        if ($emailBundle = kernel()->bundle('EmailBundle')) {
            $a = $emailBundle->config('UseModelTemplate');
            if ($a !== null) {
                $this->useModelTemplate = $a;
            }
        }

        // External Bundles can override the global config:
        //
        //   MemberBundle:
        //     UseModelTemplate: true
        //
        $this->bundle = $this->getBundleInstance();
        if ($this->bundle) {
            $a = $this->bundle->config('UseModelTemplate');
            if ($a !== null) {
                $this->useModelTemplate = $a;
            }
        }
    }

    // find bundle object
    public function getBundleInstance()
    {
        $ro = new ReflectionObject($this);
        $args = explode('\\', $ro->getNamespaceName());
        if (count($args) > 0) {
            $ns = $args[0];

            return kernel()->bundle($ns);
        }
    }

    public static function loadTemplateRecord($handle, $lang)
    {
        $record = EmailTemplate::load([
            'handle' => $handle,
            'lang' => $lang,
        ]);

        if ($record) {
            return $record;
        }

        return;
    }

    public function getLang()
    {
        return $this->lang ?: kernel()->locale->current();
    }

    /**
     *
     */
    public function renderSubject()
    {
        if (!$this->useModelTemplate) {    // from db
            return parent::renderSubject();
        }

        $subjectTpl = kernel()->getApplicationName().' - '.$this->title();
        if (!$this->templateHandle) {
            throw new EmailException('Template handle is not defined.');
        }
        $mailTemplate = self::loadTemplateRecord($this->templateHandle, $this->getLang());
        if ($mailTemplate && $mailTemplate->title) {
            $subjectTpl = kernel()->getApplicationName().' - '.$mailTemplate->title;
        }

        $loader = new Twig_Loader_Array(['subject.tpl' => $subjectTpl]);
        $twig = new Twig_Environment($loader);

        return $twig->render('subject.tpl', $this->getArguments());
    }

    public function renderContent()
    {
        if (!$this->useModelTemplate) {    // from file system
            return parent::renderContent();
        }

        if (!$this->templateHandle) {
            throw new EmailException('Template handle is empty.');
        }

        $mailTemplate = self::loadTemplateRecord($this->templateHandle, $this->getLang());
        if (!$mailTemplate) {
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
        $twig->addExtension(new Twig_Extensions_Extension_Text());
        $twig->addExtension(new Twig_Extensions_Extension_I18n());

        // load markdown twig extension
        if (class_exists('Twig_Extension_Markdown', true)) {
            $twig->addExtension(new \Twig_Extension_Markdown());
        }

        return $twig->render('_email.html',  $this->getArguments());
    }

    public function template()
    {
        return $this->getTemplateSubPath();
    }

    /**
     * This method returns a template file path in this format:.
     *
     * @return string template file path for twig
     *
     *      @{bundleName}/email/{lang}/{templateHandle}.html
     */
    public function getTemplateSubPath()
    {
        $ro = new ReflectionObject($this);
        $args = explode('\\', $ro->getNamespaceName());
        if (empty($args) || !isset($args[0])) {
            throw new EmailException('Wrong Namespace For Email template path.');
        }
        $topNs = $args[0]; // top level namespace
        return implode('/', array('@'.$topNs, 'email', $this->getLang(), $this->templateHandle.'.html'));
    }

    public function send()
    {
        $envLang = kernel()->locale->current();
        $lang = $this->getLang();
        if ($lang) {
            putenv('LC_ALL='.$lang);
            setlocale(LC_ALL,  $lang.'.UTF-8');
        }
        $ret = parent::send();
        putenv('LC_ALL='.$envLang);
        setlocale(LC_ALL,  $envLang.'.UTF-8');

        return $ret;
    }
}
