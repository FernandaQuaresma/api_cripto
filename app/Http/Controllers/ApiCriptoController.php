<?php

namespace App\Http\Controllers;

use App\Models\ApiCripto;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ApiCriptoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $regBook = ApiCripto::All();
        $contador = $regBook->count();


        if($contador > 0) {
            return response()->json([
                'sucess' => true,
                'message' => 'Criptomoedas encontradas com sucesso!',
                'data' => $regBook,
                'total' => $contador
            ], 200);
        } else {
            return response()->json([
                'sucess' => false,
                'message' => 'Nenhuma criptomoeda encontrada.'
            ], 404);
        };
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'sigla' => 'required',
        'nome' => 'required',
        'valor'=> 'required'
      ]);

      if($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Registros inválidos',
            'errors' => $validator->errors()
        ], 400);
      }

      $registros = ApiCripto::create($request->all());

      if($registros) {
        return response()->json([
            'success' => true,
            'message' => 'Criptomoeda cadastrada com sucesso!',
            'data' => $registros
        ], 201);
      } else {
        return response()->json([
            'success' => false,
            'message' => 'Error ao cadastrar a criptomoeda'
        ], 500);
      }
    }

    /**
     * Display the specified resource.
     */
    public function show(ApiCripto $apiCripto, string $id)
    {
        $regBook = ApiCripto::find($id);

        if($regBook){
            return 'Criptomoedas Localizadas: '.$regBook.Response()->json([], Response::HTTP_NO_CONTENT);    
        }
        else{
            return 'Criptomoedas não localizadas.'.Response()->json([],Response::HTTP_NO_CONTENT);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, ApiCripto $apiCripto )
    {
        $validator = Validator::make($request->all(), [
            'sigla' => 'required',
            'nome' => 'required',
            'valor' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Registros inválidos',
                'errors' => $validator->errors()
            ], 400);
        }

        $regBookBanco = ApiCripto::find($id);

        if (!$regBookBanco) {
            return response()->json([
                'success' => false,
                'message' => 'Criptomoeda não encontrado'
            ], 404);
        }

        $regBookBanco->sigla = $request->sigla;
        $regBookBanco->nome = $request->nome;
        $regBookBanco->valor = $request->valor;

        if ($regBookBanco->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Criptomoeda atualizado com sucesso!',
                'data' => $regBookBanco
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar a criptomoeda'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ApiCripto $apiCripto, string $id)
    {
        $regBook = ApiCripto::find($id);

        if(!$regBook) {
            return response()->json([
                'success' => false,
                'message' => 'criptomoeda não encontradp'
            ], 404);
        }

        if ($regBook->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Criptomoeda deletado com sucesso'
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Erro ao deletar a criptomoeda'
        ], 500);
    }
}
