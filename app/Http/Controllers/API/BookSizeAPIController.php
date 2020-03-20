<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateBookSizeAPIRequest;
use App\Http\Requests\API\UpdateBookSizeAPIRequest;
use App\Models\BookSize;
use App\Repositories\BookSizeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class BookSizeController
 * @package App\Http\Controllers\API
 */

class BookSizeAPIController extends AppBaseController
{
    /** @var  BookSizeRepository */
    private $bookSizeRepository;

    public function __construct(BookSizeRepository $bookSizeRepo)
    {
        $this->bookSizeRepository = $bookSizeRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/bookSizes",
     *      summary="Get a listing of the BookSizes.",
     *      tags={"BookSize"},
     *      description="Get all BookSizes",
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
     *                  @SWG\Items(ref="#/definitions/BookSize")
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
        $this->bookSizeRepository->pushCriteria(new RequestCriteria($request));
        $this->bookSizeRepository->pushCriteria(new LimitOffsetCriteria($request));
        $bookSizes = $this->bookSizeRepository->all();

        return $this->sendResponse($bookSizes->toArray(), 'Book Sizes retrieved successfully');
    }

    /**
     * @param CreateBookSizeAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/bookSizes",
     *      summary="Store a newly created BookSize in storage",
     *      tags={"BookSize"},
     *      description="Store BookSize",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="BookSize that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/BookSize")
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
     *                  ref="#/definitions/BookSize"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateBookSizeAPIRequest $request)
    {
        $input = $request->all();

        $bookSize = $this->bookSizeRepository->create($input);

        return $this->sendResponse($bookSize->toArray(), 'Book Size saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/bookSizes/{id}",
     *      summary="Display the specified BookSize",
     *      tags={"BookSize"},
     *      description="Get BookSize",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of BookSize",
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
     *                  ref="#/definitions/BookSize"
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
        /** @var BookSize $bookSize */
        $bookSize = $this->bookSizeRepository->findWithoutFail($id);

        if (empty($bookSize)) {
            return $this->sendError('Book Size not found');
        }

        return $this->sendResponse($bookSize->toArray(), 'Book Size retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateBookSizeAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/bookSizes/{id}",
     *      summary="Update the specified BookSize in storage",
     *      tags={"BookSize"},
     *      description="Update BookSize",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of BookSize",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="BookSize that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/BookSize")
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
     *                  ref="#/definitions/BookSize"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateBookSizeAPIRequest $request)
    {
        $input = $request->all();

        /** @var BookSize $bookSize */
        $bookSize = $this->bookSizeRepository->findWithoutFail($id);

        if (empty($bookSize)) {
            return $this->sendError('Book Size not found');
        }

        $bookSize = $this->bookSizeRepository->update($input, $id);

        return $this->sendResponse($bookSize->toArray(), 'BookSize updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/bookSizes/{id}",
     *      summary="Remove the specified BookSize from storage",
     *      tags={"BookSize"},
     *      description="Delete BookSize",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of BookSize",
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
        /** @var BookSize $bookSize */
        $bookSize = $this->bookSizeRepository->findWithoutFail($id);

        if (empty($bookSize)) {
            return $this->sendError('Book Size not found');
        }

        $bookSize->delete();

        return $this->sendSuccess('Book Size deleted successfully');
    }
}
