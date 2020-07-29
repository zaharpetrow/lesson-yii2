<?php

namespace common\traits;

trait SaveToFileTrait
{

    public static function saveToFile(string $text, string $filePath)
    {
        file_put_contents($filePath, "$text\n", FILE_APPEND);
    }

}
