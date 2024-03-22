<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

           return [
               'id' => $this->id,
               'name' => $this->name,
               'slug' => $this->slug,
               'username' => $this->username,
               'domain' => $this->domain,
               'password' => $this->password,
               'host' => $this->host,
               'port' => $this->port,
           ];
    }
}
