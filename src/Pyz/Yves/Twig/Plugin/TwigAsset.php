<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\Twig\Plugin;

use Pyz\Yves\Twig\Dependency\Plugin\TwigFunctionPluginInterface;
use Silex\Application;
use Spryker\Yves\Kernel\AbstractPlugin;
use Twig_SimpleFunction;

/**
 * @method \Pyz\Yves\Twig\TwigFactory getFactory()
 */
class TwigAsset extends AbstractPlugin implements TwigFunctionPluginInterface
{

    /**
     * @param \Silex\Application $application
     *
     * @return \Twig_SimpleFunction[]
     */
    public function getFunctions(Application $application)
    {
        $isDomainSecured = $this->isDomainSecured($application);
        $assetUrlBuilder = $this->getFactory()->createAssetUrlBuilder($isDomainSecured);
        $mediaUrlBuilder = $this->getFactory()->createMediaUrlBuilder($isDomainSecured);

        return [
            new Twig_SimpleFunction('asset', function ($value) use ($assetUrlBuilder) {
                return $assetUrlBuilder->buildUrl($value);
            }),
            new Twig_SimpleFunction('media', function ($value) use ($mediaUrlBuilder) {
                return $mediaUrlBuilder->buildUrl($value);
            }),
        ];
    }

    /**
     * @param \Silex\Application $application
     *
     * @return \Symfony\Component\HttpFoundation\RequestStack
     */
    private function getRequestStack(Application $application)
    {
        $requestStack = $application['request_stack'];

        return $requestStack;
    }

    /**
     * @param \Silex\Application $application
     *
     * @return bool
     */
    private function isDomainSecured(Application $application)
    {
        $requestStack = $this->getRequestStack($application);

        return $requestStack->getCurrentRequest()->isSecure();
    }

}
