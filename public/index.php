<?php

require '../vendor/autoload.php';


// require '../Core/Router.php';
// require '../App/Controllers/Home.php';
// require '../App/Controllers/Posts.php';

// spl_autoload_register( function($class)

//     {
//       $root = dirname(__DIR__);
//       $file = $root.'/'.str_replace('\\','/',$class).'.php';
//       if(is_readable($file))
//       {
//         require $file;
//       }
// });
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');
$url = $_SERVER['QUERY_STRING'];





$router = new Core\Router;


//echo get_class($router);

$router->add('',['controller'=>'Home','action'=>'index']);
$router->add('posts',['controller'=>'Posts','action'=>'index']);
// $router->add('posts/new',['controller'=>'Posts','action'=>'new']);
$router->add('{controller}/{action}');
$router->add('admin/{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{action}',['namespace'=>'Admin']);

// echo '<pre>';
//   // print_r($router->getParams());
// echo htmlspecialchars(print_r($router->getRoutes(),true));  
// echo '</pre>';
 
// if($router->match($url))
// { echo '<pre>';
//   echo print_r($router->getParams(),true);
//   echo '</pre>';
// } else {
//   echo "Requested URL doesn't exist!";
// }

$router->dispatch($url);