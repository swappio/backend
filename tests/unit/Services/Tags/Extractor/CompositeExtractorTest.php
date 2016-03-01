<?php

namespace Tests\Unit\Services\Tags\Extractor;

use App\Models\Swap;
use App\Services\Tags\Extractors\CompositeExtractor;
use TestCase;

class CompositeExtractorTest extends TestCase
{
    /**
     * @var CompositeExtractor
     */
    private $extractor;

    private $extractor1;

    private $extractor2;

    private $extractor3;

    protected function setUp()
    {
        parent::setUp();
        $this->extractor1 = $this->getMock('\App\Contracts\Services\Tags\ExtractorContract');
        $this->extractor2 = $this->getMock('\App\Contracts\Services\Tags\ExtractorContract');
        $this->extractor3 = $this->getMock('\App\Contracts\Services\Tags\ExtractorContract');
        $this->extractor = new CompositeExtractor([
            $this->extractor1,
            $this->extractor2,
            $this->extractor3,
        ]);
    }


    public function testExtract()
    {
        $testSwap = new Swap();
        $this->extractor1->expects(self::once())->method('extract')->with($testSwap)->willReturn(['1']);
        $this->extractor2->expects(self::once())->method('extract')->with($testSwap)->willReturn(['2']);
        $this->extractor3->expects(self::once())->method('extract')->with($testSwap)->willReturn(['3']);

        self::assertEquals(['1', '2', '3'], $this->extractor->extract($testSwap));
    }

}
