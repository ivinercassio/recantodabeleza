<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelScheduling extends Model
{
    protected $table = 'TbAgendamento';
    protected $fillable = ['title', 'telefone', 'start', 'end', 'color', 'valorTotal', 'cdCliente', 'cdFuncionario'];

    public function relService(){
        return $this->belongsToMany('App\Models\ModelService', 'tbAgendamentoServico', 'cdAgendamento', 'cdServico')
                    ->as('servicos')
                    ->withPivot('cdAgendamento','cdFuncionario', 'valorCobrado')
                    ->withTimestamps(); 
     }

    public function relClient(){
        return $this->hasOne('App\Models\ModelClient', 'cdCliente', 'cdCliente');
    }

    public function relEmployee(){
        return $this->hasOne('App\Models\ModelEmployee', 'cdFuncionario', 'cdFuncionario');
    }
}
