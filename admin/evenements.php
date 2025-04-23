
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
                    <div class="content">
  <h2 class="mb-4"><i class="bi bi-calendar-event me-2"></i>Gestion des Événements</h2>

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>📅 Événements programmés</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eventModal">
      <i class="bi bi-plus-circle me-1"></i> Ajouter un événement
    </button>
  </div>
  <?php
    include_once 'config.php' ;
    $sql = "SELECT * FROM evenements";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    // var_dump($stmt);die();

    // Récupération des résultats sous forme d'objets
    $evenements = $stmt->fetchAll(PDO::FETCH_OBJ);
   


    if(isset($_POST['ajouter'])){
      $titre = $_POST['titre'];
      $description = $_POST['description'];
      $date_evenement =  $_POST['date_evenement'];
      // var_dump($_POST);die();

      // Requête préparée
   $sql = "INSERT INTO evenements (titre, date_evenement, description) 
            VALUES (:titre, :date_evenement, :description)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':date_evenement', $date_evenement);
    $stmt->bindParam(':description', $description);
    

    // Exécution
    if ($stmt->execute()) {
        echo "Événement ajouté avec succès !";
    } else {
        echo "Erreur lors de l'ajout.";
    }
    }


?>

  <div class="card p-4">
    <table class="table text-center" id="eventTable">
      <thead class="table-light">
        <tr>
          <th>Titre</th>
          <th>Heure de creation</th>
          <th>Description</th>
          <th >Actions</th>
        </tr>
      </thead>
      <tbody id="eventTableBody">
        <?php  foreach($evenements as $evenement): ?>
          <tr>
            <td><?= $evenement->titre ?></td>
            <td><?= $evenement->date_evenement ?></td>
            <td><?= $evenement->description ?></td>
            <td class="row">
                <td class="col-6 btn btn-primary btn-sm" >   
                      <a class="text-decoration-none text-light" href="modifier.php?id=<?= $evenement->id ?>">Modifier</a>
                </td>
                <td class="col-6 btn btn-danger btn-sm">supprimer</td>
            </td>
         </tr>  
        <?php endforeach ; ?>
      </tbody>
    </table>
  </div>

  <div id="calendar"></div>
</div>

<!-- Modal Ajouter Événement -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title">Ajouter un événement</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="eventForm" method="POST" action="evenements.php">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Titre</label>
              <input type="text" class="form-control" name="titre" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Date</label>
              <input type="date" class="form-control" name="date_evenement" required>
            </div>
            <!-- <div class="col-md-6">
              <label class="form-label">Heure début</label>
              <input type="time" class="form-control" required>
            </div> -->
            <!-- <div class="col-md-6">
              <label class="form-label">Heure fin</label>
              <input type="time" class="form-control" required>
            </div> -->
            <div class="col-12">
              <label class="form-label">Description</label>
              <textarea class="form-control"  name="description" rows="3"></textarea>
            </div>
            <!-- <div class="col-md-6">
              <label class="form-label">Statut</label>
              <select class="form-select">
                <option value="À venir">À venir</option>
                <option value="En cours">En cours</option>
                <option value="Terminé">Terminé</option>
              </select>
            </div> -->
            <div class="col-12 text-end">
              <button type="submit" class="btn btn-success mt-3" name="ajouter">
                <i class="bi bi-check-circle me-1"></i> Enregistrer
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
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
