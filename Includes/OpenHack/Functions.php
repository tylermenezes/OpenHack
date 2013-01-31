<?php

function pathify()
{
    $path = '';
    foreach (func_get_args() as $arg) {
        if (is_array($arg)) {
            $path .= DIRECTORY_SEPARATOR . call_user_func_array('pathify', $arg);
        } else {
            $path .= DIRECTORY_SEPARATOR . $arg;
        }
    }

    return substr($path, 1);
}
