<?php

namespace Elijahcruz\Avatar\Traits;

use Elijahcruz\Avatar\AvatarLaravel;

/**
 * Trait HasAvatar
 * Note this is for the model that will have the avatar
 */
trait HasAvatar
{
    protected $avatarIdentifier = 'email';
    protected $avatarProvider = 'gravatar';
    protected $avatarOptions = [];

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


        $avatar = new AvatarLaravel($this->{$this->avatarIdentifier}, $this->avatarProvider, $this->avatarOptions);

        return $avatar->getUrl();
    }

    /**
     * @return string
     */
    public function getAvatarIdentifier(): string
    {
        return $this->avatarIdentifier;
    }

    /**
     * @param string $avatarIdentifier
     */
    public function setAvatarIdentifier(string $avatarIdentifier): void
    {
        $this->avatarIdentifier = $avatarIdentifier;
    }

    /**
     * @return string
     */
    public function getAvatarProvider(): string
    {
        return $this->avatarProvider;
    }

    /**
     * @param string $avatarProvider
     */
    public function setAvatarProvider(string $avatarProvider): void
    {
        $this->avatarProvider = $avatarProvider;
    }

    /**
     * @return array
     */
    public function getAvatarOptions(): array
    {
        return $this->avatarOptions;
    }

    /**
     * @param array $avatarOptions
     */
    public function setAvatarOptions(array $avatarOptions): void
    {
        $this->avatarOptions = $avatarOptions;
    }
}