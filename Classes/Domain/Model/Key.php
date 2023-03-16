<?php

namespace Clickstorm\GoMapsExt\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Key extends AbstractEntity
{
    /**
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected string $title = '';

    /**
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
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
