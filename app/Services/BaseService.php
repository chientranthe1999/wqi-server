<?php

namespace App\Services;

use App\Constants\Common;
use App\Helpers\UtilHelper;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

abstract class BaseService
{
    /**
     * The eloquent model instance of a specific table.
     *
     * @var Model
     */
    protected $model;

    /**
     * The eloquent builder instance of model instance.
     *
     * @var Builder
     */
    protected $query;

    /**
     * The request instance.
     *
     * @var Request
     */
    protected $request;

    public function __construct()
    {
        $this->setModel();
        $this->query = $this->model->newQuery();
    }

    abstract protected function setModel();

    /**
     * Display a listing of the resource.
     *
     * @param array $relations
     */
    public function index(Request $r)
    {
        if (method_exists($this, '_addFilter')) {
            $this->_addFilter($r);
        }
        $this->_addDefaultFilter($r);
        if ($r->input('limit')) {
            return $this->query->paginate($r->input('limit', Common::PAGING_LIMIT));
        } else return $this->query->get();
    }

    /**
     * Retrieve the specified resource.
     *
     * @param int $id
     * @param array $relations
     * @param array $appends
     * @return Model
     */
    public function show(string $id, array $relations = [], array $appends = [], bool $withTrashed = false): Model
    {
        $query = $this->query;
        if ($withTrashed) {
            $query->withTrashed();
        }
        return $query->with($relations)->findOrFail($id)->setAppends($appends);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return bool
     *
     * @throws ModelNotFoundException|Exception
     */
    public function destroy($id)
    {
        return $this->query->findOrFail($id)->delete();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param array $attributes
     * @return Model|bool
     * @throws Exception
     */
    public function store(array $attributes = [], Request $r)
    {
        $data = count($attributes) ? $attributes : $r->input();

        $parent = $this->query->create($data);
        $relations = [];

        foreach (array_filter($attributes, [$this, '_isRelation']) as $key => $models) {
            if (method_exists($parent, $relation = Str::camel($key))) {
                $relations[] = $relation;
                $this->syncRelations($parent->$relation(), $models, false);
            }
        }
        if (count($relations)) {
            $parent->load($relations);
        }
        return $parent->push() ? $parent : false;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Model|int $parent
     * @param array $attributes
     * @return Model|bool
     *
     * @throws ModelNotFoundException
     * @throws Exception
     */
    public function update($id, array $attributes)
    {
        if ($id) {
            $parent = $this->query->findOrFail($id);
        }
        dd($attributes);
        $parent->fill($attributes);
        return $parent->push() ? $parent : false;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function _addDefaultFilter(Request $r)
    {
        foreach ($r->all() as $key => $value) {
            if (preg_match('/(.*)_like$/', $key, $matches) && ($value || is_numeric($value))) {
                $keyword = UtilHelper::normalizeKeywordForSearch($value);
                $this->query->whereRaw("LOWER({$matches[1]}) LIKE BINARY LOWER('%{$keyword}%')");
            }
            if (preg_match('/(.*)_equal$/', $key, $matches) && ($value || is_numeric($value))) {
                $this->query->where($matches[1], $value);
            }
            if (preg_match('/^has_(.*)/', $key, $matches) && $value) {
                $this->query->whereHas($matches[1]);
            }
            if ($key == 'sort' && $value) {
                $sortParams = explode('|', $value);
                $this->query->orderBy($sortParams[0], $sortParams[1] ?? Common::PAGING_ORDER_TYPE);
            }
        }
        if (!$r->get('sort')) {
            $this->query->orderBy(Common::PAGING_ORDER_BY, Common::PAGING_ORDER_TYPE)->orderByDesc('id');
        }
    }

    /**
     * @param $value
     * @return bool
     */
    private function _isRelation($value): bool
    {
        return is_array($value) || $value instanceof Model;
    }

    /**
     * @param Relation $relation
     * @param array | Model $conditions
     * @param bool $detaching
     * @return void
     * @throws Exception
     */
    private function _syncRelations(Relation $relation, $conditions, bool $detaching = true): void
    {
        $conditions = is_array($conditions) ? $conditions : [$conditions];
        $relatedModels = [];
        foreach ($conditions as $condition) {
            if ($condition instanceof Model) {
                $relatedModels[] = $condition;
            } else if (is_array($condition)) {
                $relatedModels[] = $relation->firstOrCreate($condition);
            }
        }

        if ($relation instanceof BelongsToMany && method_exists($relation, 'sync')) {
            $relation->sync($this->_parseIds($relatedModels), $detaching);
        } else if ($relation instanceof HasMany | $relation instanceof HasOne) {
            $relation->saveMany($relatedModels);
        } else {
            throw new Exception('Relation not supported');
        }
    }

    /**
     * @param array $models
     * @return array
     */
    private function _parseIds(array $models): array
    {
        $ids = [];
        foreach ($models as $model) {
            $ids[] = $model instanceof Model ? $model->getKey() : $model;
        }
        return $ids;
    }
}
