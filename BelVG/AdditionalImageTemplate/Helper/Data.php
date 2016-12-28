<?php
/**
 * @package Shiekh.com
 * @author Siaržuk Piatroŭski (siarzuk@piatrouski.com)
 */

namespace BelVG\AdditionalImageTemplate\Helper;

class Data
    extends \Magento\Framework\App\Helper\AbstractHelper
{
    const ATTRIBUTE_NAME = "additional_image";

    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->_storeManager = $storeManager;
    }

    /**
     * Retrieve image URL by category
     *
     * @return string
     */
    public function getImageUrl(\Magento\Catalog\Model\Category $category)
    {
        $url = false;
        $image = $category->getData(self::ATTRIBUTE_NAME);
        if ($image) {
            if (is_string($image)) {
                $url = $this->_storeManager->getStore()->getBaseUrl(
                        \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                    ) . 'catalog/category/' . $image;
            } else {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Something went wrong while getting the image url.')
                );
            }
        }
        return $url;
    }

    /**
     * Retrieve URL
     *
     * @return string
     */
    public function getUrl($attributeName)
    {
        $url = false;
        if ($attributeName) {
            if (is_string($attributeName)) {
                $url = $this->_storeManager->getStore()->getBaseUrl(
                        \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                    ) . 'catalog/category/' . $attributeName;
            } else {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Something went wrong while getting the image url.')
                );
            }
        }
        return $url;
    }
}