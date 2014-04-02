<?php

/**
 * Importer short summary.
 *
 * Importer description.
 *
 * @version 1.0
 * @author Filip
 */
class Importer
{
    /**
     * Import given file based on metadata
     * @param metadata - meta information about given data
     * @param FileParser file - uploaded file
     * @return TestSuite - object containing one test suite result
     */
    public static function Import($validation, $file)  {
    
        return Parser::ParseImport($file->getTemp());
    }
}
