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

namespace Magestore\Bannerslider\Block\Adminhtml\Report;

/**
 * Report grid.
 * @category Magestore
 * @package  Magestore_Bannerslider
 * @module   Bannerslider
 * @author   Magestore Developer
 */
class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * slider factory.
     *
     * @var \Magestore\Bannerslider\Model\SliderFactory
     */
    protected $_sliderFactory;

    /**
     * report factory.
     *
     * @var \Magestore\Bannerslider\Model\ReportFactory
     */
    protected $_reportCollectionFactory;

    /**
     * helper.
     *
     * @var \Magestore\Bannerslider\Helper\Data
     */
    protected $_bannersliderHelper;

    /**
     * Registry object.
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * [__construct description].
     *
     * @param \Magento\Backend\Block\Template\Context                         $context
     * @param \Magento\Backend\Helper\Data                                    $backendHelper
     * @param \Magestore\Bannerslider\Model\SliderFactory                     $sliderFactory
     * @param \Magestore\Bannerslider\Model\Resource\Report\CollectionFactory $reportCollectionFactory
     * @param \Magento\Framework\Registry                                     $coreRegistry
     * @param \Magestore\Bannerslider\Helper\Data                             $bannersliderHelper
     * @param array                                                           $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magestore\Bannerslider\Model\SliderFactory $sliderFactory,
        \Magestore\Bannerslider\Model\Resource\Report\CollectionFactory $reportCollectionFactory,
        \Magento\Framework\Registry $coreRegistry,
        \Magestore\Bannerslider\Helper\Data $bannersliderHelper,
        array $data = []
    ) {
        $this->_sliderFactory = $sliderFactory;
        $this->_reportCollectionFactory = $reportCollectionFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->_bannersliderHelper = $bannersliderHelper;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * [_construct description].
     *
     * @return [type] [description]
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('reportGrid');
        $this->setDefaultSort('report_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = $this->_reportCollectionFactory->create();

        $collection->getSelect()->joinLeft(array(
            'table_banner' => $collection->getTable('magestore_bannerslider_banner')),
            'main_table.banner_id = table_banner.banner_id',
            array('banner_name' => 'table_banner.name', 'banner_url' => 'table_banner.click_url')
        );
        $collection->getSelect()->joinLeft(array(
            'table_slider' => $collection->getTable('magestore_bannerslider_slider')),
            'main_table.slider_id = table_slider.slider_id',
            array('slider_title' => 'table_slider.title')
        );
        $collection->getSelect()
            ->columns('SUM(main_table.clicks) AS banner_click')
            ->columns('SUM(main_table.impmode) AS banner_impress');

        $actionName = $this->getRequest()->getActionName();

        if ($actionName === 'index' || ($actionName == 'grid' && $this->getRequest()->getParam('action') === 'index')) {
            $collection->getSelect()
                ->group('main_table.slider_id')
                ->group('main_table.banner_id');
        } elseif (($actionName == 'grid' && $this->getRequest()->getParam('action') === 'banner')
            || $actionName === 'banner') {
            $collection->getSelect()
                ->group('main_table.banner_id');
        }

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * @return $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'report_id',
            [
                'header' => __('ID'),
                'type' => 'number',
                'index' => 'report_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'banner_name',
            [
                'header' => __('Banner'),
                'align' => 'left',
                'filter_index' => 'table_banner.name',
                'index' => 'banner_name',
            ]
        );
        $this->addColumn(
            'banner_url',
            [
                'header' => __('URL'),
                'align' => 'left',
                'filter_index' => 'table_banner.click_url',
                'index' => 'banner_url',
            ]
        );

        $actionName = $this->getRequest()->getActionName();
        if ($actionName === 'index' || ($actionName == 'grid' && $this->getRequest()->getParam('action') === 'index')) {
            $this->addColumn(
                'slider_title',
                [
                    'header' => __('Slider'),
                    'align' => 'left',
                    'filter_index' => 'table_slider.title',
                    'index' => 'slider_title',
                ]
            );
        }

        $this->addColumn(
            'banner_click',
            [
                'header' => __('Clicks'),
                'align' => 'left',
                'index' => 'banner_click',
                'type' => 'number',
                'filter_index' => 'main_table.clicks',
                'width' => '100px',
            ]
        );

        $this->addColumn(
            'banner_impress',
            [
                'header' => __('Impressions'),
                'align' => 'left',
                'index' => 'banner_impress',
                'filter_index' => 'main_table.impmode',
                'type' => 'number',
                'width' => '200px',
            ]
        );
        $this->addColumn(
            'imagename',
            [
                'header' => __('Image'),
                'align' => 'center',
                'width' => '70px',
                'filter' => false,
                'index' => 'imagename',
                'renderer' => 'Magestore\Bannerslider\Block\Adminhtml\Report\Helper\Renderer\Image',
            ]
        );

        $this->addColumn(
            'date_click',
            [
                'header' => __('Date'),
                'align' => 'left',
                'index' => 'date_click',
                'type' => 'date',
            ]
        );
        $this->addExportType('*/*/exportCsv', __('CSV'));
        $this->addExportType('*/*/exportXml', __('XML'));
        $this->addExportType('*/*/exportExcel', __('Excel'));

        return parent::_prepareColumns();
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true, 'action' => $this->getRequest()->getActionName()));
    }
}
