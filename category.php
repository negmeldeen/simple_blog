<?php
$page_title="Category Listing";
include_once('blog.php');
$posts = get_posts(null, $_GET['id']);
?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-push-2">
<?php
foreach($posts as $post){
?>
<h3 class="post-title"><a href="index.php?id=<?php echo $post['post_id']?>"> <?php echo $post['title']; ?> </a></h2>
<div class="meta-data"> Posted on <?php echo date('d-m-Y h:i:s', strtotime($post['date_posted'])); ?>
        in <a href="category.php?id=<?php echo $post['category_id']; ?>"><?php echo $post['name'];?></a>
        </div>
        <div><p class="post-content"><?php echo nl2br($post['contents']);?></p></div>
        <div class="post-functions">
                        <div class="post-functions">
                                    <ul class="inline-list">
                                                                                <?php if(loggedin()){?>
                                        <li>
                                            <a href="delete_post.php?id=<?php echo $post["post_id"]; ?>"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                                        </li>
                                        <li>
                                            <a href="edit_post.php?id=<?php echo $post['post_id']; ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></a>
                                        </li>
                                        <?php }?>
                                         <li>
                                            <div class="fb-share-button"></div>
                                        </li>
                                        <li>
                                            <a class="twitter-share-button"
                                            href="https://twitter.com/share">
                                            Tweet
                                            </a>
                                            <script>
                                            window.twttr=(function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],t=window.twttr||{};if(d.getElementById(id))return t;js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);t._e=[];t.ready=function(f){t._e.push(f);};return t;}(document,"script","twitter-wjs"));
                                            </script>    
                                        </li>
                                    </ul>
        </div>
<?php
}
?>

</div>
</div>
</div>
</body>
</html>