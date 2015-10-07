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

namespace Magestore\Bannerslider\Block;

use Magestore\Bannerslider\Model\Slider;
use Magestore\Bannerslider\Model\Status;

/**
 * Slider item.
 * @category Magestore
 * @package  Magestore_Bannerslider
 * @module   Bannerslider
 * @author   Magestore Developer
 */
class SliderItem extends \Magento\Framework\View\Element\Template
{
    /**
     * template for evolution slider.
     */
    const STYLESLIDE_EVOLUTION_TEMPLATE = 'Magestore_Bannerslider::slider/evolution.phtml';

    /**
     * template for popup.
     */
    const STYLESLIDE_POPUP_TEMPLATE = 'Magestore_Bannerslider::slider/popup.phtml';

    /**
     * template for note slider.
     */
    const STYLESLIDE_SPECIAL_NOTE_TEMPLATE = 'Magestore_Bannerslider::slider/special/note.phtml';

    /**
     * template for flex slider.
     */
    const STYLESLIDE_FLEXSLIDER_TEMPLATE = 'Magestore_Bannerslider::slider/flexslider.phtml';

    /**
     * template for custom slider.
     */
    const STYLESLIDE_CUSTOM_TEMPLATE = 'Magestore_Bannerslider::slider/custom.phtml';

    /**
     * Date conversion model.
     *
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_stdlibDateTime;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * slider factory.
     *
     * @var \Magestore\Bannerslider\Model\SliderFactory
     */
    protected $_sliderFactory;

    /**
     * slider model.
     *
     * @var \Magestore\Bannerslider\Model\Slider
     */
    protected $_slider;

    /**
     * slider id.
     *
     * @var int
     */
    protected $_sliderId;

    /**
     * banner slider helper.
     *
     * @var \Magestore\Bannerslider\Helper\Data
     */
    protected $_bannersliderHelper;

    /**
     * @var \Magestore\Bannerslider\Model\Resource\Banner\CollectionFactory
     */
    protected $_bannerCollectionFactory;

    /**
     * scope config.
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * stdlib timezone.
     *
     * @var \Magento\Framework\Stdlib\DateTime\Timezone
     */
    protected $_stdTimezone;

    /**
     * [__construct description].
     *
     * @param \Magento\Framework\View\Element\Template\Context                $context
     * @param \Magestore\Bannerslider\Model\Resource\Banner\CollectionFactory $bannerCollectionFactory
     * @param \Magestore\Bannerslider\Model\SliderFactory                     $sliderFactory
     * @param \Magestore\Bannerslider\Model\Slider                            $slider
     * @param \Magento\Framework\Stdlib\DateTime\DateTime                     $stdlibDateTime
     * @param \Magestore\Bannerslider\Helper\Data                             $bannersliderHelper
     * @param \Magento\Framework\ObjectFactory                                $objectFactory
     * @param \Magento\Store\Model\StoreManagerInterface                      $storeManager
     * @param \Magento\Framework\Stdlib\DateTime\Timezone                     $_stdTimezone
     * @param array                                                           $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magestore\Bannerslider\Model\Resource\Banner\CollectionFactory $bannerCollectionFactory,
        \Magestore\Bannerslider\Model\SliderFactory $sliderFactory,
        \Magestore\Bannerslider\Model\Slider $slider,
        \Magento\Framework\Stdlib\DateTime\DateTime $stdlibDateTime,
        \Magestore\Bannerslider\Helper\Data $bannersliderHelper,
        \Magento\Framework\ObjectFactory $objectFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Stdlib\DateTime\Timezone $_stdTimezone,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_sliderFactory = $sliderFactory;
        $this->_slider = $slider;
        $this->_stdlibDateTime = $stdlibDateTime;
        $this->_bannersliderHelper = $bannersliderHelper;
        $this->_storeManager = $storeManager;
        $this->_bannerCollectionFactory = $bannerCollectionFactory;
        $this->_scopeConfig = $context->getScopeConfig();
        $this->_stdTimezone = $_stdTimezone;
    }

    /**
     * @return
     */
    protected function _toHtml()
    {
        $store = $this->_storeManager->getStore()->getId();

        $configEnable = $this->_scopeConfig
            ->getValue(Slider::XML_CONFIG_BANNERSLIDER, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store);
        if (!$configEnable || $this->_slider->getStatus() === Status::STATUS_DISABLED || !$this->_slider->getId() 
            || !$this->getBannerCollection()->getSize()) {
            return '';
        }

        return parent::_toHtml();
    }

