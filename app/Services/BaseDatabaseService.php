<?php

namespace App\Services;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BaseDatabaseService
{
    public $model, $filterObject;


    public function userid($val)
    {
        $userId = (int) $val;
        return $this->model::whereHas('teamUsers', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        });
    }

    public function index($with = null)
    {
        if ($with) {
            if (is_array($with)) {
                $query = $this->model::query();
                foreach ($with as $relation) {
                    $query->with($relation);
                }
            } else {
                $query = $this->model::with($with);
            }
            return $query->get();
        }
        return $this->model::all();
    }

    public function find($id, $with = null)
    {
        if ($with) {
            if (is_array($with)) {
                $query = $this->model::where('_id', $id)->where(function ($query) {
                    $query->where('is_deleted', false)->orWhereNull('is_deleted');
                });
                foreach ($with as $relation) {
                    $query->with($relation);
                }
                return $query->first();
            } else {
                return $this->model::with($with)->where(function ($query) {
                    $query->where('is_deleted', false)->orWhereNull('is_deleted');
                })->find($id);
            }
        }
        return $this->model::where(function ($query) {
            $query->where('is_deleted', false)->orWhereNull('is_deleted');
        })->find($id);
    }

    public function store(array $data)
    {
        $model = new $this->model;
        foreach ($data as $key => $val) {
            $model->$key = $val;
        }
        $model->save();
        return $model;
    }

    public function update($id, array $data)
    {
        $model = $this->find($id);
        if (!$model) {
            throw new Exception('Model not found', 404);
        }
        foreach ($data as $key => $val) {
            $model->$key = $val;
        }
        $model->save();
        return $model;
    }


    public function delete($id)
    {
        $model = $this->find($id);
        if ($model) {
            $model->delete();
            return $model;
        }
        return false;
    }

    public function rawWhere(array $condition): Builder
    {
        $query = $this->model::query();
        foreach ($condition as $key => $val) {
            $query->where($key, $val);
        }
        return $query;
    }

    public function filter(Request $request)
    {
        return (new $this->filterObject($request->all()))
            ->apply($this->model::query());
    }
    public function filterArray(array $data)
    {
        return (new $this->filterObject($data))
            ->apply($this->model::query());
    }
}
