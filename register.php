<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card app-card p-4">
                <h2 class="text-center mb-4">Registracija korisnika</h2>
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ime</label>
                            <input type="text" class="form-control" placeholder="Ime">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Prezime</label>
                            <input type="text" class="form-control" placeholder="Prezime">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email adresa</label>
                        <input type="email" class="form-control" placeholder="email@example.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lozinka</label>
                        <input type="password" class="form-control" placeholder="Lozinka">
                    </div>
                    <button type="button" class="btn btn-primary w-100">Registruj se</button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
