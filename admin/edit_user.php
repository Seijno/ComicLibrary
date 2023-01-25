<?php

include "../connect.php";

// if session is not started, start session
if (!isset($_SESSION)) {
    session_start();
}
// if user is not an admin, redirect to login page
if (!isset($_SESSION['id']) || $_SESSION['role'] != 1) {
    header("Location: ../login.php");
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
    $_SESSION['user_li']['role'] = $result["role"];
    
    switch($result["role"]) {
        case "0":
            $role = "User";
            break;
        case "1":
            $role = "Admin";
            break;
        case "2":
            $role = "Store Owner";
            break;
        default:
            $role = "User";
    }
}

function get_stores() {
    include "../connect.php";
    $query = $conn->prepare("SELECT * FROM store");
    $query->execute();

    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    $stores = "<select name='store' class='form-select'>";
    $stores .= "<option selected>Select a store</option>";
    foreach ($result as $store) {
        $stores .= "<option value='" . $store["id"] . "'>" . $store["name"] . "</option>";
    }
    $stores .= "</select>";
    return $stores;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                        <option value="0" <?php if($_SESSION['user_li']['role'] == '0'): ?> selected="selected"<?php endif; ?>>User</option>
                        <option value="1" <?php if($_SESSION['user_li']['role'] == '1'): ?> selected="selected"<?php endif; ?>>Admin</option>
                        <option value="2" <?php if($_SESSION['user_li']['role'] == '2'): ?> selected="selected"<?php endif; ?>>Store Owner</option>

                    </select>
                    <label for="role">Role: <?php echo $role; ?></label>
                </div>
                <div id="store">
                    
                </div>

                <button class="w-100 btn mt-2 btn-lg btn-danger" name="delete" type="submit">Delete</button>
                <button class="w-100 btn mt-1 btn-lg btn-primary" name="save" type="submit">Save</button>
            </form>
        </main>

        <script>
            var role_select = document.getElementById("role");
            var store_select = document.getElementById("store")
            
            // when first loaded, if store owner role is selected, show store select box
            if (role_select.value == 2) {
                store_select.innerHTML = "<?php echo get_stores(); ?>";
            }

            // when select changed, if store owner role is selected, show store select box
            role_select.addEventListener("change", function() {
                
                if (this.value == 2) {
                    store_select.innerHTML = "<?php echo get_stores(); ?>";
                } else {
                    store_select.innerHTML = "";
                }
            });
        </script>
</body>

</html>

<?php

include "../connect.php";

if (isset($_POST["save"])) {
    $query = $conn->prepare("UPDATE user SET username=?, role=? WHERE id = $id");
    $query->execute([$_POST["username"], $_POST["role"]]);

    // if role is store owner, update store owner id
    if ($_POST["role"] == 2) {
        $query = $conn->prepare("UPDATE store SET owner_id=? WHERE id = ?");
        $query->execute([$id, $_POST["store"]]);
    }

    // redirect to user list page
    header("Location: user_list.php");
}

if (isset($_POST["delete"])) {
    $query = $conn->prepare("DELETE FROM user WHERE id = $id");
    $query->execute();
}