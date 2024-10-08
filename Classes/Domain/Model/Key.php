<?php

namespace Clickstorm\GoMapsExt\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Key extends AbstractEntity
{
    #[Extbase\Validate(['validator' => \TYPO3\CMS\Extbase\Validation\Validator\NotEmptyValidator::class])]
    protected string $title = '';

    #[Extbase\Validate(['validator' => \TYPO3\CMS\Extbase\Validation\Validator\NotEmptyValidator::class])]
    protected string $apiKey = '';

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function setApiKey(string $apiKey): void
    {
        $this->apiKey = $apiKey;
    }
}
