/**
 * Contempo Mapping
 *
 * @package WP Pro Real Estate 7
 * @subpackage JavaScript
 */

/*****************************************************
*
* Start Airbnb style map scrolling
*
******************************************************/

var marker_list = [];
var mapPin      = '';
var map         = null;
var poly        = null;

var storedLongitude = "";
var storedLatitude = "";

var open_info_window = null;

var mapCenterLat = "";
var mapCenterLng = "";

var mapNorthEast = "";
var mapNorthWest = "";
var mapSouthEast = "";
var mapSouthWest = "";

var boundsChanged = false;

var hitCount = 0;

var watchDog = 0;

var x_info_offset = -0; // x,y offset in px when map pans to marker -- to accomodate infoBubble
var y_info_offset = -180;
var debounceTime = 250;
var drawingMode  = false;
var drawListener;
var markerCluster;
var drawMarkers;
var drawBounds;
var oldZoom;
var oldBounds;

jQuery(document).on("click", ".cancelDrawButton", function (e) {
	cancelDrawing();
	disableDrawMode();
	google.maps.event.removeListener( drawListener );
	jQuery('.draw-mode').find('span').html( 'Draw' );
});

jQuery(document).on("click", ".pagination a", function (e) {

	var value = jQuery(this).attr("href");
	if ( value.indexOf( "?" ) < 0 ) {
		return;
	}

	value = value.substring( value.indexOf( "?" ) + 1 );

	if ( getUrlParameter( "action", value) == "map_listing_update" ) {
		jQuery( "#number-listings-progress" ).css( "display", "block" );
		e.preventDefault();

		ne = getUrlParameter( "ne", value );
		ne = jQuery( "<div />" ).html( ne ).text(); // unescape it
		ne = ne.replace( "+", " " );

		sw = getUrlParameter( "sw", value) ;
		sw = jQuery("<div />").html( sw ).text(); // unescape it
		sw = sw.replace( "+", " " );

		paged = getUrlParameter( "paged", value );

		doAjax( ne, sw, paged );

	    jQuery("html, body").animate({ scrollTop: 0 }, "slow");
	}

});

function getUrlParameterObject( sPageURL="" ) 
{
	if( sPageURL == "" ) {
		sPageURL = window.location.search.substring(1);
	}

	var sURLVariables = sPageURL.split('&'), sParameterName, i;

	returnObject = {};

	for (i = 0; i < sURLVariables.length; i++) {
		sParameterName = sURLVariables[i].split('=');

		key = sParameterName[0];
		value = sParameterName[1] === undefined ? "" : decodeURIComponent(sParameterName[1]);

		if ( value != "" ) {
			
			returnObject = Object.assign({[key]: value}, returnObject)

		}

	}
	
	return returnObject;
}

function getUrlParameter( sParam, sPageURL ) 
{
	if( sPageURL == "" ) {
		sPageURL = window.location.search.substring(1);
	}

    var sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? false : decodeURIComponent(sParameterName[1]);
        }
	}
	
	return false;
}

function getUsersLocation() 
{
	// This function only works over https and only if user consents.
	if ( navigator.geolocation ) {
		
	 	navigator.geolocation.getCurrentPosition(
			// Success function
			getCoords 
		);
	}
}
  
function getCoords( position ) 
{
	jQuery( "#search-by-user-location-2" ).show();
	//jQuery( "#advanced_search.header-search #submit" ).width(jQuery("#advanced_search.header-search #submit" ).width( ) - 35);

	storedLongitude = position.coords.longitude;
	storedLatitude = position.coords.latitude;
}

jQuery( "#search-by-user-location a").click( function() {
	jQuery( "#search-latitude" ).val( storedLatitude );
	jQuery( "#search-longitude" ).val( storedLongitude );	
	jQuery( "#submit" ).trigger( "click" );
});

jQuery( "#search-by-user-location-2").click( function() {
	jQuery( "#search-latitude" ).val( storedLatitude );
	jQuery( "#search-longitude" ).val( storedLongitude );	
	jQuery( "#submit" ).trigger( "click" );
});

