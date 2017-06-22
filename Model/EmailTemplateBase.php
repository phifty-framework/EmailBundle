<?php

namespace EmailBundle\Model;


use Maghead\Runtime\Model;
use Maghead\Schema\SchemaLoader;
use Maghead\Runtime\Result;
use Maghead\Runtime\Inflator;
use Magsql\Bind;
use Magsql\ArgumentArray;
use DateTime;
use WebAction\Maghead\Traits\ActionCreatorTrait;

class EmailTemplateBase
    extends Model
{

    use ActionCreatorTrait;

    const SCHEMA_PROXY_CLASS = 'EmailBundle\\Model\\EmailTemplateSchemaProxy';

    const READ_SOURCE_ID = 'master';

    const WRITE_SOURCE_ID = 'master';

    const TABLE_ALIAS = 'm';

    const SCHEMA_CLASS = 'EmailBundle\\Model\\EmailTemplateSchema';

    const LABEL = 'EmailTemplate';

    const MODEL_NAME = 'EmailTemplate';

    const MODEL_NAMESPACE = 'EmailBundle\\Model';

    const MODEL_CLASS = 'EmailBundle\\Model\\EmailTemplate';

    const REPO_CLASS = 'EmailBundle\\Model\\EmailTemplateRepoBase';

    const COLLECTION_CLASS = 'EmailBundle\\Model\\EmailTemplateCollection';

    const TABLE = 'email_templates';

    const PRIMARY_KEY = 'id';

    const GLOBAL_PRIMARY_KEY = NULL;

    const LOCAL_PRIMARY_KEY = 'id';

    public static $column_names = array (
      0 => 'id',
      1 => 'title',
      2 => 'content',
      3 => 'content_type',
      4 => 'handle',
      5 => 'comment',
      6 => 'lang',
      7 => 'updated_on',
      8 => 'created_on',
      9 => 'updated_by',
      10 => 'created_by',
    );

    public static $mixin_classes = array (
      0 => 'CommonBundle\\Model\\Mixin\\MetaSchema',
      1 => 'I18N\\Model\\Mixin\\I18NSchema',
    );

    protected $table = 'email_templates';

    public $id;

    public $title;

    public $content;

    public $content_type;

    public $handle;

    public $comment;

    public $lang;

    public $updated_on;

    public $created_on;

    public $updated_by;

    public $created_by;

    public static function getSchema()
    {
        static $schema;
        if ($schema) {
           return $schema;
        }
        return $schema = new \EmailBundle\Model\EmailTemplateSchemaProxy;
    }

    public static function createRepo($write, $read)
    {
        return new \EmailBundle\Model\EmailTemplateRepoBase($write, $read);
    }

    public function getKeyName()
    {
        return 'id';
    }

    public function getKey()
    {
        return $this->id;
    }

    public function hasKey()
    {
        return isset($this->id);
    }

    public function setKey($key)
    {
        return $this->id = $key;
    }

    public function removeLocalPrimaryKey()
    {
        $this->id = null;
    }

    public function getId()
    {
        return intval($this->id);
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getContentType()
    {
        return $this->content_type;
    }

    public function getHandle()
    {
        return $this->handle;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function getLang()
    {
        return $this->lang;
    }

    public function getUpdatedOn()
    {
        return Inflator::inflate($this->updated_on, 'DateTime');
    }

    public function getCreatedOn()
    {
        return Inflator::inflate($this->created_on, 'DateTime');
    }

    public function getUpdatedBy()
    {
        return intval($this->updated_by);
    }

    public function getCreatedBy()
    {
        return intval($this->created_by);
    }

    public function getAlterableData()
    {
        return ["id" => $this->id, "title" => $this->title, "content" => $this->content, "content_type" => $this->content_type, "handle" => $this->handle, "comment" => $this->comment, "lang" => $this->lang, "updated_on" => $this->updated_on, "created_on" => $this->created_on, "updated_by" => $this->updated_by, "created_by" => $this->created_by];
    }

    public function getData()
    {
        return ["id" => $this->id, "title" => $this->title, "content" => $this->content, "content_type" => $this->content_type, "handle" => $this->handle, "comment" => $this->comment, "lang" => $this->lang, "updated_on" => $this->updated_on, "created_on" => $this->created_on, "updated_by" => $this->updated_by, "created_by" => $this->created_by];
    }

    public function setData(array $data)
    {
        if (array_key_exists("id", $data)) { $this->id = $data["id"]; }
        if (array_key_exists("title", $data)) { $this->title = $data["title"]; }
        if (array_key_exists("content", $data)) { $this->content = $data["content"]; }
        if (array_key_exists("content_type", $data)) { $this->content_type = $data["content_type"]; }
        if (array_key_exists("handle", $data)) { $this->handle = $data["handle"]; }
        if (array_key_exists("comment", $data)) { $this->comment = $data["comment"]; }
        if (array_key_exists("lang", $data)) { $this->lang = $data["lang"]; }
        if (array_key_exists("updated_on", $data)) { $this->updated_on = $data["updated_on"]; }
        if (array_key_exists("created_on", $data)) { $this->created_on = $data["created_on"]; }
        if (array_key_exists("updated_by", $data)) { $this->updated_by = $data["updated_by"]; }
        if (array_key_exists("created_by", $data)) { $this->created_by = $data["created_by"]; }
    }

    public function clear()
    {
        $this->id = NULL;
        $this->title = NULL;
        $this->content = NULL;
        $this->content_type = NULL;
        $this->handle = NULL;
        $this->comment = NULL;
        $this->lang = NULL;
        $this->updated_on = NULL;
        $this->created_on = NULL;
        $this->updated_by = NULL;
        $this->created_by = NULL;
    }

    public function fetchCreatedBy()
    {
        return static::masterRepo()->fetchCreatedByOf($this);
    }

    public function fetchUpdatedBy()
    {
        return static::masterRepo()->fetchUpdatedByOf($this);
    }
}
