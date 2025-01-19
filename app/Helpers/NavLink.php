<?php

namespace App\Helpers;

readonly class NavLink
{
    public bool $active;

    private function __construct(
        public string $href,
        public string $icon,
        public string $label,
        public bool $exact = false,
    ) {
        $this->active = $exact ? request()->url() === $href : str_starts_with(request()->url(), $href);
    }

    public static function create(string $href, string $icon, string $label, ?string $exact): NavLink
    {
        return new NavLink($href, $icon, $label, $exact);
    }
}
