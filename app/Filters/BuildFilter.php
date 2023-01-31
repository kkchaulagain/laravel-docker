<?php

namespace App\Filters;

use App\Filters\QueryBuilder\AbstractFilter;

class BuildFilter extends AbstractFilter
{

    public function name($val)
    {
        $this->builder->where('name', "LIKE", "$val%");
    }

    public function description($val)
    {
        $this->builder->where('description', "LIKE", "$val%");
    }

    public function project_id($val)
    {
        $this->builder->where('project_id', $val);
    }

    public function status($val)
    {
        $this->builder->where('status', $val);
    }
}
