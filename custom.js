
jQuery(document).ready(function() {

    function show_projects(pageNumber,stepaction){
        var data = jQuery('#filter_form').serialize();
        
        if(stepaction  == "prevs"){
            jQuery("#next_projects").attr("disabled",false);
            jQuery("#next_projects").html('Urmﾄフorul');
            
        }else if(stepaction  == "next"){
            jQuery("#prev_projects").attr("disabled",false);
            jQuery("#prev_projects").html('Anterior');
        }
        
        
        
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: frontendajax.ajaxurl,
            data: data+'&action=filter_custom_projects&pageNumber='+pageNumber+'&stepaction='+stepaction,
            beforeSend : function(){
                jQuery('.loader_main').addClass('loading');
            },
            success: function(response){
               if(response.status == 1){
                 jQuery('.projects_data').html(response.html);
                 jQuery("#more_posts").attr("disabled",false);
                 jQuery('#prev_projects').attr('pageNumber',response.Prev_pageNumber);
                 jQuery('#next_projects').attr('pageNumber',response.next_pageNumber);
                 jQuery('.acf-map').html(response.map_data);
                 if(response.Prev_pageNumber  === 0){
                  jQuery("#prev_projects").attr("disabled",true);
                  jQuery("#prev_projects").html('Anterior');
                 }
                 
                } else{
                    jQuery("#next_projects").attr("disabled",true);
                    jQuery("#next_projects").html('No more projects found');
                }
               jQuery('.loader_main').removeClass('loading');
            },
            error : function(jqXHR, textStatus, errorThrown) {
                jQuery('.loader_main').removeClass('loading');
                jQuery('.projects_data').append(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
    
        });
        return false;
    }
    
    //load more
    $(".more_posts").on("click",function(){ 
        $("#more_posts").attr("disabled",true);
        var pageNumber = jQuery(this).attr('pageNumber');
        var stepaction = jQuery(this).attr('step_action');
        show_projects(pageNumber,stepaction);
    });
    
    //filter function
    function filter_data(){
        var data = jQuery('#filter_form').serialize();
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: frontendajax.ajaxurl,
            data: data+'&action=filter_custom_projects',
            beforeSend : function(){
                jQuery('.loader_main').addClass('loading');
            },
            success: function(response){
                 if(response.status == 1){
                    jQuery('.projects_data').html(response.html);
                    jQuery('#more_posts').attr('pageNumber',response.pageNumber);
                    jQuery('.paginaton_btns').show();
                    jQuery('.acf-map').html(response.map_data);
                    
                    
                 }else{
                    jQuery('.projects_data').html(response.html); 
                    jQuery('.paginaton_btns').hide();
                 }
                 jQuery('.loader_main').removeClass('loading');
            },
            error : function(jqXHR, textStatus, errorThrown) {
                jQuery('.loader_main').removeClass('loading');
                jQuery('.projects_data').html(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
    
        });
       
        }
        
         function export_data(){
            var data = jQuery('#filter_form').serialize();
            var exporttype = jQuery('#export_selected').val();
            
            if (exporttype == "export") {
              alert('Select Export Type.');
            } else {
              var exporttypes = jQuery('#export_selected').val();
              
                jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: frontendajax.ajaxurl,
                data: data+'&action=export_custom_projects&exporttypes='+exporttypes,
                beforeSend : function(){
                    jQuery('.export_data').text('Exporting...');
                },
                success: function(response){
                     if(response.status == 1){
                       jQuery('.export_data_Sec').html(response.html);
                        if(response.exporttypes == 'csv'){
                           doExport('#project_report', {type: 'csv', numbers: {html: {decimalMark: '.', thousandsSeparator: ','}, output: {decimalMark: ',', thousandsSeparator: ''}}
                           });
                        }else if(response.exporttypes == 'excel'){
                           doExport('#project_report', {type: 'excel'});  
                        } 
                        jQuery('.export_data_Sec').html('');
                     }else{
                        alert(response.html);
                     }
                     jQuery('.export_data').text('Export');
                },
                error : function(jqXHR, textStatus, errorThrown) {
                    jQuery('.loader_main').removeClass('loading');
                    jQuery('.projects_data').html(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                    jQuery('.export_data').text('Export');
                }
                 
            });
                
            }
            
            
            
          
           
            }
    
        function doExport(selector, params) {
            
            jQuery("#project_report").show();
            var options = {
                tableName: 'project_report',
                worksheetName: 'Countries by population'
            };
            jQuery.extend(true, options, params);
            jQuery(selector).tableExport(options);
            jQuery("#project_report").hide();
        }
    
    //Export ajax
    jQuery("#exportbtn").on("click",function(){ 
        export_data();
      });
    
    //filter ajax
    jQuery("#submit_filter").on("click",function(){ 
        filter_data();
      });
      
    //reset filter ajax
    jQuery("#reset_filter").on("click",function(){ 
        document.getElementById("filter_form").reset();
        filter_data();
      });
      
    
    (function( $ ) {
    
    /**
     * initMap
     *
     * Renders a Google Map onto the selected jQuery element
     *
     * @date    22/10/19
     * @since   5.8.6
     *
     * @param   jQuery $el The jQuery element.
     * @return  object The map instance.
     */
    function initMap( $el ) {
    
        // Find marker elements within map.
        var $markers = $el.find('.marker');
    
        // Create gerenic map.
        var mapArgs = {
            zoom        : $el.data('zoom') || 16,
            mapTypeId   : google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map( $el[0], mapArgs );
    
        // Add markers.
        map.markers = [];
        $markers.each(function(){
            initMarker( $(this), map );
        });
    
        // Center map based on markers.
        centerMap( map );
    
        // Return map instance.
        return map;
    }
    
    /**
     * initMarker
     *
     * Creates a marker for the given jQuery element and map.
     *
     * @date    22/10/19
     * @since   5.8.6
     *
     * @param   jQuery $el The jQuery element.
     * @param   object The map instance.
     * @return  object The marker instance.
     */
    function initMarker( $marker, map ) {
    
        // Get position from marker.
        var lat = $marker.data('lat');
        var lng = $marker.data('lng');
        var latLng = {
            lat: parseFloat( lat ),
            lng: parseFloat( lng )
        };
    
        // Create marker instance.
        var marker = new google.maps.Marker({
            position : latLng,
            map: map
        });
    
        // Append to reference for later use.
        map.markers.push( marker );
    
        // If marker contains HTML, add it to an infoWindow.
        if( $marker.html() ){
    
            // Create info window.
            var infowindow = new google.maps.InfoWindow({
                content: $marker.html()
            });
    
            // Show info window when marker is clicked.
            google.maps.event.addListener(marker, 'click', function() {
                infowindow.open( map, marker );
            });
        }
    }
    
    /**
     * centerMap
     *
     * Centers the map showing all markers in view.
     *
     * @date    22/10/19
     * @since   5.8.6
     *
     * @param   object The map instance.
     * @return  void
     */
    function centerMap( map ) {
    
        // Create map boundaries from all map markers.
        var bounds = new google.maps.LatLngBounds();
        map.markers.forEach(function( marker ){
            bounds.extend({
                lat: marker.position.lat(),
                lng: marker.position.lng()
            });
        });
    
        // Case: Single marker.
        if( map.markers.length == 1 ){
            map.setCenter( bounds.getCenter() );
    
        // Case: Multiple markers.
        } else{
            map.fitBounds( bounds );
        }
    }
    
    // Render maps on page load.
    $(document).ready(function(){
        $('.acf-map').each(function(){
            var map = initMap( $(this) );
        });
        
    });
    
    
    
    })(jQuery);
      
      
    });
    
    
    jQuery("select#export_selected").change(function () {
    
            var value = jQuery(this).val();
    
            if (value != "export")
            {
                jQuery(".cst_demo").addClass("cst_hide");
            } else {
    
                jQuery(".cst_demo").removeClass("cst_hide");
                jQuery(".cst_demo").show();
            }
            jQuery(".cst_hide").each(function () {
                jQuery(this).hide();
            });
            jQuery(".cst_" + value).show();
    
    
    });
    
    
    
    
    