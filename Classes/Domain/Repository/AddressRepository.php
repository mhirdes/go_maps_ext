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
     * @param int $pid The Storage Pid
     * @return QueryResultInterface The addresses
     * @throws InvalidQueryException
     */
    public function findAllAddresses(Map $map, int $pid): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->getQuerySettings()->setRespectSysLanguage(false);

        $or = [];
        $and = [];

        foreach (explode(',', $pid) as $p) {
            $or[] = $query->equals('pid', $p);
        }
        if ($map) {
            $or[] = $query->contains('map', $map);
        }
        $and[] = $query->logicalOr(...$or);

        return $query->matching(
            $query->logicalAnd(
                ...$and
            )
        )
            ->execute();
    }
}
