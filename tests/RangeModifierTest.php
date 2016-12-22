<?php
/**
 * Test case for the 'range' variables modifier.
 */


/**
 * Class RangeModifierTest - Test case for class RangeModifier
 */
final class RangeModifierTest extends PHPUnit_Framework_TestCase
{
    /** @var Smarty $smarty */
    protected $smarty;


    protected function setUp()
    {
        // Call the parent class first
        parent::setUp();

        // Instantiate the subject to test
        $this->smarty = new Smarty();
        $this->smarty->addPluginsDir(array(dirname(__DIR__).'/src'));
        $this->smarty->setCompileDir(dirname(__DIR__).'/templates_c');
    }



    protected function tearDown()
    {
        unset($this->smarty);

        parent::tearDown();
    }



    /**
     * @dataProvider dataForRangeModifier
     * @param string $template
     * @param string $value
     * @param string $expected
     */
    public function testRangeModifier($template, $value, $expected)
    {
        $this->smarty->assign('var', $value);
        $output = $this->smarty->fetch('string:'.$template);

        $this->assertEquals($expected, $output);
    }



    /**
     * Data provider for testRangeModifier()
     */
    public function dataForRangeModifier()
    {
        return array(
            // Strings
            array('{$var|range}', '1,2,3', '1-3'),
            array('{$var|range}', '123', '123'),
            array('{$var|range}', '', ''),
            // Use a different separator (';') for values in the input string
            array('{$var|range:"-":";"}', '5;6;7;8;9;10', '5-10'),

            // Compact ranges
            array('{$var|range}', range(50, 101), '50-101'),
            array('{$var|range}', array(11, 12, 13), '11-13'),
            // A range of two consecutive values
            array('{$var|range}', array(1, 2), '1-2'),
            // A range of length 0 or 1 is not a range
            array('{$var|range}', array(1), '1'),
            array('{$var|range}', array(), ''),

            // A range with gaps behaves like a compact range
            array('{$var|range}', '21,31,41', '21-41'),
            array('{$var|range}', array(21, 31, 41), '21-41'),

            // Use a different output separator
            array('{$var|range:"..."}', range(20, 30), '20...30'),

            // Sort the values
            array('{$var|range}', array(3, 5, 6, 4), '3-6'),
            array('{$var|range:"-":",":0}', array(3, 5, 6, 4), '3-4'),
            array('{$var|range:"-":",":1}', array(3, 5, 6, 4), '3-6'),
        );
    }
}


// This is the end of file; no closing PHP tag
