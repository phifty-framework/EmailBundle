<?php
namespace EmailBundle;
use Phifty\Bundle;
use AdminUI\CRUDHandler;
use EmailBundle\Model\EmailTemplate;

class EmailTemplateCRUDHandler extends CRUDHandler
{
    public $modelClass = EmailTemplate::class;

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
}

