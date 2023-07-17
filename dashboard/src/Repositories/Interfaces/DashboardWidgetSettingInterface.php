<?php

namespace Xamtirg\Dashboard\Repositories\Interfaces;

use Xamtirg\Support\Repositories\Interfaces\RepositoryInterface;

interface DashboardWidgetSettingInterface extends RepositoryInterface
{
    /**
     * @return mixed
     *
     * @since 2.1
     */
    public function getListWidget();
}
