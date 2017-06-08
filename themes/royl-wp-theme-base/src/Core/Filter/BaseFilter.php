<?php

namespace Royl\WpThemeBase\Core\Filter;

class BaseFilter {
    
    public $field_type = '';
    public $field_params = [];
    public $prefix = 'filter_';
    
    /**
     * Field Object
     * @var Royl\WpThemeBase\Core\Filter\Fields
     */
    public $Field;

    /**
     * Constructor
     */
    public function __construct( $params = [] ) {
        
        $this->field_type = $params['field']['type'];

        // shove all of the user defined field params into the field_params array
        // this array gets passed around a bit... 
        $this->field_params = $params['field'];
        $this->filter_query = $params['filter_query'];

        // Prefix field name to avoid query var clashes
        $this->field_params['name'] = $this->prefix . $this->field_params['name'];

        // Set field value if the filter is available in query params
        // Use this in child classes to get the value passed in query vars
        $this->field_params['value'] = get_query_var($this->field_params['name'], false);

        // Init the field class
        $fieldclass = '\Royl\WpThemeBase\Core\Filter\Fields\\' . $this->field_type;
        $this->Field = new $fieldclass($this->field_params);
    }
    
    /**
     * Render the field
     */
    public function render(){
        $this->Field->render();
    }
    
    /**
     * This method should be overridden in your filter class
     * It must return query args to pass to WP_Query
     */
    public function getFilter() { }
}