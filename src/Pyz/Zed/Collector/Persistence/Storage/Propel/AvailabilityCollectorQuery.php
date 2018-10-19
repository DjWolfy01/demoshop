<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Collector\Persistence\Storage\Propel;

use Orm\Zed\Availability\Persistence\Map\SpyAvailabilityAbstractTableMap;
use Orm\Zed\Product\Persistence\Map\SpyProductAbstractTableMap;
use Orm\Zed\Touch\Persistence\Map\SpyTouchTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Collector\Persistence\Collector\AbstractPropelCollectorQuery;

class AvailabilityCollectorQuery extends AbstractPropelCollectorQuery
{
    public const ID_PRODUCT_ABSTRACT = 'id_product_abstract';
    public const ID_AVAILABILITY_ABSTRACT = 'id_availability_abstract';
    public const QUANTITY = 'quantity';

    /**
     * @return void
     */
    protected function prepareQuery()
    {
        $this->touchQuery->addJoin(
            SpyTouchTableMap::COL_ITEM_ID,
            SpyAvailabilityAbstractTableMap::COL_ID_AVAILABILITY_ABSTRACT,
            Criteria::INNER_JOIN
        );

        $this->touchQuery->addJoin(
            [
                SpyAvailabilityAbstractTableMap::COL_ABSTRACT_SKU,
                SpyAvailabilityAbstractTableMap::COL_FK_STORE,
            ],
            [
                SpyProductAbstractTableMap::COL_SKU,
                $this->getStoreTransfer()->getIdStore(),
            ],
            Criteria::INNER_JOIN
        );

        $this->touchQuery->withColumn(SpyAvailabilityAbstractTableMap::COL_QUANTITY, self::QUANTITY);
        $this->touchQuery->withColumn(SpyAvailabilityAbstractTableMap::COL_ID_AVAILABILITY_ABSTRACT, self::ID_AVAILABILITY_ABSTRACT);
        $this->touchQuery->withColumn(SpyProductAbstractTableMap::COL_ID_PRODUCT_ABSTRACT, self::ID_PRODUCT_ABSTRACT);
    }
}
