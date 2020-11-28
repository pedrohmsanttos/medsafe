<?php

namespace App\Services;
use App\Services\Upload\StorageServiceInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class StorageService implements StorageServiceInterface
{
    protected $storage;
    protected $disk;
	public function __construct(Storage $storage)
	{
        $this->storage = $storage;
        $this->disk    = env('FILESYSTEM_DRIVER','local');
	}
    function put($file, $filetype, $filename, $state = 'public')
    {
		$temp     = tmpfile();        
		fwrite($temp, $file);     
		$path     = stream_get_meta_data($temp)['uri'];
        $runTask  = new File($path);
        
        try{
            $cloud = $this->storage::disk($this->disk); 
            $cloud->putFileAs($filename, $runTask, $arquivo);
            $cloud->setVisibility($filename, $state);
            $url = $cloud->url($filename);
            fclose($temp);    
        }catch(message $e){
            
        }
        
        return $url;
    }
    function download($file, $filetype, $filename)
    {
    }
    function delete($file, $filetype, $filename)
    {
    }
}