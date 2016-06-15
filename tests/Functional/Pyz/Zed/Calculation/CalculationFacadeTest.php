<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Functional\Pyz\Zed\Calculation;

use Codeception\TestCase\Test;
use Generated\Shared\Transfer\DiscountTransfer;
use Generated\Shared\Transfer\ExpenseTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\ProductOptionTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Orm\Zed\Discount\Persistence\Base\SpyDiscountQuery;
use Orm\Zed\Discount\Persistence\SpyDiscount;
use Orm\Zed\Discount\Persistence\SpyDiscountCollector;
use Orm\Zed\Discount\Persistence\SpyDiscountVoucher;
use Orm\Zed\Discount\Persistence\SpyDiscountVoucherPool;
use Spryker\Zed\Calculation\Business\CalculationFacade;
use Spryker\Zed\Discount\DiscountDependencyProvider;

class CalculationFacadeTest extends Test
{

    /**
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->resetCurrentDiscounts();
    }

    /**
     * @return void
     */
    public function testCalculatorStackWithoutDiscounts()
    {
        $calculationFacade = $this->createCalculationFacade();
        $quoteTransfer = $this->createFixtureDataForCalculation();

        $recalculatedQuoteTransfer = $calculationFacade->recalculate($quoteTransfer);

        $itemTransfer = $recalculatedQuoteTransfer->getItems()[0];

        $this->assertEquals(100, $itemTransfer->getUnitGrossPrice());
        $this->assertEquals(200, $itemTransfer->getSumGrossPrice());

        $this->assertEquals(100, $itemTransfer->getUnitGrossPriceWithDiscounts());
        $this->assertEquals(200, $itemTransfer->getSumGrossPriceWithDiscounts());

        $this->assertEquals(125, $itemTransfer->getUnitGrossPriceWithProductOptions());
        $this->assertEquals(250, $itemTransfer->getSumGrossPriceWithProductOptions());

        $this->assertEquals(125, $itemTransfer->getUnitGrossPriceWithProductOptionAndDiscountAmounts());
        $this->assertEquals(250, $itemTransfer->getSumGrossPriceWithProductOptionAndDiscountAmounts());

        $this->assertEquals(0, $itemTransfer->getUnitTotalDiscountAmount());
        $this->assertEquals(0, $itemTransfer->getSumTotalDiscountAmount());

        $this->assertEquals(0, $itemTransfer->getUnitTotalDiscountAmountWithProductOption());
        $this->assertEquals(0, $itemTransfer->getSumTotalDiscountAmountWithProductOption());

        $totalsTransfer = $recalculatedQuoteTransfer->getTotals();
        $this->assertEquals(250, $totalsTransfer->getSubtotal());
        $this->assertEquals(0, $totalsTransfer->getDiscountTotal());
        $this->assertEquals(100, $totalsTransfer->getExpenseTotal());
        $this->assertEquals(350, $totalsTransfer->getGrandTotal());
        $this->assertEquals(19, $totalsTransfer->getTaxTotal()->getTaxRate());
        $this->assertEquals(56, $totalsTransfer->getTaxTotal()->getAmount());
    }

    /**
     * @return void
     */
    public function testCalculatorStackWithDiscounts()
    {
        $calculationFacade = $this->createCalculationFacade();

        $discountAmount = 20;
        $quoteTransfer = $this->createFixtureDataForCalculation();
        $voucherEntity = $this->createDiscounts($discountAmount, DiscountDependencyProvider::PLUGIN_CALCULATOR_FIXED);

        $voucherDiscountTransfer = new DiscountTransfer();
        $voucherDiscountTransfer->setVoucherCode($voucherEntity->getCode());
        $quoteTransfer->addVoucherDiscount($voucherDiscountTransfer);

        $recalculatedQuoteTransfer = $calculationFacade->recalculate($quoteTransfer);

        //item totals
        $itemTransfer = $recalculatedQuoteTransfer->getItems()[0];

        $this->assertEquals(100, $itemTransfer->getUnitGrossPrice());
        $this->assertEquals(200, $itemTransfer->getSumGrossPrice());

        $this->assertEquals(90, $itemTransfer->getUnitGrossPriceWithDiscounts());
        $this->assertEquals(180, $itemTransfer->getSumGrossPriceWithDiscounts());

        $this->assertEquals(125, $itemTransfer->getUnitGrossPriceWithProductOptions());
        $this->assertEquals(250, $itemTransfer->getSumGrossPriceWithProductOptions());

        $this->assertEquals(115, $itemTransfer->getUnitGrossPriceWithProductOptionAndDiscountAmounts());
        $this->assertEquals(230, $itemTransfer->getSumGrossPriceWithProductOptionAndDiscountAmounts());

        $this->assertEquals(10, $itemTransfer->getUnitTotalDiscountAmount());
        $this->assertEquals(20, $itemTransfer->getSumTotalDiscountAmount());

        $this->assertEquals(10, $itemTransfer->getUnitTotalDiscountAmountWithProductOption());
        $this->assertEquals(20, $itemTransfer->getSumTotalDiscountAmountWithProductOption());

        //expenses
        $expenseTransfer = $quoteTransfer->getExpenses()[0];

        $this->assertEquals(100, $expenseTransfer->getSumGrossPriceWithDiscounts());
        $this->assertEquals(0, $expenseTransfer->getSumTotalDiscountAmount());

        $this->assertEquals(
            $discountAmount,
            ($expenseTransfer->getSumTotalDiscountAmount() + $itemTransfer->getSumTotalDiscountAmountWithProductOption())
        );

        //order totals
        $totalsTransfer = $recalculatedQuoteTransfer->getTotals();

        $this->assertEquals(250, $totalsTransfer->getSubtotal());
        $this->assertEquals($discountAmount, $totalsTransfer->getDiscountTotal());
        $this->assertEquals(100, $totalsTransfer->getExpenseTotal());
        $this->assertEquals(330, $totalsTransfer->getGrandTotal());
        $this->assertEquals(19, $totalsTransfer->getTaxTotal()->getTaxRate());
        $this->assertEquals(53, $totalsTransfer->getTaxTotal()->getAmount());

    }

