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

namespace Magestore\Bannerslider\Model\Resource\Banner;

/**
 * Banner Collection
 * @category Magestore
 * @package  Magestore_Bannerslider
 * @module   Bannerslider
 * @author   Magestore Developer
 */
class Collection extends \Magento\Framework\Model\Resource\Db\Collection\AbstractCollection
{
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
     * _construct
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Magestore\Bannerslider\Model\Banner', 'Magestore\Bannerslider\Model\Resource\Banner');
    }

    /**
     * @param \Magento\Framework\Data\Collection\EntityFactoryInterface    $entityFactory
     * @param \Psr\Log\LoggerInterface                                     $logger
     * @param \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy
     * @param \Magento\Framework\Event\ManagerInterface                    $eventManager
     * @param \Zend_Db_Adapter_Abstract                                    $connection
     * @param \Magento\Framework\Model\Resource\Db\AbstractDb              $resource
     */
    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        $connection = null,
        \Magento\Framework\Model\Resource\Db\AbstractDb $resource = null
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
        $this->_storeManager = $storeManager;

        if ($storeViewId = $this->_storeManager->getStore()->getId()) {
            $this->_storeViewId = $storeViewId;
        }
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
        );
        $storeViewId = $this->getStoreViewId();
        if (in_array($field, $attributes) && $storeViewId) {
            if (!in_array($field, $this->_addedTable)) {
                $sql = sprintf(
                    'main_table.banner_id = %s.banner_id AND %s.store_id = %s  AND %s.attribute_code = %s ',
                    $this->getReadConnection()->quoteTableAs($field),
                    $this->getReadConnection()->quoteTableAs($field),
                    $this->getReadConnection()->quote($storeViewId),
                    $this->getReadConnection()->quoteTableAs($field),
                    $this->getReadConnection()->quote($field)
                );

                $this->getSelect()
                    ->joinLeft(array($field => $this->getTable('magestore_bannerslider_value')), $sql, array());
                $this->_addedTable[] = $field;
            }

            return parent::addFieldToFilter($field, $condition);
        }
        if ($field == 'store_id') {
            $field = 'main_table.banner_id';
        }

        return parent::addFieldToFilter($field, $condition);
    }

    /**
     * get read connnection.
     */
    public function getReadConnection()
    {
        return $this->getResource()->getReadConnection();
    }

    /**
     * quote Identifier.
     */
    public function quoteIdentifier($ident, $auto = false)
    {
        $this->getResource()->getReadConnection()->quoteIdentifier($ident, $auto);
    }
    /**
     * quote.
     */
    public function quote($value, $type = null)
    {
        $this->getResource()->getReadConnection()->quote($value, $type);
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
}
