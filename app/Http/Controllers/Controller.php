<?php

namespace App\Http\Controllers;
use App\Valiable;

abstract class Controller
{

    protected function getPrefCodeByRoma($prefRoma)
    {
        foreach ( Valiable::get('parameter2_001') as $key => $rec ) {
            if ( $rec == $prefRoma ) {
                return $key;
            }
        }
        return null;
    }
    //
}
