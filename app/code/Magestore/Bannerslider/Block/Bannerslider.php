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
 * Bannerslider Block
 * @category Magestore
 * @package  Magestore_Bannerslider
 * @module   Bannerslider
 * @author   Magestore Developer
 */
class Bannerslider extends \Magento\Framework\View\Element\Template
{
    /**
     * banner slider template
     * @var string
     */
    protected $_template = 'Magestore_Bannerslider::bannerslider.phtml';

    /**
     * Registry object.
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * slider factory.
     *
     * @var \Magestore\Bannerslider\Model\SliderFactory
     */
    protected $_sliderFactory;

    /**
     * category Factory.
     *
     * @var \Magento\Catalog\Model\CategoryFactory
     */
    protected $_categoryFactory;

    /**
     * Banner Factory.
     *
     * @var \Magestore\Bannerslider\Model\BannerFactory
     */
    protected $_bannerFactory;

    /**
     * @var \Magestore\Bannerslider\Model\Resource\Banner\CollectionFactory
     */
    protected $_bannerCollectionFactory;

    /**
     * slider collecion factory.
     *
     * @var \Magestore\Bannerslider\Model\Resource\Slider\CollectionFactory
     */
    protected $_sliderCollectionFactory;

    /**
     * scope config.
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * [__construct description].
     *
     * @param \Magento\Framework\View\Element\Template\Context                $context
     * @param \Magestore\Bannerslider\Model\BannerFactory                     $bannerFactory
     * @param \Magestore\Bannerslider\Model\SliderFactory                     $sliderFactory
     * @param \Magento\Framework\Registry                                     $coreRegistry
     * @param \Magestore\Bannerslider\Model\Resource\Slider\CollectionFactory $sliderCollectionFactory
     * @param \Magestore\Bannerslider\Model\Resource\Banner\CollectionFactory $bannerCollectionFactory
     * @param \Magento\Catalog\Model\CategoryFactory                          $categoryFactory
     * @param \Magento\Store\Model\StoreManagerInterface                      $storeManager
     * @param array                                                           $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magestore\Bannerslider\Model\BannerFactory $bannerFactory,
        \Magestore\Bannerslider\Model\SliderFactory $sliderFactory,
        \Magento\Framework\Registry $coreRegistry,
        \Magestore\Bannerslider\Model\Resource\Slider\CollectionFactory $sliderCollectionFactory,
        \Magestore\Bannerslider\Model\Resource\Banner\CollectionFactory $bannerCollectionFactory,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_bannerFactory = $bannerFactory;
        $this->_sliderFactory = $sliderFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->_sliderCollectionFactory = $sliderCollectionFactory;
        $this->_bannerCollectionFactory = $bannerCollectionFactory;
        $this->_categoryFactory = $categoryFactory;
        $this->_scopeConfig = $context->getScopeConfig();
        $this->_storeManager = $storeManager;
    }

    /**
     * @return
     */
    protected function _toHtml()
    {
        $store = $this->_storeManager->getStore()->getId();

        if ($this->_scopeConfig->getValue(Slider::XML_CONFIG_BANNERSLIDER,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store)) {
            return parent::_toHtml();
        }

        return '';
    }

    /**
     * add child block slider.
     *
     * @param \Magestore\Bannerslider\Model\Resource\Slider\Collection $sliderCollection [description]
     *
     * @return \Magestore\Bannerslider\Block\Bannerslider [description]
     */
    public function appendChildBlockSliders(
        \Magestore\Bannerslider\Model\Resource\Slider\Collection $sliderCollection
    ) {
        foreach ($sliderCollection as $slider) {
            $this->append(
                $this->getLayout()->createBlock(
                    'Magestore\Bannerslider\Block\SliderItem'
                )->setSliderId($slider->getId())
            );
        }

        return $this;
    }

    /**
     * set position for banner slider.
     *
     * @param mixed string|array $position
     */
    public function setPosition($position)
    {
        $sliderCollection = $this->_sliderCollectionFactory
            ->create()
            ->addFieldToFilter('position', $position)
            ->addFieldToFilter('status', Status::STATUS_ENABLED);
        $this->appendChildBlockSliders($sliderCollection);

        return $this;
    }

    /**
     * set position for banner slider.
     *
     * @param mixed string|array $position
     */
    public function setCategoryPosition($position)
    {
        $sliderCollection = $this->_sliderCollectionFactory
            ->create()
            ->addFieldToFilter('position', $position)
            ->addFieldToFilter('status', Status::STATUS_ENABLED);
        $category = $this->_coreRegistry->registry('current_category');
        $categoryPathIds = $category->getPathIds();

        foreach ($sliderCollection as $slider) {
            $sliderCategoryIds = explode(',', $slider->getCategoryIds());
            if (count(array_intersect($categoryPathIds, $sliderCategoryIds)) > 0) {
                $this->append(
                    $this->getLayout()->createBlock(
                        'Magestore\Bannerslider\Block\SliderItem'
                    )->setSliderId($slider->getId())
                );
            }
        }

        return $this;
    }

    /**
     * set position for note.
     */
    public function setPositionNote()
    {
        $sliderCollection = $this->_sliderCollectionFactory
            ->create()
            ->addFieldToFilter('style_content', Slider::STYLE_CONTENT_YES)
            ->addFieldToFilter('style_slide', Slider::STYLESLIDE_SPECIAL_NOTE)
            ->addFieldToFilter('status', Status::STATUS_ENABLED);

        $this->appendChildBlockSliders($sliderCollection);

        return $this;
    }

    /**
     * set popup on home page.
     */
    public function setPopupOnHomePage()
    {
        $sliderCollection = $this->_sliderCollectionFactory
            ->create()
            ->addFieldToFilter('style_content', Slider::STYLE_CONTENT_YES)
            ->addFieldToFilter('style_slide', Slider::STYLESLIDE_POPUP)
            ->addFieldToFilter('status', Status::STATUS_ENABLED);
        $this->appendChildBlockSliders($sliderCollection);

        return $this;
    }
}
