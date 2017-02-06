<?php
/**
 * Check requested url, generating a route array. The url is splited by '/'
 * characters. First element in array will be requested page file. Remaining
 * elements (if any) will be passed as an array to the view.
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
  $request=trim($request,'/');
  if($request){
    $url=explode('/',filter_var(rtrim($request,'/'),FILTER_SANITIZE_URL));
    if(!empty($url)){
      // First value in $route will be the requested pàge file.
      $route['page']=$url[0];
      unset($url[0]);  
      if($url){    
        // If there are still values in $url, they will be inserted in an array:
        $route['parameters']=array_values($url);
      } 
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
function render($route,$post=[]){
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
    // If not found, file will be replacede with 404 page:
    $file='not-found';
    $path=dirname(__FILE__).'/pages/'.$file.'.php';
  }  
      
  // If $post is empty (that is, the page is requested via GET), render page content
  // inside an HTML layout. 
  // $parameters contain any parameter found in route
  // $bodyclass contain the name of the file to be included in body tag as a class.
  if(empty($post)){
    $parameters=$route['parameters'];
    $bodyclass=[$file];
    require_once('layout/header.php');
    require_once($path);
    require_once('layout/footer.php');
  }else{
    extract($post);
    require_once($path);
  }  
}