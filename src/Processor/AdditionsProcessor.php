<?php

namespace Hexanet\Common\MonologExtraBundle\Processor;

class AdditionsProcessor
{
    /**
     * @var array
     */
    protected $entries;

    public function __construct(array $entries = [])
    {
        $this->entries = $entries;
    }

    public function processRecord(array $record) : array
    {
        foreach ($this->entries as $key => $value) {
            $record['extra'][$key] = $value;
        }

        return $record;
    }
}