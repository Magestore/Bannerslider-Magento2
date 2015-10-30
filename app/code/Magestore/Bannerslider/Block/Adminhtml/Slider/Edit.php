<?php

/**
 * Magestore
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magestore.com license that is
 * available through the world-wide-web at this URL:
 * http://www.magestore.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Magestore
 * @package     Magestore_Bannerslider
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */

namespace Magestore\Bannerslider\Block\Adminhtml\Slider;

/**
 * Slider block edit form container.
 * @category Magestore
 * @package  Magestore_Bannerslider
 * @module   Bannerslider
 * @author   Magestore Developer
 */
class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * Core registry.
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @param Context $context
     * @param array   $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }
    protected function _construct()
    {
        $this->_objectId = 'slider_id';
        $this->_blockGroup = 'Magestore_Bannerslider';
        $this->_controller = 'adminhtml_slider';

        parent::_construct();

        $this->buttonList->update('save', 'label', __('Save Slider'));
        $this->buttonList->update('delete', 'label', __('Delete'));

        if ($this->getSlider()->getId()) {
            $this->buttonList->add(
                'create_banner',
                [
                    'label' => __('Create Banner'),
                    'class' => 'add',
                    'onclick' => 'openBannerPopupWindow(\''.$this->getCreateBannerUrl().'\')',
                ],
                1
            );
        }

        $this->buttonList->add(
            'save_and_continue',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
                    ],
                ],
            ],
            10
        );

        /*
         * Note by: Nguyen Huu Tien (Email: tien.uet.qh2011@gmail.com,  Skype : zerokool12a8)
         * javascript variable
         * create_banner_popupwindow : window popup
         * create_banner_popupwindow.banner_id : Id of banner after creating in popup
         * bannerGridJsObject : grid object
         * bannerGridJsObject.reloadParams['banner[]'] : An array contain Ids of banners, ex. Array [ "2", "30", "31", "32", .. ]
         * edit_form: form
         * edit_form.slider_banner: input for serialization
         *
         * See more at file magento2root/lib/web/mage/adminhtml/grid.js
         */
        $this->_formScripts[] = "
			require(['jquery'], function($){
				window.openBannerPopupWindow = function (url) {
					var left = ($(document).width()-1000)/2, height= $(document).height();
					var create_banner_popupwindow = window.open(url, '_blank','width=1000,resizable=1,scrollbars=1,toolbar=1,'+'left='+left+',height='+height);
					var windowFocusHandle = function(){
						if (create_banner_popupwindow.closed) {
							if (typeof bannerGridJsObject !== 'undefined' && create_banner_popupwindow.banner_id) {
								bannerGridJsObject.reloadParams['banner[]'].push(create_banner_popupwindow.banner_id + '');
								$(edit_form.slider_banner).val($(edit_form.slider_banner).val() + '&' + create_banner_popupwindow.banner_id + '=' + Base64.encode('order_banner_slider=0'));
				       			bannerGridJsObject.setPage(create_banner_popupwindow.banner_id);
				       		}
				       		$(window).off('focus',windowFocusHandle);
						} else {
							$(create_banner_popupwindow).trigger('focus');
							create_banner_popupwindow.alert('".__('You have to save banner and close this window!')."');
						}
					}
					$(window).focus(windowFocusHandle);
				}
			});
		";
    }

    public function getSlider()
    {
        return $this->_coreRegistry->registry('slider');
    }

    /**
     * Retrieve the save and continue edit Url.
     *
     * @return string
     */
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl(
            '*/*/save',
            ['_current' => true, 'back' => 'edit', 'tab' => '{{tab_id}}']
        );
    }

    /**
     * get create banner url.
     *
     * @return string
     */
    public function getCreateBannerUrl()
    {
        return $this->getUrl('*/banner/new', ['current_slider_id' => $this->getSlider()->getId()]);
    }
}
