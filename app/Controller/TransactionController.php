<?php

namespace Krispachi\KrisnaLTE\Controller;

use Exception;
use Krispachi\KrisnaLTE\App\FlashMessage;
use Krispachi\KrisnaLTE\App\View;
use Krispachi\KrisnaLTE\Model\TransactionModel;
use Krispachi\KrisnaLTE\Model\MahasiswaModel;

class TransactionController {
    public function index() {
        $model = [];
        $transactionModel = new TransactionModel();
        $model += [
            "transactions" => $transactionModel->getAllTransaction()
        ];
        
        $mahasiswaModel = new MahasiswaModel();
        $model += [
            "mahasiswas" => $mahasiswaModel->getAllMahasiswa()
        ];
        
        View::render("transaksi/index", $model);
    }

    public function transaction($id) {
        $model = new TransactionModel();
        $result = $model->getTransactionById($id);

        if(!empty($result)) {
            echo json_encode($result);
            exit(0);
        } else {
            echo json_encode(["error" => "empty"]);
            exit(0);
        }
    }

    public function store() {
        $data = [
            "id_mahasiswa" => $_POST["id_mahasiswa"],
            "kategori" => $_POST["kategori"],
            "nominal" => $_POST["nominal"],
            "tanggal" => $_POST["tanggal"]
        ];

        if(empty(trim($data["id_mahasiswa"])) || empty(trim($data["kategori"])) || empty(trim($data["nominal"])) || empty(trim($data["tanggal"]))) {
            FlashMessage::setFlashMessage("error", "Form tidak boleh kosong");
            $this->sendFormInput($data);
            header("Location: /transactions");
            exit(0);
        }

        $model = new TransactionModel();
        try {
            $model->createTransaction($data);
            
            FlashMessage::setFlashMessage("success", "Transaksi berhasil ditambah");
            header("Location: /transactions");
            exit(0);
        } catch (Exception $exception) {
            FlashMessage::setFlashMessage("error", $exception->getMessage());
            $this->sendFormInput($data);
            header("Location: /transactions");
            exit(0);
        }
    }

    public function edit($id) {
        $data = [
            "id" => $id,
            "id_mahasiswa" => $_POST["id_mahasiswa"],
            "kategori" => $_POST["kategori"],
            "nominal" => $_POST["nominal"],
            "tanggal" => $_POST["tanggal"]
        ];

        if(empty(trim($data["id_mahasiswa"])) || empty(trim($data["kategori"])) || empty(trim($data["nominal"])) || empty(trim($data["tanggal"]))) {
            FlashMessage::setFlashMessage("error", "Form tidak boleh kosong");
            header("Location: /transactions");
            exit(0);
        }

        $model = new TransactionModel();
        try {
            $model->updateTransaction($data);
            FlashMessage::setFlashMessage("success", "Transaksi berhasil diubah");
            header("Location: /transactions");
            exit(0);
        } catch (Exception $exception) {
            FlashMessage::setFlashMessage("error", $exception->getMessage());
            header("Location: /transactions");
            exit(0);
        }
    }

    public function delete($id) {
        $model = new TransactionModel();
        try {
            $model->deleteTransaction($id);
            FlashMessage::setFlashMessage("success", "Transaksi berhasil dihapus");
            header("Location: /transactions");
            exit(0);
        } catch (Exception $exception) {
            FlashMessage::setFlashMessage("error", $exception->getMessage());
            header("Location: /transactions");
            exit(0);
        }
    }

    public function sendFormInput(array $data) : void {
        $_SESSION["form-input"] = [];
        foreach($data as $key => $input) {
            if(!empty(trim($input))) {
                $_SESSION["form-input"] += [
                    "$key" => trim($input)
                ];
            }
        }
    }
}
