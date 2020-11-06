<?php

namespace Puviz\LinkedInConnect\Models;

use Illuminate\Database\Eloquent\Model;

class  LinkedInToken extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'linked_in_tokens';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'expires_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'account_id', 'access_token', 'expires_at', 'refresh_token'];
}
