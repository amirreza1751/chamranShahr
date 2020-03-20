<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBookSizeRequest;
use App\Http\Requests\UpdateBookSizeRequest;
use App\Repositories\BookSizeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class BookSizeController extends AppBaseController
{
    /** @var  BookSizeRepository */
    private $bookSizeRepository;

    public function __construct(BookSizeRepository $bookSizeRepo)
    {
        $this->bookSizeRepository = $bookSizeRepo;
    }

    /**
     * Display a listing of the BookSize.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->bookSizeRepository->pushCriteria(new RequestCriteria($request));
        $bookSizes = $this->bookSizeRepository->all();

        return view('book_sizes.index')
            ->with('bookSizes', $bookSizes);
    }

    /**
     * Show the form for creating a new BookSize.
     *
     * @return Response
     */
    public function create()
    {
        return view('book_sizes.create');
    }

    /**
     * Store a newly created BookSize in storage.
     *
     * @param CreateBookSizeRequest $request
     *
     * @return Response
     */
    public function store(CreateBookSizeRequest $request)
    {
        $input = $request->all();

        $bookSize = $this->bookSizeRepository->create($input);

        Flash::success('Book Size saved successfully.');

        return redirect(route('bookSizes.index'));
    }

    /**
     * Display the specified BookSize.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $bookSize = $this->bookSizeRepository->findWithoutFail($id);

        if (empty($bookSize)) {
            Flash::error('Book Size not found');

            return redirect(route('bookSizes.index'));
        }

        return view('book_sizes.show')->with('bookSize', $bookSize);
    }

    /**
     * Show the form for editing the specified BookSize.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $bookSize = $this->bookSizeRepository->findWithoutFail($id);

        if (empty($bookSize)) {
            Flash::error('Book Size not found');

            return redirect(route('bookSizes.index'));
        }

        return view('book_sizes.edit')->with('bookSize', $bookSize);
    }

    /**
     * Update the specified BookSize in storage.
     *
     * @param  int              $id
     * @param UpdateBookSizeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBookSizeRequest $request)
    {
        $bookSize = $this->bookSizeRepository->findWithoutFail($id);

        if (empty($bookSize)) {
            Flash::error('Book Size not found');

            return redirect(route('bookSizes.index'));
        }

        $bookSize = $this->bookSizeRepository->update($request->all(), $id);

        Flash::success('Book Size updated successfully.');

        return redirect(route('bookSizes.index'));
    }

    /**
     * Remove the specified BookSize from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $bookSize = $this->bookSizeRepository->findWithoutFail($id);

        if (empty($bookSize)) {
            Flash::error('Book Size not found');

            return redirect(route('bookSizes.index'));
        }

        $this->bookSizeRepository->delete($id);

        Flash::success('Book Size deleted successfully.');

        return redirect(route('bookSizes.index'));
    }
}
