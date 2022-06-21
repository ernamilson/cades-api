<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FreqCatraca;
use Illuminate\Http\Request;

class FreqCatracaController extends Controller
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
    public function store(Request $request)
    {
        $frequencia = FreqCatraca::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Frequência cadastrada!',
            'post' => $frequencia
        ]);
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
