<?php

namespace Amasty\Course\Model;

class ConfigProvider extends ConfigProviderAbstract
{
    protected $pathPrefix = 'am_course_config/';

    const ENABLE_MODULE = 'general/enabled';
    const GREETING_TEXT = 'general/greeting_text';
    const SHOW_PRODUCT_QTY = 'general/show_qty';
    const PRODUCT_QTY = 'general/qty';

    public function isEnabledModule(): bool
    {
        return $this->getValue(self::ENABLE_MODULE);
    }

    public function getGreeting()
    {
        return $this->getValue(self::GREETING_TEXT);
    }

    public function isEnabledShowQty(): bool
    {
        return $this->getValue(self::SHOW_PRODUCT_QTY);
    }

    public function getQty()
    {
        return $this->getValue(self::PRODUCT_QTY);
    }
}
