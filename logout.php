<?php

// empty everything and go back to index.php

require "connect.php";
session_destroy();
header("Location: index.html");