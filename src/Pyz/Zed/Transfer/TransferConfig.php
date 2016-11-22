<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Transfer;

use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Shared\Config\Config;
use Spryker\Zed\Transfer\TransferConfig as SprykerTransferConfig;

class TransferConfig extends SprykerTransferConfig
{

    /**
     * @return array
     */
    public function getSourceDirectories()
    {
        $directories = parent::getSourceDirectories();
        $directories[] = Config::get(ApplicationConstants::APPLICATION_SPRYKER_ROOT) . '/../../code-generator/src/*/Shared/*/Transfer/';

        return $directories;
    }

}
