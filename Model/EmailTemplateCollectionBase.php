<?php

namespace EmailBundle\Model;


use Maghead\Runtime\Collection;

class EmailTemplateCollectionBase
    extends Collection
{

    const SCHEMA_PROXY_CLASS = 'EmailBundle\\Model\\EmailTemplateSchemaProxy';

    const MODEL_CLASS = 'EmailBundle\\Model\\EmailTemplate';

    const TABLE = 'email_templates';

    const READ_SOURCE_ID = 'master';

    const WRITE_SOURCE_ID = 'master';

    const PRIMARY_KEY = 'id';

    public static function createRepo($write, $read)
    {
        return new \EmailBundle\Model\EmailTemplateRepoBase($write, $read);
    }

    public static function getSchema()
    {
        static $schema;
        if ($schema) {
           return $schema;
        }
        return $schema = new \EmailBundle\Model\EmailTemplateSchemaProxy;
    }
}
