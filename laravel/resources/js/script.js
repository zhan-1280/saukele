$('.add-to-cart').click(function() {
    var productId = $(this).data('product-id');

    $.ajax({
        url: '/cart/add',
        method: 'POST',
        data: {
            product_id: productId
        },
        success: function(response) {
            console.log(response.message);
            console.log('Cart count: ' + response.cartCount);
        }
    });
});