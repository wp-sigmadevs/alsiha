/**
 * Add to cart button functionality
 *
 * @param {Object} $
 */
//
// export const rtsbAddToCartWidget = ( $ ) => {
// 	$( 'form.cart' ).on( 'click', '.rtsb-quantity-plus, .rtsb-quantity-minus', ( e ) => {
// 		// Get current quantity values
// 		const productType = $( e.currentTarget )
// 			.closest( '.rtsb-product-add-to-cart' )
// 			.attr( 'data-product-type' );
// 		let qty, val, minVal;
//
// 		if ( 'grouped' !== productType ) {
// 			qty = $( e.currentTarget ).closest( 'form.cart' ).find( '.qty' );
// 			val = parseFloat( qty.val() );
// 			minVal = 1;
// 		} else {
// 			qty = $( e.currentTarget )
// 				.closest( '.rtsb-quantity-box-group' )
// 				.find( '.qty' );
// 			val = ! qty.val() ? 0 : parseFloat( qty.val() );
// 			minVal = 0;
// 		}
//
// 		const max = parseFloat( qty.attr( 'max' ) );
// 		const min = parseFloat( qty.attr( 'min' ) );
// 		const step = parseFloat( qty.attr( 'step' ) );
//
// 		// Change the value if plus or minus
// 		if ( $( e.currentTarget ).is( '.rtsb-quantity-plus' ) ) {
// 			if ( max && max <= val ) {
// 				qty.val( max );
// 			} else {
// 				qty.val( val + step );
// 			}
// 		} else if ( min && min >= val ) {
// 			qty.val( min );
// 		} else if ( val > minVal ) {
// 			qty.val( val - step );
// 		}
// 	}
// 	);
// };
