<?php

namespace App\Enums;

enum Roles: string
{
    case AGENT = 'agent';
    case PLAYER = 'player';
    case VIEWER = 'viewer';

    /**
     * Get the label for the role.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::AGENT => __('agent'),
            self::PLAYER => __('player'),
            self::VIEWER => __('viewer'),
        };
    }
}