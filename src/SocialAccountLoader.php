<?php

namespace Jijoel\AuthApi;

use Jijoel\AuthApi\Tests\Models\User;
use Laravel\Socialite\Two\User as ProviderUser;

class SocialAccountLoader
{
    /**
     * Find or create user instance by provider user instance and provider name.
     *
     * @param ProviderUser $providerUser
     * @param string $provider
     *
     * @return User
     */
    public function findOrCreate(
        ProviderUser $providerUser,
        string $provider)
    {
        $linkedSocialAccount = LinkedSocialAccount::where('provider_name', $provider)
            ->where('provider_id', $providerUser->getId())
            ->first();

        if ($linkedSocialAccount)
            return $linkedSocialAccount->user;

        $user = $this->findOrCreateUser($providerUser);

        $user->linkedSocialAccounts()->create([
            'provider_id' => $providerUser->getId(),
            'provider_name' => $provider,
        ]);

        return $user;
    }

    private function findOrCreateUser($providerUser)
    {
        if ($user = $this->findUser($providerUser->getEmail()))
            return $user;

        return $this->user()->create([
            'name' => $providerUser->getName(),
            'email' => $providerUser->getEmail(),
        ]);
    }

    private function findUser($email)
    {
        if (! $email) return;

        return $this->user()
            ->where('email', $email)
            ->first();
    }

    /**
     * Get the user model
     */
    private function user()
    {
        $class = linkedSocialAccount::userClass();
        return new $class;
    }
}