jQuery(document).on("click", ".sale-lease-links a", function (e) {
		
	if ( storedLatitude == "" || storedLongitude == "" ) {
		return;
	}

	e.preventDefault();

	IsplaceChange = true;
	window.location.href = this.href + "&lat=" + storedLatitude + "&lng=" + storedLongitude;
	
});

function debounce(fn, time) 
{
	let theTimeout;
	return function() 
	{
		const args = arguments;
		const functionCall = () => fn.apply(this, args);
		clearTimeout(theTimeout);
		theTimeout = setTimeout(functionCall, time);
	}
}

/***
 * returns -1 if not exists or the index if it does exist
 */
function markerExistsByLatLng( lat, lng, currentIndex=-1 ) 
{

	l = new google.maps.LatLng( lat, lng );
	
	for( y = 0; y < marker_list.length; y++ ) {
		test = marker_list[y];
		
		if ( l.equals( test.getPosition() ) ) {
			return y;
		} 
	}

	return -1;

}

/***
 * returns -1 if not exists or the index if it does exist
 */
function markerExistsByMarker( marker, currentIndex=-1 ) 
{

	if ( currentIndex == -1 ) {
		currentIndex = 0;
	} else {
		currentIndex++;
	}

	for( x = currentIndex; x < marker_list.length; x++ ) {
		test = marker_list[x];
		if ( marker.getPosition().equals(
				test.getPosition()
			) ) {
			return x;
		}
	}

	return -1;
}

function removeDuplicateMarkers()
{
	indexesToRemove = new Array();
	markerLength = marker_list.length;
	
	for( gf = 0; gf < markerLength; gf++ ) {
		m = marker_list[gf];

		if ( markerExistsByMarker( m, gf ) > -1 ) { 
			m.setMap(null);
			indexesToRemove.push(gf);
		}
	}

	for( gf = 0; gf < indexesToRemove.length; gf++ ) {
		marker_list.splice( indexesToRemove[gf], 1 );
	}

}


function doAjax(ne, sw, paged=1 )
{
	var data = {};
	data = getUrlParameterObject(  ) ;

	data = Object.assign({action: 'map_listing_update'}, data);
	data = Object.assign({ne: ne.toString()}, data);
	data = Object.assign({sw: sw.toString()}, data);
    data = Object.assign({paged: paged}, data);

    // IF the drawing mode is enabled
  	if ( drawMarkers != null && drawMarkers.length > 0 ) {
        data = Object.assign({drawMode: true}, data);
		data = Object.assign({drawMarkers: JSON.stringify(drawMarkers)}, data);
		//drawBounds = new google.maps.LatLngBounds();
    }

	url = mapping_ajax_object.ajax_url;

	//console.log("url: ");
	//console.log(url);
	jQuery.post( url, data, function( response ) {
		
		if( response != "" ) {
		

			
			//dataArray = JSON.parse( response );
			dataArray = response;
			//console.log("args: ");
			//console.log(dataArray.args);
			//console.log("wp_query: ");
			//console.log(dataArray.wp_query);
			//console.log("paged: " + dataArray.paged);
			//console.log("coords: " + dataArray.coords);
			//console.log("post__in: " + dataArray.post__in);
			

			document.getElementById("search-listing-mapper").innerHTML = dataArray.listings;
			document.getElementById("number-listings-found").innerHTML = dataArray.count;
			

			siteURL = dataArray.siteURL;

			if ( dataArray.map != "" ) {

				latlngs = dataArray.latlngs;
				var imagesURL;

				while( marker_list.length ) { 
					marker_list.pop().setMap(null); 
				}
				marker_list = [];
				// Clear all clusters. 
				markerCluster.clearMarkers();

				for( x = 0; x < latlngs.length; x++ ) {
				
					if( markerExistsByLatLng( latlngs[x].lat, latlngs[x].lng ) == -1 ) {
				
						imagesURL = latlngs[x].property.siteURL;

						var mapPin = getMapPin( latlngs[x].property );

						var marker = new google.maps.Marker({
						//	map: map,  
							draggable: false,
							flat: true,
							fullScreenControl: true,
							fullscreenControlOptions: {
								position: google.maps.ControlPosition.BOTTOM_LEFT
							},
							icon: mapPin,   
							position: {lat: parseFloat( latlngs[x].lat ), lng: parseFloat( latlngs[x].lng )},
							listingID: latlngs[x].property.listingID
						});
			
						marker_list.push( marker );

						currentMarker = marker_list.length - 1;


						var imagesURL = latlngs[x].property.siteURL;
						
						var contentString = getInfoBoxContentString( latlngs[x].property );

						marker_list[currentMarker].infobox = new InfoBox({
							content: contentString,
							disableAutoPan: true,
							maxWidth: 0,
							alignBottom: true,
							pixelOffset: new google.maps.Size( -125, -64 ),
							zIndex: null,
							closeBoxMargin: "8px 0 -20px -20px",
							closeBoxURL: imagesURL+'/images/infobox-close.png',
							infoBoxClearance: new google.maps.Size(1, 1),
							isHidden: false,
							pane: "floatPane",
							enableEventPropagation: false
						});
						//latlng = new google.maps.LatLng( latlngs[x].lat , latlngs[x].lng  );
						//drawBounds.extend(latlng);
						

						google.maps.event.addListener(marker, 'click', (function(marker, currentMarker) {
							
							return function() {
								marker_list[currentMarker].infobox.open(map, this);
								map.panTo( convert_offset( marker_list[currentMarker].position, x_info_offset, y_info_offset ) );
								//map.setCenter(marker_list[currentMarker].position);

								if(open_info_window) {
									open_info_window.close();
								}

								open_info_window = marker_list[currentMarker].infobox;
																	
							}
					
						})(marker, currentMarker));
												

					} 
				}

				
				removeDuplicateMarkers();

				var markerClustererOptions = {
					ignoreHidden: true,
					maxZoom: 14,
					styles: [{
						textColor: '#ffffff',
						url: siteURL+'/images/cluster-icon.png',
						height: 48,
						width: 48
					}]
				};

				markerCluster = new MarkerClusterer(map, marker_list, markerClustererOptions);

			}

			if ( drawMarkers != null && drawMarkers.length > 0 ) {
				disableDrawMode();

				if ( drawBounds != null ) {
				
					map.fitBounds(drawBounds);
				}
			} 

		}

		document.getElementById("number-listings-progress").style.display = "none";
		manageFeaturedTags();

	}, "json");
}

