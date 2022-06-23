<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FreqCatraca;
use Illuminate\Http\Request;

class FreqCatracaController extends ExternalDatabaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = $this->generateConfig($request);
        if($conn == false) {
            return response()->json([
                'status' => true,
                'message' => 'Frequência nao cadastrada!',
                'err' => 'Erro de credenciais!',
                'conn' => $conn
            ]);
        }
        // $freq_catraca->setConnection($freq_catraca->connection, $conn);
        var_dump(json_encode(config()->get('database.connections')));
        try {
            $freq_catraca = new FreqCatraca();
            $freq_catraca::on('sqlsrv_userInfor')->create([
                'idAluno' => $request->idAluno,
                'dataLeitura' => $request->dataLeitura,
                'Data' => $request->Data,
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Frequência cadastrada!',
                // 'post' => $frequencia,
                'conn' => $conn
            ]);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json([
                'status' => true,
                'message' => 'Frequência nao cadastrada!',
                'err' => $th,
                'conn' => $conn
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FreqCatraca  $freqCatraca
     * @return \Illuminate\Http\Response
     */
    public function show(FreqCatraca $freqCatraca)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FreqCatraca  $freqCatraca
     * @return \Illuminate\Http\Response
     */
    public function edit(FreqCatraca $freqCatraca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FreqCatraca  $freqCatraca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FreqCatraca $freqCatraca)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FreqCatraca  $freqCatraca
     * @return \Illuminate\Http\Response
     */
    public function destroy(FreqCatraca $freqCatraca)
    {
        //
    }
}
