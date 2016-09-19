<?php
/**
 * @author Anton Zoffmann
 * @copyright dasistweb GmbH (http://www.dasistweb.de)
 * Date: 19.09.16
 * Time: 12:24
 */

namespace Barbieswimcrew\Bundle\SymfonyFormRuleSetBundle\Form\Extension;


use Barbieswimcrew\Bundle\SymfonyFormRuleSetBundle\Exceptions\Rules\NoRuleDefinedException;
use Barbieswimcrew\Bundle\SymfonyFormRuleSetBundle\Structs\Rules\Base\RuleSetInterface;
use Barbieswimcrew\Bundle\SymfonyFormRuleSetBundle\Structs\Rules\RuleSet;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RelatedCheckboxTypeExtension extends AbstractRelatedExtension
{

    /**
     * Returns the name of the type being extended.
     * @return string The name of the type being extended
     */
    public function getExtendedType()
    {
        return CheckboxType::class;
    }

    /**
     * Registering the new form field options
     * @param OptionsResolver $resolver
     * @author Anton Zoffmann
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $this->defineNewFieldOption($resolver, self::OPTION_NAME_RULES, null, array(RuleSetInterface::class, 'null'));
    }

    /**
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     * @author Anton Zoffmann
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        parent::finishView($view, $form, $options);

        /** @var RuleSet $ruleSet */
        $ruleSet = $options[self::OPTION_NAME_RULES];

        if (!$ruleSet instanceof RuleSetInterface) {
            return;
        }

        # if expanded option is set true, append the data attributes to the underlying form child radio elements
        try {
            $checked = ($view->vars['checked'] === true ? 1 : 0);
            $rule = $ruleSet->getRule($checked);
            $view->vars['attr'] = $this->replaceAttributes($view, $rule);
        } catch (NoRuleDefinedException $exception) {
            # nothing to do, just interrupt the workflow
        }

    }
}