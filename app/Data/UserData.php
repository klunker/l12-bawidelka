<?php

namespace App\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

class UserData extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email,
        public readonly ?Carbon $email_verified_at,
        public readonly ?Carbon $two_factor_confirmed_at,
    ) {}
}
