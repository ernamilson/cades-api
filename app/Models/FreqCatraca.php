<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $idCatraca
 * @property string $Descricao
 * @property string $idAluno
 * @property string $Data
 * @property string $Hora
 * @property string $controle
 * @property integer $faltou
 * @property string $dataLeitura
 * @property string $usuario
 * @property string $Movimento
 * @property integer $idModeloLeituraCatraca
 * @property ModeloLeituraCatraca $modeloLeituraCatraca
 */
class FreqCatraca extends Model
{
    public $timestamps = false;
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'idCatraca';

    protected $table = 'FreqCatraca';

    /**
     * @var array
     */
    protected $fillable = ['Descricao', 'idAluno', 'Data', 'Hora', 'controle', 'faltou', 'dataLeitura', 'usuario', 'Movimento', 'idModeloLeituraCatraca'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function modeloLeituraCatraca()
    {
        return $this->belongsTo('App\Models\ModeloLeituraCatraca', 'idModeloLeituraCatraca');
    }
}
