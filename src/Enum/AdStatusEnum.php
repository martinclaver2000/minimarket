<?php

namespace App\Enum;

enum AdStatusEnum: string
{
    case CREATED = 'created';
    case PUBLISHED = 'published';
    case SOLD = 'sold';
    case EXPIRED = 'expired';
    case DENIED = 'denied';
    case DELETED = 'deleted';
}
