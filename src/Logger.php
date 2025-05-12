<?php

namespace AuthPackage;

class Logger
{
    private static $logFile = __DIR__ . '/../logs/error_log.txt';

    public static function log($level, $message, $context = [])
    {
        date_default_timezone_set('Africa/Nairobi');
        $time = date('Y-m-d H:i:s');
        $contextText = !empty($context) ? json_encode($context) : '';
        $logEntry = "[$time] [$level] $message $contextText" . PHP_EOL;

        file_put_contents(self::$logFile, $logEntry, FILE_APPEND);
        self::rotateLogIfNeeded();
    }

    public static function info($message, $context = [])
    {
        self::log('INFO', $message, $context);
    }

    public static function warning($message, $context = [])
    {
        self::log('WARNING', $message, $context);
    }

    public static function error($message, $context = [])
    {
        self::log('ERROR', $message, $context);
    }

    // rotatlog is responsible to check if logfile exceeds 1mb to create new file and call the prevoiud one archive
    private static function rotateLogIfNeeded()
    {
        $maxSize = 1024 * 1024 * 1; // 1 MB
        if (file_exists(self::$logFile) && filesize(self::$logFile) > $maxSize) {
            $backupFile = self::$logFile . '.' . date('Y-m-d');
            rename(self::$logFile, $backupFile); // Archive the old log
            file_put_contents(self::$logFile, ''); // Start a fresh log file
        }
    }
}
