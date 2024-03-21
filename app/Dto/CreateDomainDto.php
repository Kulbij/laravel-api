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
    public function getExcludedTargets(): array
    {
        return $this->data['excluded_targets'] ?? [];
    }

    /**
     * @return array
     */
    public function getTargetDomains(): array
    {
        return $this->data['target_domains'] ?? [];
    }
}
