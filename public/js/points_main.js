// Global variables;
var total_points = 2000;
var factor = 0.001, infowindow, geocoder, token, bounds, dx, dy, map, xMin = xMax = yMin = yMax = 0, markers = [], sidebar_html = '', minZoom, zoomLevel;


// Calculating position
function calculatePosition(){

	// Calculate the current position of the map (bounds)
    bounds = map.getBounds();
    var centerX = bounds.getCenter().lat();
    var centerY = bounds.getCenter().lng();

    xMin = centerX - dx, xMax = centerX + dx, yMin = centerY - dy, yMax = centerY + dy; 
}


// Fetching Data
function getData(){
	$('#main').addClass('loading');
	removeMarkers();
	markers = [];

	// Get all roads
    $.ajax({
        url: '/points',
        data: {xMin: xMin, xMax: xMax, yMin: yMin, yMax: yMax},
        success: function(data){
            console.log(data.data.length);
            if(data.data.length <= total_points){
                sidebar_html = '<table class="pure-table"><thead><tr><th>Name</th><th>Speed</th></tr></thead><tbody>';
                $.each(data.data, function(){
                    var tmp = {
                        name: this.name,
                        latitude: this.latitude,
                        longitude: this.longitude,
                        road_reference: this.road_reference,
               	 	};
                    var tmp_name = this.name == '' ? this.road_reference : this.name;
                    var location = new google.maps.LatLng(parseFloat(this.latitude), parseFloat(this.longitude));
                    var marker = new RichMarker({
                        position: location,
                        map: map,
                        draggable: true,
                        flat: true,
                        content: '<div class="marker" data-latitude="'+ this.latitude +'" data-longitude="'+ this.longitude +'" data-name="'+ tmp_name +'" data-id="'+ this.id +'" data-speed="'+ this.speed +'"></div>',
                    });
                    marker.id = this.id
                    markers.push(marker);
                    var self_id = this.id;
                    google.maps.event.addListener(marker, 'click', function(){
                        var event_marker = $.grep(markers, function(e){ return e.id == self_id;});
                        addMarkerEvents(self_id, event_marker[0].getPosition().lat(), event_marker[0].getPosition().lng());
                    });
                    google.maps.event.addListener(marker, 'dragend', function(){
                        var event_marker = $.grep(markers, function(e){ return e.id == self_id;});
                        addMarkerDDEvents(self_id, event_marker[0].getPosition().lat(), event_marker[0].getPosition().lng());
                    });
                    sidebar_html += '<tr data-latitude="'+ this.latitude +'" data-longitude="'+ this.longitude +'" data-id="'+ this.id +'"><td class="name">' + tmp_name + '</td><td class="speed"><strong>' + this.speed + '</strong></td></tr>';

                });
                $('#sidebar').html(sidebar_html + '</tbody></table>');
                $('#main').removeClass('loading');
            }else{
                $('#main').removeClass('loading');
                $('#sidebar').html('<table class="pure-table"><thead><tr><th>Name</th><th>Speed</th></tr></thead><tbody></tbody></table>');
                $('.error').html('Too much data for this zoom level, please zoom in to get new data.');
                removeMarkers();
            }

        }, error: function(data){

            alert('Something happened!');

        }
    });
}

// Removing Markers
function removeMarkers(){
	$.each(markers, function(i){
		this.setMap(null);
	}); 
	markers = [];
}

// Initialization of the Google Map
function map_init(geo_lat, geo_lon, default_zoom){
    if(typeof google !== 'undefined' && google){
        map = new google.maps.Map(document.getElementById('map'), {
            center:{
                lat: geo_lat,
                lng: geo_lon
            },
            zoom: default_zoom,
            suppressInfoWindows: true,
            maxZoom: 19,

        });
        geocoder = new google.maps.Geocoder;
        infowindow = new google.maps.InfoWindow;
        // Fetching new data on Zoom
        google.maps.event.addListener(map, 'zoom_changed', function() {
            fetchData();
        });
        google.maps.event.addListener(map, 'dragend', function() { 
        	fetchData();
        });
        /* google.maps.event.addListener(map, 'mousemove', function (event) {
              var pnt = event.latLng;
              var lat = pnt.lat();
              lat = lat.toFixed(6);
              var lng = pnt.lng();
              lng = lng.toFixed(6);
              console.log("Latitude: " + lat + "  Longitude: " + lng);     
          }); */
        google.maps.event.addListener(map, 'click', function(event) {
		    var location = event.latLng;

            var condition = 1; // to check if we are clicking on a marker

            if(condition) setData(location);
		});

    }
}

