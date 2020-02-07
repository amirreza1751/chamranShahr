<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTermAPIRequest;
use App\Http\Requests\API\UpdateTermAPIRequest;
use App\Models\Term;
use App\Repositories\TermRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class TermController
 * @package App\Http\Controllers\API
 */

class TermAPIController extends AppBaseController
{
    /** @var  TermRepository */
    private $termRepository;

    public function __construct(TermRepository $termRepo)
    {
        $this->termRepository = $termRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/terms",
     *      summary="Get a listing of the Terms.",
     *      tags={"Term"},
     *      description="Get all Terms",
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
     *                  @SWG\Items(ref="#/definitions/Term")
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
        $this->termRepository->pushCriteria(new RequestCriteria($request));
        $this->termRepository->pushCriteria(new LimitOffsetCriteria($request));
        $terms = $this->termRepository->all();

        return $this->sendResponse($terms->toArray(), 'Terms retrieved successfully');
    }

    /**
     * @param CreateTermAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/terms",
     *      summary="Store a newly created Term in storage",
     *      tags={"Term"},
     *      description="Store Term",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Term that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Term")
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
     *                  ref="#/definitions/Term"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateTermAPIRequest $request)
    {
        $input = $request->all();

        $term = $this->termRepository->create($input);

        return $this->sendResponse($term->toArray(), 'Term saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/terms/{id}",
     *      summary="Display the specified Term",
     *      tags={"Term"},
     *      description="Get Term",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Term",
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
     *                  ref="#/definitions/Term"
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
        /** @var Term $term */
        $term = $this->termRepository->findWithoutFail($id);

        if (empty($term)) {
            return $this->sendError('Term not found');
        }

        return $this->sendResponse($term->toArray(), 'Term retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateTermAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/terms/{id}",
     *      summary="Update the specified Term in storage",
     *      tags={"Term"},
     *      description="Update Term",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Term",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Term that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Term")
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
     *                  ref="#/definitions/Term"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateTermAPIRequest $request)
    {
        $input = $request->all();

        /** @var Term $term */
        $term = $this->termRepository->findWithoutFail($id);

        if (empty($term)) {
            return $this->sendError('Term not found');
        }

        $term = $this->termRepository->update($input, $id);

        return $this->sendResponse($term->toArray(), 'Term updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/terms/{id}",
     *      summary="Remove the specified Term from storage",
     *      tags={"Term"},
     *      description="Delete Term",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Term",
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
        /** @var Term $term */
        $term = $this->termRepository->findWithoutFail($id);

        if (empty($term)) {
            return $this->sendError('Term not found');
        }

        $term->delete();

        return $this->sendResponse($id, 'Term deleted successfully');
    }
}
