/**
 * Add to cart icon
 *
 * @param {Object} $
 */

/* global wc_checkout_params */

export const rtsbCheckoutCoupon = ( $ ) => {
	//console.log( wc_checkout_params  )
	$( '.rtsb-checkout-coupon-form button[name="apply_coupon"]' ).click( function( event ) {
		event.preventDefault(); // cancel default behavior
		const $form = $( this ).parents( '.woocommerce-form-coupon' );
		if ( $form.is( '.processing' ) ) {
			return false;
		}
		$form.addClass( 'processing' ).block( {
			message: null,
			overlayCSS: {
				background: '#fff',
				opacity: 0.6,
			},
		} );
		// Get the coupon code from the input field
		// eslint-disable-next-line camelcase
		const coupon_code = $form.find( 'input[name="coupon_code"]' ).val();
		const data = {
			// eslint-disable-next-line camelcase
			security: wc_checkout_params.apply_coupon_nonce,
			coupon_code: $form.find( 'input[name="coupon_code"]' ).val(),
		};
		// Use the WooCommerce REST API to apply the coupon code to the cart
		$.ajax( {
			type: 'POST',
			// eslint-disable-next-line camelcase
			url: wc_checkout_params.wc_ajax_url
				.toString()
				.replace( '%%endpoint%%', 'apply_coupon' ),
			data: new URLSearchParams( data ).toString(),
			success( res ) {
				$( '.woocommerce-error, .woocommerce-message' ).remove();
				$form.removeClass( 'processing' ).unblock();
				if ( res ) {
					$form.before( res );
					$form.slideUp();
					// eslint-disable-next-line camelcase
					$( document.body ).trigger( 'applied_coupon_in_checkout', [
						coupon_code,
					] );
					$( document.body ).trigger( 'update_checkout', {
						update_shipping_method: false,
					} );
					//$( document.body ).trigger( 'wc_update_cart' );
				}
			},
			error( res ) {
				console.log( res );
				console.log( 'Error applying coupon.' );
			},
		} );
	} );
};
export const rtsbLoginForm = ( $ ) => {
	$( document.body ).on(
		'click',
		'.rtsb-checkout-login-form a.showlogin',
		function() {
			$( '.rtsb-checkout-login-form .login' ).slideToggle();
		}
	);
	$( '.rtsb-checkout-login-form button[name="login"]' ).click( function( event ) {
		event.preventDefault(); // cancel default behavior
		const $form = $( this ).parents( '.woocommerce-form-login' );
		if ( $form.is( '.processing' ) ) {
			return false;
		}
		$form.addClass( 'processing' ).block( {
			message: null,
			overlayCSS: {
				background: '#fff',
				opacity: 0.6,
			},
		} );

		const thedata = {
			action: 'rtsb_ajax_login',
			username: $( '#username' ).val(),
			password: $( '#password' ).val(),
			rememberme: $( '#rememberme:checked' ).val()
				? $( '#rememberme:checked' ).val()
				: false,
			__rtsb_wpnonce: rtsbPublicParams.__rtsb_wpnonce,
		};
		// console.log( thedata );
		$.ajax( {
			type: 'POST',
			dataType: 'json',
			url: rtsbPublicParams.ajaxUrl,
			data: thedata,
			success( res ) {
				$form.removeClass( 'processing' ).unblock();
				/* console.log( res ) if ( res.loggedin ){} else {} */
				setTimeout( function() {
					window.location.href = res.redirectto;
				}, 500 );
			},
			error( res ) {},
		} );
	} );
};

export const rtsbCheckoutError = ( $ ) => {
	if( $('.checkout-page ').length ){
		$( document.body ).on( 'checkout_error', function( event, error_message ) {
			const $form = $( 'form.checkout' );
			$( '.woocommerce-NoticeGroup-checkout, .woocommerce-error, .woocommerce-message' ).remove();
			$form.find('.rtsb-notice-widget').find('.rtsb-notice').prepend( '<div class="woocommerce-NoticeGroup woocommerce-NoticeGroup-checkout">' + error_message + '</div>' ); // eslint-disable-line max-len
		});
	}

};

// rtsb-builder-content