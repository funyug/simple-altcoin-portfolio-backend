<?php

function success($data) {
    return response(["success"=>1,"data"=>$data]);
}

function fail($data) {
    return response(["success"=>0,"data"=>$data]);
}