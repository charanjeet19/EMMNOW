/*!
 * Curry currency conversion jQuery Plugin v0.8.3
 * https://bitbucket.org/netyou/curry-currency-ddm
 *
 * Copyright 2017, NetYou (http://curry.netyou.co.il)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.opensource.org/licenses/GPL-2.0
 */
(function($) {

  $.fn.curry = function(options) {

    // Setup a global cache for other curry plugins
    if (!window.jQCurryPluginCache)
      window.jQCurryPluginCache = [{}, false];

    var output = '',
      rates = {},
      t = this,
      requestedCurrency = window.jQCurryPluginCache[1],
      $document = $(document),
      dropDownMenu, value,
      item, keyName,
      i, l, rate;

    // Create some defaults, extending them with any options that were provided
    var settings = $.extend({
      target: '.price',
      change: true,
      base: 'USD',
      symbols: {}
    }, options);

    this.each(function() {

      var $this = $(this),
        id = $this.attr('id'),
        classes = $this.attr('class'),
        attrs = '',
        tempHolder;

      // Add class or id if replaced element had either of them
      attrs += id ? ' id="' + id + '"' : '';

      if (classes) {

        attrs += ' class="curry-ddm';

        if (classes)
          attrs += ' ' + classes + '"';
        else
          attrs += '"';

      } else {

        attrs += '';

      }

      // keep any classes attached to the original element
      output = '<select' + attrs + '></select>';

      // Replace element with generated select
      tempHolder = $(output).insertAfter($this);
      $this.detach();

      // Add new drop down to jquery list (jquery object)
      dropDownMenu = !dropDownMenu ? tempHolder : dropDownMenu.add(tempHolder);

    });

    // Create the html for the drop down menu
    var generateDDM = function(rates) {

      output = '';

      // Change all target elements to drop downs
      dropDownMenu.each(function() {
				
		/*------ generates option value using ajax, saved in db in wp_option table */
		$('#ct-currency-switch').empty(); 

		var data = {
			'action': 'get_curriencies'
		};
		$.post('/wp-admin/admin-ajax.php', data, function(response) {
			
			let parse_data=	JSON.parse(response);

			 $.each(parse_data, function( index, value ) {
					
				$('#ct-currency-switch').append('<option data-rate="'+value[1]+'"  value="'+value[0]+'">'+value[0]+'</option>'); 
			});
		});
		
		/*------26th dec-2018---*/
        for (i in rates) {

          rate = rates[i];
			
          //output += '<option value="' + i + '" data-rate="' + rate + '">' + i + '</option>';

        }

        $(output).appendTo(this);

      });

    };

    if (!settings.customCurrency) {

      // Only get currency hash once
      if (!requestedCurrency) {

        // Request currencies from yahoo finance
        var jqxhr = $.ajax({
          url: 'https://data.fixer.io/api/latest?access_key=' + ct_fixer_access_key,
          dataType: 'jsonp',
          data: {
            symbols: 'INR,EUR,CAD,GBP,ILS',
            base: settings.base
          }
        });

        // Set global flag so we know we made a request
        window.jQCurryPluginCache[1] = true;

        jqxhr
          .done(function(data) {

            var initrates = data.rates;

            // Add the base currency to the rates
            rates[settings.base] = 1;

            for ( var currency in initrates ) {

              value = initrates[currency];

              rates[currency] = value;

            }

            generateDDM(rates);

            window.jQCurryPluginCache[0] = rates;
            $document.trigger('jQCurryPlugin.gotRates');

          })
          .fail(function(err) {

            console.log(err);

          });

      } else {

        $document.on('jQCurryPlugin.gotRates', function() {

          generateDDM(window.jQCurryPluginCache[0]);

        });

      }

    } else {

      generateDDM(settings.customCurrency);

    }

    // only change target when change is set by user
    if (settings.change) {

      // Add default currency symbols
      var symbols = $.extend({
          'UDD': '&#36;',
          'GBP': '&pound;',
          'EUR': '&euro;',
          'JPY': '&yen;'
        }, settings.symbols),
        $priceTag, symbol;

      $document.on('change', this.selector, function() {

        var $target = $(settings.target),
          $option = $(this).find(':selected'),
          rate = $option.data('rate'),
          has_comma = false,
          money, result, l = $target.length;

        for (var i = 0; i < l; i++) {

          $price = $($target[i]);
          money = $price.text();

          // Check if field has comma instead of decimal and replace with decimal
          if ( money.indexOf(',') !== -1 ){
            has_comma = true;
            money = money.replace( ',' , '.' );
          }

          // Remove anything but the numbers and decimals and convert string to Number
          money = Number(money.replace(/[^0-9\.]+/g, ''));

          if ($price.data('base-figure')) {

            // If the client changed the currency there should be a base stored on the element
            result = rate * $price.data('base-figure');

          } else {

            // Store the base price on the element
            $price.data('base-figure', money);
            result = rate * money;

          }

          // Parse as two decimal number with .
          result = Number(result.toString().match(/^\d+(?:\.\d{0,2})?/));

          // Replace decimal with comma after calculations
          if ( has_comma ){
            result = result.toString().replace( '.' , ',' );
            has_comma = false;
          }

          symbol = symbols[$option.val()] || $option.val();

          $price.html('<span class="symbol">' + symbol + '</span>' + result);

        }

      });

    }

    // Returns jQuery object for chaining
    return dropDownMenu;

  };

})(jQuery); 

//jQuery(document).ready(function(){
	
	/* console.log('dropdown js file loaded');
	
	jQuery('#ct-currency-switch').empty(); 

	var data = {
		'action': 'get_curriencies',
		
	};


	jQuery.post('/wp-admin/admin-ajax.php', data, function(response) {
		console.log("kapil");
		let parse_data=	JSON.parse(response);

		 jQuery.each(parse_data, function( index, value ) {
				//console.log(value);
			jQuery('#ct-currency-switch').append('<option data-rate="'+value[1]+'"  value="'+value[0]+'">'+value[0]+'</option>'); 
		});
	});
	 */
//});


