<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\Newsletter;

use Pyz\Yves\Newsletter\Form\NewsletterSubscriptionForm;
use Spryker\Yves\Kernel\AbstractFactory;

class NewsletterFactory extends AbstractFactory
{

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createNewsletterSubscriptionForm()
    {
        return $this->getFormFactory()
            ->create($this->createNewsletterSubscriptionFormType());
    }

    /**
     * @return \Symfony\Component\Form\AbstractType
     */
    protected function createNewsletterSubscriptionFormType()
    {
        return new NewsletterSubscriptionForm();
    }

}
