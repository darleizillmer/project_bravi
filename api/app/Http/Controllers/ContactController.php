<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\People;
use App\Contact;
use DB;
use Auth;
use Storage;

class ContactController extends Controller
{
    private $mPerson;
    private $mContact;
    
    public function __construct(People $mPerson, Contact $mContact){
        $this->mPerson = $mPerson;
        $this->mContact = $mContact;
    }
    
    /**
     * @OA\Get(
     *     path="/v1/contact/{id_person}",
     *     summary="Busca contatos de um usuario da base",
     *     tags={"Contact"},
     *     description="Busca contatos de um usuario da base",
     *     operationId="getContacts",
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
     *             @OA\Items(ref="#/components/schemas/Contact")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Nao encontrado",
     *     )
     * )
     */
    public function getContacts($id_person)
    {
        $oContact = DB::table($this->mContact->dbTable)->where('id_person', $id_person)->get();
        if(is_null($oContact)){
            return $this->respond(Response::HTTP_NOT_FOUND);
        }
        return $this->respond(Response::HTTP_OK, $oContact);
    }
    
    /**
     * @OA\Get(
     *     path="/v1/contact/unique/{id_contact}",
     *     summary="Busca contato especifico da base",
     *     tags={"Contact"},
     *     description="Busca contato especifico da base",
     *     operationId="getContact",
     *     @OA\Parameter(
     *         name="id_contact",
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
     *             @OA\Items(ref="#/components/schemas/Contact")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Nao encontrado",
     *     )
     * )
     */
    public function getContact($id_contact)
    {
        $oContact = $this->mContact->find($id_contact);
        if(is_null($oContact)){
            return $this->respond(Response::HTTP_NOT_FOUND);
        }
        return $this->respond(Response::HTTP_OK, $oContact);
    }

    /**
     * @OA\Post(
     *     path="/v1/contact",
     *     summary="Adiciona contato na base",
     *     tags={"Contact"},
     *     description="Adiciona contato na base",
     *     operationId="addContact",
     *     @OA\Parameter(
     *         name="body",
     *         in="query",
     *         description="Parametros enviados para o endpoint",
     *         required=true,
     *         @OA\Schema(
     *            type="object",
     *            @OA\Property(
     *                property="id_person",
     *                description="Id do usuario",
     *                type="integer",
     *            ),
     *            @OA\Property(
     *                property="phone_number",
     *                description="Telefone do usuario",
     *                type="string",
     *            ),
     *            @OA\Property(
     *                property="whatsapp_number",
     *                description="Whatsapp do usuario",
     *                type="string",
     *            ),
     *            @OA\Property(
     *                property="email",
     *                description="Eamil do usuario",
     *                type="string",
     *            ),
     *         ),
     *         style="form"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Adicionado com Sucesso",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Contact")
     *         ),
     *     )
     * )
     */
    public function addContact(Request $request)
    {
        $this->validate($request, $this->mContact->createRules);
        return $this->respond(Response::HTTP_CREATED, $this->mContact->create($request->all()));
    }

    /**
     * @OA\Put(
     *     path="/v1/contact/{id_contact}",
     *     summary="Atualiza contato na base",
     *     tags={"Contact"},
     *     description="Atualiza contato na base",
     *     operationId="putContact",
     *     @OA\Parameter(
     *         name="id_contact",
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
     *                property="id_person",
     *                description="Id do usuario",
     *                type="integer",
     *            ),
     *            @OA\Property(
     *                property="phone_number",
     *                description="Telefone do usuario",
     *                type="string",
     *            ),
     *            @OA\Property(
     *                property="whatsapp_number",
     *                description="Whatsapp do usuario",
     *                type="string",
     *            ),
     *            @OA\Property(
     *                property="email",
     *                description="Eamil do usuario",
     *                type="string",
     *            ),
     *         ),
     *         style="form"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Atualizado com Sucesso",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Contact")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Contato nao encontrado",
     *     )
     * )
     */
    public function putContact(Request $request, $id_contact)
    {
        $this->validate($request, $this->mContact->updateRules);
        $oPerson = $this->mContact->find($id_contact);
        if(is_null($oPerson)){
            return $this->respond(Response::HTTP_NOT_FOUND);
        }
        $oPerson->update($request->all());
        return $this->respond(Response::HTTP_OK, $oPerson);
    }

    /**
     * @OA\Delete(
     *     path="/v1/contact/{id_contact}",
     *     summary="Apaga dados de um contato na base",
     *     tags={"Contact"},
     *     description="Apaga dados de um contato na base",
     *     operationId="removeContact",
     *     @OA\Parameter(
     *         name="id_contact",
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
     *         description="Contato nao encontrado",
     *     )
     * )
     */
    public function removeContact($id_contact)
    {
        if(is_null($this->mContact->find($id_contact))){
            return $this->respond(Response::HTTP_NOT_FOUND);
        }
        $this->mContact->destroy($id_contact);
        return $this->respond(Response::HTTP_NO_CONTENT);
    }

    protected function respond($status, $data = [])
    {
        return response()->json($data, $status);
    }
}
