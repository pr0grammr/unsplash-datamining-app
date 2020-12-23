<?php


namespace App\Unsplash\Service;


use App\Models\UnsplashUser;
use MongoDB\BSON\UTCDateTime;
use Unsplash\User;
use App\Twitter\Client as TwitterClient;


/**
 * Class UserService
 * @package App\Unsplash
 *
 * dieser service kümmert sich um das erstellen und updaten eines App\Models\UnsplashUser models
 *
 * @author Fabian Schilf <fabian.schilf@active-value.de>
 * @copyright 2020 active value GmbH
 */
class UserService
{
    use RefreshTrait;

    /**
     * @var TwitterClient
     */
    private $twitterClient;

    /**
     * @param TwitterClient $twitterClient
     */
    public function __construct(TwitterClient $twitterClient)
    {
        $this->twitterClient = $twitterClient;
    }

    /**
     * @param User $user
     * @return UnsplashUser
     */
    public function create(User $user)
    {
        $data = $this->prepare($user);

        if ($data['twitter_username']) {
            $data['twitter'] = $this->twitterClient->getUserByUsername($data['twitter_username']);
        }

        return UnsplashUser::create($data);
    }

    /**
     * @param User $user
     * @param UnsplashUser $unsplashUser
     * @return UnsplashUser
     */
    public function update(User $user, UnsplashUser $unsplashUser)
    {
        /**
         * prüft ob der API User erneut abgefragt werden muss
         * gibt den bereits vorhandenen user zurück, wenn
         * der datensatz nicht erneuert werden muss
         */
        if ($this->needsRefresh($user, $unsplashUser)) {
            $data = $this->prepare($user);
        } else {
            $data = $user->toArray();
        }

        // twitter daten werden dennoch geupdated um sie aktuell zu halten, selbst wenn kein refresh notwendig ist
        if ($data['twitter_username']) {
            $data['twitter'] = $this->twitterClient->getUserByUsername($data['twitter_username']);
        }

        $unsplashUser->fill($data);
        $unsplashUser->save();

        return $unsplashUser;
    }

    /**
     * @param User $user
     * @return array
     */
    private function prepare(User $user)
    {
        $data = $user->toArray();

        $userStats = $user->statistics();
        $totalViews = $userStats->offsetGet('views')->total;
        $totalLikes = $this->calculateLikesFromPhotos($user);

        $data['total_views'] = $totalViews;
        $data['total_likes'] = $totalLikes;
        $data['detection_mode'] = UnsplashUser::DETECTION_MODE_MANUAL;
        $data['refreshed_at'] = new UTCDateTime(new \DateTime());

        return $data;
    }

    /**
     * die unsplash API bietet keine möglichkeit die gesamten likes eines users
     * zu bekommen. daher müssen hier die likes von jedem foto zusammengerechnet werden
     * das limit wird auf 50 gesetzt um weniger API requests machen zu müssen
     *
     * @param User $user
     * @return float|int
     */
    private function calculateLikesFromPhotos(User $user)
    {
        $limit = 500;
        $pages = ceil($user->total_photos / $limit);
        $likes = [];

        for ($i = 1; $i <= $pages; $i++) {
            foreach ($user->photos($i, $limit) as $photo) {
                $likes[] = $photo->likes;
            }
        }

        return array_sum($likes);
    }
}
