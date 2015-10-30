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

namespace Magestore\Bannerslider\Block\Adminhtml\Form\Renderer\Fieldset;

/**
 * Fieldset element renderer.
 * @category Magestore
 * @package  Magestore_Bannerslider
 * @module   Bannerslider
 * @author   Magestore Developer
 */
class Element extends \Magento\Backend\Block\Widget\Form\Renderer\Fieldset\Element
{
    /**
     * Initialize block template.
     */
    protected $_template = 'Magestore_Bannerslider::form/renderer/fieldset/element.phtml';

    /**
     * @return string
     */
    public function getElementName()
    {
        return $this->getElement()->getName();
    }

    /**
     * @return string
     */
    public function getElementStoreViewId()
    {
        return $this->getElement()->getStoreViewId();
    }

    /**
     * Check "Use default" checkbox display availability.
     *
     * @return bool
     */
    public function canDisplayUseDefault()
    {
        return ($this->getRequest()->getParam('store') && $this->getElement()->getDateFormat() == NULL && $this->getElementName() != 'slider_id') ? TRUE : FALSE;
    }

    /**
     * Check default value usage fact.
     *
     * @return bool
     */
    public function usedDefault()
    {
        return $this->getElementStoreViewId() ? false : true;
    }

    /**
     * Disable field in default value using case.
     *
     * @return \Magento\Catalog\Block\Adminhtml\Form\Renderer\Fieldset\Element
     */
    public function checkFieldDisable()
    {
        if (!$this->getElementStoreViewId() && $this->getElementName() != 'banner_id' && $this->canDisplayUseDefault() && $this->usedDefault()) {
            $this->getElement()->setDisabled(true);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getScopeLabel()
    {
        if ($this->getElement()->getDateFormat() != null || $this->getElementName() == 'slider_id') {
            return '[GLOBAL]';
        }

        return '[STORE VIEW]';
    }

    /**
     * Retrieve element label html.
     *
     * @return string
     */
    public function getElementLabelHtml()
    {
        $element = $this->getElement();
        $label = $element->getLabel();
        if (!empty($label)) {
            $element->setLabel(__($label));
        }

        return $element->getLabelHtml();
    }

    /**
     * Retrieve element html.
     *
     * @return string
     */
    public function getElementHtml()
    {
        return $this->getElement()->getElementHtml();
    }

    /**
     * Default sore ID getter.
     *
     * @return int
     */
    protected function _getDefaultStoreId()
    {
        return \Magento\Store\Model\Store::DEFAULT_STORE_ID;
    }
}
