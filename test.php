<?php
session_start();
include_once 'classes/Session.php';




echo Session::flash('success');
