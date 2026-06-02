<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\MasksSensitiveData;

class Clientes extends Model
{
    use HasFactory, MasksSensitiveData;
    protected $fillable = ['nome', 'cpf', 'email', 'telefone', 'endereco'];
}
