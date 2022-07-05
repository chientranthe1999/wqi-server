<?php

namespace App\Http\Controllers;


use App\Services\ArticleService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function __construct(ArticleService $service)
    {
        parent::__construct($service);
    }

    public function show($id)
    {
        $result = $this->service->show($id, ['users:id,name']);
        return $this->respond($result);
    }
}
