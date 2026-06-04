<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<main class="container py-5">
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card app-card p-4 h-100">
                <h2>Rezervacija parking mesta</h2>
                <form class="mt-4">
                    <div class="mb-3">
                        <label class="form-label">Parking mesto</label>
                        <input type="text" class="form-control" value="P01" readonly>
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
                    <tr><td>Mesto</td><td>P01</td></tr>
                    <tr><td>Status</td><td>Slobodno</td></tr>
                    <tr><td>Cena po satu</td><td>100 RSD</td></tr>
                </table>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
