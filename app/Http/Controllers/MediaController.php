<?php

namespace App\Http\Controllers;

use App\Enums\MediaType;
use App\Http\Requests\CreateMediaRequest;
use App\Http\Requests\UpdateMediaRequest;
use App\Models\Location;
use App\Models\News;
use App\Repositories\MediaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class MediaController extends AppBaseController
{
    /** @var  MediaRepository */
    private $mediaRepository;

    public function __construct(MediaRepository $mediaRepo)
    {
        $this->mediaRepository = $mediaRepo;
    }

    /**
     * Display a listing of the Media.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->mediaRepository->pushCriteria(new RequestCriteria($request));
        $media = $this->mediaRepository->all();

        return view('media.index')
            ->with('media', $media);
    }

    /**
     * Show the form for creating a new Media.
     *
     * @return Response
     */
    public function create()
    {
        $owners = [
            Location::class => 'location',
            News::class => 'news',
        ];
//        foreach (MediaType::toArray() as $type){
//            $mediaType[$type] = $type;
//        }
        return view('media.create', compact('owners', 'mediaType'));
    }

    /**
     * Store a newly created Media in storage.
     *
     * @param CreateMediaRequest $request
     *
     * @return Response
     */
    public function store(CreateMediaRequest $request)
    {
        $input = $request->all();
        if($request->hasFile('path')){
            $path = $request->file('path')->store('/public/images');
            $path = str_replace('public', 'storage', $path);
        }
        $input['path'] = $path;

        $media = $this->mediaRepository->create($input);

        Flash::success('Media saved successfully.');

        return redirect(route('media.index'));
    }

    /**
     * Display the specified Media.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $media = $this->mediaRepository->findWithoutFail($id);

        if (empty($media)) {
            Flash::error('Media not found');

            return redirect(route('media.index'));
        }

        return view('media.show')->with('media', $media);
    }

    /**
     * Show the form for editing the specified Media.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $owners = [
            Location::class => 'location',
            News::class => 'news',
        ];

        $media = $this->mediaRepository->findWithoutFail($id);

        if (empty($media)) {
            Flash::error('Media not found');

            return redirect(route('media.index'));
        }

        return view('media.edit', compact('media', 'owners'));
    }

    /**
     * Update the specified Media in storage.
     *
     * @param  int              $id
     * @param UpdateMediaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMediaRequest $request)
    {
        $media = $this->mediaRepository->findWithoutFail($id);
        $new_request = $request->all();
        if (empty($media)) {
            Flash::error('Media not found');

            return redirect(route('media.index'));
        }

        if($request->hasFile('path')){
            $path = $request->file('path')->store('/public/images');
            $path = str_replace('public', 'storage', $path);
            $new_request['path'] = $path;
        }
        else{
            $new_request['path'] = $media->path;
        }

        $media = $this->mediaRepository->update($new_request, $id);

        Flash::success('Media updated successfully.');

        return redirect(route('media.index'));
    }

    /**
     * Remove the specified Media from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $media = $this->mediaRepository->findWithoutFail($id);

        if (empty($media)) {
            Flash::error('Media not found');

            return redirect(route('media.index'));
        }

        $this->mediaRepository->delete($id);

        Flash::success('Media deleted successfully.');

        return redirect(route('media.index'));
    }
}
