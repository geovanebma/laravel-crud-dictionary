<?php

namespace App\Http\Controllers;

use App\Models\Dictionary;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDictionaryRequest;
use App\Http\Requests\UpdateDictionaryRequest;

class DictionaryController extends Controller
{
    public function __construct(Dictionary $dictionary){
        $this->dictionary = $dictionary;
    }

    /**
     * Display a listing of the resource.
     * @param  \App\Models\Dictionary  $dictionary
     * @return \Illuminate\Http\Response
     */
    // public function index(Dictionary $dictionary)
    public function index(Request $request)
    {
        $word = $request->input('word');
        $type = $request->input('type');
        $important = $request->input('important');
        $learned = $request->input('learned');
        $filter = $request->input('filter');

        $query = $this->dictionary->query();

        if ($word != "") {
            $query->where('word', 'LIKE', '%'.$word.'%');
        }

        if ($type != "") {
            $query->where('type', '=', $type);
        }

        if ($filter == "important_filter") {
            $query->where('important', '=', true)->orWhere('important', '=', '1');
        }

        if ($filter == "learned_filter") {
            $query->where('learned', '=', true)->orWhere('learned', '=', '1');
        }

        if ($filter == "dont_important_filter") {
            $query->where('important', '=', false)->orWhere('important', '<>', '1');
        }

        if ($filter == "dont_learned_filter") {
            $query->where('learned', '=', false)->orWhere('learned', '<>', '1');
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
     * @param  \App\Http\Requests\StoreDictionaryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDictionaryRequest $request)
    {
        $data = $request->all();

        if(count((array) $data) == 1){
            $create = $this->dictionary->create($data);
            return response()->json(['message' => 'Registros inseridos com sucesso'], 201);
        }else if(count((array) $data) > 1){
            $create = $this->dictionary->insert($data);
            return $create;
        }

        // try {
        //     if(count((array) $data) == 1){
        //         $create = $this->dictionary->create($data);
        //         return response()->json(['message' => 'Registros inseridos com sucesso'], 201);
        //     }else if(count((array) $data) > 1){
        //         $create = $this->dictionary->insert($data);
        //         return $create;
        //     }
        // } catch (\Exception $e) {
        //     return response()->json(['error' => 'Erro ao inserir dados: ' . $e->getMessage()], 500); // Retorna uma resposta de erro com o código de status 500 (Internal Server Error)
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dictionary  $dictionary
     * @return \Illuminate\Http\Response
     */
    // public function show(Dictionary $dictionary)
    // {
    //     return $dictionary;
    // }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dado = $this->dictionary->find($id);
        
        if($dado === null){
            return ["erro" => "Não foram encontrados dados com o índice informado."];    
        }

        return $dado;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dictionary  $dictionary
     * @return \Illuminate\Http\Response
     */
    public function edit(Dictionary $dictionary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDictionaryRequest  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDictionaryRequest $request, $id)
    {
        // print_r($request->all());
        // print "<hr>";
        // print_r($dictionary->getAttributes());

        $dictionary = $this->dictionary->find($id);
        
        if($dictionary === null){
            return ["erro" => "Não foram encontrados dados para atualização com o índice informado."];    
        }
        
        $dictionary->update($request->all());
        return $dictionary;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDictionaryRequest  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function updateAll(UpdateDictionaryRequest $request)
    {
        // return response()->json(['message' => $request->all()]);

        $data = $request->all();

        foreach ($data as $id => $attributes) {
            // Encontrar o modelo pelo ID
            $model = $this->dictionary->find($attributes["id"]);
            
            if ($model) {
                $model->update($attributes);
            }
        }

        return response()->json(['message' => $model]);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Integer $id)
    {
        $dictionary = $this->dictionary->find($id);

        if($dictionary === null){
            return ["erro" => "Não foram encontrados dados para exclusão com o índice informado."];    
        }

        $dictionary->delete();
        return ["warning" => "Item removed successfully."];
    }

    public function deleteAllData()
    {
        Dictionary::truncate();
        return ["warning" => "Itens removed successfully."];
    }
}