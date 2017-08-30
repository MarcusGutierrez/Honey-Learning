<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function current_time()
{
    $t = microtime(true);
    $micro = sprintf("%06d",($t - floor($t)) * 1000000);
    $d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );
    return $d->format("Y-m-d H:i:s.u");
}

function format($time_milli)
{
    $secs = $time_milli / 1000;
    $milli = substr($time_milli, strlen($time_milli)-3, 3);
    //dd($milli);
    $d = new DateTime( date('Y-m-d H:i:s.'.$milli, $secs) );
    //dd($d->format("Y-m-d H:i:s.u"));
    return $d->format("Y-m-d H:i:s.u");
}