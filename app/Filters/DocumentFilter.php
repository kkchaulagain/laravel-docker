<?php

namespace App\Filters;

use App\Filters\QueryBuilder\AbstractFilter;

class DocumentFilter extends AbstractFilter
{

    public function application_id($val)
    {
        $this->builder->where('application_id', "$val");
    }

    public function number($val)
    {
        $this->builder->where('number', "$val");
    }

    public function issue_district($val)
    {
        $this->builder->where('issue_district', "$val");
    }

    public function type($val)
    {
        $this->builder->where('type', "$val");
    }
}
