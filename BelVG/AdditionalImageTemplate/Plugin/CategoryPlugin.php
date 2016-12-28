<?php
/**
 * @package Shiekh.com
 * @author Siaržuk Piatroŭski (siarzuk@piatrouski.com)
 */
namespace BelVG\AdditionalImageTemplate\Plugin;

use \Magento\Catalog\Model\Category as Subject;

class CategoryPlugin
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
     * Around get data for preprocess image
     *
     * @param Subject $subject
     * @param \Closure $proceed
     * @param string $key
     * @param null $index
     * @return mixed|string
     */
    public function aroundGetData(
        Subject $subject,
        \Closure $proceed,
        $key = '',
        $index = null
    ) {
        if ($key == \BelVG\AdditionalImageTemplate\Helper\Data::ATTRIBUTE_NAME) {
            $result = $proceed($key, $index);
            if ($result) {
                return $this->_helper->getUrl($result);
            } else {
                return $result;
            }
        }

        return $proceed($key, $index);
    }
}