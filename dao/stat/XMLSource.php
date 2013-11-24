<?php

/* 
 * File: XMLSource.php
 * Author: Filip Matys
 * About: Implements source enumeration for XML scheme
 */

abstract class XMLSourceType   {
    const Attribute = 0;
    const Element = 1;
}

abstract class XMLSourceValueType  {
    const Value = 0;
    const Name = 0;
}

?>
