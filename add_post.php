<html>
<?php
$page_title="Write";
include_once('blog.php');

if (!loggedin() ) {
    header("location:log_in.php");
    }

if (isset($_POST['title'],$_POST['category'],$_POST['contents'])){
    $error =array();
    $title =trim($_POST['title']);
    $contents =trim($_POST['contents']);
    if (empty($title)){
        $error[]="please enter a title";
    }
    if( empty($contents)){
        $error[]="please enter a text" ;
    }

    if (strlen($title>250)){
        $error[]="title cannot be longer than 250 characters";
    }
    if ( empty($error) ) {
        add_post($title, $contents, $_POST['category']);
        $id = mysql_insert_id();
        header('location: index.php?id=' . $id);
        die();
    }
}

?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-push-2">
<h1>Add a post</h1>
<?php
if (isset($error)&& ! empty($error)){
echo '<ul><li>',implode('<li><li>',$error),'</li></ul>';
}
?>
<form action="" method="post">
    <div class="row">
        <label for="title" class="hidden">Title</label>
        <input type="text" name="title"  placeholder="Title" value="<?php if (isset($_POST['title'])) echo $_POST['title'] ?>">
    </div>
    <div class="row">
        <label for="contents" class="hidden">Contents</label>
        <textarea name="contents"placeholder="Start Writing here..." rows="15" cols="50"  ><?php if (isset($_POST['contents'])) echo $_POST['contents'] ?></textarea>
    </div>
    <div class="row">
        <label for="category">Category</label>
        <select name="category" class="dropdown">
            <?php
            foreach ( get_categories() as $category) {
                echo("<option value='" . $category['id'] . "'>{$category['name']}</option>");
                ?>
            <?php
            }
            ?>

        </select>
    </div>
    <div>
        <input type="submit" class="btn btn-default" value="Add post">
    </div>
</form>
</div>
</div>
</div>
</body>
</html>