<?php

namespace App\Services\Upload;
    
    interface StorageServiceInterface
    {
        function put($file, $filetype, $filename, $state = 'public');
        // function list($empresa, $filetype);
        function download($file, $filetype, $filename);
        function delete($file, $filetype, $filename);
    }