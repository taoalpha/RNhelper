<?php
    /*
     * Copyright 2010-2012 Evernote Corporation.
     *
     * This sample web application demonstrates the process of using OAuth to authenticate to
     * the Evernote web service. More information can be found in the Evernote API Overview
     * at http://dev.evernote.com/documentation/cloud/.
     *
     * This application uses the PHP OAuth Extension to implement an OAuth client.
     * To use the application, you must install the PHP OAuth Extension as described
     * in the extension's documentation: http://www.php.net/manual/en/book.oauth.php
     */

    // Include our configuration settings
    require_once 'config.php';

    // Include our OAuth functions
    require_once 'functions.php';

    // Use a session to keep track of temporary credentials, etc
    session_start();

    // Status variables
    $lastError = null;
    $currentStatus = null;

    // Request dispatching. If a function fails, $lastError will be updated.
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        if ($action == 'callback') {
            if (handleCallback()) {
                if (getTokenCredentials()) {
                    getUser();
               }
            }
        } elseif ($action == 'authorize') {
            if (getTemporaryCredentials()) {
                // We obtained temporary credentials, now redirect the user to evernote.com to authorize access
                header('Location: ' . getAuthorizationUrl());
            }
        } elseif ($action == 'reset') {
            resetSession();
        } elseif ($action =="addnote"){
            $tags = array();
            $tags [] = "RNhelper";
            addNote($_POST["title"],$_POST["content"],$tags,$_POST["baseurl"]);
            $_COOKIE["save"] = "justsaved";
            echo("justsaved");
        }
    }