function getMapBounds( map ) 
{
	//console.log("in getMapBounds");
    if ( poly == null ) {
        progressDiv = document.getElementById("number-listings-progress");

        if ( ! progressDiv ) {
            // not on the map page
            return;
        }

        var bounds =  map.getBounds();
        var ne = bounds.getNorthEast();
        var sw = bounds.getSouthWest();

        // already in an event..
        if ( boundsChanged == true ) {
            return;
        }
            
        progressDiv.style.display = "inherit";
        
        if ( mapNorthEast != ne ) {
            boundsChanged = true;
        }

        
        if ( mapSouthWest != sw ) {
            boundsChanged = true;
        }
        
        if ( boundsChanged == true ) {

            //console.log("doing it... hitCount: " + hitCount);

            if(open_info_window) {
                open_info_window.close();
            }

            if ( hitCount == 0 ) {
                hitCount++;
                // we ignore the initial event on page load
                setTimeout( function(){ boundsChanged = false; }, 250);
                
                document.getElementById("number-listings-progress").style.display = "none";
        
                return;
            } 


                doAjax(ne, sw);

                setTimeout( function(){ boundsChanged = false; }, 250);
            
                jQuery(".pagination").hide();


        }
    }
}

function getInfoBoxContentString( property )
{
		
	//console.log("property Image: " + property.thumb);

	if(property['contactpage'] == 'contactpage') {

		if(property['thumb'] != '') {

			return '<div class="infobox">'+
			'<div class="info-image"'+
				'<figure>'+
					'<img src="'+property.thumb+'" height="250" width="250" />'+
				'</figure>'+
			'</div>'+
			'<div class="listing-details">'+
				'<header>'+
					'<h4 class="marT0">'+property.street+'</h4>'+
				'</header>'+
				'<p class="price marB0"><strong><a href="//maps.google.com/maps?daddr='+property.street+'" target="_blank">Driving Directions</a></strong></p>'+
			'</div>';

		} else {

			return '<div class="infobox">'+
			'<div class="listing-details">'+
				'<header>'+
					'<h4 class="marT0">'+property.title+'</h4>'+
				'</header>'+
				'<p class="price marB0"><strong><a href="//maps.google.com/maps?daddr='+property.street+'" target="_blank">Driving Directions</a></strong></p>'+
			'</div>';

		}

	} else {

		if(property['commercial'] == 'commercial') {

			return '<div class="infobox">'+
			'<div class="info-image"'+
				'<figure>'+
					'<a href="'+property.permalink+'">'+
						property.thumb+
					'</a>'+
				'</figure>'+
			'</div>'+
			'<div class="listing-details">'+
				'<header>'+
					'<h4 class="marT5 marB5"><a href="'+property.permalink+'">'+property.title+'</a></h4>'+
					'<p class="location muted marB10">'+property.city+', '+property.state+'&nbsp;'+property.zip+'</p>'+
					'<p class="listing-icons muted marB0"><i class="fa fa-ruler-combined"></i><span>'+property.size+'</span>'+
					'<p class="price marB0"><strong>'+property.fullPrice+'</strong></p>'+
				'</header>'+
			'</div>';

		} else if(property['land'] == 'land') {
			
			return '<div class="infobox">'+
			'<div class="info-image"'+
				'<figure>'+
					'<a href="'+property.permalink+'">'+
						property.thumb+
					'</a>'+
				'</figure>'+
			'</div>'+
			'<div class="listing-details">'+
				'<header>'+
					'<h4 class="marT5 marB5"><a href="'+property.permalink+'">'+property.title+'</a></h4>'+
					'<p class="location muted marB10">'+property.city+', '+property.state+'&nbsp;'+property.zip+'</p>'+
					'<p class="price marB0"><strong>'+property.fullPrice+'</strong></p>'+
				'</header>'+
			'</div>';

		} else {

			return '<div class="infobox">'+
			'<div class="info-image"'+
				'<figure>'+
					'<a href="'+property.permalink+'">'+
						property.thumb+
					'</a>'+
				'</figure>'+
			'</div>'+
			'<div class="listing-details">'+
				'<header>'+
					'<h4 class="marT5 marB5"><a href="'+property.permalink+'">'+property.title+'</a></h4>'+
					'<p class="location muted marB10">'+property.city+', '+property.state+'&nbsp;'+property.zip+'</p>'+
					'<p class="listing-icons muted marB0"><i class="fa fa-ruler-combined"></i><span>'+property.size+'</span>'+
						'<i class="fa fa-bed"></i> <span>'+property.bed+'</span> <i class="fa fa-bath"></i><span>'+property.bath+'</span></p>'+
					'<p class="price marB0"><strong>'+property.fullPrice+'</strong></p>'+
				'</header>'+
			'</div>';

		}

	}

}

