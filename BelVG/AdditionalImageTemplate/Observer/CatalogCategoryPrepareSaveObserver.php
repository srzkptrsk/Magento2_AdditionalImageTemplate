<?php
/**
 * BelVG LLC.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://store.belvg.com/BelVG-LICENSE-COMMUNITY.txt
 *
 ********************************************************************
 *
 * @category   BelVG
 * @package    BelVG_AdditionalImageTemplate
 * @author     Siaržuk Piatroŭski (siarzuk@piatrouski.com)
 * @copyright  Copyright (c) 2010 - 2017 BelVG LLC. (http://www.belvg.com)
 * @license    http://store.belvg.com/BelVG-LICENSE-COMMUNITY.txt
 */

namespace BelVG\AdditionalImageTemplate\Observer;

class CatalogCategoryPrepareSaveObserver
    implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $category = $observer->getEvent()->getCategory();
        $category->setData($this->_postData($category->getData()));
    }

    /**
     * Filter category data
     *
     * @param array $rawData
     * @return array
     */
    protected function _postData(array $rawData)
    {
        $data = $rawData;
        $attributeName = \BelVG\AdditionalImageTemplate\Helper\Data::ATTRIBUTE_NAME;

        if (empty($data[$attributeName])) {
            unset($data[$attributeName]);
            $data[$attributeName]['delete'] = true;
        }

        // @todo It is a workaround to prevent saving this data in category model and it has to be refactored in future
        if (isset($data[$attributeName])
            && is_array($data[$attributeName])
        ) {
            if (!empty($data[$attributeName]['delete'])) {
                $data[$attributeName] = null;
            } else {
                if (isset($data[$attributeName][0]['name'])
                    && isset($data[$attributeName][0]['tmp_name'])
                ) {
                    $data[$attributeName] = $data[$attributeName][0]['name'];
                } else {
                    unset($data[$attributeName]);
                }
            }
        }

        return $data;
    }
}