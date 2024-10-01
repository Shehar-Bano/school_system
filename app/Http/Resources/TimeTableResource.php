<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TimeTableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'day' => $this->day,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'slot_status' => $this->slot_status,
            'class_name' => $this->class->name,
            'section_name'=>$this->section->name,
            'subject_name'=>$this->subject->subject_name,
            'teacher_name'=>$this->teacher->name,

        ];
    }
}

