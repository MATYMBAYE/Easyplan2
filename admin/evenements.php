
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

  <div class="card p-4">
    <table class="table" id="eventTable">
      <thead class="table-light">
        <tr>
          <th>Titre</th>
          <th>Date</th>
          <th>Jour</th>
          <th>Mois</th>
          <th>Heure début</th>
          <th>Heure fin</th>
          <th>Description</th>
          <th>Statut</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="eventTableBody">
        <!-- Événements dynamiques ici -->
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
        <form id="eventForm">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Titre</label>
              <input type="text" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Date</label>
              <input type="date" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Heure début</label>
              <input type="time" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Heure fin</label>
              <input type="time" class="form-control" required>
            </div>
            <div class="col-12">
              <label class="form-label">Description</label>
              <textarea class="form-control" rows="3"></textarea>
            </div>
            <div class="col-md-6">
              <label class="form-label">Statut</label>
              <select class="form-select">
                <option value="À venir">À venir</option>
                <option value="En cours">En cours</option>
                <option value="Terminé">Terminé</option>
              </select>
            </div>
            <div class="col-12 text-end">
              <button type="submit" class="btn btn-success mt-3">
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
