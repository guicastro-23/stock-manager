<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;

    protected $table = 'funcionarios';

    protected $fillable = [
        'nome',
        'email',
    ];

      public function user()
    {
        return $this->hasOne(User::class);
    }

    public function contagensResponsavel()
    {
        return $this->hasMany(ContagemEstoque::class, 'responsavel_id');
    }

}
