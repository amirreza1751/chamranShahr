<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateFacultyAPIRequest;
use App\Http\Requests\API\UpdateFacultyAPIRequest;
use App\Models\Faculty;
use App\Repositories\FacultyRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class FacultyController
 * @package App\Http\Controllers\API
 */

class FacultyAPIController extends AppBaseController
{
    /** @var  FacultyRepository */
    private $facultyRepository;

    public function __construct(FacultyRepository $facultyRepo)
    {
        $this->facultyRepository = $facultyRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/faculties",
     *      summary="Get a listing of the Faculties.",
     *      tags={"Faculty"},
     *      description="Get all Faculties",
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
     *                  @SWG\Items(ref="#/definitions/Faculty")
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
        $this->facultyRepository->pushCriteria(new RequestCriteria($request));
        $this->facultyRepository->pushCriteria(new LimitOffsetCriteria($request));
        $faculties = $this->facultyRepository->all();

        return $this->sendResponse($faculties->toArray(), 'Faculties retrieved successfully');
    }

    /**
     * @param CreateFacultyAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/faculties",
     *      summary="Store a newly created Faculty in storage",
     *      tags={"Faculty"},
     *      description="Store Faculty",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Faculty that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Faculty")
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
     *                  ref="#/definitions/Faculty"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateFacultyAPIRequest $request)
    {
        $input = $request->all();

        $faculty = $this->facultyRepository->create($input);

        return $this->sendResponse($faculty->toArray(), 'Faculty saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/faculties/{id}",
     *      summary="Display the specified Faculty",
     *      tags={"Faculty"},
     *      description="Get Faculty",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Faculty",
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
     *                  ref="#/definitions/Faculty"
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
        /** @var Faculty $faculty */
        $faculty = $this->facultyRepository->findWithoutFail($id);

        if (empty($faculty)) {
            return $this->sendError('Faculty not found');
        }

        return $this->sendResponse($faculty->toArray(), 'Faculty retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateFacultyAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/faculties/{id}",
     *      summary="Update the specified Faculty in storage",
     *      tags={"Faculty"},
     *      description="Update Faculty",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Faculty",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Faculty that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Faculty")
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
     *                  ref="#/definitions/Faculty"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateFacultyAPIRequest $request)
    {
        $input = $request->all();

        /** @var Faculty $faculty */
        $faculty = $this->facultyRepository->findWithoutFail($id);

        if (empty($faculty)) {
            return $this->sendError('Faculty not found');
        }

        $faculty = $this->facultyRepository->update($input, $id);

        return $this->sendResponse($faculty->toArray(), 'Faculty updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/faculties/{id}",
     *      summary="Remove the specified Faculty from storage",
     *      tags={"Faculty"},
     *      description="Delete Faculty",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Faculty",
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
        /** @var Faculty $faculty */
        $faculty = $this->facultyRepository->findWithoutFail($id);

        if (empty($faculty)) {
            return $this->sendError('Faculty not found');
        }

        $faculty->delete();

        return $this->sendResponse($id, 'Faculty deleted successfully');
    }
}
