<?php
namespace App\Modules\TMFXQ\View\context_menu;


class QueueRandomCheckContextMenu extends ContextMenu
{
    /**
     * ContextMenu constructor.
     * @param int $dashboard_id
     * @param int $queue_status_id
     */
    public function __construct(int $dashboard_id, int $queue_status_id)
    {
        parent::__construct($dashboard_id,$queue_status_id);
        $this->context_menu_items[]=new ClaimMenuItem($dashboard_id,$queue_status_id);
        $this->context_menu_items[]=new UnclaimMenuItem($dashboard_id,$queue_status_id);
        $this->context_menu_items[]=new RequestReviewMenuItem($dashboard_id,$queue_status_id);
        $this->context_menu_items[]=new RemoveRequestReviewMenuItem($dashboard_id,$queue_status_id);
        $this->context_menu_items[]=new ViewInDashboardContextMenuItem($dashboard_id,$queue_status_id);
        $this->context_menu_items[]=new TmfentryContextMenuItem($dashboard_id,$queue_status_id);
        $this->context_menu_items[]=new ViewInAcceptedAgreementsContextMenuItem($dashboard_id,$queue_status_id);
        $this->context_menu_items[]=new ViewInSearchReportContextMenuItem($dashboard_id,$queue_status_id);
        $this->context_menu_items[]=new ViewTmOfficePageContextMenuItem($dashboard_id,$queue_status_id);
        $this->context_menu_items[]=new DashboardNotesMenuItem($dashboard_id,$queue_status_id);
        $this->context_menu_items[]=new ShowHistoryMenuItem($dashboard_id,$queue_status_id);
        $this->context_menu_items[]=new EditFlagValuesMenuItem($dashboard_id,$queue_status_id);
    }
}