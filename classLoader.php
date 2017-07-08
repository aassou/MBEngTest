<?php
spl_autoload_register(function ($myClass)
{
    if ( file_exists(__DIR__ . '/src/MessagingService/'.$myClass.'.php') )
    {
        require(__DIR__ . '/src/MessagingService/'.$myClass.'.php');
    }
    
    if ( file_exists(__DIR__ . '/src/Objects/'.$myClass.'.php') )
    {
        require(__DIR__ . '/src/Objects/'.$myClass.'.php');
    }
});