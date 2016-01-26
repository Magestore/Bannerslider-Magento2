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

namespace Magestore\Bannerslider\Block\Adminhtml\Slider\Edit\Tab;

use Magestore\Bannerslider\Model\Status;

/**
 * Banners tab.
 * @category Magestore
 * @package  Magestore_Bannerslider
 * @module   Bannerslider
 * @author   Magestore Developer
 */
class Banners extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * banner factory.
     *
     * @var \Magestore\Bannerslider\Model\ResourceModel\Banner\CollectionFactory
     */
    protected $_bannerCollectionFactory;

    /**
     * [__construct description].
     *
     * @param \Magento\Backend\Block\Template\Context                         $context
     * @param \Magento\Backend\Helper\Data                                    $backendHelper
     * @param \Magestore\Bannerslider\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory
     * @param array                                                           $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magestore\Bannerslider\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory,
        array $data = []
    ) {
        $this->_bannerCollectionFactory = $bannerCollectionFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * _construct
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('bannerGrid');
        $this->setDefaultSort('banner_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        if ($this->getRequest()->getParam('id')) {
            $this->setDefaultFilter(array('in_banner' => 1));
        }
    }

    /**
     * add Column Filter To Collection
     */
    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_banner') {
            $bannerIds = $this->_getSelectedBanners();

            if (empty($bannerIds)) {
                $bannerIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('banner_id', array('in' => $bannerIds));
            } else {
                if ($bannerIds) {
                    $this->getCollection()->addFieldToFilter('banner_id', array('nin' => $bannerIds));
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }

        return $this;
    }

    /**
     * prepare collection
     */
    protected function _prepareCollection()
    {
        /** @var \Magestore\Bannerslider\Model\ResourceModel\Banner\Collection $collection */
        $collection = $this->_bannerCollectionFactory->create()->setStoreViewId(null);
        $collection->setIsLoadSliderTitle(TRUE);

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * @return $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'in_banner',
            [
                'header_css_class' => 'a-center',
                'type' => 'checkbox',
                'name' => 'in_banner',
                'align' => 'center',
                'index' => 'banner_id',
                'values' => $this->_getSelectedBanners(),
            ]
        );

        $this->addColumn(
            'banner_id',
            [
                'header' => __('Banner ID'),
                'type' => 'number',
                'index' => 'banner_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'name',
            [
                'header' => __('Name'),
                'index' => 'name',
                'class' => 'xxx',
                'width' => '50px',
            ]
        );
        $this->addColumn(
            'image',
            [
                'header' => __('Image'),
                'filter' => false,
                'class' => 'xxx',
                'width' => '50px',
                'renderer' => 'Magestore\Bannerslider\Block\Adminhtml\Banner\Helper\Renderer\Image',
            ]
        );
        $this->addColumn(
            'title',
            [
                'header' => __('Slider'),
                'index' => 'title',
                'class' => 'xxx',
                'width' => '50px',
            ]
        );
        $this->addColumn(
            'start_time',
            [
                'header' => __('Starting time'),
                'type' => 'datetime',
                'index' => 'start_time',
                'class' => 'xxx',
                'width' => '50px',
                'timezone' => true,
            ]
        );

        $this->addColumn(
            'end_time',
            [
                'header' => __('Ending time'),
                'type' => 'datetime',
                'index' => 'end_time',
                'class' => 'xxx',
                'width' => '50px',
                'timezone' => true,
            ]
        );

        $this->addColumn(
            'status',
            [
                'header' => __('Status'),
                'index' => 'status',
                'type' => 'options',
                'filter_index' => 'main_table.status',
                'options' => Status::getAvailableStatuses(),
            ]
        );

        $this->addColumn(
            'edit',
            [
                'header' => __('Edit'),
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action',
                'renderer' => 'Magestore\Bannerslider\Block\Adminhtml\Slider\Edit\Tab\Helper\Renderer\EditBanner',
            ]
        );

        $this->addColumn(
            'order_banner_slider',
            [
                'header' => __('Order'),
                'name' => 'order_banner_slider',
                'index' => 'order_banner_slider',
                'class' => 'xxx',
                'width' => '50px',
                'editable' => true,
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/bannersgrid', ['_current' => true]);
    }

    /**
     * get row url
     * @param  object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return '';
    }

    public function getSelectedSliderBanners()
    {
        $sliderId = $this->getRequest()->getParam('slider_id');
        if (!isset($sliderId)) {
            return [];
        }
        $bannerCollection = $this->_bannerCollectionFactory->create();
        $bannerCollection->addFieldToFilter('slider_id', $sliderId);

        $bannerIds = [];
        foreach ($bannerCollection as $banner) {
            $bannerIds[$banner->getId()] = ['order_banner_slider' => $banner->getOrderBanner()];
        }

        return $bannerIds;
    }

    protected function _getSelectedBanners()
    {
        $banners = $this->getRequest()->getParam('banner');
        if (!is_array($banners)) {
            $banners = array_keys($this->getSelectedSliderBanners());
        }

        return $banners;
    }

    /**
     * Prepare label for tab.
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Banners');
    }

    /**
     * Prepare title for tab.
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Banners');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return true;
    }
}
