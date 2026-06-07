<?php include '../includes/header.php'; ?>
<?php
require_once '../classes/User.php';

if (!$session->isAdmin()) {
    header('Location: ../login.php');
    exit;
}

$user = new User();
$message = '';
$error = '';
$editUser = null;

if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    if ($id == $_SESSION['user_id']) {
        $error = 'Ne možete obrisati trenutno prijavljenog korisnika.';
    } elseif ($user->hasReservations($id)) {
        $error = 'Korisnik ima rezervacije i ne može biti obrisan.';
    } else {
        if ($user->delete($id)) {
            $message = 'Korisnik je uspešno obrisan.';
        } else {
            $error = 'Greška prilikom brisanja korisnika.';
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['form_type'] == 'add') {
        if ($user->create($_POST)) {
            $message = 'Korisnik je uspešno dodat.';
        } else {
            $error = 'Greška prilikom dodavanja korisnika.';
        }
    }

    if ($_POST['form_type'] == 'edit') {
        if ($user->update($_POST['id'], $_POST)) {
            $message = 'Korisnik je uspešno izmenjen.';
        } else {
            $error = 'Greška prilikom izmene korisnika.';
        }
    }
}

if (isset($_GET['edit'])) {
    $result = $user->read($_GET['edit']);
    if ($result && mysqli_num_rows($result) == 1) {
        $editUser = mysqli_fetch_assoc($result);
    }
}

$users = $user->readAll();
?>
<?php include '../includes/navbar.php'; ?>

<main class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h1>Upravljanje korisnicima</h1>
            <p class="text-secondary mb-0">Dodavanje, izmena i brisanje korisnika sistema.</p>
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
                <?php if ($editUser): ?>
                    <h3 class="mb-3">Izmena korisnika</h3>
                    <form method="POST" action="users.php">
                        <input type="hidden" name="form_type" value="edit">
                        <input type="hidden" name="id" value="<?php echo $editUser['id']; ?>">
                        <div class="mb-3">
                            <label class="form-label">Ime</label>
                            <input type="text" name="first_name" class="form-control" value="<?php echo $editUser['first_name']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Prezime</label>
                            <input type="text" name="last_name" class="form-control" value="<?php echo $editUser['last_name']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $editUser['email']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Uloga</label>
                            <select name="role" class="form-select" required>
                                <option value="korisnik" <?php if ($editUser['role'] == 'korisnik') echo 'selected'; ?>>korisnik</option>
                                <option value="admin" <?php if ($editUser['role'] == 'admin') echo 'selected'; ?>>admin</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Sačuvaj izmene</button>
                        <a href="users.php" class="btn btn-outline-light w-100 mt-2">Otkaži</a>
                    </form>
                <?php else: ?>
                    <h3 class="mb-3">Dodaj korisnika</h3>
                    <form method="POST" action="users.php">
                        <input type="hidden" name="form_type" value="add">
                        <div class="mb-3">
                            <label class="form-label">Ime</label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Prezime</label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lozinka</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Uloga</label>
                            <select name="role" class="form-select" required>
                                <option value="korisnik">korisnik</option>
                                <option value="admin">admin</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Dodaj korisnika</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card app-card p-4">
                <h3>Korisnici</h3>
                <div class="table-responsive mt-3">
                    <table class="table table-dark table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ime</th>
                                <th>Prezime</th>
                                <th>Email</th>
                                <th>Uloga</th>
                                <th>Akcije</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($users && mysqli_num_rows($users) > 0): ?>
                                <?php while ($row = mysqli_fetch_assoc($users)): ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['first_name']; ?></td>
                                        <td><?php echo $row['last_name']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><span class="badge text-bg-info"><?php echo $row['role']; ?></span></td>
                                        <td>
                                            <a href="users.php?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-light">Izmeni</a>
                                            <a href="users.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger">Obriši</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center text-secondary">Nema korisnika za prikaz.</td>
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
