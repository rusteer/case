<?php 
header("Content-Type: text/html;charset=utf-8");
include_once 'mm/proxy.php';
doProxyGet("http://localhost/response/omit/");