<?php

use AuthPackage\Auth;

include('vendor/autoload.php');


$auth = new Auth();
echo '<pre>';
var_dump($auth->login('test13@example.com', 'test12'));
// var_dump($auth->login('test13@example.com', 'tetetete'));
echo '</pre>';
