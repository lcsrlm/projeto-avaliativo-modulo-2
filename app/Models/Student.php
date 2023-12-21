<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'date_birth',
        'cpf',
        'contact',
        'cep',
        'street',
        'state',
        'neighborhood',
        'city',
        'number'
    ];

    protected $dates = ['date_birth'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
