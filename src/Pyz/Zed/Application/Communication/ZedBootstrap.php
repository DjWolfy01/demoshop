<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Application\Communication;

use Pyz\Zed\Application\ApplicationDependencyProvider;
use Spryker\Zed\Application\Communication\ZedBootstrap as SprykerZedBootstrap;

class ZedBootstrap extends SprykerZedBootstrap
{

    /**
     * @return \Silex\ServiceProviderInterface[]
     */
    protected function getServiceProvider()
    {
        return $this->getProvidedDependency(ApplicationDependencyProvider::SERVICE_PROVIDER);
    }

    /**
     * @return \Silex\ServiceProviderInterface[]
     */
    protected function getInternalCallServiceProvider()
    {
        return $this->getProvidedDependency(ApplicationDependencyProvider::INTERNAL_CALL_SERVICE_PROVIDER);
    }

    /**
     * @return \Silex\ServiceProviderInterface[]
     */
    protected function getInternalCallServiceProviderWithAuthentication()
    {
        return $this->getProvidedDependency(ApplicationDependencyProvider::INTERNAL_CALL_SERVICE_PROVIDER_WITH_AUTHENTICATION);
    }

}
