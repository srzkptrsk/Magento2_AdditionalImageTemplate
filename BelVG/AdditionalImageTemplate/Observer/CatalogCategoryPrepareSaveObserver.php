<?php
/**
 * @package Shiekh.com
 * @author Siaržuk Piatroŭski (siarzuk@piatrouski.com)
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

        if (empty($data['additional_image'])) {
            unset($data['additional_image']);
            $data['additional_image']['delete'] = true;
        }

        // @todo It is a workaround to prevent saving this data in category model and it has to be refactored in future
        if (isset($data['additional_image']) && is_array($data['additional_image'])) {
            if (!empty($data['additional_image']['delete'])) {
                $data['additional_image'] = null;
            } else {
                if (isset($data['additional_image'][0]['name']) && isset($data['additional_image'][0]['tmp_name'])) {
                    $data['additional_image'] = $data['additional_image'][0]['name'];
                } else {
                    unset($data['additional_image']);
                }
            }
        }

        return $data;
    }
}