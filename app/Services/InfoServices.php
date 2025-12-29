<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repository\InfoRepository;

class InfoServices
{
   public $InfoRepository;
    public function __construct(InfoRepository $InfoRepository)
    {
         $this->InfoRepository = $InfoRepository;
    }

    public function storeInfo( $request){
        return $this->InfoRepository->storeInfo($request);
    }

    public function updateInfo($request, $id){
        $Infoy = $this->InfoRepository->updateInfo($request, $id);
        return $Infoy;
    }

    public function deleteInfo($id){
        return $this->InfoRepository->deleteInfo($id);
    }




}
