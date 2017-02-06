<?php
// Optional config values:
$config = require_once('../app/config.php'); 
// Basic functions file:
require_once('../app/functions.php'); 

// If request is POST, prepare an array with passed values:
$post=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
  $post=$_POST; 
}

// Determine correct route
$route=routing($_SERVER['REQUEST_URI']); 
// Render requested page
render($route,$post); 
// End!