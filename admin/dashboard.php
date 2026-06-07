<?php include '../includes/header.php'; ?>
<?php
require_once '../classes/User.php';
require_once '../classes/ParkingSpot.php';
require_once '../classes/Reservation.php';
require_once '../classes/Payment.php';

if (!$session->isAdmin()) {
    header('Location: ../login.php');
    exit;
}

$user = new User();
$parkingSpot = new ParkingSpot();
$reservation = new Reservation();
$payment = new Payment();

$totalUsers = $user->countAll();
$totalSpots = $parkingSpot->countAll();
$freeSpots = $parkingSpot->countByStatus('slobodno');
$occupiedSpots = $parkingSpot->countByStatus('zauzeto');
$totalReservations = $reservation->countAll();
$totalIncome = $payment->sumTotal();
$latestReservations = $reservation->readLatest(5);
?>
<?php include '../includes/navbar.php'; ?>

<main class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>Administratorski panel</h1>
            <p class="text-secondary mb-0">Pregled osnovnih podataka o sistemu.</p>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <span>Korisnici</span>
                <strong><?php echo $totalUsers; ?></strong>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <span>Parking mesta</span>
                <strong><?php echo $totalSpots; ?></strong>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <span>Rezervacije</span>
                <strong><?php echo $totalReservations; ?></strong>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <span>Prihod</span>
                <strong><?php echo number_format($totalIncome, 0, ',', '.'); ?> RSD</strong>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="info-card">
                <h3>Stanje parkinga</h3>
                <div class="d-flex gap-3 mt-3 flex-wrap">
                    <span class="badge text-bg-success p-3">Slobodna mesta: <?php echo $freeSpots; ?></span>
                    <span class="badge text-bg-danger p-3">Zauzeta mesta: <?php echo $occupiedSpots; ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="info-card">
                <h3>Admin opcije</h3>
                <div class="d-flex gap-2 mt-3 flex-wrap">
                    <a href="#" class="btn btn-primary">Korisnici</a>
                    <a href="#" class="btn btn-outline-light">Parking mesta</a>
                </div>
            </div>
        </div>
    </div>

    <div class="card app-card p-4">
        <h3>Poslednje rezervacije</h3>
        <div class="table-responsive mt-3">
            <table class="table table-dark table-hover align-middle">
                <thead>
                    <tr>
                        <th>Korisnik</th>
                        <th>Mesto</th>
                        <th>Od</th>
                        <th>Do</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($latestReservations && mysqli_num_rows($latestReservations) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($latestReservations)): ?>
                            <tr>
                                <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                                <td><?php echo $row['spot_number']; ?></td>
                                <td><?php echo date('d.m.Y. H:i', strtotime($row['start_time'])); ?></td>
                                <td><?php echo date('d.m.Y. H:i', strtotime($row['end_time'])); ?></td>
                                <td><span class="badge text-bg-info"><?php echo $row['status']; ?></span></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-secondary">Trenutno nema rezervacija.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
