<?php
declare(strict_types = 1);
namespace joker2620\Source\Plugins\Morse;

use joker2620\Source\Exception\BotError;

/**
 * Morse code table
 *
 * @author    Espen Hovlandsdal <espen@hovlandsdal.com>
 * @copyright Copyright (c) Espen Hovlandsdal
 * @license   http://www.opensource.org/licenses/mit-license MIT License
 * @link      https://github.com/rexxars/morse-php
 */
class TableRU implements \ArrayAccess
{
    /**
     * An array of predefined codes
     *
     * @var array
     */
    private $predefinedCodes;

    /**
     * A reverse copy of the table (morse => character)
     *
     * @var array
     */
    private $reversedTable;

    /**
     * A table of predefined morse code mappings
     *
     * @var array
     */
    private $table;

    /**
     * Constructs a new instance of the table
     *
     */
    public function __construct()
    {
        $this->table           = include 'Data/RU.php';
        $this->predefinedCodes = array_keys($this->table);
        $this->reversedTable   = array_flip($this->table);
    }

    /**
     * Add a morse code mapping for the given offset (character)
     *
     * @param mixed  $offset
     * @param string $value
     *
     * @throws BotError
     */
    public function offsetSet($offset, $value)
    {
        if ($this->offsetExists($offset)) {
            throw new BotError('Can\'t override predefined character');
        } else if (!preg_match('#^[01]+$#', $value)) {
            throw new BotError('Value must be a string of zeroes and ones (0/1)');
        } else if (isset($this->reversedTable[$value])) {
            throw new BotError('There is already a character with value ' . $value);
        }

        $this->table[$offset]        = $value;
        $this->reversedTable[$value] = $offset;
    }

    /**
     * Returns whether the given offset (character) exists
     *
     * @param mixed $offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->table[$offset]);
    }

    /**
     * Remove a morse code mapping for the given offset (character)
     *
     * @param mixed $offset
     *
     * @throws BotError
     */
    public function offsetUnset($offset)
    {
        if (in_array($offset, $this->predefinedCodes, true)) {
            throw new BotError('Can\'t unset a predefined morse code');
        }

        unset($this->table[$offset]);
    }

    /**
     * Get morse code (dit/dah) for a given character
     *
     * @param $character
     *
     * @return string
     * @internal param string $offset
     *
     */
    public function getMorse($character)
    {
        return strtr($this->offsetGet($character), '01', '.-');
    }

    /**
     * Get the morse code for the given offset (character)
     *
     * @param mixed $offset
     *
     * @return string
     */
    public function offsetGet($offset)
    {
        return $this->table[$offset];
    }

    /**
     * Get character for given morse code
     *
     * @param  string $morse
     *
     * @return string
     */
    public function getCharacter($morse)
    {
        $key_code = strtr($morse, '.-', '01');
        return isset($this->reversedTable[$key_code]) ? $this->reversedTable[$key_code] : false;
    }
}
