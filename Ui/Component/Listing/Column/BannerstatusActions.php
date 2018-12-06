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

namespace Magestore\Bannerslider\Ui\Component\Listing\Column;


use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

/**
 * Class BannerstatusActions
 * @package Magestore\Bannerslider\Ui\Component\Listing\Column
 */
class BannerstatusActions extends \Magestore\Bannerslider\Ui\Component\Listing\Column\AbstractColumn
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * Constructor.
     *
     * @param ContextInterface   $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface       $urlBuilder
     * @param array              $components
     * @param array              $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * prepare item.
     *
     * @param array $item
     *
     * @return $this
     */
    protected function _prepareItem(array & $item) {
        $itemsAction = $this->getData('itemsAction');
        $indexField = $this->getData('config/indexField');

        if (isset($item[$indexField])) {
            foreach ($itemsAction as $key => $itemAction) {
                $path = isset($itemAction['path']) ? $itemAction['path'] : null;
                $itemAction['href'] = $this->urlBuilder->getUrl(
                    $path,
                    [$indexField => $item[$indexField]]
                );
                $item[$this->getData('name')][$key] = $itemAction;
            }
        }

        return $item;
    }
}
