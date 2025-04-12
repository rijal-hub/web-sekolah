
<div id="video-container" class="content-container" style="display:none;">
        <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
        <?php
            // Mengambil nilai 'jenis_lomba' dari URL (misalnya: http://localhost/web-sekolah/detail_lomba.php?jenis_lomba=video)
            $jenis_lomba_filter = isset($_GET['jenis_lomba']) ? $_GET['jenis_lomba'] : '';

            // Mengambil data lomba dari database
            include('config/db_connect.php');

            // Menyesuaikan query SQL berdasarkan jenis_lomba dan jenis_media
            if ($jenis_lomba_filter != '') {
                // Jika ada filter jenis_lomba, sesuaikan query SQL dengan jenis_media = 'video'
                $sql = "SELECT * FROM lomba_lomba WHERE jenis_lomba = '{$jenis_lomba_filter}' AND jenis_media = 'video'";
            } else {
                // Jika tidak ada filter jenis_lomba, tampilkan semua lomba dengan jenis_media 'video'
                $sql = "SELECT * FROM lomba_lomba WHERE jenis_media = 'video'";
            }

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($lomba = $result->fetch_assoc()) {
                    $media = $lomba['media'];
                    $nama_lomba = $lomba['nama_lomba'];
                    $jenis_lomba = $lomba['jenis_lomba'];

                    // Mengecek apakah media berupa URL (video)
                    if (filter_var($media, FILTER_VALIDATE_URL)) {
                        // Jika media berupa URL video (YouTube atau youtu.be)
                        if (strpos($media, 'youtube') !== false || strpos($media, 'youtu.be') !== false) {
                            // Cek apakah URLnya dari youtu.be
                            if (strpos($media, 'youtu.be') !== false) {
                                // Mengambil ID video dari URL youtu.be
                                preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $media, $matches);
                                $video_id = $matches[1]; // ID video
                            } else {
                                // Jika URL dari youtube.com, ambil ID video setelah 'v='
                                parse_str(parse_url($media, PHP_URL_QUERY), $url_params);
                                $video_id = $url_params['v']; // ID video
                            }

                            // Membuat URL embed
                            $embed_url = "https://www.youtube.com/embed/{$video_id}";
                            ?>
                            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-<?php echo $jenis_lomba; ?>">
                                <div class="portfolio-video">
                                    
                                    <!-- Iframe Video (Disembunyikan Awal) -->
                                    <iframe 
                                        id="video-iframe-<?php echo $lomba['id']; ?>"
                                        width="100%" 
                                        height="200" 
                                        src="https://www.youtube.com/embed/<?php echo $video_id; ?>?autoplay=1" 
                                        title="<?php echo $nama_lomba; ?>" 
                                        frameborder="0" 
                                        allowfullscreen 
                                        style="display: none;">
                                    </iframe>
                                </div>
                                <div class="portfolio-info">
                                    <h4><?php echo $nama_lomba; ?></h4>
                                    <a href="https://youtu.be/<?php echo $video_id; ?>" title="Tonton Video" target="_blank" class="preview-link">
                                        <i class="bi bi-play-circle"></i>
                                    </a>
                                </div>
                            </div><!-- End Portfolio Item -->
                            <?php
                        }
                    }
                }
            } else {
                echo "Tidak ada data lomba ditemukan";
            }

            // Menutup koneksi
            $conn->close();
        ?>
        </div><!-- End video-container -->
    </div>