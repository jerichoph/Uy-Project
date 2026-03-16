<?php

$key = "campusmart_secret";

function encryptData($data){
    global $key;
    return openssl_encrypt($data,"AES-256-ECB",$key);
}

function decryptData($data){
    global $key;
    return openssl_decrypt($data,"AES-256-ECB",$key);
}

?>