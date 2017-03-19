<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\User;

class NewsController extends Controller
{

    private function parseKeywords($keys)
    {
        if (strlen($keys) > 0) {
            return preg_split('/(,\s*|;\s*|\s)/', $keys);
        }
        return '';
    }

    /**
     * подготовка новости для вывода
     */
    private function performNews($news)
    {
        foreach ($news as $key => $value) {
            $value->keywords = $this->parseKeywords($value->keywords);
            $value->content = str_limit(preg_replace('(\<(\/?[^>]+)>)', '', $value->content), 200);
        }
        return $news;        
    }

    /**
     * возвращает список новостей
     */
    public function getList() 
    {
        $news = News::where('public', '=', 1)->orderBy('created_at', 'desc')->paginate(10);
        return $this->performNews($news);
    }
    /**
     * возвращает список новостей со скрытыми новостями
     */
    public function getListWithHidden()
    {
        $news = News::orderBy('created_at', 'desc')->paginate(10);
        return $this->performNews($news);
    }

    /**
     * возвращает новость по id
     */
    public function getItem($id)
    {
        $item = News::find($id);
        $is_edit = request('edit', 0);
        if ($is_edit) {
            $item->views = $item->views + 1;
            $item->save();
            $item->keywords = $this->parseKeywords($item->keywords);
        }
        return $item;
    }

    /**
     * удаляет новость по id
     */
    public function remove($id)
    {
        try {
            $news = News::find($id);
            $news->delete();
            return response()->json(['removed' => $id], 200);
        } catch (\Exception $exc) {
            return response()->json(['error' => $exc->getMessage()], 500);
        }
    }

    /**
     * добавление новости
     */
    public function add()
    {
        $this->validate(request(), [
            'title' => 'required',
            'content' => 'required'
        ]);
        $arr = request()->toArray();
        $arr['slug'] = News::getSlug(request('title'));
        try {
            $new = News::create($arr);
            return $new;
        } catch (\Exception $exc) {
            return response()->json(['error' => $exc->getMessage()], 500);
        }
    }
    /**
     * редактирование новости
     */
    public function edit($id)
    {
        $this->validate(request(), [
            'id' => 'required',
            'title' => 'required',
            'content' => 'required'
        ]);
        $arr = request()->toArray();
        $arr['slug'] = News::getSlug(request('title'), $id);
        try {
            $new = News::find($id);
            $new->fill($arr);
            $new->save();
            return $new;
        } catch (\Exception $exc) {
            return response()->json(['error' => $exc->getMessage()], 500);
        }
    }
}
