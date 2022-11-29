<?php

namespace App\classes;


use Illuminate\Database\Eloquent\Builder;

abstract class QueryManager
{
    /**
     * @var array
     */
    protected $fields;

    /**
     * @var array
     */
    protected $filters;

    /**
     * @var array
     */
    protected $sort;

    /**
     * @param array $fields
     * @param array $filters
     * @param array $sort
     */
    public function __construct(array $fields = [], array $filters = [], array $sort = [])
    {
        $this->fields = $this->_getFields($fields);
        $this->filters = $this->_getFilters($filters);
        $this->sort = $this->_getSort($sort);
    }

    /**
     * @return array
     */
    protected abstract function availableFields(): array;

    /**
     * @return array
     */
    protected abstract function availableFilters(): array;

    /**
     * @return array
     */
    protected abstract function availableSort(): array;

    /**
     * @return Builder
     */
    public abstract function build(): Builder;

    /**
     * @param array $sort
     * @return array
     */
    private function _getSort(array $sort): array
    {
        return array_intersect_key($sort, array_flip($this->availableSort()));
    }

    /**
     * @param array $fields
     * @return array
     */
    private function _getFields(array $fields): array
    {
        $fields = array_intersect($fields, $this->availableFields());

        if (empty($fields)) {
            $fields = $this->availableFields();
        }

        return $fields;
    }

    /**
     * @param array $filters
     * @return array
     */
    private function _getFilters(array $filters): array
    {
        return array_intersect_key($filters, array_flip($this->availableFilters()));
    }
}