function init_canvas_projection(map) {
	function CanvasProjectionOverlay() {}
	CanvasProjectionOverlay.prototype = new google.maps.OverlayView();
	CanvasProjectionOverlay.prototype.constructor = CanvasProjectionOverlay;
	CanvasProjectionOverlay.prototype.onAdd = function(){};
	CanvasProjectionOverlay.prototype.draw = function(){};
	CanvasProjectionOverlay.prototype.onRemove = function(){};
	
	canvasProjectionOverlay = new CanvasProjectionOverlay();
	canvasProjectionOverlay.setMap(map);
}

function convert_offset(latlng, x_offset, y_offset) {
	var proj = canvasProjectionOverlay.getProjection();
	var point = proj.fromLatLngToContainerPixel(latlng);
	point.x = point.x + x_offset;
	point.y = point.y + y_offset;
	return proj.fromContainerPixelToLatLng(point);
}

function getMapPin( property )
{

	if(property['commercial'] == 'commercial') {
		return {
			url: property["siteURL"]+'/images/map-pin-com.png',
			size: new google.maps.Size(40, 46),
		    scaledSize: new google.maps.Size(40, 46)
		};
	} else if(property['land'] == 'land' || property['land'] == 'lot') {
		return { 
			url: property["siteURL"]+'/images/map-pin-land.png',
			size: new google.maps.Size(40, 46),
		    scaledSize: new google.maps.Size(40, 46)
		};
	} 

	return {
		url: property["siteURL"]+'/images/map-pin-res.png',
		size: new google.maps.Size(40, 46),
	    scaledSize: new google.maps.Size(40, 46)
	}
	
	
}
/*****************************************************
*
* Cancel Drawing  FreeHand Area in the Map
*
******************************************************/
function cancelDrawing(){

	jQuery( '#map-wrap .drawInstructionBar' ).remove();
	jQuery( '#ct-map-navigation, #compare-panel' ).show();
	jQuery( '#map .gm-style > div > div > div > div > img' ).show();
	jQuery( '#map > div > div > div:nth-child(1) > div:nth-child(1) > div:nth-child(4)' ).show();
	jQuery( '#map > div > div > div:nth-child(1) > div:nth-child(3)' ).css('opacity','1');
	drawBounds = null;

}

