<?php include '../includes/header.php'; ?>
<?php
if (!$session->isAdmin()) {
    header('Location: ../login.php');
    exit;
}
?>
<?php include '../includes/navbar.php'; ?>

<main class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>Administratorski panel</h1>
        </div>
        <a href="../index.php" class="btn btn-outline-primary">Nazad na početnu</a>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <span>Ukupno mesta</span>
                <strong>24</strong>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <span>Slobodna mesta</span>
                <strong class="text-success">16</strong>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <span>Zauzeta mesta</span>
                <strong class="text-danger">8</strong>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card app-card p-4">
                <h3>Upravljanje parking mestima</h3>
                <table class="table table-dark table-hover mt-3">
                    <thead>
                        <tr>
                            <th>Oznaka</th>
                            <th>Zona</th>
                            <th>Status</th>
                            <th>Akcija</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>P01</td><td>A</td><td><span class="badge text-bg-success">Slobodno</span></td><td><button class="btn btn-sm btn-outline-light">Izmeni</button></td></tr>
                        <tr><td>P02</td><td>A</td><td><span class="badge text-bg-danger">Zauzeto</span></td><td><button class="btn btn-sm btn-outline-light">Izmeni</button></td></tr>
                        <tr><td>P03</td><td>B</td><td><span class="badge text-bg-success">Slobodno</span></td><td><button class="btn btn-sm btn-outline-light">Izmeni</button></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card app-card p-4">
                <h3>Statistika</h3>
                <div class="fake-chart mt-4">
                    <div style="height: 40%"></div>
                    <div style="height: 75%"></div>
                    <div style="height: 55%"></div>
                    <div style="height: 90%"></div>
                    <div style="height: 65%"></div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
