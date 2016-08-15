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

namespace Magestore\BannerSlider\Model\ResourceModel\Banner;

/**
 * Banner Collection
 * @category Magestore
 * @package  Magestore_Bannerslider
 * @module   Bannerslider
 * @author   Magestore Developer
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'banner_id';
    /**
     * store view id.
     *
     * @var int
     */
    protected $_storeViewId = null;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * added table
     * @var array
     */
    protected $_addedTable = [];

    /**
     * @var bool
     */
    protected $_isLoadSliderTitle = FALSE;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\Timezone
     */
    protected $_stdTimezone;

    /**
     * @var \Magestore\Bannerslider\Model\Slider
     */
    protected $_slider;
    /**
     * _construct
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Magestore\Bannerslider\Model\Banner', 'Magestore\Bannerslider\Model\ResourceModel\Banner');
    }

    /**
     * @param \Magento\Framework\Data\Collection\EntityFactoryInterface    $entityFactory
     * @param \Psr\Log\LoggerInterface                                     $logger
     * @param \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy
     * @param \Magento\Framework\Event\ManagerInterface                    $eventManager
     * @param \Zend_Db_Adapter_Abstract                                    $connection
     * @param \Magento\Framework\Model\ResourceModel\Db\AbstractDb              $resource
     */
    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Stdlib\DateTime\Timezone $stdTimezone,
        \Magestore\Bannerslider\Model\Slider $slider,
        $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
        $this->_storeManager = $storeManager;
        $this->_stdTimezone = $stdTimezone;
        $this->_slider = $slider;
        if ($storeViewId = $this->_storeManager->getStore()->getId()) {
            $this->_storeViewId = $storeViewId;
        }
    }

    /**
     * @param $isLoadSliderTitle
     * @return $this
     */
    public function setIsLoadSliderTitle($isLoadSliderTitle)
    {
        $this->_isLoadSliderTitle = $isLoadSliderTitle;

        return $this;
    }

    /**
     * @return bool
     */
    public function isLoadSliderTitle()
    {
        return $this->_isLoadSliderTitle;
    }

    /**
     * Before load action.
     *
     * @return $this
     */
    protected function _beforeLoad()
    {
        if ($this->isLoadSliderTitle()) {
            $this->joinSliderTitle();
        }

        return parent::_beforeLoad();
    }

    /**
     * join table to get Slider Title of Banner
     * @return $this
     */
    public function joinSliderTitle()
    {
        $this->getSelect()->joinLeft(
            ['sliderTable' => $this->getTable('magestore_bannerslider_slider')],
            'main_table.slider_id = sliderTable.slider_id',
            ['title' => 'sliderTable.title', 'slider_status' => 'sliderTable.status']
        );

        return $this;
    }

    /**
     * set order random by banner id
     *
     * @return $this
     */
    public function setOrderRandByBannerId()
    {
        $this->getSelect()->orderRand('main_table.banner_id');

        return $this;
    }

    /**
     * get store view id.
     *
     * @return int [description]
     */
    public function getStoreViewId()
    {
        return $this->_storeViewId;
    }

    /**
     * set store view id.
     *
     * @param int $storeViewId [description]
     */
    public function setStoreViewId($storeViewId)
    {
        $this->_storeViewId = $storeViewId;

        return $this;
    }

    /**
     * Multi store view.
     *
     * @param string|array      $field
     * @param null|string|array $condition
     */
    public function addFieldToFilter($field, $condition = null)
    {
        $attributes = array(
            'name',
            'status',
            'click_url',
            'target',
            'image_alt',
            'maintable',
        );
        $storeViewId = $this->getStoreViewId();

        if (in_array($field, $attributes) && $storeViewId) {
            if (!in_array($field, $this->_addedTable)) {
                $sql = sprintf(
                    'main_table.banner_id = %s.banner_id AND %s.store_id = %s  AND %s.attribute_code = %s ',
                    $this->getConnection()->quoteTableAs($field),
                    $this->getConnection()->quoteTableAs($field),
                    $this->getConnection()->quote($storeViewId),
                    $this->getConnection()->quoteTableAs($field),
                    $this->getConnection()->quote($field)
                );

                $this->getSelect()
                    ->joinLeft(array($field => $this->getTable('magestore_bannerslider_value')), $sql, array());
                $this->_addedTable[] = $field;
            }

            $fieldNullCondition = $this->_translateCondition("$field.value", ['null' => TRUE]);

            $mainfieldCondition = $this->_translateCondition("main_table.$field", $condition);

            $fieldCondition = $this->_translateCondition("$field.value", $condition);

            $condition = $this->_implodeCondition(
                $this->_implodeCondition($fieldNullCondition, $mainfieldCondition, \Zend_Db_Select::SQL_AND),
                $fieldCondition,
                \Zend_Db_Select::SQL_OR
            );

            $this->_select->where($condition, NULL, \Magento\Framework\DB\Select::TYPE_CONDITION);

            return $this;
        }
        if ($field == 'store_id') {
            $field = 'main_table.banner_id';
        }

        return parent::addFieldToFilter($field, $condition);
    }

    /**
     * @param $firstCondition
     * @param $secondCondition
     * @param $type
     * @return string
     */
    protected function _implodeCondition($firstCondition, $secondCondition, $type)
    {
        return '(' . implode(') ' . $type . ' (', [$firstCondition, $secondCondition]) . ')';
    }

    /**
     * get read connnection.
     */
    public function getConnection()
    {
        return $this->getResource()->getConnection();
    }

    /**
     * Multi store view.
     */
    protected function _afterLoad()
    {
        parent::_afterLoad();
        if ($storeViewId = $this->getStoreViewId()) {
            foreach ($this->_items as $item) {
                $item->setStoreViewId($storeViewId)->getStoreViewValue();
            }
        }

        return $this;
    }


    public function getBannerCollection($sliderId)
    {
        $storeViewId = $this->_storeManager->getStore()->getId();
        $dateTimeNow = $this->_stdTimezone->date()->format('Y-m-d H:i:s');

        /** @var \Magestore\Bannerslider\Model\ResourceModel\Banner\Collection $bannerCollection */
        $bannerCollection = $this->setStoreViewId($storeViewId)
            ->addFieldToFilter('slider_id', $sliderId)
            ->addFieldToFilter('status', \Magestore\Bannerslider\Model\Status::STATUS_ENABLED)
            ->addFieldToFilter('start_time', ['lteq' => $dateTimeNow])
            ->addFieldToFilter('end_time', ['gteq' => $dateTimeNow])
            ->setOrder('order_banner', 'ASC');

        if ($this->_slider->getSortType() == \Magestore\Bannerslider\Model\Slider::SORT_TYPE_RANDOM) {
            $bannerCollection->setOrderRandByBannerId();
        }

        return $bannerCollection;
    }
}
