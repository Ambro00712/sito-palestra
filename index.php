<?php
    // Controllo se il cookie 'user_session' è stato inviato dal browser
    if (isset($_COOKIE['user_session'])) {
        // Recupero il valore del cookie
        $cookie_value = $_COOKIE['user_session'];

        // Dividi il cookie per ottenere nome_utente e password
        list($nome_utente, $password) = explode('-', $cookie_value);

        // Connessione al database
        $host="127.0.0.1";
        $user="root";
        $db_password="";
        $database="vitality";

        $conn = new mysqli($host, $user, $db_password, $database);

        if($conn->connect_error){
            die("Connessione non riuscita: " . $conn->connect_error);
        }

        // Verifica se nome_utente e password sono validi
        $query = "SELECT * FROM utenti WHERE nome_utente = '$nome_utente' AND password = '$password';";
        $risultato = $conn->query($query);

        if ($risultato && $risultato->num_rows > 0) {
            // Autenticazione riuscita
            $vettore = $risultato->fetch_assoc();
            // Reindirizzamento a home.php perchè il cookie è gia stato stabilito
            header("Location: pagine_varie/home.php");
            exit();
            
        } else {
            // Autenticazione fallita
            //Cookie non valido o sessione scaduta.
            header("Location: pagine_varie/login.html");
            exit();
            
        }

        $conn->close();
    } else {
        header("Location: pagine_varie/login.html");
        exit();
    }
?>
