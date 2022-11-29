<?php
namespace App\Modules\TMFXQ\View\context_menu;


use App\QueueCache;
use Illuminate\Support\Facades\Auth;

class RequestReviewMenuItem extends ContextMenuItem
{

    public function __construct(int $dashboard_id, int $queue_status_id=0){
        parent::__construct($dashboard_id,$queue_status_id);
        $this->icon='<i class="fas fa-search"></i>';
        $this->classname='request-review-link';
        $this->caption='Request Review';
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function getHtml()
    {
        $queue_cache=QueueCache::where('dashboard_id',$this->dashboard_id)->first();
        $dashboard_details=json_decode($queue_cache->json,true);
        if(
            (intval($dashboard_details['review_requested'])==0))
            return view('tmfxq::context-menu.non-url-item',[
                    'icon'=>$this->icon,
                    'classname'=>$this->classname,
                    'caption'=>$this->caption,
                    'dashboard_id'=>$this->dashboard_id,
                    'queue_status_id'=>$this->queue_status_id
                ])->render();
        else
            return '';
    }

    /**
     * @return string
     * * @throws \Throwable
     */
    public function getJs()
    {
        return view('tmfxq::context-menu.request-review-item-js')->render();
    }

    /**
     * @return string
     * * @throws \Throwable
     */
    public function getModal()
    {
        return view('queue.request-review-modal')->render();
    }
}