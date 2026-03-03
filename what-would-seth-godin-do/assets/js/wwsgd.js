/* global wwsgd_vars */
( function () {
	'use strict';

	/**
	 * Returns the current value of the wwsgd_visits cookie, or 0 if absent.
	 *
	 * @return {number} Visit count.
	 */
	function getWwsgdCookieValue() {
		var cookie = document.cookie
			.split( '; ' )
			.map( function ( pair ) { return pair.split( '=' ); } )
			.find( function ( pair ) { return pair[ 0 ] === 'wwsgd_visits'; } );

		return ( cookie && parseInt( cookie[ 1 ], 10 ) ) || 0;
	}

	/**
	 * Writes the wwsgd_visits cookie with a 1-year expiry.
	 *
	 * @param {number} value New visit count.
	 */
	function setWwsgdCookieValue( value ) {
		var d = new Date();
		d.setTime( d.getTime() + 365 * 24 * 60 * 60 * 1000 );
		document.cookie = 'wwsgd_visits=' + value
			+ ';path=' + wwsgd_vars.cookie_path
			+ ';expires=' + d.toUTCString();
	}

	document.addEventListener( 'DOMContentLoaded', function () {
		var count = getWwsgdCookieValue() + 1;
		setWwsgdCookieValue( count );

		if ( count <= wwsgd_vars.repetition ) {
			Array.from( document.getElementsByClassName( 'wwsgd_new_visitor' ) )
				.forEach( function ( el ) { el.style.display = ''; } );
		} else {
			Array.from( document.getElementsByClassName( 'wwsgd_return_visitor' ) )
				.forEach( function ( el ) { el.style.display = ''; } );
		}
	} );
}() );
