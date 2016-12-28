<?php
/**
 * @package Shiekh.com
 * @author Siaržuk Piatroŭski (siarzuk@piatrouski.com)
 */

namespace BelVG\AdditionalImageTemplate\Plugin;

use \Magento\Catalog\Model\Category\DataProvider as Subject;

class DataProviderPlugin
{
    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \BelVG\AdditionalImageTemplate\Helper\Data
     */
    protected $_helper;

    /**
     * DataProviderPlugin constructor.
     * 
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \BelVG\AdditionalImageTemplate\Helper\Data $helper
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \BelVG\AdditionalImageTemplate\Helper\Data $helper
    ) {
        $this->_storeManager = $storeManager;
        $this->_helper = $helper;
    }

    /**
     * @param Subject $subject
     * @param \Closure $proceed
     * @return array
     */
    public function aroundGetData(
        Subject $subject,
        \Closure $proceed
    ) {
        $result = $proceed();

        $category = $subject->getCurrentCategory();
        if ($category) {
            $categoryData = $category->getData();

            if (isset($categoryData['additional_image'])) {
                unset($categoryData['additional_image']);

                $result[$category->getId()]['additional_image'] = array(
                    array(
                        'name' => $category->getData('additional_image'),
                        'url' => $this->_helper->getImageUrl($category),
                    )
                );
            }
        }

        return $result;
    }
}