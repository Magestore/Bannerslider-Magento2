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

namespace Magestore\Bannerslider\Model;

/**
 * Banner Model
 * @category Magestore
 * @package  Magestore_Bannerslider
 * @module   Bannerslider
 * @author   Magestore Developer
 */
class Banner extends \Magento\Framework\Model\AbstractModel
{
    const BASE_MEDIA_PATH = 'magestore/bannerslider/images';

    const BANNER_TARGET_SELF = 0;
    const BANNER_TARGET_PARENT = 1;
    const BANNER_TARGET_BLANK = 2;

    /**
     * slider colleciton factory.
     *
     * @var \Magestore\Bannerslider\Model\ResourceModel\Slider\CollectionFactory
     */
    protected $_sliderCollectionFactory;

    /**
     * store view id.
     *
     * @var int
     */
    protected $_storeViewId = null;

    /**
     * banner factory.
     *
     * @var \Magestore\Bannerslider\Model\BannerFactory
     */
    protected $_bannerFactory;

    /**
     * value factory.
     *
     * @var \Magestore\Bannerslider\Model\ValueFactory
     */
    protected $_valueFactory;

    /**
     * value collecion factory.
     *
     * @var \Magestore\Bannerslider\Model\ResourceModel\Value\CollectionFactory
     */
    protected $_valueCollectionFactory;

    /**
     * [$_formFieldHtmlIdPrefix description].
     *
     * @var string
     */
    protected $_formFieldHtmlIdPrefix = 'page_';

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * logger.
     *
     * @var \Magento\Framework\Logger\Monolog
     */
    protected $_monolog;

    /**
     * [__construct description].
     *
     * @param \Magento\Framework\Model\Context                                $context
     * @param \Magento\Framework\Registry                                     $registry
     * @param \Magestore\Bannerslider\Model\ResourceModel\Banner                   $resource
     * @param \Magestore\Bannerslider\Model\ResourceModel\Banner\Collection        $resourceCollection
     * @param \Magestore\Bannerslider\Model\BannerFactory                     $bannerFactory
     * @param \Magestore\Bannerslider\Model\ResourceModel\Slider\CollectionFactory $sliderCollectionFactory
     * @param \Magestore\Bannerslider\Model\ResourceModel\Value\CollectionFactory  $valueCollectionFactory
     * @param \Magento\Store\Model\StoreManagerInterface                      $storeManager
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magestore\Bannerslider\Model\ResourceModel\Banner $resource,
        \Magestore\Bannerslider\Model\ResourceModel\Banner\Collection $resourceCollection,
        \Magestore\Bannerslider\Model\BannerFactory $bannerFactory,
        \Magestore\Bannerslider\Model\ValueFactory $valueFactory,
        \Magestore\Bannerslider\Model\ResourceModel\Slider\CollectionFactory $sliderCollectionFactory,
        \Magestore\Bannerslider\Model\ResourceModel\Value\CollectionFactory $valueCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Logger\Monolog $monolog
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection
        );
        $this->_bannerFactory = $bannerFactory;
        $this->_valueFactory = $valueFactory;
        $this->_valueCollectionFactory = $valueCollectionFactory;
        $this->_storeManager = $storeManager;
        $this->_sliderCollectionFactory = $sliderCollectionFactory;

        $this->_monolog = $monolog;

        if ($storeViewId = $this->_storeManager->getStore()->getId()) {
            $this->_storeViewId = $storeViewId;
        }
    }

    /**
     * get form field html id prefix.
     *
     * @return string
     */
    public function getFormFieldHtmlIdPrefix()
    {
        return $this->_formFieldHtmlIdPrefix;
    }

    /**
     * get availabe slide.
     *
     * @return []
     */
    public function getAvailableSlides()
    {
        $option[] = [
            'value' => '',
            'label' => __('-------- Please select a slider --------'),
        ];

        $sliderCollection = $this->_sliderCollectionFactory->create();
        foreach ($sliderCollection as $slider) {
            $option[] = [
                'value' => $slider->getId(),
                'label' => $slider->getTitle(),
            ];
        }

        return $option;
    }

    /**
     * get store attributes.
     *
     * @return array
     */
    public function getStoreAttributes()
    {
        return array(
            'name',
            'status',
            'click_url',
            'target',
            'image_alt',
            'image',
            'caption'
        );
    }

    /**
     * get store view id.
     *
     * @return int
     */
    public function getStoreViewId()
    {
        return $this->_storeViewId;
    }

