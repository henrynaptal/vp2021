<?php
    //alustame sessiooni
    //session_set_cookie_params()
    //session_start();
    require_once("classes/SessionManager.class.php");
    SessionManager::sessionStart("vp", 0, "/~hennap/vp2021/13_tund", "greeny.cs.tlu.ee");
    //kas on sisselogitud
    if(!isset($_SESSION["user_id"])){
        header("Location: page.php");
    }
    //väljalogimine
    if(isset($_GET["logout"])){
        session_destroy();
        header("Location: page.php");
    } 