<?php

function moveUploadedFile($filename, $destination)
{
    //Copy file
    return copy($filename, $destination);
}
?>