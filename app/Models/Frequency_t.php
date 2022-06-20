<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Frequency extends Model
{
    protected $table = 'FreqCatraca';
    protected $primaryKey = 'idCatraca';
    // public const IdCatraca = 'idCatraca';
    public const IdAluno = 'idAluno';
    public const Data = 'data';
    public const Hora = 'Hora';
    public const Controle = 'controle';
    public const Faltou = 'faltou';
    public const DataLeitura = 'dataLeitura';
    public const Usuario = 'usuario';
    public const Movimento = 'Movimento';
    public const IdModeloLeituraCatraca = 'idModeloLeituraCatraca';
    use HasFactory;
}
