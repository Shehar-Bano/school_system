<?php


namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ReportResource extends JsonResource
{
   public function toArray($request){
    return [
        'category' => $this->category->name,
        'total_amount' => $this->total_amount,
    ];
   }
}
