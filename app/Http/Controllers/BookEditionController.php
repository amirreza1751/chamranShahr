<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBookEditionRequest;
use App\Http\Requests\UpdateBookEditionRequest;
use App\Repositories\BookEditionRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class BookEditionController extends AppBaseController
{
    /** @var  BookEditionRepository */
    private $bookEditionRepository;

    public function __construct(BookEditionRepository $bookEditionRepo)
    {
        $this->bookEditionRepository = $bookEditionRepo;
    }

    /**
     * Display a listing of the BookEdition.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->bookEditionRepository->pushCriteria(new RequestCriteria($request));
        $bookEditions = $this->bookEditionRepository->all();

        return view('book_editions.index')
            ->with('bookEditions', $bookEditions);
    }

    /**
     * Show the form for creating a new BookEdition.
     *
     * @return Response
     */
    public function create()
    {
        return view('book_editions.create');
    }

    /**
     * Store a newly created BookEdition in storage.
     *
     * @param CreateBookEditionRequest $request
     *
     * @return Response
     */
    public function store(CreateBookEditionRequest $request)
    {
        $input = $request->all();

        $bookEdition = $this->bookEditionRepository->create($input);

        Flash::success('Book Edition saved successfully.');

        return redirect(route('bookEditions.index'));
    }

    /**
     * Display the specified BookEdition.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $bookEdition = $this->bookEditionRepository->findWithoutFail($id);

        if (empty($bookEdition)) {
            Flash::error('Book Edition not found');

            return redirect(route('bookEditions.index'));
        }

        return view('book_editions.show')->with('bookEdition', $bookEdition);
    }

    /**
     * Show the form for editing the specified BookEdition.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $bookEdition = $this->bookEditionRepository->findWithoutFail($id);

        if (empty($bookEdition)) {
            Flash::error('Book Edition not found');

            return redirect(route('bookEditions.index'));
        }

        return view('book_editions.edit')->with('bookEdition', $bookEdition);
    }

    /**
     * Update the specified BookEdition in storage.
     *
     * @param  int              $id
     * @param UpdateBookEditionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBookEditionRequest $request)
    {
        $bookEdition = $this->bookEditionRepository->findWithoutFail($id);

        if (empty($bookEdition)) {
            Flash::error('Book Edition not found');

            return redirect(route('bookEditions.index'));
        }

        $bookEdition = $this->bookEditionRepository->update($request->all(), $id);

        Flash::success('Book Edition updated successfully.');

        return redirect(route('bookEditions.index'));
    }

    /**
     * Remove the specified BookEdition from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $bookEdition = $this->bookEditionRepository->findWithoutFail($id);

        if (empty($bookEdition)) {
            Flash::error('Book Edition not found');

            return redirect(route('bookEditions.index'));
        }

        $this->bookEditionRepository->delete($id);

        Flash::success('Book Edition deleted successfully.');

        return redirect(route('bookEditions.index'));
    }
}
