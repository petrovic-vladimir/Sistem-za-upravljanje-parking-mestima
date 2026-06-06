<?php
require_once 'classes/Session.php';
require_once 'classes/ParkingSpot.php';
require_once 'classes/Reservation.php';

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

$parkingSpot = new ParkingSpot();
$reservation = new Reservation();
$error = '';
$success = '';
$spot = null;
$spotId = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $spotId = isset($_POST['spot_id']) ? (int) $_POST['spot_id'] : 0;
    $reservationDate = isset($_POST['reservation_date']) ? $_POST['reservation_date'] : '';
    $timeFrom = isset($_POST['time_from']) ? $_POST['time_from'] : '';
    $timeTo = isset($_POST['time_to']) ? $_POST['time_to'] : '';

    $result = $parkingSpot->read($spotId);

    if (!$result || mysqli_num_rows($result) == 0) {
        $error = 'Parking mesto nije pronađeno.';
    } else {
        $spot = mysqli_fetch_assoc($result);

        if ($spot['status'] != 'slobodno') {
            $error = 'Izabrano parking mesto nije slobodno.';
        } elseif ($reservationDate == '' || $timeFrom == '' || $timeTo == '') {
            $error = 'Morate uneti datum i vreme rezervacije.';
        } elseif ($timeFrom >= $timeTo) {
            $error = 'Vreme završetka mora biti veće od vremena početka.';
        } else {
            $startTime = $reservationDate . ' ' . $timeFrom . ':00';
            $endTime = $reservationDate . ' ' . $timeTo . ':00';

            $data = array(
                'user_id' => $_SESSION['user_id'],
                'parking_spot_id' => $spotId,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'status' => 'aktivna'
            );

            if ($reservation->create($data)) {
                $parkingSpot->changeStatus($spotId, 'zauzeto');
                $_SESSION['reservation_id'] = $reservation->getLastId();
                header('Location: payment.php');
                exit;
            } else {
                $error = 'Došlo je do greške prilikom čuvanja rezervacije.';
            }
        }
    }
} else {
    if (!isset($_GET['spot_id'])) {
        header('Location: index.php');
        exit;
    }

    $spotId = (int) $_GET['spot_id'];
    $result = $parkingSpot->read($spotId);

    if (!$result || mysqli_num_rows($result) == 0) {
        header('Location: index.php');
        exit;
    }

    $spot = mysqli_fetch_assoc($result);

    if ($spot['status'] != 'slobodno') {
        header('Location: index.php');
        exit;
    }
}

$spotNumber = $spot ? $spot['spot_number'] : '';
$price = $spot ? $spot['price_per_hour'] : 100;
?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<main class="container py-5">
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card app-card p-4 h-100">
                <h2>Rezervacija parking mesta</h2>

                <?php if ($error != ''): ?>
                    <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
                <?php endif; ?>

                <form class="mt-4" method="POST" action="reservation.php">
                    <input type="hidden" name="spot_id" value="<?php echo $spotId; ?>">
                    <div class="mb-3">
                        <label class="form-label">Parking mesto</label>
                        <input type="text" class="form-control" value="<?php echo $spotNumber; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Datum rezervacije</label>
                        <input type="date" name="reservation_date" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Vreme od</label>
                            <select name="time_from" class="form-select" required>
                                <option value="">Izaberite vreme</option>
                                <?php for ($hour = 8; $hour <= 22; $hour++): ?>
                                    <option value="<?php echo sprintf('%02d:00', $hour); ?>"><?php echo sprintf('%02d:00', $hour); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Vreme do</label>
                            <select name="time_to" class="form-select" required>
                                <option value="">Izaberite vreme</option>
                                <?php for ($hour = 9; $hour <= 23; $hour++): ?>
                                    <option value="<?php echo sprintf('%02d:00', $hour); ?>"><?php echo sprintf('%02d:00', $hour); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Rezerviši</button>
                    <a href="index.php" class="btn btn-outline-light ms-2">Nazad</a>
                </form>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card app-card p-4 h-100">
                <h4>Detalji rezervacije</h4>
                <table class="table table-dark table-striped mt-3">
                    <tr><td>Mesto</td><td><?php echo $spotNumber; ?></td></tr>
                    <tr><td>Status</td><td>Slobodno</td></tr>
                    <tr><td>Cena po satu</td><td><?php echo $price; ?> RSD</td></tr>
                </table>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
