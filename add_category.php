<?php
$page_title = "Add Category";

include_once('blog.php');
if (!loggedin() ) {
    header("location:log_in.php");
}
if (isset($_POST['name'])){
    $name = trim($_POST['name']);
    if ( empty($name) ){
        $error = 'You must submit a category name.';
    } else if ( category_exists('name', $name) ) {
        $error = 'That category already exists.';
    } else if ( strlen($name) > 240 ) {
        $error = ' Category names can be max 24 characters.' ;
    }else{
        add_category($name);
        header("location: add_post.php");
    }
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-push-2">
<h1>add category</h1>
<?php
if (isset($error)){
    echo "<p> {$error}</p>";
}
?>
<form action="" method="post">
    <div>
        <label for="name">Name</label>
        <input type="text" name="name" value="">
    </div>
    <div>
        <input type="submit" value="add_category">
    </div>
    </div>
    </div>
</form>
</body>
</html>