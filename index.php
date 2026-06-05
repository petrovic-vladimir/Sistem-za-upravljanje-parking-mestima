<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<main class="container py-5">
    <section class="hero-section rounded-4 p-4 p-lg-5 mb-5">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="badge text-bg-primary mb-3">Online rezervacija parkinga</span>
                <h1 class="display-5 fw-bold">Sistem za upravljanje parking mestima</h1>
                <p class="lead text-light-emphasis mt-3">
                    Pregled slobodnih i zauzetih parking mesta, rezervacija termina i administracija parkinga.
                </p>
                <a href="#mapa" class="btn btn-primary btn-lg mt-3">Pogledaj parking mapu</a>
            </div>
            <div class="col-lg-5 mt-4 mt-lg-0">
                <div class="info-card">
                    <h5>Trenutno stanje</h5>
                    <div class="d-flex justify-content-between border-bottom py-2"><span>Ukupno mesta</span><strong>24</strong></div>
                    <div class="d-flex justify-content-between border-bottom py-2"><span>Slobodna mesta</span><strong class="text-success">16</strong></div>
                    <div class="d-flex justify-content-between py-2"><span>Zauzeta mesta</span><strong class="text-danger">8</strong></div>
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
                        <?php for ($i = 1; $i <= 24; $i++): ?>
                            <?php $occupied = in_array($i, [3, 6, 9, 12, 17, 19, 21, 24]); ?>
                            <div class="parking-spot <?php echo $occupied ? 'occupied' : 'free'; ?>">
                                P<?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?>
                            </div>
                        <?php endfor; ?>
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
                    <h4>Rezerviši</h4>
                    <a href="reservation.php" class="btn btn-outline-primary w-100">Forma za rezervaciju</a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
