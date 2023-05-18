<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice_details extends Model
{
    use HasFactory;
    protected $fillable = [
        'Invoice_id',
        'Invoice_Number',
        'Product',
        'Section',
        'Status',
        'Value_Status',
        'Note',
        'User',
    ];

}
