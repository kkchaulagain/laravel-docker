<?php

namespace App\Filters;

use App\Filters\QueryBuilder\AbstractFilter;

class FileFilter extends AbstractFilter
{

    public function document_id($val)
    {
        $this->builder->where('document_id', "$val");
    }

    public function application_id($val)
    {
        $this->builder->whereHas('document', function ($query) use ($val) {
            $query->where('application_id', "$val");
        });
    }
}
