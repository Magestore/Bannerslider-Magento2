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

namespace Magestore\Bannerslider\Helper;

use Magestore\Bannerslider\Model\Slider;

/**
 * Helper Data
 * @category Magestore
 * @package  Magestore_Bannerslider
 * @module   Bannerslider
 * @author   Magestore Developer
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Backend\Model\UrlInterface
     */
    protected $_backendUrl;

    /**
     * Store manager.
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * category collection factory.
     *
     * @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    protected $_categoryCollectionFactory;

    /**
     * [__construct description].
     *
     * @param \Magento\Framework\App\Helper\Context                      $context              [description]
     * @param \Magento\Directory\Helper\Data                             $directoryData        [description]
     * @param \Magento\Directory\Model\ResourceModel\Country\Collection       $countryCollection    [description]
     * @param \Magento\Directory\Model\ResourceModel\Region\CollectionFactory $regCollectionFactory [description]
     * @param \Magento\Store\Model\StoreManagerInterface                 $storeManager         [description]
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        \Magento\Backend\Model\UrlInterface $backendUrl,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->_backendUrl = $backendUrl;
        $this->_storeManager = $storeManager;
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
    }

    /**
     * get Base Url Media.
     *
     * @param string $path   [description]
     * @param bool   $secure [description]
     *
     * @return string [description]
     */
    public function getBaseUrlMedia($path = '', $secure = false)
    {
        return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA, $secure) . $path;
    }

    /**
     * get categories array.
     *
     * @return array
     */
    public function getCategoriesArray()
    {
        $categoriesArray = $this->_categoryCollectionFactory->create()
            ->addAttributeToSelect('name')
            ->addAttributeToSort('path', 'asc')
            ->load()
            ->toArray();

        $categories = array();
        foreach ($categoriesArray as $categoryId => $category) {
            if (isset($category['name']) && isset($category['level'])) {
                $categories[] = array(
                    'label' => $category['name'],
                    'level' => $category['level'],
                    'value' => $categoryId,
                );
            }
        }

        return $categories;
    }

    /**
     * get Slider Banner Url
     * @return string
     */
    public function getSliderBannerUrl()
    {
        return $this->_backendUrl->getUrl('*/*/banners', ['_current' => true]);
    }

    /**
     * get Backend Url
     * @param  string $route
     * @param  array  $params
     * @return string
     */
    public function getBackendUrl($route = '', $params = ['_current' => true])
    {
        return $this->_backendUrl->getUrl($route, $params);
    }

    /**
     * getSliderModeAvailable
     * @return array
     */
    public function getSliderModeAvailable()
    {
        return [
            Slider::STYLESLIDE_EVOLUTION_ONE => 'Slider Evolution Default',
            Slider::STYLESLIDE_EVOLUTION_TWO => 'Slider Evolution Caborno',
            Slider::STYLESLIDE_EVOLUTION_THREE => 'Slider Evolution Minimalist',
            Slider::STYLESLIDE_EVOLUTION_FOUR => 'Slider Evolution Fresh',
            Slider::STYLESLIDE_POPUP => 'Pop up on Home page',
            Slider::STYLESLIDE_SPECIAL_NOTE => 'Note displayed on all pages',
            Slider::STYLESLIDE_FLEXSLIDER_ONE => 'FlexSlider 1',
            Slider::STYLESLIDE_FLEXSLIDER_TWO => 'FlexSlider 2',
            Slider::STYLESLIDE_FLEXSLIDER_THREE => 'FlexSlider 3',
            Slider::STYLESLIDE_FLEXSLIDER_FOUR => 'FlexSlider 4',
        ];
    }

    /**
     *  get Style Slider
     * @return array
     */
    public function getStyleSlider()
    {
        return [
            [
                'label' => __('--------- Please choose style -------'),
                'value' => '',
            ],
            [
                'label' => __('Special Slider'),
                'value' => [
                    ['value' => Slider::STYLESLIDE_POPUP, 'label' => __('Pop up on Home page')],
                    ['value' => Slider::STYLESLIDE_SPECIAL_NOTE, 'label' => __('Note displayed on all pages')],
                ],
            ],
            [
                'label' => __('Unresponsive Slider'),
                'value' => [
                    [
                        'label' => __('Slider Evolution Default'),
                        'value' => Slider::STYLESLIDE_EVOLUTION_ONE,
                    ],
                    [
                        'label' => __('Slider Evolution Caborno'),
                        'value' => Slider::STYLESLIDE_EVOLUTION_TWO,
                    ],
                    [
                        'label' => __('Slider Evolution Minimalist'),
                        'value' => Slider::STYLESLIDE_EVOLUTION_THREE,
                    ],
                    [
                        'label' => __('Slider Evolution Fresh'),
                        'value' => Slider::STYLESLIDE_EVOLUTION_FOUR,
                    ],
                ],
            ],
            [
                'label' => __('Responsive Slider'),
                'value' => [
                    [
                        'label' => __('FlexSlider 1'),
                        'value' => Slider::STYLESLIDE_FLEXSLIDER_ONE,
                    ],
                    [
                        'label' => __('FlexSlider 2'),
                        'value' => Slider::STYLESLIDE_FLEXSLIDER_TWO,
                    ],
                    [
                        'label' => __('FlexSlider 3'),
                        'value' => Slider::STYLESLIDE_FLEXSLIDER_THREE,
                    ],
                    [
                        'label' => __('FlexSlider 4'),
                        'value' => Slider::STYLESLIDE_FLEXSLIDER_FOUR,
                    ],
                ],
            ],
        ];
    }

    /**
     * get Animation A
     * @return array
     */
    public function getAnimationA()
    {
        return [
            [
                'label' => __('Fade'),
                'value' => 'fade',
            ],
            [
                'label' => __('Square'),
                'value' => 'squarerandom',
            ],
            [
                'label' => __('Bar'),
                'value' => 'bar',
            ],
            [
                'label' => __('Rain'),
                'value' => 'rain',
            ],
        ];
    }

    /**
     * get Animation B
     * @return array
     */
    public function getAnimationB()
    {
        return [
            [
                'label' => __('Slide'),
                'value' => 'slide',
            ],
            [
                'label' => __('Fade'),
                'value' => 'fade',
            ],
        ];
    }

    /**
     * get Option Color
     * @return array
     */
    public function getOptionColor()
    {
        return [
            ['label' => __('Yellow'), 'value' => '#f7d700'],
            ['label' => __('Red'), 'value' => '#dd0707'],
            ['label' => __('Orange'), 'value' => '#ee5f00'],
            ['label' => __('Green'), 'value' => '#83ba00'],
            ['label' => __('Blue'), 'value' => '#23b8ff'],
            ['label' => __('Gray'), 'value' => '#999'],
        ];
    }

    /**
     * get Block Ids To Options Array
     * @return array
     */
    public function getBlockIdsToOptionsArray()
    {
        return [
            [
                'label' => __('------- Please choose position -------'),
                'value' => '',
            ],
            [
                'label' => __('Popular positions'),
                'value' => [
                    ['value' => 'cms-page-content-top', 'label' => __('Homepage-Content-Top')],
                ],
            ],
            [
                'label' => __('Default for using in CMS page template'),
                'value' => [
                    ['value' => 'custom', 'label' => __('Custom')],
                ],
            ],
            [
                'label' => __('General (will be disaplyed on all pages)'),
                'value' => [
                    ['value' => 'sidebar-right-top', 'label' => __('Sidebar-Top-Right')],
                    ['value' => 'sidebar-right-bottom', 'label' => __('Sidebar-Bottom-Right')],
                    ['value' => 'sidebar-left-top', 'label' => __('Sidebar-Top-Left')],
                    ['value' => 'sidebar-left-bottom', 'label' => __('Sidebar-Bottom-Left')],
                    ['value' => 'content-top', 'label' => __('Content-Top')],
                    ['value' => 'menu-top', 'label' => __('Menu-Top')],
                    ['value' => 'menu-bottom', 'label' => __('Menu-Bottom')],
                    ['value' => 'page-bottom', 'label' => __('Page-Bottom')],
                ],
            ],
            [
                'label' => __('Catalog and product'),
                'value' => [
                    ['value' => 'catalog-sidebar-right-top', 'label' => __('Catalog-Sidebar-Top-Right')],
                    ['value' => 'catalog-sidebar-right-bottom', 'label' => __('Catalog-Sidebar-Bottom-Right')],
                    ['value' => 'catalog-sidebar-left-top', 'label' => __('Catalog-Sidebar-Top-Left')],
                    ['value' => 'catalog-sidebar-left-bottom', 'label' => __('Catalog-Sidebar-Bottom-Left')],
                    ['value' => 'catalog-content-top', 'label' => __('Catalog-Content-Top')],
                    ['value' => 'catalog-menu-top', 'label' => __('Catalog-Menu-Top')],
                    ['value' => 'catalog-menu-bottom', 'label' => __('Catalog-Menu-Bottom')],
                    ['value' => 'catalog-page-bottom', 'label' => __('Catalog-Page-Bottom')],
                ],
            ],
            [
                'label' => __('Category only'),
                'value' => [
                    ['value' => 'category-sidebar-right-top', 'label' => __('Category-Sidebar-Top-Right')],
                    ['value' => 'category-sidebar-right-bottom', 'label' => __('Category-Sidebar-Bottom-Right')],
                    ['value' => 'category-sidebar-left-top', 'label' => __('Category-Sidebar-Top-Left')],
                    ['value' => 'category-sidebar-left-bottom', 'label' => __('Category-Sidebar-Bottom-Left')],
                    ['value' => 'category-content-top', 'label' => __('Category-Content-Top')],
                    ['value' => 'category-menu-top', 'label' => __('Category-Menu-Top')],
                    ['value' => 'category-menu-bottom', 'label' => __('Category-Menu-Bottom')],
                    ['value' => 'category-page-bottom', 'label' => __('Category-Page-Bottom')],
                ],
            ],
            [
                'label' => __('Product only'),
                'value' => [
                    ['value' => 'product-sidebar-right-top', 'label' => __('Product-Sidebar-Top-Right')],
                    ['value' => 'product-sidebar-right-bottom', 'label' => __('Product-Sidebar-Bottom-Right')],
                    ['value' => 'product-sidebar-left-top', 'label' => __('Product-Sidebar-Top-Left')],
                    ['value' => 'product-content-top', 'label' => __('Product-Content-Top')],
                    ['value' => 'product-menu-top', 'label' => __('Product-Menu-Top')],
                    ['value' => 'product-menu-bottom', 'label' => __('Product-Menu-Bottom')],
                    ['value' => 'product-page-bottom', 'label' => __('Product-Page-Bottom')],
                ],
            ],
            [
                'label' => __('Customer'),
                'value' => [
                    ['value' => 'customer-content-top', 'label' => __('Customer-Content-Top')],
                    ['value' => 'customer-sidebar-main-top', 'label' => __('Customer-Siderbar-Main-Top')],
                    ['value' => 'customer-sidebar-main-bottom', 'label' => __('Customer-Siderbar-Main-Bottom')],
                ],
            ],
            [
                'label' => __('Cart & Checkout'),
                'value' => [
                    ['value' => 'cart-content-top', 'label' => __('Cart-Content-Top')],
                    ['value' => 'checkout-content-top', 'label' => __('Checkout-Content-Top')],
                ],
            ],
        ];
    }

    /**
     * get Available Positions
     * @return array
     */
    public function getAvailablePositions()
    {
        return [
            'pop-up' => __('Pop up at Home page'),
            'note-allsite' => __('Note will be displayed on all pages'),
            'cms-page-content-top' => __('Homepage content top'),
            'custom' => __('Custom'),
            'sidebar-right-top' => __('Sidebar-Top-Right(all pages)'),
            'sidebar-right-bottom' => __('Sidebar-Bottom-Right (all pages)'),
            'sidebar-left-top' => __('Sidebar-Top-Left(all pages)'),
            'sidebar-left-bottom' => __('Sidebar-Bottom-Left(all pages)'),
            'content-top' => __('Content-Top(all pages)'),
            'menu-top' => __('Menu-Top(all pages)'),
            'menu-bottom' => __('Menu-Bottom(all pages)'),
            'page-bottom' => __('Page-Bottom(all pages)'),
            'catalog-sidebar-right-top' => __(' Catalog-Sidebar-Top-Right'),
            'catalog-sidebar-right-bottom' => __('Catalog-Sidebar-Bottom-Right'),
            'catalog-sidebar-left-top' => __('Catalog-Sidebar-Top-Left'),
            'catalog-sidebar-left-bottom' => __('Catalog-Sidebar-Bottom-Left'),
            'catalog-content-top' => __('Catalog-Content-Top'),
            'catalog-menu-top' => __('Catalog-Menu-Top'),
            'catalog-menu-bottom' => __('Catalog-Menu-Bottom'),
            'catalog-page-bottom' => __('Catalog-Page-Bottom'),
            'category-sidebar-right-top' => __('Category-Sidebar-Top-Right'),
            'category-sidebar-right-bottom' => __('Category-Sidebar-Bottom-Right'),
            'category-sidebar-left-top' => __('Category-Sidebar-Top-Left'),
            'category-sidebar-left-bottom' => __('Category-Sidebar-Bottom-Left'),
            'category-content-top' => __('Category-Content-Top'),
            'category-menu-top' => __('Category-Menu-Top'),
            'category-menu-bottom' => __('Category-Menu-Bottom'),
            'category-page-bottom' => __('Category-Page-Bottom'),
            'product-sidebar-right-top' => __('Product-Sidebar-Top-Right'),
            'product-sidebar-right-bottom' => __('Product-Sidebar-Bottom-Right'),
            'product-sidebar-left-top' => __('Product-Sidebar-Top-Left'),
            'product-sidebar-left-bottom' => __('Product-Sidebar-Bottom-Left'),
            'product-content-top' => __('Product-Content-Top'),
            'product-menu-top' => __('Product-Menu-Top'),
            'product-menu-bottom' => __('Product-Menu-Bottom'),
            'product-page-bottom' => __('Product-Page-Bottom'),
            'customer-content-top' => __('Customer-Content-Top'),
            'cart-content-top' => __('Cart-Content-Top'),
            'checkout-content-top' => __('Checkout-Content-Top'),
            'customer-sidebar-main-top' => __('Customer-Siderbar-Main-Top'),
            'customer-sidebar-main-bottom' => __('Customer-Siderbar-Main-Bottom'),
        ];
    }

    /**
     * get list slider for preview.
     *
     * @return []
     */
    public function getCoreSlider()
    {
        return [
            [
                'label' => __('Slider Evolution Default'),
                'value' => Slider::STYLESLIDE_EVOLUTION_ONE,
            ],
            [
                'label' => __('Slider Evolution Caborno'),
                'value' => Slider::STYLESLIDE_EVOLUTION_TWO,
            ],
            [
                'label' => __('Slider Evolution Minimalist'),
                'value' => Slider::STYLESLIDE_EVOLUTION_THREE,
            ],
            [
                'label' => __('Slider Evolution Fresh'),
                'value' => Slider::STYLESLIDE_EVOLUTION_FOUR,
            ],
            [
                'label' => __('Note display on all pages'),
                'value' => Slider::STYLESLIDE_SPECIAL_NOTE,
            ],
            [
                'label' => __('FlexSlider 1'),
                'value' => Slider::STYLESLIDE_FLEXSLIDER_ONE,
            ],
            [
                'label' => __('FlexSlider 2'),
                'value' => Slider::STYLESLIDE_FLEXSLIDER_TWO,
            ],
            [
                'label' => __('FlexSlider 3'),
                'value' => Slider::STYLESLIDE_FLEXSLIDER_THREE,
            ],
            [
                'label' => __('FlexSlider 4'),
                'value' => Slider::STYLESLIDE_FLEXSLIDER_FOUR,
            ],
        ];
    }
}
