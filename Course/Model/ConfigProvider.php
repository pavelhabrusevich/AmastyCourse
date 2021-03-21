<?php

namespace Amasty\Course\Model;

class ConfigProvider extends ConfigProviderAbstract
{
    protected $pathPrefix = 'am_course_config/';

    const SHOW_QTY = 'general/show_qty';
    const QTY = 'general/qty';

    public function getValue($path)
    {
        return $this->scopeConfig->getValue($this->pathPrefix . $path);
    }

    public function isEnabledShowQty(): bool
    {
        return $this->getValue(self::SHOW_QTY);
    }

    public function getQty()
    {
        return $this->getValue(self::QTY);
    }
}
