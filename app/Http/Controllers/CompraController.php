<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $compra = Compra::all();
        return $compra;
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
            DB::transaction(function () use ($request) {

                $asientosComprados = json_decode($request->asientos_comprados);

                $compra = Compra::create(
                    [
                        "K_COMPRA" => $request->K_COMPRA,
                        "K_CLIENTE" => $request->K_CLIENTE,
                        "F_COMPRA" => $request->F_COMPRA,
                        //TODO: IMPLEMENTAR VALOR DE LA COMPRA
                        "V_COMPRA" => 0,
                        "ESTADO" => $request->ESTADO,

                    ]
                );

                foreach ($asientosComprados as $value) {
                    DB::update("UPDATE cine_distrito.proyeccion_asiento SET ESTADO='O' WHERE cine_distrito.K_MULTIPLEX=?,cine_distrito.K_ASIENTO=?,cine_distrito.K_SALA=?, cine_distrito.K_PROYECCION=?", [$value->K_MULTIPLEX, $value->K_ASIENTO, $value->K_SALA, $value->K_PROYECCION]);
                    
                    DB::insert('INSERT INTO cine_distrito.compra_asiento VALUES(?,?,?,?,?)', [$value->K_MULTIPLEX, $value->K_ASIENTO, $value->K_SALA, $value->K_PROYECCION, $value->K_COMPRA]);
                }
            }, 5);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return response()->json([
            'respuesta' => 'exitoso'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
