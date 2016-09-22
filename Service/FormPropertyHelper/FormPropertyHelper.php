<?php
/**
 * @author Anton Zoffmann
 * @copyright dasistweb GmbH (http://www.dasistweb.de)
 * Date: 21.09.16
 * Time: 12:00
 */

namespace Barbieswimcrew\Bundle\SymfonyFormRuleSetBundle\Service\FormPropertyHelper;


use Symfony\Component\Debug\Exception\ClassNotFoundException;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\ResolvedFormTypeInterface;

class FormPropertyHelper
{
    /**
     * @param FormInterface $form
     * @author Anton Zoffmann
     * @return string
     * @throws ClassNotFoundException
     */
    public function getConfiguredFormTypeByForm(FormInterface $form)
    {
        if (($resolvedType = $form->getConfig()->getType()) instanceof ResolvedFormTypeInterface) {
            $formTypeClassName = get_class($resolvedType->getInnerType());
        } else {
            $formTypeClassName = get_class($form->getConfig()->getType());
        }

        if(!class_exists($formTypeClassName)){
            throw new ClassNotFoundException(sprintf('Class "%s" not found', $formTypeClassName), null);
        }

        $formType = new $formTypeClassName();

        return $formType;
    }
}