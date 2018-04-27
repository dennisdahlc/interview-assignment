<?php

require_once 'constanthelper.php';

class FileHelper
{
    private static $LogFileName = "log.html";
    
    public static function addStringToFile($string)
    {
        if(!is_null($string))
        {
            $logFile = @fopen(self::$LogFileName, "a");

            if($logFile === false)
            {
                echo 'Error when opening file ' . self::$LogFileName . '<br>';
            }
            else
            {
                $string = self::addExtraLineForSpacingIfNeeded($string);
                
                self::appendStringToFile($logFile, $string);

                fclose($logFile);
            }
        }
    }
    
    public static function ensureStringIsPresentInFile($string)
    {
        $hasAllLinesInStringBeenIdentifiedInLogFile = false;
        
        if(!is_null($string))
        {
            $logFile = @fopen(self::$LogFileName, "r");

            if($logFile === false)
            {
                echo 'Error when opening file ' . self::$LogFileName . '<br>';
            }
            else
            {
                $hasAllLinesInStringBeenIdentifiedInLogFile = self::areAllLinesInStringPresentInFile($string, $logFile);
            }
        }

        return $hasAllLinesInStringBeenIdentifiedInLogFile;
    }
    
    public static function deleteLogFile()
    {
        if(file_exists(self::$LogFileName))
        {
            unlink(self::$LogFileName);
        }
    }
    
    private static function areAllLinesInStringPresentInFile($string, $logFile)
    {
        $hasAllLinesInStringBeenIdentifiedInLogFile = false;
        
        $stringLines = explode(PHP_EOL, $string);

        $stringLinesIndex = 0;
        
        $isContinousReadOfLines = false;
        
        while(!feof($logFile)) 
        {
            $lineInFileRaw = fgets($logFile);
            
            //strip the EOL part of the string, since the exploded string array does not contain it
            $lineInFile = str_replace(PHP_EOL, "", $lineInFileRaw);
            
            $isLineInFileEqualToLineInString = strcmp($lineInFile, $stringLines[$stringLinesIndex]) === 0;

            if(!$isContinousReadOfLines && $isLineInFileEqualToLineInString)
            {
                $isContinousReadOfLines = true;
            }
            elseif($isContinousReadOfLines && !$isLineInFileEqualToLineInString)
            {
                $isContinousReadOfLines = false;
            }
            
            if($isLineInFileEqualToLineInString)
            {
                $stringLinesIndex++;
            }
            
            //when all lines in the string have been read in a continous manner, it is confirmed that the file contain the string
            if($isContinousReadOfLines && $stringLinesIndex === count($stringLines) - 1)
            {
                $hasAllLinesInStringBeenIdentifiedInLogFile = true;
                break;
            }
        }
        
        return $hasAllLinesInStringBeenIdentifiedInLogFile;
    }
    
    private static function addExtraLineForSpacingIfNeeded($string)
    {
        $fileSize = filesize(self::$LogFileName);

        if($fileSize > 0)
        {
            $string = ConstantHelper::$HTMLLineBreak . $string;
        }
        
        return $string;
    }
    
    private static function appendStringToFile($logFile, $string)
    {
        $writeStatus = fwrite($logFile, $string);

        if($writeStatus === false)
        {
            echo 'Error when writing to file ' . self::$LogFileName . '<br>';
        }
    }
}

?>