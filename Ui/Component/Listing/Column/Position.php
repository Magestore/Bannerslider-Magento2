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
 * @package     Magestore_BannerSlider
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */

namespace Magestore\BannerSlider\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

/**
 * @category Magestore
 * @package  Magestore_Storelocator
 * @module   Storelocator
 * @author   Magestore Developer
 */
class Position extends \Magestore\BannerSlider\Ui\Component\Listing\Column\AbstractColumn
{

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magestore\Bannerslider\Model\SliderFactory
     */
    protected $_sliderFactory;
    /**
     * Constructor.
     *
     * @param ContextInterface   $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array              $components
     * @param array              $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->_storeManager = $storeManager;
    }

    /**
     * prepare item.
     *
     * @param array $item
     *
     * @return array
     */
    protected function _prepareItem(array & $item)
    {
        $position = $item[$this->getData('name')];
        switch ($position) {
            case "pop-up":
                $label = 'Pop up at Home page';
                break;
            case "note-allsite":
                $label = 'Note will be displayed on all pages';
                break;
            case "cms-page-content-top":
                $label = 'Homepage content top';
                break;
            case "custom":
                $label = 'Custom';
                break;
             case "sidebar-right-top":
                $label = 'Sidebar-Top-Right(all pages)';
                break;
             case "sidebar-right-bottom":
                $label = 'Sidebar-Bottom-Right (all pages)';
                break;
             case "sidebar-left-top":
                $label = 'Sidebar-Top-Left(all pages)';
                break;
             case "sidebar-left-bottom":
                $label = 'Sidebar-Bottom-Left(all pages)';
                break;
             case "content-top":
                $label = 'Content-Top(all pages)';
                break;
             case "menu-top":
                $label = 'Menu-Top(all pages)';
                break;
             case "menu-bottom":
                $label = 'Menu-Bottom(all pages)';
                break;
             case "page-bottom":
                $label = 'Page-Bottom(all pages)';
                break;
             case "catalog-sidebar-right-top":
                $label = ' Catalog-Sidebar-Top-Right';
                break;
             case "catalog-sidebar-right-bottom":
                $label = 'Catalog-Sidebar-Bottom-Right';
                break;
            case "catalog-sidebar-left-top":
                $label = 'Catalog-Sidebar-Top-Left';
                break;
            case "catalog-sidebar-left-bottom":
                $label = 'Catalog-Sidebar-Bottom-Left';
                break;
            case "catalog-content-top":
                $label = 'Catalog-Content-Top';
                break;
            case "catalog-menu-top":
                $label = 'Catalog-Menu-Top';
                break;
            case "catalog-menu-bottom":
                $label = 'Catalog-Menu-Bottom';
                break;
            case "catalog-page-bottom":
                $label = 'Catalog-Page-Bottom';
                break;
            case "catalog-page-bottom":
                $label = 'Catalog-Page-Bottom';
                break;
            case "category-sidebar-right-top":
                $label = 'Category-Sidebar-Top-Right';
                break;
            case "category-sidebar-right-bottom":
                $label = 'Category-Sidebar-Bottom-Right';
                break;
            case "category-sidebar-left-top":
                $label = 'Category-Sidebar-Top-Left';
                break;
            case "category-sidebar-left-bottom":
                $label = 'Category-Sidebar-Bottom-Left';
                break;
            case "category-content-top":
                $label = 'Category-Content-Top';
                break;
            case "category-menu-top":
                $label = 'Category-Menu-Top';
                break;
            case "category-menu-top":
                $label = 'Category-Menu-Top';
                break;
            case "category-menu-bottom":
                $label = 'Category-Menu-Bottom';
                break;
            case "category-page-bottom":
                $label = 'Category-Page-Bottom';
                break;
            case "product-sidebar-right-top":
                $label = 'Product-Sidebar-Top-Right';
                break;
            case "product-sidebar-right-bottom":
                $label = 'Product-Sidebar-Bottom-Right';
                break;
            case "product-sidebar-right-bottom":
                $label = 'Product-Sidebar-Bottom-Right';
                break;
            case "product-sidebar-left-top":
                $label = 'Product-Sidebar-Top-Left';
                break;
            case "product-sidebar-left-bottom":
                $label = 'Product-Sidebar-Bottom-Left';
                break;
            case "product-content-top":
                $label = 'Product-Content-Top';
                break;
            case "product-menu-top":
                $label = 'Product-Menu-Top';
                break;
             case "product-menu-top":
                $label = 'Product-Menu-Top';
                break;
             case "product-menu-bottom":
                $label = 'Product-Menu-Bottom';
                break;
             case "product-page-bottom":
                $label = 'Product-Page-Bottom';
                break;
             case "customer-content-top":
                $label = 'Customer-Content-Top';
                break;
            case "customer-content-top":
                $label = 'Customer-Content-Top';
                break;
            case "cart-content-top":
                $label = 'Cart-Content-Top';
                break;
            case "checkout-content-top":
                $label = 'Checkout-Content-Top';
                break;
            case "customer-sidebar-main-top":
                $label = 'Customer-Siderbar-Main-Top';
                break;
            case "customer-sidebar-main-bottom":
                $label = 'Customer-Siderbar-Main-Bottom';
                break;


            default:
                $label= '';
        }

        if (isset($item[$this->getData('name')])) {
            if ($item[$this->getData('name')]) {

                $item[$this->getData('name')] = sprintf(
                    '%s',
                    $label
                );
            } else {
                $item[$this->getData('name')] = '';
            }
        }

        return $item;
    }
}
