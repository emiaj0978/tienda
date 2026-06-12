<?php
require_once __DIR__ . '/../core/Controller.php';
class RegistrosController extends Controller {

    public function index(): void {
        $this->view('asistencias/index');
    }
    public function buscar(): void{
        require_once __DIR__ . '/../models/Producto.php';
        $qrs = $_POST['qrs'];
        $producto = new Producto();
        $resultado = $producto->buscarPorQr($qrs);
        header('Content-Type: application/json');
        if($resultado){
            echo json_encode([
                'encontrado' => true,
                'producto' => $resultado
            ]);
        }else{
            echo json_encode([
                'encontrado' => false
            ]);
        }
    }

    public function registradito(): void{
        require_once __DIR__ . '/../models/Registros.php';
        $idProducto = $_POST['id_producto'];
        $asistencia = new Registros();
        $asistencia->registrar($idProducto);
        header('Content-Type: application/json');
        echo json_encode([
            'registrado' => true
        ]);
    }

    public function guardarVenta(): void{
        require_once __DIR__ . '/../models/Registros.php';
        $productos = json_decode(
        file_get_contents("php://input"),
        true
    );

    $asistencia = new Registros();
        foreach($productos as $producto){
        $asistencia->registrar(
        $producto['IDproducto']
        );

    }
    header('Content-Type: application/json');
    echo json_encode([
        'registrado' => true
    ]);
    }
    
}