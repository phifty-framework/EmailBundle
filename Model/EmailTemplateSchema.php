<?php
namespace EmailBundle\Model;
use LazyRecord\Schema\SchemaDeclare;

class EmailTemplateSchema extends SchemaDeclare
{
    function schema() {
      $this->column('title')
            ->varchar(128)
            ->label( '信件標題' );

        $this->column('content')
            ->text()
            ->label( '信件內容' )
            ->renderAs('TextareaInput',array(
                'rows' => 10,
                'cols' => 70
            ))
            ;

        $this->column('handle')
            ->varchar(256)
            ->label('操作符')
            ->renderAs('TextInput', array( 'size' => 12, 'placeholder' => '如: mainpage...' ) )
            ;

        $this->mixin('I18N\\Model\\Mixin\\I18NSchema');
        $this->mixin('CommonBundle\\Model\\Mixin\\MetaSchema');
    }
}
