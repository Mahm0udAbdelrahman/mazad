<?php

namespace App\Services;

use App\Models\ChangeLanguage;

class ChangeLanguageService
{
    public function update($data)
    {

        $ChangeLanguage = ChangeLanguage::first();
        if ($ChangeLanguage) {
            $ChangeLanguage->update($data);
        } else {
            ChangeLanguage::create($data);
        }

        return $ChangeLanguage;


}
}
