<?php

namespace App\Filters;

use App\Filters\QueryBuilder\AbstractFilter;

class ProjectFilter extends AbstractFilter
{

    public function name($val)
    {
        $this->builder->where('name', "LIKE", "$val%");
    }

    public function description($val)
    {
        $this->builder->where('description', "LIKE", "$val%");
    }

    public function business_id($val)
    {
        $this->builder->where('business_id', $val);
    }

}
