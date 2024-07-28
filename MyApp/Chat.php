<?php
namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use PDO; // Untuk koneksi database

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $pdo;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->pdo = new PDO("mysql:host=localhost;dbname=your_database", "your_user", "your_password");
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $this->pdo->prepare("INSERT INTO messages (message) VALUES (?)")->execute([$msg]);
        foreach ($this->clients as $client) {
            $client->send($msg);
        }
    }

    // ... (onClose, onError)
}
