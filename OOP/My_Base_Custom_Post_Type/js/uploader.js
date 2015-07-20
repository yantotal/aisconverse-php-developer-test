(function ($) {
    $(document ).ready(function() {
        var AltImageUpdate = function ( post_id, thumb_id ) {
            wp.media.post( 'set_alternative_thumbnail', {
                post_id:      post_id,
                thumbnail_id: thumb_id,
                nonce:        child_theme.nonce
            } ).done( function ( html ) {
                $('#mc_bottom_meta_box' ).find('.inside' ).html(html);
            } );
        };

        $('#mc_bottom_meta_box' )
            .on('click', '#set-post-alternative-thumbnail', function(e) {
                e.preventDefault();
                e.stopPropagation();

                var uploader = wp.media( {
                    title:    child_theme.l10n.uploaderTitle,
                    button:   { text: child_theme.l10n.uploaderButton },
                    multiple: false
                } );
                uploader.on('select', function() {
                    var attachment = uploader.state().get( 'selection' ).first().toJSON();
                    AltImageUpdate( wp.media.view.settings.post.id, attachment.id );
                });
                uploader.open();
            })
            .on('click', '#remove-post-alternative-thumbnail', function(e) {
                e.preventDefault();
                e.stopPropagation();

                AltImageUpdate( wp.media.view.settings.post.id, -1 );
            });
    });
})(jQuery);