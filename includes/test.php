<?php
require_once '../core/init.php';
var_dump(nl2br(str_replace("\n.", "\n..", escape(trim($_POST['message'])))));


