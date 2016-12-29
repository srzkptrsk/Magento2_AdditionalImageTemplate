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
        $image = $category->getData(self::ATTRIBUTE_NAME);
        
        return $this->getUrl($image);
    }

    /**
     * Retrieve URL
     *
     * @return string
     */
    public function getUrl($value)
    {
        $url = false;
        if ($value) {
            if (is_string($value)) {
                $url = $this->_storeManager->getStore()->getBaseUrl(
                        \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                    ) . 'catalog/category/' . $value;
            } else {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Something went wrong while getting the image url.')
                );
            }
        }
        
        return $url;
    }
}