<?php
/**
 * php-gedcom
 *
 * php-gedcom is a library for parsing, manipulating, importing and exporting
 * GEDCOM 5.5 files in PHP 5.3+.
 *
 * @author          Xiang Ming <wenqiangliu344@gmail.com>
 * @copyright       Copyright (c) 2010-2013, Xiang Ming
 * @package         php-gedcom 
 * @license         MIT
 * @link            http://github.com/mrkrstphr/php-gedcom
 */

namespace PhpGedcom\Writer\Fam\Even;

/**
 *
 */
class Wife
{
    /**
     * @param \PhpGedcom\Record\Fam\Even\Wife $attr
     * @param int $level
     * @return string
     */
    public static function convert(\PhpGedcom\Record\Fam\Even\Wife &$wife, $level = 0)
    {
        $output = '';
        
        $output.= $level." HUSB \n";
        // level up
        $level++;
        
        // AGE
        $age = $wife->getAge();
        if(!empty($age)){
            $output.=$level." AGE ".$age."\n";
        }
        
        return $output;
    }
}
