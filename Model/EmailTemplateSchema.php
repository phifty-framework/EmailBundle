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

        $this->column('content_type')
            ->varchar(12)
            ->label( '信件格式' )
            ->validValues(array( 
                'HTML' => 'text/html',
                '純文字' => 'text/plain',
                'Markdown' => 'text/markdown',
            ))
            ;

        $this->column('handle')
            ->varchar(256)
            ->label('操作符')
            ->renderAs('TextInput', array( 'size' => 12, 'placeholder' => '如: mainpage...' ) )
            ;

        $this->column('comment')
            ->text()
            ->label('備註')
            ->renderAs('TextareaInput', [ 
                'rows' => 2,
                'cols' => 72,
            ])
            ;

        $this->mixin('I18N\\Model\\Mixin\\I18NSchema');
        $this->mixin('CommonBundle\\Model\\Mixin\\MetaSchema');
    }
}
