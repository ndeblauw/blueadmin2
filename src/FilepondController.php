<?php

namespace Ndeblauw\BlueAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// to check below
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FilepondController extends Controller
{
    private $filepond;

    public function __construct(Filepond $filepond)
    {
        $this->filepond = $filepond;
    }

    public function upload(Request $request)
    {
        ray($request);

        $input = array_reverse($request->allFiles());
        $file = array_pop($input);

        $file = is_array($file) ? $file[0] : $file;

        if ($file === null) {
            return Response::make(config('filepond.input_name') . ' is required', 422, [
                'Content-Type' => 'text/plain',
            ]);
        }

        $path = config('filepond.temporary_files_path', 'filepond');
        $disk = config('filepond.temporary_files_disk', 'local');

        if (!($newFile = $file->storeAs($path . DIRECTORY_SEPARATOR . Str::random(), $file->getClientOriginalName(), $disk))) {
            return Response::make('Could not save file', 500, [
                'Content-Type' => 'text/plain',
            ]);
        }

        return Response::make($this->filepond->getServerIdFromPath(Storage::disk($disk)->path($newFile)), 200, [
            'Content-Type' => 'text/plain',
        ]);
    }

    /**
     * Takes the given encrypted filepath and deletes
     * it if it hasn't been tampered with
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function delete(Request $request)
    {
        $filePath = $this->filepond->getPathFromServerId($request->getContent());
        if (Storage::disk(config('filepond.temporary_files_disk', 'local'))->delete($filePath)) {
            return Response::make('', 200, [
                'Content-Type' => 'text/plain',
            ]);
        }

        return Response::make('', 500, [
            'Content-Type' => 'text/plain',
        ]);
    }
}