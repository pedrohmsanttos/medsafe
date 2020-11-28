<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCorretoraAPIRequest;
use App\Http\Requests\API\UpdateCorretoraAPIRequest;
use App\Models\Corretora;
use App\Repositories\CorretoraRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class CorretoraController
 * @package App\Http\Controllers\API
 */

class CorretoraAPIController extends AppBaseController
{
    /** @var  CorretoraRepository */
    private $corretoraRepository;

    public function __construct(CorretoraRepository $corretoraRepo)
    {
        $this->corretoraRepository = $corretoraRepo;
    }

    /**
     * Display a listing of the Corretora.
     * GET|HEAD /corretoras
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->corretoraRepository->pushCriteria(new RequestCriteria($request));
        $this->corretoraRepository->pushCriteria(new LimitOffsetCriteria($request));
        $corretoras = $this->corretoraRepository->all();

        return $this->sendResponse($corretoras->toArray(), 'Corretoras retrieved successfully');
    }

    /**
     * Store a newly created Corretora in storage.
     * POST /corretoras
     *
     * @param CreateCorretoraAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCorretoraAPIRequest $request)
    {
        $input = $request->all();

        $corretoras = $this->corretoraRepository->create($input);

        return $this->sendResponse($corretoras->toArray(), 'Corretora saved successfully');
    }

    /**
     * Display the specified Corretora.
     * GET|HEAD /corretoras/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Corretora $corretora */
        $corretora = $this->corretoraRepository->findWithoutFail($id);

        if (empty($corretora)) {
            return $this->sendError('Corretora not found');
        }

        return $this->sendResponse($corretora->toArray(), 'Corretora retrieved successfully');
    }

    /**
     * Update the specified Corretora in storage.
     * PUT/PATCH /corretoras/{id}
     *
     * @param  int $id
     * @param UpdateCorretoraAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCorretoraAPIRequest $request)
    {
        $input = $request->all();

        /** @var Corretora $corretora */
        $corretora = $this->corretoraRepository->findWithoutFail($id);

        if (empty($corretora)) {
            return $this->sendError('Corretora not found');
        }

        $corretora = $this->corretoraRepository->update($input, $id);

        return $this->sendResponse($corretora->toArray(), 'Corretora updated successfully');
    }

    /**
     * Remove the specified Corretora from storage.
     * DELETE /corretoras/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Corretora $corretora */
        $corretora = $this->corretoraRepository->findWithoutFail($id);

        if (empty($corretora)) {
            return $this->sendError('Corretora not found');
        }

        $corretora->delete();

        return $this->sendResponse($id, 'Corretora deleted successfully');
    }
}
