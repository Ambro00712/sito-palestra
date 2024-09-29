<?php
    // Connessione al database
    $host="127.0.0.1";
    $user="root";
    $password="";
    $database="vitality";

    $conn = new mysqli($host, $user, $password, $database);
    
    if($conn->connect_error){
        die("Connessione non riuscita: " . $conn->connect_error);
    }

    // Estrazione dati dal post
    $nome_utente = $_POST['nome_utente'];
    $password = $_POST['password'];

    // Generazione query per estrarre i dati dal database
    $query = "SELECT * FROM utenti WHERE nome_utente = '$nome_utente' AND password = '$password';";
    
    // Esecuzione query
    $risultato = $conn->query($query);
    
    // Verifica risultato
    if ($risultato && $risultato->num_rows > 0) {
        //dati di login corretti, viene creato il cookie e inclusa la pagina home.php
        $vettore = $risultato->fetch_assoc(); // Trasforma i risultati in array associativo

        // Creazione della stringa cookie unendo nome_utente e password
        $cookie_value = $nome_utente . '-' . $password;

        // Imposta il cookie, con durata di 1 ora
        setcookie("user_session", $cookie_value, time() + 3600, "/");

        // Utente reindirizzato a home.php
        header("Location: pagine_varie/home.php");
        exit();
    } else {
        //login sbagliato, non viene creato il cookie e viene riaperta la pagina di login
        header("Location: pagine_varie/login.html");
        exit();
    }

    $conn->close();
?>
