<?php

namespace App\Repositories\Languages;

class Language
{
    /**
     * @var $int
     */
    private $languages_id;

    /**
     * @var string
     */
    private $languages_name;

    public function __construct($data)
    {
        $this->languages_id = $data->languages_id;
        $this->languages_name = $data->languages_name;
    }

    /**
     * @return int
     */
    public function getLanguageId() : int
    {
        return $this->languages_id;
    }

    /**
     * @return string
     */
    public function getLanguagesName() : string
    {
        return $this->languages_name;
    }
}