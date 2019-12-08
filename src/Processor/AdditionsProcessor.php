<?php

namespace TheRedDot\MonologExtraBundle\Processor;

class AdditionsProcessor
{
    /**
     * @var array<string, mixed>
     */
    protected $entries;

    /**
     * @param array<string, mixed> $entries
     */
    public function __construct(array $entries = [])
    {
        $this->entries = $entries;
    }

    /**
     * @param array<mixed> $record
     *
     * @return array<mixed>
     */
    public function processRecord(array $record): array
    {
        foreach ($this->entries as $key => $value) {
            $record['extra'][$key] = $value;
        }

        return $record;
    }
}
