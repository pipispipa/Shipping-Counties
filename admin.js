jQuery(document).ready(function($) {
    $('#add-company').click(function(e) {
        e.preventDefault();
        var newIndex = $('#shipping-companies tr').length;
        $('#shipping-companies').append('<tr valign="top"><th scope="row">Company Name:</th><td><input type="text" name="ship_from_countries_companies[' + newIndex + '][name]" value="" /> Shipping From: <input type="text" name="ship_from_countries_companies[' + newIndex + '][shipping_from]" value="" /><button class="button remove-company">Remove</button></td></tr>');
    });

    $(document).on('click', '.remove-company', function(e) {
        e.preventDefault();
        $(this).closest('tr').remove();
    });
});
