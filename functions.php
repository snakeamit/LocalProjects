<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

// END ENQUEUE PARENT ACTION

//enque custom js
function add_custom_script(){
    
    wp_enqueue_script('xlsx-js',  get_stylesheet_directory_uri() . "/export/libs/js-xlsx/xlsx.core.min.js'; ", NULL, NULL, false );
    wp_enqueue_script('html2canvas-js', get_stylesheet_directory_uri() . "/export/libs/html2canvas/html2canvas.min.js'; ", NULL, NULL, false );
    wp_enqueue_script('tableExport_b-js',  get_stylesheet_directory_uri() . "/export/tableExport_b.js'; ", NULL, NULL, false );
    
    wp_enqueue_script('map-js', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAHzN1ZqSiBrBFYjoaP8ONLUACo33jPIbU&callback=Function.prototype', NULL, NULL, true );
    
    wp_enqueue_script('custom-js', get_stylesheet_directory_uri() . '/assets/js/custom.js?time='.time(), NULL, NULL, true );
    
    wp_localize_script( 'custom-js', 'frontendajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
}
add_action( 'wp_enqueue_scripts', 'add_custom_script' );



function update_custom_post_number( $post_id ) {
    // Check if the post is of your custom post type
    if ( get_post_type( $post_id ) === 'apel-proiect' ) {
        // Get the current highest custom_post_number
        $args = array(
            'post_type'      => 'calendar-apeluri',
            'posts_per_page' => 1,
            'meta_key'       => 'id_apel',
            'orderby'        => 'meta_value_num',
            'order'          => 'DESC',
        );
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                $highest_number = get_field( 'id_apel' );
            }
            wp_reset_postdata();
        } else {
            $highest_number = 0;
        }

        // Update the custom_post_number with the incremented value
        $new_number = $highest_number + 1;
        update_field( 'id_apel', $new_number, $post_id );
    }
}
add_action( 'save_post', 'update_custom_post_number', 10, 1 );

// custom post type project
function custom_post_type() {
  
// Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Projects', 'Post Type General Name', 'Divi' ),
        'singular_name'       => _x( 'Projects', 'Post Type Singular Name', 'Divi' ),
        'menu_name'           => __( 'Projects', 'Divi' ),
        'parent_item_colon'   => __( 'Parent Project', 'Divi' ),
        'all_items'           => __( 'All Projects', 'Divi' ),
        'view_item'           => __( 'View Project', 'Divi' ),
        'add_new_item'        => __( 'Add New Project', 'Divi' ),
        'add_new'             => __( 'Add New', 'Divi' ),
        'edit_item'           => __( 'Edit Project', 'Divi' ),
        'update_item'         => __( 'Update Project', 'Divi' ),
        'search_items'        => __( 'Search Project', 'Divi' ),
        'not_found'           => __( 'Not Found', 'Divi' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'Divi' ),
    );
      
// Set other options for Custom Post Type
      
    $args = array(
        'label'               => __( 'Projects', 'Divi' ),
        'description'         => __( 'Projects', 'Divi' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail','revisions',),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,
  
    );
    
    
      
    // Registering your Custom Post Type
    register_post_type( 'projects', $args );
  
// taxnomy for localitate
    $labels = array(
    'name' => _x( 'Localitate', 'taxonomy general name','Divi' ),
    'singular_name' => _x( 'Localitate', 'taxonomy singular name','Divi' ),
    'search_items' =>  __( 'Search Localitate','Divi' ),
    'all_items' => __( 'All Localitate' ,'Divi'),
    'parent_item' => __( 'Parent Localitate','Divi' ),
    'parent_item_colon' => __( 'Parent Localitate:','Divi'),
    'edit_item' => __( 'Edit Localitate','Divi' ), 
    'update_item' => __( 'Update Localitate','Divi' ),
    'add_new_item' => __( 'Add New Localitate','Divi' ),
    'new_item_name' => __( 'New Localitate Name','Divi' ),
    'menu_name' => __( 'Localitate' ,'Divi'),
  );    
  
  // Now register the taxonomy
  register_taxonomy('localitate',array('projects'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'localitate' ),
  ));
  
  
  // taxnomy for localitate
    $labels = array(
    'name' => _x( 'Judet', 'taxonomy general name','Divi' ),
    'singular_name' => _x( 'Judet', 'taxonomy singular name' ,'Divi'),
    'search_items' =>  __( 'Search Judet' ,'Divi'),
    'all_items' => __( 'All Judet' ,'Divi'),
    'parent_item' => __( 'Parent Judet','Divi' ),
    'parent_item_colon' => __( 'Parent Judet:','Divi' ),
    'edit_item' => __( 'Edit Judet','Divi' ), 
    'update_item' => __( 'Update Judet','Divi' ),
    'add_new_item' => __( 'Add New Judet' ,'Divi'),
    'new_item_name' => __( 'New Judet Name','Divi' ),
    'menu_name' => __( 'Judet','Divi' ),
  );    
  
  // Now register the taxonomy
  register_taxonomy('judet',array('projects'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'judet' ),
  ));
  
  
  
  
  
}
  
