<?php

use App\Exceptions\TranspositionOutOfRangeException;
use App\TranspositionService;
use PHPUnit\Framework\TestCase;

class TranspositionServiceTest extends TestCase
{
    /**
     * @dataProvider cases
     */
    public function testTransposition(
        string $dataToTranspose,
        array $expectedData,
        int $semitonesToTranspose
    ): void {
        $json = file_get_contents(__DIR__ . '/data/' . $dataToTranspose);

        $service = new TranspositionService();

        $this->assertSame($expectedData, $service->transpose(json_decode($json), $semitonesToTranspose));
    }

    public static function cases(): array
    {
        return [
            'negative semitones'                           => ['test1.json', [
                [1, 10], [2, 3], [1, 10], [2, 5], [1, 10], [2, 6], [1, 10], [2, 3], [1, 10], [2, 5], [1, 10], [2, 6], [1, 10], [2, 8], [1, 10], [2, 5], [1, 10], [2,
                    6], [1, 10], [2, 8], [1, 10], [2, 10], [1, 10], [2, 6], [1, 10], [2, 8], [1, 10], [2, 10], [1, 10], [2, 11], [1, 10], [2, 8], [1, 10], [2, 10], [1,
                    10], [2, 6], [1, 10], [2, 8], [1, 10], [2, 5], [1, 10], [2, 6], [1, 10], [2, 3], [1, 10], [2, 5], [1, 10], [2, 2], [1, 10], [2, 3], [1, 10], [1, 10],
                [1, 10], [1, 11], [1, 10], [1, 8], [1, 10], [1, 10], [1, 10], [1, 6], [1, 10], [1, 8], [1, 10], [1, 5], [1, 10], [1, 6], [1, 10], [1, 3], [1, 10], [1
                    , 8], [1, 10], [1, 5], [1, 10], [1, 6], [1, 10], [1, 3], [1, 10], [1, 5], [1, 10], [1, 2], [1, 10], [1, 3]
            ], -3],
            'positive semitones'                           => ['test1.json', [
                [2, 2], [2, 7], [2, 2], [2, 9], [2, 2], [2, 10], [2, 2], [2, 7], [2, 2], [2, 9], [2, 2], [2, 10], [2, 2], [2, 12], [2, 2], [2, 9], [2, 2], [2, 10], [2, 2], [2, 12], [2, 2], [3, 2], [2, 2], [2, 10], [2, 2], [2, 12], [2, 2], [3, 2], [2, 2], [3, 3], [2, 2], [2, 12], [2, 2], [3, 2], [2, 2], [2, 10], [2, 2], [2, 12], [2, 2], [2, 9], [2, 2], [2, 10], [2, 2], [2, 7], [2, 2], [2, 9], [2, 2], [2, 6], [2, 2], [2, 7], [2, 2], [2, 2], [2, 2], [2, 3], [2, 2], [1, 12], [2, 2], [2, 2], [2, 2], [1, 10], [2, 2], [1, 12], [2, 2], [1, 9], [2, 2], [1, 10], [2, 2], [1, 7], [2, 2], [1, 12], [2, 2], [1, 9], [2, 2], [1, 10], [2, 2], [1, 7], [2, 2], [1, 9], [2, 2], [1, 6], [2, 2], [1, 7]
            ], 1],
            'handling transfer from one octave to another' => ['test2.json', [[-3, 12], [-2, 12], [-1, 12], [0, 12], [1, 12], [2, 12], [3, 12], [4, 12]], -1],
        ];
    }

    /**
     * @dataProvider exceptionCases
     */
    public function testTranspositionOutOfKeyboardRange(
        array $dataToTranspose,
        int $semitonesToTranspose
    ): void {
        $this->expectException(TranspositionOutOfRangeException::class);

        $service = new TranspositionService();
        $service->transpose($dataToTranspose, $semitonesToTranspose);
    }

    public static function exceptionCases(): array
    {
        return [
            'lower range' => [[[-3, 10]], -1],
            'max range'   => [[[5, 1]], 1],
        ];
    }
}
