<?php

/**
 * Component.
 *
 * Component description.
 *
 * @version 1.0
 * @author Filip
 */
class ComponentProvider
{
    /**
     * Multi table
     * @param mixed $view
     * @return string
     */
    public static function Multitable($view)
    {
        return '<corly-multi-table view="' . $view . '"></corly-multi-table>';
    }
}
