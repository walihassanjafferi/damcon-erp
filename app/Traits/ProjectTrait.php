<?php
namespace App\Traits;

use App\Models\ProjectAdvances;
use Auth;



trait ProjectTrait {

    public static function projectAdvances($title, $user_id, $project_id, $module_name, $module_id, $payment_title, $amount, $comment){

        $project_advance = new ProjectAdvances();
        $project_advance->title = $title;
        $project_advance->user_id = $user_id;
        $project_advance->project_id = $project_id;
        $project_advance->module_name = $module_name;
        $project_advance->module_id = $module_id;
        $project_advance->payment_title = $payment_title;
        $project_advance->amount = $amount;
        $project_advance->comments = $comment;

        if($project_advance->save())
        {
            return "success";
        }

    }
   
}