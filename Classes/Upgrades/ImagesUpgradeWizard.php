<?php

declare(strict_types=1);

namespace Clickstorm\GoMapsExt\Upgrades;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

#[UpgradeWizard('gomapsext_imagesUpgradeWizard')]
final class ImagesUpgradeWizard implements UpgradeWizardInterface
{
    private const TABLE_SYS_FILE_REFERENCE = 'sys_file_reference';
    private const TABLE_ADDRESS = 'tx_gomapsext_domain_model_address';
    private const FIELD_TABLENAMES = 'tablenames';
    private const FIELD_FIELDNAME = 'fieldname';
    private const FIELD_UID = 'uid';
    private const OLD_FIELD_NAME = 'tx_gomapsext_info_window_image';
    private const NEW_FIELD_NAME = 'info_window_images';

    /**
     * Return the speaking name of this wizard
     */
    public function getTitle(): string
    {
        return 'EXT:go_maps_ext - fix relations for info window images';
    }

    /**
     * Return the description for this wizard
     */
    public function getDescription(): string
    {
        return <<<'EOD'
            Replaces in sys_file_reference the fieldname tx_gomapsext_info_window_image with info_window_images.
            Otherwise the images will not be found.
            EOD;
    }

    /**
     * Execute the update
     *
     * Called when a wizard reports that an update is necessary
     */
    public function executeUpdate(): bool
    {
        $query = self::getQueryBuilderForSysFileReference();
        $query
            ->update(self::TABLE_SYS_FILE_REFERENCE)
            ->set(
                self::FIELD_FIELDNAME,
                self::NEW_FIELD_NAME
            )
            ->where($query->expr()->eq(self::FIELD_TABLENAMES, $query->createNamedParameter(self::TABLE_ADDRESS)))
            ->andWhere($query->expr()->eq(self::FIELD_FIELDNAME, $query->createNamedParameter(self::OLD_FIELD_NAME)))
            ->executeStatement();

        return true;
    }

    /**
     * Is an update necessary?
     *
     * Is used to determine whether a wizard needs to be run.
     * Check if data for migration exists.
     *
     * @return bool Whether an update is required (TRUE) or not (FALSE)
     */
    public function updateNecessary(): bool
    {
        $query = self::getQueryBuilderForSysFileReference();
        return (bool)$query
            ->count(self::FIELD_UID)
            ->from(self::TABLE_SYS_FILE_REFERENCE)
            ->where($query->expr()->eq(self::FIELD_TABLENAMES, $query->createNamedParameter(self::TABLE_ADDRESS)))
            ->andWhere($query->expr()->eq(self::FIELD_FIELDNAME, $query->createNamedParameter(self::OLD_FIELD_NAME)))
            ->executeQuery()->fetchOne();
    }

    /**
     * Returns an array of class names of prerequisite classes
     *
     * This way a wizard can define dependencies like "database up-to-date" or
     * "reference index updated"
     *
     * @return string[]
     */
    public function getPrerequisites(): array
    {
        return [
            DatabaseUpdatedPrerequisite::class,
        ];
    }

    private static function getQueryBuilderForSysFileReference(): QueryBuilder
    {
        $query = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable(self::TABLE_SYS_FILE_REFERENCE);
        $query->getRestrictions()->removeAll();
        return $query;
    }
}
