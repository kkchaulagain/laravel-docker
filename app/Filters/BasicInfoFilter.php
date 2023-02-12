<?php

namespace App\Filters;

use App\Filters\QueryBuilder\AbstractFilter;

class BasicInfoFilter extends AbstractFilter
{

    public function application_id($val)
    {
        $this->builder->where('application_id', "$val");
    }
}
