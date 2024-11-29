<?php
namespace App\Controllers;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/Adult.php'; // Esto puede ser innecesario si usas autoload

use App\Models\Adult; // Importa la clase Adult

class AdultController {
    private $adultModel;

    public function __construct() {
        $this->adultModel = new Adult(); // Ahora se puede encontrar la clase Adult
    }

    public function showList() {
        if (!isset($_SESSION['dni'])) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        $id_usuario = $_SESSION['user_id'];
        $seresQueridos = $this->adultModel->getSeresQueridos($id_usuario);

        require __DIR__ . '/../views/adult/list.php';
    }

    public function showListDevices() {
        if (!isset($_SESSION['dni'])) {
            echo "<p>No has iniciado sesión.</p>";
            echo '<a href="/login" class="btn btn-primary">Iniciar sesión</a>';
            exit;
        }
        $id_usuario = $_SESSION['user_id'];
        $seresQueridosDis = $this->adultModel->showDevicesPerson($id_usuario);
        require __DIR__ . '/../views/dashboard.php';
        return $seresQueridosDis; // Retorna la lista de dispositivos
    }

    public function registerAdultoMayor() {
        if (!isset($_SESSION['dni'])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'No has iniciado sesión.'
            ]);
            exit;
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $ad_dni = isset($_POST['dni']) ? $_POST['dni'] : null;
            $ad_nombres = isset($_POST['nombres']) ? $_POST['nombres'] : null;
            $ad_apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : null;
            $ad_email = isset($_POST['email']) ? $_POST['email'] : null;
            $ad_telefono = isset($_POST['telefono']) ? $_POST['telefono'] : null;
            $ad_departamento = isset($_POST['departamento']) ? $_POST['departamento'] : null;
            $ad_provincia = isset($_POST['provincia']) ? $_POST['provincia'] : null;
            $ad_ciudad = isset($_POST['ciudad']) ? $_POST['ciudad'] : null;
            $ad_direccion = isset($_POST['direccion']) ? $_POST['direccion'] : null;
            $ad_sexo = isset($_POST['sexo']) ? $_POST['sexo'] : null;
            $ad_estatura = isset($_POST['estatura']) ? $_POST['estatura'] : null;
            $ad_fecha_nacimiento = isset($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : null;
            $ad_tipo_de_sangre  = isset($_POST['tipo_de_sangre']) ? $_POST['tipo_de_sangre'] : null;
            $ad_padecimientos = isset($_POST['padecimientos']) ? $_POST['padecimientos'] : null;

            $ad_responsable_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

            if ($ad_dni && $ad_nombres && $ad_apellidos && $ad_email && $ad_telefono && $ad_departamento && $ad_provincia && $ad_ciudad && $ad_direccion && $ad_sexo && $ad_estatura && $ad_fecha_nacimiento && $ad_tipo_de_sangre && $ad_padecimientos && $ad_responsable_id) {
                $result = $this->adultModel->insertOlderAdult($ad_dni, $ad_nombres, $ad_apellidos, $ad_email, $ad_telefono, $ad_departamento, $ad_provincia, $ad_ciudad, $ad_direccion, $ad_sexo, $ad_estatura, $ad_fecha_nacimiento, $ad_tipo_de_sangre, $ad_padecimientos, $ad_responsable_id);

                if ($result) {
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Adulto mayor registrado correctamente.'
                    ]);
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Faltan datos.'
                    ]);
                }
            }
        }
    }

}