<?php
namespace App\Modules\TMFXQ\Actions;

use App\QueueType;

class QueueTypeManager
{
    /**
     * @return QueueType[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllRows(){
        return QueueType::all();
    }
}