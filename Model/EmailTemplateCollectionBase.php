<?php
namespace EmailBundle\Model;
use LazyRecord\BaseCollection;
class EmailTemplateCollectionBase
    extends BaseCollection
{
    const SCHEMA_PROXY_CLASS = 'EmailBundle\\Model\\EmailTemplateSchemaProxy';
    const MODEL_CLASS = 'EmailBundle\\Model\\EmailTemplate';
    const TABLE = 'email_templates';
    const READ_SOURCE_ID = 'default';
    const WRITE_SOURCE_ID = 'default';
    const PRIMARY_KEY = 'id';
}
