<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\Twig\Plugin;

use Spryker\Yves\Application\Application;
use Spryker\Yves\Kernel\AbstractPlugin;

/**
 * @method \Pyz\Yves\Twig\TwigFactory getFactory()
 */
class TwigYves extends AbstractPlugin
{

    /**
     * @param \Spryker\Yves\Application\Application $application
     *
     * @return \Twig_Extension
     */
    public function getTwigYvesExtension(Application $application)
    {
        return $this->getFactory()
            ->createYvesTwigExtension($application);
    }

}
