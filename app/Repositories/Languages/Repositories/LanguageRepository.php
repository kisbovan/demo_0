<?php

namespace App\Repositories\Languages\Repositories;

use App\Repositories\Languages\Language;

class LanguageRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * @return Languages[]
     */
    public function getAllLanguages() : array
    {
        $allProducts = [];

        if ($result = $this->db->query("SELECT * FROM `languages`;")) {
            while ($obj = $result->fetch_object()) {
                $allProducts[] = new Language($obj);
            }
        }

        return $allProducts;
    }

    /**
     * @param int $id
     * 
     * @return Language
     */
    public function getLanguageById(int $id) : Language
    {
        $result = $this->db->query(sprintf("SELECT * FROM `languages` WHERE `languages_id` = %d;", $id))->fetch_row();

        return new Language($this->createObject($result));
    }

    private function createObject($result)
    {
        $languageObj->languages_id = $result[0];
        $languageObj->languages_name = $result[1];

        return $languageObj;
    }
}