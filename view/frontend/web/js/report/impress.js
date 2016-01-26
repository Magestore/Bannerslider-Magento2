/**
 * @File Name: impress.js
 * @File Path: /home/zero/public_html/magento2/1.0.0-beta-sample-15-7/v1/app/code/Magestore/Bannerslider/view/frontend/web/js/report/impress.js
 * @Author: zerokool - Nguyen Huu Tien
 * @Email: tien.uet.qh2011@gmail.com
 * @Date:   2015-07-27 15:47:56
 * @Last Modified by:   zero
 * @Last Modified time: 2015-09-26 16:17:19
 */

'use strict';
define([
    'jquery',
    'jquery/ui'
], function($) {
    "use strict";

    $.widget('magestore.impress', {
        options: {
            url: '',
            slider_id: '',
        },

        _create: function() {
            var o = this.options;
            $.ajax({
                url: o.url,
                type: 'POST',
                dataType: 'html',
                data: {
                    slider_id: o.slider_id
                },
            });
        },
    });
    return $.magestore.impress;
});
