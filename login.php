<?php
require_once 'classes/User.php';
require_once 'classes/Session.php';

$session = new Session();
$session->start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = new User();
    $loggedUser = $user->login($email, $password);

    if ($loggedUser) {
        $session->setUser($loggedUser);

        if ($loggedUser['role'] == 'admin') {
            header('Location: admin/dashboard.php');
            exit;
        }

        header('Location: index.php');
        exit;
    } else {
        $error = 'Email ili lozinka nisu ispravni.';
    }
}
?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card app-card p-4">
                <h2 class="text-center mb-4">Prijava korisnika</h2>

                <?php if ($error != ''): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST" action="login.php">
                    <div class="mb-3">
                        <label class="form-label">Email adresa</label>
                        <input type="email" name="email" class="form-control" placeholder="unesite email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lozinka</label>
                        <input type="password" name="password" class="form-control" placeholder="unesite lozinku" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Prijavi se</button>
                </form>
                <p class="text-center mt-3 mb-0">Nemate nalog? <a href="register.php">Registrujte se</a></p>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
