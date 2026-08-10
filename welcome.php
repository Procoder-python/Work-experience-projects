<?php
session_start(); 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fakebook | Home</title>
    <link rel="stylesheet" href="styling.css">
</head>
<body class="welcome-page">
    <header class="site-header">
        <a class="site-logo" href="welcome.php">FAKEBOOK</a>
        <nav class="site-nav" aria-label="Main navigation">
            <a href="welcome.php">Home</a>
            <a class="nav-logout" href="logout.php">Log out</a>
        </nav>
    </header>

    <main class="welcome-main">
        <section class="welcome-hero">
            <p class="eyebrow">YOUR SOCIAL SPACE</p>
            <h1>Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>.</h1>
            <p class="hero-text">Stay connected with the people and moments that matter to you.</p>
            <div class="hero-actions">
                <a class="primary-action" href="#features">Explore Fakebook</a>
            </div>
        </section>

        <section id="features" class="feature-section" aria-labelledby="features-title">
            <div class="section-heading">
                <p class="eyebrow">WHAT YOU CAN DO</p>
                <h2 id="features-title">A simple place to stay connected.</h2>
            </div>
            <div class="feature-grid">
                <article class="feature-item">
                    <span class="feature-number">01</span>
                    <h3>Connect</h3>
                    <p>Keep up with the people in your circle.</p>
                </article>
                <article class="feature-item">
                    <span class="feature-number">02</span>
                    <h3>Share</h3>
                    <p>Share updates, ideas, and moments.</p>
                </article>
                <article class="feature-item">
                    <span class="feature-number">03</span>
                    <h3>Discover</h3>
                    <p>Find something new in your community.</p>
                </article>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <span>FAKEBOOK</span>
        <span>Made for staying connected.</span>
    </footer>
</body>
</html>
