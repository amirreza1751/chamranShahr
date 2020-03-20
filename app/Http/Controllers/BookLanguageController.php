<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBookLanguageRequest;
use App\Http\Requests\UpdateBookLanguageRequest;
use App\Repositories\BookLanguageRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class BookLanguageController extends AppBaseController
{
    /** @var  BookLanguageRepository */
    private $bookLanguageRepository;

    public function __construct(BookLanguageRepository $bookLanguageRepo)
    {
        $this->bookLanguageRepository = $bookLanguageRepo;
    }

    /**
     * Display a listing of the BookLanguage.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->bookLanguageRepository->pushCriteria(new RequestCriteria($request));
        $bookLanguages = $this->bookLanguageRepository->all();

        return view('book_languages.index')
            ->with('bookLanguages', $bookLanguages);
    }

    /**
     * Show the form for creating a new BookLanguage.
     *
     * @return Response
     */
    public function create()
    {
        return view('book_languages.create');
    }

    /**
     * Store a newly created BookLanguage in storage.
     *
     * @param CreateBookLanguageRequest $request
     *
     * @return Response
     */
    public function store(CreateBookLanguageRequest $request)
    {
        $input = $request->all();

        $bookLanguage = $this->bookLanguageRepository->create($input);

        Flash::success('Book Language saved successfully.');

        return redirect(route('bookLanguages.index'));
    }

    /**
     * Display the specified BookLanguage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $bookLanguage = $this->bookLanguageRepository->findWithoutFail($id);

        if (empty($bookLanguage)) {
            Flash::error('Book Language not found');

            return redirect(route('bookLanguages.index'));
        }

        return view('book_languages.show')->with('bookLanguage', $bookLanguage);
    }

    /**
     * Show the form for editing the specified BookLanguage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $bookLanguage = $this->bookLanguageRepository->findWithoutFail($id);

        if (empty($bookLanguage)) {
            Flash::error('Book Language not found');

            return redirect(route('bookLanguages.index'));
        }

        return view('book_languages.edit')->with('bookLanguage', $bookLanguage);
    }

    /**
     * Update the specified BookLanguage in storage.
     *
     * @param  int              $id
     * @param UpdateBookLanguageRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBookLanguageRequest $request)
    {
        $bookLanguage = $this->bookLanguageRepository->findWithoutFail($id);

        if (empty($bookLanguage)) {
            Flash::error('Book Language not found');

            return redirect(route('bookLanguages.index'));
        }

        $bookLanguage = $this->bookLanguageRepository->update($request->all(), $id);

        Flash::success('Book Language updated successfully.');

        return redirect(route('bookLanguages.index'));
    }

    /**
     * Remove the specified BookLanguage from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $bookLanguage = $this->bookLanguageRepository->findWithoutFail($id);

        if (empty($bookLanguage)) {
            Flash::error('Book Language not found');

            return redirect(route('bookLanguages.index'));
        }

        $this->bookLanguageRepository->delete($id);

        Flash::success('Book Language deleted successfully.');

        return redirect(route('bookLanguages.index'));
    }
}
