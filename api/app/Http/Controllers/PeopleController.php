<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\People;
use DB;
use Auth;
use Storage;

class PeopleController extends Controller
{
    private $person;
    
    public function __construct(People $person){
        $this->person = $person;
    }
    
    /**
     * @OA\Get(
     *     path="/v1/person",
     *     summary="Busca todas pessoas da base",
     *     tags={"Person"},
     *     description="Busca todas pessoas da base",
     *     operationId="getAll",
     *     @OA\Response(
     *         response=200,
     *         description="Retorno com Sucesso",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/People")
     *         ),
     *     )
     * )
     */
    public function getAll()
    {
        return $this->respond(Response::HTTP_OK, $this->person->all());
    }
    
    /**
     * @OA\Get(
     *     path="/v1/person/{id_person}",
     *     summary="Busca dados da pessoa",
     *     tags={"Person"},
     *     description="Busca dados da pessoa",
     *     operationId="getPerson",
     *     @OA\Parameter(
     *         name="id_person",
     *         in="path",
     *         description="Parametros enviados para o endpoint",
     *         required=true,
     *         @OA\Schema(
     *            type="integer",
     *            format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Retorno com Sucesso",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/People")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Nao encontrado",
     *     )
     * )
     */
    public function getPerson($id_person)
    {
        $oPerson = $this->person->find($id_person);
        if(is_null($oPerson)){
            return $this->respond(Response::HTTP_NOT_FOUND);
        }
        return $this->respond(Response::HTTP_OK, $oPerson);
    }
    
    /**
     * @OA\Post(
     *     path="/v1/person",
     *     summary="Adiciona passoa na base",
     *     tags={"Person"},
     *     description="Adiciona passoa na base",
     *     operationId="addPerson",
     *     @OA\Parameter(
     *         name="body",
     *         in="query",
     *         description="Parametros enviados para o endpoint",
     *         required=true,
     *         @OA\Schema(
     *            type="object",
     *            @OA\Property(
     *                property="name",
     *                description="Nome do usuario",
     *                type="string",
     *            )
     *         ),
     *         style="form"
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Criado com Sucesso",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/People")
     *         ),
     *     )
     * )
     */
    public function addPerson(Request $request)
    {
        $this->validate($request, $this->person->createRules);
        return $this->respond(Response::HTTP_CREATED, $this->person->create($request->all()));
    }
    
    /**
     * @OA\Put(
     *     path="/v1/person/{id_person}",
     *     summary="Atualiza dados de uma passoa na base",
     *     tags={"Person"},
     *     description="Atualiza dados de uma passoa na base",
     *     operationId="putPerson",
     *     @OA\Parameter(
     *         name="id_person",
     *         in="path",
     *         description="Parametros enviados para o endpoint",
     *         required=true,
     *         @OA\Schema(
     *            type="integer",
     *            format="int64"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="body",
     *         in="query",
     *         description="Parametros enviados para o endpoint",
     *         required=true,
     *         @OA\Schema(
     *            type="object",
     *            @OA\Property(
     *                property="name",
     *                description="Nome do usuario",
     *                type="string",
     *            )
     *         ),
     *         style="form"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Atualizado com Sucesso",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/People")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario nao encontrado",
     *     )
     * )
     */
    public function putPerson(Request $request, $id_person)
    {
        $this->validate($request, $this->person->updateRules);
        $oPerson = $this->person->find($id_person);
        if(is_null($oPerson)){
            return $this->respond(Response::HTTP_NOT_FOUND);
        }
        $oPerson->update($request->all());
        return $this->respond(Response::HTTP_OK, $oPerson);
    }
    
    /**
     * @OA\Delete(
     *     path="/v1/person/{id_person}",
     *     summary="Apaga dados de uma passoa na base",
     *     tags={"Person"},
     *     description="Apaga dados de uma passoa na base",
     *     operationId="removePerson",
     *     @OA\Parameter(
     *         name="id_person",
     *         in="path",
     *         description="Parametros enviados para o endpoint",
     *         required=true,
     *         @OA\Schema(
     *            type="integer",
     *            format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Apagado com Sucesso",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario nao encontrado",
     *     )
     * )
     */
    public function removePerson($id_person)
    {
        if(is_null($this->person->find($id_person))){
            return $this->respond(Response::HTTP_NOT_FOUND);
        }
        $this->person->destroy($id_person);
        return $this->respond(Response::HTTP_NO_CONTENT);
    }

    protected function respond($status, $data = [])
    {
        return response()->json($data, $status);
    }

}

