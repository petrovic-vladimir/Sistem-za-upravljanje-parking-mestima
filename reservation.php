<?php
require_once 'classes/Session.php';
require_once 'classes/ParkingSpot.php';

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

$spotNumber = '';
$price = 100;

if (isset($_GET['spot_id'])) {
    $parkingSpot = new ParkingSpot();
    $result = $parkingSpot->read($_GET['spot_id']);

    if ($result && mysqli_num_rows($result) > 0) {
        $spot = mysqli_fetch_assoc($result);
        $spotNumber = $spot['spot_number'];
        $price = $spot['price_per_hour'];
    }
}
?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<main class="container py-5">
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card app-card p-4 h-100">
                <h2>Rezervacija parking mesta</h2>
                <form class="mt-4" method="POST" action="reservation.php">
                    <div class="mb-3">
                        <label class="form-label">Parking mesto</label>
                        <input type="text" class="form-control" value="<?php echo $spotNumber; ?>" readonly>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Vreme od</label>
                            <input type="time" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Vreme do</label>
                            <input type="time" class="form-control">
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary">Rezerviši</button>
                </form>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card app-card p-4 h-100">
                <h4>Detalji rezervacije</h4>
                <table class="table table-dark table-striped mt-3">
                    <tr><td>Mesto</td><td><?php echo $spotNumber != '' ? $spotNumber : 'Nije izabrano'; ?></td></tr>
                    <tr><td>Status</td><td>Slobodno</td></tr>
                    <tr><td>Cena po satu</td><td><?php echo $price; ?> RSD</td></tr>
                </table>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
