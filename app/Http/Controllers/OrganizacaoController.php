<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrganizacaoRequest;
use App\Http\Requests\UpdateOrganizacaoRequest;
use App\Repositories\OrganizacaoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class OrganizacaoController extends AppBaseController
{
    /** @var  OrganizacaoRepository */
    private $organizacaoRepository;

    public function __construct(OrganizacaoRepository $organizacaoRepo)
    {
        $this->organizacaoRepository = $organizacaoRepo;
    }

    /**
     * Display a listing of the Organizacao.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->organizacaoRepository->pushCriteria(new RequestCriteria($request));
        $organizacaos = $this->organizacaoRepository->all();

        return view('organizacaos.index')
            ->with('organizacaos', $organizacaos);
    }

    /**
     * Show the form for creating a new Organizacao.
     *
     * @return Response
     */
    public function create()
    {
        return view('organizacaos.create');
    }

    /**
     * Store a newly created Organizacao in storage.
     *
     * @param CreateOrganizacaoRequest $request
     *
     * @return Response
     */
    public function store(CreateOrganizacaoRequest $request)
    {
        $input = $request->all();

        $organizacao = $this->organizacaoRepository->create($input);

        Flash::success('Organizacao saved successfully.');

        return redirect(route('organizacaos.index'));
    }

    /**
     * Display the specified Organizacao.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $organizacao = $this->organizacaoRepository->findWithoutFail($id);

        if (empty($organizacao)) {
            Flash::error('Organizacao not found');

            return redirect(route('organizacaos.index'));
        }

        return view('organizacaos.show')->with('organizacao', $organizacao);
    }

    /**
     * Show the form for editing the specified Organizacao.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $organizacao = $this->organizacaoRepository->findWithoutFail($id);

        if (empty($organizacao)) {
            Flash::error('Organizacao not found');

            return redirect(route('organizacaos.index'));
        }

        return view('organizacaos.edit')->with('organizacao', $organizacao);
    }

    /**
     * Update the specified Organizacao in storage.
     *
     * @param  int              $id
     * @param UpdateOrganizacaoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOrganizacaoRequest $request)
    {
        $organizacao = $this->organizacaoRepository->findWithoutFail($id);

        if (empty($organizacao)) {
            Flash::error('Organizacao not found');

            return redirect(route('organizacaos.index'));
        }

        $organizacao = $this->organizacaoRepository->update($request->all(), $id);

        Flash::success('Organizacao updated successfully.');

        return redirect(route('organizacaos.index'));
    }

    /**
     * Remove the specified Organizacao from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $organizacao = $this->organizacaoRepository->findWithoutFail($id);

        if (empty($organizacao)) {
            Flash::error('Organizacao not found');

            return redirect(route('organizacaos.index'));
        }

        $this->organizacaoRepository->delete($id);

        Flash::success('Organizacao deleted successfully.');

        return redirect(route('organizacaos.index'));
    }
}
