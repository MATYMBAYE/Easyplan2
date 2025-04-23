

<?php
session_start();
require_once 'config.php';

// 1) Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}
$userId = $_SESSION['user_id'];

// 2) Charger les infos actuelles
$stmt = $conn->prepare("SELECT nom, email FROM utilisateurs WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// 3) Traitement du formulaire de mise à jour
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom   = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $pwd   = $_POST['password'] ?? '';

    // Mettre à jour le nom et l'email
    $stmt = $conn->prepare("UPDATE utilisateurs SET nom = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $nom, $email, $userId);
    $ok1 = $stmt->execute();

    // Si l'utilisateur a saisi un nouveau mot de passe, on le hash et on l'enregistre
    if ($pwd !== '') {
        $hash = password_hash($pwd, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE utilisateurs SET mot_de_passe = ? WHERE id = ?");
        $stmt->bind_param("si", $hash, $userId);
        $ok2 = $stmt->execute();
    } else {
        $ok2 = true;
    }

    if ($ok1 && $ok2) {
        $message = 'Profil mis à jour avec succès !';
        // Recharger les infos
        $stmt = $conn->prepare("SELECT nom, email FROM utilisateurs WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
    } else {
        $message = 'Une erreur est survenue, veuillez réessayer.';
    }
}
?>


<?php
    include_once 'include/head.php' ;
?>
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
                <?php
                          include_once 'include/sidebar.php' ;
                 ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                include_once 'include/navbar.php';
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                  
                    
  <div class="container py-5">
    <h2 class="mb-4"><i class="bi bi-person-circle"></i> Mon profil</h2>

    <?php if ($message): ?>
      <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post" class="card p-4 shadow-sm bg-white" style="max-width: 500px;">
      <div class="mb-3">
        <label for="nom" class="form-label">Nom</label>
        <input type="text" id="nom" name="nom" class="form-control"
               value="<?= htmlspecialchars($user['nom']) ?>" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Adresse email</label>
        <input type="email" id="email" name="email" class="form-control"
               value="<?= htmlspecialchars($user['email']) ?>" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Nouveau mot de passe <small>(laisser vide pour conserver)</small></label>
        <input type="password" id="password" name="password" class="form-control">
      </div>
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> Enregistrer les changements
      </button>
      <a href="index.html" class="btn btn-secondary ms-2">
        <i class="bi bi-arrow-left-circle"></i> Retour
      </a>
    </form>
  </div>


                    
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
          <?php
          include_once 'include/footer.php';
          ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
     <?php
     include_once 'include/script.php';
     ?>
   
</body>

</html>
