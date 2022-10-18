<?php
namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait FileAttachmentsTrait {

    //Store Files
    public static function uploadFile($image,$folder=null,$name=null)
    {
        if($image->getClientOriginalExtension() == 'pdf')
        {
            $fileName = $name.'_'.rand(10,5000).time() . '.' . $image->getClientOriginalExtension();
            $store = Storage::disk('local')->put('public/'.$folder.'/PDF'.'/'.$fileName,file_get_contents($image),'public');
        }
        else
        {
            $fileName = $name.'_'.rand(10,5000).time() . '.' . $image->getClientOriginalExtension();

            $img = Image::make($image->getRealPath());
          
            try{
                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
    
            }
            catch(Exception $e)
            {
                dd($e->getMessage());
            }

            $img->stream();
            Storage::disk('local')->put('public/'.$folder.''.'/'.$fileName, $img, 'public');
        }

        return $fileName;
    }

    //Remove Files
    public static function RemoveFile($name,$folder=null){
       
        if(!preg_match("/\.(pdf)$/", $name))
        {
            $path = ('/'.$folder.'/'.$name);
           
            if (Storage::disk('public')->exists($path))
            {
                Storage::disk('public')->delete($path);
            }
        }
        else {
            $path = ('/'.$folder.'/PDF/'.$name);
          
            if (Storage::disk('public')->exists($path))
            {
                Storage::disk('public')->delete($path);
            }
        }
    }
}
