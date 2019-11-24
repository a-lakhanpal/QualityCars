<?php

/** Error handling functions **/

set_error_handler(HandleError);

function HandleError($errno, $errstr, $errfile, $errline)
{
	$err .= "Error: [$errno] $errstr <br />\nLine: $errline <br />\nFile: $errfile <br />PHP ". PHP_VERSION . " (" . PHP_OS . " ) <br />\n";
	$cont = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<title>Error | Quality Car</title>
				</head>
				<body style=\'font-family: "Trebuchet MS",Arial,Helvetica,sans-serif;\'><div style="width: 600px; margin: auto; color:#ff0000; border:1px solid #ff0000; background: #ffe5e5; padding: 20px; text-align: center;">
				
';
	
	$cont .= '<h1>Quality Cars</h1>';
	$cont .= "<h3>An error occured!</h3>";
	$cont .= "<p>Something went wrong while trying to perform the requested operation. Please note the details below and contact the system administrator.</p>";
	$cont .= $err;
	$cont .= "<a href='http://hyperdisc.unitec.ac.nz/wad10s1/soltab01/QualityCarsPHP/'>Go to Quality Cars home page</a>";
	$cont .= '</div></body></html>';
	
	echo $cont;
	logError($err);	
	exit(1);
		
	
    /* Don't execute PHP internal error handler */
    return true;
}

/** Log error to file **/
function logError($error) 
{
	//Log error to file
	$fh = fopen('Error_Log.txt', 'a') or $cont .= 'Can not log the error to the log file';
	fwrite($fh, "\n\n--------------------------------\n");
	fwrite($fh, date('l jS \of F Y h:i:s A'));
	fwrite($fh, "\n");
	fwrite($fh, $error);
	fclose($fh);
}

?>