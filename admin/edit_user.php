<?php

include "../connect.php";

session_start();
$session = session_id();

if (empty($_SESSION)) {
    header("Location: index.php");
}

$id = $_GET["id"];

$query = $conn->prepare("SELECT * FROM user WHERE id = $id");
$query->execute();

$result = $query->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    header("Location: user_list.php");
} else {
    $email = $result["email"];
    $username = $result["username"];
    
    switch($result["role"]) {
        case "0":
            $role = "User";
            break;
        case "1":
            $role = "Store Owner";
            break;
        case "2":
            $role = "Admin";
            break;
        default:
            $role = "User";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/signin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<main class="form-signin w-100 m-auto">
        <form method="post" action="">
                <h1 class="text-center h3 mb-3 fw-normal">Edit User</h1>

                <div class="form-floating">
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" disabled>
                    <label for="email"><?php echo $email; ?></label>
                </div>
                <div class="form-floating">
                    <input type="text" class="form-control" placeholder="name" name="username" id="username" required>
                    <label for="username"><?php echo $username; ?></label>
                </div>
                <div class="form-floating">
                    <select class="form-select" id="role" name="role">
                        <option value="0">User</option>
                        <option value="1">Store Owner</option>
                        <option value="2">Admin</option>
                    </select>
                    <label for="role">Role: <?php echo $role; ?></label>
                </div>

                <button class="w-100 btn mt-2 btn-lg btn-danger" name="delete" type="submit">Delete</button>
                <button class="w-100 btn mt-1 btn-lg btn-primary" name="save" type="submit">Save</button>
            </form>
        </main>
</body>
</html>

<?php

include "../connect.php";

if (isset($_POST["save"])) {
    $query = $conn->prepare("UPDATE user SET username=?, role=? WHERE id = $id");
    $query->execute([$_POST["username"], $_POST["role"]]);
}

if (isset($_POST["delete"])) {
    $query = $conn->prepare("DELETE FROM user WHERE id = $id");
    $query->execute();
}