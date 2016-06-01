<?php
/**
 * Date: 01.06.16
 * Time: 16:17
 */

namespace AppBundle\Form;


use AppBundle\Entity\Currency;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CurrencyType
 * @package AppBundle\Form
 * @author  Eldar Shikhbadinov <s.eldar@ideas-world.net>
 */
class CurrencyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'label.name'])
            ->add('numCode', TextType::class, ['label' => 'label.currency.num_code'])
            ->add('charCode', TextType::class, ['label' => 'label.currency.char_code'])
            ->add('rateToRuble', MoneyType::class, ['label' => 'label.currency.rate_to_ruble', 'currency' => 'RUR'])
            ->add(
                'default',
                ChoiceType::class,
                [
                    'label'              => 'label.is_default',
                    'choices'            => [
                        '0' => 'label.false',
                        '1' => 'label.true'
                    ],
                    'translation_domain' => 'messages'
                ]
            );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => Currency::class,
            )
        );
    }
}