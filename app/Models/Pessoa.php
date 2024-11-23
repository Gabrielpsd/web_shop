<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    protected $table = 'cliente_fornecedor';

    protected $fillable = ['id','descricao','fornecedor','cpf_cnpj','idade','sexo'];
}
