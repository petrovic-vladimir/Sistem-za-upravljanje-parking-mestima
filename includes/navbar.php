<nav class="navbar navbar-dark app-navbar sticky-top">
    <div class="container d-flex flex-wrap align-items-center justify-content-between gap-3 py-2">
        <a class="navbar-brand fw-bold me-4" href="<?php echo $basePath; ?>index.php">Parking Sistem</a>
        <div class="d-flex flex-wrap align-items-center gap-2">
            <?php if ($session->isLoggedIn() && !$session->isAdmin()): ?>
                <a class="nav-link text-light" href="<?php echo $basePath; ?>index.php">Početna</a>
            <?php endif; ?>

            <?php if ($session->isAdmin()): ?>
                <a class="nav-link text-light" href="<?php echo $basePath; ?>admin/dashboard.php">Admin panel</a>
            <?php endif; ?>

            <?php if ($session->isLoggedIn()): ?>
                <span class="nav-link text-light">Korisnik: <?php echo $_SESSION['first_name']; ?></span>
                <a class="btn btn-outline-light btn-sm" href="<?php echo $basePath; ?>logout.php">Odjava</a>
            <?php else: ?>
                <a class="nav-link text-light" href="<?php echo $basePath; ?>login.php">Prijava</a>
                <a class="btn btn-primary btn-sm" href="<?php echo $basePath; ?>register.php">Registracija</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
