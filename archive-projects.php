<?php get_header();?>

   <div class="container">
        <div class="loader_main ">
           <span class="loader"></span>
         </div>
       
	      	<div class="filter">
	      	    <div class="export_types">
	      	        <select name="text" id="export_selected">
                        <option value="export"><?php _e('Select Export Type','Divi');?></option>
                         <option value="excel"><?php _e('XLS','Divi');?></option>
                        <option value="csv"><?php _e('CSV','Divi');?></option>
                    </select>
                    <div id="exportbtn">
                        <a href="javascript:void(0);" disabled="disabled" class="export_data"><?php _e('Export','Divi');?></a>
                        <!--<a href="javascript:void(0);"  class="cst_csv cst_hide" onClick="doExport('#search_report', {type: 'csv', numbers: {html: {decimalMark: '.', thousandsSeparator: ','}, output: {decimalMark: ',', thousandsSeparator: ''}}-->
                                <!--});"><?php _e('Export','Divi');?></a>-->
                        <!--<a href="javascript:void(0);"class="cst_excel cst_hide"  onClick="doExport('#search_report', {type: 'excel'});"><?php _e('Export','Divi');?></a>-->
                    </div>
	      	    </div>
	      	    <form id="filter_form">  
	      		<div class="filterList">
	      		    <label><?php _e('Prioritate de Investitie','Divi');?></label>
	      		    <select class="custm_form" name="prioritate" >
	      		        <option value=""><?php _e('Select','Divi');?></option>
	      		        <option value="da"><?php _e('da','Divi');?></option>
	      		        <option value="nu"><?php _e('nu','Divi');?></option>
	      		    </select>
	      		</div>
	      		<div class="filterList">
	      		    <label><?php _e('Beneficiari eligibili','Divi');?></label>
	      		    <select class="custm_form" name="beneficiari_eligibili" >
	      		        <option value=""><?php _e('Select','Divi');?></option>
	      		        <option value="da"><?php _e('da','Divi');?></option>
	      		        <option value="nu"><?php _e('nu','Divi');?></option>
	      		    </select>
	      		</div>
	      		<!--<div class="filterList">-->
	      		<!--    <label><?php _e('Status apel','Divi');?></label>-->
	      		<!--    <select class="custm_form" name="status_apel" >-->
	      		<!--        <option value=""><?php _e('Select','Divi');?></option>-->
	      		<!--        <option value="deschis"><?php _e('Deschis','Divi');?></option>-->
	      		<!--        <option value="anunțat"><?php _e('Anunțat','Divi');?></option>-->
	      		<!--        <option value="închis"><?php _e('închis','Divi');?></option>-->
	      		<!--        <option value="suspendat"><?php _e('Suspendat','Divi');?></option>-->
	      		<!--    </select>-->
	      		<!--</div>-->
	      		<div class="filterList">
	      		    <label><?php _e('Stadiu proiect','Divi');?></label>
	      		    <select class="custm_form" name="stadiu_proiect" >
	      		        <option value=""><?php _e('Select','Divi');?></option>
	      		        <option value="implementare"><?php _e('Implementare','Divi');?></option>
	      		        <option value="finalizat"><?php _e('Finalizat','Divi');?></option>
	      		        <option value="reziliat"><?php _e('Reziliat','Divi');?></option>
	      		        <option value="suspendat"><?php _e('Suspendat','Divi');?></option>
	      		    </select>
	      		</div>
	      		<?php
	      		    $localitates = get_terms(array(
                        'taxonomy' => 'localitate',
                        'hide_empty' => false,
                    ));
                    
                if($localitates){ ?>
                
	      		<div class="filterList">
	      		    <label><?php _e('Localitate','Divi');?></label>
	      		    <select class="custm_form" name="localitate" >
	      		      <option value=""><?php _e('Select','Divi');?></option>
	      		      <?php
	      		      foreach ($localitates as $localitate){
                      echo '<option value="'.$localitate->term_id.'">'.$localitate->name.'</option>';
	      		      } ?>
	      		   </select>
	      		</div>
	      		<?php } ?>
	      		
	      		<?php
	      		    $judets = get_terms(array(
                        'taxonomy' => 'judet',
                        'hide_empty' => false,
                    ));
                    
                if($judets){ ?>
                
	      		<div class="filterList">
	      		    <label><?php _e('Judet','Divi');?></label>
	      		    <select class="custm_form" name="judet" >
	      		      <option value=""><?php _e('Select','Divi');?></option>
	      		      <?php
	      		      foreach ($judets as $judet){
                      echo '<option value="'.$judet->term_id.'">'.$judet->name.'</option>';
	      		      } ?>
	      		   </select>
	      		</div>
	      		<?php } ?>
	      		
	      		<div class="filterList">
	      		    <label><?php _e('Nume beneficiar','Divi');?></label>
	      		    <input type="text" name="nume_beneficiar" class="search_inpt">
	      		</div>
	      	
	      		<div class="filterList">
	      		    <label><?php _e('Obiectiv Specific FEDR','Divi');?></label>
	      		    <input type="text" name="obiectiv_specific" class="search_inpt">
	      		</div>
	      		
	      		<div class="filterList">
	      		    <label><?php _e('Căutați după proiect','Divi');?></label>
	      		    <input type="text" name="title_search" class="search_inpt">
	      		</div>
	      		<div class="filterList filter_btn">
	      		 <button type="button" id="submit_filter"><?php _e('Search','Divi');?></button>
	      		 <button type="button" id="reset_filter"><?php _e('Reset','Divi');?></button>
	      		</div>
	      		<!--<input type="hidden" name="action" value="filter_custom_projects">-->
	      		</form>
	      	  </div>
      	  
      	   <div class="container_one">  
      		<div class="leftContent">
      		 <div class="projects_data">
      		 <?php
      		 $args = array('post_type'=>'projects','posts_per_page'=>5,'post_status'=>'publish');
      		 $project_loop = new WP_Query($args);
      		 $map_data = '';
      		 if($project_loop->have_posts()){
      		   
      		   while($project_loop->have_posts()): $project_loop->the_post(); 
      		   $latitude = get_field('latitude',get_the_ID());
      		   $longitude = get_field('longitude',get_the_ID());?>
      			<div class="contentPost">
      				<h1><a href="<?php the_permalink();?>"><?php the_title();?></a></h1>
      				<p><?php echo wp_trim_words(get_the_content(), 40);?></p>
      			</div>
      			<?php
      			if(!empty($latitude) && !empty($longitude)){
      		     $map_data .='<div class="marker" data-lat="'.$latitude.'" data-lng="'.$longitude.'"><h3>'.get_the_title(get_the_ID()).'</h3> <p>'.wp_trim_words(get_the_content(), 20).'</p>
      			</div>';
      		
      			}
      		endwhile;
      		wp_reset_query();
      		}else{ ?>
      		    <p>Data not found.!!</p>
      	    <?php } ?>
      		
      		</div>
      		<div class="paginaton_btns">	
      		<button class="more_posts" id="prev_projects" type="button" pageNumber="1" step_action="prevs" disabled="disabled"><?php _e('Previous','Divi');?><span class="loader"></span></button>
      		<button class="more_posts" id="next_projects" type="button" pageNumber="1" step_action="next"><?php _e('Next','Divi');?><span class="loader"></span></button>
      		</div>
      		</div>
      		<div class="rightBox">
      			<div class="custom_map">
      			   <div class="acf-map" data-zoom="16">
                  <?php echo $map_data;?>
                 </div>	
      			</div>
      		</div>
      		
   	<!--Export Table-->
      	<div class="export_data_Sec">
      	    
      	</div>	
	</div>
</div>
<style type="text/css">
.acf-map {
    width: 100%;
    height: 400px;
    border: #ccc solid 1px;
    margin: 20px 0;
}

// Fixes potential theme css conflict.
.acf-map img {
   max-width: inherit !important;
}
</style>


<?php get_footer();?>
