<?php

namespace spec\TheRedDot\MonologExtraBundle\Processor;

use TheRedDot\MonologExtraBundle\Processor\AdditionsProcessor;
use PhpSpec\ObjectBehavior;

class AdditionsProcessorSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith([]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(AdditionsProcessor::class);
    }

    public function it_adds_nothing_to_record_by_default()
    {
        $this->processRecord([])->shouldReturn([]);
    }

    public function it_adds_entries_to_record()
    {
        $this->beConstructedWith(['type' => 'symfony']);

        $this->processRecord(['message' => 'log'])->shouldReturn([
            'message' => 'log',
            'extra' => [
                'type' => 'symfony',
            ],
        ]);
    }
}
