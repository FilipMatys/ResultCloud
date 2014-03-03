<?php

class ColorHandle {
    /**
     * Change the brightness of the passed in color
     *
     * $diff should be negative to go darker, positive to go lighter and
     * is subtracted from the decimal (0-255) value of the color
     *
     * @param string $hex color to be modified
     * @param string $diff amount to change the color
     * @return string hex color
     */
    public static function hex_color_mod($colour, $per) {
        $colour = substr( $colour, 1 ); // Removes first character of hex string (#) 
        $rgb = ''; // Empty variable 
        $per = $per/100*255; // Creates a percentage to work with. Change the middle figure to control colour temperature

        if  ($per < 0 ) // Check to see if the percentage is a negative number 
        { 
            // DARKER 
            $per =  abs($per); // Turns Neg Number to Pos Number 
            for ($x=0;$x<3;$x++) 
            { 
                $c = hexdec(substr($colour,(2*$x),2)) - $per; 
                $c = ($c < 0) ? 0 : dechex($c); 
                $rgb .= (strlen($c) < 2) ? '0'.$c : $c; 
            }   
        }  
        else 
        { 
            // LIGHTER         
            for ($x=0;$x<3;$x++) 
            {             
                $c = hexdec(substr($colour,(2*$x),2)) + $per; 
                $c = ($c > 255) ? 'ff' : dechex($c); 
                $rgb .= (strlen($c) < 2) ? '0'.$c : $c; 
            }    
        } 
        
        return '#'.$rgb;
    }
}