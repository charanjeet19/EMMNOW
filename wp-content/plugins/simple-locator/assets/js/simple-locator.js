function openInfoWindow(o){return google.maps.event.trigger(markers[o],"click"),googlemap.panTo(markers[o].getPosition()),googlemap.fitBounds(markers[o].getPosition()),googlemap.setZoom(12),!1}function wpsl_before_submit(o,e){}function wpsl_after_render(o){}function wpsl_click_marker(o,e,t,a){}function wpsl_no_results(o,e){}function wpsl_error(o,e){}function wpsl_success(o,e,t){}function wpsl_googlemaps_response(){return googlemaps_response}function wpsl_all_locations_rendered(o){}function wpsl_all_locations_marker_clicked(o,e){}var markers=[],googlemap="",active_form="",formatted_address="",googlemaps_response="",geolocation=!1;jQuery(function(o){function e(){if("1"===wpsl_locator.autocomplete){var e=o(".wpsl-search-form");o.each(e,function(e,t){var a=new google.maps.places.Autocomplete(this),s=o(this).parents("form").find(".wpslsubmit");google.maps.event.addListener(a,"place_changed",function(){o(s).click()})})}}function t(e){if(wpsl_locator.default_enabled)if("true"===wpsl_locator.default_user_center&&navigator.geolocation&&!e){var a=o(".simple-locator-form");o.each(a,function(e,a){var s=n(o(this));o(s.results).empty().addClass("loading").show(),navigator.geolocation.getCurrentPosition(function(o){m(o,s)},function(e){t(!0),o(s.results).empty().removeClass("loading").hide()})})}else s()}function a(e,t,a){o.ajax({url:wpsl_locator.ajaxurl,type:"post",datatype:"json",data:{action:"locatornonce"},success:function(s){"1"===wpsl_locator.jsdebug&&(console.log("Nonce Generation Response"),console.log(s)),o(".locator-nonce").remove(),o(e).find("form").append('<input type="hidden" class="locator-nonce" name="nonce" value="'+s.nonce+'" />'),a&&l(t)}})}function s(e,t){var a=wpsl_locator.default_latitude,s=wpsl_locator.default_longitude,l=o(".simple-locator-form");o.each(l,function(o,e){formelements=n(this),formelements.map.show();var t=new google.maps.LatLng(a,s),l={center:t,zoom:parseInt(wpsl_locator.default_zoom),mapTypeControl:!1,streetViewControl:!1,styles:wpsl_locator.mapstyles};"1"===wpsl_locator.custom_map_options&&(l=wpsl_locator.map_options),l.center=t;new google.maps.Map(formelements.map[0],l)})}function n(e){var t=".wpsl-map",a=".wpsl-results";if(o(active_form).siblings("#widget").length<1){if("."===wpsl_locator_options.mapcont.charAt(0))var t=o(e).find(wpsl_locator_options.mapcont);else var t=o(wpsl_locator_options.mapcont);if("."===wpsl_locator_options.resultscontainer.charAt(0))var a=o(e).find(wpsl_locator_options.resultscontainer);else var a=o(wpsl_locator_options.resultscontainer)}else var t=o(active_form).find(t),a=o(active_form).find(a);return formelements={parentdiv:o(e),errordiv:o(e).find(".wpsl-error"),map:t,results:a,distance:o(e).find(".distanceselect"),address:o(e).find(".address"),latitude:o(e).find(".latitude"),longitude:o(e).find(".longitude"),unit:o(e).find(".unit"),taxonomy:o(e).find('input[name^="taxonomy"]:checked'),taxonomy_select:o(e).find('select[name^="taxonomy"]'),form:o(e).find("form")},formelements}function l(e){var t=o(e.address).val();return o(e.form).hasClass("allow-empty")&&""===t?p(e):o(e.form).hasClass("allow-empty")&&"undefined"==typeof t?p(e):(geocoder=new google.maps.Geocoder,void geocoder.geocode({address:t},function(t,a){if(a==google.maps.GeocoderStatus.OK){googlemaps_response=t;var s=t[0].geometry.location.lat(),n=t[0].geometry.location.lng();return formatted_address=t[0].formatted_address,"1"===wpsl_locator.jsdebug&&(console.log("Google Geocode Response"),console.log(t)),o(e.latitude).val(s),o(e.longitude).val(n),0===o(e.form).find("#wpsl_action").length?p(e):r(e)}wpsl_error(wpsl_locator.notfounderror,active_form),o(e.errordiv).text(wpsl_locator.notfounderror).show(),o(e.results).hide()}))}function r(e){o(e.form).append('<input type="hidden" name="formatted_address" value="'+formatted_address+'">'),o(e.form).append('<input type="hidden" name="geolocation" value="'+geolocation+'">'),o(e.form).submit()}function p(e){var t=o(e.taxonomy).serializeArray();if(0==e.taxonomy.length){var a=o(e.taxonomy_select);o.each(a,function(e,a){if(""!==o(this).val()){var s={};s.name=o(this).attr("name"),s.value=o(this).val(),t.push(s)}})}var s={};o.each(t,function(o,e){var t=this.name.replace(/(^.*\[|\].*$)/g,"");void 0!=typeof s[t]&&s[t]instanceof Array||(s[t]=[]),t&&s[t].push(this.value)});var n=!!o(e.form).hasClass("allow-empty"),l="undefined"!=typeof o(e.address).val()&&o(e.address).val(),r="undefined"!=typeof o(e.distance).val()&&o(e.distance).val();if(formdata={action:"locate",address:l,formatted_address:formatted_address,locatorNonce:o(".locator-nonce").val(),distance:r,latitude:o(e.latitude).val(),longitude:o(e.longitude).val(),unit:o(e.unit).val(),geolocation:geolocation,taxonomies:s,allow_empty_address:n},wpsl_locator.postfields.length>0)for(var i=0;i<wpsl_locator.postfields.length;i++){var p=wpsl_locator.postfields[i];formdata[p]=o("input[name="+p+"]").val()}o.ajax({url:wpsl_locator.ajaxurl,type:"post",datatype:"json",data:formdata,success:function(t){"1"===wpsl_locator.jsdebug&&(console.log("Form Response"),console.log(t)),"error"===t.status?(wpsl_error(t.message,active_form),o(e.errordiv).text(t.message).show(),o(e.results).hide(),o(e.map).hide()):(wpsl_success(t.result_count,t.results,active_form),c(t,e))},error:function(o){"1"===wpsl_locator.jsdebug&&(console.log("Form Response Error"),console.log(o.responseText))}})}function c(e,t){if(e.result_count>0){var a=1===e.result_count?wpsl_locator.location:wpsl_locator.locations,s='<h3 class="wpsl-results-header">'+e.result_count+" "+a;for(""!==e.latitude&&(s+=" "+wpsl_locator.found_within+" "+e.distance+" "+e.unit+" "+wpsl_locator.of+" "),s+="true"===e.using_geolocation?wpsl_locator.yourlocation:e.formatted_address,s+="</h3>",""!==wpsl_locator_options.resultswrapper&&(s+="<"+wpsl_locator_options.resultswrapper+">"),i=0;i<e.results.length;i++)s+=e.results[i].output;""!==wpsl_locator_options.resultswrapper&&(s+="</"+wpsl_locator_options.resultswrapper+">"),o(t.results).removeClass("loading").html(s),o(t.map).show(),o(t.zip).val("").blur(),d(e,t),wpsl_after_render(active_form)}else o(t.errordiv).text(wpsl_locator_options.noresultstext).show(),o(t.results).hide(),o(t.map).hide(),wpsl_no_results(e.formatted_address,active_form)}function d(e,t){markers=[];var a=o(t.map)[0];if("undefined"!=typeof wpsl_locator_options)var s="show"!==wpsl_locator_options.mapcontrols;else var s=!1;if("undefined"!=typeof wpsl_locator_options)var n=google.maps.ControlPosition[wpsl_locator_options.mapcontrolsposition];else var n="TOP_LEFT";var l,r=wpsl_locator.mappin?wpsl_locator.mappin:"",i=new google.maps.LatLngBounds,p={mapTypeId:"roadmap",mapTypeControl:!1,zoom:8,styles:wpsl_locator.mapstyles,panControl:!1,disableDefaultUI:s,zoomControlOptions:{style:google.maps.ZoomControlStyle.SMALL,position:n}};"1"===wpsl_locator.custom_map_options&&(p=wpsl_locator.map_options);var c,d,u=[],m=new google.maps.InfoWindow;l=new google.maps.Map(a,p);for(var d=0,f=e.results.length;d<f;d++){var _={title:e.results[d].title,lat:e.results[d].latitude,lng:e.results[d].longitude,id:e.results[d].id,infowindow:e.results[d].infowindow};u.push(_)}for(d=0;d<u.length;d++){var g=new google.maps.LatLng(u[d].lat,u[d].lng);i.extend(g),c=new google.maps.Marker({position:g,map:l,title:u[d].title,icon:r}),google.maps.event.addListener(c,"click",function(o,e){return function(){m.setContent(u[e].infowindow),m.open(l,o),wpsl_click_marker(o,e,active_form,u[e].id)}}(c,d)),markers.push(c),l.fitBounds(i);var w=google.maps.event.addListener(l,"idle",function(){e.results.length<2&&l.setZoom(13),google.maps.event.removeListener(w)})}var v=google.maps.event.addListener(l,"bounds_changed",function(o){google.maps.event.removeListener(v)});googlemap=l}function u(){if("true"!==wpsl_locator.showgeobutton)return!1;if(navigator.geolocation){var e='<button class="wpsl-geo-button">'+wpsl_locator.geobuttontext+"</button>";o(".geo_button_cont").html(e)}}function m(e,t){var a=e.coords.longitude,s=e.coords.latitude;o(t.latitude).val(s),o(t.longitude).val(a),geolocation=!0,p(t)}o(document).ready(function(){e(),t()}),o(".wpslsubmit").on("click",function(e){e.preventDefault(),geolocation=!1;var t=o(this).parents(".simple-locator-form");active_form=t,o("input[name=latitude],input[name=longitude]").val("");var s=n(t);wpsl_before_submit(active_form,s),o(s.errordiv).hide(),wpsl_locator.default_enabled?o(s.map).find(".gm-style").remove():o(s.map).hide(),o(s.results).empty().addClass("loading").show(),a(t,s,!0)}),o(document).ready(function(){u(),o(".simple-locator-form").each(function(){a(o(this))})}),o(document).on("click",".wpsl-geo-button",function(e){e.preventDefault();var t=o(this).parents(".simple-locator-form");active_form=t;var a=n(t);o(a.errordiv).hide(),wpsl_locator.default_enabled?o(a.map).find(".gm-style").remove():o(a.map).hide(),o(a.results).empty().addClass("loading").show(),navigator.geolocation.getCurrentPosition(function(o){m(o,a)})})});