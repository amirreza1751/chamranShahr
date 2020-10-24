<?php

namespace App\Http\Controllers\API;

use App\CollectionHelper;
use App\Enums\MediaType;
use App\Http\Requests\API\CreateAdAPIRequest;
use App\Http\Requests\API\UpdateAdAPIRequest;
use App\Models\Ad;
use App\Models\Media;
use App\Repositories\AdRepository;
use App\Repositories\BookRepository;
use App\Repositories\MediaRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Monolog\Handler\IFTTTHandler;
use Morilog\Jalali\Jalalian;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * Class AdController
 * @package App\Http\Controllers\API
 */

class AdAPIController extends AppBaseController
{
    /** @var  AdRepository */
    private $adRepository;
    private $bookRepository;
    private $mediaRepository;

    public function __construct(AdRepository $adRepo, BookRepository $bookRepo, MediaRepository $mediaRepository)
    {
        $this->adRepository = $adRepo;
        $this->bookRepository = $bookRepo;
        $this->mediaRepository = $mediaRepository;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/ads",
     *      summary="Get a listing of the Ads.",
     *      tags={"Ad"},
     *      description="Get all Ads",
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
     *                  @SWG\Items(ref="#/definitions/Ad")
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
        $this->adRepository->pushCriteria(new RequestCriteria($request));
        $this->adRepository->pushCriteria(new LimitOffsetCriteria($request));
        $ads = $this->adRepository->paginate(10);

        return $this->sendResponse($ads->toArray(), 'Ads retrieved successfully');
    }

    /**
     * @param CreateAdAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/ads",
     *      summary="Store a newly created Ad in storage",
     *      tags={"Ad"},
     *      description="Store Ad",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Ad that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Ad")
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
     *                  ref="#/definitions/Ad"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateAdAPIRequest $request)
    {
        $input = $request->all();

        $ad = $this->adRepository->create($input);

        return $this->sendResponse($ad->toArray(), 'Ad saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/ads/{id}",
     *      summary="Display the specified Ad",
     *      tags={"Ad"},
     *      description="Get Ad",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Ad",
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
     *                  ref="#/definitions/Ad"
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
        /** @var Ad $ad */
        $ad = $this->adRepository->findWithoutFail($id);

        if (empty($ad)) {
            return $this->sendError('Ad not found');
        }

