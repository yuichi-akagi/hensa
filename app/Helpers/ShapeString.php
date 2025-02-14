<?php
if (! function_exists('ss')) {
    function ss($html)
    {
        if ( strpos($html,'&') ) {
//            $html = str_replace('&','&amp;',$html);
        }
        $html = e($html);
        if ( preg_match_all('|\*\*(.*)\*\*|U',$html,$out,PREG_PATTERN_ORDER) ) {
            foreach ( $out[1] as $rec ) {
                $html = str_replace('**' . $rec . '**','<span class="text-2xl text-bold">' . $rec . '</span>',$html);
            }
        }
        return nl2br($html);
    }
}
