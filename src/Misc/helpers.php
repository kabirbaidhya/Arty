<?php

if (!function_exists('array_undot')) {
    function array_undot(array $array)
    {
        $output = array();
        foreach ($array as $key => $value) {
            array_set($output, $key, $value);
        }

        return $output;
    }
}

if (!function_exists('array_dot_once')) {
    function array_dot_once(array $array)
    {
        $output = array();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $key2 => $value2) {
                    $output[$key.'.'.$key2] = $value2;
                }
            } else {
                $output[$key] = $value;
            }
        }

        return $output;
    }
}
