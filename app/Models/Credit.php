<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Credit extends Model{

    use HasFactory;
    protected $fillable = [
        'name',
        'category_id',
        'nominal',
        'description',
        'credit_date',
        'account_finance_id',
        'created_by',
        'updated_by'
    ];

    public function account(){
        return $this->belongsTo(AccountFinance::class, 'account_finance_id');
    }
    public function user(){
    return $this->belongsTo(User::class, 'created_by');
    }
}
