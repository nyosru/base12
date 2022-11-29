<?php

namespace App\Modules\TMFXQ\Managers;


use App\classes\QueryManager;
use App\QueueRootStatus;
use App\QueueStatus;
use App\QueueType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QueueStatusQueryManager extends QueryManager
{

    /**
     * @return array
     */
    protected function availableFields(): array
    {
        return [
            'id',
            'name',
            'root_status',
            'type',
        ];
    }

    /**
     * @return array
     */
    protected function availableFilters(): array
    {
        return ['dashboard_global_status_id','cipostatus_status_formalized_id'];
    }

    /**
     * @return array
     */
    protected function availableSort(): array
    {
        return ['id', 'type'];
    }

    /**
     * @return Builder
     */
    public function build(): Builder
    {
        $builder = QueueStatus::query();

        $this->select($builder);
        $this->filter($builder);
        $this->sort($builder);
        $this->join($builder);

        return $builder;
    }

    private function join(Builder $builder){
        if(in_array('type',$this->fields) || in_array('type',$this->sort))
            $builder->leftJoin(QueueRootStatus::TABLE_NAME,
                QueueStatus::TABLE_NAME.'.queue_root_status_id',
                '=',
                QueueRootStatus::TABLE_NAME.'.id')
                ->leftJoin(QueueType::TABLE_NAME,
                    QueueRootStatus::TABLE_NAME.'.queue_type_id',
                    '=',
                    QueueType::TABLE_NAME.'.id');
    }

    /**
     * @param Builder $builder
     */
    private function select(Builder $builder)
    {
        foreach ($this->fields as $field)
            switch ($field){
                case 'root_status':
                    $this->includeQueueRootStatusWithQueueTypeId($builder);
                    break;
                case 'type':
                    $builder->selectRaw(QueueType::TABLE_NAME.'.id as type');
                    $builder->selectRaw(QueueType::TABLE_NAME.'.name as type_name');
                    break;
                default:
                    $builder->addSelect(QueueStatus::TABLE_NAME . '.' . $field);
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

        if(in_array('dashboard_global_status_id',array_flip($this->filters)) &&
            $this->filters['dashboard_global_status_id']!=1) {
            $builder->where(QueueStatus::TABLE_NAME . '.dashboard_global_status_id',
                $this->filters['dashboard_global_status_id']);
            return;
        }

        foreach ($this->filters as $column => $value) {
                $builder->where(QueueStatus::TABLE_NAME . '.' . $column, $value);
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
            if($column=='type' && in_array($column,$this->fields))
                $builder->orderBy(QueueType::TABLE_NAME . '.id', $direction);
            else
                $builder->orderBy(QueueStatus::TABLE_NAME . '.' . $column, $direction);
        }
    }

    /**
     * @param Builder $builder
     */
    private function includeQueueRootStatusWithQueueTypeId(Builder $builder)
    {
        if (!in_array('queue_root_status_id', $this->fields)) {
            $builder->addSelect(QueueStatus::TABLE_NAME . '.queue_root_status_id');
        }

        $builder->with(['queueRootStatus' => function (BelongsTo $queue_root_status) {
            $queue_root_status->select(['id','name','queue_type_id']);
        }]);
    }
}
