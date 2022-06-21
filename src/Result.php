<?php
declare(strict_types=1);

namespace KielD01\LaravelGoogleApi;

use Illuminate\Support\Collection;

abstract class Result
{
    private array $rawResult;
    protected Collection $result;

    public function __construct(array $result)
    {
        $this->setRawResult($result);
        $this->processResult();
    }

    private function setRawResult(array $result): void
    {
        $this->rawResult = $result;
    }

    public function getRawResult(): array
    {
        return $this->rawResult;
    }

    public function getResult(): Collection
    {
        return $this->result;
    }

    abstract protected function processResult();
}