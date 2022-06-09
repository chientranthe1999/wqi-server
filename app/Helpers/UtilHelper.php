<?php

namespace App\Helpers;

use App\Constants\Common;
class UtilHelper {
    public static function normalizeKeywordForSearch($keyword)
    {
        if ($keyword) {
            $keyword = trim($keyword);
        }
        if (!$keyword && $keyword != 0) {
            return null;
        }
        foreach (Common::SQL_SPECIAL_CHARACTERS as $character) {
            $keyword = str_replace($character, "\\$character", $keyword);
        }
        return $keyword;
    }
}
