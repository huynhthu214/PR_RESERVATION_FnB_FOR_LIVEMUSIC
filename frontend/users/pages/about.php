<?php
function loadCmsContent($type) {
    $url = 'http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=get_content&type=' . urlencode($type);

    $json = @file_get_contents($url);
    if ($json === false) {
        echo '<p>Content not found (API error).</p>';
        return;
    }

    $data = json_decode($json, true);
    if ($data && $data['success']) {
        echo $data['content'];
    } else {
        echo '<p>Content not found.</p>';
    }
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/about.css">

<!-- HERO -->
<section class="hero">
  <div class="hero-content">
    <h1>Về LiveMusic</h1>
    <?php loadCmsContent('about-live-music'); ?>
  </div>
</section>

<!-- MISSION -->
<section class="mission">
  <h2>Sứ mệnh của chúng tôi</h2>
  <?php loadCmsContent('our-mission'); ?>
</section>

<!-- VALUES -->
<section class="values">
  <h2>Giá trị của chúng tôi</h2>
  <div class="values-grid">
    <?php loadCmsContent('our-value'); ?>
  </div>
</section>

<!-- LEGAL & CONTACT -->
<section class="legal">
  <h2>Điều khoản & Chính sách</h2>
  <div class="legal-grid">
    <?php loadCmsContent('legal-privacy'); ?>
  </div>
</section>
