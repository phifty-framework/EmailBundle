<?php

namespace EmailBundle\Model;


use Maghead\Schema\RuntimeSchema;
use Maghead\Schema\RuntimeColumn;
use Maghead\Schema\Relationship\Relationship;
use Maghead\Schema\Relationship\HasOne;
use Maghead\Schema\Relationship\HasMany;
use Maghead\Schema\Relationship\BelongsTo;
use Maghead\Schema\Relationship\ManyToMany;

class EmailTemplateSchemaProxy
    extends RuntimeSchema
{

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

    public static $column_hash = array (
      'id' => 1,
      'title' => 1,
      'content' => 1,
      'content_type' => 1,
      'handle' => 1,
      'comment' => 1,
      'lang' => 1,
      'updated_on' => 1,
      'created_on' => 1,
      'updated_by' => 1,
      'created_by' => 1,
    );

    public static $mixin_classes = array (
      0 => 'CommonBundle\\Model\\Mixin\\MetaSchema',
      1 => 'I18N\\Model\\Mixin\\I18NSchema',
    );

    public $columnNames = array (
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

    public $primaryKey = 'id';

    public $columnNamesIncludeVirtual = array (
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

    public $label = 'EmailTemplate';

    public $readSourceId = 'master';

    public $writeSourceId = 'master';

    public $relations;

    public function __construct()
    {
        $this->relations = array( 
      'created_by' => \Maghead\Schema\Relationship\BelongsTo::__set_state(array( 
      'data' => array( 
          'foreign_schema' => 'UserBundle\\Model\\UserSchema',
          'foreign_column' => 'id',
          'self_schema' => 'EmailBundle\\Model\\EmailTemplateSchema',
          'self_column' => 'created_by',
        ),
      'accessor' => 'created_by',
      'where' => NULL,
      'orderBy' => array( 
        ),
      'onUpdate' => NULL,
      'onDelete' => NULL,
      'usingIndex' => false,
    )),
      'updated_by' => \Maghead\Schema\Relationship\BelongsTo::__set_state(array( 
      'data' => array( 
          'foreign_schema' => 'UserBundle\\Model\\UserSchema',
          'foreign_column' => 'id',
          'self_schema' => 'EmailBundle\\Model\\EmailTemplateSchema',
          'self_column' => 'updated_by',
        ),
      'accessor' => 'updated_by',
      'where' => NULL,
      'orderBy' => array( 
        ),
      'onUpdate' => NULL,
      'onDelete' => NULL,
      'usingIndex' => false,
    )),
    );
        $this->columns[ 'id' ] = new RuntimeColumn('id',array( 
      'locales' => NULL,
      'attributes' => array( 
          'autoIncrement' => true,
          'renderAs' => 'HiddenInput',
          'widgetAttributes' => array( 
            ),
        ),
      'name' => 'id',
      'primary' => true,
      'unsigned' => true,
      'type' => 'int',
      'isa' => 'int',
      'notNull' => true,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
      'autoIncrement' => true,
      'renderAs' => 'HiddenInput',
      'widgetAttributes' => array( 
        ),
    ));
        $this->columns[ 'title' ] = new RuntimeColumn('title',array( 
      'locales' => NULL,
      'attributes' => array( 
          'length' => 128,
          'label' => '信件標題',
        ),
      'name' => 'title',
      'primary' => NULL,
      'unsigned' => NULL,
      'type' => 'varchar',
      'isa' => 'str',
      'notNull' => NULL,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
      'length' => 128,
      'label' => '信件標題',
    ));
        $this->columns[ 'content' ] = new RuntimeColumn('content',array( 
      'locales' => NULL,
      'attributes' => array( 
          'label' => '信件內容',
          'renderAs' => 'TextareaInput',
          'widgetAttributes' => array( 
              'rows' => 10,
              'cols' => 70,
            ),
        ),
      'name' => 'content',
      'primary' => NULL,
      'unsigned' => NULL,
      'type' => 'text',
      'isa' => 'str',
      'notNull' => NULL,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
      'label' => '信件內容',
      'renderAs' => 'TextareaInput',
      'widgetAttributes' => array( 
          'rows' => 10,
          'cols' => 70,
        ),
    ));
        $this->columns[ 'content_type' ] = new RuntimeColumn('content_type',array( 
      'locales' => NULL,
      'attributes' => array( 
          'length' => 12,
          'label' => '信件格式',
          'validValues' => array( 
              'HTML' => 'text/html',
              '純文字' => 'text/plain',
              'Markdown' => 'text/markdown',
            ),
        ),
      'name' => 'content_type',
      'primary' => NULL,
      'unsigned' => NULL,
      'type' => 'varchar',
      'isa' => 'str',
      'notNull' => NULL,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
      'length' => 12,
      'label' => '信件格式',
      'validValues' => array( 
          'HTML' => 'text/html',
          '純文字' => 'text/plain',
          'Markdown' => 'text/markdown',
        ),
    ));
        $this->columns[ 'handle' ] = new RuntimeColumn('handle',array( 
      'locales' => NULL,
      'attributes' => array( 
          'length' => 256,
          'label' => '程式標記',
          'renderAs' => 'TextInput',
          'widgetAttributes' => array( 
              'size' => 12,
              'placeholder' => '如: mainpage...',
            ),
        ),
      'name' => 'handle',
      'primary' => NULL,
      'unsigned' => NULL,
      'type' => 'varchar',
      'isa' => 'str',
      'notNull' => NULL,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
      'length' => 256,
      'label' => '程式標記',
      'renderAs' => 'TextInput',
      'widgetAttributes' => array( 
          'size' => 12,
          'placeholder' => '如: mainpage...',
        ),
    ));
        $this->columns[ 'comment' ] = new RuntimeColumn('comment',array( 
      'locales' => NULL,
      'attributes' => array( 
          'label' => '備註',
          'renderAs' => 'TextareaInput',
          'widgetAttributes' => array( 
              'rows' => 2,
              'cols' => 72,
            ),
        ),
      'name' => 'comment',
      'primary' => NULL,
      'unsigned' => NULL,
      'type' => 'text',
      'isa' => 'str',
      'notNull' => NULL,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
      'label' => '備註',
      'renderAs' => 'TextareaInput',
      'widgetAttributes' => array( 
          'rows' => 2,
          'cols' => 72,
        ),
    ));
        $this->columns[ 'lang' ] = new RuntimeColumn('lang',array( 
      'locales' => NULL,
      'attributes' => array( 
          'length' => 12,
          'validValues' => function() {
                    return array_flip(kernel()->locale->available());
                },
          'label' => '語言',
          'default' => function() {
                    $bundle = \I18N\I18N::getInstance();
                    if ($lang = $bundle->config('default_lang') ) {
                        return $lang;
                    }
                    return kernel()->locale->getDefault();
                },
          'renderAs' => 'SelectInput',
          'widgetAttributes' => array( 
              'allow_empty' => true,
            ),
        ),
      'name' => 'lang',
      'primary' => NULL,
      'unsigned' => NULL,
      'type' => 'varchar',
      'isa' => 'str',
      'notNull' => NULL,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
      'length' => 12,
      'validValues' => function() {
                    return array_flip(kernel()->locale->available());
                },
      'label' => '語言',
      'default' => function() {
                    $bundle = \I18N\I18N::getInstance();
                    if ($lang = $bundle->config('default_lang') ) {
                        return $lang;
                    }
                    return kernel()->locale->getDefault();
                },
      'renderAs' => 'SelectInput',
      'widgetAttributes' => array( 
          'allow_empty' => true,
        ),
    ));
        $this->columns[ 'updated_on' ] = new RuntimeColumn('updated_on',array( 
      'locales' => NULL,
      'attributes' => array( 
          'timezone' => true,
          'default' => \Magsql\Raw::__set_state(array( 
      'value' => 'CURRENT_TIMESTAMP',
    )),
          'label' => '更新時間',
          'renderAs' => 'DateTimeInput',
          'widgetAttributes' => array( 
            ),
        ),
      'name' => 'updated_on',
      'primary' => NULL,
      'unsigned' => NULL,
      'type' => 'timestamp',
      'isa' => 'DateTime',
      'notNull' => false,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => \Magsql\Raw::__set_state(array( 
      'value' => 'CURRENT_TIMESTAMP',
    )),
      'timezone' => true,
      'default' => \Magsql\Raw::__set_state(array( 
      'value' => 'CURRENT_TIMESTAMP',
    )),
      'label' => '更新時間',
      'renderAs' => 'DateTimeInput',
      'widgetAttributes' => array( 
        ),
    ));
        $this->columns[ 'created_on' ] = new RuntimeColumn('created_on',array( 
      'locales' => NULL,
      'attributes' => array( 
          'timezone' => true,
          'default' => \Magsql\Raw::__set_state(array( 
      'value' => 'CURRENT_TIMESTAMP',
    )),
          'label' => '建立時間',
          'renderAs' => 'DateTimeInput',
          'widgetAttributes' => array( 
            ),
        ),
      'name' => 'created_on',
      'primary' => NULL,
      'unsigned' => NULL,
      'type' => 'timestamp',
      'isa' => 'DateTime',
      'notNull' => NULL,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
      'timezone' => true,
      'default' => \Magsql\Raw::__set_state(array( 
      'value' => 'CURRENT_TIMESTAMP',
    )),
      'label' => '建立時間',
      'renderAs' => 'DateTimeInput',
      'widgetAttributes' => array( 
        ),
    ));
        $this->columns[ 'updated_by' ] = new RuntimeColumn('updated_by',array( 
      'locales' => NULL,
      'attributes' => array( 
          'refer' => 'UserBundle\\Model\\UserSchema',
          'length' => NULL,
          'default' => function() {
                    if ( isset($_SESSION) ) {
                        return kernel()->currentUser->id;
                    }
                },
          'renderAs' => 'SelectInput',
          'widgetAttributes' => array( 
            ),
          'label' => '更新者',
        ),
      'name' => 'updated_by',
      'primary' => NULL,
      'unsigned' => true,
      'type' => 'int',
      'isa' => 'int',
      'notNull' => NULL,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
      'refer' => 'UserBundle\\Model\\UserSchema',
      'length' => NULL,
      'default' => function() {
                    if ( isset($_SESSION) ) {
                        return kernel()->currentUser->id;
                    }
                },
      'renderAs' => 'SelectInput',
      'widgetAttributes' => array( 
        ),
      'label' => '更新者',
    ));
        $this->columns[ 'created_by' ] = new RuntimeColumn('created_by',array( 
      'locales' => NULL,
      'attributes' => array( 
          'refer' => 'UserBundle\\Model\\UserSchema',
          'length' => NULL,
          'default' => function() {
                    if (isset($_SESSION)) {
                        return kernel()->currentUser->id;
                    }
                },
          'renderAs' => 'SelectInput',
          'widgetAttributes' => array( 
            ),
          'label' => '建立者',
        ),
      'name' => 'created_by',
      'primary' => NULL,
      'unsigned' => true,
      'type' => 'int',
      'isa' => 'int',
      'notNull' => NULL,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
      'refer' => 'UserBundle\\Model\\UserSchema',
      'length' => NULL,
      'default' => function() {
                    if (isset($_SESSION)) {
                        return kernel()->currentUser->id;
                    }
                },
      'renderAs' => 'SelectInput',
      'widgetAttributes' => array( 
        ),
      'label' => '建立者',
    ));
    }
}
