<?php

namespace Royl\WpThemeBase\Filter\Query;

class Search extends \Royl\WpThemeBase\Filter\Query
{
    public function getFilter()
    {
        if ($this->field_params['value']) {
            return ['s' => $this->field_params['value']];
        }
        return [];
    }
}