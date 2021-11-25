<?php

//XSS
function escape($word) {
    return htmlspecialchars($word, ENT_QUOTES, 'UTF-8');
}

//トークンを作成
function getCSRFToken(){
    $nonce =  base64_encode(openssl_random_pseudo_bytes(48));
    setcookie('XSRF-TOKEN',$nonce);
    return $nonce;
}

