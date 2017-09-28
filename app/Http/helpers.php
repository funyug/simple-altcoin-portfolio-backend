<?php

function success($data) {
    return ["success"=>1,"data"=>$data];
}

function fail($data) {
    return ["success"=>0,"data"=>$data];
}