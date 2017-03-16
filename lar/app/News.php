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
    public static function getSlug($title, $id = null)
    {
        $slug = (new \Slug())->make($title);
        $patt = '/\d+$/';
        $slret = preg_replace($patt, '', $slug);
        if (strlen($slret) == 0) $slret = $slug;
        $dop = '';
        if (isset($id)) $dop = ' and id != ' . $id;
        $slugs = self::select('slug')->whereRaw('slug like \'' . $slret . '%\'' . $dop)->get()->toArray();
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

    public function setPublicAttribute($value)
    {
        $pub = 0;
        if ($value || $value == 'true') $pub = 1;
        $this->attributes['public'] = $pub;
    }
}
