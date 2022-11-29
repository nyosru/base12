<?php $__currentLoopData = $prequalify_request_objs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prequalify_request_obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
    $class='';
    $lp_div='';

    if($prequalify_request_obj->lead_status_id && $prequalify_request_obj->lead_status_id!=5){
        $lp_div='<div class="legend-point not-painted"></div>';
    }

    $phone_icon=$clone_icon=$poo_icon='';
    if($current_status!='finished'){
        $prequalify_request_answer_objs=\App\PrequalifyRequestAnswer::where('prequalify_request_id',$prequalify_request_obj->id)
        ->whereIn('prequalify_question_option_id',\App\PrequalifyQuestionOption::select('id')
            ->whereIn('prequalify_question_id',[10,12,13])
        )->get();

        if($prequalify_request_answer_objs && $prequalify_request_answer_objs->count()){
            $current_user_timezone=\App\Tmfsales::find(session('current_user'))->timezone;
            try{
                $current_user_time=\Carbon\Carbon::now(new \DateTimeZone($current_user_timezone))
                    ->setTimezone(new \DateTimeZone($prequalify_request_obj->timezone))
                    ->format('H:i');
                $current_user_weekday=\Carbon\Carbon::now(new \DateTimeZone($current_user_timezone))
                    ->setTimezone(new \DateTimeZone($prequalify_request_obj->timezone))
                    ->format('w');
            }catch (Exception $e){
                throw new Exception("user:".session('current_user')." timezone:$current_user_timezone");
            }

            $phone_icon='';
            $arr_text_colors=[];
            $result=0;
            $pq_13=false;
            foreach ($prequalify_request_answer_objs as $prequalify_request_answer_obj){
                $slot=[];
                $text_color='';
                switch ($prequalify_request_answer_obj->prequalify_question_option_id){
                    case 48:
                        $slot=['06:00','09:00'];
                    break;
                    case 49:
                        $slot=['09:00','12:00'];
                    break;
                    case 50:
                        $slot=['12:00','15:00'];
                    break;
                    case 51:
                        $slot=['15:00','18:00'];
                    break;
                    case 52:
                        $slot=['18:00','21:00'];
                    break;
                    case 53:
                        $slot=['21:00','23:59'];
                    break;
                    case 58:
                        if(in_array($current_user_weekday,[0,6])){
                            if($current_user_time>='09:00' && $current_user_time<='18:00')
                                $text_color='text-success';
                            else
                                $text_color='text-dark';
                        }else{
                            $text_color='text-dark';
                        }
                        //$phone_icon.=sprintf(' <i class="fas fa-fast-forward %s"></i>',$text_color);
                    break;
                    case 59:
                        if($current_user_time>='07:00' && $current_user_time<='09:00')
                            $text_color='text-success';
                        else
                            $text_color='text-dark';
                        //$phone_icon.=sprintf(' <i class="fas fa-coffee %s"></i>',$text_color);
                    break;
                    case 60:
                        if($current_user_time>='18:00' && $current_user_time<='21:00')
                            $text_color='text-success';
                        else
                            $text_color='text-dark';
                        //$phone_icon.=sprintf(' <i class="fas fa-moon %s"></i>',$text_color);
                    break;
                    case 61:
                        if(
                            ($current_user_weekday>0 && $current_user_weekday<6) &&
                            ($current_user_time>='09:00' && $current_user_time<='18:00')
                        )
                            $result=1;
                        $pq_13=true;
                    break;
                    case 62:
                        if(
                            ($current_user_weekday>0 && $current_user_weekday<6) &&
                            ($current_user_time>='07:00' && $current_user_time<='09:00')
                        )
                            $result=1;
                        $pq_13=true;
                    break;
                    case 63:
                        if(
                            ($current_user_weekday>0 && $current_user_weekday<6) &&
                            ($current_user_time>='18:00' && $current_user_time<='21:00')
                        )
                            $result=1;
                        $pq_13=true;
                    break;
                    case 64:
                        if(
                            in_array($current_user_weekday,[0,6]) &&
                            ($current_user_time>='09:00' && $current_user_time<='18:00')
                        )
                            $result=1;
                        $pq_13=true;
                    break;
                }

                if(strlen($text_color))
                    $arr_text_colors[]=$text_color;

                if(count($slot) && strlen($phone_icon)==0)
                    $phone_icon=' <i class="fas fa-phone-square text-danger"></i>';

                if(count($slot) && $current_user_time>=$slot[0] && $current_user_time<=$slot[1]){
                    $phone_icon=' <i class="fas fa-phone-square text-success"></i>';
                    break;
                }
            }
            if(count($arr_text_colors)){
                if(in_array('text-success',$arr_text_colors))
                    $phone_icon='<i class="fas fa-phone-square text-success"></i> '.$phone_icon;
                else
                    $phone_icon='<i class="fas fa-phone-square text-danger"></i> '.$phone_icon;
            }
            if($pq_13)
                if($result)
                    $phone_icon='<i class="fas fa-phone-square text-success"></i> '.$phone_icon;
                else
                    $phone_icon='<i class="fas fa-phone-square text-danger"></i> '.$phone_icon;
        }
        $email=$prequalify_request_obj->tmfSubject->tmfSubjectContacts()->where('contact_data_type_id',1)->first();
        $phone=$prequalify_request_obj->tmfSubject->tmfSubjectContacts()->where('contact_data_type_id',4)->first();

        $tmf_subject_objs=\App\TmfSubject::where('id','!=',$prequalify_request_obj->tmf_subject_id);
        if($email && $phone){
            $tmf_subject_objs=$tmf_subject_objs->where(function ($query) use ($email,$phone){
                $query->whereIn('id',\App\TmfSubjectContact::select('tmf_subject_id')
                                ->distinct()
                                ->where('contact',$email->contact)
                               )
                    ->orWhereIn('id',\App\TmfSubjectContact::select('tmf_subject_id')
                                ->distinct()
                                ->where('contact',$phone->contact));
            });
        }elseif ($email)
            $tmf_subject_objs=$tmf_subject_objs->whereIn('id',\App\TmfSubjectContact::select('tmf_subject_id')
                                ->distinct()
                                ->where('contact',$email->contact)
                               );
        elseif ($phone)
            $tmf_subject_objs=$tmf_subject_objs->whereIn('id',\App\TmfSubjectContact::select('tmf_subject_id')
                                ->distinct()
                                ->where('contact',$phone->contact)
                               );
        if($tmf_subject_objs && $tmf_subject_objs->count()){
            $clone_icon='<i class="fas fa-clone"></i>';
            $tmf_subject_ids=$tmf_subject_objs->pluck('id')->toArray();
            $tmfsales_tmoffer_not_boom_reason_obj = \App\TmfsalesTmofferNotBoomReason::whereIn('tmoffer_id',
                            \App\Tmoffer::select('ID')
                                    ->whereIn('prequalify_request_id',
                                        \App\PrequalifyRequest::select('id')
                                        ->whereIn('tmf_subject_id',$tmf_subject_ids)
                                    )
                            )
                ->where('not_boom_reason_id', 79)
                ->get();
            if($tmfsales_tmoffer_not_boom_reason_obj && $tmfsales_tmoffer_not_boom_reason_obj->count())
                $poo_icon='<i class="fas fa-poo" style="color:brown"></i>';
        }
    }
    ?>
    <li class="list-group-item pq-application pt-1 pb-1" data-status="<?php echo e($current_status); ?>" data-id="<?php echo e($prequalify_request_obj->id); ?>">
        <div class="d-table">
            <div class="d-table-row">
                <div class="d-table-cell align-middle"><?php echo $lp_div; ?></div>
                <div class="d-table-cell align-middle p-1 pr-2" style="line-height: 1;"><span style="font-size: 11px;"><?php echo \DateTime::createFromFormat('Y-m-d H:i:s',$prequalify_request_obj->created_at)->format('M j, Y \<\b\r\/\>\@ H:i'); ?></span></div>
                <div class="d-table-cell align-middle">
                    <?php echo $poo_icon; ?>

                    <?php echo $clone_icon; ?>

                    <?php echo ($prequalify_request_obj->quiz_at?'<i class="fas fa-money-bill-alt text-success"></i>':''); ?>

                    <?php echo e($prequalify_request_obj->tmfSubject->first_name); ?> <?php echo e($prequalify_request_obj->tmfSubject->last_name); ?>

                    <?php echo $phone_icon; ?>

                </div>
            </div>
        </div>
    </li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/pq-applications/applications-list.blade.php ENDPATH**/ ?>