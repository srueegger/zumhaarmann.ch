/**
 * Haarmann — Google Maps Init.
 *
 * Wird via wp_enqueue_scripts in der Theme-functions.php geladen, sobald
 * eine Page das Map-Pattern enthält (Class "haarmann-map" im post_content).
 *
 * Die Maps-JS-API ruft nach dem Laden die globale Funktion
 * `haarmannMapInit` auf (siehe `&callback=haarmannMapInit` im Script-Tag).
 *
 * Konfiguration kommt via wp_add_inline_script als `window.haarmannMapConfig`:
 *   { lat, lng, name, address, zoom }
 */

( function () {
	'use strict';

	/**
	 * Dunkle, warme Map-Style-Definition — abgestimmt auf die Theme-Tokens
	 * --wp--preset--color--dark (#1A1612), --gold (#C9A876), --cream (#E8DDC8).
	 *
	 * @type {google.maps.MapTypeStyle[]}
	 */
	var darkWarmStyles = [
		{ elementType: 'geometry', stylers: [ { color: '#221C17' } ] },
		{ elementType: 'labels.icon', stylers: [ { visibility: 'off' } ] },
		{ elementType: 'labels.text.fill', stylers: [ { color: '#9b8a7a' } ] },
		{ elementType: 'labels.text.stroke', stylers: [ { color: '#1A1612' } ] },

		{ featureType: 'administrative', elementType: 'geometry', stylers: [ { color: '#5a4a36' } ] },
		{ featureType: 'administrative.country', elementType: 'labels.text.fill', stylers: [ { color: '#C9A876' } ] },
		{ featureType: 'administrative.locality', elementType: 'labels.text.fill', stylers: [ { color: '#E8DDC8' } ] },
		{ featureType: 'administrative.neighborhood', elementType: 'labels.text.fill', stylers: [ { color: '#C9A876' } ] },

		{ featureType: 'poi', elementType: 'labels.text.fill', stylers: [ { color: '#9b8a7a' } ] },
		{ featureType: 'poi.business', stylers: [ { visibility: 'off' } ] },
		{ featureType: 'poi.park', elementType: 'geometry', stylers: [ { color: '#1f1a14' } ] },
		{ featureType: 'poi.park', elementType: 'labels.text.fill', stylers: [ { color: '#7a6b54' } ] },

		{ featureType: 'road', elementType: 'geometry', stylers: [ { color: '#3a2f25' } ] },
		{ featureType: 'road', elementType: 'geometry.stroke', stylers: [ { color: '#1A1612' } ] },
		{ featureType: 'road', elementType: 'labels.text.fill', stylers: [ { color: '#9b8a7a' } ] },
		{ featureType: 'road.arterial', elementType: 'geometry', stylers: [ { color: '#4a3d2d' } ] },
		{ featureType: 'road.highway', elementType: 'geometry', stylers: [ { color: '#5a4a36' } ] },
		{ featureType: 'road.highway', elementType: 'geometry.stroke', stylers: [ { color: '#1A1612' } ] },
		{ featureType: 'road.highway', elementType: 'labels.text.fill', stylers: [ { color: '#C9A876' } ] },

		{ featureType: 'transit', elementType: 'geometry', stylers: [ { color: '#1f1a14' } ] },
		{ featureType: 'transit.line', elementType: 'geometry', stylers: [ { color: '#3a2f25' } ] },
		{ featureType: 'transit.station', elementType: 'labels.text.fill', stylers: [ { color: '#E8DDC8' } ] },

		{ featureType: 'water', elementType: 'geometry', stylers: [ { color: '#0d0a08' } ] },
		{ featureType: 'water', elementType: 'labels.text.fill', stylers: [ { color: '#5a4a36' } ] }
	];

	/**
	 * Custom Marker — goldener Punkt mit dunklem Stroke, passt zur Brand.
	 */
	function buildMarkerIcon( google ) {
		return {
			path: google.maps.SymbolPath.CIRCLE,
			scale: 10,
			fillColor: '#C9A876',
			fillOpacity: 1,
			strokeColor: '#1A1612',
			strokeWeight: 3
		};
	}

	/**
	 * Escape user-supplied strings before sie ins InfoWindow-HTML wandern.
	 */
	function esc( str ) {
		if ( str === null || typeof str === 'undefined' ) {
			return '';
		}
		return String( str )
			.replace( /&/g, '&amp;' )
			.replace( /</g, '&lt;' )
			.replace( />/g, '&gt;' )
			.replace( /"/g, '&quot;' )
			.replace( /'/g, '&#39;' );
	}

	/**
	 * Adresse aufsplitten in Strasse + PLZ/Ort an erstem Komma.
	 */
	function splitAddress( address ) {
		var parts = String( address || '' ).split( ',' );
		var first = ( parts[ 0 ] || '' ).trim();
		var rest = parts.slice( 1 ).join( ',' ).trim();
		return { street: first, city: rest };
	}

	function buildInfoContent( cfg ) {
		var addr = splitAddress( cfg.address );
		var mapsLink = 'https://maps.google.com/?q=' + encodeURIComponent( cfg.address || '' );
		return (
			'<div class="haarmann-map-info">' +
				'<h3 class="haarmann-map-info__name">' + esc( cfg.name ) + '</h3>' +
				'<p class="haarmann-map-info__address">' +
					esc( addr.street ) +
					( addr.city ? '<br>' + esc( addr.city ) : '' ) +
				'</p>' +
				'<a class="haarmann-map-info__link" href="' + esc( mapsLink ) + '" target="_blank" rel="noreferrer noopener">Route planen →</a>' +
			'</div>'
		);
	}

	/**
	 * Wird von der Maps-JS-API als `?callback=haarmannMapInit` aufgerufen.
	 */
	window.haarmannMapInit = function () {
		var el = document.getElementById( 'haarmann-map' );
		if ( ! el || typeof google === 'undefined' || ! google.maps ) {
			return;
		}

		var cfg = window.haarmannMapConfig || {};
		var lat = typeof cfg.lat === 'number' ? cfg.lat : 47.3892;
		var lng = typeof cfg.lng === 'number' ? cfg.lng : 8.5402;
		var center = { lat: lat, lng: lng };

		var map = new google.maps.Map( el, {
			center: center,
			zoom: typeof cfg.zoom === 'number' ? cfg.zoom : 16,
			styles: darkWarmStyles,
			backgroundColor: '#1A1612',
			disableDefaultUI: true,
			zoomControl: true,
			gestureHandling: 'cooperative',
			clickableIcons: false
		} );

		var marker = new google.maps.Marker( {
			position: center,
			map: map,
			icon: buildMarkerIcon( google ),
			title: cfg.name || cfg.address || ''
		} );

		var infoWindow = new google.maps.InfoWindow( {
			content: buildInfoContent( cfg ),
			pixelOffset: new google.maps.Size( 0, -6 ),
			disableAutoPan: false
		} );

		marker.addListener( 'click', function () {
			infoWindow.open( { map: map, anchor: marker } );
		} );

		// Direkt beim Laden öffnen — der Standort ist die Hauptinfo der Map.
		google.maps.event.addListenerOnce( map, 'idle', function () {
			infoWindow.open( { map: map, anchor: marker } );
		} );
	};
} )();
