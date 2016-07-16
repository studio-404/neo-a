<?php
namespace lib\functions\email; 

class phpmailerException extends Exception
{
    public function errorMessage()
    {
        $errorMsg = '<strong>' . $this->getMessage() . "</strong><br />\n";
        return $errorMsg;
    }
}
?>