    /**
     * set slider Id and set template.
     *
     * @param int $sliderId
     */
    public function setSliderId($sliderId)
    {
        $this->_sliderId = $sliderId;

        $slider = $this->_sliderFactory->create()->load($this->_sliderId);
        if ($slider->getId()) {
            $this->setSlider($slider);

            if ($slider->getStyleContent() == Slider::STYLE_CONTENT_NO) {
                $this->setTemplate(Slider::STYLESLIDE_CUSTOM_TEMPLATE);
            } else {
                $this->setTemplate($this->getStyleSlideTemplate($slider->getStyleSlide()));
            }
        }

        return $this;
    }

    /**
     * get style slide template.
     *
     * @param int $styleSlideId
     *
     * @return string
     */
    public function getStyleSlideTemplate($styleSlideId)
    {
        switch ($styleSlideId) {
            //Evolution slide
            case Slider::STYLESLIDE_EVOLUTION_ONE:
            case Slider::STYLESLIDE_EVOLUTION_TWO:
            case Slider::STYLESLIDE_EVOLUTION_THREE:
            case Slider::STYLESLIDE_EVOLUTION_FOUR:
                return self::STYLESLIDE_EVOLUTION_TEMPLATE;
                break;

            case Slider::STYLESLIDE_POPUP:
                return self::STYLESLIDE_POPUP_TEMPLATE;
                break;
            //Note all page
            case Slider::STYLESLIDE_SPECIAL_NOTE:
                return self::STYLESLIDE_SPECIAL_NOTE_TEMPLATE;
                break;

            // Flex slide
            default:
                return self::STYLESLIDE_FLEXSLIDER_TEMPLATE;
                break;
        }
    }

    public function isShowTitle()
    {
        return $this->_slider->getShowTitle() == Slider::SHOW_TITLE_YES ? true : false;
    }

    /**
     * get banner collection of slider.
     *
     * @return \Magestore\Bannerslider\Model\Resource\Banner\Collection
     */
    public function getBannerCollection()
    {
        $storeViewId = $this->_storeManager->getStore()->getId();
        $dateTimeNow = $this->_stdTimezone->date()->format('Y-m-d H:i:s');

        $bannerCollection = $this->_bannerCollectionFactory->create()
            ->setStoreViewId($storeViewId)
            ->addFieldToFilter('slider_id', $this->_slider->getId())
            ->addFieldToFilter('status', Status::STATUS_ENABLED)
            ->addFieldToFilter('start_time', ['lteq' => $dateTimeNow])
            ->addFieldToFilter('end_time', ['gteq' => $dateTimeNow])
            ->setOrder('order_banner', 'ASC');

        if ($this->_slider->getSortType() == Slider::SORT_TYPE_RANDOM) {
            $bannerCollection->getSelect()->orderRand('main_table.banner_id');
        }

        return $bannerCollection;
    }

    /**
     * get first banner.
     *
     * @return \Magestore\Bannerslider\Model\Banner
     */
    public function getFirstBannerItem()
    {
        return $this->getBannerCollection()
            ->setPageSize(1)
            ->setCurPage(1)
            ->getFirstItem();
    }

    /**
     * get position note.
     *
     * @return string
     */
    public function getPositionNote()
    {
        return $this->_slider->getPositionNoteCode();
    }

    /**
     * set slider model.
     *
     * @param \Magestore\Bannerslider\Model\Slider $slider [description]
     */
    public function setSlider(\Magestore\Bannerslider\Model\Slider $slider)
    {
        $this->_slider = $slider;

        return $this;
    }

    /**
     * @return \Magestore\Bannerslider\Model\Slider
     */
    public function getSlider()
    {
        return $this->_slider;
    }

    /**
     * get banner image url.
     *
     * @param \Magestore\Bannerslider\Model\Banner $banner
     *
     * @return string
     */
    public function getBannerImageUrl(\Magestore\Bannerslider\Model\Banner $banner)
    {
        return $this->_bannersliderHelper->getBaseUrlMedia($banner->getImage());
    }

    /**
     * get flexslider html id.
     *
     * @return string
     */
    public function getFlexsliderHtmlId()
    {
        return 'magestore-bannerslider-flex-slider-'.$this->getSlider()->getId().$this->_stdlibDateTime->gmtTimestamp();
    }
}
