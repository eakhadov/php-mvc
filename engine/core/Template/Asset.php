<?php

namespace Engine\Core\Template;

class Asset
{
    /**
     * Undocumented function
     *
     * @param string $file asset file
     * @return string
     */
    public static function get(string $file): string
    {
        return content_path('themes') . '/' . View::theme();
    }
}
