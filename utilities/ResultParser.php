<?php
/**
 * Parse result from mysqli prepared
 * statements.
 *
 * @author Filip Matys
 * @author Jiri Kratochvil
 */

class ResultParser {

    // Get single result
    public static function parseSingleResult($statement) {
        // Store result
        $statement->store_result();

        // Get result metadata
        $meta = $statement->result_metadata();

        // Init helpful arrays
        $variables = array();
        $data = array();
        // Get all returned fields names
        while ($field = $meta->fetch_field()) {
            $variables[] = &$data[$field->name];
        }

        // Bind variables to result
        call_user_func_array(array($statement, 'bind_result'), $variables);

        // Fetch single result
        $statement->fetch();

        // Create empty object and assign properties 
        // and values
        $loadedEntity = new stdClass();
        foreach ($data as $key => $value) {
            $loadedEntity->$key = $value;
        }

        // Free the result
        $statement->free_result();

        return $loadedEntity;
    }

    // Get multiple results 
    public static function parseMultipleResult($statement) {
        // Store result
        $statement->store_result();

        // Get result metadata
        $meta = $statement->result_metadata();

        // Init helpful arrays
        $variables = array();
        $data = array();
        // Get all returned fields names
        while ($field = $meta->fetch_field()) {
            $variables[] = &$data[$field->name];
        }
        
        // Bind variables to result
        call_user_func_array(array($statement, 'bind_result'), $variables);

        $entities = array();

        // Fetch multiple results
        while ($statement->fetch()) {
            // Create empty object and assign properties 
            // and values
            $loadedEntity = new stdClass();
            foreach ($data as $key => $value) {
                $loadedEntity->$key = $value;
            }
            $entities[] = $loadedEntity;
        }
        // Free the result
        $statement->free_result();

        return $entities;
    }

}
