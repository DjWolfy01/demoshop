<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\Customer\Form;

use Spryker\Yves\Kernel\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @method \Pyz\Yves\Customer\CustomerConfig getConfig()
 */
class NewsletterSubscriptionForm extends AbstractType
{
    public const FIELD_SUBSCRIBE = 'subscribe';

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'newsletterSubscriptionForm';
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->addSubscribeField($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addSubscribeField(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_SUBSCRIBE, CheckboxType::class, [
            'label' => 'customer.newsletter.subscription_agreement',
            'required' => false,
        ]);

        return $this;
    }
}
