<?php
namespace App\Http\Resources;
 
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
 
class UserResource extends JsonResource
{
    /**
     * Indicates if the resource's collection keys should be preserved.
     *
     * @var bool
     */
    public $preserveKeys = true;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //var_dump($request);
        return [
            '@context' => "http://schema.org/",
            "@type" => "Person",
            "jobTitle" => "Professor",
            "url" => env('APP_URL')."/api/user/".$this->id,
            'id' => $this->id,
            'name' => is_null($this->name)?'':$this->name,
            'email' => $this->email,
            'apellido1'=>is_null($this->apellido1)?'':$this->apellido1,
            'apellido2'=>is_null($this->apellido2)?'':$this->apellido2,
            'telephone'=>is_null($this->phone)?'':$this->phone,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'avatar'=>$this->avatar
        ];
    }
}