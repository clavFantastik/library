<?php

include "lib/user_session.php";
destroy_sess();

header('Location: /login.php');

?>