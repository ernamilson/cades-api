<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tokens;
use Illuminate\Http\Request;

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
    
    private function generateDatabaseConnectionConfig($data, $cript_reversa, $chave_cr)
    {
        // matching driver name to laravel driver names
        $driver_db = match($data->driver_db){
            "mssql" => "sqlsrv",
        };
        // matching default db ports based on driver
        $port = match($driver_db){
            "mssql" => "3306",
            "sqlsrv" => "1433"
        };
        // crypt data (usr, pwd, db_name)
        $encrypt_data = [
                "database" => $data->nome_banco,
                "username" => $data->usuario,
                "password" => $data->senha
        ];
        // uncrypt data (driver, host, port)
        $connection_data = [
                "driver" => $driver_db,
                "host" => $data->host,
                "port" => $port,
                // "username" => 'userInfor',
                "trust_server_certificate" => 'false',
                "charset" => "utf8",
                "prefix" => "",
                "prefix_indexes" => true,

        ];

        // var_dump($this->dec($data->usuario, $cript_reversa, $chave_cr));

        $decrypt_data = $this->decryptArray($encrypt_data, $cript_reversa, $chave_cr);

        $final_connection_data = array_merge($connection_data, $decrypt_data);
        
        return $final_connection_data;
    }

    private function setConnConfig($config) {
        // $conn_name = $config["driver"]."_".$config["user"];
        // Config::set("database.connections.".$conn_name, $config);
        // return $conn_name;
        $conn_name = $config["driver"].$config["username"];
        Config::set("database.connections.".$conn_name, $config);
        // Config::set("database.connections.sqlsrv", $config);
        return $conn_name;
    }

    public function generateConfig(Request $request)
    {
        [$chave_cr, $cript_reversa] = $this->getCryptoParam();
        $tokens = new Tokens;

        // getting SQL response
        $req_data = $tokens->getData($request->chave, $request->token);
        
        if($req_data === false) {
            return false;
        }

        
        // setting connection config
        $conn_cfg = $this->generateDatabaseConnectionConfig($req_data, $cript_reversa, $chave_cr);
        

        // var_dump($conn_cfg);
        
        
        // setting connection
        $conn_name = $this->setConnConfig($conn_cfg);

        return $conn_name;
    }
    
}
