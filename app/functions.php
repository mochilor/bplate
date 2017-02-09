<?php
/**
 * Check requested url, generating a route array. The url is splited by '/'
 * characters. First element in array will be requested page file. Remaining
 * elements (if any) will be passed as an array to the view. Url need to be in 
 * friendly format, therefore mod_rewrite must be enabled in server.
 * 
 * @param string $request The requested url
 * @return array An array with the requested file and any optional parameters.
 */
function routing($request){
  // Default route:
  $route=[
    'page'       => 'home',
    'parameters' => []
  ];
  // Check request:
  $checked_request=trim($request,'/');
  if($checked_request){
    $url=explode('/',filter_var(rtrim($checked_request,'/'),FILTER_SANITIZE_URL));
    // First value in $url will be the requested page file.
    $route['page']=$url[0];
    unset($url[0]);  
    if($url){    
      // If there are still values in $url, they will be inserted in an array:
      $route['parameters']=array_values($url);
    } 
  }  
  // Return obtained route:
  return $route;    
}

/**
 * Render requested page. If called via GET, it will include HTML layout, elsewhere
 * it only renders content of file. Any parameter found in GET request will be
 * passed to view inside $parameters array.
 * 
 * @param array $route The array returned by routing().
 * @param array $post The content of $_POST, if any.
 */
function render($route,$post){
  $error=true;
  // Set requested file:
  $file=$route['page'];
  // Set file folder based on request type:
  if(empty($post)){
    $folder='/pages/';
  }else{
    $folder='/ajax/';
  }
  // Check file path
  $path=dirname(__FILE__).$folder.$file.'.php';
  if(file_exists($path)){
    $error=check_parameters($route['parameters'],$file);
  }  
  // If page file is not found or incorrect arguments are detected, we send a 404 error:
  if($error){
    $file='not-found';
    $path=dirname(__FILE__).'/pages/'.$file.'.php';
    header("HTTP/1.0 404 Not Found");
  }
  // Optional config values:
  $config = require_once('../app/config.php'); 
  
  // If $post is empty (that is, the page is requested via GET), render page content inside a HTML layout.   
  if(empty($post)){
    // $parameters contain any parameter found in route
    $parameters=$route['parameters'];
    // $body_class contain the name of the file to be included in body tag as a class.
    $body_class=[$file];    
    
    // Execute code in page file and store all generated content in a variable:
    ob_start();
    require_once($path);
    $content=ob_get_contents();
    ob_end_clean();    
    
    // Render page:
    require_once('layout/header.php');
    echo $content;
    require_once('layout/footer.php');
  }else{
    extract($post);
    require_once($path);
  }  
}

/**
 * Check that received parameters won't exceed the established limit for each 
 * page. Those limits can be set in $valid_parameters. Returns true if an invalid
 * number of parameters is detected.
 * 
 * @param array $parameters Received parameters that will be checked.
 * @param string $page Requested page.
 * @return boolean
 */
function check_parameters($parameters,$page){  
  $error=false;
  // Here you can define valid number of parameters for desired pages:
  $valid_parameters=[
      'example' => 3,
  ];
  // If $page is in $valid_parameters array, we'll perform a check:
  if(array_key_exists($page,$valid_parameters)){
    if(count($parameters)>$valid_parameters[$page]){
      // If passed parameters exceed limit, return false:
      $error=true;
    }
  }elseif(count($parameters)>0){
    // By default, we forbid any parameter in url
    $error=true;
  }
  return $error;
}