function DufProductCrud() { }

DufProductCrud.prototype.setMap = function(input)
{
    var latitude 	= $('#duf_admin_generic_latitude').val();
    var longitude 	= $('#duf_admin_generic_longitude').val();

    if (typeof(latitude) == 'undefined' || latitude == '') {
    	latitude = 48.853588011465085;
    }

    if (typeof(longitude) == 'undefined' || longitude == '') {
    	longitude = 2.3453826904296875;
    }

    $('#ecommerce-map-picker').locationpicker({
        location: {latitude: latitude, longitude: longitude},
        radius: 12,
        addressFormat: 'street_address',
        inputBinding:
        {
            latitudeInput: 		$('#duf_admin_generic_latitude'),
            longitudeInput: 	$('#duf_admin_generic_longitude'),
            locationNameInput: 	$('#ecommerce-location-search'),
        },
        enableAutocomplete: true,
        onchanged: function (currentLocation, radius, isMarkerDropped) {
            var addressComponents = $(this).locationpicker('map').location.addressComponents;
            window.dufProductCrud.updateControls(addressComponents);
        },
        oninitialized: function(component) {
            var address 	= $('#duf_admin_generic_address').val();
            var city 		= $('#duf_admin_generic_city').val();

            if(typeof(address) == 'undefined')
            {
                $('#duf_admin_generic_address').val(null);
                $('#duf_admin_generic_city').val(null);
                $('#duf_admin_generic_zipcode').val(null);
            }
        }
    });
};

DufProductCrud.prototype.updateControls = function(addressComponents)
{
    var fastsearch 	= $('#ecommerce-location-search').val();
    fastsearch 		= fastsearch.split(",");
    var address 	= $('#duf_admin_generic_address').val();

    $('#duf_admin_generic_address').val(addressComponents.addressLine1);
    $('#duf_admin_generic_address2').val(addressComponents.addressLine2);
    $('#duf_admin_generic_city').val(addressComponents.city);
    $('#duf_admin_generic_zipcode').val(addressComponents.postalCode);

    $('select[name="duf_admin_generic[country]"]').val(addressComponents.country).trigger("change");
};

DufProductCrud.prototype.checkIsVirtual = function()
{
    var is_checked = $('input[name="duf_admin_generic[is_virtual]"]').is(':checked');

    if (is_checked) {
        // hide address if store is virtual
        $('.dufecommerce-address-component').slideUp();
    }
    else {
        // show address if store is NOT virtual
        $('.dufecommerce-address-component').slideDown();
    }
};

DufProductCrud.prototype.changeProductCategories = function(checkbox)
{
    console.log(checkbox.is(':checked'));

    if (checkbox.is(':checked')) {
        // select category parents
        var category_ul = checkbox.parent().parent();
        window.dufProductCrud.checkParentCategory(category_ul);
    }
    else {
        // unselect category children
        var children_container = checkbox.parent().find('.categories-tree-crud.children');
        if (children_container.length > 0) {
            var children_checkboxes = children_container.find('input[type="checkbox"]');

            children_checkboxes.each(function() {
                $(this).prop('checked', false);
            });
        }
    }
};

DufProductCrud.prototype.checkParentCategory = function(category_ul)
{
    if (category_ul.hasClass('children')) {
        var parent_category_checkbox = category_ul.parent().find('input[type="checkbox"]').first();

        if (!parent_category_checkbox.is(':checked')) {
            parent_category_checkbox.prop('checked', true);

            var next_category_ul = parent_category_checkbox.parent().parent();
            window.dufProductCrud.checkParentCategory(next_category_ul);
        }
    }
};

DufProductCrud.prototype.getProductsForCategory = function(select)
{
    $('#store-products-list-ajax-container').html('');

    if (select.val() > 0 && select.val() !== '0') {
        var category_id                 = select.val();
        var category_entity             = select.data('category-entity');
        var route                       = Routing.generate('duf_e_commerce_get_products_by_category', { category_id: category_id });
        var previous_products_options   = $('#duf-admin-store-products').find('option');
        var previous_products           = new Array();

        previous_products_options.each(function() {
            previous_products.push($(this).val());
        });

        $.ajax({
            url: route,
            type: 'POST',
            data: 'category_entity=' + category_entity + '&previous_products=' + previous_products,
            success: function(html) {
                $('#store-products-list-ajax-container').html(html);
            }
        });
    }
};

DufProductCrud.prototype.setSelectedStoreProducts = function(checkbox)
{
    if (checkbox.is(':checked')) {
        // add product to hidden select
        var product_option  = '<option value="' + checkbox.val() + '|' + checkbox.data('product-class') + '" selected>' + checkbox.data('product-class') + '</option>';
        $('#duf-admin-store-products').append(product_option);

        // duplicate list-item
        var list_item   = checkbox.parent().appendTo($('.store-selected-products .list-group'));
    }
    else {
        // remove product from hidden select
        $('#duf-admin-store-products option').each(function() {
            if ($(this).val() == checkbox.val() + '|' + checkbox.data('product-class')) {
                $(this).remove();
            }
        });

        // remove list-item
        checkbox.parent().fadeOut(function() {
            checkbox.parent().remove();
        });
    }
};

$(document).on('switchChange.bootstrapSwitch', 'input[name="duf_admin_generic[is_virtual]"]', function() {
    window.dufProductCrud.checkIsVirtual();
});

$(document).on('change', '.categories-tree-crud li input[type="checkbox"]', function() {
    window.dufProductCrud.changeProductCategories($(this));
});

$(document).on('change', '#duf-ecommerce-store-products-search', function() {
    window.dufProductCrud.getProductsForCategory($(this));
});

$(document).on('change', '.store-product-checkbox', function() {
    window.dufProductCrud.setSelectedStoreProducts($(this));
});