<?php

declare(strict_types = 1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PasswordReset extends Model
{
    /**
     * Create a new token record.
     *
     * @param \Illuminate\Contracts\Auth\CanResetPassword $user
     *
     * @return string
     */
    public function create(User $user)
    {
        $token = $this->createNewToken();

        $this->insert($this->getPayload($user->email, $token));

        return $token;
    }

    /**
     * Create a new token for the user.
     *
     * @return string
     */
    public function createNewToken()
    {
        return Str::random(60);
    }

    /**
     * Build the record payload for the table.
     *
     * @param string $email
     * @param string $token
     *
     * @return array
     */
    protected function getPayload($email, $token)
    {
        return ['email' => $email, 'token' => $token, 'created_at' => new Carbon];
    }
}
