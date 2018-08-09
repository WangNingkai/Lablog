<?php
namespace App\Helpers\Extensions;

/* 准备文本格式的词库

首先准备一个文本文件，每个词占一行。格式：

词语<tab>值

生成 SimpleDict 专用词库

SimpleDict::make("text_file_path", "output_dict_path");

搜索

$dict = new SimpleDict("dict_path");
$result = $dict->search("some text here...");*/

/* $result 的格式：
array(
  'word1' => array('value' => 'value1', 'count' => 'count1'),
  ...
)*/

/*替换

// 简单替换
$replaced = $dict->replace("some text here...", "**");

// 高级替换
$replaced = $dict->replace("some text here...", function($word, $value) {
  return "[$word -> $value]";
});*/


/**
 * A simple dictionary
 *
 * 1. prepare a text file, format:
 *   word1<tab>value1
 *   word2<tab>value2
 *   ...
 *
 * 2. make a dictionary file:
 *   SimpleDict::make("text_file_path", "output_dict_path");
 *
 * 3. play with it!
 *  $dict = new SimpleDict("dict_path");
 *  $result = $dict->search("some text here...");
 *
 * $result format:
 *   array(
 *     'word1' => array('value' => 'value1', 'count' => 'count1'),
 *     ...
 *   )
 *
 * @link https://github.com/nowgoo/dict/
 * @author Nowgoo <nowgoo@gmail.com>
 * http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class SimpleDict {
    /**
     * char for padding value
     */
    const CHAR_PAD = ' ';
    /**
     * stop chars
     */
    const CHAR_STOP = ',.? ';
    /**
     * file handle
     * @var resource
     */
    private $file;
    /**
     * fixed row length
     * @var int
     */
    private $rowLength = 0;
    /**
     * fixed value length
     * @var int
     */
    private $valueLength = 0;
    /**
     * first chars cache
     * @var array
     */
    private $start = array();

    public function __construct($file) {
        if (file_exists($file) && is_readable($file))
        {
            $this->file = @fopen($file, 'r');
            if ($this->file)
            {
                $unpack = unpack("n3", fread($this->file, 6));
                $count = $unpack[1];
                $this->valueLength = $unpack[2];
                $this->rowLength = $unpack[3];
                foreach ($this->readLine(6, $count) as $line)
                {
                    list($fChar, $fCount, $fOffset, $fValue) = $line;
                    $this->start[$fChar] = array($fCount, $fOffset, $fValue);
                }
            }
        }
    }

    public function __destruct() {
        unset($this->start);
        if (isset($this->file) && $this->file)
            @fclose($this->file);
    }

    /**
     * search $str, return words found in dict:
     * array(
     *   'word1' => array('value' => 'value1', 'count' => 'count1'),
     *   ...
     * )
     * @param string $str
     * @return array
     */
    public function search($str) {
        $ret = array();
        $itr = new CharIterator($str);
        $stops = self::CHAR_STOP;
        $buff = array();
        foreach ($itr as $char)
        {
            if (strpos($stops, $char) !== false)
            {
                $buff = array();
                continue;
            }
            foreach ($buff as $prefix => $next)
            {
                $newPrefix = $prefix . $char;
                list($count, $offset, $value) = $this->findWord($char, $next[0], $next[1]);
                if (!empty($value))
                {
                    if (isset($ret[$newPrefix]))
                    {
                        $ret[$newPrefix]['count']++;
                    }
                    else
                    {
                        $ret[$newPrefix] = array(
                            'count' => 1,
                            'value' => $value
                        );
                    }
                }
                if ($count > 0)
                {
                    $buff[$newPrefix] = array($count, $offset);
                }
                unset($buff[$prefix]);
            }
            if (isset($this->start[$char]))
            {
                list($count, $offset, $value) = $this->start[$char];
                if (!empty($value))
                {
                    if (isset($ret[$char]))
                    {
                        $ret[$char]['count']++;
                    }
                    else
                    {
                        $ret[$char] = array(
                            'count' => 1,
                            'value' => $value
                        );
                    }
                }
                if ($count > 0 && !isset($buff[$char]))
                {
                    $buff[$char] = array($count, $offset);
                }
            }
        }

        return $ret;
    }

    /**
     * replace words to $to
     * if $to is callable, replace to call_user_func($to, $word, $value)
     * @param string $str
     * @param mixed $to
     * @return string
     */
    public function replace($str, $to) {
        $ret = '';
        $itr = new CharIterator($str);
        $stops = self::CHAR_STOP;
        $buff = '';
        $size = 0;
        $offset = 0;
        $buffValue = array();
        foreach ($itr as $char)
        {
            if (strpos($stops, $char) !== false)
            {
                if (empty($buffValue))
                {
                    $ret .= $buff . $char;
                }
                else
                {
                    $ret .= $this->replaceTo($buffValue[0], $buffValue[1], $to) . substr($buff, strlen($buffValue[0])) . $char;
                }
                $buff = '';
                $buffValue = array();
                continue;
            }
            if ($buff !== '')
            {
                list($fCount, $fOffset, $fValue) = $this->findWord($char, $size, $offset);
                if ($fValue === null)
                {
                    if (empty($buffValue))
                    {
                        $ret .= $buff;
                    }
                    else
                    {
                        $ret .= $this->replaceTo($buffValue[0], $buffValue[1], $to) . substr($buff, strlen($buffValue[0]));
                    }
                    $buff = '';
                    $buffValue = array();
                }
                else
                {
                    if ($fCount > 0)
                    {
                        $buff .= $char;
                        $size = $fCount;
                        $offset = $fOffset;
                        if (!empty($fValue))
                        {
                            $buffValue = array($buff, $fValue);
                        }
                    }
                    else
                    {
                        $ret .= $this->replaceTo($buff . $char, $fValue, $to);
                        $buff = '';
                        $buffValue = array();
                    }
                    continue;
                }
            }
            if (isset($this->start[$char]))
            {
                list($fCount, $fOffset, $fValue) = $this->start[$char];
                if ($fCount > 0)
                {
                    $buff = $char;
                    $size = $fCount;
                    $offset = $fOffset;
                    if (!empty($fValue))
                        $buffValue = array($buff, $fValue);
                }
                else
                {
                    $ret .= $this->replaceTo($char, $fValue, $to);
                }
            }
            else
            {
                $ret .= $char;
            }
        }
        if ($buff !== '')
        {
            if (empty($buffValue))
            {
                $ret .= $buff;
            }
            else
            {
                $ret .= $this->replaceTo($buffValue[0], $buffValue[1], $to) . substr($buff, strlen($buffValue[0]));
            }
        }

        return $ret;
    }

    private function replaceTo($word, $value, $to) {
        return is_callable($to) ? call_user_func($to, $word, $value) : $to;
    }

    /**
     * from $offset, find $char, up to $count record
     * @param string $char
     * @param int $count
     * @param int $offset
     * @return array($count, $offset, $value)
     */
    private function findWord($char, $count, $offset) {
        fseek($this->file, $offset);
        $len = $this->rowLength;
        $data = fread($this->file, $count * $len);
        for ($i = 0; $i < $count; $i++)
        {
            $row = substr($data, $i * $len, $len);
            $un = unpack("c3char/ncount/Noffset/c*value", $row);
            $fChar = rtrim(chr($un['char1']) . chr($un['char2']) . chr($un['char3']));
            if ($fChar !== $char)
            {
                continue;
            }
            $fCount = $un['count'];
            $fOffset = $un['offset'];
            $fValue = '';
            for ($j = 1; $j <= $this->rowLength - 9; $j++)
            {
                $v = $un['value' . $j];
                if ($v == 32)
                {
                    break;
                }
                $fValue .= chr($v);
            }

            return array($fCount, $fOffset, $fValue);
        }

        return array(0, 0, null);
    }

    private function readLine($offset, $size) {
        $ret = array();
        fseek($this->file, $offset);
        $data = fread($this->file, $size * $this->rowLength);
        for ($i = 0; $i < $size; $i++)
        {
            $row = substr($data, $i * $this->rowLength, $this->rowLength);
            $un = unpack("c3char/ncount/Noffset/c*value", $row);
            $fChar = rtrim(chr($un['char1']) . chr($un['char2']) . chr($un['char3']));
            $fCount = $un['count'];
            $fOffset = $un['offset'];
            $fValue = '';
            for ($j = 1; $j <= $this->rowLength - 9; $j++)
            {
                $v = $un['value' . $j];
                if ($v == 32)
                {
                    break;
                }
                $fValue .= chr($v);
            }
            $ret[] = array($fChar, $fCount, $fOffset, $fValue);
        }

        return $ret;
    }

    /**
     * make a dict file $output from $input
     * @param string $input
     * @param string $output
     */
    public static function make($input, $output) {
        $data = array();
        $fp = fopen($input, 'r');
        $vLen = 0;
        while ($line = fgetcsv($fp, 1024))
        {
            list($word, $value) = explode("\t", rtrim($line));
            $itr = new CharIterator($word);
            $pfx = '';
            foreach ($itr as $char)
            {
                if (!isset($data[$pfx]['next']) || !in_array($char, $data[$pfx]['next']))
                {
                    $data[$pfx]['next'][] = $char;
                }
                $pfx .= $char;
            }
            if (strlen($value) > $vLen)
            {
                $vLen = strlen($value);
            }
            $data[$word]['value'] = $value;
        }
        fclose($fp);
        if (!isset($data['']['next']) || empty($data['']['next']))
            return;
        sort($data['']['next'], SORT_STRING);
        $stack = array(array_fill_keys($data['']['next'], 0));
        $prefix = array();
        $fp = fopen($output, 'w');
        // header: count, valueLength, rowLength
        $line = pack("nnn", count($stack[0]), $vLen, $vLen + 9);
        fwrite($fp, $line);
        $offset = strlen($line);
        do
        {
            foreach ($stack[0] as $char => &$addr)
            {
                if ($addr > 0)
                {
                    continue;
                }
                $line = str_pad($char, 3, self::CHAR_PAD) . pack("nN", 0, 0) . str_repeat(self::CHAR_PAD, $vLen);
                fwrite($fp, $line);
                $addr = $offset;
                $offset += strlen($line);
            }
            $nextKeys = array_keys($stack[0]);
            $nextChar = $nextKeys[0];
            $next = $data[implode('', $prefix) . $nextChar];
            $nextSize = isset($next['next']) ? count($next['next']) : 0;
            $nextVal = isset($next['value']) ? $next['value'] : '';
            $line = pack("nN", $nextSize, $offset) . str_pad($nextVal, $vLen, self::CHAR_PAD);
            fseek($fp, $stack[0][$nextChar] + 3);
            fwrite($fp, $line);
            fseek($fp, $offset);
            if (isset($next['next']))
            {
                $prefix[] = $nextChar;
                sort($next['next'], SORT_STRING);
                array_unshift($stack, array_fill_keys($next['next'], 0));
            }
            else
            {
                unset($stack[0][$nextChar]);
            }
            while (empty($stack[0]) && !empty($stack))
            {
                array_shift($stack);
                if (empty($stack))
                {
                    break;
                }
                $keys = array_keys($stack[0]);
                unset($stack[0][$keys[0]]);
                array_pop($prefix);
            }
        } while (!empty($stack));
        //echo "done\n";
        fclose($fp);
    }

    /**
     * @param $words array('word','value')
     * @param $output
     */
    public static function makeFromArray($words, $output) {
        @ini_set('memory_limit', '512M');
        $data = array();
        $vLen = 0;
        foreach ($words as $item)
        {
            if (isset($item['value']))
                list($word, $value) = array_values($item);
            else
            {
                $word = $item['word'];
                $value = 1;
            }
            $itr = new CharIterator($word);
            $pfx = '';
            foreach ($itr as $char)
            {
                if (!isset($data[$pfx]['next']) || !in_array($char, $data[$pfx]['next']))
                {
                    $data[$pfx]['next'][] = $char;
                }
                $pfx .= $char;
            }
            if (strlen($value) > $vLen)
            {
                $vLen = strlen($value);
            }
            $data[$word]['value'] = $value;
        }
        unset($words);
        if(!isset($data['']['next']) || empty($data['']['next']))
            return;
        sort($data['']['next'], SORT_STRING);
        $stack = array(array_fill_keys($data['']['next'], 0));
        $prefix = array();
        $fp = fopen($output, 'w');
        // header: count, valueLength, rowLength
        $line = pack("nnn", count($stack[0]), $vLen, $vLen + 9);
        fwrite($fp, $line);
        $offset = strlen($line);
        do
        {
            foreach ($stack[0] as $char => &$addr)
            {
                if ($addr > 0)
                {
                    continue;
                }
                $line = str_pad($char, 3, self::CHAR_PAD) . pack("nN", 0, 0) . str_repeat(self::CHAR_PAD, $vLen);
                fwrite($fp, $line);
                $addr = $offset;
                $offset += strlen($line);
            }
            $nextKeys = array_keys($stack[0]);
            $nextChar = $nextKeys[0];
            $next = $data[implode('', $prefix) . $nextChar];
            $nextSize = isset($next['next']) ? count($next['next']) : 0;
            $nextVal = isset($next['value']) ? $next['value'] : '';
            $line = pack("nN", $nextSize, $offset) . str_pad($nextVal, $vLen, self::CHAR_PAD);
            fseek($fp, $stack[0][$nextChar] + 3);
            fwrite($fp, $line);
            fseek($fp, $offset);
            if (isset($next['next']))
            {
                $prefix[] = $nextChar;
                sort($next['next'], SORT_STRING);
                array_unshift($stack, array_fill_keys($next['next'], 0));
            }
            else
            {
                unset($stack[0][$nextChar]);
            }
            while (empty($stack[0]) && !empty($stack))
            {
                array_shift($stack);
                if (empty($stack))
                {
                    break;
                }
                $keys = array_keys($stack[0]);
                unset($stack[0][$keys[0]]);
                array_pop($prefix);
            }
        } while (!empty($stack));
        //echo "done\n";
        fclose($fp);
        unset($data);
    }
}
