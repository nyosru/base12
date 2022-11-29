<?php

namespace App\Modules\Affiliate\Managers;


use App\classes\QueryManager;
use App\Modules\Affiliate\Models\RegApplication;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegApplicationQueryManager extends QueryManager
{

    /**
     * @return array
     */
    protected function availableFields(): array
    {
        return [
            'id', 'profile', 'text', 'status', 'created_at'
        ];
    }

    /**
     * @return array
     */
    protected function availableFilters(): array
    {
        return ['status'];
    }

    /**
     * @return array
     */
    protected function availableSort(): array
    {
        return ['id', 'status', 'created_at'];
    }

    /**
     * @return Builder
     */
    public function build(): Builder
    {
        $builder = RegApplication::query();

        $this->select($builder);
        $this->filter($builder);
        $this->sort($builder);

        return $builder;
    }

    /**
     * @param Builder $builder
     */
    private function select(Builder $builder)
    {
        foreach ($this->fields as $field) {
            if ($field == 'profile') {
                $this->includeProfile($builder);
                continue;
            }

            $builder->addSelect(RegApplication::TABLE_NAME . '.' . $field);
        }
    }

    /**
     * @param Builder $builder
     */
    private function filter(Builder $builder)
    {
        if (empty($this->filters)) {
            return;
        }

        foreach ($this->filters as $column => $value) {
            $builder->where(RegApplication::TABLE_NAME . '.' . $column, $value);
        }
    }

    /**
     * @param Builder $builder
     */
    private function sort(Builder $builder)
    {
        if (empty($this->sort)) {
            return;
        }

        foreach ($this->sort as $column => $direction) {
            $builder->orderBy(RegApplication::TABLE_NAME . '.' . $column, $direction);
        }
    }

    /**
     * @param Builder $builder
     */
    private function includeProfile(Builder $builder)
    {
        // It is not possible to include relation, if the foreign key is missing from columns, this is important to make
        // sure that `aff_profile_id` column will be included in the field list
        if (!in_array('aff_profile_id', $this->fields)) {
            $builder->addSelect(RegApplication::TABLE_NAME . '.aff_profile_id');
        }

        $builder->with(['profile' => function (BelongsTo $profile) {
            $profile->select(['id', 'name', 'email', 'phone', 'address']);
        }]);
    }
}
