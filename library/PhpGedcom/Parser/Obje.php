<?php
/**
 * php-gedcom
 *
 * php-gedcom is a library for parsing, manipulating, importing and exporting
 * GEDCOM 5.5 files in PHP 5.3+.
 *
 * @author          Kristopher Wilson <kristopherwilson@gmail.com>
 * @copyright       Copyright (c) 2010-2013, Kristopher Wilson
 * @package         php-gedcom
 * @license         MIT
 * @link            http://github.com/mrkrstphr/php-gedcom
 */

namespace PhpGedcom\Parser;

/**
 *
 *
 */
class Obje extends \PhpGedcom\Parser\Component
{

    /**
     *
     *
     */
    public static function parse(\PhpGedcom\Parser $parser)
    {
        $record = $parser->getCurrentLineRecord();
        $depth = (int) $record[0];
        if(isset($record[1])){
          $identifier = $parser->normalizeIdentifier($record[1]);
        }
        else{
           $parser->skipToNextLevel($depth);
           return null;
        }

        $obje = new \PhpGedcom\Record\Obje();
        $obje->setId($identifier);

        $parser->getGedcom()->addObje($obje);

        $parser->forward();

        while (!$parser->eof()) {
            $record = $parser->getCurrentLineRecord();
            $currentDepth = (int) $record[0];
            $recordType = strtoupper(trim($record[1]));

            if ($currentDepth <= $depth) {
                $parser->back();
                break;
            }

            switch ($recordType) {
                case 'FILE':
                    $obje->setFile(trim($record[2]));
                    break;
                case 'REFN':
                    $refn = \PhpGedcom\Parser\Refn::parse($parser);
                    $obje->addRefn($refn);
                    break;
                case 'RIN':
                    $obje->setRin(trim($record[2]));
                    break;

                case 'NOTE':
                    $note = \PhpGedcom\Parser\NoteRef::parse($parser);
                    if ($note) {
                        $obje->addNote($note);
                    }
                    break;
                case 'SOUR':
                    $chan = \PhpGedcom\Parser\Chan::parse($parser);
                    $obje->setChan($chan);
                    break;
    
                case 'CHAN':
                    $chan = \PhpGedcom\Parser\Chan::parse($parser);
                    $obje->setChan($chan);
                    break;

                default:
                    $parser->logUnhandledRecord(get_class() . ' @ ' . __LINE__);
            }

            $parser->forward();
        }

        return $obje;
    }
}
