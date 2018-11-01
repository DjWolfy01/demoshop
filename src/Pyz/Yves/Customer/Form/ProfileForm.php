<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\Customer\Form;

use Spryker\Yves\Kernel\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProfileForm extends AbstractType
{
    public const FIELD_EMAIL = 'email';
    public const FIELD_LAST_NAME = 'last_name';
    public const FIELD_FIRST_NAME = 'first_name';
    public const FIELD_SALUTATION = 'salutation';

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'profileForm';
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this
            ->addSalutationField($builder)
            ->addFirstNameField($builder)
            ->addLastNameField($builder)
            ->addEmailField($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    public function addEmailField(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_EMAIL, EmailType::class, [
            'label' => 'customer.profile.email',
            'required' => true,
            'constraints' => [
                new NotBlank(),
                new Email(),
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    public function addLastNameField(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_LAST_NAME, TextType::class, [
            'label' => 'customer.profile.last_name',
            'required' => true,
            'constraints' => [
                new NotBlank(),
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    public function addFirstNameField(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_FIRST_NAME, TextType::class, [
            'label' => 'customer.profile.first_name',
            'required' => true,
            'constraints' => [
                new NotBlank(),
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    public function addSalutationField(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_SALUTATION, ChoiceType::class, [
            'choices' => [
                'customer.salutation.mr' => 'Mr',
                'customer.salutation.ms' => 'Ms',
                'customer.salutation.mrs' => 'Mrs',
                'customer.salutation.dr' => 'Dr',
            ],
            'label' => 'profile.form.salutation',
            'required' => false,
            'constraints' => [
                new NotBlank(),
            ],
        ]);

        return $this;
    }
}