    /**
     * set store view id.
     *
     * @param int $storeViewId
     */
    public function setStoreViewId($storeViewId)
    {
        $this->_storeViewId = $storeViewId;

        return $this;
    }

    /**
     * before save.
     */
    public function beforeSave()
    {
        if ($this->getStoreViewId()) {
            $defaultStore = $this->_bannerFactory->create()->setStoreViewId(null)->load($this->getId());
            $storeAttributes = $this->getStoreAttributes();
            $data = $this->getData();
            foreach ($storeAttributes as $attribute) {
                if (isset($data['use_default']) && isset($data['use_default'][$attribute])) {
                    $this->setData($attribute.'_in_store', false);
                } else {
                    $this->setData($attribute.'_in_store', true);
                    $this->setData($attribute.'_value', $this->getData($attribute));
                }
                $this->setData($attribute, $defaultStore->getData($attribute));
            }
        }

        return parent::beforeSave();
    }

    /**
     * after save.
     */
//    public function afterSave()
//    {
//        if ($storeViewId = $this->getStoreViewId()) {
//            $storeAttributes = $this->getStoreAttributes();
//
//            foreach ($storeAttributes as $attribute) {
//                $attributeValue = $this->_valueFactory->create()
//                    ->loadAttributeValue($this->getId(), $storeViewId, $attribute);
//                if ($this->getData($attribute.'_in_store')) {
//                    try {
//                        if ($attribute == 'image' && $this->getData('delete_image')) {
//                            $attributeValue->delete();
//                        } else {
//                            $attributeValue->setValue($this->getData($attribute.'_value'))->save();
//                        }
//                    } catch (\Exception $e) {
//                        $this->_monolog->addError($e->getMessage());
//                    }
//                } elseif ($attributeValue && $attributeValue->getId()) {
//                    try {
//                        $attributeValue->delete();
//                    } catch (\Exception $e) {
//                        $this->_monolog->addError($e->getMessage());
//                    }
//                }
//            }
//        }
//
//        return parent::afterSave();
//    }

    public function afterSave()
    {
        if ($storeViewId = $this->getStoreViewId()) {
            $storeAttributes = $this->getStoreAttributes();
            $collectionBanner = $this->_valueCollectionFactory->create();
            $attributeValue = $this->_valueFactory->create()
                ->loadAttributeValue($this->getId(), $storeViewId, $storeAttributes, $collectionBanner);
            foreach ($attributeValue as $model) {
                if ($this->getData($model->getData('attribute_code') . '_in_store')) {
                    try {
                        if ($model->getData('attribute_code') == 'image' && $this->getData('delete_image')) {
                            $model->delete();
                        } else {
                            $model->setValue($this->getData($model->getData('attribute_code') . '_value'))->save();
                        }
                    } catch (\Exception $e) {
                        $this->_monolog->addError($e->getMessage());
                    }
                } elseif ($model && $model->getId()) {
                    try {
                        $model->delete();
                    } catch (\Exception $e) {
                        $this->_monolog->addError($e->getMessage());
                    }
                }
            }

        }
        return parent::afterSave();
    }
    /**
     * load info multistore.
     *
     * @param mixed  $id
     * @param string $field
     *
     * @return $this
     */
    public function load($id, $field = null)
    {
        parent::load($id, $field);
        if ($this->getStoreViewId()) {
            $this->getStoreViewValue();
        }

        return $this;
    }

    /**
     * get store view value.
     *
     * @param string|null $storeViewId
     *
     * @return $this
     */
    public function getStoreViewValue($storeViewId = null)
    {
        if (!$storeViewId) {
            $storeViewId = $this->getStoreViewId();
        }
        if (!$storeViewId) {
            return $this;
        }
        $storeValues = $this->_valueCollectionFactory->create()
            ->addFieldToFilter('banner_id', $this->getId())
            ->addFieldToFilter('store_id', $storeViewId);
        foreach ($storeValues as $value) {
            $this->setData($value->getAttributeCode().'_in_store', true);
            $this->setData($value->getAttributeCode(), $value->getValue());
        }

        return $this;
    }

    /**
     * get target value.
     *
     * @return string
     */
    public function getTargetValue()
    {
        switch ($this->getTarget()) {
            case self::BANNER_TARGET_SELF:
                return '_self';
            case self::BANNER_TARGET_PARENT:
                return '_parent';

            default:
                return '_blank';
        }
    }
}
