<?php

namespace App\Socialite;

use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;
use Illuminate\Support\Arr;

class EduIDProvider extends AbstractProvider implements ProviderInterface
{
    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(config('services.eduid.authorize_url'), $state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return config('services.eduid.token_url');
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get(
            config('services.eduid.user_url'),
            $this->getRequestOptions($token)
        );
        return json_decode($response->getBody(), true);
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User)->setRaw($user)->map([
            'uid' => Arr::get($user['data'], 'uid'),
            'branch' => Arr::get($user['data'], 'branch'),
            'first_name' => Arr::get($user['data'], 'first_name'),
            'last_name' => Arr::get($user['data'], 'last_name'),
            'email' => Arr::get($user['data'], 'email'),
            'jmbg' => Arr::get($user['data'], 'jmbg'),
            'oib' => Arr::get($user['data'], 'oib'),
            'date_of_birth' => Arr::get($user['data'], 'date_of_birth'),
        ]);
    }

    /**
     * Get the default options for an HTTP request.
     *
     * @param string $token
     * @return array
     */
    protected function getRequestOptions($token)
    {
        return [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$token,
            ],
        ];
    }
}
