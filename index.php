<?php ob_start();?>
<?php
/*
Plugin Name: Wp Sticky Side Buttons
Plugin URI: https://www.wpajans.net
Description: WordPress Advanced, useful sticky buttons
Version: 2.1
Author: WpAJANS - Mustafa KÜÇÜK
Author URI: https://www.wpajans.net
License: GNU
*/

## Global Variables ##
$current_link = 'http://'.$_SERVER['HTTP_HOST' ].$_SERVER['REQUEST_URI'];

## Create Table ##
global $wpdb;
if ($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}wpajans_stickybuttons'") != $wpdb->prefix . 'wpajans_stickybuttons'){
  $wpdb->query("CREATE TABLE {$wpdb->prefix}wpajans_stickybuttons (
  id integer not null auto_increment,
  btntext TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  image TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  link TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  background TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,

  PRIMARY KEY (id)
  );");
}


## Menu ##
add_action('admin_menu', 'wpajans_sticky_manager');

function wpajans_sticky_manager()
 {
 add_options_page('WpAJANS-Buttons','WpAJANS-StickyButtons', '8', 'wpajansstickybuttons', 'wpajans_stickyfunctions');
 }

 ## Functions ##
 function wpajans_stickyfunctions() {
    global $current_link;
 ?>

<!-- CSS Files -->
 <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/forms-min.css">
 <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/buttons-min.css">
 <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/tables-min.css">

<!-- Button Add Form -->
 <div style="margin-top:10px;">
 <h2>Button Add</h2>
 <form class="pure-form pure-form-aligned" method="post" action="">
    <fieldset>
        <div class="pure-control-group">
            <label for="name">Text</label>
            <input id="text" name="stickybuttontext" type="text" placeholder="text">
        </div>

        <div class="pure-control-group">
            <label for="Image">Image Or font awesome</label>
            <input id="text" name="stickybuttonimage" type="text" placeholder="Image Or font awesome"> // image http://* 50*50 or font-awesome ex fa fa-home
        </div>

        <div class="pure-control-group">
            <label for="Link">Link</label>
            <input id="text" name="stickybuttonlink" type="text" placeholder="link">
        </div>

        <div class="pure-control-group">
            <label for="foo">Background Color</label>
            <input id="text" name="stickybuttonbgcolor" value="#29a9e8" type="color" placeholder="#29a9e8">
        </div>

        <div class="pure-controls">

            <button type="submit" class="pure-button pure-button-primary">Add</button>
        </div>
    </fieldset>
</form>
 </div>
<!-- Button List -->
<h2>Button List</h2>

<table class="pure-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Text</th>
            <th>Link</th>
            <th>Image</th>
            <th>Background Color</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
    <?php if($_GET["action"]=="delete"){
$back_page = $_SERVER['HTTP_REFERER'];
$deletebuttonid = $_GET["id"];
global $wpdb;
$deleteds = $wpdb->delete($wpdb->prefix.'wpajans_stickybuttons',array('id'=>$deletebuttonid));
    if($deleteds){
header("location: $back_page");
ob_end_flush();
    }}
    ?>
    <?php
global $wpdb;

$btnlist = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wpajans_stickybuttons order by id DESC" );
foreach($btnlist as $row)
{
?>
        <tr class="pure-table-odd">
            <td><?php echo $row->id;?></td>
            <td><?php echo $row->btntext;?></td>
            <td><?php echo $row->link;?></td>
            <td><?php echo $row->image;?></td>
            <td><?php echo $row->background;?></td>
            <td><a href="<?php echo $current_link;?>&action=delete&id=<?php echo $row->id;?>">Delete</a></td>

        </tr>
<?php } ?>

    </tbody>
</table>

<?php
if($_POST){

global $wpdb;

## Values ##
$stickybuttontext = $_POST["stickybuttontext"];
$stickybuttonimage = $_POST["stickybuttonimage"];
$stickybuttonlink = $_POST["stickybuttonlink"];
$stickybuttonbgcolor = $_POST["stickybuttonbgcolor"];

if(empty($stickybuttontext) or empty($stickybuttonlink)){
  echo '<div id="message" style="margin: 9px 0;" class="error notice notice-error is-dismissible below-h2"><p>Please fill in the fields</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Hide this message.</span></button></div>';
}else{


## Add ##
$values=array(
        'btntext'=>$stickybuttontext,
        'image'=>$stickybuttonimage,
        'link'=>$stickybuttonlink,
        'background'=>$stickybuttonbgcolor
        );
$buttonadd = $wpdb->insert($wpdb->prefix.'wpajans_stickybuttons',$values);
}
if($buttonadd)
{
    echo '<div id="message" style="margin: 9px 0;" class="updated notice notice-success is-dismissible below-h2"><p>Button added. <a target="_blank" href="'.get_bloginfo(url).'">Show Site</a></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Hide this message.</span></button></div>';
}

}else{

}
?>

 <?php }

## Function ##
function wordpress_Sticky_btns()
{
?>

<!-- CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

<style>
.sticky-container {
  /* background-color: #333; */
  padding: 0px;
  margin: 0px;
  position: fixed;
  right: -140px;
  top: 130px;
  width: 200px;
  z-index: 9999999;
}
.sticky li {
  opacity: .5;
      border: 3px solid #E8E8E8;
      border-radius: 7px;
      list-style-type: none;
      background-color: #29a9e8;
      color: #efefef;
      height: 61px;
      padding: 0px;
      margin: 0px -35px 1px;
      -webkit-transition: all 0.6s ease-in-out;
      -moz-transition: all 0.6s ease-in-out;
      -o-transition: all 0.6s ease-in-out;
      transition: all 0.6s ease-in-out;
      cursor: pointer;
      /* filter: url("data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\'><filter ….3333 0 0 0.3333 0.3333 0.3333 0 0 0 0 0 1 0\'/></filter></svg>#grayscale"); */
      filter: gray;
      /* -webkit-filter: grayscale(100%); */
}
.sticky li:hover {
  opacity: 1;
  margin-left: -180px;
  /* background-color: #8e44ad; */
  -webkit-filter: grayscale(0%);
}
.sticky li img {
  display: block;
  /* float: left; */
    margin: -5px 5px;
      padding: 6px;
  margin-right: 10px;
}
.sticky li i {
  display: block;
  /* float: left; */
    margin: -5px 5px;
      padding: 6px;
  margin-right: 10px;
}
.sticky li p {
  position: relative;
bottom: 61px;
padding: 0px;
margin-left: 61px;
    line-height: 68px;
    font-size: 1.17em;
color: #fff;
z-index: -1;
}
</style>

<div class="sticky-container">
<ul class="sticky">
    <?php
global $wpdb;

$btnlist = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wpajans_stickybuttons order by id ASC" );
foreach($btnlist as $row)
{
    ?>
<li style="background:<?php echo $row->background;?>">
<a href="<?php echo $row->link;?>">
<?php $detect = mb_substr($row->image,0,2);
if($detect=="fa"){
echo'<i style="font-size:50px;color:#fff" class="'.$row->image.'"></i>';
}else{?>
<img width="64" target="_blank" title="<?php echo $row->btntext;?>" alt="" src="<?php echo $row->image;?>" />
<?php }?>
</a>
<p><?php echo $row->btntext;?></p>
</li>
<?php } ?>

</ul>
</div>
<?php
}
?>
