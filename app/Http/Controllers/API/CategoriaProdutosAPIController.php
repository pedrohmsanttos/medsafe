<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCategoriaProdutosAPIRequest;
use App\Http\Requests\API\UpdateCategoriaProdutosAPIRequest;
use App\Models\CategoriaProdutos;
use App\Repositories\CategoriaProdutosRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class CategoriaProdutosController
 * @package App\Http\Controllers\API
 */

class CategoriaProdutosAPIController extends AppBaseController
{
    /** @var  CategoriaProdutosRepository */
    private $categoriaProdutosRepository;

    public function __construct(CategoriaProdutosRepository $categoriaProdutosRepo)
    {
        $this->categoriaProdutosRepository = $categoriaProdutosRepo;
    }

    /**
     * Display a listing of the CategoriaProdutos.
     * GET|HEAD /categoriaProdutos
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->categoriaProdutosRepository->pushCriteria(new RequestCriteria($request));
        $this->categoriaProdutosRepository->pushCriteria(new LimitOffsetCriteria($request));
        $categoriaProdutos = $this->categoriaProdutosRepository->all();

        return $this->sendResponse($categoriaProdutos->toArray(), 'Categoria Produtos retrieved successfully');
    }

    /**
     * Store a newly created CategoriaProdutos in storage.
     * POST /categoriaProdutos
     *
     * @param CreateCategoriaProdutosAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCategoriaProdutosAPIRequest $request)
    {
        $input = $request->all();

        $categoriaProdutos = $this->categoriaProdutosRepository->create($input);

        return $this->sendResponse($categoriaProdutos->toArray(), 'Categoria Produtos saved successfully');
    }

    /**
     * Display the specified CategoriaProdutos.
     * GET|HEAD /categoriaProdutos/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var CategoriaProdutos $categoriaProdutos */
        $categoriaProdutos = $this->categoriaProdutosRepository->findWithoutFail($id);

        if (empty($categoriaProdutos)) {
            return $this->sendError('Categoria Produtos not found');
        }

        return $this->sendResponse($categoriaProdutos->toArray(), 'Categoria Produtos retrieved successfully');
    }

    /**
     * Update the specified CategoriaProdutos in storage.
     * PUT/PATCH /categoriaProdutos/{id}
     *
     * @param  int $id
     * @param UpdateCategoriaProdutosAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCategoriaProdutosAPIRequest $request)
    {
        $input = $request->all();

        /** @var CategoriaProdutos $categoriaProdutos */
        $categoriaProdutos = $this->categoriaProdutosRepository->findWithoutFail($id);

        if (empty($categoriaProdutos)) {
            return $this->sendError('Categoria Produtos not found');
        }

        $categoriaProdutos = $this->categoriaProdutosRepository->update($input, $id);

        return $this->sendResponse($categoriaProdutos->toArray(), 'CategoriaProdutos updated successfully');
    }

    /**
     * Remove the specified CategoriaProdutos from storage.
     * DELETE /categoriaProdutos/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var CategoriaProdutos $categoriaProdutos */
        $categoriaProdutos = $this->categoriaProdutosRepository->findWithoutFail($id);

        if (empty($categoriaProdutos)) {
            return $this->sendError('Categoria Produtos not found');
        }

        $categoriaProdutos->delete();

        return $this->sendResponse($id, 'Categoria Produtos deleted successfully');
    }
}
