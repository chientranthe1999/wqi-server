<?php
namespace App\Constants;

class Common
{
    const PAGING_LIMIT = 20;
    const PAGING_ORDER_BY = 'created_at';
    const PAGING_ORDER_TYPE = 'desc';

    const SQL_SPECIAL_CHARACTERS = ["\\", "'", "\"", "%", "_"];

    const ACTIVE = 1;
    const DISABLE = 2;

}
