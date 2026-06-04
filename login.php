<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card app-card p-4">
                <h2 class="text-center mb-4">Prijava korisnika</h2>
                <form>
                    <div class="mb-3">
                        <label class="form-label">Email adresa</label>
                        <input type="email" class="form-control" placeholder="unesite email">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lozinka</label>
                        <input type="password" class="form-control" placeholder="unesite lozinku">
                    </div>
                    <button type="button" class="btn btn-primary w-100">Prijavi se</button>
                </form>
                <p class="text-center mt-3 mb-0">Nemate nalog? <a href="register.php">Registrujte se</a></p>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
