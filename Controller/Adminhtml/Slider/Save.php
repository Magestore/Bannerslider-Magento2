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

namespace Magestore\Bannerslider\Controller\Adminhtml\Slider;

use Magestore\Bannerslider\Model\Slider;

/**
 * Save Slider action
 * @category Magestore
 * @package  Magestore_Bannerslider
 * @module   Bannerslider
 * @author   Magestore Developer
 */
class Save extends \Magestore\Bannerslider\Controller\Adminhtml\Slider
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $formPostValues = $this->getRequest()->getPostValue();

        if (isset($formPostValues['slider'])) {
            $sliderData = $formPostValues['slider'];
            $sliderId = isset($sliderData['slider_id']) ? $sliderData['slider_id'] : null;
            if (isset($sliderData['style_slide'])) {
                if ($sliderData['style_slide'] == Slider::STYLESLIDE_EVOLUTION_ONE || $sliderData['style_slide'] == Slider::STYLESLIDE_EVOLUTION_THREE ||
                    $sliderData['style_slide'] == Slider::STYLESLIDE_EVOLUTION_TWO || $sliderData['style_slide'] == Slider::STYLESLIDE_EVOLUTION_FOUR
                ) {
                    $sliderData['animationB'] = $sliderData['animationA'];
                } elseif ($sliderData['style_slide'] == Slider::STYLESLIDE_POPUP) {
                    $sliderData['position'] = 'pop-up';
                } elseif ($sliderData['style_slide'] == Slider::STYLESLIDE_SPECIAL_NOTE) {
                    $sliderData['position'] = 'note-allsite';
                }
            }

            if ($sliderData['style_content'] == Slider::STYLE_CONTENT_NO) {
                $sliderData['position'] = $sliderData['position_custom'];
            }

            if (isset($sliderData['category_ids'])) {
                $sliderData['category_ids'] = implode(',', $sliderData['category_ids']);
            }

            $model = $this->_sliderFactory->create();

            $model->load($sliderId);

            $model->setData($sliderData);

            try {
                $model->save();

                if (isset($formPostValues['slider_banner'])) {
                    $bannerGridSerializedInputData = $this->_jsHelper->decodeGridSerializedInput($formPostValues['slider_banner']);
                    $bannerIds = [];
                    foreach ($bannerGridSerializedInputData as $key => $value) {
                        $bannerIds[] = $key;
                        $bannerOrders[] = $value['order_banner_slider'];
                    }

                    $unSelecteds = $this->_bannerCollectionFactory
                        ->create()
                        ->setStoreViewId(null)
                        ->addFieldToFilter('slider_id', $model->getId());
                    if (count($bannerIds)) {
                        $unSelecteds->addFieldToFilter('banner_id', array('nin' => $bannerIds));
                    }

                    foreach ($unSelecteds as $banner) {
                        $banner->setSliderId(0)
                            ->setStoreViewId(null)
                            ->setOrderBanner(0)->save();
                    }

                    $selectBanner = $this->_bannerCollectionFactory
                        ->create()
                        ->setStoreViewId(null)
                        ->addFieldToFilter('banner_id', array('in' => $bannerIds));
                    $i = -1;
                    foreach ($selectBanner as $banner) {
                        $banner->setSliderId($model->getId())
                            ->setStoreViewId(null)
                            ->setOrderBanner($bannerOrders[++$i])->save();
                    }
                }

                $this->messageManager->addSuccess(__('The slider has been saved.'));
                $this->_getSession()->setFormData(false);

                return $this->_getBackResultRedirect($resultRedirect, $model->getId());
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->messageManager->addException($e, __('Something went wrong while saving the slider.'));
            }

            $this->_getSession()->setFormData($formPostValues);

            return $resultRedirect->setPath('*/*/edit', [static::PARAM_CRUD_ID => $sliderId]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
