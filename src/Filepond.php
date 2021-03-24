<?php

namespace Ndeblauw\BlueAdmin;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Ndeblauw\BlueAdmin\Exceptions\InvalidPathException;

class Filepond
{
    public function getServerIdFromPath($path)
    {
        return Crypt::encryptString($path);
    }

    public function getPathFromServerId($serverId)
    {
        if (! trim($serverId)) {
            throw new InvalidPathException();
        }

        $filePath = Crypt::decryptString($serverId);
        if (! Str::startsWith($filePath, $this->getBasePath())) {
            throw new InvalidPathException();
        }

        return $filePath;
    }

    public function getBasePath()
    {
        return Storage::disk(config('blueadmin.filepond_temporary_files_disk', 'local'))
            ->path(config('blueadmin.filepond_temporary_files_path', 'filepond'));
    }
}
