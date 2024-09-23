<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use League\Flysystem\Visibility;

class StartupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return[
            'id' => $this -> id,
            'title' => $this ->tittle,
            'description' => $this ->description,
            'funding_stage' => $this ->funding_stage,
            'team_members' => $this ->team_members,
            'pitch_deck_url' => $this ->pitch_deck_url,
            'business_plan_url' => $this ->business_plan_url,
            'current_amount' => $this ->current_amount,
            'goal_amount' => $this ->goal_amount,
            'category' => $this ->category,
            'visibility' => $this -> Visibility,
            'status' => $this ->status,
        ];
    }
}
