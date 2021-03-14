 <?php
/*
* Plugin Name: pakrun post custom api
* Plugin URI: http://pakrunco.com
* Description: this plugin made for better api of blog posts
* Author: Alireza Sayyah
* Version: 1.0
* Text Domain: Pakrun Company
*/

function pakrun_getposts_api(){
   $args=[
        'numberposts'=>99999,
        'post_type'=>'post'
   ];
   $posts=get_posts($args);
   $i=0;
   $data=[];

   foreach($posts as $post){
        $data[$i]['count']=$i+1;
        $data[$i]['id']=$post->ID;
        $data[$i]['title']=$post->post_title;
        $data[$i]['excerpt']=$post->post_excerpt;
        $data[$i]['content']=$post->post_content;
        $data[$i]['categories']=get_the_category($post->ID);
        $data[$i]['date']=$post->post_date;
        $data[$i]['slug']=$post->post_name;
        $data[$i]['image']['thumbnail']=get_the_post_thumbnail_url($post->ID,'thumbnail');
        $data[$i]['image']['large']=get_the_post_thumbnail_url($post->ID,'large');
        $headline = get_post_meta( $post->ID, '_yoast_wpseo_title', true);
        $desc = get_post_meta( $post->ID, '_yoast_wpseo_metadesc', true);
        $keyword = get_post_meta($post->ID, '_yoast_wpseo_focuskw',true);
        $data[$i]['headline-seo']=$headline;
        $data[$i]['desc-seo']=$desc;
        $data[$i]['keyword-seo']=$keyword;
        $i++;
   }
   return $data;
    
}


add_action("rest_api_init",function(){
    register_rest_route('API_ROUTE','getposts',[
        'methods'=>'GET',
        'callback'=>'pakrun_getposts_api'
    ]);
});
