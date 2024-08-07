<?php

namespace App\Models\Enums;

enum OrderStatus : string
{
    case DRAFT = 'draft';
    case PAID = 'paid';
    case DELIVERY = 'delivery';
    case DELIVERED = 'delivered';
}
