<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $guarded = []; 

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function debit()
    {
        return $this->belongsTo('App\Models\Debit');
    }

    public function debits()
    {
        return $this->hasMany('App\Models\Debit');
    }

}
