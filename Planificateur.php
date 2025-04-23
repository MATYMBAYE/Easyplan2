<?php class Planificateur { /* Classe gestionnaire */ } ?>

<?php
// listeEvenements.php

session_start();
require_once 'config.php';
require_once 'Evenement.php';

// 1) Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}
$userId = $_SESSION['user_id'];

// 2) Traitement des actions POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id     = intval($_POST['id'] ?? 0);

    if ($action === 'delete' && $id) {
        $ev = Evenement::getById($conn, $id, $userId);
        if ($ev) {
            $ev->delete($conn);
        }
        header('Location: listeEvenements.php');
        exit;
    }

    if ($action === 'update' && $id) {
        $ev = Evenement::getById($conn, $id, $userId);
        if ($ev) {
            $ev->titre          = trim($_POST['titre']);
            $ev->description    = trim($_POST['description']);
            $ev->date_evenement = $_POST['date'];
            // Gestion optionnelle de l'image :
            if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === 0) {
                $targetDir = "uploads/";
                $newName = uniqid() . "_" . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $newName);
                $ev->image = $newName;
            }
            $ev->save($conn);
        }
        header('Location: listeEvenements.php');
        exit;
    }
}

// 3) Récupérer tous les événements de l'utilisateur
$evenements = Evenement::getAllByUser($conn, $userId);

// 4) Si on édite un événement, charger ses données
$editEvent = null;
if (isset($_GET['edit_id'])) {
    $eid = intval($_GET['edit_id']);
    $editEvent = Evenement::getById($conn, $eid, $userId);
}
?>


  <div class="container py-5">

    <h2 class="mb-4">Liste des événements</h2>

    <!-- Formulaire de modification (si on est en mode édition) -->
    <?php if ($editEvent): ?>
      <div class="card mb-4">
        <div class="card-body">
          <h5 class="card-title">Modifier l'événement #<?= $editEvent->id ?></h5>
          <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id" value="<?= $editEvent->id ?>">
            <div class="mb-3">
              <label class="form-label">Titre</label>
              <input type="text"
                     name="titre"
                     class="form-control"
                     value="<?= htmlspecialchars($editEvent->titre) ?>"
                     required>
            </div>
            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea name="description"
                        class="form-control"
                        rows="3"><?= htmlspecialchars($editEvent->description) ?></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Date &amp; heure</label>
              <input type="datetime-local"
                     name="date"
                     class="form-control"
                     value="<?= str_replace(' ', 'T', $editEvent->date_evenement) ?>"
                     required>
            </div>
            <div class="mb-3">
              <label class="form-label">Changer l’image (optionnel)</label>
              <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-save"></i> Enregistrer
            </button>
            <a href="listeEvenements.php" class="btn btn-secondary">
              <i class="bi bi-x-circle"></i> Annuler
            </a>
          </form>
        </div>
      </div>
    <?php endif; ?>

    <!-- Tableau des événements -->
    <table class="table table-striped table-hover">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Titre</th>
          <th>Description</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($evenements as $i => $ev): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($ev->titre) ?></td>
            <td><?= nl2br(htmlspecialchars($ev->description)) ?></td>
            <td><?= htmlspecialchars($ev->date_evenement) ?></td>
            <td>
              <!-- Bouton Modifier -->
              <a href="?edit_id=<?= $ev->id ?>"
                 class="btn btn-sm btn-warning me-1">
                <i class="bi bi-pencil-square"></i>
              </a>
              <!-- Formulaire Supprimer -->
              <form method="post" style="display:inline">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= $ev->id ?>">
                <button type="submit"
                        class="btn btn-sm btn-danger"
                        onclick="return confirm('Supprimer cet événement ?')">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <a href="evenements.php" class="btn btn-success">
      <i class="bi bi-plus-circle"></i> Ajouter un nouvel événement
    </a>
  </div>

 
