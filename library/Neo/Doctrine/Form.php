<?php

class Neo_Doctrine_Form extends ZendX_JQuery_Form
{

    /**
     *
     * @var array
     */
    protected $_values;

    /**
     *
     * @var integer
     */
    protected $_input_length = 30;

    /**
     *
     * @var array
     */
    protected $_excludedFields = array();

    /**
     *
     * @var array
     */
    protected $_groups = array();

    /**
     *
     * @var array
     */
    protected $_elements = array();

    /**
     *
     * @var array
     */
    protected $_messages = array();
    
    public function init($model)
    {
        $class = Doctrine::getTable($model);
        
        $columns   = $class->getColumns();
        $relations = $class->getRelations();

        foreach ( $relations as $r ) {
            //$related_fields[] = $r->getLocalColumnName();
            /*
            $columns[$r->getLocalColumnName()]['type']    = 'foreign';
            $columns[$r->getLocalColumnName()]['foreign'] = $r->getForeignColumnName();
            $columns[$r->getLocalColumnName()]['class']   = $r->getClass();
            */
        }

        unset(
            $columns['id'],
            $columns['created_at'],
            $columns['updated_at'],
            $columns['deleted_at']
        );

        /* subtract hidden fields from columns list */
        foreach( $this->getExcludedFields() as $val ) {
            unset($columns[$val]);
            //@todo unset the related_fields, too.
        }

        foreach ( $columns as $name => $column ) {
           
            $attributes = $this->getColumnAttributes( $column );
            $attributes['name'] = $name;

            //oops, createElement() is also a Zend_Form function!
            $element = $this->createElement( $attributes );

            //no labels for hidden elements            
            if ( $element->getType() != 'Zend_Form_Element_Hidden' ) {
                $element->setLabel( ucwords( strtr( $name, '_', ' ' ) ) );
            }

            //this will conflict with the foreign keys which get a dataset
            if ( $column['type'] === 'foreign' ) {
                $values = $this->getColumnDataSet( $column );
                if ( ! empty ( $values ) AND is_array( $values ) ) {
                    $element->addMultiOptions( $values );
                }
            } else {
                $element->setValue( $attributes['values'] );
                //$element->setValue( $this->getValueForField( $name ) );
            }

            $element->addFilter( new Zend_Filter_StringTrim() );
            $this->addElement( $element );
        }

    }

    /**
     *
     * @param $file
     * @return unknown_type
     */
    public function parseSchema( $file )
    {
        if ( ! extension_loaded( 'syck' ) ) {
            throw new Exception(
                'The syck extension is required' );
        }
            // One can also use this: Doctrine_Parser::load('test.yml', 'yml');

        /* load the yaml data from the filesystem */
        try {
            $schema = syck_load( file_get_contents( '/srv/www/courses/htdocs/Data/Db/courses_schema.yml') );
        }
        catch ( SyckException $e ) {
            echo self::INVALID_SCHEMA;
            echo $e->getMessage();
            echo $e->getFile();
            echo $e->getLine();
        }

        return $schema;
    }

    /*
     *
     * Available Zend Form Elements:
     * Zend_Form_Element_Button
     * Zend_Form_Element_Captcha
     * Zend_Form_Element_Checkbox
     * Zend_Form_Element_File
     * Zend_Form_Element_Hidden
     * Zend_Form_Element_Hash
     * Zend_Form_Element_Image
     * Zend_Form_Element_MultiCheckbox
     * Zend_Form_Element_Multiselect
     * Zend_Form_Element_Password
     * Zend_Form_Element_Radio
     * Zend_Form_Element_Reset
     * Zend_Form_Element_Select
     * Zend_Form_Element_Submit
     * Zend_Form_Element_Text
     * Zend_Form_Element_Textarea
     * ZendX_JQuery_Form_Element_DatePicker
     * Neo_Form_Element_Time
     *
     * @param $name
     * @param $type
     * @param $length
     * @param $required
     * @return Zend_Form_Element
     */
    public function createElement( array $attributes )
    {
        $name     = $attributes['name'];
        $type     = $attributes['type'];
        $length   = $attributes['length'];
        $required = $attributes['required'];
        $default  = $attributes['default'];
        $values   = $attributes['values'];
        $email    = $attributes['email'];
        
        $min = ( isset( $attributes['min'] ) ) ? $attributes['min'] : 1;
        $max = ( isset( $attributes['max'] ) ) ? $attributes['max'] : $attributes['length'];

        /* float, decimal, string and integer are fallthrough cases since all will render a text box */
        switch ( $type ) {
            case 'float':
            case 'decimal':
            case 'integer':
                if( preg_match( '/_id$/i', $name ) ) {
                    $element = new Zend_Form_Element_Hidden( $name );
                } else {
                    $element = new Zend_Form_Element_Text( $name );
                }
                $element->addValidator( new Zend_Validate_Digits(true) );
                $element->setAttrib( 'size', $length );

                break;
            case 'string':
                /* determine if it should be 'hidden' */
                if( preg_match( '/_id$/i', $name ) ) {
                    $element = new Zend_Form_Element_Hidden( $name );
                } else {
                    if ( $length > 60 ) {
                        $element = new Zend_Form_Element_Textarea( $name, array( 'rows' => 5, 'cols' => 54) );
                    } else {
                        $element = new Zend_Form_Element_Text( $name );
                        if ($email) {
                            $element->addValidator( new Zend_Validate_EmailAddress(true));
                        } else {
                            //$element->addValidator( new Zend_Validate_Alnum(true) );
                        }
                    }
                    
                }
                
                $element->addValidator( new Zend_Validate_StringLength($min, $max) );
                
                if ( $length > $this->_input_length ) {
                    $size = $this->_input_length;
                } else {
                    $size = $length;
                }
                
                $element->setAttrib( 'size', $size );
                $element->setAttrib( 'maxlength', $max );
                break;
            case 'boolean':
                $element = new Zend_Form_Element_Checkbox( $name );
                break;
            case 'blob':
                $element = new Zend_Form_Element_File( $name );
                break;
            case 'clob':
                  $element = new Zend_Form_Element_Textarea( $name, array( 'rows' => 12, 'cols' => 35) );
                  break;
            case 'timestamp':
                  break;
            case 'time':
                $element = new Neo_Form_Element_Time( $name );
                $element->setValue(date('H:i'));
                $element->setAttrib( 'size', 5 );
                $element->setAttrib( 'maxlength', 5 );
                break;
            case 'date':
                $jQueryParams = array(
                    'defaultDate' => date('yy-mm-dd'),
                    'dateFormat' => 'yy-mm-dd',
                    'firstDay' => 1,
                    'showOn' => 'button',
                    'buttonImageOnly' => false,
                    //'earRange' => '1970:2012',
                    'minDate' => '-40Y',
                    //'maxDate' => "+1M +10D"
                    'changeMonth' => true,
                    'changeYear'=> true,
                    'monthNames' => array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre')
                );
                
                $element = new ZendX_JQuery_Form_Element_DatePicker($name, $jQueryParams);
                $element->addValidator( new Zend_Validate_Date('yy-mm-dd'));
                $element->addValidator( new Zend_Validate_StringLength('10', '10') );
                $element->setAttrib( 'disabled', true );
                $element->setAttrib( 'size', 10 );
                $element->setAttrib( 'maxlength', 10 );
                break;
            case 'enum':
                $element = new Zend_Form_Element_Radio( $name );
                if ( ! empty ( $values ) AND is_array( $values ) ) {
                    $values = array_combine($values, $values);
                    $element->addMultiOptions( $values );
                }
                break;
            case 'foreign':
                $element = new Zend_Form_Element_Select( $name );
                /*if ( ! empty ( $values ) AND is_array( $values ) ) {
                    $element->addMultiOptions( $values );
                }*/
                break;
            case 'array':
                break;
            case 'object':
                //Doctrine auto-serializes...not sure how or why I would have this in a form
                //but its here for completeness.
                break;
            default:
                  break;
        }
        
        if ( ! empty ( $default ) ) {
            $element->setValue($default);
        }

        if ( $required ) {
            $element->setRequired( TRUE );
        }

        return $element;
    }

