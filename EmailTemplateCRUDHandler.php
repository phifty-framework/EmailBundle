<?php
namespace EmailBundle;
use Phifty\Bundle;
use AdminUI\CRUDHandler;

class EmailTemplateCRUDHandler extends CRUDHandler
{
    /* CRUD Attributes */
    public $modelClass = 'EmailBundle\Model\EmailTemplate';
    public $crudId     = 'email_template';

    public $listColumns = array( 'id', 'title', 'handle');

    public $listRightColumns = array('comment', 'updated_on', 'created_on');
    // public $filterColumns = array();

    public $quicksearchFields = array('title', 'content');

    public $canCreate = true;
    public $canUpdate = true;
    public $canDelete = true;

    public $canBulkEdit = true;
    public $canBulkDelete = true;
    public $canBulkCopy = false;
    public $canEditInNewWindow = false;

    // public $templatePage = '@CRUD/page.html';
    // public $actionViewClass = 'AdminUI\\Action\\View\\StackView';
    // public $pageLimit = 15;
    // public $defaultOrder = array('id', 'DESC');

    public function init() {
        parent::init();
        $this->setFormatter('title', function($record) {
            return mb_substr($record->title,0, 12) . '..';
        });
    }
}

