<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductSearch\Business\Map;

use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\PageMapTransfer;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\Price\Business\PriceFacadeInterface;
use Spryker\Zed\ProductSearch\Business\ProductSearchFacadeInterface;
use Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface;

/**
 * @method \Pyz\Zed\Collector\Communication\CollectorCommunicationFactory getFactory()
 */
class ProductDataPageMapBuilder
{

    /**
     * @var \Spryker\Zed\Price\Business\PriceFacadeInterface
     */
    protected $priceFacade;

    /**
     * @var \Spryker\Zed\ProductSearch\Business\ProductSearchFacadeInterface
     */
    protected $productSearchFacade;

    /**
     * @var \Generated\Shared\Transfer\ProductSearchAttributeMapTransfer[]
     */
    protected $attributeMap;

    /**
     * @param \Spryker\Zed\ProductSearch\Business\ProductSearchFacadeInterface $productSearchFacade
     * @param \Spryker\Zed\Price\Business\PriceFacadeInterface $priceFacade
     */
    public function __construct(ProductSearchFacadeInterface $productSearchFacade, PriceFacadeInterface $priceFacade)
    {
        $this->priceFacade = $priceFacade;
        $this->productSearchFacade = $productSearchFacade;
    }

    /**
     * @param \Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface $pageMapBuilder
     * @param array $productData
     * @param \Generated\Shared\Transfer\LocaleTransfer $locale
     *
     * @return \Generated\Shared\Transfer\PageMapTransfer
     */
    public function buildPageMap(PageMapBuilderInterface $pageMapBuilder, array $productData, LocaleTransfer $locale)
    {
        $pageMapTransfer = (new PageMapTransfer())
            ->setStore(Store::getInstance()->getStoreName())
            ->setLocale($locale->getLocaleName());

        $attributes = $this->getProductAttributes($productData);
        $price = $this->getPriceBySku($productData['abstract_sku']);

        /*
         * Here you can hard code which product data will be used for which search functionality
         */
        $pageMapBuilder
            ->addSearchResultData($pageMapTransfer, 'id_product_abstract', $productData['id_product_abstract'])
            ->addSearchResultData($pageMapTransfer, 'abstract_sku', $productData['abstract_sku'])
            ->addSearchResultData($pageMapTransfer, 'abstract_name', $productData['abstract_name'])
            ->addSearchResultData($pageMapTransfer, 'price', $price)
            ->addSearchResultData($pageMapTransfer, 'url', $this->getProductUrl($productData))
            ->addSearchResultData($pageMapTransfer, 'available', $this->isAvailable($productData))
            ->addFullTextBoosted($pageMapTransfer, $productData['abstract_name'])
            ->addSuggestionTerms($pageMapTransfer, $productData['abstract_name'])
            ->addCompletionTerms($pageMapTransfer, $productData['abstract_name'])
            ->addStringSort($pageMapTransfer, 'name', $productData['abstract_name'])
            ->addIntegerSort($pageMapTransfer, 'price', $price)
            ->addIntegerFacet($pageMapTransfer, 'price', $price)
            ->addCategory($pageMapTransfer, $this->getAllParentCategories($productData), $this->getDirectParentCategories($productData));

        /*
         * We'll then extend this with dynamically configured product attributes from database
         */
        $pageMapTransfer = $this
            ->productSearchFacade
            ->mapDynamicProductAttributes($pageMapBuilder, $pageMapTransfer, $attributes);

        return $pageMapTransfer;
    }

    /**
     * @param array $productData
     *
     * @return array
     */
    protected function getProductAttributes(array $productData)
    {
        $abstractAttributes = $this->getEncodedAttributeData($productData['abstract_attributes']);
        $abstractLocalizedAttributes = $this->getEncodedAttributeData($productData['abstract_localized_attributes']);
        $concreteAttributes = $this->getEncodedAttributeData($productData['concrete_attributes']);
        $concreteLocalizedAttributes = $this->getEncodedAttributeData($productData['concrete_localized_attributes']);

        $attributes = array_merge(
            $abstractAttributes,
            $abstractLocalizedAttributes,
            $concreteAttributes,
            $concreteLocalizedAttributes
        );

        return $attributes;
    }

    /**
     * @param string $data
     *
     * @return array
     */
    protected function getEncodedAttributeData($data)
    {
        $data = '[' . $data . ']';

        $array = json_decode($data, true);

        if (!is_array($array)) {
            throw new \RuntimeException('Invalid JSON data: ' . json_last_error_msg() . ' - ' . print_r($data, true));
        }

        return array_shift($array);
    }

    /**
     * @param string $sku
     *
     * @return int
     */
    protected function getPriceBySku($sku)
    {
        return $this->priceFacade->getPriceBySku($sku);
    }

    /**
     * @param array $productData
     *
     * @return bool
     */
    protected function getProductUrl(array $productData)
    {
        $productUrls = explode(',', $productData['product_urls']);

        return $productUrls[0];
    }

    /**
     * @param array $productData
     *
     * @return bool
     * TODO: put this to Stock or Availability facade (there's also a ticket for this: https://github.com/spryker/spryker/issues/1935 )
     */
    protected function isAvailable(array $productData)
    {
        $isAvailable = (bool)(
            $productData['is_never_out_of_stock'] ||
            $productData['quantity'] > 0
        );

        return $isAvailable;
    }

    /**
     * @param array $productData
     *
     * @return mixed
     */
    protected function getDirectParentCategories(array $productData)
    {
        return explode(',', $productData['node_id']);
    }

    /**
     * @param array $productData
     *
     * @return mixed
     */
    protected function getAllParentCategories(array $productData)
    {
        return explode(',', $productData['category_parent_ids']);
    }

}
