<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemContagemEstoque extends Model
{
    protected $table = 'itens_contagem_estoque';

    protected $fillable = [
        'contagem_estoque_id',
        'produto_id',
        'quantidade_sistema',
        'quantidade_contada',
        'situacao',
        'observacao',
    ];

    public function contagemEstoque()
    {
        return $this->belongsTo(ContagemEstoque::class);
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
