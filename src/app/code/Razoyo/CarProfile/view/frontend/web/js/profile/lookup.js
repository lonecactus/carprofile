/**
 * @author      Razoyo <razoyo@razoyo.com>
 * @copyright   Copyright 2024 © Razoyo. All Rights Reserved.
 */

define([
    'jquery',
    'domReady'
], function () {
    'use strict';
    return function ymmLookup(makeUrl, modelUrl) {

        jQuery(document).ready(function() {
            jQuery('button.save').prop('disabled', true);
        });

        jQuery(document).on('change', '#selector_year', function () {
            var param = 'year=' + jQuery('#selector_year').val();

            jQuery('#selector_make').attr('disabled', true);
            jQuery('#selector_model').attr('disabled', true);
            jQuery('button.save').prop('disabled', true);

            jQuery.ajax({
                url: makeUrl,
                data: param,
                type: 'GET',
                dataType: 'json',
                beforeSend: function () {
                    jQuery('body').trigger('processStart'); // start loader
                }
            }).done(function (data) {
                jQuery('body').trigger('processStop');
                jQuery('#selector_make').empty();
                jQuery('#selector_make').append(data.value);
                jQuery('#selector_make').attr('disabled', false);
            });
        });

        jQuery(document).on('change', '#selector_make', function () {
            var param = 'year=' + jQuery('#selector_year').val() + '&make=' + jQuery('#selector_make').val();

            jQuery('#selector_model').attr('disabled', true);
            jQuery('button.save').prop('disabled', true);

            jQuery.ajax({
                url: modelUrl,
                data: param,
                type: 'GET',
                dataType: 'json',
                beforeSend: function () {
                    jQuery('body').trigger('processStart'); // start loader
                }
            }).done(function (data) {
                jQuery('body').trigger('processStop');
                jQuery('#selector_model').empty();
                jQuery('#selector_model').append(data.value);
                jQuery('#selector_model').attr('disabled', false);
                // jQuery('button.save').prop('disabled', false);
            });



            ///        $resultRedirect = $this->redirectFactory->create();
            //         $resultRedirect->setPath('carprofile/profile/index');
            //         return $resultRedirect;
        });

        jQuery(document).on('change', '#selector_model', function () {
            var modelSelection = jQuery('#selector_model').val();
            if( modelSelection.length ) {
                jQuery('button.save').prop('disabled', false);
            } else {
                jQuery('button.save').prop('disabled', true)
            }
            // console.log(jQuery('#selector_model').val() + '||selectorvalue');
        });
    }

});
