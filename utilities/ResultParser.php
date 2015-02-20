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
        return self::parseMultipleResult($statement)[0];
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

    /**
     * Get result of count query
     * @param statement
     * @return count
     */
    public static function parseCountResult($statement)  {
        // Store result
        $statement->store_result();

        // Get result metadata
        $meta = $statement->result_metadata();

        // Init arrays
        $variables = array();
        $data = array();

        // Get field names
        while ($field = $meta->fetch_field())   {
            $variables[] = &$data[$field->name];
        }

        // Bind variabeles to result
        call_user_func_array(array($statement, 'bind_result'), $variables);
    
        // Fetch single result
        $statement->fetch();

        $count = 0;
        // Assign value
        foreach ($data as $key => $value) {
            $count = $value;
        }

        return $count;
    }

}
