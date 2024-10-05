<?php

namespace App\Trait;
use Illuminate\Support\Facades\File;

trait MediaTrait
{
    final public function image ($image,$folder,$oldImage=null){
        // delete old image
        if ($oldImage && File::exists(storage_path('app/public/' . $oldImage))) {
            File::delete(storage_path('app/public/' . $oldImage));
        }

        $rand= rand(999999, 1000000);
        $imageName = time().'_'.$rand. '.' . $image->getClientOriginalExtension();
            $image->move(storage_path('app/public/'.$folder),$imageName);
            return $folder.'/'.$imageName;

    }

    final public function uploadMultiImages($images,$folder,$oldImages= null){
        // delete oldImages if exists
        if ($oldImages) {
            foreach ($oldImages as $oldImage){
                if(File::exists(storage_path('app/public/' . $oldImage))){
                    File::delete(storage_path('app/public/' . $oldImage));
                }
            }
        }
        $files  = [];
        foreach ($images as $image){
            $rand= rand(999999, 1000000);
            $imageName = time().'_'.$rand. '.' . $image->getClientOriginalExtension();
                $image->move(storage_path('app/public/'.$folder),$imageName);
                $files[] = $folder.'/'.$imageName;
        }
        return $files;
    }

    final public function deleteMulti($oldFiles = null){
        // delete oldImages if exists
        if ($oldFiles) {
            foreach ($oldFiles as $oldImage){
                if(File::exists(storage_path('app/public/' . $oldImage))){
                    File::delete(storage_path('app/public/' . $oldImage));
                }
            }
        }

    }


    final public function deleteFile($oldImage=null){
        if ($oldImage && File::exists(storage_path('app/public/' . $oldImage))) {
            File::delete(storage_path('app/public/' . $oldImage));
        }
    }

}
