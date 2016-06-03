<?php
/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\Application\Plugin\Provider;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\Provider\WebProfilerServiceProvider as SilexWebProfilerServiceProvider;
use Silex\ServiceProviderInterface;
use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Shared\Config\Config;
use Spryker\Yves\Kernel\AbstractPlugin;

class WebProfilerServiceProvider extends AbstractPlugin implements ServiceProviderInterface, ControllerProviderInterface
{

    /**
     * @var \Silex\Provider\WebProfilerServiceProvider
     */
    protected $silexWebProfiler;

    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    public function register(Application $app)
    {
        if (Config::get(ApplicationConstants::ENABLE_WEB_PROFILER)) {
            $this->getSilexWebProfiler()->register($app);
        }
    }

    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    public function boot(Application $app)
    {
        if (Config::get(ApplicationConstants::ENABLE_WEB_PROFILER)) {
            $this->getSilexWebProfiler()->boot($app);
        }
    }

    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    public function connect(Application $app)
    {
        if (Config::get(ApplicationConstants::ENABLE_WEB_PROFILER)) {
            $this->getSilexWebProfiler()->connect($app);
        }
    }

    /**
     * @return \Silex\Provider\WebProfilerServiceProvider
     */
    protected function getSilexWebProfiler()
    {
        if ($this->silexWebProfiler === null) {
            $this->silexWebProfiler = new SilexWebProfilerServiceProvider();
        }

        return $this->silexWebProfiler;
    }

}
