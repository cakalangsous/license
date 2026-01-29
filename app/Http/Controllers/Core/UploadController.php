<?php

namespace App\Http\Controllers\Core;

use App\Actions\Core\Upload\DeleteFile;
use App\Actions\Core\Upload\ListFiles;
use App\Actions\Core\Upload\TempDelete;
use App\Actions\Core\Upload\TempUpload;
use App\Actions\Core\Upload\UploadFile;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UploadController extends Controller
{
    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'file|mimes:png,jpg,jpeg',
        ]);

        $link = (new UploadFile)->execute($request->file('file'));

        return response()->json([
            'success' => true,
            'message' => 'Upload success',
            'link' => $link,
        ]);
    }

    public function delete(Request $request): JsonResponse
    {
        $request->validate([
            'src' => 'required',
            'data-url' => 'required',
        ]);

        $deleted = (new DeleteFile)->execute($request->src);

        if (! $deleted) {
            return response()->json(['success' => false, 'message' => 'File not exists.']);
        }

        return response()->json(['status' => true, 'message' => 'File deleted']);
    }

    public function list(): JsonResponse
    {
        $images = (new ListFiles)->execute();

        return response()->json($images);
    }

    public function temp_upload(Request $request): Response
    {
        if (! $request->hasFile('filepond')) {
            return response('Unknown request', 404);
        }

        $allowedTypes = urldecode($request->input('allowed_types', 'png,jpg,jpeg,gif,webp'));
        $maxSize = $request->input('max_size', 5120);

        $request->validate([
            'filepond' => "required|file|mimes:{$allowedTypes}|max:{$maxSize}",
        ]);

        $folder = (new TempUpload)->execute($request->file('filepond'));

        return response($folder, 200)->header('Content-Type', 'text/plain');
    }

    public function temp_delete(Request $request): bool
    {
        return (new TempDelete)->execute($request->getContent());
    }

    public function getUploaded(Request $request): JsonResponse
    {
        $request->validate([
            'load' => 'required',
        ]);

        return response()->json([
            'filename' => asset('storage/'.$request->load),
        ]);
    }
}
