<?php

namespace App\Models;

use \App\Database\Database;

class Model extends Database
{
    protected $table;

    private $db;

    public function findAll() {
        $query = $this->customQuery('SELECT * FROM ' . $this->table);
        return $query->fetchAll();
    }

    public function findBy(array $criteres)
        {
            $champs = [];
            $valeurs = [];

            // On boucle pour éclater le tableau
            foreach($criteres as $champ => $valeur){
                // SELECT * FROM annonces WHERE actif = ? AND signale = 0
                // bindValue(1, valeur)
                $champs[] = "$champ = ?";
                $valeurs[] = $valeur;
            }

            // On transforme le tableau "champs" en une chaine de caractères
            $liste_champs = implode(' AND ', $champs);

            // On exécute la requête
            return $this->customQuery('SELECT * FROM '.$this->table.' WHERE '. $liste_champs, $valeurs)->fetchAll();
        }

        public function find(int $id)
        {
            return $this->customQuery("SELECT * FROM {$this->table} WHERE id = $id")->fetch();
        }

    public function create(Model $model)
    {
        $champs = [];
        $inter = [];
        $valeurs = [];

        // On boucle pour éclater le tableau
        foreach($model as $champ => $valeur){
            // INSERT INTO annonces (titre, description, actif) VALUES (?, ?, ?)
            if($valeur != null && $champ != 'db' && $champ != 'table'){
                $champs[] = $champ;
                $inter[] = "?";
                $valeurs[] = $valeur;
            }
        }

        // On transforme le tableau "champs" en une chaine de caractères
        $liste_champs = implode(', ', $champs);
        $liste_inter = implode(', ', $inter);

        // On exécute la requête
        return $this->customQuery('INSERT INTO '.$this->table.' ('. $liste_champs.')VALUES('.$liste_inter.')', $valeurs);
    }

        public function update(int $id, Model $model)
    {
        $champs = [];
        $valeurs = [];

        // On boucle pour éclater le tableau
        foreach($model as $champ => $valeur){
            // UPDATE annonces SET titre = ?, description = ?, actif = ? WHERE id= ?
            if($valeur !== null && $champ != 'db' && $champ != 'table'){
                $champs[] = "$champ = ?";
                $valeurs[] = $valeur;
            }
        }
        $valeurs[] = $id;

        // On transforme le tableau "champs" en une chaine de caractères
        $liste_champs = implode(', ', $champs);

        // On exécute la requête
        return $this->customQuery('UPDATE '.$this->table.' SET '. $liste_champs.' WHERE id = ?', $valeurs);
    }

        public function delete(int $id)
        {
            return $this->customQuery("DELETE FROM {$this->table} WHERE id = ?", [$id]);
        }


        public function customQuery(string $sql, array $attributs = null)
        {
            // On récupère l'instance de Db
            $this->db = Database::getInstance();

            // On vérifie si on a des attributs
            if($attributs !== null){
                // Requête préparée
                $query = $this->db->prepare($sql);
                $query->execute($attributs);
                return $query;
            }else{
                // Requête simple
                return $this->db->query($sql);
            }
        }
}