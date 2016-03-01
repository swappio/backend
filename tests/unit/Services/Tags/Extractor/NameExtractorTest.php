<?php

namespace Tests\Unit\Services\Tags\Extractor;

use App\Models\Swap;
use App\Services\Tags\Extractors\NameExtractor;
use TestCase;

class NameExtractorTest extends TestCase
{
    /**
     * @var NameExtractor
     */
    private $extractor;

    protected function setUp()
    {
        parent::setUp();
        $this->extractor = new NameExtractor();
    }


    public function swapsProvider()
    {
        return [
            [new Swap(['name' => 'Some name']), ['some', 'name']],
            [new Swap(['name' => 'Name']), ['name']],
            [new Swap(['name' => 'Some-name Super Custom 2']), ['some-name', 'super', 'custom']],
            [new Swap(['name' => '']), []],
        ];
    }

    /**
     * @dataProvider swapsProvider
     */
    public function testExtract(Swap $swap, $expected)
    {
        self::assertEquals($expected, $this->extractor->extract($swap));
    }

}
