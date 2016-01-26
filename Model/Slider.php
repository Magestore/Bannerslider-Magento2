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
 * Slider Model
 * @category Magestore
 * @package  Magestore_Bannerslider
 * @module   Bannerslider
 * @author   Magestore Developer
 */
class Slider extends \Magento\Framework\Model\AbstractModel
{
    const XML_CONFIG_BANNERSLIDER = 'bannerslider/general/enable_frontend';

    /**
     * Allow to show title or not.
     */
    const SHOW_TITLE_YES = 1;
    const SHOW_TITLE_NO = 2;

    /**
     * style custom content.
     */
    const STYLE_CONTENT_YES = 1;
    const STYLE_CONTENT_NO = 2;

    /**
     * sort type of banners in a slider.
     */
    const SORT_TYPE_RANDOM = 1;
    const SORT_TYPE_ORDERLY = 2;

    /**
     * Evolution slider.
     */
    const STYLESLIDE_EVOLUTION_ONE = 1;
    const STYLESLIDE_EVOLUTION_TWO = 2;
    const STYLESLIDE_EVOLUTION_THREE = 3;
    const STYLESLIDE_EVOLUTION_FOUR = 4;

    /**
     * popup.
     */
    const STYLESLIDE_POPUP = 5;

    /**
     * note slider.
     */
    const STYLESLIDE_SPECIAL_NOTE = 6;

    /**
     * flexslider.
     */
    const STYLESLIDE_FLEXSLIDER_ONE = 7;
    const STYLESLIDE_FLEXSLIDER_TWO = 8;
    const STYLESLIDE_FLEXSLIDER_THREE = 9;
    const STYLESLIDE_FLEXSLIDER_FOUR = 10;

    /**
     * position code of note slider.
     */
    const NOTE_POSITION_TOP_LEFT = 'top-left';
    const NOTE_POSITION_MIDDLE_TOP = 'middle-top';
    const NOTE_POSITION_TOP_RIGHT = 'top-right';
    const NOTE_POSITION_MIDDLE_LEFT = 'middle-left';
    const NOTE_POSITION_MIDDLE_RIGHT = 'middle-right';
    const NOTE_POSITION_BOTTOM_LEFT = 'bottom-left';
    const NOTE_POSITION_MIDDLE_BOTTOM = 'middle-bottom';
    const NOTE_POSITION_BOTTOM_RIGHT = 'bottom-right';

    /**
     * banner collection factory.
     *
     * @var \Magestore\Bannerslider\Model\ResourceModel\Banner\CollectionFactory
     */
    protected $_bannerCollectionFactory;

    /**
     * constructor.
     *
     * @param \Magento\Framework\Model\Context                                $context
     * @param \Magento\Framework\Registry                                     $registry
     * @param \Magestore\Bannerslider\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory
     * @param \Magestore\Bannerslider\Model\ResourceModel\Slider                   $resource
     * @param \Magestore\Bannerslider\Model\ResourceModel\Slider\Collection        $resourceCollection
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magestore\Bannerslider\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory,
        \Magestore\Bannerslider\Model\ResourceModel\Slider $resource,
        \Magestore\Bannerslider\Model\ResourceModel\Slider\Collection $resourceCollection
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection
        );
        $this->_bannerCollectionFactory = $bannerCollectionFactory;
    }

    /**
     * get banner collection of slider.
     *
     * @return \Magestore\Bannerslider\Model\ResourceModel\Banner\Collection
     */
    public function getOwnBanerCollection()
    {
        return $this->_bannerCollectionFactory->create()->addFieldToFilter('slider_id', $this->getId());
    }

    /**
     * get list position notes.
     *
     * @return array
     */
    public function getListPositionNotes()
    {
        return [
            self::NOTE_POSITION_TOP_LEFT,
            self::NOTE_POSITION_MIDDLE_TOP,
            self::NOTE_POSITION_TOP_RIGHT,
            self::NOTE_POSITION_MIDDLE_LEFT,
            self::NOTE_POSITION_MIDDLE_RIGHT,
            self::NOTE_POSITION_BOTTOM_LEFT,
            self::NOTE_POSITION_MIDDLE_BOTTOM,
            self::NOTE_POSITION_BOTTOM_RIGHT,
        ];
    }

    /**
     * get position note code.
     *
     * @return sring
     */
    public function getPositionNoteCode()
    {
        $listPositionNotes = $this->getListPositionNotes();
        if (!isset($listPositionNotes[$this->getPositionNote()])) {
            return self::NOTE_POSITION_TOP_LEFT;
        }

        return $listPositionNotes[$this->getPositionNote()];
    }

    /**
     * get position note options.
     *
     * @return array
     */
    public function getPositionNoteOptions()
    {
        $listPositionNotes = $this->getListPositionNotes();
        $option = [];
        foreach ($listPositionNotes as $key => $positionNote) {
            list($label, $value) = explode('-', $positionNote);
            if (isset($label) && isset($value)) {
                $option[] = ['label' => ucfirst($label).'-'.ucfirst($value), 'value' => $key];
            }
        }

        return $option;
    }
}
