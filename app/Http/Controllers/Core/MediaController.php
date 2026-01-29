<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use Inertia\Response;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends CoreController
{
    public function __construct()
    {
        $this->data['parent_menu'] = 'system';
        $this->data['active_menu'] = 'media';
        $this->data['title'] = 'Media Library';
    }

    public function index(): Response
    {
        abort_if(! auth()->user()->can('media_view'), 403);

        $media = Media::latest()->paginate(24);

        $media->through(function ($item) {
            $item->append('original_url');

            return $item;
        });

        $this->data['media'] = $media;

        return $this->inertia('Core/Media/Index', $this->data);
    }

    public function store(Request $request)
    {
        abort_if(! auth()->user()->can('media_create'), 403);

        $request->validate([
            'filepond' => 'required|string',
        ]);

        // Handle filepond temp upload
        $folder = $request->filepond;

        $tempPath = storage_path('app/temp/'.$folder);
        if (! is_dir($tempPath)) {
            $tempPath = storage_path('app/public/temp/'.$folder);
        }

        $files = glob($tempPath.'/*');
        if (empty($files)) {
            return back()->with(['success' => false, 'message' => 'File not found']);
        }

        $filePath = $files[0];

        // Attach to user
        auth()->user()
            ->addMedia($filePath)
            ->toMediaCollection('library');

        return back()->with(['success' => true, 'message' => 'Media uploaded successfully!']);
    }

    public function destroy(Media $media)
    {
        abort_if(! auth()->user()->can('media_delete'), 403);

        $media->delete();

        return back()->with(['success' => true, 'message' => 'Media deleted successfully!']);
    }
}