function setData(position){

	// Get the address
	geocoder.geocode({'location': position}, function(results, status) {
      if (status === 'OK') {
        if (results[0]) {
          	
          	var result = results[0];
          	$('[name="new_latitude"]').val(position.lat());
          	$('[name="new_longitude"]').val(position.lng());
          	$('[name="new_name"]').val(result.address_components[0]['long_name'] !== 'undefined' ? result.address_components[0]['long_name'] : '');
          	$('[name="new_type"]').val(result.address_components[0]['types'] !== 'undefined' ? result.address_components[0]['types'] : '');
            $('[name="new_provincia"]').val(result.address_components[1]['long_name'] !== 'undefined' ? result.address_components[1]['long_name'] : '');
          	$('[name="new_road_reference"]').val(result.address_components[1]['types'] !== 'undefined' ? result.address_components[1]['types'] : '');
          	$('[name="new_sub_type"]').val(result.address_components[2]['long_name'] !== 'undefined' ? result.address_components[2]['long_name'] : '');
          	
            setTimeout(function(){
                if(!$('#modal').is(':visible') && !$('#automatic-update').is(':checked')) $('#create-modal').show();
            }, 50);          	

        } else {
          alert('No results found for this location');
        }
      } else {
        alert('Geocoder failed due to: ' + status);
      }
    });
}	

function fetchData(){

    calculatePosition();
    zoomLevel = map.getZoom();
    if(zoomLevel > minZoom){
        var tmp_factor = (zoomLevel - minZoom) * factor;
        xMin += tmp_factor;
        xMax -= tmp_factor;
        yMin += tmp_factor;
        yMax -= tmp_factor;
    }else{
        var tmp_factor = (zoomLevel - minZoom) * factor;
        xMin += tmp_factor;
        xMax -= tmp_factor;
        yMin += tmp_factor;
        yMax -= tmp_factor;
    }
    getData();
}

function addMarkerDDEvents(id, lat, lon){
    var elm = $('.marker[data-id="'+ id +'"]');
    var tmp_id = elm.data('id');
        $('[name="id"]').val(elm.data('id'));
        $('[name="name"]').val(elm.data('name'));
        $('[name="speed"]').val(elm.data('speed'));
        $('[name="old_geo_lat"]').val(elm.data('latitude'));
        $('[name="old_geo_lon"]').val(elm.data('longitude'));
        var old_geo_lat = $('[name="old_geo_lat"]').val(),
            old_geo_lon = $('[name="old_geo_lon"]').val();

        $('[name="latitude"]').val(lat);
        $('[name="longitude"]').val(lon);

        var remove_marker = $.grep(markers, function(e){ return e.id == tmp_id;});
        infowindow.close(map, remove_marker[0]);

        if(!$('#automatic-update').is(':checked')){
            $('#modal').show();
            if($('#create-modal').is(':visible')) $('#create-modal').hide();
        }else{

            $('#modal').hide();
            $('#create-modal').hide();

            if(parseFloat(old_geo_lat).toFixed(7) !== parseFloat(lat).toFixed(7) && parseFloat(old_geo_lon).toFixed(7) !== parseFloat(lon).toFixed(7)){
                $('#main').addClass('loading');
                var id = $('[name="id"]').val(), 
                    name = $('[name="name"]').val(), 
                    speed = $('[name="speed"]').val(), 
                    geo_lat = $('[name="latitude"]').val(),
                    geo_lon = $('[name="longitude"]').val();
                if(geo_lat == '') geo_lat = $('[name="old_geo_lat"]').val();
                if(geo_lon == '') geo_lon = $('[name="old_geo_lon"]').val();

                var selector = $('[data-id="'+ id +'"]');
                $.ajax({
                    url: '/points/update', 
                    type: 'post',
                    data: {_token: token, id: id, name: name, speed: speed, latitude: geo_lat, longitude: geo_lon},
                    success: function(data){
                        $('#main').removeClass('loading');
                        $('.success').html('Successfully updated point!');

                        // Update the table with the new values
                        $('.name', selector).text(name);
                        $('.speed', selector).text(speed);
                        $(selector).data('latitude', geo_lat);
                        $(selector).data('longitude', geo_lon);

                        // Remove the old marker
                        var remove_marker = $.grep(markers, function(e){ return e.id == id;});
                        var index = -1;
                        $.each(markers, function(i){
                            if(this.id == id) index = i;
                        }); 
                        remove_marker[0].setMap(null);
                        markers.splice(index, 1);

                        // Create new marker
                        var location = new google.maps.LatLng(geo_lat, geo_lon);
                        var marker = new RichMarker({
                            position: location,
                            map: map,
                            draggable: true,
                            flat: true,
                            content: '<div class="marker" data-latitude="'+ geo_lat +'" data-longitude="'+ geo_lon +'" data-name="'+ name +'" data-id="'+ id +'" data-speed="'+ speed +'"></div>',
                        });
                        marker.id = id;
                        markers.push(marker);
                        var self_id = id;
                        google.maps.event.addListener(marker, 'click', function(){
                            var event_marker = $.grep(markers, function(e){ return e.id == self_id;});
                            addMarkerEvents(self_id, event_marker[0].getPosition().lat(), event_marker[0].getPosition().lng());
                        });
                        google.maps.event.addListener(marker, 'dragend', function(){
                            var event_marker = $.grep(markers, function(e){ return e.id == self_id;});
                            addMarkerDDEvents(self_id, event_marker[0].getPosition().lat(), event_marker[0].getPosition().lng());
                        });

                        $('#create-modal').hide();
                        $('#modal').hide();

                        setTimeout(function(){
                            $('#create-modal').hide();
                            $('#modal').hide();
                        }, 100);

                        setTimeout(function(){
                            $('.success').html('');
                        }, 5000);
                    }, error: function(){
                        alert('Something happened!');
                    }
                });
            }
        }   
}