    public function getColumnAttributes( array $column )
    {
        $attributes = array();

        $attributes['type']     = $this->getColumnType( $column );
        $attributes['length']   = $this->getColumnLength( $column );
        $attributes['required'] = $this->getColumnRequired( $column );
        $attributes['default']  = $this->getColumnDefault( $column );
        $attributes['values']   = $this->getColumnValues( $column );
        $attributes['email']    = $this->getColumnEmail( $column );

        return $attributes;
    }

    protected function getColumnEmail( array $column )
    {
        if ( isset( $column['email'] ) ) {
            $default = $column['email'];
        }
        else {
            $default = false;
        }

        return $default;
    }

    protected function getColumnType( array $column )
    {
        if ( array_key_exists( 'length', $column ) AND ! empty( $column['length'] ) ) {
            $type = $column['type'];
        }
        else {
            $type = (string) reset( explode( '(', $column['type'] ) );
        }

        return $type;
    }

    protected function getColumnLength( array $column )
    {
        if ( array_key_exists( 'length', $column ) AND ! empty( $column['length'] ) ) {
            $length = $column['length'];
        }
        else {
            $length = (int) end( explode( '(', $column['type'] ) );
        }

        return $length;

    }

    protected function getColumnDefault( array $column )
    {
        if ( isset( $column['default'] ) ) {
            $default = $column['default'];
        }
        else {
            $default = false;
        }

        return $default;
    }

    protected function getColumnValues( array $column )
    {
        $values = array();
        $values = $column['values'];
        return $values;
    }

    /**
     * Returns a dataset for a field which is a foreign key
     *
     * @param $column mixed
     * @return array
     */
    protected function getColumnDataSet( array $column )
    {
        $values = array();
        $class = $column['class'];
        $key = $column['foreign'];
        //$id = strtolower( $column['class'] ) . '_id';
        $query = Doctrine_Query::create()
            ->select( 'id as key, name as value' )
            ->from($class);
        $values = $query->execute( array(), Doctrine::HYDRATE_ARRAY );
        return $values;
    }

    /**
     *
     * @param $column
     * @return unknown_type
     */
    protected function getColumnRequired( array $column )
    {
        if ( isset( $column['notnull'] )
             OR
             isset( $column['notblank'] ) )
        {
            $required = true;
        }
        else {
            $required = false;
        }

        return $required;
    }

    public function getAllElements()
    {
        return $this->_elements;
    }

    public function setExcludedFields( array $fields )
    {
        $this->_excludedFields = $fields;
        return $this;
            //make it a chainable, semi-fluid interface.
    }

    public function getExcludedFields()
    {
        return $this->_excludedFields;
    }

    public function setRelatedField( array $field )
    {
        //check to ensure $field is in the relations somewhere

        return $this;
            //make it a chainable, semi-fluid interface.
    }

    public function setFieldValues( array $values )
    {
        $this->_values = $values;
    }

    public function getFieldValues()
    {
        return $this->_values;
    }

    public function getValueForField( $name )
    {
        $values = $this->getFieldValues();
        
        if ( array_key_exists( $name, $values ) AND ! empty( $values ) ) {
            $value = $values[$name];
        }
        else {
            $value = null;
        }

        return $value;
    }
}