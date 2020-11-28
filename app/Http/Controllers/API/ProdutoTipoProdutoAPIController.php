<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProdutoTipoProdutoAPIRequest;
use App\Http\Requests\API\UpdateProdutoTipoProdutoAPIRequest;
use App\Models\ProdutoTipoProduto;
use App\Repositories\ProdutoTipoProdutoRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ProdutoTipoProdutoController
 * @package App\Http\Controllers\API
 */

class ProdutoTipoProdutoAPIController extends AppBaseController
{
    /** @var  ProdutoTipoProdutoRepository */
    private $produtoTipoProdutoRepository;

    public function __construct(ProdutoTipoProdutoRepository $produtoTipoProdutoRepo)
    {
        $this->produtoTipoProdutoRepository = $produtoTipoProdutoRepo;
    }

    /**
     * Display a listing of the ProdutoTipoProduto.
     * GET|HEAD /produtoTipoProdutos
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->produtoTipoProdutoRepository->pushCriteria(new RequestCriteria($request));
        $this->produtoTipoProdutoRepository->pushCriteria(new LimitOffsetCriteria($request));
        $produtoTipoProdutos = $this->produtoTipoProdutoRepository->all();

        return $this->sendResponse($produtoTipoProdutos->toArray(), 'Produto Tipo Produtos recuperados com sucesso');
    }

    /**
     * Store a newly created ProdutoTipoProduto in storage.
     * POST /produtoTipoProdutos
     *
     * @param CreateProdutoTipoProdutoAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateProdutoTipoProdutoAPIRequest $request)
    {
        $input = $request->all();

        $produtoTipoProdutos = $this->produtoTipoProdutoRepository->create($input);

        return $this->sendResponse($produtoTipoProdutos->toArray(), 'Produto Tipo Produto saved successfully');
    }

    /**
     * Display the specified ProdutoTipoProduto.
     * GET|HEAD /produtoTipoProdutos/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ProdutoTipoProduto $produtoTipoProduto */
        $produtoTipoProduto = $this->produtoTipoProdutoRepository->findWithoutFail($id);

        if (empty($produtoTipoProduto)) {
            return $this->sendError('Produto Tipo Produto not found');
        }

        return $this->sendResponse($produtoTipoProduto->toArray(), 'Produto Tipo Produto retrieved successfully');
    }

    /**
     * Update the specified ProdutoTipoProduto in storage.
     * PUT/PATCH /produtoTipoProdutos/{id}
     *
     * @param  int $id
     * @param UpdateProdutoTipoProdutoAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProdutoTipoProdutoAPIRequest $request)
    {
        $input = $request->all();

        /** @var ProdutoTipoProduto $produtoTipoProduto */
        $produtoTipoProduto = $this->produtoTipoProdutoRepository->findWithoutFail($id);

        if (empty($produtoTipoProduto)) {
            return $this->sendError('Produto Tipo Produto not found');
        }

        $produtoTipoProduto = $this->produtoTipoProdutoRepository->update($input, $id);

        return $this->sendResponse($produtoTipoProduto->toArray(), 'ProdutoTipoProduto updated successfully');
    }

    /**
     * Remove the specified ProdutoTipoProduto from storage.
     * DELETE /produtoTipoProdutos/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ProdutoTipoProduto $produtoTipoProduto */
        $produtoTipoProduto = $this->produtoTipoProdutoRepository->findWithoutFail($id);

        if (empty($produtoTipoProduto)) {
            return $this->sendError('Produto Tipo Produto not found');
        }

        $produtoTipoProduto->delete();

        return $this->sendResponse($id, 'Produto Tipo Produto deleted successfully');
    }
}