    /**
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    protected function createFixtureDataForCalculation()
    {
        $quoteTransfer = new QuoteTransfer();

        $itemTransfer = new ItemTransfer();
        $itemTransfer->setSku('test1');
        $itemTransfer->setTaxRate(19);
        $itemTransfer->setQuantity(2);
        $itemTransfer->setUnitGrossPrice(100);

        $productOptionTransfer = new ProductOptionTransfer();
        $productOptionTransfer->setTaxRate(19);
        $productOptionTransfer->setQuantity(2);
        $productOptionTransfer->setUnitGrossPrice(25);

        $itemTransfer->addProductOption($productOptionTransfer);

        $quoteTransfer->addItem($itemTransfer);

        $expenseTransfer = new ExpenseTransfer();
        $expenseTransfer->setUnitGrossPrice(100);
        $expenseTransfer->setQuantity(1);
        $quoteTransfer->addExpense($expenseTransfer);

        return $quoteTransfer;
    }

    /**
     * @param int $discountAmount
     * @param string $calculatorType
     * @return \Orm\Zed\Discount\Persistence\SpyDiscountVoucher
     * @throws \Propel\Runtime\Exception\PropelException
     */
    protected function createDiscounts($discountAmount, $calculatorType)
    {
        $discountVoucherPoolEntity = new SpyDiscountVoucherPool();
        $discountVoucherPoolEntity->setName('test-pool');
        $discountVoucherPoolEntity->setIsActive(true);
        $discountVoucherPoolEntity->save();

        $discountVoucherEntity = new SpyDiscountVoucher();
        $discountVoucherEntity->setCode('spryker-test');
        $discountVoucherEntity->setIsActive(true);
        $discountVoucherEntity->setFkDiscountVoucherPool($discountVoucherPoolEntity->getIdDiscountVoucherPool());
        $discountVoucherEntity->save();

        $discountEntity = new SpyDiscount();
        $discountEntity->setAmount($discountAmount);
        $discountEntity->setDisplayName('test1');
        $discountEntity->setIsActive(1);
        $discountEntity->setValidFrom(new \DateTime('1985-07-01'));
        $discountEntity->setValidTo(new \DateTime('2050-07-01'));
        $discountEntity->setCollectorLogicalOperator('AND');
        $discountEntity->setCalculatorPlugin($calculatorType);
        $discountEntity->setFkDiscountVoucherPool($discountVoucherPoolEntity->getIdDiscountVoucherPool());
        $discountEntity->save();

        $collectorEntity = new SpyDiscountCollector();
        $collectorEntity->setCollectorPlugin(DiscountDependencyProvider::PLUGIN_COLLECTOR_ITEM);
        $collectorEntity->setFkDiscount($discountEntity->getIdDiscount());
        $collectorEntity->save();

        $discountEntity->reload(true);
        $pool = $discountEntity->getVoucherPool();
        $pool->getDiscountVouchers();

        return $discountVoucherEntity;

    }

    /**
     * @return \Spryker\Zed\Calculation\Business\CalculationFacade
     */
    protected function createCalculationFacade()
    {
        return new CalculationFacade();
    }

    /**
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     */
    protected function resetCurrentDiscounts()
    {
        $discounts = SpyDiscountQuery::create()->find();
        foreach ($discounts as $discountEntity) {
            $discountEntity->setIsActive(false);
            $discountEntity->save();
        }
    }

}
