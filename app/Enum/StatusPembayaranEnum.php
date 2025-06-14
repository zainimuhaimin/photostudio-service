<?php
namespace App\Enum;
enum StatusPembayaranEnum: string{
    case BOOKED = 'BOOKED';
    case PAID = 'PAID';
    case UNPAID = 'UNPAID';
    case INVALID = 'INVALID';
    case VALID = 'VALID';
}