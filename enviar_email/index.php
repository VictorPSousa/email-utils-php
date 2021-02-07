<?php

$headers = 'From: php.mailing.test@gmail.com' . "\r\n" . 
           'MIME-Version: 1.0' . "\r\n" .
           'Content-Type: text/html; charset=utf-8';

$result = mail("php.mailing.test@gmail.com", "Hello World", "This is email body", $headers);
var_dump($result);