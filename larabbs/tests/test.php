<?php
require '../vendor/autoload.php';
use \App\Handlers\SlugTranslateHandler;


function alterArrayToQuery($list)
{
    $sql = "(";
    foreach ($list as $item){
        $sql .= strval($item);
        if ($item !== end($list)) {
            $sql .= ',';
        }
    }
    $sql .= ")";
    return $sql;
}

echo alterArrayToQuery([1,2,3,]);
