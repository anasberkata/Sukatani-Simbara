<?php

if (isset($_SESSION['login'])) {
} else {
    header("Location: index.php");
}

?>