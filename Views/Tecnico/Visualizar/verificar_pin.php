<?php
require_once "../../../Config/conexion.php";

$DataBase = new Database;
$con = $DataBase->conectar();

$response = ['success' => false];

if(isset($_POST['pin']) && isset($_POST['documento'])) {
    $pin = $_POST['pin'];
    $documento = $_POST['documento'];

    $stmt = $con->prepare("SELECT pin FROM usuario WHERE documento = :documento");
    $stmt->bindParam(':documento', $documento, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if($result && $result['pin'] == $pin) {
        $response['success'] = true;
    }
}

echo json_encode($response);
?>
