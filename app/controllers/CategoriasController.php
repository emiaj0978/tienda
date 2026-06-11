<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Categoria.php';

class CategoriasController extends Controller {

    public function index(): void {
        $this->reporte();
    }

    // ================= LISTAR =================
    public function reporte(): void {

        if (!isset($_SESSION['usuario'])) {
            header("Location: " . BASE_URL . "/login");
            exit();
        }

        $this->soloSuperAdmin();

        $categoria = new Categoria();
        $categorias = $categoria->obtenerCategorias();

        $this->view('categorias/reportes', [
            'usuario'    => $_SESSION['usuario'],
            'categorias' => $categorias
        ]);
    }

    public function reportes(): void {
        $this->reporte();
    }

    // ================= ELIMINAR =================
    public function eliminar(): void {

        $id = $_POST['id'];

        $categoria = new Categoria();
        $resultado = $categoria->eliminarCategoria($id);

        header('Content-Type: application/json');
        echo json_encode(['eliminar' => $resultado]);
    }

    // ================= REGISTRO =================
    public function registro(): void {

        if (!isset($_SESSION['usuario'])) {
            header("Location: " . BASE_URL . "/login");
            exit();
        }

        $this->view('categorias/registro', [
            'usuario' => $_SESSION['usuario']
        ]);
    }

    // ================= EDITAR =================
    public function editar(): void {

        $categoria = new Categoria();

        $resultado = $categoria->editarCategoria([
            'IDcategoria'      => $_POST['IDcategoria'],
            'nombre_categoria' => $_POST['nombre_categoria'],
            'descripcion'      => $_POST['descripcion']
        ]);

        header('Content-Type: application/json');
        echo json_encode(['ok' => $resultado]);
    }

    // ================= GUARDAR =================
    public function guardar(): void {

        $categoria = new Categoria();

        $resultado = $categoria->guardarCategoria([
            'nombre_categoria' => $_POST['nombre_categoria'],
            'descripcion'      => $_POST['descripcion']
        ]);

        if ($resultado) {
            header('Location: ' . BASE_URL . '/categorias/reportes');
        } else {
            header('Location: ' . BASE_URL . '/categorias/registro');
        }
    }
}