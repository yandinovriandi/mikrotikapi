<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TunnelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'server_id' => $this->server_id,
            'username' => $this->username,
            'password' => $this->password,
            'to_ports_api' => $this->to_ports_api,
            'to_ports_winbox' => $this->to_ports_winbox,
            'to_ports_web' => $this->to_ports_web,
        ];
    }
}
