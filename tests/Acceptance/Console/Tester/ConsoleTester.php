<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Acceptance\Console\Tester;

use Symfony\Component\Process\Process;

class ConsoleTester extends \AcceptanceTester
{

    /**
     * @return string
     */
    public function runConsoleApplication()
    {
        $cmd = 'vendor/bin/console';
        $process = new Process($cmd);
        $process->run();
        $output = $process->getOutput();

        return $output;
    }

}
