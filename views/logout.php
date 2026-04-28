<?php
    session_destroy();//cerrando sesion
        if(headers_sent())
        {
                    echo "<script>
                        window.location.href='index.php?view=login';
                    </script>";
        }else{
                    header("Location: index.php?view=login");
        } 
?>