<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\MasksSensitiveData;

class Pedidos extends Model
{
    use HasFactory, MasksSensitiveData;
    protected $fillable = ['nome', 'telefone', 'endereco'];
}
