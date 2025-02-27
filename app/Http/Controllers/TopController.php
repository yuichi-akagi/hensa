<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Valiable;
use App\Models\HsStat;
use App\Models\Hs;

class TopController extends Controller
{

    public function index(Request $request)
    {
        $enables = ['11'];
        $pref_list = [];
        $hs_list = [];

        $result = HsStat::where('is_show','=',1)->get();
        $ids = [];
        foreach ( $result as $rec ) {
            $ids[] = $rec->hs_id;
        }
        foreach ( Valiable::get('parameter2_001') as $key => $roma ) {
            if ( in_array($key ,$enables) ) {
                $pref_list[$roma] = Valiable::getValue('parameter_001',$key);
                $hs_list[$roma] = Hs::whereIn('id',$ids)->where('prefecture','=',$key)->orderBy('id')->get();
            }
        }
        return view('top.index')
            ->with('pref_list',$pref_list)
            ->with('hs_list',$hs_list)
        ;
    }
    //
}
