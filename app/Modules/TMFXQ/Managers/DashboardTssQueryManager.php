<?php

namespace App\Modules\TMFXQ\Managers;


use App\classes\QueryManager;
use App\DashboardTss;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DashboardTssQueryManager extends QueryManager
{

    /**
     * @return array
     */
    protected function availableFields(): array
    {
        return [
            'id',
            'description',
            'dashboard',
            'cipostatus_status_formalized',
            'dashboard_global_status',
            'tmfsales',
            'created_at',
            'warning_at',
            'danger_at',
        ];
    }

    /**
     * @return array
     */
    protected function availableFilters(): array
    {
        return ['dashboard_id'];
    }

    /**
     * @return array
     */
    protected function availableSort(): array
    {
        return ['id', 'created_at'];
    }

    /**
     * @return Builder
     */
    public function build(): Builder
    {
        $builder = DashboardTss::query();

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
                case 'dashboard':
                    $this->includeDashboard($builder);
                    break;
                case 'cipostatus_status_formalized':
                    $this->includeCipostatusStatusFormalized($builder);
                    break;
                case 'dashboard_global_status':
                    $this->includeDashboardGlobalStatus($builder);
                    break;
                case 'tmfsales':
                    $this->includeTmfsales($builder);
                    break;
                default:
                    $builder->addSelect(DashboardTss::TABLE_NAME . '.' . $field);
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
            $builder->where(DashboardTss::TABLE_NAME . '.' . $column, $value);
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
            $builder->orderBy(DashboardTss::TABLE_NAME . '.' . $column, $direction);
        }
    }

    /**
     * @param Builder $builder
     */
    private function includeDashboard(Builder $builder)
    {
        if (!in_array('dashboard_id', $this->fields)) {
            $builder->addSelect(DashboardTss::TABLE_NAME . '.dashboard_id');
        }

        $builder->with(['dashboard' => function (BelongsTo $dashboard) {
            $dashboard->select(['id']);
        }]);
    }

    /**
     * @param Builder $builder
     */
    private function includeCipostatusStatusFormalized(Builder $builder)
    {
        if (!in_array('cipostatus_status_formalized_id', $this->fields)) {
            $builder->addSelect(DashboardTss::TABLE_NAME . '.cipostatus_status_formalized_id');
        }

        $builder->with(['cipostatusStatusFormalized' => function (BelongsTo $cipostatus_status_formalized) {
            $cipostatus_status_formalized->select(['id','status']);
        }]);
    }

    /**
     * @param Builder $builder
     */
    private function includeDashboardGlobalStatus(Builder $builder)
    {
        if (!in_array('dashboard_global_status_id', $this->fields)) {
            $builder->addSelect(DashboardTss::TABLE_NAME . '.dashboard_global_status_id');
        }

        $builder->with(['dashboardGlobalStatus' => function (BelongsTo $dashboard_global_status) {
            $dashboard_global_status->select(['id','status_name']);
        }]);
    }

    /**
     * @param Builder $builder
     */
    private function includeTmfsales(Builder $builder)
    {
        if (!in_array('tmfsales_id', $this->fields)) {
            $builder->addSelect(DashboardTss::TABLE_NAME . '.tmfsales_id');
        }

        $builder->with(['tmfsales' => function (BelongsTo $tmfsales) {
            $tmfsales->select(['ID','Login','LongID','FirstName','LastName']);
        }]);
    }
}
