<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';
    protected $fillable = ['title', 'slug', 'content', 'image', 'keywords', 'public'];

    /**
     * возвращает уникальный слуг
     */
    public static function getSlug($title)
    {
        $slug = (new \Slug())->make($title);
        $patt = '/\d+$/';
        $slret = preg_replace($patt, '', $slug); 
        $slugs = self::select('slug')->where('slug', 'like', $slret . '%')->get()->toArray();
        if (!empty($slugs)) {
            $arrs = [];
            foreach ($slugs as $sl) {
                preg_match($patt, $sl['slug'], $mat);
                $arrs[] = isset($mat[0]) ? $mat[0] : 0;
            }
            return $slret . (max($arrs) + 1);
        }
        return $slug;
    }
}
