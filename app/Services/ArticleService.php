<?php


namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Article;

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
}