/*****************************************************
*
* Draw FreeHand Area in the Map
*
******************************************************/
function drawFreeHand(){

    poly = new google.maps.Polyline( { map:map,clickable:false } );
    var move = google.maps.event.addListener( map,'mousemove',function(e){
        poly.getPath().push( e.latLng );
    });

    // Mouse Up Listener
	var map_mouse_up_listener = google.maps.event.addListenerOnce(map,'mouseup',function(e){
		
		google.maps.event.removeListener( move );
		google.maps.event.removeListener( map_mouse_up_listener );
        var path = poly.getPath();
        poly.setMap(null);
        poly = new google.maps.Polygon({
			map:map,
			path:path, 
			strokeOpacity: 0.3, 
			fillOpacity: 0.3,
			strokeColor: '#8e9092',
			strokeWeight: 1,
		});

		google.maps.event.clearListeners( map.getDiv(), 'mousedown' );
		getMarkersInsideDraw(e, poly);

		if ( drawMarkers.length > 0 ) {
			oldZoom   = map.getZoom();
			oldBounds = map.getBounds();
			jQuery( "#number-listings-progress" ).css( "display", "block" );
			jQuery( '#map > div > div > div:nth-child(1) > div:nth-child(3)' ).css('opacity','0');
			doAjax('','', 1 );
			jQuery( '#map-wrap .drawInstructionBar' ).remove();
			jQuery( '#ct-map-navigation, #compare-panel' ).show();
		} else {
			cancelDrawing();
			disableDrawMode();
		}
		
	});
}



/*****************************************************
*
* Enable Draw Mode
*
******************************************************/

function disableDrawMode(){

	map.setOptions({
		draggable: true,
		draggableCursor : 'grab',
		zoomControl: true,
		scrollwheel: true,
		disableDoubleClickZoom: true
	});

	jQuery( '#map .gm-style > div > div > div > div > img' ).show();
	jQuery( '#map > div > div > div:nth-child(1) > div:nth-child(1) > div:nth-child(4)' ).show();
	jQuery( '#map > div > div > div:nth-child(1) > div:nth-child(3)' ).css('opacity','1');

	drawingMode = false;
}

/*****************************************************
*
* Disable Draw Mode
*
******************************************************/

function enableDrawMode(){

	jQuery( '#map .gm-style > div > div > div > div > img' ).hide();
	jQuery( '#map > div > div > div:nth-child(1) > div:nth-child(1) > div:nth-child(4)' ).hide();
	jQuery( '#map > div > div > div:nth-child(1) > div:nth-child(3)' ).css('opacity','0');

	drawingMode = true;

	map.setOptions({
		draggable: false,
		//draggableCursor : "url(http://s3.amazonaws.com/besport.com_images/status-pin.png), auto",
		draggableCursor:'crosshair',
		zoomControl: false,
		scrollwheel: false,
		disableDoubleClickZoom: false,
		clickableIcons: false,
	});
}

