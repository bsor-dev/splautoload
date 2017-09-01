<?php


define('__ROOT__', dirname(dirname(__FILE__)));


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



