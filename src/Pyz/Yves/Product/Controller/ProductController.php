<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\Product\Controller;

use Spryker\Shared\Product\Model\ProductAbstractInterface;
use Spryker\Yves\Application\Controller\AbstractController;

/**
 * @method \Pyz\Yves\Product\ProductFactory getFactory()
 */
class ProductController extends AbstractController
{

    /**
     * @param \Spryker\Shared\Product\Model\ProductAbstractInterface $product
     *
     * @return array
     */
    public function detailAction(ProductAbstractInterface $product)
    {
        $categories = $product->getCategory();

        $storageAvailabilityTransfer = $this->getFactory()
            ->getAvailabilityClient()
            ->getProductAvailabilityByIdProductAbstract($product->getAbstractProductId());

        $productData = [
            'product' => $product,
            'productCategories' => $categories,
            'category' => count($categories) ? end($categories) : null,
            'availability' => $storageAvailabilityTransfer,
        ];
        return $productData;
    }

}
