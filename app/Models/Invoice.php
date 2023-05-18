<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'Invoice_Number',
        'Invoice_Date',
        'Payment_Date',
        'Due_Date',
        'Section_id',
        'Product',
        'Discount',
        'Amount_Collection',
        'Amount_Commission',
        'Rate_VAT',
        'Value_VAT',
        'Total',
        'Status',
        'Value_Status',
        'Note'
    ];

    public function section(){
        return $this->belongsTo(Section::class);
    }

}
