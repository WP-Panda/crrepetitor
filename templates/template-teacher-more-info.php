<div class="more-teachers">
    <?php $category = get_the_category(); ?>
    <div class="more-teachers-title">Другие репетиторы по <a href="#"><?php echo $category[0]->cat_name ?></a></div>
    <?php get_template_part( 'templates/template','teacher-short-short-info' ); ?>
</div>