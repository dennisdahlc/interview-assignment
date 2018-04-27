<?php

require_once 'mysqlhelper.php';
require_once 'filehelper.php';

class EventHandler 
{
    public static $selectEventName = "Select";
    public static $resetEventName = "Reset";
    
    public static function handleEvent()
    {
        MySQLHelper::createConnectionToDatabase();
        
        $event = self::retrieveEvent();
        
        $eventName = $event->name;
        
        if($eventName == self::$selectEventName)
        {
            self::executeSelect($event);
        }
        else if($eventName == self::$resetEventName)
        {
            self::initializeSetup();
        }
        
        MYSQLHelper::closeConnection();
    }
    
    public static function initializeSetup()
    {
        MySQLHelper::initializeDatabase();
        FileHelper::deleteLogFile();
        
        echo "Database reset";
    }
    
    public static function executeSelect($event)
    {
        $result = MySQLHelper::performSelectOperation($event);
        
        FileHelper::addStringToFile($result);

        $isResultAddedToFile = FileHelper::ensureStringIsPresentInFile($result);
        
        MYSQLHelper::performDeleteOperation($isResultAddedToFile, $event);
        
        echo $result;
    }
    
    private static function retrieveEvent()
    {
        $URIStringifiedJson = $_POST["data"];
        
        $decodedStringifiedJson = urldecode($URIStringifiedJson);
        
        $event = json_decode($decodedStringifiedJson);
        
        return $event;
    }
}

EventHandler::handleEvent();

?> 