<?php
require_once 'classes/Session.php';

$session = new Session();
$session->start();

if (!$session->isLoggedIn()) {
    header('Location: login.php');
    exit;
}

if ($session->isAdmin()) {
    header('Location: admin/dashboard.php');
    exit;
}
?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="card app-card p-4">
                <h2 class="text-center mb-4">Plaćanje parkinga</h2>
                <form method="POST" action="payment.php">
                    <div class="mb-3">
                        <label class="form-label">Broj kartice</label>
                        <input type="text" class="form-control" placeholder="0000 0000 0000 0000">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Datum isteka</label>
                            <input type="text" class="form-control" placeholder="MM/YY">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">CVV</label>
                            <input type="text" class="form-control" placeholder="123">
                        </div>
                    </div>
                    <button type="button" class="btn btn-success w-100">Plati rezervaciju</button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
