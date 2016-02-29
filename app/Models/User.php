<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function feedbacks()
    {
        return $this->hasMany('\App\Models\Feedback', 'for_user_id', 'id');
    }

    public function rating()
    {
        $feedbacks = $this->feedbacks;
        $sum = 0;

        foreach ($feedbacks as $feedback) {
            $sum += $feedback->value;
        }

        return count($feedbacks) === 0 ? 0 : round($sum / count($feedbacks), 1);
    }
}
