<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    const P = ["#\n {3} *#","#ray\n#","#\n *\)#","# *\=\> *#","# {2} *#"  ,"#\n *\)#", "#\( #", "# \)#"];
    const R = [" ",         "ray",    ")",       "=",         " "         ,")"       , "(",     ")" ];
    define('DS',DIRECTORY_SEPARATOR);
    define('APP_START',microtime(true));
    define('ROOT_DIR',dirname(__FILE__).DS);
    define('FW_DIR',sprintf("%svendor%sfw%s",ROOT_DIR,DS,DS));
    define('APP_DIR',sprintf( '%sapp%s',ROOT_DIR,DS));
    try {
        // set up the autoloader
        require sprintf('%sbootstrap%sbootstrap.php',FW_DIR,DS);
        // next, set up the factory for all future class instantiation
        $factory = new fw\factory\ClassFactory();
        // create the app
        $app = $factory->getClass('app\app');
        // process the request
        $ob = "";
        $errormessage = "";
        if (($result = $app->go($errormessage,false)) === false) {
            if (str_pos("database",$errormessage)) {
                $message = <<<HTML
                    <BR><BR>
                    The database at the Host is down.  We are waiting for the service to be resumed. We will be online again as soon as possible.
                    HTML;
            } else {
                $message = "";
            }
            $html = <<<HTML
            <div style="width:100%;height:100%;margin: 0 auto;">
                <h1>SORRY, THE ROSTER SITE IS TEMPORARILY UNAVAILABLE</h1>
                <div>$message
                    <BR><BR>{$errormessage}
                </div>
            </div>
            HTML;
            die;
        }
        // return anything in the output buffer then the application output
        echo $ob.$result;
    } catch (Exception $e) {
        die("Caught Exception in index.php: ".$e->getMessage());
    }
