<?php

namespace Krispachi\KrisnaLTE\Model;

use Exception;
use Krispachi\KrisnaLTE\App\Database;

class TransactionModel {
    private $table = "transaksis";
    private $database;

    public function __construct() {
        $this->database = new Database();
    }

    public function getAllTransaction() {
        $this->database->query("SELECT * FROM {$this->table}");
        return $this->database->resultSet();
    }

    public function getTransactionById($id) {
        $this->database->query("SELECT * FROM {$this->table} WHERE id = :id");
        $this->database->bind("id", $id);
        return $this->database->single();
    }

    public function createTransaction($data) {
        $query = "INSERT INTO {$this->table} (id_mahasiswa, kategori, nominal, tanggal) VALUES(:id_mahasiswa, :kategori, :nominal, :tanggal)";
        $this->database->query($query);

        $this->database->bind("id_mahasiswa", $data["id_mahasiswa"]);
        $this->database->bind("kategori", $data["kategori"]);
        $this->database->bind("nominal", $data["nominal"]);
        $this->database->bind("tanggal", $data["tanggal"]);

        $this->database->execute();
    }

    public function updateTransaction($data) {
        if(empty($this->getTransactionById($data["id"]))) {
            throw new Exception("Transaksi tidak ditemukan");
        }
        
        $query = "UPDATE {$this->table} SET id_mahasiswa = :id_mahasiswa, kategori = :kategori, nominal = :nominal, tanggal = :tanggal WHERE id = :id";
        $this->database->query($query);

        $this->database->bind("id_mahasiswa", $data["id_mahasiswa"]);
        $this->database->bind("kategori", $data["kategori"]);
        $this->database->bind("nominal", $data["nominal"]);
        $this->database->bind("tanggal", $data["tanggal"]);
        $this->database->bind("id", $data["id"]);

        $this->database->execute();
    }

    public function deleteTransaction($id) {
        if(empty($this->getTransactionById($id))) {
            throw new Exception("Transaksi tidak ditemukan");
        }
        
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $this->database->query($query);
        $this->database->bind("id", $id);
        $this->database->execute();
    }
}
