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
        $asientos = json_decode($request->asientos);
        $snacks = json_decode($request->snacks);
        $usuario = json_decode($request->usuario);

        try {
            DB::transaction(function () use ($request, $asientos, $snacks, $usuario) {

                $compra = Compra::create(
                    [
                        "K_COMPRA" => mt_rand(0, 10000000000),
                        "K_CLIENTE" => $usuario->K_CLIENTE,
                        // "F_COMPRA" => $request->F_COMPRA,
                        //TODO: IMPLEMENTAR VALOR DE LA COMPRA
                        "V_COMPRA" => 0,
                        "ESTADO" => 'ACEPTADO',

                    ]
                );

                foreach ($asientos as $value) {
                    DB::update("UPDATE cine_distrito.proyeccion_asiento SET ESTADO='O' WHERE cine_distrito.proyeccion_asiento.K_MULTIPLEX=? AND cine_distrito.proyeccion_asiento.K_ASIENTO=? AND cine_distrito.proyeccion_asiento.K_SALA=? AND cine_distrito.proyeccion_asiento.K_PROYECCION=?", [$value->K_MULTIPLEX, $value->K_ASIENTO, $value->K_SALA, $value->K_PROYECCION]);

                    DB::insert('INSERT INTO cine_distrito.compra_asiento VALUES(?,?,?,?,?)', [$value->K_MULTIPLEX, $value->K_ASIENTO, $value->K_SALA, $value->K_PROYECCION, $compra->K_COMPRA]);
                }

                foreach ($snacks as $value) {
                    DB::update("UPDATE cine_distrito.snack SET Q_SNACK=Q_SNACK-? WHERE cine_distrito.snack.K_SNACK=?", [$value->cantidad_comprada, $value->K_SNACK]);

                    DB::insert('INSERT INTO cine_distrito.compra_snack VALUES(?,?,?,?)', [$value->K_SNACK, $compra->K_COMPRA, $value->cantidad_comprada, 0]);
                    //TODO Hacer el valor del subtotal de la compra
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