/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/
  
add_action( 'init', 'custom_post_type', 0 );


//load more and filter ajax
add_action('wp_ajax_filter_custom_projects', 'filter_custom_projects_function');
add_action('wp_ajax_nopriv_filter_custom_projects', 'filter_custom_projects_function');
function filter_custom_projects_function(){
    $response = array('status'=>'','html'=>'','Prev_pageNumber'=>'','next_pageNumber'=>'','map_data'=>'');
    $html = '';
    $status = 1;
    
    $pageNumber = !empty($_POST['pageNumber']) ? $_POST['pageNumber'] : 1;
   
    if($_POST['stepaction'] == 'next'){
        $next_page = $pageNumber+1;
        $prev_page = $pageNumber;
        $pageNumber++;
    }else if($_POST['stepaction'] == 'prevs'){
        $next_page = $pageNumber;
        $prev_page = $pageNumber-1;
        
    }
     
    
    $args = array('post_type'=>'projects','posts_per_page'=>5,'post_status'=>'publish','paged'=>$pageNumber);
    
   
   
   $args['meta_query'] = array('relation' => 'AND');
   $args['tax_query'] =  array('relation' => 'AND');
   
    if(!empty($_POST['prioritate'])){
            $args['meta_query'][] = array(
	            'key' =>'prioritate_de_investitie_operatiuni_strategice:_danu',
   	            'value' => $_POST['prioritate'],
                'compare' => 'LIKE',
            );
    }
    
    if(!empty($_POST['beneficiari_eligibili'])){
            $args['meta_query'][] = array(
	            'key' =>'beneficiari_eligibili',
   	            'value' => $_POST['beneficiari_eligibili'],
                'compare' => 'LIKE',
            );
    }
    
    if(!empty($_POST['stadiu_proiect'])){
            $args['meta_query'][] = array(
	            'key' =>'stadiu_proiect',
   	            'value' => $_POST['stadiu_proiect'],
                'compare' => 'LIKE',
            );
    }
    
    if(!empty($_POST['nume_beneficiar'])){
            $args['meta_query'][] = array(
	            'key' =>'nume_beneficiar',
   	            'value' => $_POST['nume_beneficiar'],
                'compare' => 'LIKE',
            );
    }
    
    if(!empty($_POST['obiectiv_specific'])){
            $args['meta_query'][] = array(
	            'key' =>'obiectiv_specific_fedr',
   	            'value' => $_POST['obiectiv_specific'],
                'compare' => 'LIKE',
            );
    }
    
    
    if(!empty($_POST['title_search'])){
            $args['s'] = $_POST['title_search'];
    }
    
    
    //tax query
    if(!empty($_POST['localitate'])){
            $args['tax_query'][] = array(
	            'taxonomy' => 'localitate',
                'field' => 'term_id',
               'terms' => $_POST['localitate'],
            );
    }
    
    if(!empty($_POST['judet'])){
            $args['tax_query'][] = array(
	            'taxonomy' => 'judet',
                'field' => 'term_id',
               'terms' => $_POST['judet'],
            );
    }
    
    // print_r($args);
    
    $project_loop = new WP_Query($args);
    $map_data = '';  		 
      if($project_loop->have_posts()){
      		   
      	while($project_loop->have_posts()): $project_loop->the_post();
      	       $latitude = get_field('latitude',get_the_ID());
      		   $longitude = get_field('longitude',get_the_ID());
      		$html .='<div class="contentPost">
      				<h1><a href="'.get_permalink().'">'.get_the_title(get_the_ID()).'</a></h1>
      				<p>'.wp_trim_words(get_the_content(), 40).'</p>
      			</div>';
      			
      			if(!empty($latitude) && !empty($longitude)){
      		     $map_data .='<div class="marker" data-lat="'.$latitude.'" data-lng="'.$longitude.'"><h3>'.get_the_title(get_the_ID()).'</h3> <p>'.wp_trim_words(get_the_content(), 20).'</p>
      			</div>';
      		
      			}
      			
      		endwhile;
      		wp_reset_query();
      		$status = 1;
       }else{ 
      		 $html ='<p>Data not found.!!</p>';
      		 $status = 0;
      } 
     
     $response['status'] = $status;
     $response['html'] = $html;
     $response['Prev_pageNumber'] = $prev_page;
     $response['next_pageNumber'] = $next_page;
     $response['map_data'] = $map_data;
     
     echo json_encode($response);
     die();

}

