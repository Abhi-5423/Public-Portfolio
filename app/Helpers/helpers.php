<?php
function e(mixed $v):string{return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8');}
function csrf():string{if(empty($_SESSION['csrf']))$_SESSION['csrf']=bin2hex(random_bytes(32));return $_SESSION['csrf'];}
function verify_csrf():void{if(!hash_equals($_SESSION['csrf']??'',$_POST['csrf']??'')){http_response_code(419);exit('Invalid CSRF token.');}}
function flash(string $key,?string $value=null):?string{if($value!==null){$_SESSION['flash'][$key]=$value;return null;}$v=$_SESSION['flash'][$key]??null;unset($_SESSION['flash'][$key]);return $v;}
function redirect(string $url):never{header('Location: '.$url);exit;}
function require_admin():void{if(empty($_SESSION['admin']))redirect('/admin/login.php');}
