<?php
class exceptionHandler
{
    private $message;

    // this function is used to clean the error message
    private function sweep($string)
    {
        $errorPos = strpos($string, "ERROR:");
        if ($errorPos !== false) {
            $result = substr($string, $errorPos + strlen("ERROR:"));
        } else {
            $result = $string;
        }
        return $result; 
    }

    // helper methods
    private function RegularError($mess)
    {
        if (preg_match('/ERROR: P0001: ([\s\S]*?)\n/', $mess, $match)) {
            return $match[1];
        }
        return null;
    }

    // helper methods
    private function SQLError($mess)
    {
        if (preg_match('/SQLSTATE\[P0001\]: ([\s\S]*?)\n/', $mess, $match)) {
            return $match[1];
        }

        if (preg_match('/SQLSTATE\[23505\]: ([\s\S]*?)\n/', $mess, $match)) {
            return $match[1];
        }
        return DEFAULT_ERR;
    }

    public function getMessage()
    {
        return $this->sweep($this->message);
    }

    public function setMessage($message)
    {
        $this->message = $this->RegularError($message) ?? $this->SQLError($message);
    }
}