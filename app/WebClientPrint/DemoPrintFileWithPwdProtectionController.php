<?php

include 'WebClientPrint.php';

use Neodynamic\SDK\Web\WebClientPrint;
use Neodynamic\SDK\Web\Utils;
use Neodynamic\SDK\Web\DefaultPrinter;
use Neodynamic\SDK\Web\InstalledPrinter;
use Neodynamic\SDK\Web\PrintFile;
use Neodynamic\SDK\Web\PrintFilePDF;
use Neodynamic\SDK\Web\PrintFileDOC;
use Neodynamic\SDK\Web\PrintFileXLS;
use Neodynamic\SDK\Web\PrintRotation;
use Neodynamic\SDK\Web\PrintOrientation;
use Neodynamic\SDK\Web\ClientPrintJob;
use Neodynamic\SDK\Web\EncryptMetadata;

// Process request
// Generate ClientPrintJob? only if clientPrint param is in the query string
$urlParts = parse_url($_SERVER['REQUEST_URI']);

if (isset($urlParts['query'])) {
    $rawQuery = $urlParts['query'];
    parse_str($rawQuery, $qs);
    if (isset($qs[WebClientPrint::CLIENT_PRINT_JOB])) {

        $useDefaultPrinter = ($qs['useDefaultPrinter'] === 'checked');
        $printerName = urldecode($qs['printerName']);

        $fileName = uniqid() . '.' . $qs['filetype'];

        $filePath = '';
        if ($qs['filetype'] === 'PDF') {
            $filePath = 'files/LoremIpsum-PasswordProtected.pdf';
        } else if ($qs['filetype'] === 'DOC') {
            $filePath = 'files/LoremIpsum-PasswordProtected.doc';
        } else if ($qs['filetype'] === 'XLS') {
            $filePath = 'files/SampleSheet-PasswordProtected.xls';
        }

        if (!Utils::isNullOrEmptyString($filePath)) {
            
            //get and set the RSA pub key generated by WCPP Client Utility 
            $publicKeyBase64 = $qs['wcp_pub_key_base64'];
            $publicKeySignatureBase64 = $qs['wcp_pub_key_signature_base64'];
            
            if (!Utils::isNullOrEmptyString($publicKeyBase64)) {
                
                //create an encryption metadata to set to the PrintFile
                $encMetadata = new EncryptMetadata($publicKeyBase64, $publicKeySignatureBase64);
                
                //ALL the test files are protected with the same password for demo purposes 
                //This password will be encrypted and stored in file metadata
                $plainTextPassword = 'ABC123';
                
                //Create a ClientPrintJob obj that will be processed at the client side by the WCPP
                $cpj = new ClientPrintJob();

                if ($qs['filetype'] === 'PDF')
                {
                    $myfile = new PrintFilePDF($filePath, $fileName, null);
                    $myfile->password = $plainTextPassword;
                    //$myfile->printRotation = PrintRotation::None;
                    //$myfile->pagesRange = '1,2,3,10-15';
                    //$myfile->printAnnotations = true;
                    //$myfile->printAsGrayscale = true;
                    //$myfile->printInReverseOrder = true;
                    
                    $myfile->encryptMetadata = $encMetadata;
                    
                    $cpj->printFile = $myfile;
                }
                else if ($qs['filetype'] === 'DOC')
                {
                    $myfile = new PrintFileDOC($filePath, $fileName, null);
                    $myfile->password = $plainTextPassword;
                    //$myfile->pagesRange = $qs['pagesRange'];
                    //$myfile->printInReverseOrder = ($qs['printInReverseOrder']=='true');
                    
                    $myfile->encryptMetadata = $encMetadata;
                    
                    $cpj->printFile = $myfile;
                }
                else if ($qs['filetype'] === 'XLS')
                {
                    $myfile = new PrintFileXLS($filePath, $fileName, null);
                    $myfile->password = $plainTextPassword;
                    //$myfile->$pagesFrom = 0;
                    //$myfile->$pagesTo = 0;
                    
                    $myfile->encryptMetadata = $encMetadata;
                    
                    $cpj->printFile = $myfile;
                }

                if ($useDefaultPrinter || $printerName === 'null') {
                    $cpj->clientPrinter = new DefaultPrinter();
                } else {
                    $cpj->clientPrinter = new InstalledPrinter($printerName);
                }

                //Send ClientPrintJob back to the client
                ob_start();
                ob_clean();
                header('Content-type: application/octet-stream');
                echo $cpj->sendToClient();
                ob_end_flush();
                exit();

            }
        }
    }
}
    


 