<?php
namespace EmailBundle\Model;

class EmailTemplate  extends \EmailBundle\Model\EmailTemplateBase {

    /**
     * @retunr EmailTemplate
     */
    public static function loadByHandle($handle, $lang = null) {
        $lang = $lang ?: kernel()->locale->current();
        $record = new self;
        $record->load([ 'handle' => $handle, 'lang' => $lang ]);
        return $record;
    }

    /**
     * Code block for message id parser.
     */
    private function __() {
            }
}
