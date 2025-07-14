<?php
class Admin {
    private $e_mail;
    private $password;
    private $code_admin;

    // --- Constructeur ---
    public function __construct($e_mail = '', $password = '', $code_admin = '') {
        $this->e_mail = $e_mail;
        $this->password = $password;
        $this->code_admin = $code_admin;
    }

    // --- Getters ---
    public function getEmail() {
        return $this->e_mail;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getCodeAdmin() {
        return $this->code_admin;
    }

    // --- Setters ---
    public function setEmail($e_mail) {
        $this->e_mail = $e_mail;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setCodeAdmin($code_admin) {
        $this->code_admin = $code_admin;
    }
}
?>
