<nav class="navbar navbar-dark app-navbar sticky-top">
    <div class="container py-2">
        <div class="d-flex flex-wrap align-items-center justify-content-between w-100 gap-3">
            <a class="navbar-brand fw-bold mb-0" href="<?php echo $basePath; ?>index.php">Parking Sistem</a>

            <div class="main-nav d-flex flex-wrap align-items-center">
                <?php if ($session->isLoggedIn() && !$session->isAdmin()): ?>
                    <a class="nav-link text-light" href="<?php echo $basePath; ?>index.php">Početna</a>
                <?php endif; ?>

                <?php if ($session->isAdmin()): ?>
                    <a class="nav-link text-light" href="<?php echo $basePath; ?>admin/dashboard.php">Admin panel</a>
                    <a class="nav-link text-light" href="<?php echo $basePath; ?>admin/users.php">Korisnici</a>
                    <a class="nav-link text-light" href="<?php echo $basePath; ?>admin/parking_spots.php">Parking mesta</a>
                <?php endif; ?>

                <?php if (!$session->isLoggedIn()): ?>
                    <a class="nav-link text-light" href="<?php echo $basePath; ?>login.php">Prijava</a>
                <?php endif; ?>
            </div>

            <div class="user-nav d-flex flex-wrap align-items-center gap-3">
                <?php if ($session->isLoggedIn()): ?>
                    <span class="user-info">Korisnik: <?php echo $_SESSION['first_name']; ?></span>
                    <a class="btn btn-outline-light btn-sm" href="<?php echo $basePath; ?>logout.php">Odjava</a>
                <?php else: ?>
                    <a class="btn btn-primary btn-sm" href="<?php echo $basePath; ?>register.php">Registracija</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
