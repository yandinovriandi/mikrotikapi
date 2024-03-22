<?php


namespace App\Models\Enums;

enum TunnelStatus: string
{
    case ACTIVE = 'active';
    case OFFLINE = 'offline';
}
