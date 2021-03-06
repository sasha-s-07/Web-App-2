<?php

 

use WebApp2\Database\{Database,User};

require_once 'vendor/autoload.php';

$r = new User();
$db = Database::getDb();
$roles = $r->getUserRoles($db);

if (isset($_POST['submit'])) {
    $fname = $_POST['f_name'];
    $lname = $_POST['l_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = $_POST['password'];

    $db = Database::getDb();
    $u = new User();
    $user = $u->addUser($fname, $lname, $username, $email, $password, $role, $db);

    if (isset($user)) {
        header("Location: index.php?page=confirmAdd");
    } else {
        echo "Error Adding User!";
    }
}


?>
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP Query Crew - Health Clinic</title>

    <!-- Bootstrap 4.5 CSS -->
    <link rel="stylesheet" href="library/bootstrap/bootstrap.min.css">
    <!-- Style CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Style FOR HEADER AND FOOTER -->
    <link rel="stylesheet" href="css/HeaderFooter.css">


</head>
   <?php

            include_once 'header.php';
            ?>
<section>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-8 col-xl-6">
                <div class="row">
                    <div class="col text-center">
                        <h1>Admin/User/Patient Registration</h1>
                        <p class="text-h3">Register with us today & let's start the road to recovery.</p>
                    </div>
                </div>
                <form name="addUser" method="post" action="">
                    <div class="form-group">
                        <label for="role">Role: </label>
                        <select  name="role" class="form-control" id="role" >
                            <?php foreach ($roles as $role) {
                                $select = "";
                                $selected = $select == $role->type? "selected" : "";?>
                                <option <?=$selected?> value="<?=$role->id?>"> <?= $role->type?></option>

                            <?php } ?>
                        </select>
                        <span style="color: #ff0000">
                            </span>
                    </div>
                    <div class="row align-items-center">
                        <div class="col mt-4">
                            <input type="text" name="f_name" id="f_name" class="form-control" placeholder="First name...">
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col mt-4">
                            <input type="text" name="l_name" id="l_name" class="form-control" placeholder="Last name...">
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col mt-4">
                            <input type="text" name="username" id="username" class="form-control" placeholder="Username..">
                        </div>
                    </div>

                    <div class="row align-items-center mt-4">
                        <div class="col">
                            <input type="text" name="email" id="email" class="form-control" placeholder="Email">
                        </div>
                    </div>
                    <div class="row align-items-center mt-4">
                        <div class="col">
                            <input type="password" name="password" id="password"class="form-control" placeholder="Password">
                        </div>
                        <div class="col">
                            <input type="password"  name="confirmPassword" class="form-control" placeholder="Confirm Password">
                        </div>
                    </div>

                    <div class="row justify-content-start mt-4">
                        <div class="col">


                            <button class="btn btn-primary mt-4" name="submit">Submit</button>
                        </div>
                    </div>

                </form>


            </div>
        </div>
    </div>
</section>
<?php

require_once 'footer.php';
?>

?>
<!-- Script Source Files -->
<script src="js/addUser_validation.js"></script>

<!-- jQuery -->
<script src="js/jquery-3.5.1.min.js"></script>
<!-- Bootstrap 4.5 JS -->
<script src="js/bootstrap.min.js"></script>
<!-- Popper JS -->
<script src="js/popper.min.js"></script>
<!-- Font Awesome -->
<script src="js/all.min.js"></script>

<!-- End Script Source Files -->
