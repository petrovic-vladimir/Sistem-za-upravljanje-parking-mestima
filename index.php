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

$parkingSpot = new ParkingSpot();
$spots = $parkingSpot->readAll();
$totalSpots = $parkingSpot->countAll();
$freeSpots = $parkingSpot->countByStatus('slobodno');
$occupiedSpots = $parkingSpot->countByStatus('zauzeto');
?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<main class="container py-5">
    <section class="hero-section rounded-4 p-4 p-lg-5 mb-5">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="badge text-bg-primary mb-3">Online rezervacija parkinga</span>
                <h1 class="display-5 fw-bold">Sistem za upravljanje parking mestima</h1>
                <p class="lead text-light-emphasis mt-3">
                    Pregled slobodnih i zauzetih parking mesta i izbor mesta za rezervaciju.
                </p>
                <a href="#mapa" class="btn btn-primary btn-lg mt-3">Pogledaj parking mapu</a>
            </div>
            <div class="col-lg-5 mt-4 mt-lg-0">
                <div class="info-card">
                    <h5>Trenutno stanje</h5>
                    <div class="d-flex justify-content-between border-bottom py-2"><span>Ukupno mesta</span><strong><?php echo $totalSpots; ?></strong></div>
                    <div class="d-flex justify-content-between border-bottom py-2"><span>Slobodna mesta</span><strong class="text-success"><?php echo $freeSpots; ?></strong></div>
                    <div class="d-flex justify-content-between py-2"><span>Zauzeta mesta</span><strong class="text-danger"><?php echo $occupiedSpots; ?></strong></div>
                </div>
            </div>
        </div>
    </section>

    <section id="mapa" class="row g-4">
        <div class="col-lg-8">
            <div class="card app-card h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h3 class="mb-1">Mapa parkinga</h3>
                </div>
                <div class="card-body p-4">
                    <div class="parking-map">
                        <?php while ($spot = mysqli_fetch_assoc($spots)): ?>
                            <?php if ($spot['status'] == 'slobodno'): ?>
                                <a class="parking-spot free text-decoration-none" href="reservation.php?spot_id=<?php echo $spot['id']; ?>">
                                    <?php echo $spot['spot_number']; ?>
                                </a>
                            <?php else: ?>
                                <div class="parking-spot occupied">
                                    <?php echo $spot['spot_number']; ?>
                                </div>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card app-card mb-4">
                <div class="card-body p-4">
                    <h4>Legenda</h4>
                    <div class="legend-item"><span class="legend-box free-box"></span> Slobodno mesto</div>
                    <div class="legend-item"><span class="legend-box occupied-box"></span> Zauzeto mesto</div>
                </div>
            </div>

            <div class="card app-card">
                <div class="card-body p-4">
                    <h4>Uputstvo</h4>
                    <p class="text-light-emphasis mb-0">Klikom na slobodno parking mesto otvara se forma za rezervaciju.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
