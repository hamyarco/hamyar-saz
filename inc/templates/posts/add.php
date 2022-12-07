<?php   defined('ABSPATH') || exit ("no access"); ?>
<?php \HamyarSaz\core\helpers::template( 'header',['title'=>!empty($id)?'ویرایش مقاله':'افزودن مقاله']); ?>
<?php
if (isset($id) && !empty($id)){
    global $post;
    $post=WP_Post::get_instance($id);
    if ( ! $post ) {
        wp_die('مقاله ای یافت نشد');
    }

    $arg = [
        'post_id'=>get_the_ID(),
        'title' =>get_the_title(),
        'description' =>get_the_content(),
        'categories'=>get_categories(),
        'image_id'=>get_post_thumbnail_id(),
    ];
}else{
    $arg=[];
}

$default_args = [
    'post_id'=>'',
    'title' =>'',
    'description' =>'',
    'categories'=>[],
    'images'=>'',
];
extract(hsaz_default_args($default_args,$arg));
?>
    <link rel="stylesheet" href="<?php echo HAMYAR_SAZ_MATERIALIZE_URL ?>app-assets/vendors/select2/select2-materialize.css" type="text/css">
    <div class="row " >
        <div class="col s12 m6 l4 push-m3 push-l4 ">
            <div id="validation" class="card card card-default scrollspy">
                <div class="card-content">
                    <form enctype="multipart/form-data" data-bitwarden-watching="1" method="post">
                        <?php wp_nonce_field() ?>
                        <input type="hidden" name="post_id" value="<?php echo $post_id ?>">
                        <div class="row hamsaz-uploader mb-3">
                            <label>
                                <input type="hidden" name="image-uploader" value="<?php echo $image_id ?>">
                                <input type="hidden" id="single-image-url" value="<?php echo (!empty($image_id))? wp_get_attachment_image_src( $image_id,'full' )[0] :'' ?>">
                                <div id="single-image"></div>
                                <div class="website-logo-wrapper">
                                    <input type="button" value="<?php echo (!empty($image_id))? 'ویرایش تصویر':'افزودن تصویر'  ?>" class="upload-btn upload-single-image">
                                    <input type="file">
                                </div>
                            </label>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="title" type="text" name="title" class="" required value="<?php echo $title; ?>">
                                <label for="title">عنوان</label>
                            </div>
                        </div>
                        <div class="row">
                            <span id="old-text" style="display: none"><?php echo $description; ?></span>
                            <!-- /# -->
                            <div class="input-field col s12">
                                    <div class="snow-container">
                                        <div class="compose-editor"></div>
                                        <div class="compose-quill-toolbar hidden">
                                                <span class="ql-formats mr-0">
                                                    <button class="ql-bold"></button>
                                                    <button class="ql-link"></button>
                                                    <button class="ql-image"></button>
                                                </span>
                                        </div>
                                    </div>
                                <input type="hidden" name="description">
                           </div>
                        </div>
                        <div class="row">
                            <div class="input-field">
                                <select class="select2 browser-default" multiple="multiple" name="categories[]">
                                    <?php
                                    $terms = get_terms( ['taxonomy'=>'category','hide_empty' => false] );
                                    foreach ( $terms as $term ) {
                                        $selected='';
                                        foreach ($categories as $category){
                                            if ($category == $term->term_id){
                                                $selected='selected';
                                            }
                                        }
                                        printf('<option value="%s" %s>%s</option>', $term->term_id,$selected, $term->name);
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <button class="btn cyan waves-effect waves-light right" type="submit" name="action"><?php echo !empty($id)?'ویرایش':'افزودن' ?>
                                    <i class="material-icons right">send</i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php ob_start(); ?>
    <script>
        $(document).ready(function () {
            $(".select2").select2({
                dropdownAutoWidth: true,
                width: '100%',
                placeholder: "انتخاب دسته بندی",
                dir: "rtl",
                tags: true
            });
        });
        <?php if (!empty($image_id)): ?>
        initialExistImage('#single-image');
        <?php endif; ?>
        // Quill Editor
        // -------------------
        var composeTodoEditor = new Quill(".snow-container .compose-editor", {
            modules: {
                toolbar: ".compose-quill-toolbar"
            },
            placeholder: "توضیحات...",
            theme: "snow"
        });
        <?php if (!empty($description)): ?>
        // composeTodoEditor.setText(document.querySelector('#old-text').innerHTML);
        var editor = document.getElementsByClassName('ql-editor')
        editor[0].innerHTML = document.querySelector('#old-text').innerHTML
        <?php endif; ?>
    </script>
<?php $script=ob_get_clean();

\HamyarSaz\core\helpers::template( 'footer',['script'=>$script]); ?>