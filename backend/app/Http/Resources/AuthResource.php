<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'access_token' => $this->resource['access_token'],
            'token_type' => $this->resource['token_type'],
            'expires_at' => $this->resource['expires_at'],
        ];

        if (isset($this->resource['user'])) {
            $data['user'] = new UserResource($this->resource['user']);
        }

        return $data;
    }
}

