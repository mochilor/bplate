<?php
/**
 * Simple GET example
 */
?>
<h1>This is only an example page</h1>
<p>Lorem ipsum...</p>
<?php
if(!empty($parameters)):?>
<h2>Parameters for this url</h2>
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
endif;?>
<form method="post" action="example_post">
  <lable for="example_field">Insert something here:</label>
  <input type="text" name="example" id="example_field"><br />
  <lable for="example_field_2">And insert something here:</label>
  <input type="text" name="example_2" id="example_field_2">
  <input type="submit" value="send">
</form>