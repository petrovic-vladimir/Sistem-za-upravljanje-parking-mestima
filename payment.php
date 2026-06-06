<?php
require_once 'classes/Session.php';
require_once 'classes/Reservation.php';
require_once 'classes/Payment.php';

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

if (!isset($_SESSION['reservation_id'])) {
    header('Location: index.php');
    exit;
}

$reservation = new Reservation();
$payment = new Payment();
$error = '';
$success = '';
$reservationId = (int) $_SESSION['reservation_id'];
$result = $reservation->readWithDetails($reservationId);

if (!$result || mysqli_num_rows($result) == 0) {
    header('Location: index.php');
    exit;
}

$reservationData = mysqli_fetch_assoc($result);
$start = strtotime($reservationData['start_time']);
$end = strtotime($reservationData['end_time']);
$hours = ($end - $start) / 3600;

if ($hours < 1) {
    $hours = 1;
}

$amount = $hours * $reservationData['price_per_hour'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cardNumber = isset($_POST['card_number']) ? trim($_POST['card_number']) : '';

    if ($cardNumber == '') {
        $error = 'Morate uneti broj kartice.';
    } else {
        $data = array(
            'reservation_id' => $reservationId,
            'amount' => $amount,
            'card_number' => $cardNumber,
            'status' => 'placeno'
        );

        if ($payment->create($data)) {
            $success = 'Uplata je uspešno evidentirana. Parking mesto je uspešno rezervisano.';
            unset($_SESSION['reservation_id']);
        } else {
            $error = 'Došlo je do greške prilikom plaćanja.';
        }
    }
}
?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<main class="container py-5">
    <div class="row justify-content-center g-4">
        <div class="col-lg-5">
            <div class="card app-card p-4 h-100">
                <h2 class="mb-4">Plaćanje parkinga</h2>

                <?php if ($error != ''): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <?php if ($success != ''): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                    <a href="index.php" class="btn btn-primary w-100">Povratak na početnu</a>
                <?php else: ?>
                    <form method="POST" action="payment.php">
                        <div class="mb-3">
                            <label class="form-label">Broj kartice</label>
                            <input type="text" name="card_number" class="form-control" placeholder="0000 0000 0000 0000" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Potvrdi uplatu</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card app-card p-4 h-100">
                <h4>Podaci o rezervaciji</h4>
                <table class="table table-dark table-striped mt-3">
                    <tr><td>Parking mesto</td><td><?php echo $reservationData['spot_number']; ?></td></tr>
                    <tr><td>Vreme od</td><td><?php echo date('d.m.Y H:i', $start); ?></td></tr>
                    <tr><td>Vreme do</td><td><?php echo date('d.m.Y H:i', $end); ?></td></tr>
                    <tr><td>Broj sati</td><td><?php echo $hours; ?></td></tr>
                    <tr><td>Cena po satu</td><td><?php echo $reservationData['price_per_hour']; ?> RSD</td></tr>
                    <tr><td>Ukupno za uplatu</td><td><strong><?php echo $amount; ?> RSD</strong></td></tr>
                </table>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
