<?php
date_default_timezone_set('Asia/Manila');

define('__ROOT__', dirname(dirname(__FILE__)));

#error handling
function shit(){
    echo'<h1>KFC</h1>';
    echo'<div><b>404</b> Not found, error was encountered while trying to use an error document to handle request.</div>';
    echo'<a href="javascript:history.go(-1)">Go back to my previous page</a>';
}

function isUrlValid($url){
  $absolute_url2 = ltrim(str_replace(basename(__ROOT__).'/', '', strtok($url, "?")), '/');
  $au3 = explode('/', $absolute_url2);
  $url_ext_arr = array();
  foreach ($au3 as $key => $value) {
    $path = pathinfo($value, PATHINFO_EXTENSION);
    array_push($url_ext_arr, $path);
  }
  $url_ext_arr = array_values(array_filter($url_ext_arr));
  if(count(array_unique($url_ext_arr)) < count($url_ext_arr)){
    die(shit());
  }
}

$absolute_url = $_SERVER['REQUEST_URI'];
$url_base = basename($_SERVER['REQUEST_URI']);
isUrlValid($absolute_url);

$url = "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s://" : "://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
//$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//$url = basename($_SERVER['REQUEST_URI']);
#$url_shit = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

if (!filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_QUERY_REQUIRED) === false) {
    //echo("$url is a valid URL");
} else {
   if(strpos($url_base, ".php") !== true){
    if(!@file_get_contents($url_base) && (basename(__ROOT__) != $url_base )){
      header('Location:index.php');
      /*shit();
      return false*/;
    }
  }
}


/*DESTROY SESSION IF BROWSER IS CLOSED*/
session_set_cookie_params(0);
session_start();



//$_SESSION['timestamp'] = $now;

$GLOBALS['config'] = array(
  'mysql' => array(
    'host' => '127.0.0.1',
    'username' => 'root',
    'password' => '',
    'dbname'   => 'icweb'
  )
);


$GLOBALS['config'] = array(
	'mysql' => array(
		'host' => '127.0.0.1',
		'username' => 'root',
		'password' => '',
		'dbname' => 'master_data'
	)
);

$GLOBALS['config'] = array(
  'mysql' => array(
    'host' => '127.0.0.1',
    'username' => 'root',
    'password' => '',
    'dbname'   => 'asset_mgt'
  )
);



spl_autoload_register('autoload');

function autoload($class , $dir = null){
  if(is_null($dir)){
    $dir = __ROOT__.'/class/';
  }
  foreach ( array_diff(scandir($dir), array('.', '..'))  as $file) {
    if(is_dir($dir.$file)){
      autoload($class, $dir.$file.'/');
    }else{
      if ( substr( $file, 0, 2 ) !== '._' && preg_match( "/.php$/i" , $file ) ) {
        include $dir . $file;
        // filename matches class?
        /*if ( str_replace( '.php', '', $file ) == $class || str_replace( '.class.php', '', $file ) == $class ) {
        }*/
      }
    }
  }
}


/*if(isset($_SESSION['timestamp'])){
  $checkTime = time() - $_SESSION['timestamp'];
  if($checkTime > 5) {
    $userId = $_SESSION['user_id'];
    if(session_destroy()){
      Audit::loggedOutUser($userId);
      unset($_SESSION['user_id'], $_SESSION['password'], $_SESSION['timestamp']);
    }
  }else{
    //$_SESSION['timestamp'] = time();
  }
}
*/

//header("Content-Type: text/html; charset=ISO-8859-1");
if(isset($_SESSION['user_id'])){
  if(!cp::checkPass($_SESSION['user_id'])){
    if(session_destroy()){
      echo'<script>
          alert("Please login again for security");
          window.location.href="index.php";
        </script>';
      //header('Location:index.php');
    }
  }
}


if(isset($_SESSION['lang'])){
  $lang = $_SESSION['lang'];
}else{
  $lang = 0;
}
//header("Content-Type: text/html");


