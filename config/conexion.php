<?php 
class Conexion
{
    private $host = 'localhost';
    private $usuario = 'root';
    private $password = '';
    private $base_datos = 'sistema_ventas';
    private $conexion;
    private static $instancia = null;

    private function __construct()
    {
        $this->conexion = new mysqli($this->host, $this->usuario, $this->password, $this->base_datos);
        if ($this->conexion->connect_error) {
            die("Error en la conexión: " . $this->conexion->connect_error);
        }
    }

    public static function getInstancia()
    {
        if (self::$instancia === null) {
            self::$instancia = new self();
        }
        return self::$instancia;
    }

    public function consultaSimple($query)
    {
        if (!$this->conexion->query($query)) {
            throw new Exception("Error en la consulta: " . $this->conexion->error);
        }
    }

    public function consultaRetorno($query)
    {
        $resultado = $this->conexion->query($query);
        if (!$resultado) {
            throw new Exception("Error en la consulta: " . $this->conexion->error);
        }
        return $resultado;
    }

    public function consultaPreparada($query, $tipos, ...$parametros)
    {
        $stmt = $this->conexion->prepare($query);
        if (!$stmt) {
            throw new Exception("Error preparando la consulta: " . $this->conexion->error);
        }
        $stmt->bind_param($tipos, ...$parametros);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function liberarResultado($resultado)
    {
        if ($resultado) {
            $resultado->free();
        }
    }

    public function cerrarConexion()
    {
        if ($this->conexion) {
            $this->conexion->close();
        }
    }

    private function __clone() {}
    private function __wakeup() {}
}
