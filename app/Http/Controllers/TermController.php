<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTermRequest;
use App\Http\Requests\UpdateTermRequest;
use App\Repositories\TermRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class TermController extends AppBaseController
{
    /** @var  TermRepository */
    private $termRepository;

    public function __construct(TermRepository $termRepo)
    {
        $this->termRepository = $termRepo;
    }

    /**
     * Display a listing of the Term.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->termRepository->pushCriteria(new RequestCriteria($request));
        $terms = $this->termRepository->all();

        return view('terms.index')
            ->with('terms', $terms);
    }

    /**
     * Show the form for creating a new Term.
     *
     * @return Response
     */
    public function create()
    {
        return view('terms.create');
    }

    /**
     * Store a newly created Term in storage.
     *
     * @param CreateTermRequest $request
     *
     * @return Response
     */
    public function store(CreateTermRequest $request)
    {
        $input = $request->all();

        $term = $this->termRepository->create($input);

        Flash::success('Term saved successfully.');

        return redirect(route('terms.index'));
    }

    /**
     * Display the specified Term.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $term = $this->termRepository->findWithoutFail($id);

        if (empty($term)) {
            Flash::error('Term not found');

            return redirect(route('terms.index'));
        }

        return view('terms.show')->with('term', $term);
    }

    /**
     * Show the form for editing the specified Term.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $term = $this->termRepository->findWithoutFail($id);

        if (empty($term)) {
            Flash::error('Term not found');

            return redirect(route('terms.index'));
        }

        return view('terms.edit')->with('term', $term);
    }

    /**
     * Update the specified Term in storage.
     *
     * @param  int              $id
     * @param UpdateTermRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTermRequest $request)
    {
        $term = $this->termRepository->findWithoutFail($id);

        if (empty($term)) {
            Flash::error('Term not found');

            return redirect(route('terms.index'));
        }

        $term = $this->termRepository->update($request->all(), $id);

        Flash::success('Term updated successfully.');

        return redirect(route('terms.index'));
    }

    /**
     * Remove the specified Term from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $term = $this->termRepository->findWithoutFail($id);

        if (empty($term)) {
            Flash::error('Term not found');

            return redirect(route('terms.index'));
        }

        $this->termRepository->delete($id);

        Flash::success('Term deleted successfully.');

        return redirect(route('terms.index'));
    }
}
