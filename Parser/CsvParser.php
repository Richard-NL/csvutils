<?php
namespace Rsh\CsvTools\Parser;

class CsvParser
{

    public function getHeaders($string)
    {
        $lines = $this->convertToLines($string);
        if (!isset($lines[0]) || empty($lines[0])) {
            return [];
        }

        return $this->getValuesFromLine($lines[0]);
    }

    public function convertToLines($string)
    {
        $lines = array_filter(preg_split("/\r\n|\n|\r/", $string));
        return $lines;
    }

    public function getValuesFromLine($line, $separator = ";")
    {
        if (empty($line)) {
            throw new \UnexpectedValueException('Line was empty');
        }

        return explode($separator, $line);
    }

    public function parse($string)
    {
        $lines = $this->convertToLines($string);
        $headers = $this->getValuesFromLine($lines[0]);
        $records = [];
        for ($index = 1; $index < count($lines); $index += 1) {
            $lineValues = $this->getValuesFromLine($lines[$index]);
            $record = [];
            foreach ($lineValues as $key => $value) {
                $record[$headers[$key]] = $value;
            }
            $records[] = $record;
        }
        return $records;
    }
} 