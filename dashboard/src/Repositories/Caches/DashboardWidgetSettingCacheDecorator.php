<?php

namespace Xamtirg\Dashboard\Repositories\Caches;

use Xamtirg\Dashboard\Repositories\Interfaces\DashboardWidgetSettingInterface;
use Xamtirg\Support\Repositories\Caches\CacheAbstractDecorator;

class DashboardWidgetSettingCacheDecorator extends CacheAbstractDecorator implements DashboardWidgetSettingInterface
{
    /**
     * {@inheritDoc}
     */
    public function getListWidget()
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
