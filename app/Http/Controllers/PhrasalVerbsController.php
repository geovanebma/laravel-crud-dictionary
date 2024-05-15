<?php

namespace App\Http\Controllers;

use App\Models\PhrasalVerbs;
use Illuminate\Http\Request;
use App\Http\Requests\StorePhrasalVerbsRequest;
use App\Http\Requests\UpdatePhrasalVerbsRequest;

class PhrasalVerbsController extends Controller
{
    public function __construct(PhrasalVerbs $phrasal){
        $this->phrasal = $phrasal;
    }

    /**
     * Display a listing of the resource.
     * @param  \App\Models\Dictionary  $dictionary
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $word = $request->input('word');
        $important = $request->input('important');
        $learned = $request->input('learned');

        $query = $this->phrasal->query();

        if ($word != "") {
            $query->where('word', 'LIKE', '%'.$word.'%');
        }

        if ($important == "true") {
            $query->where('important', '=', $important)->orWhere('important', '=', '1');
        }else{
            // $query->where('important', '=', $important)->orWhere('important', '=', '0');
        }

        if ($learned == "true") {
            $query->where('learned', '=', $learned)->orWhere('learned', '=', '1');
        }else{
            // $query->where('learned', '=', $learned)->orWhere('learned', '=', '0');
        }

        $result = $query->get();

        // Retorne a resposta com os dados filtrados, por exemplo, em JSON
        return response()->json($result);
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
     * @param  \App\Http\Requests\StorePhrasalVerbsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePhrasalVerbsRequest $request)
    {
        $data = $request->all();

        if(count((array) $data) == 1){
            $create = $this->phrasal->create($data);
            return response()->json(['message' => 'Registros inseridos com sucesso'], 201);
        }else if(count((array) $data) > 1){
            $create = $this->phrasal->insert($data);
            return $create;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dado = $this->phrasal->find($id);
        
        if($dado === null){
            return ["erro" => "Não foram encontrados dados com o índice informado."];    
        }

        return $dado;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PhrasalVerbs  $phrasalVerbs
     * @return \Illuminate\Http\Response
     */
    public function edit(PhrasalVerbs $phrasalVerbs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePhrasalVerbsRequest  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePhrasalVerbsRequest $request, $id)
    {
        $phrasal = $this->phrasal->find($id);
        
        if($phrasal === null){
            return ["erro" => "Não foram encontrados dados para atualização com o índice informado."];    
        }
        
        $phrasal->update($request->all());
        return $phrasal;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Integer $id)
    {
        $phrasal = $this->phrasal->find($id);

        if($phrasal === null){
            return ["erro" => "Não foram encontrados dados para exclusão com o índice informado."];    
        }

        $phrasal->delete();
        return ["warning" => "Item removed successfully."];
    }
}