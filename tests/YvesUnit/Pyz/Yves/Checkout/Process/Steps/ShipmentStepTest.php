<?php
/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace YvesUnit\Pyz\Yves\Checkout\Process\Steps;

use Generated\Shared\Transfer\ExpenseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\ShipmentTransfer;
use Pyz\Yves\Checkout\Process\Steps\ShipmentStep;
use Spryker\Client\Calculation\CalculationClientInterface;
use Spryker\Shared\Shipment\ShipmentConstants;
use Spryker\Yves\StepEngine\Dependency\Plugin\Handler\StepHandlerPluginCollection;
use Spryker\Yves\StepEngine\Dependency\Plugin\Handler\StepHandlerPluginInterface;
use Symfony\Component\HttpFoundation\Request;

class ShipmentStepTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @return void
     */
    public function testShipmentStepExecuteShouldTriggerPlugins()
    {
        $shipmentPluginMock = $this->createShipmentMock();
        $shipmentPluginMock->expects($this->once())->method('addToDataClass');

        $shipmentStepHandler = new StepHandlerPluginCollection();
        $shipmentStepHandler->add($shipmentPluginMock, 'test');
        $shipmentStep = $this->createShipmentStep($shipmentStepHandler);

        $quoteTransfer = new QuoteTransfer();

        $shipmentTransfer = new ShipmentTransfer();
        $shipmentTransfer->setShipmentSelection('test');
        $quoteTransfer->setShipment($shipmentTransfer);

        $shipmentStep->execute($this->createRequest(), $quoteTransfer);
    }

    /**
     * @return void
     */
    public function testShipmentPostConditionsShouldReturnTrueWhenShipmentSet()
    {
        $quoteTransfer = new QuoteTransfer();
        $expenseTransfer = new ExpenseTransfer();
        $expenseTransfer->setType(ShipmentConstants::SHIPMENT_EXPENSE_TYPE);
        $quoteTransfer->addExpense($expenseTransfer);

        $shipmentStep = $this->createShipmentStep(new StepHandlerPluginCollection());

        $this->assertTrue($shipmentStep->postCondition($quoteTransfer));
    }

    /**
     * @return bool
     */
    public function testShipmentRequireInputShouldReturnTrue()
    {
        $shipmentStep = $this->createShipmentStep(new StepHandlerPluginCollection());
        $this->assertTrue($shipmentStep->requireInput(new QuoteTransfer()));
    }

    /**
     * @param \Spryker\Yves\StepEngine\Dependency\Plugin\Handler\StepHandlerPluginCollection $shipmentPlugins
     *
     * @return \Pyz\Yves\Checkout\Process\Steps\ShipmentStep
     */
    protected function createShipmentStep(StepHandlerPluginCollection $shipmentPlugins)
    {
        return new ShipmentStep(
            $this->createCalculationClientMock(),
            $shipmentPlugins,
            'shipment',
            'escape_route'
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    protected function createRequest()
    {
        return Request::createFromGlobals();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Client\Calculation\CalculationClientInterface
     */
    protected function createCalculationClientMock()
    {
        $calculationMock = $this->getMock(CalculationClientInterface::class);
        $calculationMock->method('recalculate')->willReturnArgument(0);

        return $calculationMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Yves\StepEngine\Dependency\Plugin\Handler\StepHandlerPluginInterface
     */
    protected function createShipmentMock()
    {
        return $this->getMock(StepHandlerPluginInterface::class);
    }

}
