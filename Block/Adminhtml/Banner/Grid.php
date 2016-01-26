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

namespace Magestore\Bannerslider\Block\Adminhtml\Banner;

use Magestore\Bannerslider\Model\Status;

/**
 * Banner grid.
 * @category Magestore
 * @package  Magestore_Bannerslider
 * @module   Bannerslider
 * @author   Magestore Developer
 */
class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * banner collection factory.
     *
     * @var \Magestore\Bannerslider\Model\ResourceModel\Banner\CollectionFactory
     */
    protected $_bannerCollectionFactory;

    /**
     * slider collection factory.
     *
     * @var \Magestore\Bannerslider\Model\ResourceModel\Slider\CollectionFactory
     */
    protected $_sliderCollectionFactory;

    /**
     * construct.
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
        \Magestore\Bannerslider\Model\ResourceModel\Slider\CollectionFactory $sliderCollectionFactory,
        array $data = []
    ) {
        $this->_bannerCollectionFactory = $bannerCollectionFactory;
        $this->_sliderCollectionFactory = $sliderCollectionFactory;

        parent::__construct($context, $backendHelper, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('bannerGrid');
        $this->setDefaultSort('banner_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $storeViewId = $this->getRequest()->getParam('store');

        /** @var \Magestore\Bannerslider\Model\ResourceModel\Banner\Collection $collection */
        $collection = $this->_bannerCollectionFactory->create()->setStoreViewId($storeViewId);

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * @return $this
     */
    protected function _prepareColumns()
    {
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
                'class' => 'xxx',
                'width' => '50px',
                'filter' => false,
                'renderer' => 'Magestore\Bannerslider\Block\Adminhtml\Banner\Helper\Renderer\Image',
            ]
        );
        $this->addColumn(
            'click_url',
            [
                'header' => __('URL'),
                'index' => 'click_url',
                'class' => 'xxx',
                'width' => '50px',
            ]
        );

        $this->addColumn(
            'title',
            [
                'header' => __('Slider'),
                'index'   => 'slider_id',
                'type'    => 'options',
                'options' => $this->getSliderAvailableOption(),
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
                'options' => Status::getAvailableStatuses(),
            ]
        );

        $this->addColumn(
            'edit',
            [
                'header' => __('Edit'),
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('Edit'),
                        'url' => ['base' => '*/*/edit'],
                        'field' => 'banner_id',
                    ],
                ],
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action',
            ]
        );
        $this->addExportType('*/*/exportCsv', __('CSV'));
        $this->addExportType('*/*/exportXml', __('XML'));
        $this->addExportType('*/*/exportExcel', __('Excel'));

        return parent::_prepareColumns();
    }

    /**
     * get slider vailable option
     *
     * @return array
     */
    public function getSliderAvailableOption()
    {
        $option = [];
        $sliderCollection = $this->_sliderCollectionFactory->create()->addFieldToSelect(['title']);

        foreach ($sliderCollection as $slider) {
            $option[$slider->getId()] = $slider->getTitle();
        }

        return $option;
    }

    /**
     * @return $this
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('banner');

        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('bannerslideradmin/*/massDelete'),
                'confirm' => __('Are you sure?'),
            ]
        );

        $statuses = Status::getAvailableStatuses();

        array_unshift($statuses, ['label' => '', 'value' => '']);
        $this->getMassactionBlock()->addItem(
            'status',
            [
                'label' => __('Change status'),
                'url' => $this->getUrl('bannerslideradmin/*/massStatus', ['_current' => true]),
                'additional' => [
                    'visibility' => [
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => __('Status'),
                        'values' => $statuses,
                    ],
                ],
            ]
        );

        return $this;
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', ['_current' => true]);
    }

    /**
     * get row url
     * @param  object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl(
            '*/*/edit',
            ['banner_id' => $row->getId()]
        );
    }
}
