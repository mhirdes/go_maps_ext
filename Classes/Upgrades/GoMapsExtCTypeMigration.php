<?php

declare(strict_types=1);

namespace Clickstorm\GoMapsExt\Upgrades;

use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\AbstractListTypeToCTypeUpdate;

#[UpgradeWizard('goMapsExtCTypeMigration')]
class GoMapsExtCTypeMigration extends AbstractListTypeToCTypeUpdate
{
    protected function getListTypeToCTypeMapping(): array
    {
        return ['gomapsext_show' => 'gomapsext_show'];
    }

    public function getTitle(): string
    {
        return 'Migrate "Go Maps Ext" plugins to content elements.';
    }

    public function getDescription(): string
    {
        return 'The "Go Maps Ext" plugin is now registered as content element. Update migrates existing records and backend user permissions.';
    }
}
