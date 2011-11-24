<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Olivier Chauvel <olivier@generation-multiple.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Genemu\Bundle\FormBundle\Form\ChoiceList;

use Symfony\Component\Form\Extension\Core\ChoiceList\ArrayChoiceList;

/**
 * @author Olivier Chauvel <olivier@generation-multiple.com>
 */
class AutocompleteArrayChoiceList extends ArrayChoiceList
{
    private $ajax;

    public function __construct($choices, $ajax = false)
    {
        $this->ajax = $ajax;

        parent::__construct($choices);
    }


    /**
     * {@inheritdoc}
     */
    public function getChoices()
    {
        $choices = parent::getChoices();

        $array = array();
        foreach ($choices as $value => $label) {
            $array[] = array(
                'value' => $value,
                'label' => $label
            );
        }

        return $array;
    }

    /**
     * Get intersaction $choices to $values
     *
     * @param array $values
     *
     * @return array $intersect
     */
    public function getIntersect(array $values)
    {
        $intersect = array();

        if ($this->ajax) {
            foreach ($values as $value => $label) {
                $intersect[] = array(
                    'value' => $value,
                    'label' => $label
                );
            }
        } else {
            foreach ($this->getChoices() as $choice) {
                if (in_array($choice['value'], $values)) {
                    $intersect[] = $choice;
                }
            }
        }

        return $intersect;
    }
}