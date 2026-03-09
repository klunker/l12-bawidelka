<?php

use Illuminate\Support\Facades\File;

test('has all polish translatable keys', function () {
    $enFiles = File::allFiles(lang_path('en'));

    foreach ($enFiles as $enFile) {
        $filename = $enFile->getFilename();
        $enTranslations = require $enFile->getPathname();
        $arrFile = lang_path("pl/{$filename}");

        // Check if Polish translation file exists
        expect(File::exists($arrFile))->toBeTrue("Polish translation file '{$filename}' does not exist");

        // Load Polish translations
        $plTranslations = require $arrFile;

        // Check that all English keys exist in Polish translations
        foreach ($enTranslations as $key => $value) {
            expect($plTranslations)->toHaveKey($key);
        }
    }
});
