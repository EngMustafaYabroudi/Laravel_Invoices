<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice_attachments extends Model
{
    use HasFactory;
    protected $fillable =[
      'Invoice_id',
      'Invoice_Number',
      'file_name',
      'Created_by'
    ];
}
