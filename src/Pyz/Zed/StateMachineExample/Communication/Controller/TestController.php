<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\StateMachineExample\Communication\Controller;

use Spryker\Zed\Application\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Zed\StateMachineExample\Communication\StateMachineExampleCommunicationFactory getFactory()
 * @method \Pyz\Zed\StateMachineExample\Business\StateMachineExampleFacade getFacade()
 * @method \Pyz\Zed\StateMachineExample\Persistence\StateMachineExampleQueryContainerInterface getQueryContainer()
 *
 */
class TestController extends AbstractController
{

    const STATE_MACHINE_NAME = 'Test';

    /**
     * @return array
     */
    public function listAction()
    {
        $stateMachineItems = $this->getFacade()
            ->getStateMachineItems();

        $stateMachineItems = $this->getStateMachineFacade()
            ->getProcessedStateMachineItems($stateMachineItems);

        $manualEvents = $this->getStateMachineFacade()
            ->getManualEventsForStateMachineItems($stateMachineItems);

        $stateMachineExampleItems = $this->getQueryContainer()
            ->queryAllStateMachineItems();

        return [
            'stateMachineExampleItems' => $stateMachineExampleItems,
            'manualEvents' => $manualEvents,
            'stateMachineItems' => $this->createStateMachineLookupTable($stateMachineItems)
        ];
    }

    /**
     * @param array|\Generated\Shared\Transfer\StateMachineItemTransfer[] $stateMachineItems
     *
     * @return array|\Generated\Shared\Transfer\StateMachineItemTransfer[]
     */
    public function createStateMachineLookupTable(array $stateMachineItems)
    {
        $lookupIndex = [];
        foreach ($stateMachineItems as $stateMachineItemTransfer) {
            $lookupIndex[$stateMachineItemTransfer->getIdentifier()] = $stateMachineItemTransfer;
        }

        return $lookupIndex;
    }

    /**
     * @throws \Propel\Runtime\Exception\PropelException
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addItemAction()
    {
        $this->getFacade()->createExampleItem();

        return new RedirectResponse('/state-machine-example/test/list');
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function deleteItemAction(Request $request)
    {
        $idStateMachineItem = $this->castId($request->query->get('id'));

        $this->getQueryContainer()
            ->queryStateMachineExampleItemByIdStateMachineItem($idStateMachineItem)
            ->delete();

        return new RedirectResponse('/state-machine-example/test/list');
    }

    /**
     * @return \Spryker\Zed\StateMachine\Business\StateMachineFacade
     */
    protected function getStateMachineFacade()
    {
        return $this->getFactory()->getStateMachineFacade();
    }

}
