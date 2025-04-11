-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Apr 2025 pada 16.00
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bangetayu`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `beranda`
--

CREATE TABLE `beranda` (
  `id` int(11) NOT NULL,
  `foto_sekolah` text NOT NULL,
  `foto_walikota` text NOT NULL,
  `foto_presiden` text NOT NULL,
  `Nama_Kepsek` varchar(255) DEFAULT NULL,
  `logo` text DEFAULT NULL,
  `foto_kepsek` text DEFAULT NULL,
  `sambutan` text DEFAULT NULL,
  `slogan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `beranda`
--

INSERT INTO `beranda` (`id`, `foto_sekolah`, `foto_walikota`, `foto_presiden`, `Nama_Kepsek`, `logo`, `foto_kepsek`, `sambutan`, `slogan`) VALUES
(1, 'PLANG SEKOLAH.jpg', 'pelantikan-walkot.jpg', 'pelantikan-pres1.jpg', 'Samadi, S.Ag., S.Pd.', 'x', 'kepala-sekolah.jpg', 'AssalamualaikumWr.Wb\r\n\r\n \r\n\r\nPuji syukur kepada Alloh SWT, Tuhan Yang Maha Esa yang telah memberikan rahmat dan hidayahNya sehingga website SD Negeri Bangetayu Wetan 02 Semarang  ini dapat terbit. Salah satu tujuan dari website ini adalah untuk menjawab akan setiap kebutuhan informasi dengan memanfaatkan sarana teknologi informasi yang ada. Kami sadar sepenuhnya dalam rangka memajukan pendidikan di era berkembangnya Teknologi Informasi yang begitu pesat, sangat diperlukan berbagai sarana prasarana yang kondusif, kebutuhan berbagai informasi siswa, guru, orangtua maupun masyarakat, sehingga kami berusaha mewujudkan hal tersebut semaksimal mungkin. Semoga dengan adanya website ini dapat membantu dan bermanfaat, terutama informasi yang berhubungan dengan pendidikan, ilmu pengetahuan dan informasi seputar SD Negeri Bangetayu Wetan 02 Semarang \r\n\r\n \r\n\r\nBesar harapan kami, sarana ini dapat memberi manfaat bagi semua pihak yang ada dilingkup pendidikan dan pemerhati pendidikan secara khusus bagi SD Negeri Bangetayu Wetan 02 Semarang \r\n\r\n \r\n\r\nAkhirnya kami mengharapkan masukan dari berbagai pihak untuk website ini agar kami terus belajar dan meng-update diri, sehingga tampilan, isi dan mutu website akan terus berkembang dan lebih baik nantinya. Terima kasih atas kerjasamanya, maju terus untuk mencapai SD Negeri Bangetayu Wetan 02  Semarang  yang lebih baik lagi.\r\n\r\n \r\n\r\nWassalmualaikum warohmatullahi wabarokatuh.', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `berita_sekolah`
--

CREATE TABLE `berita_sekolah` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `kategori` varchar(100) NOT NULL,
  `isi` text DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `media` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `berita_sekolah`
--

INSERT INTO `berita_sekolah` (`id`, `judul`, `kategori`, `isi`, `tanggal`, `media`) VALUES
(1, 'Menerima Sertifikat SEKOLAH ADIWIYATA BERPRESTASI', '', 'Semarang – SD Negeri Bangetayu Wetan 02 kembali menorehkan prestasi membanggakan. Sekolah ini secara resmi menerima Sertifikat Sekolah Adiwiyata Berprestasi, sebagai bentuk penghargaan atas komitmen dan keberhasilan dalam menerapkan prinsip-prinsip pelestarian lingkungan hidup di lingkungan sekolah.\r\n\r\nPenghargaan ini diberikan oleh Dinas Lingkungan Hidup Kota Semarang sebagai bagian dari program Adiwiyata, yaitu program nasional yang bertujuan menciptakan sekolah yang peduli dan berbudaya lingkungan. Sertifikat diserahkan dalam sebuah acara resmi yang dihadiri oleh perwakilan dinas, kepala sekolah, guru, serta siswa-siswi SDN Bangetayu Wetan 02.\r\n\r\nKepala SDN Bangetayu Wetan 02, bapak samadi, menyampaikan rasa syukurnya atas penghargaan ini. “Penghargaan ini merupakan hasil kerja keras seluruh warga sekolah dalam menjaga kebersihan, mengelola sampah dengan benar, serta melakukan berbagai kegiatan peduli lingkungan seperti penghijauan dan pemanfaatan barang bekas,” ujarnya.', '2023-12-23', 'WhatsApp Image 2024-12-23 at 09.55.06.jpeg'),
(2, 'Penyerahan Bantuan Alat Tulis Kepada Peserta Didik', '', 'Semarang, 11 April 2024 – Suasana penuh semangat dan kebahagiaan menyelimuti SDN Bangetayu Wetan 02 saat dilaksanakannya kegiatan penyerahan bantuan alat tulis kepada peserta didik. Kegiatan ini merupakan bentuk kepedulian dan dukungan terhadap dunia pendidikan, khususnya dalam membantu para siswa dalam memenuhi kebutuhan belajar mereka.\r\n\r\nBantuan yang diserahkan berupa berbagai perlengkapan sekolah seperti buku tulis, pensil, pulpen, penggaris, penghapus, dan alat tulis lainnya yang dibutuhkan dalam kegiatan pembelajaran sehari-hari. Bantuan ini diterima langsung oleh para siswa dengan wajah ceria dan penuh rasa syukur.\r\n\r\nKepala Sekolah SDN Bangetayu Wetan 02, Bapak Samadi, S.Ag., S.Pd., menyampaikan rasa terima kasih yang sebesar-besarnya kepada semua pihak yang telah berkontribusi dalam kegiatan ini. \"Bantuan ini sangat berarti bagi anak-anak kami, terutama bagi mereka yang membutuhkan. Semoga kegiatan seperti ini bisa terus berlanjut dan menginspirasi pihak lain untuk turut peduli terhadap pendidikan,\" ujarnya dalam sambutannya.\r\n\r\nKegiatan ini juga menjadi momen untuk mempererat hubungan antara sekolah, peserta didik, dan masyarakat sekitar. Selain penyerahan bantuan, acara juga diisi dengan sesi foto bersama, dan beberapa siswa menyampaikan kesan mereka atas bantuan yang diberikan.\r\n\r\nMelalui kegiatan ini, diharapkan semangat belajar para siswa semakin meningkat dan mereka dapat lebih fokus dalam menimba ilmu tanpa harus khawatir akan kekurangan perlengkapan belajar. Semangat gotong royong dan kepedulian terhadap sesama menjadi nilai penting yang diangkat dalam kegiatan ini.', '2024-04-11', 'WhatsApp Image 2024-10-22 at 08.56.52.jpeg'),
(3, 'KEGITAN INOVASI ADIWIYATA SEKOLAH  Teh Bunga Telang', '', 'Sebagai salah satu Sekolah Adiwiyata yang terus berkomitmen terhadap pelestarian lingkungan dan pengembangan budaya ramah lingkungan, SDN Bangetayu Wetan 02 menghadirkan sebuah inovasi menarik melalui pemanfaatan bunga telang (Clitoria ternatea) menjadi minuman sehat bernama Teh Bunga Telang.\r\nLatar Belakang Kegiatan\r\n\r\nProgram Adiwiyata mendorong sekolah untuk menciptakan lingkungan yang bersih, sehat, dan berwawasan lingkungan. Dalam mendukung program tersebut, SDN Bangetayu Wetan 02 memanfaatkan lahan kosong di lingkungan sekolah untuk menanam tanaman bunga telang. Tanaman ini dikenal memiliki banyak manfaat bagi kesehatan dan mudah dibudidayakan.\r\nProses Pengolahan Teh Bunga Telang\r\n\r\nKegiatan ini melibatkan siswa secara aktif, mulai dari proses penanaman, perawatan, hingga pengolahan bunga telang menjadi teh. Berikut adalah tahapan kegiatan:\r\n\r\n    Penanaman dan Perawatan\r\n    Siswa bersama guru menanam bibit bunga telang di taman sekolah. Tanaman ini dirawat secara rutin dengan penyiraman dan pemupukan alami dari kompos organik.\r\n\r\n    Panen dan Pengeringan\r\n    Setelah bunga mekar sempurna, bunga dipetik dan dikeringkan secara alami di bawah sinar matahari selama beberapa hari.\r\n\r\n    Pengolahan Menjadi Teh\r\n    Bunga telang yang sudah kering dikemas dalam kantong teh sederhana atau disimpan dalam wadah bersih. Siswa kemudian belajar menyeduh teh bunga telang dan mengenal manfaatnya.\r\n\r\nManfaat Teh Bunga Telang\r\n\r\nTeh ini tidak hanya memiliki warna biru keunguan yang cantik, tetapi juga dikenal kaya antioksidan, membantu menjaga kesehatan mata, serta meningkatkan daya tahan tubuh. Edukasi mengenai manfaat ini disampaikan kepada siswa sebagai bagian dari pembelajaran kontekstual.\r\nTujuan dan Dampak Kegiatan\r\n\r\n    Menumbuhkan kepedulian siswa terhadap lingkungan sekitar.\r\n\r\n    Menanamkan jiwa wirausaha dengan hasil olahan sederhana.\r\n\r\n    Mendorong gaya hidup sehat dan ramah lingkungan.\r\n\r\n    Membentuk karakter siswa yang kreatif dan inovatif.\r\n\r\nHarapan ke Depan\r\n\r\nKegiatan inovatif seperti ini diharapkan terus berkembang dan menjadi inspirasi bagi sekolah lain. Tidak hanya mendukung program Adiwiyata, tetapi juga memperkuat karakter siswa sebagai agen perubahan yang peduli lingkungan.', '2023-08-04', 'TEH dari BUNGA TELANG (jumat 4 agustus 2023).jpg'),
(4, 'Kegiatan Pramuka Penggalang PERJUSA 2024', '', ' Semarang – SDN Bangetayu Wetan 02 sukses menggelar Perkemahan Jumat-Sabtu (PERJUSA) 2024 bagi anggota Pramuka Penggalang pada akhir pekan ini. Kegiatan yang berlangsung di lingkungan sekolah tersebut bertujuan untuk menanamkan nilai-nilai kemandirian, kedisiplinan, serta kerja sama di kalangan siswa.\r\nSelama perkemahan, peserta mengikuti berbagai kegiatan seru dan mendidik, seperti pendirian tenda, api unggun, jelajah alam, hingga lomba keterampilan kepramukaan. Tidak hanya itu, mereka juga mendapatkan materi tentang kepemimpinan dan tanggung jawab yang diberikan oleh pembina Pramuka. \r\nKegiatan ini diakhiri dengan upacara penutupan dan pemberian penghargaan bagi kelompok yang menunjukkan semangat dan keterampilan terbaik selama perkemahan. Diharapkan, pengalaman dari PERJUSA 2024 dapat memberikan bekal berharga bagi para siswa dalam kehidupan sehari-hari. ', '2024-04-02', 'WhatsApp Image 2024-12-23 at 09.39.44.jpeg'),
(5, 'Kepala Sekolah Menerima SK Sekolah Adiwiyata Provinsi Jawa Tengah', '', 'Kepala SDN Bangetayu Wetan 02 menerima Surat Keputusan (SK) Sekolah Adiwiyata Provinsi Jawa Tengah sebagai bentuk apresiasi atas upaya sekolah dalam menjaga lingkungan dan menerapkan program Adiwiyata.\r\n\r\nPenyerahan SK dilakukan oleh Dinas Lingkungan Hidup Provinsi Jawa Tengah dan dihadiri oleh perwakilan sekolah-sekolah yang lolos seleksi tingkat provinsi. Penghargaan ini menjadi bukti bahwa SDN Bangetayu Wetan 02 telah memenuhi kriteria sebagai sekolah yang peduli dan berbudaya lingkungan.\r\n\r\nKepala sekolah menyampaikan terima kasih kepada seluruh warga sekolah atas kerja sama dan kepeduliannya terhadap lingkungan. Harapannya, prestasi ini dapat menjadi motivasi untuk terus meningkatkan program ramah lingkungan di sekolah dan melangkah menuju Adiwiyata Nasional.', '2024-06-12', 'Gambar WhatsApp 2025-04-11 pukul 13.36.48_c45955d7.jpg'),
(6, 'KEGITAN INOVASI ADIWIYATA SEKOLAH  Oseng Daun dan Bunga Telang', '', 'Sebagai bagian dari program Adiwiyata, SDN Bangetayu Wetan 02 terus melakukan berbagai inovasi ramah lingkungan dan edukatif. Salah satu kegiatan terbaru adalah pemanfaatan tanaman bunga telang menjadi menu sehat berupa oseng daun dan bunga telang.\r\n\r\nKegiatan ini melibatkan guru dan siswa dalam proses pemanenan, pengolahan, hingga penyajian. Daun dan bunga telang yang ditanam di kebun sekolah dipanen lalu diolah menjadi makanan yang bergizi dan alami.\r\n\r\nSelain mendukung ketahanan pangan sekolah, kegiatan ini juga bertujuan untuk menumbuhkan kesadaran siswa terhadap manfaat tanaman di sekitar mereka, serta menanamkan sikap kreatif dan peduli lingkungan sejak dini.\r\n\r\nDengan inovasi ini, SDN Bangetayu Wetan 02 berharap bisa terus mengembangkan kegiatan Adiwiyata yang bermanfaat, menyenangkan, dan berdampak positif bagi seluruh warga sekolah.', '2024-04-11', 'OSENG-OSENG dari DAUN DAN BUNGA TELANG (kamis, 23 Maret 2023).jpg'),
(7, 'KEGITAN INOVASI ADIWIYATA SEKOLAH  Teh Bunga Rosela', '', 'Dalam rangka mendukung program Adiwiyata, SDN Bangetayu Wetan 02 kembali melakukan inovasi berbasis lingkungan, yaitu dengan mengolah bunga rosela menjadi minuman sehat berupa teh bunga rosela.\r\n\r\nBunga rosela yang ditanam di kebun sekolah dipanen oleh siswa dan guru, lalu dikeringkan secara alami untuk dijadikan teh. Teh bunga rosela dikenal memiliki banyak manfaat untuk kesehatan, seperti menurunkan tekanan darah dan meningkatkan daya tahan tubuh.\r\n\r\nKegiatan ini tidak hanya mengajarkan siswa tentang cara pengolahan tanaman herbal, tetapi juga menumbuhkan rasa cinta terhadap lingkungan serta semangat untuk memanfaatkan tanaman sekolah secara bijak dan kreatif.\r\n\r\nMelalui inovasi ini, SDN Bangetayu Wetan 02 terus berkomitmen menjadikan lingkungan sekolah sebagai tempat belajar yang sehat, hijau, dan inspiratif.', '2024-04-11', 'TEH dari BUNGA ROSELA (jumat 23 juni 2023).jpg'),
(8, 'KEGITAN INOVASI ADIWIYATA SEKOLAH  Sirup Bunga Rosela', '', 'Sebagai bagian dari kegiatan inovasi program Adiwiyata, SDN Bangetayu Wetan 02 mengolah tanaman rosela yang ditanam di lingkungan sekolah menjadi sirup bunga rosela yang segar dan menyehatkan.\r\n\r\nProses pembuatan sirup melibatkan siswa dan guru, dimulai dari pemanenan bunga rosela, pencucian, perebusan, hingga proses penyaringan dan pengemasan sirup. Kegiatan ini memberikan pengalaman langsung kepada siswa tentang pemanfaatan tanaman herbal serta pentingnya menjaga dan memanfaatkan lingkungan sekolah secara kreatif.\r\n\r\nSirup bunga rosela memiliki rasa yang khas dan kaya manfaat, di antaranya membantu menurunkan kolesterol dan menjaga daya tahan tubuh.\r\n\r\nMelalui inovasi ini, SDN Bangetayu Wetan 02 terus berupaya menciptakan lingkungan sekolah yang hijau, produktif, dan edukatif, sesuai dengan semangat Adiwiyata.', '2024-04-11', 'SIRUP dari BUNGA ROSELLA (jumat, 12 mei 2023).jpg'),
(9, 'KEGITAN INOVASI ADIWIYATA SEKOLAH  Membuat Ecoprint \"Mewarnai Menggunakan Daun\"', '', 'SDN Bangetayu Wetan 02 terus berinovasi dalam mendukung program Adiwiyata dengan mengadakan kegiatan kreatif berbasis lingkungan, salah satunya yaitu membuat ecoprint atau mewarnai menggunakan daun alami.\r\n\r\nKegiatan ini melibatkan siswa dalam proses memilih daun, menata di atas kain atau kertas, dan melakukan teknik pukul atau tekan untuk memindahkan warna dan bentuk daun secara alami. Proses ini tidak menggunakan pewarna kimia, sehingga ramah lingkungan dan aman untuk anak-anak.\r\n\r\nMelalui kegiatan ecoprint, siswa diajak untuk lebih mengenal jenis-jenis daun di lingkungan sekitar sekaligus mengembangkan kreativitas dalam seni. Hasil karya ecoprint ini bisa dijadikan sebagai hiasan, pembatas buku, atau media pembelajaran.\r\n\r\nInovasi ini menjadi salah satu cara sekolah dalam menanamkan cinta lingkungan melalui seni dan kegiatan menyenangkan yang mendidik.', '2024-04-11', 'WhatsApp Image 2024-01-12 at 10.19.54.jpeg'),
(10, 'PENERIMAAN PESERTA DIDIK BARU', 'Akademik', 'SDN Bangetayu Wetan 02 telah membuka Penerimaan Peserta Didik Baru (PPDB) untuk tahun ajaran baru. Kegiatan ini dilaksanakan sesuai dengan jadwal dan ketentuan dari Dinas Pendidikan.\r\n\r\nProses pendaftaran dilakukan secara tertib dan transparan, dengan tetap mengutamakan prinsip pemerataan akses pendidikan bagi semua calon peserta didik. Orang tua dan wali murid datang langsung ke sekolah untuk melakukan pendaftaran dengan membawa dokumen yang dibutuhkan.\r\n\r\nSelama proses PPDB, pihak sekolah memberikan pelayanan terbaik dan informasi yang jelas kepada masyarakat. Diharapkan, seluruh calon peserta didik yang mendaftar dapat segera bergabung dan menjadi bagian dari keluarga besar SDN Bangetayu Wetan 02.', '2024-04-11', 'WhatsApp Image 2023-08-01 at 09.08.54-min.jpeg'),
(11, 'PENILAIAN PRAMUKA GARUDA KECAMATAN GENUK', '', 'SDN Bangetayu Wetan 02 mengikuti kegiatan Penilaian Pramuka Garuda yang diselenggarakan oleh Kwartir Ranting Kecamatan Genuk. Kegiatan ini merupakan bagian dari proses seleksi untuk memperoleh predikat Pramuka Garuda, yaitu tingkatan tertinggi dalam kepramukaan.\r\n\r\nDalam kegiatan ini, peserta didik dinilai berdasarkan kemampuan kepramukaan, kedisiplinan, sikap, serta keterampilan yang telah mereka pelajari selama mengikuti kegiatan pramuka di sekolah. Seluruh peserta menunjukkan semangat dan percaya diri dalam mengikuti rangkaian penilaian.\r\n\r\nDengan adanya kegiatan ini, diharapkan dapat menumbuhkan semangat kepramukaan yang lebih tinggi dan membentuk karakter siswa yang mandiri, disiplin, dan bertanggung jawab.', '2024-04-02', 'WhatsApp Image 2023-08-01 at 09.08.57.jpeg'),
(12, 'DUGDERAN KECAMATAN GENUK', 'Non-Akademik', 'SDN Bangetayu Wetan 02 turut memeriahkan acara Dugderan Kecamatan Genuk yang diadakan dalam rangka menyambut datangnya bulan suci Ramadhan. Kegiatan ini diikuti oleh berbagai sekolah dan masyarakat di wilayah Kecamatan Genuk.\r\n\r\nDalam acara ini, siswa-siswi SDN Bangetayu Wetan 02 ikut berpartisipasi dalam pawai budaya dengan mengenakan pakaian adat dan membawa atribut bernuansa Islami. Kegiatan berlangsung meriah dan penuh semangat, menunjukkan kekompakan serta semangat kebersamaan antarwarga.\r\n\r\nMelalui kegiatan Dugderan ini, siswa diajak untuk mengenal tradisi lokal sekaligus menumbuhkan rasa cinta terhadap budaya dan nilai-nilai keagamaan', '2024-04-17', 'WhatsApp Image 2023-08-01 at 09.08.45.jpeg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `footer`
--

CREATE TABLE `footer` (
  `id` int(11) NOT NULL,
  `tautan` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kegiatan_sekolah`
--

CREATE TABLE `kegiatan_sekolah` (
  `id` int(11) NOT NULL,
  `nama_kegiatan` varchar(255) DEFAULT NULL,
  `media` text DEFAULT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kegiatan_sekolah`
--

INSERT INTO `kegiatan_sekolah` (`id`, `nama_kegiatan`, `media`, `deskripsi`) VALUES
(4, 'tes', 'Screenshot (7).png', 'tesss');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kontak`
--

CREATE TABLE `kontak` (
  `id` int(11) NOT NULL,
  `alamat` text DEFAULT NULL,
  `maps` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telepon` varchar(50) DEFAULT NULL,
  `jam_kerja` varchar(100) DEFAULT NULL,
  `twitter` varchar(255) NOT NULL,
  `instagram` varchar(255) NOT NULL,
  `youtube` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kontak`
--

INSERT INTO `kontak` (`id`, `alamat`, `maps`, `email`, `telepon`, `jam_kerja`, `twitter`, `instagram`, `youtube`) VALUES
(1, 'yy', 'y', 'muak gw anjir', 'bgst (bagus tu)', 'ga pernah dibukain kalo buat kamu mah', 'gausah kepo', 'cie mau stalking', 'bukan yutuber');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lomba_lomba`
--

CREATE TABLE `lomba_lomba` (
  `id` int(11) NOT NULL,
  `nama_lomba` varchar(255) NOT NULL,
  `media` text NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lomba_lomba`
--

INSERT INTO `lomba_lomba` (`id`, `nama_lomba`, `media`, `deskripsi`) VALUES
(3, 'cek', 'LAPANGAN.jpg', 'ihiy'),
(4, 'bismillah', 'https://www.youtube.com/watch?v=KOQ0CejPAic', 'uy'),
(5, 'v', 'https://www.youtube.com/watch?v=KOQ0CejPAic', 'y'),
(6, 'cek', 'https://youtu.be/KOQ0CejPAic?si=GzPgs4j12smC7VaZ', 'bb');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaduan`
--

CREATE TABLE `pengaduan` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `surel` varchar(255) DEFAULT NULL,
  `no_kontak` varchar(20) DEFAULT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `prestasi_sekolah`
--

CREATE TABLE `prestasi_sekolah` (
  `id` int(11) NOT NULL,
  `nama_prestasi` varchar(255) DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `prestasi_sekolah`
--

INSERT INTO `prestasi_sekolah` (`id`, `nama_prestasi`, `foto`, `deskripsi`, `kategori`) VALUES
(1, 'tes', 'e149a738-560d-4d19-b0f5-bd32d2e8e7bb.jpg', 'tes', ''),
(4, 'Juara Lomba MTQ Kecamatan Genuk', 'Lomba MTQ.jpeg', 'Reva Rizkyana Nurdianita meraih Juara 1 Khot Putri (Umum), sementara Adsyar Nuha Baswara meraih Juara 2 Khor Putra (Umum) dalam Lomba MTQ Kecamatan Genuk. Prestasi ini menunjukkan kemampuan luar biasa mereka dalam bidang seni membaca Al-Quran.', ''),
(5, 'JUARA 3 TIKI PUTRI', 'tiki.jpeg', 'SDN Bangetayu Wetan 02 meraih juara 3 dalam ajang Tiki Putri tingkat kota, berkat kerja keras dan semangat tim siswa-siswi yang berhasil menunjukkan kemampuan luar biasa dalam lomba ini. MENDAPAT HADIAH UANG PENDIDIKAN 1.500.000, MEDALI, SERTA PIALA', 'Akademik'),
(6, 'JUARA 3 KHOT PUTRI', 'khot putri.jpeg', 'Siswi SDN Bangetayu Wetan 02 meraih Juara 3 dalam lomba Khot Putri tingkat kecamatan berkat keterampilan menulis kaligrafi yang indah dan teliti. MENDAPAT HADIAH UANG PENDIDIKAN 1.500.000, MEDALI, SERTA PIALA\r\n\r\n ', 'Akademik'),
(7, 'JUARA 3 KHOT PUTRA', 'khot putra.jpeg', 'Siswi SDN Bangetayu Wetan 02 meraih Juara 3 dalam lomba Khot Putra tingkat kecamatan berkat keterampilan menulis kaligrafi yang indah dan teliti.MENDAPAT HADIAH UANG PENDIDIKAN 1.500.000, MEDALI, SERTA PIALA', 'Akademik');

-- --------------------------------------------------------

--
-- Struktur dari tabel `profil_guru`
--

CREATE TABLE `profil_guru` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `nip` varchar(100) DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `profil_guru`
--

INSERT INTO `profil_guru` (`id`, `nama`, `foto`, `nip`, `jabatan`) VALUES
(3, 'Samadi, S.Ag., S.Pd.', 'kepala-sekolah-min.jpg', '-', 'Kepala Sekolah'),
(4, 'Munawaroh, S.Pd.SD', 'BU MUNAWAROH.jpg', '-', 'Tenaga Pendidik'),
(5, 'PUDJI JATI, S.Pd', 'PUDJI.png', '-', 'Tenaga Pendidik'),
(6, 'Rofiah, S.Pd.SD', 'BU ROFIAH.jpg', '-', 'Tenaga Pendidik'),
(7, 'SUNARTI, S.Pd. SD', 'kosong.jpg', '-', 'Tenaga Pendidik'),
(8, 'Suroto, S.Pd.SD', 'PAK SUROTO.jpg', '-', 'Tenaga Pendidik'),
(9, 'Murtati, S.Pd', 'murtati.jpeg', '-', 'Tenaga Pendidik'),
(10, 'Wiwik Rejeki, S.Pd', 'buwiwik.jpeg', '-', 'Tenaga Pendidik'),
(11, 'Fauzin, S.Pd., M.Pd', 'PAK FAUZIN.jpg', '-', 'Tenaga Pendidik'),
(12, 'Maria Ulfah, S.Pd', 'kosong1.jpg', '-', 'Tenaga Pendidik'),
(13, 'Dika Widyaningrum, S.Pd', 'dhika.jpg', '-', 'Tenaga Pendidik'),
(14, 'Tri Puji Lestari, M.Pd', 'tri.-min.JPG', '-', 'Tenaga Pendidik'),
(15, 'Supadmi, S.Pd. SD', 'WhatsApp Image 2021-06-10 at 10.14.14.jpeg', '-', 'Tenaga Pendidik'),
(16, 'Lucia Manisem, S.Pd.SD', 'BU LUCI.jpg', '-', 'Tenaga Pendidik'),
(17, 'Alifah, S.Pd.SD', 'BU ALIFAH.jpg', '-', 'Tenaga Pendidik'),
(18, 'Rahmat Nur Hidayat', 'rahmat.jpeg', '-', 'Tenaga Pendidik'),
(19, 'Abdul Wakhid, S.Ag', 'Foto_Keki_Terbaru_Whd__1_-removebg-preview.png', '-', 'Tenaga Pendidik'),
(20, 'Abdul Khoir, S.Pd.I', 'pak choir.jpg', '-', 'Tenaga Pendidik'),
(21, 'Dheri Puji Santoso, S.Pd', 'deryy.png', '-', 'Tenaga Pendidik'),
(22, 'Hendro Wibowo, S.Pd', 'hendro.png', '-', 'Tenaga Pendidik'),
(23, 'Yustina Susanti, S.Ag', 'BU SANTI.jpg', '-', 'Guru Khatolik');

-- --------------------------------------------------------

--
-- Struktur dari tabel `profil_karyawan`
--

CREATE TABLE `profil_karyawan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `profil_karyawan`
--

INSERT INTO `profil_karyawan` (`id`, `nama`, `foto`, `jabatan`) VALUES
(1, 'Ummi Fitrotun Nisa, S.E', 'krywn.jpg', 'Penjaga Sekolah'),
(2, 'Arif Kurniawan', 'Mas arif(1).jpg', 'Penjaga Sekolah'),
(3, 'Fitriyani Puji Rahayu, S.Pd', 'mb fitri.jpg', 'Penjaga Sekolah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `profil_sekolah`
--

CREATE TABLE `profil_sekolah` (
  `id` int(11) NOT NULL,
  `visi` text DEFAULT NULL,
  `misi` text DEFAULT NULL,
  `foto_sekolah` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `profil_sekolah`
--

INSERT INTO `profil_sekolah` (`id`, `visi`, `misi`, `foto_sekolah`) VALUES
(1, 'Terwujudnya sekolah yang berbudi pekerti luhur, unggul dalam prestasi, berkarakter, peduli terhadap sesama dan lingkungan.', '-Mengembangkan sikap santun, berperilaku religius di lingkungan dalam dan luar sekolah.\r\n-Mengembangkan budaya literasi, kerja keras, kreatif, dan mandiri.\r\n-Mengembangkan budaya nasionalis, gotong royong, dan integritas.\r\n-Menciptakan suasana pembelajaran yang menantang, menyenangkan, komunikatif, tanpa takut salah, dan demokratis.\r\n-Mencegah kerusakan lingkungan\r\n-Menghindari pencemaran lingkungan\r\n-Melestarikan lingkungan\r\n-Memanfaatkan waktu belajar, sumber belajar, sumber daya fisik dan manusia agar memberikan hasil yang terbaik bagi perkembangan peserta didik', 'sdn bangetayu wetan 02.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sarana_prasarana`
--

CREATE TABLE `sarana_prasarana` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sarana_prasarana`
--

INSERT INTO `sarana_prasarana` (`id`, `nama`, `foto`, `deskripsi`) VALUES
(3, 'Ruang Guru', 'RUANG GURU.jpg', 'Ruang Guru di SDN Bangetayu Wetan 02 dilengkapi dengan fasilitas yang nyaman dan memadai, mendukung kegiatan belajar mengajar serta kolaborasi antar guru.'),
(4, 'Ruang Kepala Sekolah', 'ruangkepsek.jpeg', 'Ruang Kepala Sekolah di SDN Bangetayu Wetan 02 dilengkapi dengan fasilitas yang nyaman dan mendukung aktivitas administrasi serta pengambilan keputusan sekolah.'),
(5, 'Perpustakaan', 'perpus.jpeg', 'Perpustakaan di SDN Bangetayu Wetan 02 menyediakan berbagai buku bacaan yang mendukung pembelajaran dan perkembangan minat baca siswa.'),
(6, 'Lapangan Upacara', 'lap upacara.jpg', 'Lapangan Upacara di SDN Bangetayu Wetan 02 adalah fasilitas yang luas dan nyaman, digunakan untuk berbagai kegiatan upacara bendera dan acara sekolah lainnya.'),
(7, 'Taman Kelas', 'TAMAN KELAS.jpg', 'SDN Bangetayu Wetan 02 memiliki taman kelas yang asri dan rapi, memberikan suasana belajar yang nyaman dan menyegarkan bagi siswa.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `beranda`
--
ALTER TABLE `beranda`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `berita_sekolah`
--
ALTER TABLE `berita_sekolah`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `footer`
--
ALTER TABLE `footer`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kegiatan_sekolah`
--
ALTER TABLE `kegiatan_sekolah`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `lomba_lomba`
--
ALTER TABLE `lomba_lomba`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `prestasi_sekolah`
--
ALTER TABLE `prestasi_sekolah`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `profil_guru`
--
ALTER TABLE `profil_guru`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `profil_karyawan`
--
ALTER TABLE `profil_karyawan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `profil_sekolah`
--
ALTER TABLE `profil_sekolah`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sarana_prasarana`
--
ALTER TABLE `sarana_prasarana`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `beranda`
--
ALTER TABLE `beranda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `berita_sekolah`
--
ALTER TABLE `berita_sekolah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `footer`
--
ALTER TABLE `footer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kegiatan_sekolah`
--
ALTER TABLE `kegiatan_sekolah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `kontak`
--
ALTER TABLE `kontak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `lomba_lomba`
--
ALTER TABLE `lomba_lomba`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `pengaduan`
--
ALTER TABLE `pengaduan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `prestasi_sekolah`
--
ALTER TABLE `prestasi_sekolah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `profil_guru`
--
ALTER TABLE `profil_guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `profil_karyawan`
--
ALTER TABLE `profil_karyawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `profil_sekolah`
--
ALTER TABLE `profil_sekolah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `sarana_prasarana`
--
ALTER TABLE `sarana_prasarana`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
