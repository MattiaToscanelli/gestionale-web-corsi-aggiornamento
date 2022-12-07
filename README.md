# Gestione Web Corsi Aggiornamento
Lo scopo di questo progetto è quello di realizzare un sito web che permetta di 
gestire dei corsi di aggiornamento erogati da un’azienda formatrice. In poche 
parole bisognerà gestire tutto il processo di creazione dei corsi e 
dell’iscrizioni da parte dei corsisti. Il sito web è accessibile da chiunque, 
con la possibilità di visualizzare l’homepage e i corsi in programma. Per ogni 
corso è possibile effettuare un’iscrizione per un numero massimo di iscrizioni, 
fornendo i propri dati personali. Inoltre è possibile specificare se il 
partecipante al corso vuole iscriversi anche per il pranzo in comunque. 
Infine è presente anche una scheda pdf che riassume tutte le specifiche di un 
determinato corso. L’utente che si iscrive a un corso potrà registrarsi al sito, 
così da visualizzare tutti i corsi eseguiti in precedenza o ancora da fare, 
oppure può decidere di non registrarsi. Infine sono presenti uno o più gestori 
della pagina i quali possono modificare la homepage, modificare la pagina di 
contatti inviare e-mail di pubblicità, creare e gestire i corsi di 
aggiornamento, gestire le iscrizioni e modificare le impostazioni del sito.




# Installazione
In questa guida verrà mostrato come implementare questa applicazione sul 
proprio Web Server. In poche paroleverrà spiegato dove deve venir messa la 
cartella del progetto, quali file bisogna configurare affinché il sito funzioni
nella maniera corretta, lo script per la creazione del database e altre piccole 
aggiunte.


## Dove posizionare la cartella
All’interno della cartella “5_Sito o applicativo” è possibile trovare un’altra 
cartella di nome “GestioneCorsiAggiornamento”. Questa cartella deve essere 
inserita nella propria cartella “htdocs” del proprio web server.


## Dove posizionare la cartella
Per utilizzare la mia applicazione bisogna configurare tre file:
* config.js
* config.php

Il primo file (config.js) bisognerà modificare l’IP URL con quello del proprio 
Web Server. Questo file lo si può trovare all’interno della cartella js

Riempire il campo contrassegnato con “<>” inserendo il proprio dato (Riga 4):  
`const URL = 'http://<IP_WEB_SERVER>/GestioneCorsiAggiornamento/;`


Il secondo file (config.php) bisognerà eseguire più operazioni, più precisamente
bisognerà impostare l’IP URL con quello del proprio Web Server (Riga 20):  
`define('URL', 'http://<IP_WEB_SERVER>/GestioneCorsiAggiornamento/');`

All'interno di questo file possono trovare anche le configurazioni per il 
client di postaelettronica e di accesso al database in caso si vogliano 
modificare.


## Creazione Database
Lo script di creazione Database utilizzato lo si può trovare all’interno nella 
nella cartella Database. Copiare e eseguire il codice sul proprio server MySQL.


## Test Funzionamento
Per verificare che l'applicaziona funziona provare ad accedere sull'applicativo 
web con le seguenti credenziali:
* E-mail: gestionecorsi@yopmail.com
* Password: Password&1