<?php
function getCacheHashMap($key, $value ){
    error_log("get cache from helper");
    $cache = \Config\Services::cache();
    $cache = $cache->get($key);
    if($cache){
        $result = $cache[$value];
        return $result;
    }else{
        return false;
    }
}

function getCache($key){
    error_log("get cache from helper");
    error_log($key);
    $cache = \Config\Services::cache();
    $cache = $cache->get($key);
    if($cache){
        return $cache;
    }else{
        return false;
    }
}