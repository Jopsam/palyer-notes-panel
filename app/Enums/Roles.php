<?php

namespace App\Enums;

enum Roles: string
{
    case AGENT = 'agent';
    case PLAYER = 'player';

    /**
     * Get the label for the role.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::AGENT => __('support_agent'),
            self::PLAYER => __('player'),
        };
    }
}