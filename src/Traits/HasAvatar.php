<?php

namespace Elijahcruz\Avatar\Traits;

use Elijahcruz\Avatar\AvatarLaravel;

/**
 * Trait HasAvatar
 * Note this is for the model that will have the avatar
 */
trait HasAvatar
{
    protected $avatarIdentifier = 'name';

    protected array $options = [];

    protected $avatarProvider = 'ui-avatars';

    public function getAvatarAttribute()
    {
        return $this->getAvatar();
    }

    public function getAvatar($size = 100)
    {
        // Check if the identifier is an actual string and not null
        if (is_string($this->{$this->avatarIdentifier})) {
            $this->options['size'] = $size;
        }


        $avatar = new AvatarLaravel($this->{$this->avatarIdentifier}, $this->avatarProvider, $this->options);

        return $avatar->getUrl();
    }
}