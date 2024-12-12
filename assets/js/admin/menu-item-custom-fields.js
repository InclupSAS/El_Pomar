jQuery(document).ready(function($) {
    function setThumbnail(item_id, attachment) {
        $('#edit-menu-item-thumbnail-' + item_id).val(attachment.id);
        $('#menu-item-thumbnail-preview-' + item_id).html('<img src="' + attachment.url + '" alt="" style="max-width: 100%; height: auto;">');
    }

    $('.upload-thumbnail-button').on('click', function(e) {
        e.preventDefault();
        var item_id = $(this).data('item-id');
        var frame = wp.media({
            title: 'Seleccionar Imagen',
            button: {
                text: 'Usar esta imagen'
            },
            multiple: false
        });

        frame.on('select', function() {
            var attachment = frame.state().get('selection').first().toJSON();
            setThumbnail(item_id, attachment);
        });

        frame.open();
    });

    $('.remove-thumbnail-button').on('click', function(e) {
        e.preventDefault();
        var item_id = $(this).data('item-id');
        $('#edit-menu-item-thumbnail-' + item_id).val('');
        $('#menu-item-thumbnail-preview-' + item_id).html('');
    });
});