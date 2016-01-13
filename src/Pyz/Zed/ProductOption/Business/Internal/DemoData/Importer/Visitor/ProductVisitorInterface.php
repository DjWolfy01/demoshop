<?php

namespace Pyz\Zed\ProductOption\Business\Internal\DemoData\Importer\Visitor;

use Pyz\Zed\ProductOption\Business\Internal\DemoData\Importer\Node\ProductAbstract;
use Pyz\Zed\ProductOption\Business\Internal\DemoData\Importer\Node\ProductConcrete;
use Pyz\Zed\ProductOption\Business\Internal\DemoData\Importer\Node\ProductOptionType;
use Pyz\Zed\ProductOption\Business\Internal\DemoData\Importer\Node\ProductOptionTypeExclusion;
use Pyz\Zed\ProductOption\Business\Internal\DemoData\Importer\Node\ProductOptionValue;
use Pyz\Zed\ProductOption\Business\Internal\DemoData\Importer\Node\ProductOptionValueConstraint;
use Pyz\Zed\ProductOption\Business\Internal\DemoData\Importer\Node\ProductConfiguration;
use Pyz\Zed\ProductOption\Business\Internal\DemoData\Importer\Command\QueueableCommand;

interface ProductVisitorInterface
{

    /**
     * @param ProductAbstract|ProductConcrete|ProductOptionType|ProductOptionValue $context
     */
    public function setContext($context);

    public function leaveContext();

    /**
     * @return QueueableCommand[]
     */
    public function getCommandQueue();

    /**
     * @param ProductAbstract $visitee
     */
    public function visitProductAbstract(ProductAbstract $visitee);

    /**
     * @param ProductConcrete $visitee
     */
    public function visitProductConcrete(ProductConcrete $visitee);

    /**
     * @param ProductOptionType $visitee
     */
    public function visitProductOptionType(ProductOptionType $visitee);

    /**
     * @param ProductOptionTypeExclusion $visitee
     */
    public function visitProductOptionTypeExclusion(ProductOptionTypeExclusion $visitee);

    /**
     * @param ProductOptionValue $visitee
     */
    public function visitProductOptionValue(ProductOptionValue $visitee);

    /**
     * @param ProductOptionValueConstraint $visitee
     */
    public function visitProductOptionValueConstraint(ProductOptionValueConstraint $visitee);

    /**
     * @param ProductConfiguration $visitee
     */
    public function visitProductConfiguration(ProductConfiguration $visitee);

}
