<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
include_once('config.php');
//session
session_start();
//login check function
function loggedin(){
    if (isset($_SESSION['username']) || isset($_COOKIE['username'])){
        return true;
    }
    return false;
}
?>
<head>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet"  type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,800' rel='stylesheet' type='text/css'>
<link rel="icon" 
      type="image/png" 
      href="favicon.ico">
<style>
body{
    font-family: 'Open Sans', sans-serif;
}
.container-fluid{
    position: fixed;
    background: #fff;
    width: 100%;
    margin-top: -1;
}
.navbar-default{
    background: #fff;
    border-radius: 0;
}
.navbar-header{
    margin: auto auto 20px 11px;
}
.navbar-nav {
    margin-top: 10px;
}
.navbar-brand{
    padding-top: 0;
}
.cover{
    background: 
    linear-gradient(
      rgba(0, 0, 0, 0.4), 
      rgba(0, 0, 0, 0.45)
    ),
    url("images/cover.jpg") no-repeat center;;
  background-size: cover;
  width: 100%;
  height: 100%;
  margin-top: -5%;
}
.post-title{
    text-align: center;
    font-size: 4.5rem;
}
.post-title > a{
    color: #666;
    font-weight: 300;
}
.meta-data{
    color: rgba(0, 0, 0, 0.3);
    font-size: 12px;
    font-weight: 400;
    letter-spacing: -0.366667px;
    line-height: 13.2px;
}
.inline-list{
    list-style: none;
    display: block;
    padding: 0;
}
.inline-list > li{
    display: inline;
    margin-left:10px;
}
</style>
<title><?php echo $page_title;?> - Sherif Negm's Place</title>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>
<body>
<div class="navbar navbar-default">
  <div class="container-fluid">
    <button type="button" id="nav-toggle" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">
        <img alt="Daftary" src="daftary.png">
      </a>
    </div>
      <ul class="nav navbar-nav main-nav">
        <li><a href="add_category.php">Add Category</a></li>
        <li><a href="add_post.php">Add post</a></li>
        <li><a href="category_list.php">Category list</a></li>
        <li><a href="about.php">the writer</a></li>
        <?php if (loggedin()){?>
        <li><a href="logout.php">Log out</a></li>
        <?php }else{ ?>
        <li><a href="log_in.php">Log in</a></li>
        <?php }?>
      </ul>
    </div>
</div>
<?php

function truncate($string,$length=100,$append="&hellip;") {
  $string = trim($string);

  if(strlen($string) > $length) {
    $string = wordwrap($string, $length);
    $string = explode("\n", $string, 2);
    $string = $string[0] . $append;
  }
  return $string;
}
function add_post($title,$contents,$category){

    $title=mysql_real_escape_string($title);
    $contents=mysql_real_escape_string($contents);
    $category=(int) $category ;
   // mysql_query("INSERT INTO posts (`contents`,`title`,`date_posted`,`cat_id`) VALUES ($contents,$title,NOW(),$category)");
   //$sql = "INSERT INTO posts (cat_id,title,content,date_posted) VALUES(8,\'a7ee\',\',a7ee tani\',NOW())\n"
    mysql_query("INSERT INTO `posts` SET
          `cat_id`        = $category,
         `title`         = '$title',
         `contents`      = '$contents',
         `date_posted`   = NOW()");
    echo mysql_error();
}
function edit_post($id, $title, $contents, $category) {
    $id         = (int) $id;
    $title      = mysql_real_escape_string($title);
    $contents   = mysql_real_escape_string($contents);
    $category   = (int) $category;
    mysql_query("UPDATE `posts` SET
        `cat_id`    = {$category},
        `title`     = '{$title}',
        `contents`  = '{$contents}'
        WHERE `id` = {$id} ");
}
function add_category($name){
    $sql = "INSERT INTO categories (`id`, `name`) VALUES (null,'{$name}');";    
    mysql_query($sql);
}

function delete($table,$id){
    $table==mysql_real_escape_string($table);
    $id= (int) $id;
    mysql_query("DELETE FROM $table WHERE id = $id");
    echo mysql_error();
}
function get_posts($id = null, $cat_id = null) {$posts = array();
    $query = "SELECT posts.id AS post_id, categories.id AS category_id, title, contents, date_posted, categories.name FROM posts INNER JOIN categories ON categories.id = posts.cat_id ";
    
    if ( isset($id) ) {
        $id = (int) $id;
        $query .= " WHERE `posts` . `id` = {$id}";
    }
    if (isset($cat_id) ){
        $cat_id = (int) $cat_id;
        $query .= " WHERE `cat_id` = {$cat_id}";
    }
    $query .= " ORDER BY `posts` . `id` DESC";
    $query = mysql_query($query);
    while ($row = mysql_fetch_assoc($query) ) {
        $posts[] = $row;
    }
    return $posts;
}

function get_categories ($id = null){
$categories=array();
    $query=mysql_query("SELECT `id`, `name` FROM `categories` WHERE 1 LIMIT 0, 30 ");
    if (! $query){
        throw new My_Db_Exception('Database error: ' . mysql_error());
    }
    while($row = mysql_fetch_assoc($query)){
        //handle rows.
        $categories[]=$row;
    }
    return $categories;


}
///////////////////////////////////////////////////////////////////////////////////////////////
function category_exists($field, $value) {
    $field = mysql_real_escape_string($field);
    $value = mysql_real_escape_string($value);
    $q = "SELECT COUNT(1) FROM categories WHERE {$field} = '{$value}'";
    $query = mysql_query($q);
    echo mysql_error();
    return ( mysql_result($query, 0) == '0' ) ? false : true; 
}