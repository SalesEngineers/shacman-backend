<?php

namespace App\Services;

class GalleryService
{
    public function listForSelect()
    {
        return \App\Models\Gallery::all()->pluck('name', 'id');
    }
}