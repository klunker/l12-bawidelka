<?php

namespace App\Services;

use App\Models\Variable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class SettingsVariableService
{
    /**
     * @return Collection<string, string>
     */
    public function getAll(): Collection
    {
        return Cache::rememberForever('settings-variables', function () {
            return Variable::pluck('value', 'key');
        });
    }

    public function get(string $key, mixed $default = null): ?string
    {
        return $this->getAll()->get($key, $default);
    }
}
