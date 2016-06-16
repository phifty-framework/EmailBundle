<?php
namespace EmailBundle\Model;
use LazyRecord\Schema\SchemaLoader;
use LazyRecord\Result;
use SQLBuilder\Bind;
use SQLBuilder\ArgumentArray;
use PDO;
use SQLBuilder\Universal\Query\InsertQuery;
use LazyRecord\BaseModel;
class EmailTemplateBase
    extends BaseModel
{
    const SCHEMA_CLASS = 'EmailBundle\\Model\\EmailTemplateSchema';
    const SCHEMA_PROXY_CLASS = 'EmailBundle\\Model\\EmailTemplateSchemaProxy';
    const COLLECTION_CLASS = 'EmailBundle\\Model\\EmailTemplateCollection';
    const MODEL_CLASS = 'EmailBundle\\Model\\EmailTemplate';
    const TABLE = 'email_templates';
    const READ_SOURCE_ID = 'default';
    const WRITE_SOURCE_ID = 'default';
    const PRIMARY_KEY = 'id';
    const FIND_BY_PRIMARY_KEY_SQL = 'SELECT * FROM email_templates WHERE id = :id LIMIT 1';
    public static $column_names = array (
      0 => 'id',
      1 => 'title',
      2 => 'content',
      3 => 'content_type',
      4 => 'handle',
      5 => 'comment',
      6 => 'lang',
      7 => 'created_on',
      8 => 'updated_on',
      9 => 'created_by',
      10 => 'updated_by',
    );
    public static $column_hash = array (
      'id' => 1,
      'title' => 1,
      'content' => 1,
      'content_type' => 1,
      'handle' => 1,
      'comment' => 1,
      'lang' => 1,
      'created_on' => 1,
      'updated_on' => 1,
      'created_by' => 1,
      'updated_by' => 1,
    );
    public static $mixin_classes = array (
      0 => 'CommonBundle\\Model\\Mixin\\MetaSchema',
      1 => 'I18N\\Model\\Mixin\\I18NSchema',
    );
    protected $table = 'email_templates';
    public $readSourceId = 'default';
    public $writeSourceId = 'default';
    public function getSchema()
    {
        if ($this->_schema) {
           return $this->_schema;
        }
        return $this->_schema = SchemaLoader::load('EmailBundle\\Model\\EmailTemplateSchemaProxy');
    }
    public function getId()
    {
            return $this->get('id');
    }
    public function getTitle()
    {
            return $this->get('title');
    }
    public function getContent()
    {
            return $this->get('content');
    }
    public function getContentType()
    {
            return $this->get('content_type');
    }
    public function getHandle()
    {
            return $this->get('handle');
    }
    public function getComment()
    {
            return $this->get('comment');
    }
    public function getLang()
    {
            return $this->get('lang');
    }
    public function getCreatedOn()
    {
            return $this->get('created_on');
    }
    public function getUpdatedOn()
    {
            return $this->get('updated_on');
    }
    public function getCreatedBy()
    {
            return $this->get('created_by');
    }
    public function getUpdatedBy()
    {
            return $this->get('updated_by');
    }
}
