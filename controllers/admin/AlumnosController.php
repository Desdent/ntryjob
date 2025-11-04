<?php
require_once __DIR__ . '/../../models/Alumno.php';

class AlumnosController {
    
    /**
     * GET - Listar todos los alumnos
     */
    public function index() {
        try {
            $alumnos = Alumno::getAll();
            echo json_encode(['success' => true, 'data' => $alumnos]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
    /**
     * POST - Crear alumno
     */
    public function create() {
        try {
            $data = json_decode(file_get_contents('php://input'), true); //Lee el cuerpo en raw de la peticion(get/post/etc), la cual se recibe a traves mediante el php input
                                                                        // El true es para que devuelva un array en vez de un objeto. Sin true es$data->nombre y con true es $data['nombre']
                //Recordar que llega en texto raw con formato de texto json PERO no en formato json, y json decode lo que hace es decodificar ese string en formato de texto json en uyn array asoc.


            // Validaciones básicas
            if (empty($data['nombre']) || empty($data['email']) || empty($data['password'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Campos requeridos faltantes']);
                return;
            }
            
            $id = Alumno::create($data);
            echo json_encode(['success' => true, 'id' => $id]);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
    /**
     * PUT - Actualizar alumno
     */
    public function update() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (empty($data['id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'ID requerido']);
                return;
            }
            
            $result = Alumno::update($data['id'], $data);
            echo json_encode(['success' => true, 'updated' => $result]);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
    /**
     * DELETE - Eliminar alumno
     */
    public function delete() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (empty($data['id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'ID requerido']);
                return;
            }
            
            $result = Alumno::delete($data['id']);
            echo json_encode(['success' => true, 'deleted' => $result]);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
