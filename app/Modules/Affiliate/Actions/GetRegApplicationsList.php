<?php

namespace App\Modules\Affiliate\Actions;


use App\Modules\Affiliate\Managers\RegApplicationQueryManager;

class GetRegApplicationsList
{
    /**
     * @var array
     */
    private $fields;

    /**
     * @var array
     */
    private $filters;

    /**
     * @var array
     */
    private $sort;

    /**
     * @var int
     */
    private $per_page;

    /**
     * @param array $fields
     * @param array $filters
     * @param array $sort
     * @param int $per_page
     */
    public function __construct(array $fields = [], array $filters = [], array $sort = [], int $per_page = 10)
    {
        $this->fields = $fields;
        $this->filters = $filters;
        $this->sort = $sort;
        $this->per_page = $per_page;
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function run()
    {
        $application_query_manager = new RegApplicationQueryManager($this->fields, $this->filters, $this->sort);

        return $application_query_manager->build()->paginate($this->per_page);
    }
}
