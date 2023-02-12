<?php

namespace App\Filters;

use App\Filters\QueryBuilder\AbstractFilter;

class ApplicationFilter extends AbstractFilter
{

    public function account_id($val)
    {
        $this->builder->where('account_id', "$val");
    }

    public function status($status)
    {
        $this->builder->where('status', "$status");
    }

    public function reference_code($val)
    {
        $this->builder->where('reference_code', "$val");
    }
}
