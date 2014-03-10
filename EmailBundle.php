<?php
namespace EmailBundle;
use Phifty\Bundle;

class EmailBundle extends Bundle
{
    public function assets() {
        return array();
    }

    public function defaultConfig() {
        return array();
    }

    public function init() 
    {
        $this->expandRoute('/bs/email_template', 'EmailTemplateCRUDHandler');
        /*
        $this->expandRoute( '/bs/product_resource', 'ProductResourceCRUDHandler' );
        if ( $this->config('with_agency_products') ) {
            $this->expandRoute( '/bs/agency_product', '\\Product\\AgencyProductCRUD' );
        }
        if ( $this->config('with_types') ) {
            $this->expandRoute( '/bs/product_type', '\\Product\\ProductTypeCRUDHandler' );
        }

        $this->route( '/bs/product/api/delete_spec/{schemaId}' , 'SpecDataController:deleteSchemaAndData' );

        $this->addCRUDAction( 'Category' , array('Create','Update','Delete','BulkDelete') );
        $this->addCRUDAction( 'Product' , array('BulkDelete') );
        */
    }

}
