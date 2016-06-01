<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Twig;

use Symfony\Component\Translation\TranslatorInterface;

/**
 * Converts boolean value to a string representation
 * Class BooleanToStringConverterExtension
 * @package AppBundle\Twig
 * @author  Eldar Shikhbadinov <s.eldar@ideas-world.net>
 */
class BooleanToStringExtension extends \Twig_Extension
{
    /**
     * @var array
     */
    private $valueTranslations;

    public function __construct(TranslatorInterface $translator)
    {
        $this->valueTranslations = [
            'true'  => $translator->trans('label.true'),
            'false' => $translator->trans('label.false')
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('bool2string', array($this, 'booleanToString')),
        );
    }

    /**
     * Transforms the given boolean value to a string.
     *
     * @param boolean $value
     *
     * @return string
     */
    public function booleanToString($value)
    {
        return $value ? $this->valueTranslations['true'] : $this->valueTranslations['false'];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        // the name of the Twig extension must be unique in the application. Consider
        // using 'app.extension' if you only have one Twig extension in your application.
        return 'app.extension.bool2string';
    }
}
