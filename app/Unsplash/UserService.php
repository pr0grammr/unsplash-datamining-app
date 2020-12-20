<?php


namespace App\Unsplash;


use App\Models\UnsplashUser;
use Unsplash\User;


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
    /**
     * @param User $user
     * @return UnsplashUser
     */
    public function create(User $user)
    {
        $data = $this->prepare($user);
        return UnsplashUser::create($data);
    }

    /**
     * @param User $user
     * @param UnsplashUser $unsplashUser
     * @return UnsplashUser
     */
    public function update(User $user, UnsplashUser $unsplashUser)
    {
        $data = $this->prepare($user);

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
        $data['profile_image_url'] = $data['profile_image']['medium'];

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
        $limit = 50;
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