function addMarkerEvents(id, lat, lon){
     var elm = $('.marker[data-id="'+ id +'"]');
     var tmp_id = $('[name="id"]').val(elm.data('id'));
        $('[name="name"]').val(elm.data('name'));
        $('[name="speed"]').val(elm.data('speed'));
        $('[name="old_geo_lat"]').val(elm.data('latitude'));
        $('[name="old_geo_lon"]').val(elm.data('longitude'));

        $('[name="latitude"]').val(lat);
        $('[name="longitude"]').val(lon);

        var remove_marker = $.grep(markers, function(e){ return e.id == tmp_id;});
        infowindow.close(map, remove_marker);
        $('#modal').show();
        if($('#create-modal').is(':visible')) $('#create-modal').hide();
}

/*
function fetchData(){
	zoomLevel = map.getZoom();
    if (zoomLevel < minZoom) {
        $('.error').html('New data will NOT be fetched for higher zoom only because of performance');
    } else {
        calculatePosition();
        if(zoomLevel > 15){
            var factor = ((zoomLevel - 15)/1000);
            xMin += factor;
            xMax -= factor;
            yMin += factor;
            yMax -= factor;
        }
        getData();
        $('.error').html('');
    }
}
*/

// Document ready
$(document).ready(function(){

	$('#modal').draggable();   
	$('#create-modal').draggable();   

	$('#default').click(function(){
        $('#main-form').hide();

        // Reset the Map
        var currCenter = map.getCenter();
        setTimeout(function(){
            google.maps.event.trigger($("#map")[0], 'resize');
            map.setCenter(currCenter);
        }, 50);

        calculatePosition();
        getData();

        // Show the map and the sidebar
        setTimeout(function(){
            $('#sidebar, #map, .automatic-update, #boxes').show();
                // Reset the Map
                var currCenter = map.getCenter();
                setTimeout(function(){
                    google.maps.event.trigger($("#map")[0], 'resize');
                    map.setCenter(currCenter);
                }, 50);
        }, 1200);
        
    });

	// Clicking on sidebar
	$(this).on('click', '#sidebar tbody tr', function(){
		$('#modal').show();
		$('#create-modal').hide();
		var id = $('[name="id"]').val($(this).data('id'));
		$('[name="name"]').val($('.name', this).text());
		$('[name="speed"]').val($('.speed', this).text());
		$('[name="old_geo_lat"]').val($(this).data('latitude'));
		$('[name="old_geo_lon"]').val($(this).data('longitude'));
		$('[name="latitude"]').val('');
		$('[name="longitude"]').val('');
        var current_marker = $.grep(markers, function(e){ return e.id == id;});
        map.setCenter(current_marker[0].getPosition());
	}); 

    $(this).on('mouseenter', '#sidebar tbody tr', function(){
        var id = $(this).data('id');
        $('#map .marker[data-id="'+id+'"]').addClass('hovered');
        var current_marker = $.grep(markers, function(e){ return e.id == id;});
        map.setCenter(current_marker[0].getPosition());
    }); 
    $(this).on('mouseleave', '#sidebar tbody tr', function(){
        var id = $(this).data('id');
        $('#map .marker[data-id="'+id+'"]').removeClass('hovered');
        var current_marker = $.grep(markers, function(e){ return e.id == id;});
        map.setCenter(current_marker[0].getPosition());
    }); 

	/* // Clicking on marker
	$(this).on('click', '.marker', function(e){
		var id = $('[name="id"]').val($(this).data('id'));
		$('[name="name"]').val($(this).data('name'));
		$('[name="speed"]').val($(this).data('speed'));
		$('[name="old_geo_lat"]').val($(this).data('latitude'));
		$('[name="old_geo_lon"]').val($(this).data('longitude'));
		$('[name="latitude"]').val('');
		$('[name="longitude"]').val('');

        var remove_marker = $.grep(markers, function(e){ return e.id == id;});
        infowindow.close(map, remove_marker);

        $('#modal').show();
        if($('#create-modal').is(':visible')) $('#create-modal').hide();
	});  */


    $('#search').click(function(){

        // Show the map and the sidebar
        var geo_lat = $('.autocomplete-start').val(),
        	geo_lon = $('.autocomplete-end').val();

        if(geo_lat == '' || geo_lon == ''){
            
            $('.autocomplete-start').css('border-color', '#e74c3c');
            $('.autocomplete-end').css('border-color', '#e74c3c');

        }else{         
    	
            $('#main-form').hide();
            $('.autocomplete-start').css('border-color', '#ddd');
            $('.autocomplete-end').css('border-color', '#ddd');

        	map.setCenter({lat:parseFloat(geo_lat), lng:parseFloat(geo_lon)});
            calculatePosition();
            getData();

        	setTimeout(function(){
            	$('#sidebar, #map, .automatic-update, #boxes').show();

            	// Reset the Map
    	        var currCenter = map.getCenter();
    	        setTimeout(function(){
    	            google.maps.event.trigger($("#map")[0], 'resize');
    	            map.setCenter(currCenter);
    	        }, 50);
        	}, 200);

        }

    });

    $('#update-point').click(function(){

    	// Check if actually something was updated
    	var elem = $('[name="id"]').val();
    	if(!elem) {
    		$('.error').html('You havent selected any points.');
    		return false;
    	}
    	if(confirm('Are you sure that you want to update this point?')){
    		$('#modal').addClass('loading');
    		var id = $('[name="id"]').val(), 
    			name = $('[name="name"]').val(), 
    			speed = $('[name="speed"]').val(), 
    			geo_lat = $('[name="latitude"]').val(),
    			geo_lon = $('[name="longitude"]').val();
			if(geo_lat == '') geo_lat = $('[name="old_geo_lat"]').val();
			if(geo_lon == '') geo_lon = $('[name="old_geo_lon"]').val();

			var selector = $('[data-id="'+ id +'"]');
			$.ajax({
				url: '/points/update', 
				type: 'post',
				data: {_token: token, id: id, name: name, speed: speed, latitude: geo_lat, longitude: geo_lon},
				success: function(data){
					$('#modal').removeClass('loading');
					$('.success').html('Successfully updated point!');

					// Update the table with the new values
					$('.name', selector).text(name);
					$('.speed', selector).text(speed);
					$(selector).data('latitude', geo_lat);
					$(selector).data('longitude', geo_lon);

					// Remove the old marker
					var remove_marker = $.grep(markers, function(e){ return e.id == id;});
					var index = -1;
                    $.each(markers, function(i){
                        if(this.id == id) index = i;
                    }); 
                    remove_marker[0].setMap(null);
                    markers.splice(index, 1);

					// Create new marker
					var location = new google.maps.LatLng(geo_lat, geo_lon);
					var marker = new RichMarker({
	                    position: location,
	                    map: map,
	                    draggable: true,
	                    flat: true,
	                    content: '<div class="marker" data-latitude="'+ geo_lat +'" data-longitude="'+ geo_lon +'" data-name="'+ name +'" data-id="'+ id +'" data-speed="'+ speed +'"></div>',
	                });
	                marker.id = id;
                	markers.push(marker);
                    var self_id = id;
                    google.maps.event.addListener(marker, 'click', function(){
                        var event_marker = $.grep(markers, function(e){ return e.id == self_id;});
                        addMarkerEvents(self_id, event_marker[0].getPosition().lat(), event_marker[0].getPosition().lng());
                    });
                    google.maps.event.addListener(marker, 'dragend', function(){
                        var event_marker = $.grep(markers, function(e){ return e.id == self_id;});
                        addMarkerDDEvents(self_id, event_marker[0].getPosition().lat(), event_marker[0].getPosition().lng());
                    });

					setTimeout(function(){
						$('.success').html('');
					}, 5000);
				}, error: function(){
					alert('Something happened!');
				}
			});
    	}else{
    		$('#modal').removeClass('loading');
    	}
    });

    $('#create-point').click(function(){
    	$('[name="new_speed"]').css('border-color', '#ccc');
    	if($('[name="new_speed"]').val() == ''){
    		$('[name="new_speed"]').css('border-color', '#e74c3c');
    	} else {
    		var name = $('[name="new_name"]').val(), 
    			speed = $('[name="new_speed"]').val(), 
    			geo_lat = $('[name="new_latitude"]').val(),
    			geo_lon = $('[name="new_longitude"]').val();
    		$.ajax({
				url: '/points/save', 
				type: 'post',
				data: {_token: token, speed: speed, latitude: geo_lat, 
					longitude: geo_lon, name: name, type: $('[name="new_type"]').val(), 
					provincia: $('[name="new_provincia"]').val(), road_reference: $('[name="new_road_reference"]').val(), 
					sub_type: $('[name="new_sub_type"]').val(), 
				}, beforeSend: function(){
					$('#create-modal').addClass('loading');
				},
				success: function(data){
					var new_sidebar_html = '<tr data-latitude="'+ geo_lat +'" data-longitude="'+ geo_lon +'" data-id="'+ data.data.id +'"><td class="name">' + name + '</td><td class="speed"><strong>' + speed + '</strong></td></tr>';
					$('#sidebar tbody').prepend(new_sidebar_html);
					$('#create-modal').removeClass('loading');
					$('.success').html('Successfully created point!');

					// Create new marker
					var location = new google.maps.LatLng(geo_lat, geo_lon);
					var marker = new RichMarker({
	                    position: location,
	                    map: map,
	                    draggable: true,
	                    flat: true,
	                    content: '<div class="marker" data-latitude="'+ geo_lat +'" data-longitude="'+ geo_lon +'" data-name="'+ name +'" data-id="'+ data.data.id +'" data-speed="'+ speed +'"></div>',
	                });
	                marker.id = data.data.id
                	markers.push(marker);
                    var self_id = this.id;
                    google.maps.event.addListener(marker, 'click', function(){
                        var event_marker = $.grep(markers, function(e){ return e.id == self_id;});
                        addMarkerEvents(self_id, event_marker[0].getPosition().lat(), event_marker[0].getPosition().lng());
                    });
                    google.maps.event.addListener(marker, 'dragend', function(){
                        var event_marker = $.grep(markers, function(e){ return e.id == self_id;});
                        addMarkerDDEvents(self_id, event_marker[0].getPosition().lat(), event_marker[0].getPosition().lng());
                    });

					$('#create-modal').hide();
					setTimeout(function(){
						$('.success').html('');
					}, 5000);
				}, error: function(){
					alert('Something happened!');
				}
			});
    	}
    });

    $('#delete-point').click(function(){
    	var id = $('[name="id"]').val();
    	$('#modal').addClass('loading');
    	var selector = $('[data-id="'+ id +'"]');
    	if(confirm('Are you sure that you want to delete this point?')){
	    	$.ajax({
				url: '/points/delete', 
				type: 'post',
				data: {_token: token, id: id},
				success: function(data){
					$('#modal').removeClass('loading');
					$('.success').html('Successfully deleted point!');

					// Removing the item in the sidebar
					selector.remove();

					// Remove the old marker
					var remove_marker = $.grep(markers, function(e){ return e.id == id;});
					var index = markers.map(function(x){ return x.id; }).indexOf(id);
					remove_marker[0].setMap(null);
					markers.splice(index,1);


					$('#modal').hide();
					setTimeout(function(){
						$('.success').html('');
					}, 5000);
				}, error: function(){
					alert('Something happened!');
				}
			});
    	}else{
    		$('#modal').removeClass('loading');
    	}
    });

    $('.close').click(function(){
    	$('#modal, #create-modal').hide();
    });

});
