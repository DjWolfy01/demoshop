<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\Checkout\Form\Steps;

use Spryker\Yves\StepEngine\Dependency\Plugin\Form\SubFormPluginCollection;
use Spryker\Yves\StepEngine\Dependency\Plugin\Form\SubFormPluginInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ShipmentForm extends AbstractType
{

    const SHIPMENT_PROPERTY_PATH = 'shipment';
    const SHIPMENT_SELECTION = 'shipmentSelection';
    const SHIPMENT_SELECTION_PROPERTY_PATH = self::SHIPMENT_PROPERTY_PATH . '.' . self::SHIPMENT_SELECTION;

    /**
     * @var \Spryker\Yves\StepEngine\Dependency\Plugin\Form\SubFormPluginCollection
     */
    protected $shipmentMethodsSubFormPlugins;

    /**
     * @param \Spryker\Yves\StepEngine\Dependency\Plugin\Form\SubFormPluginCollection $shipmentMethodsSubFormPlugins
     */
    public function __construct(SubFormPluginCollection $shipmentMethodsSubFormPlugins)
    {
        $this->shipmentMethodsSubFormPlugins = $shipmentMethodsSubFormPlugins;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'shipmentForm';
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->addShipmentMethods($builder, $options);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addShipmentMethods(FormBuilderInterface $builder, array $options)
    {
        $shipmentMethodSubForms = $this->getShipmentMethodSubForms();
        $shipmentMethodChoices = $this->getShipmentMethodsChoices($shipmentMethodSubForms);

        $this->addShipmentMethodChoices($builder, $shipmentMethodChoices)
            ->addShipmentMethodSubForms($builder, $shipmentMethodSubForms, $options);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $shipmentMethodChoices
     *
     * @return $this
     */
    protected function addShipmentMethodChoices(FormBuilderInterface $builder, array $shipmentMethodChoices)
    {
        $builder->add(
            self::SHIPMENT_SELECTION,
            'choice',
            [
                'choices' => $shipmentMethodChoices,
                'label' => false,
                'required' => true,
                'expanded' => true,
                'multiple' => false,
                'empty_value' => false,
                'property_path' => self::SHIPMENT_SELECTION_PROPERTY_PATH,
            ]
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param \Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface[] $shipmentMethodSubForms
     * @param array $options
     *
     * @return $this
     */
    protected function addShipmentMethodSubForms(FormBuilderInterface $builder, array $shipmentMethodSubForms, array $options)
    {
        foreach ($shipmentMethodSubForms as $shipmentMethodSubForm) {
            $builder->add(
                $shipmentMethodSubForm->getName(),
                $shipmentMethodSubForm,
                [
                    'property_path' => self::SHIPMENT_PROPERTY_PATH . '.' . $shipmentMethodSubForm->getPropertyPath(),
                    'error_bubbling' => true,
                    'select_options' => $options['select_options']
                ]
            );
        }

        return $this;
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Plugin\Form\SubFormPluginCollection
     */
    protected function getShipmentMethodSubForms()
    {
        $shipmentMethodSubForms = [];

        foreach ($this->shipmentMethodsSubFormPlugins as $shipmentMethodSubForm) {
            $shipmentMethodSubForms[] = $this->createSubForm($shipmentMethodSubForm);
        }

        return $shipmentMethodSubForms;
    }

    /**
     * @param \Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface[] $shipmentMethodSubForms
     *
     * @return array
     */
    protected function getShipmentMethodsChoices(array $shipmentMethodSubForms)
    {
        $choices = [];

        foreach ($shipmentMethodSubForms as $shipmentMethodSubForm) {
            $subFormName = $shipmentMethodSubForm->getName();
            $choices[$subFormName] = str_replace('_', ' ', $subFormName);
        }

        return $choices;
    }

    /**
     * @param \Spryker\Yves\StepEngine\Dependency\Plugin\Form\SubFormPluginInterface $shipmentMethodSubForm
     *
     * @return \Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface
     */
    protected function createSubForm(SubFormPluginInterface $shipmentMethodSubForm)
    {
        return $shipmentMethodSubForm->createSubForm();
    }


    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     *
     * @return void
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setRequired('select_options');
    }

}
