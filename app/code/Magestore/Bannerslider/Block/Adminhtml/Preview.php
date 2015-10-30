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

namespace Magestore\Bannerslider\Block\Adminhtml;

use Magestore\Bannerslider\Model\Slider as SliderModel;

/**
 * Preview Block
 * @category Magestore
 * @package  Magestore_Bannerslider
 * @module   Bannerslider
 * @author   Magestore Developer
 */
class Preview extends \Magento\Backend\Block\Template
{
    const STYLESLIDE_PARAM = 'sliderpreview_id';
    const PREVIEW_NOTE_ID_MIN = 1;
    const PREVIEW_NOTE_ID_MAX = 8;

    /**
     * preview template for slider.
     */
    const STYLESLIDE_EVOLUTION_PREVIEW_TEMPLATE = 'Magestore_Bannerslider::slider/preview/evolution.phtml';
    const STYLESLIDE_SPECIAL_NOTE_PREVIEW_TEMPLATE = 'Magestore_Bannerslider::slider/preview/special/note.phtml';
    const STYLESLIDE_FLEXSLIDER_PREVIEW_TEMPLATE = 'Magestore_Bannerslider::slider/preview/flexslider.phtml';

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Add elements in layout.
     *
     * @return
     */
    protected function _prepareLayout()
    {
        $styleslideParam = $this->getRequest()->getParam(self::STYLESLIDE_PARAM);
        $this->setStyleSlidePreviewTemplate($styleslideParam);

        return parent::_prepareLayout();
    }

    /**
     * set style slide template.
     *
     * @return string|null
     */
    public function setStyleSlidePreviewTemplate($styleslideParam)
    {
        switch ($styleslideParam) {
            case SliderModel::STYLESLIDE_EVOLUTION_ONE:
            case SliderModel::STYLESLIDE_EVOLUTION_TWO:
            case SliderModel::STYLESLIDE_EVOLUTION_THREE:
            case SliderModel::STYLESLIDE_EVOLUTION_FOUR:
                $this->setTemplate(self::STYLESLIDE_EVOLUTION_PREVIEW_TEMPLATE);
                break;
            case SliderModel::STYLESLIDE_SPECIAL_NOTE:
                $this->setTemplate(self::STYLESLIDE_SPECIAL_NOTE_PREVIEW_TEMPLATE);
                break;
            case SliderModel::STYLESLIDE_FLEXSLIDER_ONE:
            case SliderModel::STYLESLIDE_FLEXSLIDER_TWO:
            case SliderModel::STYLESLIDE_FLEXSLIDER_THREE:
            case SliderModel::STYLESLIDE_FLEXSLIDER_FOUR:
                $this->setTemplate(self::STYLESLIDE_FLEXSLIDER_PREVIEW_TEMPLATE);
                break;
        }
    }

    /**
     * get slider evolution transition array.
     *
     * @return array
     */
    public function getSliderEvolutionTransitionArray()
    {
        return [
            SliderModel::STYLESLIDE_EVOLUTION_ONE   => 'explode',
            SliderModel::STYLESLIDE_EVOLUTION_TWO   => ['barLeft', 'barRight'],
            SliderModel::STYLESLIDE_EVOLUTION_THREE => 'square',
            SliderModel::STYLESLIDE_EVOLUTION_FOUR  => 'squareRandom',
        ];
    }
}
