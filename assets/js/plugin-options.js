jQuery(document).ready(function($) {
    "use strict";

    $('#bard-demo-import').on( 'click', function() {

        $('#bard-demo-import').text( 'Please Wait...' );
        $(this).append( '<span class="dashicons dashicons-update-alt spin"></span>' );

        // Checked Plugins
        var contact_from_7      = $('#contact_from_7').is( ':checked' ),
            instagram_feed      = $('#instagram_feed').is( ':checked' ),
            wysija_newsletter   = $('#wysija_newsletter').is( ':checked' ),
            recent_posts        = $('#recent_posts').is( ':checked' ),
            elementor           = $('#elementor').is( ':checked' ),
            royal_elementor     = $('#royal_elementor_addons').is( ':checked' );

        var cf7_active = false,
            instagram_active = false,
            newsletter_active = false,
            recent_posts_active = false,
            elementor_active = false,
            royal_elementor_active = false;

        var startImport = true;

        // Activate Contact Form 7
        if ( true == contact_from_7 ) {
            wp.updates.installPlugin({
                slug: 'contact-form-7',
                success: function() {
                    ajaxPluginInstall( 'bardxtra_contact_from_7_activation', contact_from_7 );
                    cf7_active = true;
                },
                error: function( xhr, ajaxOptions, thrownerror ) {
                    console.log(xhr.errorCode)
                    cf7_active = true;
                    if ( 'folder_exists' === xhr.errorCode ) {
                        ajaxPluginInstall( 'bardxtra_contact_from_7_activation', contact_from_7 );
                    }
                },
            });
        }
            
        // Activate Instagram Feed
        if ( true == instagram_feed ) {
            wp.updates.installPlugin({
                slug: 'instagram-feed',
                success: function() {
                    ajaxPluginInstall( 'bardxtra_instagram_feed_activation', instagram_feed );
                    instagram_active = true;
                },
                error: function( xhr, ajaxOptions, thrownerror ) {
                    console.log(xhr.errorCode)
                    instagram_active = true;
                    if ( 'folder_exists' === xhr.errorCode ) {
                        ajaxPluginInstall( 'bardxtra_instagram_feed_activation', instagram_feed );
                    }
                },
            });
        }
            
        // Activate Mailpoet 2
        if ( true == wysija_newsletter ) {
            wp.updates.installPlugin({
                slug: 'wysija-newsletters',
                success: function() {
                    ajaxPluginInstall( 'bardxtra_wysija_newsletter_activation', wysija_newsletter );
                    newsletter_active = true;
                },
                error: function( xhr, ajaxOptions, thrownerror ) {
                    console.log(xhr.errorCode)
                    newsletter_active = true;
                    if ( 'folder_exists' === xhr.errorCode ) {
                        ajaxPluginInstall( 'bardxtra_wysija_newsletter_activation', wysija_newsletter );
                    }
                },
            });
        }

        // Activate Recent Posts Widget
        if ( true == recent_posts ) {
            wp.updates.installPlugin({
                slug: 'recent-posts-widget-with-thumbnails',
                success: function() {
                    ajaxPluginInstall( 'bardxtra_recent_posts_activation', recent_posts );
                    recent_posts_active = true;
                },
                error: function( xhr, ajaxOptions, thrownerror ) {
                    console.log(xhr.errorCode)
                    recent_posts_active = true;
                    if ( 'folder_exists' === xhr.errorCode ) {
                        ajaxPluginInstall( 'bardxtra_recent_posts_activation', recent_posts );
                    }
                },
            });
        }

        // Activate Recent Posts Widget
        if ( true == elementor && 2 < 1 ) {
            wp.updates.installPlugin({
                slug: 'elementor',
                success: function() {
                    ajaxPluginInstall( 'bardxtra_elementor_activation', elementor );
                    elementor_active = true;
                },
                error: function( xhr, ajaxOptions, thrownerror ) {
                    console.log(xhr.errorCode)
                    elementor_active = true;
                    if ( 'folder_exists' === xhr.errorCode ) {
                        ajaxPluginInstall( 'bardxtra_elementor_activation', elementor );
                    }
                },
            });
        }

        // Activate Recent Posts Widget
        if ( true == royal_elementor && 2 < 1 ) {
            wp.updates.installPlugin({
                slug: 'royal-elementor-addons',
                success: function() {
                    ajaxPluginInstall( 'bardxtra_royal_elementor_addons_activation', royal_elementor );
                    royal_elementor_active = true;
                },
                error: function( xhr, ajaxOptions, thrownerror ) {
                    console.log(xhr.errorCode)
                    royal_elementor_active = true;
                    if ( 'folder_exists' === xhr.errorCode ) {
                        ajaxPluginInstall( 'bardxtra_royal_elementor_addons_activation', royal_elementor );
                    }
                },
            });
        }

        var pluginsInstalled = setInterval(function() {
            if ( contact_from_7 ) {
                startImport = false;
                if  ( cf7_active ) {
                    startImport = true;
                }
            }

            if ( instagram_feed ) {
                startImport = false;
                if  ( instagram_active ) {
                    startImport = true;
                }
            }

            if ( wysija_newsletter ) {
                startImport = false;
                if  ( newsletter_active ) {
                    startImport = true;
                }
            }

            if ( recent_posts ) {
                startImport = false;
                if  ( recent_posts_active ) {
                    startImport = true;
                }
            }

            // if ( elementor ) {
            //     startImport = false;
            //     if  ( elementor_active ) {
            //         startImport = true;
            //     }
            // }

            if ( royal_elementor ) {
                startImport = false;
                if  ( royal_elementor_active ) {
                    startImport = true;
                }
            }

            if ( startImport ) {
                // Import Demo Content
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {
                        action: 'bardxtra_import_xml'
                    },
                    success: function(data, textStatus, XMLHttpRequest){
                        setTimeout(function() {
                            var importButton = $('#bard-demo-import');

                            importButton.remove( '.dashicons' );
                            importButton.text( 'Import Completed!' );
                            importButton.attr( 'disabled', 'disabled' );
                            // $( '.after-import-notice' ).show();
                            var getURL  = window.location.href,    
                                baseURL = getURL.substring(0, getURL.indexOf('/wp-admin') + 9);
                                window.location.replace( baseURL + '/admin.php?page=bard-extra-sub' );

                            // Remove Instagram Widget
                            if ( true != instagram_feed ) {
                                $.ajax({
                                    type: 'POST',
                                    url: ajaxurl,
                                    data: {
                                        action: 'bardxtra_remove_instagram_widget'
                                    },
                                });       
                            }
                        }, 15000 );
                    },
                    error: function(MLHttpRequest, textStatus, errorThrown){
                        console.log('woups err!');
                    }
                });

                console.log('Demo Import Started!');
                clearInterval( pluginsInstalled );
            }
        }, 1000);

    });

    function ajaxPluginInstall( action, plugin ) {
        $.post(
            ajaxurl,
            {
                action: action,
                bardxtra_plugin_checked: plugin,
                nonce: bardPluginOptions.nonce
            },
            function(response) {}
        )
    }


}); // end dom ready