        return $this->sendResponse($ad->toArray(), 'Ad retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateAdAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/ads/{id}",
     *      summary="Update the specified Ad in storage",
     *      tags={"Ad"},
     *      description="Update Ad",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Ad",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Ad that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Ad")
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
     *                  ref="#/definitions/Ad"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateAdAPIRequest $request)
    {
        $input = $request->all();

        /** @var Ad $ad */
        $ad = $this->adRepository->findWithoutFail($id);

        if (empty($ad)) {
            return $this->sendError('Ad not found');
        }

        $ad = $this->adRepository->update($input, $id);

        return $this->sendResponse($ad->toArray(), 'Ad updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/ads/{id}",
     *      summary="Remove the specified Ad from storage",
     *      tags={"Ad"},
     *      description="Delete Ad",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Ad",
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
        /** @var Ad $ad */
        $ad = $this->adRepository->findWithoutFail($id);

        if (empty($ad)) {
            return $this->sendError('Ad not found');
        }

        $ad->delete();

        return $this->sendSuccess('Ad deleted successfully');
    }


    /**
     *******************************************************************************************************************
     *******************************************************************************************************************
     *************************************************** CUSTOMIZATION *************************************************
     *******************************************************************************************************************
     *******************************************************************************************************************
     */

    public function create_book_ad(Request $request){
//        $this->authorize('create_book_ad', Ad::class);

        $this->validate($request, [
            'title' => 'required',
            'offered_price' => 'required',
            'phone_number' => 'required',
            'book_title' => 'required',
            'book_length' => 'required',
//            'isbn' => 'unique:books'
            'images.*' => 'image|mimes:jpg,jpeg,png|max:512',
            'publish_month' => 'required|numeric|min:2',
            'publish_year' => 'required|numeric|min:4',
        ]);

        $book_info = [
            'title' => $request->get('book_title'),
            'edition_id' => $request->get('edition_id'),
            'publisher' => $request->get('publisher'),
            'publish_date' => Jalalian::fromFormat(
                "Y-m-d", $request->get('publish_year')."-". $request->get('publish_month') ."-01"
            )->toCarbon()->toDateString(),
            'book_length' => $request->get('book_length'),
            'language_id' => $request->get('language_id'),
            'isbn' => $request->get('isbn'),
            'author' => $request->get('author'),
            'translator' => $request->get('translator'),
            'price' => $request->get('price'),
            'size_id' => $request->get('size_id'),
            'is_grayscale' => $request->get('is_grayscale')
        ];


        $new_book = $this->bookRepository->firstOrCreate($book_info);


        $ad_info = [
            'title' => $request->get('title'),
            'english_title' => $request->get('english_title'),
            'ad_location' => $request->get('ad_location'),
            'advertisable_type' => 'App\Models\Book',
            'advertisable_id' => $new_book->id,
            'offered_price' => $request->get('offered_price'),
            'phone_number' => $request->get('phone_number'),
            'description' => $request->get('description'),
            'is_verified' => 0,
            'is_special' => 0,
            'category_id' => $request->get('category_id'),
            'ad_type_id' => $request->get('ad_type_id'),
            'creator_id' => Auth('api')->user()->id
        ];

        $new_ad = $this->adRepository->create($ad_info);

        $console = new ConsoleOutput();

        $images = array();
        $mimes = array();
        if($files=$request->file('images')){
            foreach($files as $file){
                $mimes[] = $file->getMimeType();
                $image_path = Storage::disk()->put("/public/images/ads", $file);
                $image_path = str_replace('public', '/storage', $image_path);
                $images[]=$image_path;
            }
        }
        foreach ($images as $image){
            $new_ad->medias($this->mediaRepository->create([
                "title" => "Ad Image",
                "path" => $image,
                "owner_type" => Ad::class,
                "owner_id" => $new_ad->id,
                "type" => MediaType::Img
            ]));
        }
        $new_ad['mimes'] = $mimes;
        return $this->sendResponse($new_ad->toArray(), 'Book ad created successfully.');

    }


    public function show_book_ad($id){
        /** User can view a specific advertisement. */

//        $ad = $this->adRepository->with(['adType', 'category', 'medias', 'advertisable.size', 'advertisable.language', 'advertisable.edition'])->where('id', $id)->get();
        $ad = Ad::where('id', $id)->first();

        if (empty($ad)) {
            return $this->sendError('Ad not found');
        }

//        $this->authorize('show_book_ad', $ad);

        return $this->sendResponse($ad->retrieve(), 'Ad retrieved successfully');
    }



    public function index_book_ads(Request $request){
        /** Displays all the book advertisements. */

//        $this->authorize('index_book_ads');

        $this->adRepository->pushCriteria(new RequestCriteria($request));
        $this->adRepository->pushCriteria(new LimitOffsetCriteria($request));
//        $ads = $this->adRepository->with(['advertisable', 'medias', 'category'])->where('ad_type_id', $request->get('ad_type_id'))->paginate(10);
        $ads = $this->adRepository->where('ad_type_id', $request->get('ad_type_id'))->get();

        $ads = Ad::staticRetrieves($ads);

        $pageSize = 10;

        $paginated = CollectionHelper::paginate($ads, sizeof($ads), $pageSize);

        return $this->sendResponse($paginated->toArray(), 'Ads retrieved successfully');
    }

    public function my_book_ads(Request $request){
        /** User can view a list of their advertisements which are created. */

//        $this->authorize('my_book_ads');

        $this->adRepository->pushCriteria(new RequestCriteria($request));
        $this->adRepository->pushCriteria(new LimitOffsetCriteria($request));
//        $my_book_ads = $this->adRepository->with(['advertisable', 'medias', 'category'])->where('creator_id', Auth('api')->user()->id)->paginate(10);
        $my_book_ads = $this->adRepository->where('creator_id', Auth('api')->user()->id)->get();
        $ads = Ad::staticRetrieves($my_book_ads);

        $pageSize = 10;

        $paginated = CollectionHelper::paginate($ads, sizeof($ads), $pageSize);
        return $this->sendResponse($paginated->toArray(), 'Ads retrieved successfully');
    }

    public function remove_book_ad($id){
        /** User can remove their ads. Only the ads which they create themselves. */
        $ad = $this->adRepository->findWithoutFail($id);

//        $this->authorize('remove_book_ad', $ad);

        if (empty($ad)) {
            return $this->sendError('Ad not found');
        }
        $ad->delete();
        return $this->sendResponse($ad->toArray(), 'Ad removed successfully');
    }

    public function update_book_ad($id, Request $request){

//        $this->validate($request, [
//            'book_title' => 'required',
//        ]);

        $input = $request->all();

        /** @var Ad $ad */
        $ad = $this->adRepository->findWithoutFail($id);

//        $this->authorize('update_book_ad', $ad);

        if (empty($ad)) {
            return $this->sendError('Ad not found');
        }

//        $ad = $this->adRepository->update($input, $id);

        return $this->sendResponse($ad->toArray(), 'Ad updated successfully');
    }

    public function my_ads_count(){
        if (Auth('api')->check())
        return $this->adRepository->where('creator_id', Auth('api')->user()->id)->count();
    }


}
