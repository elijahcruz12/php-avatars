<?php

namespace Elijahcruz\Avatar\Traits;

use Elijahcruz\Avatar\AvatarLaravel;
use Elijahcruz\Avatar\Exception\GeneratorTypeNotFound;
use Elijahcruz\Avatar\Exception\IdentifierTypeNotSupportedException;

/**
 * Trait HasAvatar
 * Note this is for the model that will have the avatar
 */
trait HasAvatar
{
    protected string $avatarIdentifier;
    protected string $avatarProvider;
    protected array $avatarOptions;

    /**
     * Get the URL
     *
     * @return string
     * @throws GeneratorTypeNotFound
     * @throws IdentifierTypeNotSupportedException
     */
    protected function getAvatar(): string
    {
        $avatar = new AvatarLaravel($this->avatarIdentifier, $this->avatarProvider, $this->avatarOptions);
        return $avatar->getUrl();
    }
}