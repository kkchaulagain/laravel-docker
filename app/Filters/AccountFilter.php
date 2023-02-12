<?php

namespace App\Filters;

use App\Filters\QueryBuilder\AbstractFilter;

class AccountFilter extends AbstractFilter
{

    public function name($val)
    {
        $this->builder->where('name', 'like', "%$val%");
    }


    public function min_balance($val)
    {
        $this->builder->where('min_balance', "$val");
    }

    public function interest_rate($val)
    {
        $this->builder->where('interest_rate', "$val");
    }
}
