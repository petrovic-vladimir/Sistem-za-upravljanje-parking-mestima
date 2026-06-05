<?php
require_once 'classes/User.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = array(
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'role' => 'korisnik'
    );

    if ($data['first_name'] == '' || $data['last_name'] == '' || $data['email'] == '' || $data['password'] == '') {
        $error = 'Sva polja su obavezna.';
    } else {
        $user = new User();
        $existingUser = $user->findByEmail($data['email']);

        if ($existingUser && mysqli_num_rows($existingUser) > 0) {
            $error = 'Korisnik sa ovom email adresom već postoji.';
        } else {
            if ($user->create($data)) {
                $success = 'Registracija je uspešno izvršena. Možete da se prijavite.';
            } else {
                $error = 'Došlo je do greške prilikom registracije.';
            }
        }
    }
}
?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card app-card p-4">
                <h2 class="text-center mb-4">Registracija korisnika</h2>

                <?php if ($error != ''): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <?php if ($success != ''): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>

                <form method="POST" action="register.php">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ime</label>
                            <input type="text" name="first_name" class="form-control" placeholder="Ime" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Prezime</label>
                            <input type="text" name="last_name" class="form-control" placeholder="Prezime" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email adresa</label>
                        <input type="email" name="email" class="form-control" placeholder="email@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lozinka</label>
                        <input type="password" name="password" class="form-control" placeholder="Lozinka" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Registruj se</button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
