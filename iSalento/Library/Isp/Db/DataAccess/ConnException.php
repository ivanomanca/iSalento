<?php

class Isp_Db_DataAccess_ConnException extends Exception {}

/*		
class Test {
    public function testing() {
        try {
            try {
                throw new MyException('foo!');
            } catch (MyException $e) {
                //rethrow it
                throw $e;
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
}
*/

//$foo = new Test;
//$foo->testing();

/*
class Exception
{
    protected $message = 'Unknown exception';   // exception message
    protected $code = 0;                        // user defined exception code
    protected $file;                            // source filename of exception
    protected $line;                            // source line of exception

    function __construct($message = null, $code = 0);

    final function getMessage();                // message of exception 
    final function getCode();                   // code of exception
    final function getFile();                   // source filename
    final function getLine();                   // source line
    final function getTrace();                  // an array of the backtrace()
    final function getTraceAsString();          // formated string of trace

    // Overrideable
    function __toString();                       // formated string for display
}


*/
?>