add_action('wp_ajax_export_custom_projects', 'export_custom_projects_function');
add_action('wp_ajax_nopriv_export_custom_projects', 'export_custom_projects_function');
function export_custom_projects_function(){
    $response = array('status'=>'','html'=>'');
    $html = '';
    $status = 1;
    
    
$args = array('post_type'=>'projects','posts_per_page'=>-1,'post_status'=>'publish');
    
   
   
   $args['meta_query'] = array('relation' => 'AND');
   $args['tax_query'] =  array('relation' => 'AND');
   
    if(!empty($_POST['prioritate'])){
            $args['meta_query'][] = array(
	            'key' =>'prioritate_de_investitie_operatiuni_strategice:_danu',
   	            'value' => $_POST['prioritate'],
                'compare' => 'LIKE',
            );
    }
    
    if(!empty($_POST['beneficiari_eligibili'])){
            $args['meta_query'][] = array(
	            'key' =>'beneficiari_eligibili',
   	            'value' => $_POST['beneficiari_eligibili'],
                'compare' => 'LIKE',
            );
    }
    
    if(!empty($_POST['stadiu_proiect'])){
            $args['meta_query'][] = array(
	            'key' =>'stadiu_proiect',
   	            'value' => $_POST['stadiu_proiect'],
                'compare' => 'LIKE',
            );
    }
    
    if(!empty($_POST['nume_beneficiar'])){
            $args['meta_query'][] = array(
	            'key' =>'nume_beneficiar',
   	            'value' => $_POST['nume_beneficiar'],
                'compare' => 'LIKE',
            );
    }
    
    if(!empty($_POST['obiectiv_specific'])){
            $args['meta_query'][] = array(
	            'key' =>'obiectiv_specific_fedr',
   	            'value' => $_POST['obiectiv_specific'],
                'compare' => 'LIKE',
            );
    }
    
    
    if(!empty($_POST['title_search'])){
            $args['s'] = $_POST['title_search'];
    }
    
    
    //tax query
    if(!empty($_POST['localitate'])){
            $args['tax_query'][] = array(
	            'taxonomy' => 'localitate',
                'field' => 'term_id',
               'terms' => $_POST['localitate'],
            );
    }
    
    if(!empty($_POST['judet'])){
            $args['tax_query'][] = array(
	            'taxonomy' => 'judet',
                'field' => 'term_id',
               'terms' => $_POST['judet'],
            );
    }
    
    
    
    $project_loop = new WP_Query($args);
    $map_data = '';  		 
      if($project_loop->have_posts()){
          
          $html .= '<table id="project_report" class="table-bordered numformat">
                        <thead>
                            <tr><th colspan="5">Adrne Zupria Projects Search Report Date: ['.date("d/m/Y").']</th></tr>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>cod smis</th>
                                <th>data incepere</th>
                                <th>data finalizare</th>
                                <th>stadiu proiect</th>
                                <th>tip proiect</th>
                                <th>status apel</th>
                                <th>beneficiari eligibili</th>
                                <th>latitude</th>
                                <th>longitude</th>
                                <th>nume beneficiar</th>
                                <th>id beneficiar</th>
                                <th>nume achizitii publice</th>
                                <th>valoare totala proiect</th>
                                <th>valoare contributie UE</th>
                                <th>fond EU</th>
                                <th>Obiectiv Specific FEDR</th>
                                <th>Prioritate de Investitie (operatiuni strategice: da/nu)</th>
                            </tr>
                        </thead>
                        <tbody>';
      		   
      	while($project_loop->have_posts()): $project_loop->the_post();
      	
      	        $cod_smis = get_field('cod_smis',get_the_ID());
      	        $data_incepere = get_field('data_incepere',get_the_ID());
      	        $data_finalizare = get_field('data_finalizare',get_the_ID());
      	        $stadiu_proiect = get_field('stadiu_proiect',get_the_ID());
      	        $tip_proiect = get_field('tip_proiect',get_the_ID());
      	        $status_apel = get_field('status_apel',get_the_ID());
      	        $beneficiari_eligibili = get_field('beneficiari_eligibili',get_the_ID());
      	        $latitude = get_field('latitude',get_the_ID());
      		    $longitude = get_field('longitude',get_the_ID());
      	        $nume_beneficiar = get_field('nume_beneficiar',get_the_ID());
      	        $id_beneficiar = get_field('id_beneficiar',get_the_ID());
      	        $nume_achizitii_publice = get_field('nume_achizitii_publice',get_the_ID());
      	        $valoare_totala_proiect = get_field('valoare_totala_proiect',get_the_ID());
      	        $valoare_contributie_ue = get_field('valoare_contributie_ue',get_the_ID());
      	        $fond_eu = get_field('fond_eu',get_the_ID());
      	        $obiectiv_specific_fedr = get_field('obiectiv_specific_fedr',get_the_ID());
      	        $prioritate_de_investitie_operatiuni_strategice_danu = get_field('prioritate_de_investitie_operatiuni_strategice:_danu',get_the_ID());
      	        
      		  
      		$html .=' <tr>
                        <td>'. get_the_ID() .'</td> 
                        <td>'. get_the_title(get_the_ID()) .'</td> 
                        <td>'. $cod_smis .'</td>
                        <td>'. $data_incepere .'</td>
                        <td>'. $data_finalizare .'</td>
                        <td>'. $stadiu_proiect .'</td>
                        <td>'. $tip_proiect .'</td>
                        <td>'. $status_apel .'</td>
                        <td>'. $beneficiari_eligibili .'</td>
                        <td>'. $latitude .'</td>
                        <td>'. $longitude .'</td>
                        <td>'. $nume_beneficiar .'</td>
                        <td>'. $id_beneficiar .'</td>
                        <td>'. $nume_achizitii_publice .'</td>
                        <td>'. $valoare_totala_proiect .'</td>
                        <td>'. $valoare_contributie_ue .'</td>
                        <td>'. $fond_eu .'</td>
                        <td>'. $obiectiv_specific_fedr .'</td>
                        <td>'. $prioritate_de_investitie_operatiuni_strategice_danu .'</td>
                      </tr>';
      		
      		endwhile;
      		$html .= '</tbody>
                     </table>';
      		wp_reset_query();
      		$status = 1;
       }else{ 
      		 $html ='Data not found.!!';
      		 $status = 0;
      } 
     
     $response['status'] = $status;
     $response['html'] = $html;
     $response['exporttypes'] = $_POST['exporttypes'];
     
     echo json_encode($response);
     die();

}


// add google map api key in acf
function my_acf_google_map_api( $api ){
    $api['key'] = 'AIzaSyAHzN1ZqSiBrBFYjoaP8ONLUACo33jPIbU';
    return $api;
}
add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');
