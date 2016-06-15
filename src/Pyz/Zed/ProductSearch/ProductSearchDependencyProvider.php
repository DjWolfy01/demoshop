<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductSearch;

use Spryker\Zed\Kernel\Container;
use Spryker\Zed\ProductSearch\ProductSearchDependencyProvider as SprykerProductSearchDependencyProvider;

class ProductSearchDependencyProvider extends SprykerProductSearchDependencyProvider
{

    const FACADE_PRODUCT_SEARCH = 'product search facade';
    const FACADE_PRICE = 'price facade';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container[self::FACADE_PRICE] = function (Container $container) {
            return $container->getLocator()->price()->facade();
        };

        $container[self::FACADE_PRODUCT_SEARCH] = function (Container $container) {
            return $container->getLocator()->productSearch()->facade();
        };

        return $container;
    }

}
