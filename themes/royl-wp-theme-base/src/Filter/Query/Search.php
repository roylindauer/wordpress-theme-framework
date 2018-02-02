<?php

namespace Royl\WpThemeBase\Filter\Query;

class Search extends \Royl\WpThemeBase\Filter\Query
{
    public function getFilter()
    {
        if ($this->filter_query['value']) {
            return ['s' => $this->filter_query['value']];
        }
        return [];
    }
}
