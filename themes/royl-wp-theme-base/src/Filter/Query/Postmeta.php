<?php

namespace Royl\WpThemeBase\Filter\Query;

class Postmeta extends \Royl\WpThemeBase\Filter\Query
{
    public function getFilter()
    {
        $args = [];
        if ($this->filter_query['value']) {
            $args = [
                'meta_query' => [
                    [
                        'key' => $this->filter_query['key'],
                        'value' => $this->filter_query['value'],
                        'compare' => $this->filter_query['compare']
                    ]
                ]
            ];
        }
        
        return $args;
    }
}
