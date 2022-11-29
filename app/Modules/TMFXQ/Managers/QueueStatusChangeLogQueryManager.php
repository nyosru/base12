<?php

namespace App\Modules\TMFXQ\Managers;


use App\classes\QueryManager;
use App\Modules\TMFXQ\Models\QueueStatusChangeLog;
use App\QueueRootStatus;
use App\QueueStatus;
use App\QueueType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QueueStatusChangeLogQueryManager extends QueryManager
{

    /**
     * @return array
     */
    protected function availableFields(): array
    {
        return [
            'id',
            'tmfsales',
        ];
    }

    /**
     * @return array
     */
    protected function availableFilters(): array
    {
        return ['created_at','tmfsales_id'];
    }

    /**
     * @return array
     */
    protected function availableSort(): array
    {
        return ['id','count_id'];
    }

    /**
     * @return Builder
     */
    public function build(): Builder
    {
        $builder = QueueStatusChangeLog::query();

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
        foreach ($this->fields as $field)
            switch ($field){
                case 'tmfsales':
                    $this->includeTmfsales($builder);
                    break;
                default:
                    $builder->addSelect(QueueStatusChangeLog::TABLE_NAME . '.' . $field);
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

        foreach ($this->filters as $column => $data)
            if($column=='created_at') {
                foreach ($data as $el)
                    $builder->where(QueueStatusChangeLog::TABLE_NAME . '.' . $column, $el['operator'], $el['value']);
            }else
                $builder->where(QueueStatusChangeLog::TABLE_NAME . '.' . $column, $data);

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
            if($column=='count_id')
                $builder->orderByRaw(sprintf('count(%s.id) %s',QueueStatusChangeLog::TABLE_NAME,$direction));
            else
                $builder->orderBy(QueueStatusChangeLog::TABLE_NAME . '.' . $column, $direction);
        }
    }

    /**
     * @param Builder $builder
     */
    private function includeTmfsales(Builder $builder)
    {
        if (!in_array('tmfsales_id', $this->fields)) {
            $builder->addSelect(QueueStatusChangeLog::TABLE_NAME . '.tmfsales_id');
        }

        $builder->with(['tmfsales' => function (BelongsTo $tmfsales) {
            $tmfsales->select(['ID','FirstName','LastName']);
        }]);
    }
}
