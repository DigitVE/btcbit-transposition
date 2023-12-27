<?php

namespace App;

use App\Exceptions\TranspositionOutOfRangeException;

class TranspositionService
{
    private const MIN_POSSIBLE_NOTE = 22;
    private const MAX_POSSIBLE_NOTE = 109;
    private const OCTAVE_SIZE = 12;
    private const OCTAVE_OFFSET = 4;

    /**
     * @throws TranspositionOutOfRangeException
     */
    public function transpose(array $arrayToTransposite, int $semitonesToTranspose): array
    {
        return array_map(function (array $item) use ($semitonesToTranspose) {
            return $this->transposeElement($item, $semitonesToTranspose);
        }, $arrayToTransposite);
    }

    /**
     * @throws TranspositionOutOfRangeException
     */
    private function transposeElement(array $item, int $semitonesToTranspose): array
    {
        $octaveNumber = ($item[0] + self::OCTAVE_OFFSET) * self::OCTAVE_SIZE;
        $total = $octaveNumber + $item[1];

        $total += $semitonesToTranspose;

        if ($total > self::MAX_POSSIBLE_NOTE || $total < self::MIN_POSSIBLE_NOTE) {
            throw new TranspositionOutOfRangeException();
        }

        $result = [intdiv($total, self::OCTAVE_SIZE) - self::OCTAVE_OFFSET, $total % self::OCTAVE_SIZE];

        if ($result[1] === 0) {
            $result[0]--;
            $result[1] = self::OCTAVE_SIZE;
        }

        return $result;
    }
}
