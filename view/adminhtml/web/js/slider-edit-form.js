/*
 * @Author: zerokool - Nguyen Huu Tien
 * @Date:   2015-07-16 13:17:04
 * @Last Modified by:   zero
 * @Last Modified time: 2015-09-26 20:37:57
 */

'use strict';
require(['jquery','magestore/zebra-tooltips'], function($) {
    $(document).ready(function() {
        var atooltip = $('[data-position-image]'),
            positionImage = atooltip.data('position-image'),
            imageTooltip = [],
            categories = [
                'category-sidebar-right-top',
                'category-sidebar-right-bottom',
                'category-sidebar-left-top',
                'category-sidebar-left-bottom',
                'category-content-top',
                'category-menu-top',
                'category-menu-bottom',
                'category-page-bottom',
            ];

        for (var i = 0; i < positionImage.length; i++) {
            imageTooltip.push($('<img src="' + positionImage[i] + '" />'));
        };

        atooltip.css('cursor', 'pointer').click(function(e) {
            e.preventDefault();
        });

        function toggleDescriptionField() {
            var display = ($('#page_style_content').val() == 1 && $('#page_style_slide').val() == 6);
            $('#page_description').parents('.admin__field').toggle(display);
        }

        function toggleCustomCodeField() {
            var display = ($('#page_style_content').val() == 2);
            $('#page_custom_code').parents('.admin__field').toggle(display);
        }

        function toggleStyleSlideNote() {
            var pageStyleSlideVal = $('#page_style_slide').val();
            $('#style_slide-note').toggle(pageStyleSlideVal != '' && pageStyleSlideVal != 5);
        }

        function updateLinkPreview() {
            $('#style-slide-view').attr('href', $('#style-slide-view').data('preview-url') + 'sliderpreview_id/' + $('#page_style_slide').val() + '/');
        }

        function toggleCategoryId() {
            var position = $('#page_position' + ($('#page_style_content').val() == 1 ? '' : '_custom')).val();
            $('#page_category_ids').parents('.admin__field').toggle(categories.indexOf(position) != -1);
        }

        function updatePositionImage() {
            var position = $('#page_position' + ($('#page_style_content').val() == 1 ? '' : '_custom')).val();

            var img = null;
            switch (position) {
                case '':
                    break;
                case 'customer-content-top':
                    img = imageTooltip[0];
                    break;
                case 'checkout-content-top':
                    img = imageTooltip[1];
                    break;
                case 'note-allsite':
                    img = imageTooltip[3];
                    break;
                case 'pop-up':
                    img = imageTooltip[4];
                    break;
                default:
                    img = imageTooltip[2];
                    break;
            };

            atooltip.toggle(position != '');
            $.Zebra_Tooltips(atooltip, {
                'max_width': 300,
                'content': img,
                background_color: '#4C9ED9'
            });
        }

        toggleDescriptionField();
        toggleCustomCodeField();
        toggleStyleSlideNote();
        toggleCategoryId();
        updateLinkPreview();
        updatePositionImage();

        $('#page_style_content').change(function(event) {
            toggleDescriptionField();
            toggleCustomCodeField();
            toggleCategoryId();
            updatePositionImage();
        });

        $('#page_style_slide').change(function(event) {
            toggleDescriptionField();
            toggleStyleSlideNote();
            updateLinkPreview();
        });

        $('#page_position').change(function(event) {
            updatePositionImage();
            toggleCategoryId();
        });

        $('#page_position_custom').change(function(event) {
            updatePositionImage();
            toggleCategoryId();
        });

    });

});
