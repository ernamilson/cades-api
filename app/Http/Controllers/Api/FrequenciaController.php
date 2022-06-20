<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFrequenciaRequest;
use App\Models\Frequencia;
use Illuminate\Http\Request;

class FrequenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'status' => true,
            'message' => 'Get Response'
        ]);
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
    public function store(StoreFrequenciaRequest $request)
    {

        $frequencia = Frequencia::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Frequência cadastrada!',
            'post' => $frequencia
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Frequencia  $frequencia
     * @return \Illuminate\Http\Response
     */
    public function show(Frequencia $frequencia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Frequencia  $frequencia
     * @return \Illuminate\Http\Response
     */
    public function edit(Frequencia $frequencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Frequencia  $frequencia
     * @return \Illuminate\Http\Response
     */
    public function update(StoreFrequenciaRequest $request, Frequencia $frequencia)
    {
        $frequencia->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Frequência atualizada!',
            'post' => $frequencia
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Frequencia  $frequencia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Frequencia $frequencia)
    {
        //
    }
}
