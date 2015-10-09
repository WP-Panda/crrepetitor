<?php function bottom_complite(){

    $args1 = array(
        'hide_empty' => false,
        'orderby' => 'id',
        'order'=> 'DESC',
        'exclude' => 1,
    );

    $term_obj = '';
    $myterms1 = get_terms( array( 'category' ), $args1 );
    foreach( $myterms1 as $term ){
        if( 0 == $term->parent) {
            $args1['parent'] = $term->term_id;
            $myterms3 = get_terms( array( 'category' ), $args1 );
            foreach( $myterms3 as $term2 ){
// print_r($term2);
                $term_obj .= '"' . $term2->name .'",';
            }
        }
    }
    ?>
    <script>
        (function($){
            var availableTags = [<?php echo $term_obj; ?>];
            $( "#compliter" ).autocomplete({
                source: availableTags
            });
        })(jQuery);
    </script>

<?php
}