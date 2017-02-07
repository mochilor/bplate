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
 * @param array $config Array with global configuration.
 * @param array $post The content of $_POST, if any.
 */
function render($route,$config,$post=[]){
  $error=false;
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
  if(!file_exists($path)){
    // If not found, $error is set to true:
    $error=true;
  }  
  // If $post is empty (that is, the page is requested via GET), render page content inside a HTML layout.   
  if(empty($post)){
    // $parameters contain any parameter found in route
    $parameters=$route['parameters'];
    if(!$error){
      $error=check_parameters($parameters,$file);
    }
    if($error){
      // If page file is not found or incorrect arguments are detected, we send a 404 error:
      $file='not-found';
      $path=dirname(__FILE__).'/pages/'.$file.'.php';
      header("HTTP/1.0 404 Not Found");
    }
    // $bodyclass contain the name of the file to be included in body tag as a class.
    $bodyclass=[$file];
    require_once('layout/header.php');
    require_once($path);
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
  // If $page is in $valida_parameters array, we'll perform a check:
  if(array_key_exists($page,$valid_parameters)){
    if(count($parameters)>$valid_parameters[$page]){
      // If passed parameters exceed limit, return false:
      $error=true;
    }
  }
  return $error;
}