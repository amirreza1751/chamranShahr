<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateBookEditionAPIRequest;
use App\Http\Requests\API\UpdateBookEditionAPIRequest;
use App\Models\BookEdition;
use App\Repositories\BookEditionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class BookEditionController
 * @package App\Http\Controllers\API
 */

class BookEditionAPIController extends AppBaseController
{
    /** @var  BookEditionRepository */
    private $bookEditionRepository;

    public function __construct(BookEditionRepository $bookEditionRepo)
    {
        $this->bookEditionRepository = $bookEditionRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/bookEditions",
     *      summary="Get a listing of the BookEditions.",
     *      tags={"BookEdition"},
     *      description="Get all BookEditions",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/BookEdition")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $this->bookEditionRepository->pushCriteria(new RequestCriteria($request));
        $this->bookEditionRepository->pushCriteria(new LimitOffsetCriteria($request));
        $bookEditions = $this->bookEditionRepository->all();

        return $this->sendResponse($bookEditions->toArray(), 'Book Editions retrieved successfully');
    }

    /**
     * @param CreateBookEditionAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/bookEditions",
     *      summary="Store a newly created BookEdition in storage",
     *      tags={"BookEdition"},
     *      description="Store BookEdition",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="BookEdition that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/BookEdition")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/BookEdition"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateBookEditionAPIRequest $request)
    {
        $input = $request->all();

        $bookEdition = $this->bookEditionRepository->create($input);

        return $this->sendResponse($bookEdition->toArray(), 'Book Edition saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/bookEditions/{id}",
     *      summary="Display the specified BookEdition",
     *      tags={"BookEdition"},
     *      description="Get BookEdition",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of BookEdition",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/BookEdition"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var BookEdition $bookEdition */
        $bookEdition = $this->bookEditionRepository->findWithoutFail($id);

        if (empty($bookEdition)) {
            return $this->sendError('Book Edition not found');
        }

        return $this->sendResponse($bookEdition->toArray(), 'Book Edition retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateBookEditionAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/bookEditions/{id}",
     *      summary="Update the specified BookEdition in storage",
     *      tags={"BookEdition"},
     *      description="Update BookEdition",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of BookEdition",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="BookEdition that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/BookEdition")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/BookEdition"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateBookEditionAPIRequest $request)
    {
        $input = $request->all();

        /** @var BookEdition $bookEdition */
        $bookEdition = $this->bookEditionRepository->findWithoutFail($id);

        if (empty($bookEdition)) {
            return $this->sendError('Book Edition not found');
        }

        $bookEdition = $this->bookEditionRepository->update($input, $id);

        return $this->sendResponse($bookEdition->toArray(), 'BookEdition updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/bookEditions/{id}",
     *      summary="Remove the specified BookEdition from storage",
     *      tags={"BookEdition"},
     *      description="Delete BookEdition",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of BookEdition",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var BookEdition $bookEdition */
        $bookEdition = $this->bookEditionRepository->findWithoutFail($id);

        if (empty($bookEdition)) {
            return $this->sendError('Book Edition not found');
        }

        $bookEdition->delete();

        return $this->sendSuccess('Book Edition deleted successfully');
    }
}
