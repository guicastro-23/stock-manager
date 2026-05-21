<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstoqueProduto extends Model
{
    protected $table = 'estoques_produtos';

    protected $fillable = [
        'produto_id',
        'quantidade_sistema',
    ];

    public function produto()
    {
        return $this->belongsTo(EstoqueProduto::class);
    }
}
