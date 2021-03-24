<?php

namespace Amasty\Course\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

abstract class ConfigProviderAbstract
{
    protected $scopeConfig;

    protected $pathPrefix;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function getValue($path)
    {
        if ($this->pathPrefix) {
            return $this->scopeConfig->getValue($this->pathPrefix . $path);
        }
    }
}
