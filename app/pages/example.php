<?php
/**
 * Simple GET example
 */

// Here you can set values that will be used in header or footer:
$page_title='Example title - '.$config['company_name'];
$page_description='Example metadescription for this url';
?>
<div class="container">
  <div class="row">
    <div class="col-md-6">
      <h1>This is only an example page</h1>      
      <p>Each page can receive any number of parameters. You can set a valid number of parameters for each page in an included function called check_parameters().</p>    
      <h2>Add parameters to this url:</h2>
      <ol>
        <li><a href="/example/parameter-1">One Parameter</a></li>
        <li><a href="/example/parameter-1/parameter-2-rocks">Two Parameters</a></li>
        <li><a href="/example/parameter-1/parameter-2-rocks/cool-stuff">Three Parameters</a></li>
        <li><a href="/example/parameter-1/parameter-2-rocks/cool-stuff/too-much-parameters">Four Parameters (triggers a 404 error)</a></li>
      </ol>
<?php
if(!empty($parameters)):?>
      <h2>Parameters detected in this url</h2>
      <ul>
<?php
  foreach($parameters as $k=>$v):?>
        <li>
          <?=$k?>: <?=$v?>
        </li> 
<?php    
  endforeach;
?>
      </ul>
<?php 
else:?>
      <h2>No parameters detected</h2>
<?php      
endif;?>
    </div><!-- /.col-md-6 -->
    <div class="col-md-6">
      <h2>Example form with POST</h2>
      <form method="post" action="/example_post">
        <div class="form-group">
          <label for="example_field">Insert something here:</label>
          <input type="text" class="form-control" name="example" id="example_field" placeholder="Gimme something!">
        </div><!-- /.form-group -->
        <div class="form-group">
          <label for="example_field_2">And insert something more here:</label>
          <input type="text" class="form-control" name="example_2" id="example_field_2" placeholder="Gimme something more!">
        </div><!-- /.form-group -->
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
    </div><!-- /.col-md-6 -->
  </div><!-- /.row -->
</div><!-- /.container -->