/*****************************************************
*
* Get list of Markers inside the Draw Area
*
******************************************************/
function getMarkersInsideDraw(e, polygon ) {
	drawMarkers = [];
	drawBounds = new google.maps.LatLngBounds();

	for ( var i=0; i < marker_list.length; i++ ) {
		if ( google.maps.geometry.poly.containsLocation(marker_list[i].position, polygon ) ) {
			if( marker_list[i].listingID != undefined ) {
				drawMarkers.push( Number(marker_list[i].listingID));
				drawBounds.extend(marker_list[i].position);
			}
		}
	}

}

/*****************************************************
*
* End Airbnb style map scrolling
*
******************************************************/

var estateMapping = (function () {
	var self = {},
	    current_marker = 0,
	    x_center_offset = 0, // x,y offset in px when map gets built with marker bounds
	    y_center_offset = 0;

	
	function build_marker(latlng, property, skipBounds=false) {

	   var mapPin = getMapPin( property );

		var marker = new google.maps.Marker({
			map: self.map, 
			animation: google.maps.Animation.DROP,
			draggable: false,
			flat: true,
			fullScreenControl: true,
			fullscreenControlOptions: {
				position: google.maps.ControlPosition.BOTTOM_LEFT
			},
			icon: mapPin,
            position: latlng,
            listingID: property.listingID
		});

		marker_list.push( marker );
		
		if ( skipBounds == false ) {
			self.bounds.extend(latlng);		
			self.map.fitBounds(self.bounds);
		} 

		// REMOVE is the below call needed?
		//self.map.setCenter(convert_offset(self.bounds.getCenter(), x_center_offset, y_center_offset));
		
		var residentialString = '';
		if(property['commercial'] != 'commercial') {
			var residentialString=''+property.bed+' | '+property.bath+' | ';
		}

		var contentString = getInfoBoxContentString( property );

		var imagesURL = property.siteURL;

		var infobox = new InfoBox({
			content: contentString,
			disableAutoPan: true,
			maxWidth: 0,
			alignBottom: true,
			pixelOffset: new google.maps.Size( -125, -64 ),
			zIndex: null,
			closeBoxMargin: "8px 0 -20px -20px",
			closeBoxURL: imagesURL+'/images/infobox-close.png',
			infoBoxClearance: new google.maps.Size(1, 1),
			isHidden: false,
			pane: "floatPane",
            enableEventPropagation: false
		});

	
		google.maps.event.addListener(marker, 'click', function() {
			
			if(open_info_window) open_info_window.close();
			
				infobox.open(self.map, marker);
				self.map.panTo(convert_offset(this.position, x_info_offset, y_info_offset));
				open_info_window = infobox;
	
		});
		
	}

	// Next/Previous Marker Navigation

	var ct_map_next = function() {
        current_marker++;
        if (current_marker > marker_list.length){
            current_marker = 1;
        }
        while(marker_list[current_marker-1].visible === false) {
            current_marker++;
            if(current_marker > marker_list.length) {
                current_marker = 1;
            }
        }
        google.maps.event.trigger(marker_list[current_marker-1], 'click');
    }

    var ct_map_prev = function() {
        current_marker--;
        if (current_marker < 1) {
            current_marker = marker_list.length;
        }
        while(marker_list[current_marker-1].visible === false) {
            current_marker--;
            if(current_marker > marker_list.length) {
                current_marker = 1;
            }
        }
        google.maps.event.trigger(marker_list[current_marker-1], 'click');
    }

	window.onload = function() {
		var ctGmapNext  = document.getElementById('ct-gmap-next');
		var ctGmapPrev  = document.getElementById('ct-gmap-prev');
		var ctGmapDraw  = document.getElementById('ct-gmap-draw');

		if(ctGmapDraw != null) {
			document.getElementById('ct-gmap-draw').addEventListener('click',function () {

				if ( poly != null ) {
					poly.setMap(null);
					poly = null;
					self.map.fitBounds(oldBounds);
					self.map.setZoom(oldZoom);
					google.maps.event.trigger(self.map, 'zoom_changed' );
					//getMapBounds(map);
					cancelDrawing();
					disableDrawMode();
					jQuery('.draw-mode').find('span').html( 'Draw' );
					jQuery('.draw-mode').removeClass( 'draw-mode' );
					drawMarkers = [];

					return false;

				} else {

					jQuery( '#ct-map-navigation, #compare-panel' ).hide();
					jQuery( '#map-wrap' ).append( '<div class="drawInstructionBar"><div class="instructions">Click and drag to draw your search.<a href="#" class="btn btn-sm cancelDrawButton" data-rf-test-id="cancelDrawButton">Cancel</a></div></div>' );
                    jQuery(this).addClass( 'draw-mode' );
					jQuery(this).find('span').html( 'Clear Draw' );
                    enableDrawMode();
				}

				drawListener = google.maps.event.addDomListener(map.getDiv(),'mousedown',function(e){
                    if ( drawingMode ) {
                        drawFreeHand();
                    } else {
                        disableDrawMode();
					} 
                });
                return false;
			});
		}

		if(ctGmapNext != null) {
			document.getElementById('ct-gmap-next').addEventListener('click',function () {
				ct_map_next();
			});
		}

		if(ctGmapPrev != null) {
			document.getElementById('ct-gmap-prev').addEventListener('click',function () {
			    ct_map_prev();
			});
		}
	}
	
    function geocode_and_place_marker(property, skipBounds=false) {
		
		var geocoder = new google.maps.Geocoder();
    	var address = property.street+', '+property.city+' '+property.state+', '+property.zip;
		   
	   
       //If latlong exists build the marker, otherwise geocode then build the marker
       if (property['latlong'] && property['latlong'].length>1) {
		   
			var lat = parseFloat(property['latlong'].split(',')[0]),
            	lng = parseFloat(property['latlong'].split(',')[1]);
			var latlng = new google.maps.LatLng(lat,lng);
			
			if ( markerExistsByLatLng( lat, lng ) == -1 ) {	
            	build_marker(latlng, property, skipBounds);
			}

       } else {
			
			geocoder.geocode({ address : address }, function( results, status ) {
               if(status == google.maps.GeocoderStatus.OK) {
					var latlng = results[0].geometry.location;

					if ( markerExistsByLatLng( latlng.lat(), latlng.lng() ) == -1 ) {	
						build_marker(latlng, property,skipBounds);
					}
    			}
    		});
        }
    }
    
	self.init_property_map = function (properties, defaultmapcenter, siteURL) {

		var ctMapType = ctMapGlobal['mapType'];
		var ctMapStyle = ctMapGlobal['mapStyle'];
		var ctMapCustomStyles = ctMapGlobal['mapCustomStyles'];

		if(ctMapStyle == 'custom') {

			if ( defaultmapcenter != null ) {

				var options = {
					zoom: 10,
					center: new google.maps.LatLng(defaultmapcenter.mapcenter),
					mapTypeId: google.maps.MapTypeId[ctMapType], 
					disableDefaultUI: false,
					scrollwheel: false,
					streetViewControl: false,
					styles: [{"featureType":"water","stylers":[{"visibility":"on"},{"color":"#acbcc9"}]},{"featureType":"landscape","stylers":[{"color":"#f2e5d4"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#c5c6c6"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#e4d7c6"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#fbfaf7"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#c5dac6"}]},{"featureType":"administrative","stylers":[{"visibility":"on"},{"lightness":33}]},{"featureType":"road"},{"featureType":"poi.park","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":20}]},{},{"featureType":"road","stylers":[{"lightness":20}]}]
				};
			} else {
				
				var options = {
					mapTypeId: google.maps.MapTypeId[ctMapType], 
					disableDefaultUI: false,
					scrollwheel: false,
					streetViewControl: false,
					styles: [{"featureType":"water","stylers":[{"visibility":"on"},{"color":"#acbcc9"}]},{"featureType":"landscape","stylers":[{"color":"#f2e5d4"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#c5c6c6"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#e4d7c6"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#fbfaf7"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#c5dac6"}]},{"featureType":"administrative","stylers":[{"visibility":"on"},{"lightness":33}]},{"featureType":"road"},{"featureType":"poi.park","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":20}]},{},{"featureType":"road","stylers":[{"lightness":20}]}]
				};
			}

		} else {
			
			var options = {
	    		zoom: 10,
	    		center: new google.maps.LatLng(defaultmapcenter.mapcenter),
	    		mapTypeId: google.maps.MapTypeId[ctMapType], 
	    		disableDefaultUI: false,
	    		scrollwheel: false,
	    		streetViewControl: true
	    	};
	    }

		// get user's location
		lat = getUrlParameter( "lat", "" );
		lng = getUrlParameter( "lng", "" );
		skipBounds = false;

		if ( lat && lng ) {
			//console.log("In lat and lng portion");
			options.center = { lat: parseFloat( lat ), lng: parseFloat( lng ) };
			skipBounds = true;
		}

    	/* Marker Clusters */
        var markerClustererOptions = {
            ignoreHidden: true,
            maxZoom: 14,
            styles: [{
                textColor: '#ffffff',
                url: siteURL+'/images/cluster-icon.png',
                height: 48,
                width: 48
			}]
        };
		
		self.map = new google.maps.Map( document.getElementById( 'map' ), options );
		
		
		map = self.map;

		self.bounds = new google.maps.LatLngBounds();
		
		init_canvas_projection( self.map );
	
		//wait for idle to give time to grab the projection (for calculating offset)
		if ( defaultmapcenter != null ) {

			var idle_listener = google.maps.event.addListener(self.map, 'idle', function() {


				// check for no results...
				//console.log("properties.length: " + properties.length);
				//console.log("properties: ");
				//console.log(properties);
				
				if ( properties && properties.length ) {

					for (i=0;i<properties.length;i++) {
						geocode_and_place_marker(properties[i], skipBounds);
					}

				} else { // no results
		
					var geocoder = new google.maps.Geocoder();
					var latlng;
					var zoomLevel = 14;

					address = getUrlParameter("ct_keyword", "");
					
					geocoder.geocode({ address : address }, function( results, status ) {
						if(status == google.maps.GeocoderStatus.OK) {
						 	latlng = results[0].geometry.location;

						} else {
							// keyword was not a recognised location
							// try the users lat lng otherwise default to usa
							
							if ( lat == "" ) {
								lat = storedLatitude;
								lng = storedLongitude;
							}

							if ( lat != "" && lng != "" ) {
							
								latlng = new google.maps.LatLng( lat, lng );
								zoomLevel = 8;
							} else {
								latlng = new google.maps.LatLng( 40.338354, -97.524664 );	
								zoomLevel = 4;
							}

						}
						 
						self.map.setCenter(latlng);
						self.map.setZoom(zoomLevel);
						//self.bounds.extend(latlng);	
						//self.map.fitBounds(self.bounds);

					});


				}
				
				markerCluster = new MarkerClusterer(self.map, marker_list, markerClustererOptions);
				
				
				google.maps.event.removeListener(idle_listener);
				jQuery( "#number-listings-progress" ).css( "display", "none" );
				
				google.maps.event.addListener( self.map, 'dragend', debounce( ( ) => {
					skipBounds = false;
					//console.log("dragend");
					getMapBounds( self.map );
		
				}, debounceTime ) );
				
		
				google.maps.event.addListener( self.map, 'zoom_changed', debounce( ( ) => {
					skipBounds = false;
					//console.log("zoom_changed");
					getMapBounds( self.map );
		
				}, debounceTime ) );
		
				
			});
	
			google.maps.event.addListenerOnce(map, 'tilesloaded', function() {
				//google.maps.event.trigger(map, 'resize');
			});
		}
	
		/*****************************************************
		*
		* Start Airbnb style map scrolling
		*
		******************************************************/	
/*
		google.maps.event.addListener( self.map, 'dragend', debounce( ( ) => {
			skipBounds = false;
			//console.log("dragend");
			getMapBounds( self.map );

		}, debounceTime ) );
		

		google.maps.event.addListener( self.map, 'zoom_changed', debounce( ( ) => {
			skipBounds = false;
			//console.log("zoom_changed");
			getMapBounds( self.map );

		}, debounceTime ) );

/*		
		if ( skipBounds == true ) {
			hitCount++;
			google.maps.event.addListenerOnce( self.map, 'idle', debounce( ( ) => {
			
				//console.log("idle");
				getMapBounds( self.map );

			}, debounceTime ) );		
		}
*/
		/*****************************************************
		*
		* End Airbnb style map scrolling
		*
		******************************************************/
		
	}
	
	return self;
}());
