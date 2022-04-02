<?php
declare(strict_types=1);

namespace KielD01\LaravelGoogleApi;

abstract class Result
{
    private array $rawResult;

    public function __construct(array $result)
    {
        $this->setRawResult($result);
        $this->processResult();
    }

    private function setRawResult(array $result)
    {
        $this->rawResult = $result;
    }

    public function getRawResult(): array
    {
        return $this->rawResult;
    }

    abstract protected function processResult();
}