<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'type',
        'value',
        'status'
    ];

    public function discount($total){
        if($this->type == "fixed"){
            return $this->value;
        }
        else{
            return ($this->value/100)*$total;
        }
    }
}
