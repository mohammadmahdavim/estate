<?php
/**
 * Created by PhpStorm.
 * User: mamad
 * Date: 05/06/2020
 * Time: 05:32 PM
 */

namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Morilog\Jalali\Jalalian;

class dateService
{

    public function slashToTimeStamps($date)
    {

        $date = explode('/', $date);
        $date = (new Jalalian($date[0], $date[1], $date[2]))->getTimestamp();
        return $date;
    }


}
