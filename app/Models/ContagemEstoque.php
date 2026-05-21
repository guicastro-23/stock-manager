<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


    class ContagemEstoque extends Model
{
    protected $table = 'contagens_estoque';

    protected $fillable = [
        'codigo',
        'data_agendada',
        'responsavel_id',
        'status',
    ];

    public function responsavel()
    {
        return $this->belongsTo(Funcionario::class, 'responsavel_id');
    }

    public function itens()
    {
        return $this->hasMany(ItemContagemEstoque::class);
    }
}

