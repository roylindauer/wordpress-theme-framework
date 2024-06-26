<?php

namespace Royl\WpThemeBase\Filter\Query;

class Taxonomy extends \Royl\WpThemeBase\Filter\Query
{
    public function getFilter()
    {
        $args = [];
        if ($this->getValue()) {
            $args = [
                'tax_query' => [
                    [
                        'taxonomy' => $this->filter_query['taxonomy'],
                        'field' => 'slug',
                        'terms' => $this->getValue(),
                    ]
                ]
            ];
        }
        return $args;
    }
}
