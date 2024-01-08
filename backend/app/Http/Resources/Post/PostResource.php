<?php

namespace App\Http\Resources\Post;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        setlocale(LC_TIME, 'ru_RU.utf8'); // Устанавливаем локализацию
        return [
            'id' => $this->id,
            'title' => $this->title,
            'preview' => $this->preview,
            'text' => $this->text,
            'image' => $this->getFirstMediaUrl('images'),
            'date' => Carbon::parse($this->created_at)->locale('ru')->isoFormat('LL')
        ];
    }
}
