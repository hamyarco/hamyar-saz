<?php   defined('ABSPATH') || exit ("no access"); ?>
<?php \HamyarSaz\core\helpers::template( 'header',['title'=>'برگه ها']); ?>
    <div class="row " id="posts">
        <link rel="stylesheet" type="text/css" href="<?php echo HAMYAR_SAZ_MATERIALIZE_URL ?>app-assets/css-rtl/pages/eCommerce-products-page.css">
<?php
$count=12;
$paged=get_query_var('paged') ? get_query_var('paged') : 1;
$offset = ($paged - 1) * $count;

$args = array(
    'post_type' => 'page',
    'paged' => $paged,
    'post_status' => ['publish','pending'],
    'offset' => $offset,
    'posts_per_page' =>$count
);

$loop = new WP_Query( $args );
if (isset($loop->posts) && count($loop->posts)>0){
    $hidden=true;
    global $post;
    foreach ($loop->posts as $post){
        $post=WP_Post::get_instance( $post->ID );

        ?>
        <div class="col s6  m4 l3">
            <div class="card">
                <?php if($post->post_status=='pending'): ?>
                    <div class="card-badge pending"><a class="white-text"> <b>بایگانی شده</b> </a></div>
                <?php endif; ?>
                <div class="card-image waves-effect waves-block waves-light ">
                    <?php
                    if (get_post_thumbnail_id(get_the_ID())) {
                        echo get_the_post_thumbnail( get_the_ID(), 'medium' ,['class'=>'activator']);
                    }else{
                        echo '<img width="300" height="300" src="/wp-content/uploads/woocommerce-placeholder.png" class="attachment-medium size-medium wp-post-image activator" alt="" decoding="async">';
                    }
                    ?>
                </div>
                <div class="card-content padding-5">
                    <span class="card-title">
                        <span class="text-ellipsis"> <?php the_title() ?> </span>
                        <span class="activator"><i class="material-icons">more_vert</i></span>
                    </span>
                </div>
                <div class="card-reveal" style="display: none; transform: translateY(0%);">
                    <span class="card-title grey-text text-darken-4"><i class="material-icons right close-icon">close</i></span>
                    <ul class="">
                        <li><a class="col s12 btn mt-8 mb-8 waves-effect waves-light" href="<?php the_permalink() ?>"  target="_blank">مشاهده </a></li>
                        <li><a class="col s12 btn mb-8 waves-effect waves-light" href="/hamsaz/pages/edit/<?php the_ID(); ?>/"  >ویرایش</a></li>
                        <li>
                            <form method="post">
                                <?php wp_nonce_field() ?>
                                <input type="hidden" name="post_id" value="<?php the_ID(); ?>">
                                <?php if (get_post_status(get_the_ID())=='publish'): ?>
                                    <input type="hidden" name="action" value="archvie" >
                                    <button type="submit" class="col s12 btn mb-8 waves-effect waves-light" >بایگانی</button>
                                <?php else: ?>
                                    <input type="hidden" name="action" value="unarchvie" >
                                    <input type="hidden" name="action" value="unarchvie" >
                                    <button type="submit" class="col s12 btn mb-8 waves-effect waves-light" >بازگردانی</button>
                                <?php endif; ?>
                            </form>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <?php
    }
}else{
    $hidden=false;
}
$page_loop= ceil($loop->found_posts/$count) ;
if ( $loop->found_posts > $count ):
?>
        <div class="col s12">
            <ul class="pagination center">
                <?php if ($paged==1): ?>
                    <li class="disabled">
                        <a href="#!">
                            <i class="material-icons">chevron_left</i>
                        </a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="<?php echo home_url(get_query_var('hamsaz')).'/paged/1/'; ?>">
                            <i class="material-icons">chevron_left</i>
                        </a>
                    </li>
                <?php endif; ?>
                <?php for($i=1 ; $i <= $page_loop;$i++): ?>

                <li class="<?php echo ($i==$paged)?'active':'' ?>"><a href="<?php echo home_url(get_query_var('hamsaz')).'/paged/'.$i; ?>"><?php echo $i ?></a>
                    </li>
                <?php endfor; ?>
                <?php if ($paged==$page_loop): ?>
                    <li class="disabled">
                        <a href="#!">
                            <i class="material-icons">chevron_right</i>
                        </a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="<?php echo home_url(get_query_var('hamsaz')).'/paged/'.$page_loop; ?>">
                            <i class="material-icons">chevron_right</i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>

        <?php
    endif; ?>
        </div>

    <div style="bottom: 20px; right: 10px;" class="fixed-action-btn"><a href="add/" class="btn-floating waves-effect waves-light gradient-45deg-purple-deep-orange"><i class="material-icons">add</i></a>
    </div>
<?php
\HamyarSaz\core\helpers::template( 'footer'); ?>