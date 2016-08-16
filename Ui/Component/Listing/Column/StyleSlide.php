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
class StyleSlide extends \Magestore\BannerSlider\Ui\Component\Listing\Column\AbstractColumn
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
//        $style = $item[$this->getData('name')];
//        switch ($style) {
//            case 1:
//                $label = 'Slider Evolution Default';
//                break;
//            case 2:
//                $label = 'Slider Evolution Caborno';
//                break;
//            case 3:
//                $label = 'Slider Evolution Minimalist';
//                break;
//            case 4:
//                $label = 'Slider Evolution Fresh';
//                break;
//            case 5:
//                $label = 'Pop up on Home page';
//                break;
//            case 6:
//                $label = 'Note displayed on all pages';
//                break;
//            case 7:
//                $label = 'FlexSlider 1';
//                break;
//            case 8:
//                $label = 'FlexSlider 2';
//                break;
//            case 9:
//                $label = 'FlexSlider 3';
//                break;
//            case 10:
//                $label = 'FlexSlider 4';
//                break;
//
//            default:
//                $label= '';
//        }
//
//        if (isset($item[$this->getData('name')])) {
//            if ($item[$this->getData('name')]) {
//
//                $item[$this->getData('name')] = sprintf(
//                    '%s',
//                    $label
//                );
//            } else {
//                $item[$this->getData('name')] = '';
//            }
//        }
//
//        return $item;
    }
}
