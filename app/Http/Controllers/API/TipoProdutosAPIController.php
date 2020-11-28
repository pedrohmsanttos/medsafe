<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTipoProdutosAPIRequest;
use App\Http\Requests\API\UpdateTipoProdutosAPIRequest;
use App\Models\TipoProdutos;
use App\Repositories\TipoProdutosRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class TipoProdutosController
 * @package App\Http\Controllers\API
 */

class TipoProdutosAPIController extends AppBaseController
{
    /** @var  TipoProdutosRepository */
    private $tipoProdutosRepository;

    public function __construct(TipoProdutosRepository $tipoProdutosRepo)
    {
        $this->tipoProdutosRepository = $tipoProdutosRepo;
    }

    /**
     * Display a listing of the TipoProdutos.
     * GET|HEAD /tipoProdutos
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->tipoProdutosRepository->pushCriteria(new RequestCriteria($request));
        $this->tipoProdutosRepository->pushCriteria(new LimitOffsetCriteria($request));
        $tipoProdutos = $this->tipoProdutosRepository->all();

        return $this->sendResponse($tipoProdutos->toArray(), 'Tipo Produtos retrieved successfully');
    }

    /**
     * Store a newly created TipoProdutos in storage.
     * POST /tipoProdutos
     *
     * @param CreateTipoProdutosAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateTipoProdutosAPIRequest $request)
    {
        $input = $request->all();

        $tipoProdutos = $this->tipoProdutosRepository->create($input);

        return $this->sendResponse($tipoProdutos->toArray(), 'Tipo Produtos saved successfully');
    }

    /**
     * Display the specified TipoProdutos.
     * GET|HEAD /tipoProdutos/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var TipoProdutos $tipoProdutos */
        $tipoProdutos = $this->tipoProdutosRepository->findWithoutFail($id);

        if (empty($tipoProdutos)) {
            return $this->sendError('Tipo Produtos not found');
        }

        return $this->sendResponse($tipoProdutos->toArray(), 'Tipo Produtos retrieved successfully');
    }

    /**
     * Update the specified TipoProdutos in storage.
     * PUT/PATCH /tipoProdutos/{id}
     *
     * @param  int $id
     * @param UpdateTipoProdutosAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTipoProdutosAPIRequest $request)
    {
        $input = $request->all();

        /** @var TipoProdutos $tipoProdutos */
        $tipoProdutos = $this->tipoProdutosRepository->findWithoutFail($id);

        if (empty($tipoProdutos)) {
            return $this->sendError('Tipo Produtos not found');
        }

        $tipoProdutos = $this->tipoProdutosRepository->update($input, $id);

        return $this->sendResponse($tipoProdutos->toArray(), 'TipoProdutos updated successfully');
    }

    /**
     * Remove the specified TipoProdutos from storage.
     * DELETE /tipoProdutos/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var TipoProdutos $tipoProdutos */
        $tipoProdutos = $this->tipoProdutosRepository->findWithoutFail($id);

        if (empty($tipoProdutos)) {
            return $this->sendError('Tipo Produtos not found');
        }

        $tipoProdutos->delete();

        return $this->sendResponse($id, 'Tipo Produtos deleted successfully');
    }
}
