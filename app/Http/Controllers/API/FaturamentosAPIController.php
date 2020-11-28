<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateFaturamentosAPIRequest;
use App\Http\Requests\API\UpdateFaturamentosAPIRequest;
use App\Models\Faturamentos;
use App\Repositories\FaturamentosRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class FaturamentosController
 * @package App\Http\Controllers\API
 */

class FaturamentosAPIController extends AppBaseController
{
    /** @var  FaturamentosRepository */
    private $faturamentosRepository;

    public function __construct(FaturamentosRepository $faturamentosRepo)
    {
        $this->faturamentosRepository = $faturamentosRepo;
    }

    /**
     * Display a listing of the Faturamentos.
     * GET|HEAD /faturamentos
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->faturamentosRepository->pushCriteria(new RequestCriteria($request));
        $this->faturamentosRepository->pushCriteria(new LimitOffsetCriteria($request));
        $faturamentos = $this->faturamentosRepository->all();

        return $this->sendResponse($faturamentos->toArray(), 'Faturamentos retrieved successfully');
    }

    /**
     * Store a newly created Faturamentos in storage.
     * POST /faturamentos
     *
     * @param CreateFaturamentosAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateFaturamentosAPIRequest $request)
    {
        $input = $request->all();

        $faturamentos = $this->faturamentosRepository->create($input);

        return $this->sendResponse($faturamentos->toArray(), 'Faturamentos saved successfully');
    }

    /**
     * Display the specified Faturamentos.
     * GET|HEAD /faturamentos/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Faturamentos $faturamentos */
        $faturamentos = $this->faturamentosRepository->findWithoutFail($id);

        if (empty($faturamentos)) {
            return $this->sendError('Faturamentos not found');
        }

        return $this->sendResponse($faturamentos->toArray(), 'Faturamentos retrieved successfully');
    }

    /**
     * Update the specified Faturamentos in storage.
     * PUT/PATCH /faturamentos/{id}
     *
     * @param  int $id
     * @param UpdateFaturamentosAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFaturamentosAPIRequest $request)
    {
        $input = $request->all();

        /** @var Faturamentos $faturamentos */
        $faturamentos = $this->faturamentosRepository->findWithoutFail($id);

        if (empty($faturamentos)) {
            return $this->sendError('Faturamentos not found');
        }

        $faturamentos = $this->faturamentosRepository->update($input, $id);

        return $this->sendResponse($faturamentos->toArray(), 'Faturamentos updated successfully');
    }

    /**
     * Remove the specified Faturamentos from storage.
     * DELETE /faturamentos/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Faturamentos $faturamentos */
        $faturamentos = $this->faturamentosRepository->findWithoutFail($id);

        if (empty($faturamentos)) {
            return $this->sendError('Faturamentos not found');
        }

        $faturamentos->delete();

        return $this->sendResponse($id, 'Faturamentos deleted successfully');
    }
}
