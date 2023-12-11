<?php
// Path: app/models/Plato.php

class Plato {
    private $idPlato;
    private $nombre;
    private $descripcion;
    private $precio;
    private $imagen;

    // Constructor
    public function __construct($idPlato, $nombre, $descripcion, $precio, $imagen) {
        $this->idPlato = $idPlato;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->imagen = $imagen;
    }

    // Getters y setters
    public function getIdPlato() {
        return $this->idPlato;
    }
    
    public function setIdPlato($idPlato) {
        $this->idPlato = $idPlato;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function getImagen() {
        return $this->imagen;
    }

    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }
}
?>