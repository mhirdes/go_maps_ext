<?php

namespace Clickstorm\GoMapsExt\Domain\Repository;

use Clickstorm\GoMapsExt\Domain\Model\Map;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class AddressRepository extends Repository
{

    /**
     * Finds all addresses by the specified map or the storage pid
     *
     * @param Map $map The map
     * @param string $pids The Storage Pid
     * @return QueryResultInterface The addresses
     * @throws InvalidQueryException
     */
    public function findAllAddresses(Map $map, string $pids = '', bool $ignoreSysLanguage = false): QueryResultInterface
    {
        $query = $this->createQuery();
        $querySettings = $query->getQuerySettings();

        $querySettings->setRespectStoragePage(false);

        if ($ignoreSysLanguage) {
            $querySettings->setRespectSysLanguage(false);
        }

        $query->setQuerySettings($querySettings);

        $or = [];
        $and = [];

        if ($pids !== '') {
            foreach (explode(',', $pids) as $pid) {
                $or[] = $query->equals('pid', $pid);
            }
        }

        $or[] = $query->contains('map', $map);
        $and[] = $query->logicalOr(...$or);

        return $query->matching(
            $query->logicalAnd(
                ...$and
            )
        )
            ->execute();
    }
}
