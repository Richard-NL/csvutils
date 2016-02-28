<?php
namespace Rsh\CsvTools\Parser;

class CsvParserTest extends \PHPUnit_Framework_TestCase
{
    private $csvParser;

    public function setUp()
    {
        $this->csvParser = new CsvParser();
    }

    public function testGetValues()
    {
        $line = 'Foo;Bar;Baz';

        $this->assertEquals(['Foo', "Bar", "Baz"], $this->csvParser->getValuesFromLine($line));
    }

    public function testGetHeaders() {
        $string = 'Header1;Header2;Header3' . PHP_EOL . 'Val1;Val2;Val3';

        $headers = $this->csvParser->getHeaders($string);
        $this->assertEquals(['Header1', 'Header2', 'Header3'], $headers);
    }

    public function testConvertToLines()
    {
        $string = 'Header1;Header2;Header3' . PHP_EOL . 'Val1;Val2;Val3';
        $lines = $this->csvParser->convertToLines($string);
        $this->assertEquals('Header1;Header2;Header3', $lines[0]);
    }

    public function testParse()
    {
        $string = 'Id;Title;Description' . PHP_EOL . '1;Foo;A foo description here' . PHP_EOL . '2;Bar;A bar description here';
        $structuredData = $lines = $this->csvParser->parse($string);
        $expectedData = [
            ['Id' => '1', 'Title' => 'Foo', 'Description' => 'A foo description here'],
            ['Id' => '2', 'Title' => 'Bar', 'Description' => 'A bar description here']
        ];
        $this->assertEquals($expectedData, $structuredData);
    }
} 