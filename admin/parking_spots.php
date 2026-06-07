<?php include '../includes/header.php'; ?>
<?php
require_once '../classes/ParkingSpot.php';

if (!$session->isAdmin()) {
    header('Location: ../login.php');
    exit;
}

$parkingSpot = new ParkingSpot();
$message = '';
$error = '';
$editSpot = null;

if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    if ($parkingSpot->hasReservations($id)) {
        $error = 'Parking mesto ima rezervacije i ne može biti obrisano.';
    } else {
        if ($parkingSpot->delete($id)) {
            $message = 'Parking mesto je uspešno obrisano.';
        } else {
            $error = 'Greška prilikom brisanja parking mesta.';
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['form_type'] == 'add') {
        if ($parkingSpot->create($_POST)) {
            $message = 'Parking mesto je uspešno dodato.';
        } else {
            $error = 'Greška prilikom dodavanja parking mesta.';
        }
    }

    if ($_POST['form_type'] == 'edit') {
        if ($parkingSpot->update($_POST['id'], $_POST)) {
            $message = 'Parking mesto je uspešno izmenjeno.';
        } else {
            $error = 'Greška prilikom izmene parking mesta.';
        }
    }
}

if (isset($_GET['edit'])) {
    $result = $parkingSpot->read($_GET['edit']);
    if ($result && mysqli_num_rows($result) == 1) {
        $editSpot = mysqli_fetch_assoc($result);
    }
}

$spots = $parkingSpot->readAll();
?>
<?php include '../includes/navbar.php'; ?>

<main class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h1>Upravljanje parking mestima</h1>
            <p class="text-secondary mb-0">Dodavanje, izmena i brisanje parking mesta.</p>
        </div>
        <a href="dashboard.php" class="btn btn-outline-light">Nazad na admin panel</a>
    </div>

    <?php if ($message != ''): ?>
        <div class="alert alert-success"><?php echo $message; ?></div>
    <?php endif; ?>

    <?php if ($error != ''): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card app-card p-4">
                <?php if ($editSpot): ?>
                    <h3 class="mb-3">Izmena parking mesta</h3>
                    <form method="POST" action="parking_spots.php">
                        <input type="hidden" name="form_type" value="edit">
                        <input type="hidden" name="id" value="<?php echo $editSpot['id']; ?>">
                        <div class="mb-3">
                            <label class="form-label">Oznaka mesta</label>
                            <input type="text" name="spot_number" class="form-control" value="<?php echo $editSpot['spot_number']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="slobodno" <?php if ($editSpot['status'] == 'slobodno') echo 'selected'; ?>>slobodno</option>
                                <option value="zauzeto" <?php if ($editSpot['status'] == 'zauzeto') echo 'selected'; ?>>zauzeto</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cena po satu</label>
                            <input type="number" name="price_per_hour" class="form-control" value="<?php echo $editSpot['price_per_hour']; ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Sačuvaj izmene</button>
                        <a href="parking_spots.php" class="btn btn-outline-light w-100 mt-2">Otkaži</a>
                    </form>
                <?php else: ?>
                    <h3 class="mb-3">Dodaj parking mesto</h3>
                    <form method="POST" action="parking_spots.php">
                        <input type="hidden" name="form_type" value="add">
                        <div class="mb-3">
                            <label class="form-label">Oznaka mesta</label>
                            <input type="text" name="spot_number" class="form-control" placeholder="P25" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="slobodno">slobodno</option>
                                <option value="zauzeto">zauzeto</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cena po satu</label>
                            <input type="number" name="price_per_hour" class="form-control" value="50" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Dodaj parking mesto</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card app-card p-4">
                <h3>Parking mesta</h3>
                <div class="table-responsive mt-3">
                    <table class="table table-dark table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Oznaka</th>
                                <th>Status</th>
                                <th>Cena po satu</th>
                                <th>Akcije</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($spots && mysqli_num_rows($spots) > 0): ?>
                                <?php while ($row = mysqli_fetch_assoc($spots)): ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['spot_number']; ?></td>
                                        <td>
                                            <?php if ($row['status'] == 'slobodno'): ?>
                                                <span class="badge text-bg-success">slobodno</span>
                                            <?php else: ?>
                                                <span class="badge text-bg-danger">zauzeto</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo number_format($row['price_per_hour'], 0, ',', '.'); ?> RSD</td>
                                        <td>
                                            <a href="parking_spots.php?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-light">Izmeni</a>
                                            <a href="parking_spots.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger">Obriši</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-secondary">Nema parking mesta za prikaz.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
