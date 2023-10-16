elenco dei cambiamenti effettuati per farlo partire:

- aggiunto ambiente docker compose con zendphp per tirare su rapidamente un ambiente di sviluppo. Tutti gli step di installazione "una tantum" sono all'interno del file zend/entrypoint.d/00-init.sh
- modificato file dev/common/config/main-local.php e dev/common/config/test-local.php per puntare al database containerizzato
- aggiunta configurazione per xdebug e vscode
- creato file yii.orig dal file yii committato nel repository, prima che venga modificato dal php init. Viene usato per lanciare le migrazioni che NON partono col file yii modificato dal php init
- aggiunta configurazione alias "@backend" in common/config/main.php per far funzionare le migrazioni, riga 42
- aggiunti file .gitkeep e .gitignore per mantenere versionate cartelle vuote fondamentali per il funzionamento dell'applicazione. Elenco cartelle:
  common/uploads/store
  common/uploads/temp
  console/runtime
  backend/models
  backend/web
  frontend/runtime
- cambiata lingua di default da italiano a inglese nel file frontend/configs/components.php, riga 88, per poter lanciare in modalità non interattiva la creazione del primo utente
- aggiunto .gitignore "esterno" per escludere tutti i file temporanei e/o generati dall'applicativo durante la fase di setup e esecuzione.

richieste:

- controllare la lista delle dipendenze e fornire un composer.lock funzionante in quanto fare un composer install adesso non fa partire l'applicativo (pagina bianca)
- valutare l'aggiunta della configurazione alias "@backend": è stata messa al posto giusto?