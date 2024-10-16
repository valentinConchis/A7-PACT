<?php

use app\core\Application;

class m0001_create_table_cb_mean_of_paiement
{
    public function up() {
        $db = Application::$app->db;
        $sql = "CREATE TABLE cb_mean_of_paiement (
            id INT PRIMARY KEY,
            name VARCHAR(50) NOT NULL,
            card_number VARCHAR(16) NOT NULL,
            expiration_date DATE NOT NULL,
            CONSTRAINT cb_mean_of_paiement_fk FOREIGN KEY (id) REFERENCES mean_of_paiement (id)
        );";
        $db->pdo->exec($sql);
    }

    public function down()
    {
        $db = Application::$app->db;
        $sql = "DROP TABLE cb_mean_of_paiement;";
        $db->pdo->exec($sql);
    }
}