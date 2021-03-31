<?php

namespace Amasty\AdditionalModule\Model;

class ConfigProvider extends ConfigProviderAbstract
{
    protected $pathPrefix = 'am_additional_config/';

    const ENABLE_MODULE = 'general/enabled';
    const PROMO_SKU = 'general/promo_sku';
    const FOR_SKU = 'general/for_sku';
    const ENABLE_MAG_ADD_PRODUCT = 'general/magento_add_product';

    public function isEnabledModule(): bool
    {
        return $this->getValue(self::ENABLE_MODULE);
    }

    public function getPromoSku()
    {
        return $this->getValue(self::PROMO_SKU);
    }

    public function getForSku():array
    {
        return array_unique(explode(',', $this->getValue(self::FOR_SKU)));
    }

    public function isEnabledMagAddProduct(): bool
    {
        return $this->getValue(self::ENABLE_MAG_ADD_PRODUCT);
    }
}
