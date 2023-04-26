<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'login', // adiciona o atributo login à lista de atributos preenchíveis em massa
        'name',
        'cpf',
        'email',
        'address',
        'password',
        'company_id' // adiciona a chave estrangeira company_id para a associação com a empresa
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
