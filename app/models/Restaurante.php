<?php
// Path: app/models/Restaurante.php

class Restaurante implements JsonSerializable {
    private $idRestaurante;
    private $nombre;
    private $direccion;
    private $tipoComida;
    private $rangoPrecios;
    private $horarioApertura;
    private $horarioCierre;
    private $ubicacion;
    private $descripcion;
    private $telefono;
    private $imagen;
    private $platos;

    // Constructor
    public function __construct(
        $idRestaurante, $nombre, $direccion, $tipoComida, $rangoPrecios, 
        $horarioApertura, $horarioCierre, $ubicacion, $descripcion, $telefono, $imagen
    ) {
        $this->idRestaurante = $idRestaurante;
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->tipoComida = $tipoComida;
        $this->rangoPrecios = $rangoPrecios;
        $this->horarioApertura = $horarioApertura;
        $this->horarioCierre = $horarioCierre;
        $this->ubicacion = $ubicacion;
        $this->descripcion = $descripcion;
        $this->telefono = $telefono;
        $this->imagen = $imagen;
        $this->platos = [];
    }
        public function jsonSerialize() {
            return [
                'idRestaurante' => $this->getIdRestaurante(),
                'nombre' => $this->getNombre(),
                'direccion'=> $this->direccion,
                'tipoComida'=> $this->tipoComida,
                'rangoPrecios'=> $this->rangoPrecios,
                'horarioApertura'=> $this->horarioApertura,
                'horarioCierre'=> $this->horarioCierre,
                'ubicacion'=> $this->ubicacion,
                'descripcion'=> $this->descripcion,
                'telefono'=> $this->telefono,
                'imagen'=> $this->imagen,
                'estaAbierto' => $this->estaAbierto(),
                'platillos' => $this->getPlatos(),
            ];
        }

    public function getIdRestaurante() {
        return $this->idRestaurante;
    }

    public function setIdRestaurante($idRestaurante) {
        $this->idRestaurante = $idRestaurante;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function getTipoComida() {
        return $this->tipoComida;
    }

    public function setTipoComida($tipoComida) {
        $this->tipoComida = $tipoComida;
    }

    public function getRangoPrecios() {
        return $this->rangoPrecios;
    }

    public function setRangoPrecios($rangoPrecios) {
        $this->rangoPrecios = $rangoPrecios;
    }

    public function getHorarioApertura() {
        return $this->horarioApertura;
    }

    public function setHorarioApertura($horarioApertura) {
        $this->horarioApertura = $horarioApertura;
    }

    public function getHorarioCierre() {
        return $this->horarioCierre;
    }

    public function setHorarioCierre($horarioCierre) {
        $this->horarioCierre = $horarioCierre;
    }

    public function getUbicacion() {
        return $this->ubicacion;
    }

    public function setUbicacion($ubicacion) {
        $this->ubicacion = $ubicacion;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function getImagen() {
        return $this->imagen;
    }

    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    // Métodos para agregar y obtener platos
    public function addPlato(Plato $plato) {
        $this->platos[] = $plato;
    }

    public function getPlatos() {
        return $this->platos;
    }

    public function getHorarioAperturaFormateado() {
        // Formatea el horario de apertura a 12 horas
        $horaApertura = DateTime::createFromFormat('H:i:s', $this->horarioApertura);
        return $horaApertura->format('h:i A');
    }

    public function getHorarioCierreFormateado() {
        // Formatea el horario de cierre a 12 horas
        $horaCierre = DateTime::createFromFormat('H:i:s', $this->horarioCierre);
        return $horaCierre->format('h:i A');
    }

    public function estaAbierto() {
        $horaActual = new DateTime('now', new DateTimeZone('America/Bogota'));
        $horarioApertura = DateTime::createFromFormat('H:i:s', $this->horarioApertura);
        $horarioCierre = DateTime::createFromFormat('H:i:s', $this->horarioCierre);
    
        return ($horaActual >= $horarioApertura && $horaActual <= $horarioCierre);
    }

}
?>