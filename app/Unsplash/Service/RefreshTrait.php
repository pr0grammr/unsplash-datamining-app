<?php


namespace App\Unsplash\Service;


use App\Models\UnsplashPhoto;
use App\Models\UnsplashUser;
use MongoDB\BSON\UTCDateTime;
use Unsplash\Photo;
use Unsplash\User;


/**
 * zur überprüfung ob ein eintrag aktulisiert werden muss
 *
 * Trait RefreshTrait
 * @package App\Unsplash
 */
trait RefreshTrait
{
    /**
     * prüft ob das refresh datum des unsplash datenbank eintrags
     * älter ist, als das datum des unsplash API eintrags
     * ist dies der fall, ist kein weitere API request nötig, da der
     * datensatz nicht geupdated werden muss
     *
     * @param User|Photo $apiEntry
     * @param UnsplashUser|UnsplashPhoto $databaseEntry
     * @return bool
     * @throws \Exception
     */
    private function needsRefresh($apiEntry, $databaseEntry)
    {
        $updatedAt = $apiEntry->updated_at;
        if (!$updatedAt) {
            return true;
        }

        $updatedAt = new \DateTime($updatedAt);

        /** @var UTCDateTime $refreshedAt */
        $refreshedAt = $databaseEntry->refreshed_at;
        if (!$refreshedAt) {
            return true;
        }

        $refreshedAt = $refreshedAt->toDateTime();

        return $updatedAt >= $refreshedAt;
    }
}
