<?php

namespace App\Helpers\Extensions;


class CharIterator implements \Iterator {
    /**
     * @var string
     */
    private $str;
    /**
     * @var string
     */
    private $char;
    /**
     * @var int
     */
    private $length = 0;
    /**
     * @var int
     */
    private $index = 0;
    /**
     * @var int
     */
    private $offset = 0;

    public function __construct($str) {
        $this->str = $str;
    }

    public function current() {
        return $this->char;
    }

    public function key() {
        return $this->offset;
    }

    public function next() {
        if ($this->offset >= $this->length)
        {
            $this->char = '';

            return false;
        }
        $i = $this->offset;
        $c = $this->str[$i];
        $ord = ord($c);
        if ($ord < 128)
        {
            $this->char = $c;
        }
        elseif ($ord < 224)
        {
            $this->char = $c . $this->str[++$i];
        }
        elseif ($ord < 240)
        {
            $this->char = $c . $this->str[++$i] . $this->str[++$i];
        }
        else
        {
            $this->char = $c . $this->str[++$i] . $this->str[++$i] . $this->str[++$i];
        }
        $this->offset = $i + 1;
        $this->index += 1;

        return true;
    }

    public function rewind() {
        $this->offset = 0;
        $this->index = 0;
        $this->length = strlen($this->str);
        $this->char = '';
        $this->next();
    }

    public function valid() {
        return ($this->char !== '');
    }
}
