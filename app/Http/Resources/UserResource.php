<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\Pure;

class UserResource extends JsonResource
{
    // Optionally pass a token to the resource
    protected string $token;

    #[Pure] public function __construct($resource, string $token)
    {
        // Ensure you call the parent constructor
        parent::__construct($resource);
        $this->token = $token;
    }

    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        return [
            'token'      => $this->token,
            'user'       => [
                'id'         => $this->id,
                'name'       => $this->name,
                'username'   => $this->username,
                'company_id' => $this->company_id,
                'role'      => $this->roles[0]->name,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
        ];
    }
}
