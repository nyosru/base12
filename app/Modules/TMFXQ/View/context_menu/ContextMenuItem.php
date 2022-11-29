<?php
namespace App\Modules\TMFXQ\View\context_menu;


abstract class ContextMenuItem
{
    /**
     * @var string
     */
    protected $icon;

    /**
     * @var string
     */
    protected $classname;

    /**
     * @var string
     */
    protected $caption;

    /**
     * @var int
     */
    protected $dashboard_id;

    /**
     * @var int
     */
    protected $queue_status_id;

    /**
     * ContextMenuItem constructor.
     * @param int $dashboard_id
     * @param int $queue_status_id
     */
    public function __construct(int $dashboard_id, int $queue_status_id){
        $this->dashboard_id=$dashboard_id;
        $this->queue_status_id=$queue_status_id;
    }

    /**
     * @return string
     */
    abstract public function getHtml();

    /**
     * @return string
     */
    abstract public function getJs();

    /**
     * @return string
     */
    abstract public function getModal();
}