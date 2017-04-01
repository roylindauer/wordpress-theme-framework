<?php

namespace Royl\WpThemeBase\Core\Filter\Fields;
use Royl\WpThemeBase\Wp;
use Royl\WpThemeBase\Util;

class BaseField {

    /**
     * Array of field parameter
     * Sets some default classes for the field
     * @var array
     */
    public $field_params = [
        'classes' => [ 'filter-field' ],
    ];

    /**
     * Partial to use to render FieldClass
     * @var string
     */
    public $partial = '';
    
    /**
     * [__construct description]
     * @param array $params [description]
     */
    public function __construct( $params = array() ) {
        $this->field_params = array_merge( $this->field_params, $params );
        $this->field_params['id'] = $this->field_params['name'] . '_' . uniqid();
    }
    
    /**
     * Render the field
     * @return [type] [description]
     */
    public function render() {
        $this->processFieldClasses();
        
        echo '<div class="filter-wrapper">';
        if ( isset( $this->field_params['label'] ) ) {
            echo '<label class="filter-label" for="' . $this->field_params['id'] . '">' . Util\Text::translate( $this->field_params['label'] ) . '</label>';   
        }
        Wp\Template::renderPartial( $this->partial, [ 'field' => $this->field_params ], __DIR__ . '/..' );
        echo '</div>';
    }

    /**
     * Set the partial to render
     * @param string $partial [description]
     */
    public function setPartial( $partial = '' ) {
        $this->partial = $partial;
    }

    /**
     * Add CSS classes to field_params class array
     * @param string $class [description]
     */
    public function addClass( $class = '' ) {
        $this->field_params['classes'][] = $class;
    }

    /**
     * Convert array of classes intro string
     * @return [type] [description]
     */
    private function processFieldClasses() {
        $this->field_params['classes'] = join( ' ', $this->field_params['classes'] );
    }
}