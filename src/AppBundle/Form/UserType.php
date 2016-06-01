<?php
/**
 * Date: 01.06.16
 * Time: 16:17
 */

namespace AppBundle\Form;


use AppBundle\Entity\Currency;
use AppBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UserType
 * @package AppBundle\Form
 * @author  Eldar Shikhbadinov <s.eldar@ideas-world.net>
 */
class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'defaultCurrency',
                EntityType::class,
                array(
                    'label'        => 'label.default_currency',
                    'class'        => Currency::class,
                    'choice_label' => 'name'
                )
            );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => User::class,
            )
        );
    }
}