<?php
    namespace App\Controllers;

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require_once __DIR__ . '/../models/Device.php';

    use App\Models\Device;

    class DeviceController
    {
        private $deviceModel;

        public function __construct()
        {
            $this->deviceModel = new Device();
        }

        public function enlazarDispositivo() {
            if (!isset($_SESSION['dni'])) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No has iniciado sesión.'
                ]);
                exit;
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $dispositivo_id = $_POST['dispositivo_id'] ?? null;
                $alias = $_POST['alias'] ?? null;
                $adulto_mayor_id = $_POST['adulto_id'] ?? null;
                $responsable_id = $_SESSION['user_id'] ?? null;

                // Depuración: Verifica los datos recibidos
                error_log("Datos recibidos: " . print_r($_POST, true));

                if ($dispositivo_id && $alias && $adulto_mayor_id) {
                    $result = $this->deviceModel->enlazarDispositivo($dispositivo_id, $alias, $adulto_mayor_id, $responsable_id);
                    if ($result) {
                        echo json_encode([
                            'status' => 'success',
                            'message' => 'Dispositivo enlazado correctamente.'
                        ]);
                    } else {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Error al enlazar dispositivo.'
                        ]);
                    }
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Faltan datos.'
                    ]);
                }
            }
        }
    }