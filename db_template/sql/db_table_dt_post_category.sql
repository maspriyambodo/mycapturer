
-- --------------------------------------------------------

--
-- Table structure for table `dt_post_category`
--

DROP TABLE IF EXISTS `dt_post_category`;
CREATE TABLE `dt_post_category` (
  `id` int NOT NULL,
  `category` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `descriptions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `stat` int DEFAULT NULL COMMENT '1. aktif\r\n2. non-aktif',
  `syscreateuser` int DEFAULT NULL COMMENT 'di dapat dari session login user',
  `syscreatedate` datetime DEFAULT NULL,
  `sysupdateuser` int DEFAULT NULL COMMENT 'di dapat dari session login user',
  `sysupdatedate` datetime DEFAULT NULL,
  `sysdeleteuser` int DEFAULT NULL COMMENT 'di dapat dari session login user',
  `sysdeletedate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `dt_post_category`
--

INSERT INTO `dt_post_category` (`id`, `category`, `descriptions`, `stat`, `syscreateuser`, `syscreatedate`, `sysupdateuser`, `sysupdatedate`, `sysdeleteuser`, `sysdeletedate`) VALUES
(1, 'Lounge', 'Forum untuk berbagi gosip, gambar, foto, dan video yang seru, lucu, serta unik.', 1, 1, '2020-03-27 11:32:34', 1, '2021-04-20 18:16:30', 1, '2021-04-20 18:30:25'),
(2, 'Animasi', 'Forum yang membahas tentang visual effect, 3D, multimedia, 3D visualization, dan animasi.', 1, 1, '2020-03-28 16:42:57', 1, '2021-04-20 18:16:46', 0, '0000-00-00 00:00:00'),
(3, 'Komik & Ilustrasi', 'Forum untuk memajang, berbagi dan berdiskusi karya komik dan ilustrasi, terutama yang berasal dari komikus dan ilustrator Indonesia.', 1, 1, '2020-03-28 16:43:42', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(4, 'AMHelpdesk', 'Portal info, bantuan dan tutorial seputar Anime dan Manga.', 1, 1, '2020-03-28 21:24:59', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(5, 'Anime', 'Tempat untuk diskusi serial Anime, baik yang sedang tayang maupun yang sudah tamat', 1, 1, '2020-03-28 21:25:20', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(6, 'Fanstuff', 'Tempatnya para penggemar fiksi. Lihat juga cerita fiksi karya mereka!', 1, 1, '2020-03-28 21:25:43', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(7, 'Manga, Manhua, & Manhwa', 'Tempat untuk diskusi komik yang berasal dari Jepang, Hongkong, Korea dan Indonesia', 1, 1, '2020-03-28 21:26:01', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(8, 'TokuSenKa', 'Tempat untuk diskusi Tokusatsu, Super Sentai dan Kaijuu', 1, 1, '2020-03-28 21:26:18', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(9, 'Berita Dunia Hiburan', 'Mau makin dekat dengan kehidupan selebritis? Ayo diskusikan berbagai update dari dunia entertainment!', 1, 1, '2020-03-28 21:26:49', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(10, 'Beritagar.id', 'Temukan pengalaman baru dalam membaca berita dan berbagai info unik lainnya', 1, 1, '2020-03-28 21:27:09', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(11, 'Berita Luar Negeri', 'Tempat diskusi mengenai berita dari luar negeri.', 1, 1, '2020-03-28 21:27:29', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(12, 'Citizen Journalism', 'Jadilah bagian dari dunia reportase dengan berbagi kabar soal peristiwa di sekitarmu!', 1, 1, '2020-03-28 21:28:14', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(13, 'Gatra.com', 'Kritis tanpa mengiris, tajam tanpa menikam', 1, 1, '2020-03-28 21:28:39', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(14, 'Kumparan', 'Kumparan adalah platform media kolaboratif pertama di Indonesia di mana jurnalis dan pembaca bisa berkolaborasi dan berkarya bersama. Bergabung, bertualang, dan bergembiralah bersama kami. Menelusuri alam raya imajinasi', 1, 1, '2020-03-28 21:34:29', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(15, 'Media Indonesia', 'Memberikan ragam informasi aktual dari sumber terpercaya dengan perspektif yang lebih mendalam', 1, 1, '2020-03-28 21:34:49', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(16, 'Medcom.id', 'Baca dan diskusikan berbagai berita aktual dari sumber terpercaya.', 1, 1, '2020-03-28 21:35:09', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(17, 'SINDOnews.com', 'Sumber Informasi Terpercaya.', 1, 1, '2020-03-28 21:35:32', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(18, 'Tribunnews.com', 'Tribunnnews.com: national reach, local perspective', 1, 1, '2020-03-28 21:35:50', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(19, 'Pilkada', 'Forum khusus untuk berbagi informasi dan berdiskusi mengenai segala sesuatu yang berkaitan dengan Pemilihan Kepala Daerah dan Wakil Kepala Daerah. Buat suara Agan berarti, ayo pilih dengan teliti!', 1, 1, '2020-03-28 21:36:13', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(20, 'Pilih Capres & Caleg', 'Ruang untuk mendiskusikan calon presiden dan calon legislatif.', 1, 1, '2020-03-28 21:36:31', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(21, 'Dunia Kerja & Profesi', 'Tempat diskusi beragam profesi dan pembahasan seputar karir, gaji, pajak, keuangan dan serba-serbi dunia kerja.', 1, 1, '2020-03-28 21:36:54', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(22, 'Lowongan Kerja', 'Tempat kumpulan informasi mengenai lowongan pekerjaan.', 1, 1, '2020-03-28 21:37:26', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(23, 'Penawaran Kerjasama, BO, Distribusi, Reseller, & Agen', 'Tempat untuk menawarkan bisnis baik dalam bentuk franchise, peluang bisnis, distribusi, reseller, kemitraan, dan agen usaha.', 1, 1, '2020-03-28 21:37:49', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(24, 'Reksa Dana', 'Ingin belajar atau sudah berpengalaman dengan reksa dana? Share dan temukan hal baru seputar reksa dana di sini!', 1, 1, '2020-03-28 21:38:06', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(25, 'The Exclusive Business Club (ExBC)', 'Tempat berkumpulnya para pelaku bisnis atau pengusaha untuk berbagi pengalaman tentang pengembangan bisnis di bidang masing-masing.', 1, 1, '2020-03-28 21:38:26', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(26, 'UKM', 'Tempat diskusi dan berbagi seputar Usaha Kecil Menengah (UKM), mulai dari tips, trik, dan pengalaman menjalankan usaha.', 1, 1, '2020-03-28 21:38:48', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(27, 'Buku', 'Forum bagi pecinta buku untuk berdiskusi dan berbagi ulasan bacaan favorit, sharing koleksi buku, dan ngobrolin trend perbukuan bareng komunitas.', 1, 1, '2020-03-28 21:39:04', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(28, 'CCPB - Shareware & Freeware', 'Tempat berbagi trik dan aplikasi.', 1, 1, '2020-03-28 21:39:27', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(29, 'Hardware Computer', 'Tempat diskusi computer hardware: updates, problems, drivers, peripheral, performance, upgrade, overclocking, showcase, dan konsultasi.', 1, 1, '2020-03-28 21:40:15', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(30, 'Internet Service & Networking', 'Tempat membahas internet service provider dan networking (hardware & tutorial).', 1, 1, '2020-03-28 21:40:36', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(31, 'Linux dan OS Selain Microsoft & Mac', 'Tempat diskusi seputar sistem operasi Unix, Linux, dan sistem operasi lainnya (selain produk Microsoft & Mac).', 1, 1, '2020-03-28 21:40:56', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(32, 'Macintosh', 'Tempat diskusi dan berbagi informasi tentang produk Macintosh, baik hardware maupun software.', 1, 1, '2020-03-28 21:41:16', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(33, 'Programmer Forum', 'Tempat diskusi dan belajar bahasa programming, dari pemula hingga pakar.', 1, 1, '2020-03-28 21:41:34', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(34, 'Website, Webmaster, Webdeveloper', 'Tempat diskusi teknis dan review seputar website, security, blogs, CMS, webhosting, filehoster, forum, board, mail, SEO, templates, snippets/scripts, social bookmarking, social network.', 1, 1, '2020-03-28 21:41:52', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(35, 'Hosting Stuff', 'Hosting (shared hosting, VPS, dedicated), domain (register), software hosting (cPanel, WHM, lxAdmin, etc), technical & security issues, webserver.', 1, 1, '2020-03-28 21:42:12', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(36, 'Templates & Scripts Stuff', 'Tempat kumpulan templates dan scripts.', 1, 1, '2020-03-28 21:42:29', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(37, 'Oriental Exotic (Asian food)', 'Tempat membahas kuliner khas Asia.', 1, 1, '2020-03-28 21:42:54', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(38, 'Restaurant Review', 'Tempat berbagi pengalaman makan dan ulasan seputar resto (menu, tempat, promo).', 1, 1, '2020-03-28 21:43:33', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(39, 'Selera Nusantara (Indonesian Food)', 'Tempat membahas kuliner khas Indonesia.', 1, 1, '2020-03-28 21:43:54', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(40, 'The Rest of the World (International Food)', 'Tempat membahas hidangan dari berbagai penjuru dunia lainnya, termasuk kuliner western dan european.', 1, 1, '2020-03-28 21:44:29', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(41, 'Deals', 'Tempat berbagi promo dan diskon menarik.', 1, 1, '2020-03-28 21:44:47', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(42, 'Do It Yourself', 'Forum berisi kumpulan topik diskusi, tips, dan tutorial do it yourself dengan memanfaatkan barang baru maupun recycle', 1, 1, '2020-03-28 21:45:06', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(43, 'Civitas Academica', 'Tempat kumpul alumni dan siswa dari beragam almamater. Saling berbagi info lowongan kerja, acara reuni, dan kondisi terbaru sekolah atau universitas.', 1, 1, '2020-03-28 21:45:28', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(44, 'Sejarah & Xenology', 'Tempat membahas sejarah/biografi tokoh dalam dan luar negeri. Juga diskusi tentang xenology (ilmu yang membahas misteri-misteri dunia).', 1, 1, '2020-03-28 21:45:47', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(45, 'Sains & Teknologi', 'Tempat diskusi mendalam dan berbagi pengetahuan sains dan teknologi.', 1, 1, '2020-03-28 21:46:04', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(46, 'Audio & Video', 'Tempat khusus membahas peralatan audio dan video', 1, 1, '2020-03-28 21:46:24', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(47, 'Home Appliance', 'Tempat khusus membahas barang elektronik rumah tangga', 1, 1, '2020-03-28 21:46:42', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(48, 'Photography', 'Portal untuk membahas seputar dunia photography', 1, 1, '2021-04-25 21:39:17', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(49, 'Olah Raga', 'Kategori posting olah raga', 1, 1, '2021-06-09 00:49:23', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00');
