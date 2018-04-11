<?php
/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\AlexaBot\Model\Product;

use Pyz\Client\AlexaBot\AlexaBotConfig;
use Pyz\Client\AlexaBot\Model\FileSession\FileSessionInterface;
use Pyz\Client\Catalog\CatalogClientInterface;
use Pyz\Yves\Product\Mapper\StorageProductMapperInterface;
use Spryker\Client\Kernel\AbstractPlugin;

class AlexaProduct extends AbstractPlugin implements AlexaProductInterface
{
    const VARIANT_ATTRIBUTE_NAME = 'variant';

    /**
     * @var \Pyz\Client\AlexaBot\AlexaBotConfig
     */
    private $alexaBotConfig;

    /**
     * @var \Pyz\Client\Catalog\CatalogClientInterface
     */
    private $catalogClient;

    // TODO Product-1: inject the product client.

    /**
     * @var \Pyz\Yves\Product\Mapper\StorageProductMapper
     */
    private $storageProductMapper;

    /**
     * @var \Pyz\Client\AlexaBot\Model\FileSession\FileSessionInterface
     */
    private $fileSession;

    /**
     * @param \Pyz\Client\AlexaBot\AlexaBotConfig $alexaBotConfig
     * @param \Pyz\Client\Catalog\CatalogClientInterface $catalogClient
     * TODO Product-1: inject the product client.
     * @param \Pyz\Yves\Product\Mapper\StorageProductMapperInterface $storageProductMapper
     * @param \Pyz\Client\AlexaBot\Model\FileSession\FileSessionInterface $fileSession
     */
    public function __construct(
        AlexaBotConfig $alexaBotConfig,
        CatalogClientInterface $catalogClient,
        // TODO Product-1: inject the product client.
        StorageProductMapperInterface $storageProductMapper,
        FileSessionInterface $fileSession
    ) {
        $this->alexaBotConfig = $alexaBotConfig;
        $this->catalogClient = $catalogClient;
        // TODO Product-1: inject the product client.
        $this->storageProductMapper = $storageProductMapper;
        $this->fileSession = $fileSession;
    }

    /**
     * @param string $productName
     *
     * @return string[]
     */
    public function getVariantsByProductName($productName)
    {
        $abstractProductId = $this->getAbstractIdByNameAndWriteToSession($productName);
        $storageProductTransfer = $this->getStorageProduct($abstractProductId);

        return $storageProductTransfer->getSuperAttributes()[static::VARIANT_ATTRIBUTE_NAME];
    }

    /**
     * @param int $abstractProductId
     * @param string $variantName
     *
     * @return string
     */
    public function getVariantSkuByAbstractProductIdAndVariantName($abstractProductId, $variantName)
    {
        $selectedAttributes = [self::VARIANT_ATTRIBUTE_NAME => $variantName];
        $storageProductTransfer = $this->getStorageProduct($abstractProductId, $selectedAttributes);

        return $storageProductTransfer->getSku();
    }

    /**
     * @param string $productName
     *
     * @return int
     */
    private function getAbstractIdByNameAndWriteToSession($productName)
    {
        $catalogResponse = $this
            ->catalogClient
            ->catalogSuggestSearch($productName);

        $abstractProductId = $catalogResponse['suggestionByType']['product_abstract'][0]['id_product_abstract'];

        // TODO Product-2: write the abstract product ID to the file session to use it later by the add to cart action.

        return $abstractProductId;
    }

    /**
     * @param int $abstractProductId
     * @param array $selectedAttributes
     *
     * @return \Generated\Shared\Transfer\StorageProductTransfer
     */
    private function getStorageProduct($abstractProductId, $selectedAttributes = [])
    {
        $productData = $this
            ->productClient
            ->getProductAbstractFromStorageByIdForCurrentLocale($abstractProductId);

        $storageProductTransfer = $this
            ->storageProductMapper
            ->mapStorageProduct($productData, $selectedAttributes);

        return $storageProductTransfer;
    }
}
