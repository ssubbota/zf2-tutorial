<?php
/**
 * Zucchi (http://zucchi.co.uk)
 *
 * @link      http://github.com/zucchi/Zucchi for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zucchi Limited. (http://zucchi.co.uk)
 * @license   http://zucchi.co.uk/legals/bsd-license New BSD License
 */
namespace Zucchi\Filter\Cast;

use Zend\Filter\AbstractFilter;

/**
 * Filter to cast value to an inteter
 * 
 * @author Matt Cockayne <matt@zucchi.co.uk>
 * @package    Zucchi
 * @subpackage Filter
 */
class Boolean extends AbstractFilter
{
    /**
     * Defined by Zend\Filter\FilterInterface
     *
     * Returns the integer of $value
     *
     * @param  string $value
     * @return integer
     */
    public function filter($value)
    {
        if (is_string($value) && $value === 'true') {
            $value = true;
        } else if (is_string($value) && $value === 'false') {
            $value = false;
        } else if (!is_bool($value)) {
            $value = (bool) $value;
        }
        return $value;
    }
}
