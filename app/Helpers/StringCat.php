<?php
if (! function_exists('strcat')) {
    function strcat()
    {
        $args = func_get_args();
        $str = '';
        foreach ( $args as $rec ) {
            if ( ! $rec ) return null;
        }
        return join("",$args);
    }
}
