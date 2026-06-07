<?php
$reservationsToday = $reservation->countToday();
$reservationsWeek = $reservation->countThisWeek();
$reservationsMonth = $reservation->countThisMonth();
$incomeToday = $payment->sumToday();
$incomeWeek = $payment->sumThisWeek();
$incomeMonth = $payment->sumThisMonth();
$popularSpots = $reservation->mostReservedSpots(5);
?>

<div class="card app-card p-4 mb-4">
    <h3>Statistika rezervacija i prihoda</h3>
    <div class="row g-4 mt-1">
        <div class="col-md-4">
            <div class="stat-card">
                <span>Rezervacije danas</span>
                <strong><?php echo $reservationsToday; ?></strong>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <span>Rezervacije ove nedelje</span>
                <strong><?php echo $reservationsWeek; ?></strong>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <span>Rezervacije ovog meseca</span>
                <strong><?php echo $reservationsMonth; ?></strong>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <span>Prihod danas</span>
                <strong><?php echo number_format($incomeToday, 0, ',', '.'); ?> RSD</strong>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <span>Prihod ove nedelje</span>
                <strong><?php echo number_format($incomeWeek, 0, ',', '.'); ?> RSD</strong>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <span>Prihod ovog meseca</span>
                <strong><?php echo number_format($incomeMonth, 0, ',', '.'); ?> RSD</strong>
            </div>
        </div>
    </div>
</div>

<div class="card app-card p-4 mb-4">
    <h3>Najčešće rezervisana parking mesta</h3>
    <div class="table-responsive mt-3">
        <table class="table table-dark table-hover align-middle">
            <thead>
                <tr>
                    <th>Parking mesto</th>
                    <th>Broj rezervacija</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($popularSpots && mysqli_num_rows($popularSpots) > 0): ?>
                    <?php while ($spot = mysqli_fetch_assoc($popularSpots)): ?>
                        <tr>
                            <td><?php echo $spot['spot_number']; ?></td>
                            <td><?php echo $spot['total']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2" class="text-center text-secondary">Trenutno nema podataka za prikaz.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
