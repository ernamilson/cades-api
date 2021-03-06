<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tokens extends Model
{
    use HasFactory;

    // 'mysql3' is the database containing the databases access credentials

    public function getData($chave, $token) {
        try {
            $data = DB::connection('mysql3')->select(
                "select host, usuario, senha, nome_banco, driver_db 
                from banco 
                where (chave, token) = (?, ?) and produtos_id = 2",
                array($chave, $token));
        } catch(Throwable $e){
            report($e);
            return false;
        }
        if(empty($data)) {
            return false;
        };
        return $data[0];
    }
}
