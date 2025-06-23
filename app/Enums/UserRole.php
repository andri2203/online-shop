<?php

namespace App\Enums;

enum UserRole: string
{
    case Customer = 'customer';
    case Store = 'store';
    case Admin = 'admin';
}
