<?php

use WebApp2\Database\{Database,PatientPDO,AdminAllUsersPDO,User};
use WebApp2\ObjectManagers\MailManager;
require_once 'vendor/autoload.php';
$invitation_result = "";
$id_array = array();
if($_SESSION['user']->role !== "admin") {
    header("location: index.php?page=user_login");
}

$dbcon = Database::getDb();

//Generate a table
$newPatients = new AdminAllUsersPDO();
$patients = $newPatients->getPatients($dbcon);
//var_dump($patients);

// this will send invitation to patient to review a doctor
if (isset($_POST['review'])){
  //registere the patient's id
  if(!in_array($_POST['patient_id'], $id_array)){
    array_push($id_array,$_POST['patient_id']);
  }
  $userpdo =new User();
  $patient = $userpdo->findUserInfo($dbcon,$_POST['patient_id']) ; // grab the patient info
  $mailManager = new MailManager();
  $invitation_result = $mailManager->sendRequestReview($patient); // send the invitation

}
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>QC/HC - admin dashboard</title>

    <!-- Bootstrap 4.5 CSS -->
    <link rel="stylesheet" href="library/bootstrap/bootstrap.min.css">
    <!-- Style FOR HEADER AND FOOTER -->
    <link rel="stylesheet" href="css/HeaderFooter.css">
    <!-- Style CSS -->
    <link rel="stylesheet" href="css/admin-style/admin_dashboard.css">
    <link rel="stylesheet" href="css/admin-style/admin_sidebar.css">

</head>

<body>
<?php include_once 'header.php'; ?>

<div class="d-lg-flex align-items-stretch w-100">
    <?php include_once 'admin_sidebar.php'; ?>
    <main class="w-100 order-2" id="admin_main">
        <div class="container-fluid">
            <button class="btn btn-secondary my-4" type="button" id="sidebar_nav_btn">Admin Menu</button>

            <div class="card mb-5">
                <h1 class="pl-3 py-2">Patients List</h1>

                <!--List of patients-->
                <div class="p-3 faq-list overflow-auto">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($patients as $p) {
                            $name = $p->firstname.' '.$p->lastname;
                        ?>
                            <tr>
                                <td><?= $p->id; ?></td>
                                <td><?= $name; ?></td>
                                <td><?= $p->username; ?></td>
                                <td><?= $p->email; ?></td>
                                <td>
                                    <form action="index.php?page=admin_patient_update" method="post">
                                        <input type="hidden" name="id" value="<?= $p->id; ?>"/>
                                        <input type="submit" class="button btn btn-info" name="updPatient" value="update"/>
                                    </form>
                                </td>
                                <td>
                                    <form action="index.php?page=admin_patient_delete" method="post">
                                        <input type="hidden" name="id" value="<?= $p->id; ?>"/>
                                        <input type="submit" class="button btn btn-primary" name="dltPatient" value="delete"/>
                                    </form>
                                </td>
                                <td>
                                    <form action="#" method="post">
                                        <input type="hidden" name="patient_id" value="<?= $p->id; ?>"/>
                                        <input type="submit" class="button btn btn-warning" name="review" value="review invitation"/>
                                        <?php if (in_array($p->id,$id_array)): ?>
                                          <span class="invitation-msg"><?= $invitation_result ?></span>
                                        <?php endif; ?>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</div>

<?php include_once 'footer.php'; ?>

<!-- Script Source Files -->

<!-- jQuery -->
<script src="js/jquery-3.5.1.min.js"></script>
<!-- Bootstrap 4.5 JS -->
<script src="js/bootstrap.min.js"></script>
<!-- Popper JS -->
<script src="js/popper.min.js"></script>
<!-- Font Awesome -->
<script src="js/all.min.js"></script>
<!--CUSTOM JS-->
<script type="text/javascript" src="js/admin_sidebar.js"></script>

<!-- End Script Source Files -->


</body>
</html>
