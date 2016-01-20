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

namespace Magestore\Bannerslider\Controller\Adminhtml\Slider;

/**
 * Slider Index action
 * @category Magestore
 * @package  Magestore_Bannerslider
 * @module   Bannerslider
 * @author   Magestore Developer
 */
class Index extends \Magestore\Bannerslider\Controller\Adminhtml\Slider
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        if ($this->getRequest()->getQuery('ajax')) {
            $resultForward = $this->_resultForwardFactory->create();
            $resultForward->forward('grid');

            return $resultForward;
        }

        $resultPage = $this->_resultPageFactory->create();

        return $resultPage;
    }
}
