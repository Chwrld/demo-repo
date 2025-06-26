<?php

//kung naa nay logout button
session_start();
session_destroy();
header('Location: ../index.php');
exit();