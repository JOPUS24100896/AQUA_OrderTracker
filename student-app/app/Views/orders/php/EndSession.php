<?php 
session_start();
session_unset();
session_destroy();
return view('orders');
?>