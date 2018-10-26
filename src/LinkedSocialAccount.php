<?php

namespace Jijoel\AuthApi;

use Illuminate\Database\Eloquent\Model;

class LinkedSocialAccount extends Model
{
    protected $fillable = [
        'provider_name',
        'provider_id',
    ];

    /**
     * Get the user that the client belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(self::userClass());
    }

    /**
     * Get the name of the user class
     *
     * @return String
     */
    public static function userClass()
    {
        $provider = config('auth.guards.api.provider');
        return config("auth.providers.$provider.model", 'App\User');
    }
}
