CREATE TABLE IF NOT EXISTS `customer` (
  `idcustomer` int NOT NULL AUTO_INCREMENT,
  `nama_customer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `jenis_kelamin` enum('laki-laki','perempuan') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat_customer` text COLLATE utf8mb4_general_ci,
  `foto_customer` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`idcustomer`)
) ;

INSERT INTO `customer` (`idcustomer`, `nama_customer`, `jenis_kelamin`, `alamat_customer`, `foto_customer`) VALUES
	(1, 'aji', 'laki-laki', 'tumpang', '66743933ba907.png');

CREATE TABLE IF NOT EXISTS `produk` (
  `idproduk` int NOT NULL AUTO_INCREMENT,
  `nama_produk` text NOT NULL,
  PRIMARY KEY (`idproduk`)
) 

INSERT INTO `produk` (`idproduk`, `nama_produk`) VALUES
	(1, 'halo');

CREATE TABLE IF NOT EXISTS `penjualan` (
  `idpenjualan` int NOT NULL AUTO_INCREMENT,
  `idcustomer` int NOT NULL DEFAULT '0',
  `idproduk` int NOT NULL DEFAULT '0',
  `tanggal_penjualan` date NOT NULL DEFAULT '0000-00-00',
  `total_pesanan` int NOT NULL DEFAULT '0',
  `total_harga` int NOT NULL DEFAULT '0',
  `catatan` text NOT NULL,
  PRIMARY KEY (`idpenjualan`),
  KEY `FK_penjualan_customer` (`idcustomer`),
  KEY `FK_penjualan_produk` (`idproduk`),
  CONSTRAINT `FK_penjualan_customer` FOREIGN KEY (`idcustomer`) REFERENCES `customer` (`idcustomer`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_penjualan_produk` FOREIGN KEY (`idproduk`) REFERENCES `produk` (`idproduk`) ON DELETE CASCADE ON UPDATE CASCADE
) ;

INSERT INTO `penjualan` (`idpenjualan`, `idcustomer`, `idproduk`, `tanggal_penjualan`, `total_pesanan`, `total_harga`, `catatan`) VALUES
	(1, 1, 1, '2024-06-05', 1, 200000, '551324');


