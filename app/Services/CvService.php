<?php
/**
 * Created by PhpStorm.
 * User: mamad
 * Date: 05/06/2020
 * Time: 05:32 PM
 */

namespace App\Services;


class CvService
{

    public function file($job)
    {
        $output = [];
        if (count($job) > 1) {
            foreach ($job as $key => $a) {
                foreach ($a as $k => $name) {
                    $output[$k][$key] = $name;
                }
            }
        }
        return $output;

    }



}
