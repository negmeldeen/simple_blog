<?php
$page_title = "Categories";
include_once('blog.php');
?>
<div class="container">
    <div class="row">
        <div class="col-md-3 col-md-push-3">
<?php
foreach(get_categories() as $category){
?>
    <p><a href="category.php?id=<?php echo $category['id'] ?>"><?php echo $category['name'] ?></a> 
    	        <?php if (loggedin()){?>
    	 - <a href="delete_category.php?id=<?php echo $category['id'] ?>">DELETE</a>
    </p>
<?php
}
}
?>
</div></div></div>
</body>
</html>
