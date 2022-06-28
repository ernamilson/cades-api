<?php

namespace App\Http\Middleware;

use App\Models\Tokens;

use Closure;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class AuthTokens
{
            
    /**
     * Custom parameters.
     *
     * @var \Symfony\Component\HttpFoundation\ParameterBag
     *
     * @api
     */
    public $attributes;

    private function getCryptoParam()
    {
        $chave_cr = env('CRYPTO_KEY');
        $caracteres_cript_reversa = md5(sha1(env('CRYPTO_REVERSA')));
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
        // var_dump($data);
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
        $conn_name = $config["driver"].$config["username"];
        Config::set("database.connections.".$conn_name, $config);
        return $conn_name;
    }

    // public function generateConfig(Request $request)
    // {
    //     [$chave_cr, $cript_reversa] = $this->getCryptoParam();
    //     $tokens = new Tokens;

    //     // getting SQL response
    //     $req_data = $tokens->getData($request->chave, $request->token);
    //     var_dump($req_data);
    //     if($req_data === false) {
    //         return false;
    //     }

        
    //     // setting connection config
    //     $conn_cfg = $this->generateDatabaseConnectionConfig($req_data, $cript_reversa, $chave_cr);
        

    //     // var_dump($conn_cfg);
        
        
    //     // setting connection
    //     $conn_name = $this->setConnConfig($conn_cfg);

    //     return $conn_name;
    // }

     /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // if ($request->input('token') !== 'my-secret-token') {
        //     return redirect('home');
        // }


        [$chave_cr, $cript_reversa] = $this->getCryptoParam();
        $tokens = new Tokens;

        // getting SQL response
        $req_data = $tokens->getData($request->chave, $request->token);
        if ($req_data !== false)
        {
            try {
                $conn_cfg = $this->generateDatabaseConnectionConfig($req_data, $cript_reversa, $chave_cr);
            
                // setting connection
                $conn_name = $this->setConnConfig($conn_cfg);
            } catch (\Throwable $th) {
                throw $th;
                return false;
            }
        } else {
           return response()->json([
                'message' => "Could'nt connect to database."
           ], 400); 
        }
        // setting connection config
        $request->attributes->add(['conn_cfg' => $conn_name]);
 
        return $next($request);
    }
    
}
