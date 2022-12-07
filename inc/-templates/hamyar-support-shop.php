<?php
if (!is_user_logged_in()){
    wp_safe_redirect('/wp-login.php');
}else{
    global $post;
    xdebug_break();
    if (get_current_user_id()!== (int)$post->post_author){
        wp_die('این صفحه خصوصی بوده و فقط سازنده آن قادر به مشاهده آن خواهد بود.');
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
صفحه اصلی فروشگاه

</body>
</html>