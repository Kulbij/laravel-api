<?php

namespace App\Dto;

class CreateDomainDto
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getTargetDomains(): array
    {
        return $this->parseListDomains($this->data['target_domains'], 1);
    }

    /**
     * @return array
     */
    public function getExcludedTargets(): array
    {
        return $this->parseListDomains($this->data['excluded_targets']);
    }

    /*
     * @param array $listData
     * @param int $startFromIndex
     *
     * @return array
     */
    private function parseListDomains(array $listData, int $startFromIndex = 0): array
    {
        $domainsData = [];

        foreach ($listData as $index => $value) {
            if ($startFromIndex > 0 && isset($listData[0])) {
                $index = $startFromIndex + $index;
            }

            $domainsData[$index] = $value;
        }

        return $domainsData;
    }
}
