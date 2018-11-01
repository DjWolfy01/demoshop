<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport;

use Spryker\Shared\Kernel\Store;
use Spryker\Zed\DataImport\DataImportDependencyProvider as SprykerDataImportDependencyProvider;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\PriceProductDataImport\Communication\Plugin\PriceProductDataImportPlugin;

class DataImportDependencyProvider extends SprykerDataImportDependencyProvider
{
    public const FACADE_AVAILABILITY = 'availability facade';
    public const FACADE_CATEGORY = 'category facade';
    public const FACADE_PRODUCT_BUNDLE = 'product bundle facade';
    public const FACADE_PRODUCT_RELATION = 'product relation facade';
    public const FACADE_PRODUCT_SEARCH = 'product search facade';
    public const STORE = 'store';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        parent::provideBusinessLayerDependencies($container);

        $this->addAvailabilityFacade($container);
        $this->addCategoryFacade($container);
        $this->addProductBundleFacade($container);
        $this->addProductRelationFacade($container);
        $this->addProductSearchFacade($container);
        $this->addStore($container);

        return $container;
    }

    /**
     * @return array
     */
    protected function getDataImporterPlugins(): array
    {
        return [
            new PriceProductDataImportPlugin(),
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    private function addAvailabilityFacade(Container $container)
    {
        $container[static::FACADE_AVAILABILITY] = function (Container $container) {
            return $container->getLocator()->availability()->facade();
        };
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    private function addCategoryFacade(Container $container)
    {
        $container[static::FACADE_CATEGORY] = function (Container $container) {
            return $container->getLocator()->category()->facade();
        };
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    private function addProductBundleFacade(Container $container)
    {
        $container[static::FACADE_PRODUCT_BUNDLE] = function (Container $container) {
            return $container->getLocator()->productBundle()->facade();
        };
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    private function addProductSearchFacade(Container $container)
    {
        $container[static::FACADE_PRODUCT_SEARCH] = function (Container $container) {
            return $container->getLocator()->productSearch()->facade();
        };
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    private function addProductRelationFacade(Container $container)
    {
        $container[static::FACADE_PRODUCT_RELATION] = function (Container $container) {
            return $container->getLocator()->productRelation()->facade();
        };
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    private function addStore(Container $container)
    {
        $container[static::STORE] = function (Container $container) {
            return Store::getInstance();
        };
    }
}
