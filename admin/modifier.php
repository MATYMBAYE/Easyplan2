<?php
include_once 'include/head.php';
?>
<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <?php include_once 'include/sidebar.php'; ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <?php include_once 'include/navbar.php'; ?>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <?php
                include_once 'config.php'; // Connexion à la base de données

                // Traitement du formulaire
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifier'])) {
                    $id_e = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
                    $titre = $_POST['titre'];
                    $date_evenement = $_POST['date_evenement'];
                    $description = $_POST['description'];

                    if ($id_e) {
                        $sql = "UPDATE evenements SET titre = :titre, date_evenement = :date_evenement, description = :description WHERE id = :id";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':titre', $titre);
                        $stmt->bindParam(':date_evenement', $date_evenement);
                        $stmt->bindParam(':description', $description);
                        $stmt->bindParam(':id', $id_e, PDO::PARAM_INT);

                        if ($stmt->execute()) {
                            echo "<div class='alert alert-success'>Événement modifié avec succès.</div>";
                            // header("Location: evenements.php");
                            // exit;
                        } else {
                            echo "<div class='alert alert-danger'>Erreur lors de la modification.</div>";
                        }
                    } else {
                        echo "<div class='alert alert-warning'>ID invalide.</div>";
                    }
                }

                // Récupération des données pour affichage du formulaire
                $id_e = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                if ($id_e) {
                    $sql = "SELECT * FROM evenements WHERE id = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':id', $id_e, PDO::PARAM_INT);
                    $stmt->execute();
                    $evenement = $stmt->fetch(PDO::FETCH_OBJ);

                    if (!$evenement) {
                        echo "<div class='alert alert-danger'>Événement introuvable.</div>";
                        exit;
                    }
                } else {
                    // echo "<div class='alert alert-warning'>ID invalide.</div>";
                    exit;
                }
                ?>

                <!-- Formulaire de modification -->
                <form id="eventForm" method="POST" action="modifier.php">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Titre</label>
                            <input type="text" class="form-control" name="titre" value="<?= htmlspecialchars($evenement->titre) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" name="date_evenement" value="<?= $evenement->date_evenement ?>" required>
                        </div>
                        <input type="hidden" name="id" value="<?= $evenement->id ?>">
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3"><?= htmlspecialchars($evenement->description) ?></textarea>
                        </div>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-success mt-3" name="modifier">
                                <i class="bi bi-check-circle me-1"></i> Modifier
                            </button>
                        </div>
                    </div>
                </form>

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include_once 'include/footer.php'; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <?php include_once 'include/script.php'; ?>

</body>
</html>
