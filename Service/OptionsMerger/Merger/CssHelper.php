<?php

namespace Barbieswimcrew\Bundle\DynamicFormBundle\Service\OptionsMerger\Merger;

/**
 * Class CssHelper
 * @package Barbieswimcrew\Bundle\DynamicFormBundle\Service\OptionsMerger\Merger
 */
class CssHelper
{
    /**
     * @var string
     */
    private $hiddenClass;

    /**
     * CssHelper constructor.
     * @param string $hiddenClass
     */
    public function __construct($hiddenClass)
    {
        $this->hiddenClass = $hiddenClass;
    }

    /**
     * @param array $originAttr
     * @param array $overrideAttr
     * @param bool $hidden
     * @return string
     */
    public function handleCssClasses(array $originAttr, array $overrideAttr, $hidden)
    {
        /** @var array $overrideClasses */
        $overrideClasses = array();

        if (array_key_exists('class', $overrideAttr)) {
            $overrideClasses = $this->explodeClasses($overrideAttr['class']);
        }

        /** @var array $originClasses */
        $originClasses = array();

        if (array_key_exists('class', $originAttr)) {
            $originClasses = $this->explodeClasses($originAttr['class']);
        }

        /** @var array $mergedClasses */
        $mergedClasses = $this->mergeClasses($originClasses, $overrideClasses);

        $mergedClasses = $this->handleHiddenClass($mergedClasses, $hidden);

        return $this->implodeClasses($mergedClasses);
    }

    /**
     * @param array $classes
     * @param boolean $hidden
     * @return array
     */
    public function handleHiddenClass(array $classes, $hidden)
    {

        return ($hidden) ? $this->appendHiddenClass($classes) : $this->removeHiddenClass($classes);

    }

    /**
     * @param array $classes
     * @return array
     */
    public function appendHiddenClass(array $classes)
    {
        if (!in_array($this->hiddenClass, $classes)) {
            $classes[] = $this->hiddenClass;
        }

        return $classes;

    }

    /**
     * @param array $classes
     * @return array
     */
    public function removeHiddenClass(array $classes)
    {
        return array_filter($classes, function ($class) {
            return ($class !== $this->hiddenClass);
        });
    }

    /**
     * merge class strings
     * @param array $originClasses
     * @param array $overrideClasses
     * @return array
     * @author Anton Zoffmann
     */
    public function mergeClasses(array $originClasses, array $overrideClasses)
    {
        return array_merge($originClasses, $overrideClasses);
    }

    /**
     * @param $classesString
     * @return array
     */
    public function explodeClasses($classesString)
    {
        return explode(' ', $classesString);
    }

    /**
     * @param array $classes
     * @return string
     */
    public function implodeClasses(array $classes)
    {
        return implode(' ', $classes);
    }

}