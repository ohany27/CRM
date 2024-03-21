<?php
include("../../Config/validarSesion.php");
require_once("../../Config/conexion.php");
$Conexion = new Database;
$con = $Conexion->conectar();

// Assign PDO object to $pdo
$pdo = $con;

// Inicializar mensaje de error
$error = '';

// Verificar si se ha enviado el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $documento = $_POST["documento"];
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $password = $_POST["password"];
    $pin = $_POST["pin"];
    $telefono = $_POST["telefono"];
    $direccion = $_POST["direccion"];
    $nitc = $_POST["nitc"];
    $id_tip_usu = $_POST["id_tip_usu"];

    // Validar campos obligatorios
    if (empty($documento) || empty($nombre) || empty($correo) || empty($password) || empty($pin) || empty($telefono) || empty($direccion) || empty($nitc) || empty($id_tip_usu)) {
        echo "<script>alert('Todos los campos son obligatorios.')</script>";
    } else {
        // Verificar si ya existe un usuario con el mismo correo, pin o documento
        $query = "SELECT * FROM usuario WHERE correo = :correo OR pin = :pin OR documento = :documento";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array(':correo' => $correo, ':pin' => $pin, ':documento' => $documento));

        // Si se encuentra algún registro, mostrar un mensaje de error
        if ($stmt->rowCount() > 0) {
            echo "<script>alert('Correo existente o pin')</script>";
        } else {
            // Si no hay registros duplicados, insertar el nuevo usuario
            // Encriptar la contraseña antes de insertarla en la base de datos
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $query_insert_user = "INSERT INTO usuario (documento, nombre, correo, password, pin, telefono, direccion, nitc, id_tip_usu) 
                                VALUES (:documento, :nombre, :correo, :password, :pin, :telefono, :direccion, :nitc, :id_tip_usu)";
            $stmt_insert_user = $pdo->prepare($query_insert_user);
            $stmt_insert_user->execute(
                array(
                    ':documento' => $documento,
                    ':nombre' => $nombre,
                    ':correo' => $correo,
                    ':password' => $hashed_password,
                    ':pin' => $pin,
                    ':telefono' => $telefono,
                    ':direccion' => $direccion,
                    ':nitc' => $nitc,
                    ':id_tip_usu' => $id_tip_usu
                )
            );

            // Mostrar alerta de registro exitoso
            echo "<script>alert('Usuario creado'); window.location='../Visualizar/usuarios.php';</script>";
            exit();
        }
    }
}
?>

<?php include "../Template/header.php"; ?>
<form class="row g-3 needs-validation" method="post" novalidate>
    <div class="col-12">
        <label class="form-label" for="documento">Documento</label>
        <input type="number" id="documento" name="documento" class="form-control" id="yourName" minlength="9" required>
        <div class="invalid-feedback">Por Favor, ingrese su Documento!</div>
    </div>
    <div class="col-12">
        <label class="form-label" for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" class="form-control" id="yourName" required>
        <div class="invalid-feedback">Por Favor, ingrese su Nombre!</div>
    </div>
    <div class="col-12">
        <label class="form-label" for="nombre">Correo</label>
        <input type="email" id="correo" name="correo" class="form-control" id="yourName" required>
        <div class="invalid-feedback">Por Favor, ingrese su Correo!</div>
    </div>
    <div class="col-12">
        <label class="form-label" for="password">Contraseña</label>
        <input type="password" id="password" name="password" class="form-control" id="yourName"
            pattern="^(?=.*\d)(?=.*[a-zA-Z]).{5,}$" required>
        <div class="invalid-feedback">Por Favor, ingrese su Contraseña!</div>
    </div>
    <div class="col-12">
        <label class="form-label" for="pin">Pin</label>
        <input type="number" id="pin" name="pin" class="form-control" id="yourName" pattern="\d{5,}" required>
        <div class="invalid-feedback">Por Favor, ingrese su Pin!</div>
    </div>
    <div class="col-12">
        <label class="form-label" for="telefono">Telefono</label>
        <input type="number" id="telefono" name="telefono" class="form-control" id="yourName" required>
        <div class="invalid-feedback">Por Favor, ingrese su Telefono!</div>
    </div>
    <div class="col-12">
        <label class="form-label" for="direccion">Dirección</label>
        <input type="text" id="direccion" name="direccion" class="form-control" id="yourName" required>
        <div class="invalid-feedback">Por Favor, ingrese su Dirección!</div>
    </div>
    <label for="nitc">
        <select id="nitc" name="nitc" placeholder="Nitc:" required>
            <option value="">Seleccione_Empresa</option>
            <?php
            // Obtener las empresas
            $query_empresas = "SELECT * FROM empresa";
            $stmt_empresas = $con->query($query_empresas);
            while ($row_empresas = $stmt_empresas->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . $row_empresas['nitc'] . "'>" . $row_empresas['nombre'] . "</option>";
            }
            ?>
        </select>
    </label>
    <label for="id_tip_usu">
        <select id="id_tip_usu" name="id_tip_usu" placeholder="rol:" required>
            <option value="">Seleccione_Rol</option>
            <?php
            // Obtener los roles
            $query_roles = "SELECT * FROM roles";
            $stmt_roles = $con->query($query_roles);
            while ($row_roles = $stmt_roles->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . $row_roles['id_tip_usu'] . "'>" . $row_roles['tip_usu'] . "</option>";
            }
            ?>
        </select>
    </label>
    <button class="btn btn-primary w-100" type="submit">Registrarse</button>
</form>

<?php include "../Template/footer.php"; ?>