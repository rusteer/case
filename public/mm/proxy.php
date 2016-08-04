<?php
function doProxyPost($url){
  $query=$url.(strpos($url,"?")>0?"&":"?")."proxy=true";
  $postBody="";
  foreach($_REQUEST as $key=>$value){
    $postBody.=$key . '=' . urlencode($value) . '&';
  }
  rtrim($postBody,'&');
  $ch=curl_init();
  curl_setopt($ch,CURLOPT_URL,$query);
  curl_setopt($ch,CURLOPT_POSTFIELDS,$postBody);
  $result=curl_exec($ch);
  curl_close($ch);
  echo $result;
}

function doProxyGet($url){
  $query=$url.(strpos($url,"?")>0?"&":"?")."proxy=true";
  foreach($_REQUEST as $key=>$value){
    $query.='&'.$key . '=' . urlencode($value);
  }
  $ch=curl_init($query);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
  curl_setopt($ch,CURLOPT_BINARYTRANSFER,true);
  $result=curl_exec($ch);
  curl_close($ch);
  echo $result;
}
