<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountFinance extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "account_number",
        "account_type",
        "description"
    ];
}
