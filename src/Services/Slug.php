<?php

namespace App\Services;

use Symfony\Component\String\Slugger\AsciiSlugger;

class Slug
{
    public function slugify(string $string): string
    {
        $slugger = new AsciiSlugger();
        $slug = $slugger->slug(strtolower($string));

        return $slug;
    }
}
