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

use Magestore\Bannerslider\Model\Slider;

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

    /**
     * [$_bannersliderHelper description].
     *
     * @var \Magestore\Bannerslider\Helper\Data
     */
    protected $_bannersliderHelper;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magestore\Bannerslider\Helper\Data $bannersliderHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_bannersliderHelper = $bannersliderHelper;
    }

    /**
     * Add elements in layout.
     *
     * @return
     */
    protected function _prepareLayout()
    {
        $styleslideParam = $this->getRequest()->getParam(self::STYLESLIDE_PARAM);
        $this->setTemplate($this->getStyleSlidePreviewTemplate($styleslideParam));

        return parent::_prepareLayout();
    }

    /**
     * get style slide template.
     *
     * @return string|null
     */
    public function getStyleSlidePreviewTemplate($styleslideParam)
    {
        switch ($styleslideParam) {
            case Slider::STYLESLIDE_EVOLUTION_ONE:
            case Slider::STYLESLIDE_EVOLUTION_TWO:
            case Slider::STYLESLIDE_EVOLUTION_THREE:
            case Slider::STYLESLIDE_EVOLUTION_FOUR:
                return self::STYLESLIDE_EVOLUTION_PREVIEW_TEMPLATE;
                break;
            case Slider::STYLESLIDE_SPECIAL_NOTE:
                return self::STYLESLIDE_SPECIAL_NOTE_PREVIEW_TEMPLATE;
                break;
            case Slider::STYLESLIDE_FLEXSLIDER_ONE:
            case Slider::STYLESLIDE_FLEXSLIDER_TWO:
            case Slider::STYLESLIDE_FLEXSLIDER_THREE:
            case Slider::STYLESLIDE_FLEXSLIDER_FOUR:
                return self::STYLESLIDE_FLEXSLIDER_PREVIEW_TEMPLATE;
                break;
            default:
                return;
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
            Slider::STYLESLIDE_EVOLUTION_ONE => 'explode',
            Slider::STYLESLIDE_EVOLUTION_TWO => ['barLeft', 'barRight'],
            Slider::STYLESLIDE_EVOLUTION_THREE => 'square',
            Slider::STYLESLIDE_EVOLUTION_FOUR => 'squareRandom',
        ];
    }
}
