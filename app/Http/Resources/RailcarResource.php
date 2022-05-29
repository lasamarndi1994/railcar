<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RailcarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'display_name' => $this->name,

            'area' => $this->area,
            'display_area' => ucwords(str_replace("_"," ",$this->area)),

            'arrival_date' => $this->dateTimeFormat($this->arrival_date),
            'due_date'=> $this->dateTimeFormat($this->due_date),

            'display_arrival_date' => $this->currentDateTimeFormat($this->arrival_date),
            'display_due_date'=> $this->currentDateTimeFormat($this->due_date),

            'status' => $this->status,
            'display_status' => ucfirst($this->status),
        ];
    }
    /**
     * dateTimeFormat
     *
     * @param  mixed $date_time
     * @return void
     */
    private function dateTimeFormat($date_time){
      $date_year = date("Y-m-d", strtotime($date_time));
      $time = date("H:i", strtotime($date_time));
      return  $date_year.'T'.$time;

    }

    /**
     * currentDateTimeFormat
     *
     * @param  mixed $date_time
     * @return void
     */
    private function currentDateTimeFormat($date_time){
        return date("Y-m-d H:i", strtotime($date_time));
    }
}
