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

class editionService
{

    public function prepareTeam($teams)
    {
        $output = [];
        if (count($teams) > 1) {
            foreach ($teams as $key => $a) {
                foreach ($a as $k => $name) {
                    $output[$k][$key] = $name;
                }
            }
        }
        return $output;
    }
}
