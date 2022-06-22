<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tokens_api;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class ExternalDatabaseController extends Controller
{
    private function getCryptoParam()
    {
        $chave_cr = 97;  
        $caracteres_cript_reversa = md5(sha1("GrcZlOUnd0Y6tKOAlc8I69IFX6k_p1S3PAqoJCom3AKnThz_t3r0Cc5VxxjcXc-s9kB9JfCyCw3EPZ0XkcylXwCL9jfJOfeQ1"));
        return [$chave_cr, $caracteres_cript_reversa];
    } 

    private function enc($word, $cript_reversa, $chave_cr)
    {
        $word .= $cript_reversa;
        $s = strlen($word)+1;
        $nw = "";
        $n = $chave_cr;
        for ($x = 1; $x < $s; $x++){
            $m = $x*$n;
            if ($m > $s){
                $nindex = $m % $s;
            }
            else if ($m < $s){
                $nindex = $m;
            }
            if ($m % $s == 0){
                $nindex = $x;
            }
            $nw = $nw.$word[$nindex-1];
        }
        return $nw;
    }

    private function dec($word, $cript_reversa, $chave_cr)
    {
        $s = strlen($word)+1;
        $nw = "";
        $n = $chave_cr;
        for ($y = 1; $y < $s; $y++){
            $m = $y*$n;
            if ($m % $s == 1){
                $n = $y;
                break;
            }
        }
        for ($x = 1; $x < $s; $x++){
            $m = $x*$n;
            if ($m > $s){
                $nindex = $m % $s;
            }
            else if ($m < $s){
                $nindex = $m;
            }
            if ($m % $s == 0){
                $nindex = $x;
            }
            $nw = $nw.$word[$nindex-1];
        }
        $t = strlen($nw) - strlen($cript_reversa);
        return substr($nw, 0, $t);
    }

    private function decryptArray($arr, $cript_reversa, $chave_cr)
    {
        $decArray = array();
        foreach ($arr as $key => $value)
        { 
            $decArray[$key] = $this->dec($value, $cript_reversa, $chave_cr);
        }
        return $decArray;
    }
    
    private function generateDatabaseConnectionConfig($cfg_data)
    {
        
    }

    public function index(Request $request)
    {
        [$chave_cr, $cript_reversa] = $this->getCryptoParam();
        $data = new Tokens_api;
        $req_data = $data->getData($request->chave, $request->token);
        $driver_db = match($req_data->driver_db){
            "mssql" => "sqlsrv",
        };
        // $port = match($req_data->driver_db){

        // };

        $encrypt_data = [
                "user" => $req_data->usuario,
                "password" => $req_data->senha,
                "database" => $req_data->nome_banco,
        ];
        $connection_data = [
                "driver" => $driver_db,
                "host" => $req_data->host,
                "port" => 1433
        ];
        $final_connection_data = array_merge($connection_data, $encrypt_data);
        return response()->json([
            "status" => true,
            "message" => 'Token validado',
            "conn" => $final_connection_data,
            "decr" => $this->decryptArray($encrypt_data, $cript_reversa, $chave_cr),
        ]);
    }
    
}
