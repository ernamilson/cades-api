<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FreqCatraca;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class FreqCatracaController extends Controller
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
        try {
            $conn = $request->get('conn_cfg');
            using DB::connection
            $freq_catraca = DB::connection($conn)->insert(
                'insert into FreqCatraca (idAluno, dataLeitura, Data, Movimento) values (?, ?, ?, ?)',
                [$request->idAluno, $request->dataLeitura, $request->Data, $request->Movimento]
            );

            // Cadastrando multiplos logs

            // Request will need to have a logs array
            // {
            //     token: xxxxxx,
            //     chave: xxxxxx,
            //     logs: [
            //         {data},
            //         {data},
            //         {data}
            //     ]
            // }

            // $freq_catraca = DB::connection($conn);
            // foreach ($request->logs as $key => $value) {
            //     $freq_catraca->insert(
            //         'insert into FreqCatraca (idAluno, dataLeitura, Data, Movimento) values (?, ?, ?, ?)',
            //         [$request->idAluno, $request->dataLeitura, $request->Data, $request->Movimento]
            //     );
            // }

            return response()->json([
                'status' => true,
                'message' => 'Frequência cadastrada!',
                // 'request' => $request->all()
            ], 201);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json([
                'status' => true,
                'message' => 'Frequência nao cadastrada!',
                'err' => $th,
                // 'conn' => $conn
            ], 404);
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
