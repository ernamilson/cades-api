<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tokens_api extends Model
{
    use HasFactory;

    public function getData($chave, $token) {
        $data = DB::connection('mysql3')->select(
                "select chave, token, host,
                        usuario, senha, nome_banco,
                        driver_db, produtos_id, 
                        codigo_empresa 
                from banco 
                where (chave, token) = (?, ?)",
                array($chave, $token));
        return $data[0];
    }
}
