<?php

namespace App\ValueObjects;

enum InvoiceStatus: string
{
    case SENT = 'sent';
    case LATE = 'late';
    case PAID = 'paid';
    case CANCELLED = 'cancelled';
}