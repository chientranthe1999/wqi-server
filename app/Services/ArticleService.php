<?php


namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;

class ArticleService extends BaseService
{
    public function __construct(Request $r)
    {
        parent::__construct($r);
    }



    protected function setModel()
    {
        $this->model = new Article();
    }

    public function _addFilter($r)
    {
        $this->query->with('users:id,name');
    }

    public function store(array $attributes = [], Request $r)
    {
        $userId = Auth::id();
        $infor = $this->model->create([
            'user_id' => $userId,
            'category' => $r->input('category'),
            'content' => $r->input('content'),
            'title' => $r->input('title'),
            'image' => $r->input('image'),
        ]);
        return $infor;
    }
}
