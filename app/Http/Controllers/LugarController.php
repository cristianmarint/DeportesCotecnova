<?php

namespace App\Http\Controllers;

use App\Lugar;

use App\Departamento;
use App\Municipio;
use App\Direccion;
use App\Telefono;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LugarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lugares = Lugar::all();
        return view('lugar.index', compact('lugares'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departamentos = Departamento::orderBy('nombre', 'asc')->get();
        return view('lugar.create', compact('departamentos'));
    }

    /**
     * Display the specified resource .
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response json
     */
    public function getLugar($id){
        $lugar = Lugar::where('lugar_id',$id)
            ->orderBy('nombre', 'asc')
            ->get();
        return response()->json($lugar);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|min:3|max:50',
            'municipio' => 'required|integer|not_in:0|exists:municipio,id',
            'calle' => 'required|string|min:3|max:50',
            'carrera' => 'required|string|min:3|max:10',
            'numero' => 'required|string|min:1|max:5',
            'tipo_telefono' => 'required|integer|not_in:0|exists:telefono,id',
            'telefono' => 'required|integer|min:7'
        ]);

        DB::transaction(function () use ($data, $request) {
            $telefono = Telefono::create([
                'numero' => $data['telefono'],
                'tipo' => $data['tipo_telefono']
            ]);

            $direccion = Direccion::create([
                'calle' => $data['calle'],
                'carrera' => $data['carrera'],
                'numero' => $data['numero'],
            ]);

            Lugar::create([
                'nombre' => $data['nombre'],
                'municipio_id' => $data['municipio'],
                'telefono_id' => $telefono->id,
                'direccion_id' => $direccion->id,
                'user_id' => Auth::user()->id
            ]);
        });

        return redirect(route('lugares.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lugar = Lugar::findOrFail($id);
        return view('lugar.show', compact('lugar'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lugar = Lugar::findOrFail($id);
        $departamentos = Departamento::orderBy('nombre', 'asc')->get();
        $telefono = Telefono::orderBy('numero', 'asc')->get();

        return view('lugar.edit',compact('lugar','departamentos','telefono'));
        
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
        $lugar = Lugar::findOrFail($id);
        $data = $request->validate([
            'nombre' => 'required|min:3|max:50',
            'municipio' => 'required|integer|not_in:0|exists:municipio,id',
            'calle' => 'required|string|min:3|max:50',
            'carrera' => 'required|string|min:3|max:10',
            'numero' => 'required|string|min:1|max:5',
            'tipo_telefono' => 'required|integer|not_in:0|exists:telefono,id',
            'telefono' => 'required|integer|min:7'
        ]);

        DB::transaction(function () use ($data, $request, $lugar) {
            $telefono = Telefono::create([
                'numero' => $data['telefono'],
                'tipo' => $data['tipo_telefono']
            ]);

            $direccion = Direccion::create([
                'calle' => $data['calle'],
                'carrera' => $data['carrera'],
                'numero' => $data['numero'],
            ]);

            Lugar::find($lugar->id)->
                update([
                    'nombre' => $data['nombre'],
                    'municipio_id' => $data['municipio'],
                    'telefono_id' => $telefono->id,
                    'direccion_id' => $direccion->id,
                    'user_id' => Auth::user()->id
                ]);
        }, 2);
        return redirect(route('lugares.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Lugar::find($id)->delete();
        return redirect(route('lugares.index'));
    }
}