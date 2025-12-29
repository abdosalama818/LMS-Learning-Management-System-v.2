<?php

namespace App\Repository;


use App\Models\InfoBox;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class InfoRepository
{




    public function storeInfo($request)
    {

            InfoBox::create([
            'title' => $request->input('title'),
            'icon' => $request->input('icon'),
            'description' => $request->input('video_url'),
        ]);
    }

    public function updateInfo($request, $id)
    {

       

        InfoBox::updateOrCreate(['id'=>$id],[
            'title' => $request->input('title'),
            'icon' => $request->input('icon'),
            'description' => $request->input('description'),
        ]);
    }


    public function deleteInfo($id)
    {
        $InfoBox = InfoBox::find($id);
       
        $InfoBox->delete();
    }


}
