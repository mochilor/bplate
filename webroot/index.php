<?php
// Basic functions file:
require_once('../app/functions.php'); 

// Determine correct route
$route=routing(filter_input(INPUT_SERVER,'REQUEST_URI')); 

// Render requested page
render($route,$_POST); 
// End!