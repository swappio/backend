<?php

namespace App\Services;

use App\Contracts\Storages\WishStorageContract;
use App\Models\Wish;

/**
 * Class WishService
 * @package App\Services
 */
class WishService
{
    /**
     * @var WishStorageContract
     */
    private $storage;

    /**
     * WishService constructor.
     * @param WishStorageContract $storage
     */
    public function __construct(WishStorageContract $storage)
    {
        $this->storage = $storage;
    }


    /**
     * Saves all wishes
     *
     * @param string[] $wishes
     * @return array
     */
    public function saveAll($wishes)
    {
        $foundWishes = $this->storage->findAll($wishes);
        $notFoundWishes = array_filter($wishes, function ($wish) use ($foundWishes) {
            foreach ($foundWishes as $foundWish) {
                if ($wish === $foundWish->name) {
                    return false;
                }
            }

            return true;
        });

        $modelsToSave = [];
        foreach ($notFoundWishes as $wish) {
            $modelsToSave[] = new Wish(['name' => $wish]);
        }

        $wishes = $this->storage->saveAll($modelsToSave);

        return array_merge($foundWishes ?: [], $wishes);
    }
}
