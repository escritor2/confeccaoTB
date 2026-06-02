<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\MasksSensitiveData;

class Fornecedor extends Model
{
    use MasksSensitiveData;
    protected $table = 'fornecedor';
    protected $fillable = ['nome', 'telefone', 'endereco'];
}
