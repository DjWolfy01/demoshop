<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\Product\Plugin;

use Pyz\Yves\Twig\Dependency\Plugin\TwigFilterPluginInterface;
use Pyz\Yves\Twig\Dependency\Plugin\TwigFunctionPluginInterface;
use Silex\Application;
use Spryker\Shared\Library\Currency\CurrencyManager;
use Spryker\Yves\Kernel\AbstractPlugin;
use Twig_SimpleFilter;
use Twig_SimpleFunction;

class TwigPrice extends AbstractPlugin implements TwigFilterPluginInterface, TwigFunctionPluginInterface
{

    /**
     * @return \Twig_SimpleFilter[]
     */
    public function getFilters()
    {
        return [
            $this->getPriceFilter(),
            $this->getPriceRawFilter(),
        ];
    }

    /**
     * @param \Silex\Application $application
     *
     * @return \Twig_SimpleFunction[]
     */
    public function getFunctions(Application $application)
    {
        return [
            new Twig_SimpleFunction('getItemTotalPrice', function ($grossPrice, $quantity = 1) {
                return $grossPrice * $quantity;
            }),
        ];
    }

    /**
     * @return \Twig_SimpleFilter
     */
    private function getPriceFilter()
    {
        return new Twig_SimpleFilter('price', function ($priceValue, $withSymbol = true) {
            $priceValue = CurrencyManager::getInstance()->convertCentToDecimal($priceValue);

            return CurrencyManager::getInstance()->format($priceValue, $withSymbol);
        });
    }

    /**
     * @return \Twig_SimpleFilter
     */
    private function getPriceRawFilter()
    {
        return new Twig_SimpleFilter('priceRaw', function ($priceValue) {
            $priceValue = CurrencyManager::getInstance()->convertCentToDecimal($priceValue);

            return $priceValue;
        });
    }

}
