/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : ecmvph_nailandia

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2024-02-15 13:36:02
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `attendances`
-- ----------------------------
DROP TABLE IF EXISTS `attendances`;
CREATE TABLE `attendances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_employee` int(11) NOT NULL,
  `sign_in` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sign_out` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sign_in_log` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sign_out_log` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user` (`fk_employee`),
  CONSTRAINT `attendances_ibfk_1` FOREIGN KEY (`fk_employee`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of attendances
-- ----------------------------

-- ----------------------------
-- Table structure for `bookings`
-- ----------------------------
DROP TABLE IF EXISTS `bookings`;
CREATE TABLE `bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `booking_type` enum('Walk-in','Online','Call') NOT NULL,
  `fk_customer` int(11) NOT NULL,
  `fk_booking_status` int(11) NOT NULL,
  `schedule_time` varchar(255) NOT NULL,
  `remarks` text NOT NULL,
  `logged_by` varchar(255) NOT NULL,
  `logged_time` varchar(255) NOT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `updated_time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_customer` (`fk_customer`),
  KEY `bookings_ibfk_2` (`fk_booking_status`),
  CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`fk_customer`) REFERENCES `customers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`fk_booking_status`) REFERENCES `bookings_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of bookings
-- ----------------------------

-- ----------------------------
-- Table structure for `bookings_services`
-- ----------------------------
DROP TABLE IF EXISTS `bookings_services`;
CREATE TABLE `bookings_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_booking` int(11) NOT NULL,
  `fk_service` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_booking` (`fk_booking`),
  KEY `fk_service` (`fk_service`),
  CONSTRAINT `bookings_services_ibfk_1` FOREIGN KEY (`fk_booking`) REFERENCES `bookings` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `bookings_services_ibfk_2` FOREIGN KEY (`fk_service`) REFERENCES `services` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of bookings_services
-- ----------------------------

-- ----------------------------
-- Table structure for `bookings_status`
-- ----------------------------
DROP TABLE IF EXISTS `bookings_status`;
CREATE TABLE `bookings_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `booking_status` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of bookings_status
-- ----------------------------
INSERT INTO `bookings_status` VALUES ('1', 'In-queue');
INSERT INTO `bookings_status` VALUES ('2', 'Ongoing');
INSERT INTO `bookings_status` VALUES ('3', 'Completed');
INSERT INTO `bookings_status` VALUES ('4', 'Cancelled');

-- ----------------------------
-- Table structure for `bookings_timing`
-- ----------------------------
DROP TABLE IF EXISTS `bookings_timing`;
CREATE TABLE `bookings_timing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_booking` int(11) NOT NULL,
  `booking_time` varchar(255) NOT NULL,
  `ongoing_time` varchar(255) DEFAULT NULL,
  `completion_time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_booking` (`fk_booking`),
  CONSTRAINT `bookings_timing_ibfk_1` FOREIGN KEY (`fk_booking`) REFERENCES `bookings` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of bookings_timing
-- ----------------------------

-- ----------------------------
-- Table structure for `cities`
-- ----------------------------
DROP TABLE IF EXISTS `cities`;
CREATE TABLE `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_province` int(11) NOT NULL,
  `city` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_province` (`fk_province`),
  CONSTRAINT `cities_ibfk_1` FOREIGN KEY (`fk_province`) REFERENCES `provinces` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1621 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of cities
-- ----------------------------
INSERT INTO `cities` VALUES ('1', '43', 'Alaminos');
INSERT INTO `cities` VALUES ('2', '43', 'Calamba');
INSERT INTO `cities` VALUES ('3', '43', 'Kalayaan');
INSERT INTO `cities` VALUES ('4', '43', 'Lumban');
INSERT INTO `cities` VALUES ('5', '43', 'Nagcarlan');
INSERT INTO `cities` VALUES ('6', '43', 'Pangil');
INSERT INTO `cities` VALUES ('7', '43', 'San Pedro');
INSERT INTO `cities` VALUES ('8', '43', 'Siniloan');
INSERT INTO `cities` VALUES ('9', '43', 'Bay');
INSERT INTO `cities` VALUES ('10', '43', 'Calauan');
INSERT INTO `cities` VALUES ('11', '43', 'Liliw');
INSERT INTO `cities` VALUES ('12', '43', 'Mabitac');
INSERT INTO `cities` VALUES ('13', '43', 'Paete');
INSERT INTO `cities` VALUES ('14', '43', 'Pila');
INSERT INTO `cities` VALUES ('15', '43', 'Santa Cruz');
INSERT INTO `cities` VALUES ('16', '43', 'Victoria');
INSERT INTO `cities` VALUES ('17', '43', 'Binan');
INSERT INTO `cities` VALUES ('18', '43', 'Cavinti');
INSERT INTO `cities` VALUES ('19', '43', 'Los Banos');
INSERT INTO `cities` VALUES ('20', '43', 'Magdalena');
INSERT INTO `cities` VALUES ('21', '43', 'Pagsanjan');
INSERT INTO `cities` VALUES ('22', '43', 'Rizal');
INSERT INTO `cities` VALUES ('23', '43', 'Santa Maria');
INSERT INTO `cities` VALUES ('24', '43', 'Cabuyao');
INSERT INTO `cities` VALUES ('25', '43', 'Famy');
INSERT INTO `cities` VALUES ('26', '43', 'Lusiana');
INSERT INTO `cities` VALUES ('27', '43', 'Majayjay');
INSERT INTO `cities` VALUES ('28', '43', 'Pakil');
INSERT INTO `cities` VALUES ('29', '43', 'San Pablo');
INSERT INTO `cities` VALUES ('30', '43', 'Santa Rosa');
INSERT INTO `cities` VALUES ('31', '42', 'Alfonso');
INSERT INTO `cities` VALUES ('32', '42', 'Cavite City');
INSERT INTO `cities` VALUES ('33', '42', 'General Trias');
INSERT INTO `cities` VALUES ('34', '42', 'Magallanes');
INSERT INTO `cities` VALUES ('35', '42', 'Noveleta');
INSERT INTO `cities` VALUES ('36', '42', 'Tanza');
INSERT INTO `cities` VALUES ('37', '42', 'Amadeo');
INSERT INTO `cities` VALUES ('38', '42', 'Dasmarinas');
INSERT INTO `cities` VALUES ('39', '42', 'Imus');
INSERT INTO `cities` VALUES ('40', '42', 'Maragondon');
INSERT INTO `cities` VALUES ('41', '42', 'Rosario');
INSERT INTO `cities` VALUES ('42', '42', 'Ternate');
INSERT INTO `cities` VALUES ('43', '42', 'Bacoor');
INSERT INTO `cities` VALUES ('44', '42', 'General Emilio Aguinaldo');
INSERT INTO `cities` VALUES ('45', '42', 'Indang');
INSERT INTO `cities` VALUES ('46', '42', 'Mendez');
INSERT INTO `cities` VALUES ('47', '42', 'Silang');
INSERT INTO `cities` VALUES ('48', '42', 'Trece Martires');
INSERT INTO `cities` VALUES ('49', '42', 'Carmona');
INSERT INTO `cities` VALUES ('50', '42', 'General Mariano Alvarez');
INSERT INTO `cities` VALUES ('51', '42', 'Kawit');
INSERT INTO `cities` VALUES ('52', '42', 'Naic');
INSERT INTO `cities` VALUES ('53', '42', 'Tagaytay');
INSERT INTO `cities` VALUES ('54', '44', 'Agdanga');
INSERT INTO `cities` VALUES ('55', '44', 'Burdeos');
INSERT INTO `cities` VALUES ('56', '44', 'Gumaca');
INSERT INTO `cities` VALUES ('57', '44', 'Lucban');
INSERT INTO `cities` VALUES ('58', '44', 'Mulanay');
INSERT INTO `cities` VALUES ('59', '44', 'Patnanungan');
INSERT INTO `cities` VALUES ('60', '44', 'Polilio');
INSERT INTO `cities` VALUES ('61', '44', 'San Andres');
INSERT INTO `cities` VALUES ('62', '44', 'Sariaya');
INSERT INTO `cities` VALUES ('63', '44', 'Unisan');
INSERT INTO `cities` VALUES ('64', '44', 'Alabat');
INSERT INTO `cities` VALUES ('65', '44', 'Calauag');
INSERT INTO `cities` VALUES ('66', '44', 'General Luna');
INSERT INTO `cities` VALUES ('67', '44', 'Infanta');
INSERT INTO `cities` VALUES ('68', '44', 'Lucena');
INSERT INTO `cities` VALUES ('69', '44', 'Padre Burgos');
INSERT INTO `cities` VALUES ('70', '44', 'Perez');
INSERT INTO `cities` VALUES ('71', '44', 'Quezon');
INSERT INTO `cities` VALUES ('72', '44', 'San Antonio');
INSERT INTO `cities` VALUES ('73', '44', 'Tagkawayan');
INSERT INTO `cities` VALUES ('74', '44', 'Atimonan');
INSERT INTO `cities` VALUES ('75', '44', 'Candelaria');
INSERT INTO `cities` VALUES ('76', '44', 'General Nakar');
INSERT INTO `cities` VALUES ('77', '44', 'Jomalig');
INSERT INTO `cities` VALUES ('78', '44', 'Macalelon');
INSERT INTO `cities` VALUES ('79', '44', 'Pagbilao');
INSERT INTO `cities` VALUES ('80', '44', 'Pitogo');
INSERT INTO `cities` VALUES ('81', '44', 'Real');
INSERT INTO `cities` VALUES ('82', '44', 'San Francisco (Aurora)');
INSERT INTO `cities` VALUES ('83', '44', 'Tayabas');
INSERT INTO `cities` VALUES ('84', '44', 'Buenavista');
INSERT INTO `cities` VALUES ('85', '44', 'Catanauan');
INSERT INTO `cities` VALUES ('86', '44', 'Guinayangan');
INSERT INTO `cities` VALUES ('87', '44', 'Lopez');
INSERT INTO `cities` VALUES ('88', '44', 'Mauban');
INSERT INTO `cities` VALUES ('89', '44', 'Panukulan');
INSERT INTO `cities` VALUES ('90', '44', 'Plaridel');
INSERT INTO `cities` VALUES ('91', '44', 'Sampaloc');
INSERT INTO `cities` VALUES ('92', '44', 'San Narciso');
INSERT INTO `cities` VALUES ('93', '44', 'Tiaong');
INSERT INTO `cities` VALUES ('94', '41', 'Agoncillo');
INSERT INTO `cities` VALUES ('95', '41', 'Batangas City');
INSERT INTO `cities` VALUES ('96', '41', 'Cuenca');
INSERT INTO `cities` VALUES ('97', '41', 'Lian');
INSERT INTO `cities` VALUES ('98', '41', 'Malvar');
INSERT INTO `cities` VALUES ('99', '41', 'Rosario');
INSERT INTO `cities` VALUES ('100', '41', 'San Nicolas');
INSERT INTO `cities` VALUES ('101', '41', 'Taal');
INSERT INTO `cities` VALUES ('102', '41', 'Tingloy');
INSERT INTO `cities` VALUES ('103', '41', 'Alitagtag');
INSERT INTO `cities` VALUES ('104', '41', 'Bauan');
INSERT INTO `cities` VALUES ('105', '41', 'Ibaan');
INSERT INTO `cities` VALUES ('106', '41', 'Lipa');
INSERT INTO `cities` VALUES ('107', '41', 'Mataas na kahoy');
INSERT INTO `cities` VALUES ('108', '41', 'San Jose');
INSERT INTO `cities` VALUES ('109', '41', 'San Pascual');
INSERT INTO `cities` VALUES ('110', '41', 'Talisay');
INSERT INTO `cities` VALUES ('111', '41', 'Tuy');
INSERT INTO `cities` VALUES ('112', '41', 'Balayan');
INSERT INTO `cities` VALUES ('113', '41', 'Calaca');
INSERT INTO `cities` VALUES ('114', '41', 'Laurel');
INSERT INTO `cities` VALUES ('115', '41', 'Lobo');
INSERT INTO `cities` VALUES ('116', '41', 'Nasugbu');
INSERT INTO `cities` VALUES ('117', '41', 'San Juan');
INSERT INTO `cities` VALUES ('118', '41', 'Santa Teresita');
INSERT INTO `cities` VALUES ('119', '41', 'Tanauan');
INSERT INTO `cities` VALUES ('120', '41', 'Balete');
INSERT INTO `cities` VALUES ('121', '41', 'Calatagan');
INSERT INTO `cities` VALUES ('122', '41', 'Lemery');
INSERT INTO `cities` VALUES ('123', '41', 'Mabini');
INSERT INTO `cities` VALUES ('124', '41', 'Padre Garcia');
INSERT INTO `cities` VALUES ('125', '41', 'San Luis');
INSERT INTO `cities` VALUES ('126', '41', 'Santo Tomas');
INSERT INTO `cities` VALUES ('127', '41', 'Taysan');
INSERT INTO `cities` VALUES ('128', '45', 'Angono');
INSERT INTO `cities` VALUES ('129', '45', 'Cainta');
INSERT INTO `cities` VALUES ('130', '45', 'Pililla');
INSERT INTO `cities` VALUES ('131', '45', 'Taytay');
INSERT INTO `cities` VALUES ('132', '45', 'Antipolo');
INSERT INTO `cities` VALUES ('133', '45', 'Cardona');
INSERT INTO `cities` VALUES ('134', '45', 'Montalban/Rodriquez');
INSERT INTO `cities` VALUES ('135', '45', 'Teresa');
INSERT INTO `cities` VALUES ('136', '45', 'Baras');
INSERT INTO `cities` VALUES ('137', '45', 'Jalajala');
INSERT INTO `cities` VALUES ('138', '45', 'San Mateo');
INSERT INTO `cities` VALUES ('139', '45', 'Binangonan');
INSERT INTO `cities` VALUES ('140', '45', 'Morong');
INSERT INTO `cities` VALUES ('141', '45', 'Tanay');
INSERT INTO `cities` VALUES ('142', '1', 'Bangued');
INSERT INTO `cities` VALUES ('143', '1', 'Daguioman');
INSERT INTO `cities` VALUES ('144', '1', 'Lacub');
INSERT INTO `cities` VALUES ('145', '1', 'Licuan-baay');
INSERT INTO `cities` VALUES ('146', '1', 'Penarrubia');
INSERT INTO `cities` VALUES ('147', '1', 'San Isidro');
INSERT INTO `cities` VALUES ('148', '1', 'Tineg');
INSERT INTO `cities` VALUES ('149', '1', 'Boliney');
INSERT INTO `cities` VALUES ('150', '1', 'Danglas');
INSERT INTO `cities` VALUES ('151', '1', 'Lagangilang');
INSERT INTO `cities` VALUES ('152', '1', 'Luba');
INSERT INTO `cities` VALUES ('153', '1', 'Pidigan');
INSERT INTO `cities` VALUES ('154', '1', 'San Juan');
INSERT INTO `cities` VALUES ('155', '1', 'Tubo');
INSERT INTO `cities` VALUES ('156', '1', 'Bucay');
INSERT INTO `cities` VALUES ('157', '1', 'Dolores');
INSERT INTO `cities` VALUES ('158', '1', 'Lagayan');
INSERT INTO `cities` VALUES ('159', '1', 'Malibcong');
INSERT INTO `cities` VALUES ('160', '1', 'Pilar');
INSERT INTO `cities` VALUES ('161', '1', 'San Quintin');
INSERT INTO `cities` VALUES ('162', '1', 'Villaviciosa');
INSERT INTO `cities` VALUES ('163', '1', 'Bucloc');
INSERT INTO `cities` VALUES ('164', '1', 'La Paz');
INSERT INTO `cities` VALUES ('165', '1', 'Langiden');
INSERT INTO `cities` VALUES ('166', '1', 'Manabo');
INSERT INTO `cities` VALUES ('167', '1', 'Sallapadan');
INSERT INTO `cities` VALUES ('168', '1', 'Tayum');
INSERT INTO `cities` VALUES ('169', '2', 'Calanasan');
INSERT INTO `cities` VALUES ('170', '2', 'Luna');
INSERT INTO `cities` VALUES ('171', '2', 'Conner');
INSERT INTO `cities` VALUES ('172', '2', 'Pudtol');
INSERT INTO `cities` VALUES ('173', '2', 'Flora');
INSERT INTO `cities` VALUES ('174', '2', 'Santa Marcela');
INSERT INTO `cities` VALUES ('175', '2', 'Kabugao');
INSERT INTO `cities` VALUES ('176', '3', 'Atok');
INSERT INTO `cities` VALUES ('177', '3', 'Buguias');
INSERT INTO `cities` VALUES ('178', '3', 'Kibungan');
INSERT INTO `cities` VALUES ('179', '3', 'Tuba');
INSERT INTO `cities` VALUES ('180', '3', 'Baguio');
INSERT INTO `cities` VALUES ('181', '3', 'Itogon');
INSERT INTO `cities` VALUES ('182', '3', 'La Trinidad');
INSERT INTO `cities` VALUES ('183', '3', 'Tublay');
INSERT INTO `cities` VALUES ('184', '3', 'Bakun');
INSERT INTO `cities` VALUES ('185', '3', 'Kabayan');
INSERT INTO `cities` VALUES ('186', '3', 'Mankayan');
INSERT INTO `cities` VALUES ('187', '3', 'Bokod');
INSERT INTO `cities` VALUES ('188', '3', 'Kapangan');
INSERT INTO `cities` VALUES ('189', '3', 'Sablan');
INSERT INTO `cities` VALUES ('190', '4', 'Aguinaldo');
INSERT INTO `cities` VALUES ('191', '4', 'Hingyon');
INSERT INTO `cities` VALUES ('192', '4', 'Lamut');
INSERT INTO `cities` VALUES ('193', '4', 'Alfonso Lista (Potia)');
INSERT INTO `cities` VALUES ('194', '4', 'Hungduan');
INSERT INTO `cities` VALUES ('195', '4', 'Mayoyao');
INSERT INTO `cities` VALUES ('196', '4', 'Asipulo');
INSERT INTO `cities` VALUES ('197', '4', 'Kiangan');
INSERT INTO `cities` VALUES ('198', '4', 'Tinoc');
INSERT INTO `cities` VALUES ('199', '4', 'Banaue');
INSERT INTO `cities` VALUES ('200', '4', 'Lagawe');
INSERT INTO `cities` VALUES ('201', '5', 'Balbalan');
INSERT INTO `cities` VALUES ('202', '5', 'Rizal (Liwan)');
INSERT INTO `cities` VALUES ('203', '5', 'Lubuagan');
INSERT INTO `cities` VALUES ('204', '5', 'Tabuk');
INSERT INTO `cities` VALUES ('205', '5', 'Pasil');
INSERT INTO `cities` VALUES ('206', '5', 'Tanudan');
INSERT INTO `cities` VALUES ('207', '5', 'Pinukpuk');
INSERT INTO `cities` VALUES ('208', '5', 'Tinglayan');
INSERT INTO `cities` VALUES ('209', '6', 'Barlig');
INSERT INTO `cities` VALUES ('210', '6', 'Natonin');
INSERT INTO `cities` VALUES ('211', '6', 'Sagada');
INSERT INTO `cities` VALUES ('212', '6', 'Bauko');
INSERT INTO `cities` VALUES ('213', '6', 'Paracelis');
INSERT INTO `cities` VALUES ('214', '6', 'Tadian');
INSERT INTO `cities` VALUES ('215', '6', 'Besao');
INSERT INTO `cities` VALUES ('216', '6', 'Sabangan');
INSERT INTO `cities` VALUES ('217', '6', 'Bontoc');
INSERT INTO `cities` VALUES ('218', '6', 'Sadanga');
INSERT INTO `cities` VALUES ('219', '7', 'Adams');
INSERT INTO `cities` VALUES ('220', '7', 'Banna (Espiritu)');
INSERT INTO `cities` VALUES ('221', '7', 'Currimao');
INSERT INTO `cities` VALUES ('222', '7', 'Marcos');
INSERT INTO `cities` VALUES ('223', '7', 'Pasuquin');
INSERT INTO `cities` VALUES ('224', '7', 'Sarrat');
INSERT INTO `cities` VALUES ('225', '7', 'Bacarra');
INSERT INTO `cities` VALUES ('226', '7', 'Batac');
INSERT INTO `cities` VALUES ('227', '7', 'Dingras');
INSERT INTO `cities` VALUES ('228', '7', 'Nueva Era');
INSERT INTO `cities` VALUES ('229', '7', 'Piddig');
INSERT INTO `cities` VALUES ('230', '7', 'Solsona');
INSERT INTO `cities` VALUES ('231', '7', 'Badoc');
INSERT INTO `cities` VALUES ('232', '7', 'Burgos');
INSERT INTO `cities` VALUES ('233', '7', 'Dumalneg');
INSERT INTO `cities` VALUES ('234', '7', 'Pagudpud');
INSERT INTO `cities` VALUES ('235', '7', 'Pinili');
INSERT INTO `cities` VALUES ('236', '7', 'Vintar');
INSERT INTO `cities` VALUES ('237', '7', 'Bangui');
INSERT INTO `cities` VALUES ('238', '7', 'Carasi');
INSERT INTO `cities` VALUES ('239', '7', 'Laoag');
INSERT INTO `cities` VALUES ('240', '7', 'Paoay');
INSERT INTO `cities` VALUES ('241', '7', 'San Nicolas');
INSERT INTO `cities` VALUES ('242', '8', 'Alilem');
INSERT INTO `cities` VALUES ('243', '8', 'Cabugao');
INSERT INTO `cities` VALUES ('244', '8', 'Galimuyod');
INSERT INTO `cities` VALUES ('245', '8', 'Nagbukel');
INSERT INTO `cities` VALUES ('246', '8', 'San Emilio');
INSERT INTO `cities` VALUES ('247', '8', 'San Vicente');
INSERT INTO `cities` VALUES ('248', '8', 'Santa Lucia');
INSERT INTO `cities` VALUES ('249', '8', 'Sigay');
INSERT INTO `cities` VALUES ('250', '8', 'Tagudin');
INSERT INTO `cities` VALUES ('251', '8', 'Banayoyo');
INSERT INTO `cities` VALUES ('252', '8', 'Candon');
INSERT INTO `cities` VALUES ('253', '8', 'Gregorio del Pilar (Concepcion)');
INSERT INTO `cities` VALUES ('254', '8', 'Narvacan');
INSERT INTO `cities` VALUES ('255', '8', 'San Esteban');
INSERT INTO `cities` VALUES ('256', '8', 'Santa');
INSERT INTO `cities` VALUES ('257', '8', 'Santa Maria');
INSERT INTO `cities` VALUES ('258', '8', 'Sinait');
INSERT INTO `cities` VALUES ('259', '8', 'Vigan');
INSERT INTO `cities` VALUES ('260', '8', 'Bantay');
INSERT INTO `cities` VALUES ('261', '8', 'Caoayan');
INSERT INTO `cities` VALUES ('262', '8', 'Lidlidda');
INSERT INTO `cities` VALUES ('263', '8', 'Quirino (Angkaki)');
INSERT INTO `cities` VALUES ('264', '8', 'San Ildefonso');
INSERT INTO `cities` VALUES ('265', '8', 'Santa Catalina');
INSERT INTO `cities` VALUES ('266', '8', 'Santiago');
INSERT INTO `cities` VALUES ('267', '8', 'Sugpon');
INSERT INTO `cities` VALUES ('268', '8', 'Burgos');
INSERT INTO `cities` VALUES ('269', '8', 'Cervantes');
INSERT INTO `cities` VALUES ('270', '8', 'Magsingal');
INSERT INTO `cities` VALUES ('271', '8', 'Salcedo (Baugen)');
INSERT INTO `cities` VALUES ('272', '8', 'San Juan (Lapog)');
INSERT INTO `cities` VALUES ('273', '8', 'Santa Cruz');
INSERT INTO `cities` VALUES ('274', '8', 'Santo Domingo');
INSERT INTO `cities` VALUES ('275', '8', 'Suyo');
INSERT INTO `cities` VALUES ('276', '9', 'Agoo');
INSERT INTO `cities` VALUES ('277', '9', 'Balaoan');
INSERT INTO `cities` VALUES ('278', '9', 'Caba');
INSERT INTO `cities` VALUES ('279', '9', 'Rosario');
INSERT INTO `cities` VALUES ('280', '9', 'Santo Tomas');
INSERT INTO `cities` VALUES ('281', '9', 'Aringay');
INSERT INTO `cities` VALUES ('282', '9', 'Bangar');
INSERT INTO `cities` VALUES ('283', '9', 'Luna');
INSERT INTO `cities` VALUES ('284', '9', 'San Fernando');
INSERT INTO `cities` VALUES ('285', '9', 'Santol');
INSERT INTO `cities` VALUES ('286', '9', 'Bacnotan');
INSERT INTO `cities` VALUES ('287', '9', 'Bauang');
INSERT INTO `cities` VALUES ('288', '9', 'Naguilian');
INSERT INTO `cities` VALUES ('289', '9', 'San Gabriel');
INSERT INTO `cities` VALUES ('290', '9', 'Sudipen');
INSERT INTO `cities` VALUES ('291', '9', 'Bagulin');
INSERT INTO `cities` VALUES ('292', '9', 'Burgos');
INSERT INTO `cities` VALUES ('293', '9', 'Pugo');
INSERT INTO `cities` VALUES ('294', '9', 'San Juan');
INSERT INTO `cities` VALUES ('297', '9', 'Tubao');
INSERT INTO `cities` VALUES ('298', '10', 'Agno');
INSERT INTO `cities` VALUES ('299', '10', 'Anda');
INSERT INTO `cities` VALUES ('300', '10', 'Basista');
INSERT INTO `cities` VALUES ('301', '10', 'Binmaley');
INSERT INTO `cities` VALUES ('302', '10', 'Calasiao');
INSERT INTO `cities` VALUES ('303', '10', 'Labrador');
INSERT INTO `cities` VALUES ('304', '10', 'Malsiqui');
INSERT INTO `cities` VALUES ('305', '10', 'Mapandan');
INSERT INTO `cities` VALUES ('306', '10', 'San Carlos');
INSERT INTO `cities` VALUES ('307', '10', 'San Nicolas');
INSERT INTO `cities` VALUES ('308', '10', 'Santo Tomas');
INSERT INTO `cities` VALUES ('309', '10', 'Umingan');
INSERT INTO `cities` VALUES ('310', '10', 'Aguilar');
INSERT INTO `cities` VALUES ('311', '10', 'Asingan');
INSERT INTO `cities` VALUES ('312', '10', 'Bautista');
INSERT INTO `cities` VALUES ('313', '10', 'Bolinao');
INSERT INTO `cities` VALUES ('314', '10', 'Dagupan');
INSERT INTO `cities` VALUES ('315', '10', 'Laoac');
INSERT INTO `cities` VALUES ('316', '10', 'Manaoag');
INSERT INTO `cities` VALUES ('317', '10', 'Natividad');
INSERT INTO `cities` VALUES ('318', '10', 'San Fabian');
INSERT INTO `cities` VALUES ('319', '10', 'San Quintin');
INSERT INTO `cities` VALUES ('320', '10', 'Sison');
INSERT INTO `cities` VALUES ('321', '10', 'Urbiztondo');
INSERT INTO `cities` VALUES ('322', '10', 'Alaminos');
INSERT INTO `cities` VALUES ('323', '10', 'Balungao');
INSERT INTO `cities` VALUES ('324', '10', 'Bayambang');
INSERT INTO `cities` VALUES ('325', '10', 'Bugallon');
INSERT INTO `cities` VALUES ('326', '10', 'Dasol');
INSERT INTO `cities` VALUES ('327', '10', 'Lingayen');
INSERT INTO `cities` VALUES ('328', '10', 'Mangaldan');
INSERT INTO `cities` VALUES ('329', '10', 'Pozorrubio');
INSERT INTO `cities` VALUES ('330', '10', 'San Jacinto');
INSERT INTO `cities` VALUES ('331', '10', 'Santa Barbara');
INSERT INTO `cities` VALUES ('332', '10', 'Sual');
INSERT INTO `cities` VALUES ('333', '10', 'Urdaneta');
INSERT INTO `cities` VALUES ('334', '10', 'Alcala');
INSERT INTO `cities` VALUES ('335', '10', 'Bani');
INSERT INTO `cities` VALUES ('336', '10', 'Binalonan');
INSERT INTO `cities` VALUES ('337', '10', 'Burgos');
INSERT INTO `cities` VALUES ('338', '10', 'Infanta');
INSERT INTO `cities` VALUES ('339', '10', 'Mabini');
INSERT INTO `cities` VALUES ('340', '10', 'Mangatarem');
INSERT INTO `cities` VALUES ('341', '10', 'Rosales');
INSERT INTO `cities` VALUES ('342', '10', 'San Manuel');
INSERT INTO `cities` VALUES ('343', '10', 'Santa Maria');
INSERT INTO `cities` VALUES ('344', '10', 'Tayug');
INSERT INTO `cities` VALUES ('345', '10', 'Villasis');
INSERT INTO `cities` VALUES ('346', '11', 'Basco');
INSERT INTO `cities` VALUES ('347', '11', 'Sabtang');
INSERT INTO `cities` VALUES ('348', '11', 'Itbayat');
INSERT INTO `cities` VALUES ('349', '11', 'Uyugan');
INSERT INTO `cities` VALUES ('350', '11', 'Ivana');
INSERT INTO `cities` VALUES ('351', '11', 'Mahatao');
INSERT INTO `cities` VALUES ('352', '12', 'Abulug');
INSERT INTO `cities` VALUES ('353', '12', 'Aparri');
INSERT INTO `cities` VALUES ('354', '12', 'Calayan');
INSERT INTO `cities` VALUES ('355', '12', 'Gattaran');
INSERT INTO `cities` VALUES ('356', '12', 'Lasam');
INSERT INTO `cities` VALUES ('357', '12', 'Rizal');
INSERT INTO `cities` VALUES ('358', '12', 'Santa Teresita');
INSERT INTO `cities` VALUES ('359', '12', 'Tuguegarao');
INSERT INTO `cities` VALUES ('360', '12', 'Alcala');
INSERT INTO `cities` VALUES ('361', '12', 'Baggao');
INSERT INTO `cities` VALUES ('362', '12', 'Camalaniugan');
INSERT INTO `cities` VALUES ('363', '12', 'Gonzaga');
INSERT INTO `cities` VALUES ('364', '12', 'Pamplona');
INSERT INTO `cities` VALUES ('365', '12', 'Sanchez-Mira');
INSERT INTO `cities` VALUES ('366', '12', 'Santo Nino (Faire)');
INSERT INTO `cities` VALUES ('367', '12', 'Allacapan');
INSERT INTO `cities` VALUES ('368', '12', 'Ballesteros');
INSERT INTO `cities` VALUES ('369', '12', 'Claveria');
INSERT INTO `cities` VALUES ('370', '12', 'Iguig');
INSERT INTO `cities` VALUES ('371', '12', 'Penablanca');
INSERT INTO `cities` VALUES ('372', '12', 'Santa Ana');
INSERT INTO `cities` VALUES ('373', '12', 'Solana');
INSERT INTO `cities` VALUES ('375', '12', 'Amulung');
INSERT INTO `cities` VALUES ('376', '12', 'Buguey');
INSERT INTO `cities` VALUES ('377', '12', 'Enrile');
INSERT INTO `cities` VALUES ('378', '12', 'Lal-lo');
INSERT INTO `cities` VALUES ('379', '12', 'Piat');
INSERT INTO `cities` VALUES ('380', '12', 'Santa Praxedes');
INSERT INTO `cities` VALUES ('381', '12', 'Tuao');
INSERT INTO `cities` VALUES ('382', '13', 'Alicia');
INSERT INTO `cities` VALUES ('383', '13', 'Burgos');
INSERT INTO `cities` VALUES ('384', '13', 'Cordon');
INSERT INTO `cities` VALUES ('386', '13', 'Echague');
INSERT INTO `cities` VALUES ('387', '13', 'Luna');
INSERT INTO `cities` VALUES ('388', '13', 'Palanan');
INSERT INTO `cities` VALUES ('389', '13', 'Reina Mercedes');
INSERT INTO `cities` VALUES ('390', '13', 'San Isidro');
INSERT INTO `cities` VALUES ('391', '13', 'San Pablo');
INSERT INTO `cities` VALUES ('392', '13', 'Tumauini');
INSERT INTO `cities` VALUES ('393', '13', 'Angadanan');
INSERT INTO `cities` VALUES ('394', '13', 'Cabagan');
INSERT INTO `cities` VALUES ('395', '13', 'Delfin Albano (Magsaysay)');
INSERT INTO `cities` VALUES ('396', '13', 'Gamu');
INSERT INTO `cities` VALUES ('397', '13', 'Maconacon');
INSERT INTO `cities` VALUES ('398', '13', 'Quezon');
INSERT INTO `cities` VALUES ('399', '13', 'Roxas');
INSERT INTO `cities` VALUES ('400', '13', 'San Manuel (Callang)');
INSERT INTO `cities` VALUES ('401', '13', 'Santa Maria');
INSERT INTO `cities` VALUES ('402', '13', 'Aurora');
INSERT INTO `cities` VALUES ('403', '13', 'Cabatuan');
INSERT INTO `cities` VALUES ('404', '13', 'Dinapigue');
INSERT INTO `cities` VALUES ('405', '13', 'Ilagan');
INSERT INTO `cities` VALUES ('406', '13', 'Mallig');
INSERT INTO `cities` VALUES ('407', '13', 'Quirino');
INSERT INTO `cities` VALUES ('408', '13', 'San Agustin');
INSERT INTO `cities` VALUES ('409', '13', 'San Mariano');
INSERT INTO `cities` VALUES ('410', '13', 'Santiago');
INSERT INTO `cities` VALUES ('411', '13', 'Benito Soliven');
INSERT INTO `cities` VALUES ('412', '13', 'Cauayan');
INSERT INTO `cities` VALUES ('413', '13', 'Divilacan');
INSERT INTO `cities` VALUES ('414', '13', 'Jones');
INSERT INTO `cities` VALUES ('415', '13', 'Naguilian');
INSERT INTO `cities` VALUES ('416', '13', 'Ramon');
INSERT INTO `cities` VALUES ('417', '13', 'San Guillermo');
INSERT INTO `cities` VALUES ('418', '13', 'San Mateo');
INSERT INTO `cities` VALUES ('419', '13', 'Santo Tomas');
INSERT INTO `cities` VALUES ('420', '14', 'Alfonso Castaneda');
INSERT INTO `cities` VALUES ('421', '14', 'Bambang');
INSERT INTO `cities` VALUES ('422', '14', 'Dupax del Sur');
INSERT INTO `cities` VALUES ('423', '14', 'Santa Fe (Imugan)');
INSERT INTO `cities` VALUES ('424', '14', 'Ambaguio');
INSERT INTO `cities` VALUES ('425', '14', 'Bayombong');
INSERT INTO `cities` VALUES ('426', '14', 'Kasibu');
INSERT INTO `cities` VALUES ('427', '14', 'Solano');
INSERT INTO `cities` VALUES ('428', '14', 'Aritao');
INSERT INTO `cities` VALUES ('429', '14', 'Diadi');
INSERT INTO `cities` VALUES ('430', '14', 'Kayapa');
INSERT INTO `cities` VALUES ('431', '14', 'Villaverde (Ibung)');
INSERT INTO `cities` VALUES ('432', '14', 'Bagabag');
INSERT INTO `cities` VALUES ('433', '14', 'Dupax del Norte');
INSERT INTO `cities` VALUES ('434', '14', 'Quezon');
INSERT INTO `cities` VALUES ('435', '15', 'Aglipay');
INSERT INTO `cities` VALUES ('436', '15', 'Nagtipunan');
INSERT INTO `cities` VALUES ('437', '15', 'Cabarroguis');
INSERT INTO `cities` VALUES ('438', '15', 'Saguday');
INSERT INTO `cities` VALUES ('439', '15', 'Diffun');
INSERT INTO `cities` VALUES ('440', '15', 'Maddela');
INSERT INTO `cities` VALUES ('441', '16', 'Baler');
INSERT INTO `cities` VALUES ('442', '16', 'Dingalan');
INSERT INTO `cities` VALUES ('443', '16', 'Casiguran');
INSERT INTO `cities` VALUES ('444', '16', 'Dipaculao');
INSERT INTO `cities` VALUES ('445', '16', 'DIlasag');
INSERT INTO `cities` VALUES ('446', '16', 'Maria Aurora');
INSERT INTO `cities` VALUES ('447', '16', 'Dinalungan');
INSERT INTO `cities` VALUES ('448', '16', 'San Luis');
INSERT INTO `cities` VALUES ('449', '17', 'Hermosa');
INSERT INTO `cities` VALUES ('450', '17', 'Orani');
INSERT INTO `cities` VALUES ('451', '17', 'Bagac');
INSERT INTO `cities` VALUES ('452', '17', 'Limay');
INSERT INTO `cities` VALUES ('453', '17', 'Orion');
INSERT INTO `cities` VALUES ('454', '17', 'Balanga');
INSERT INTO `cities` VALUES ('455', '17', 'Mariveles');
INSERT INTO `cities` VALUES ('456', '17', 'Pilar');
INSERT INTO `cities` VALUES ('457', '17', 'Dinalupihan');
INSERT INTO `cities` VALUES ('458', '17', 'Morong');
INSERT INTO `cities` VALUES ('459', '17', 'Samal');
INSERT INTO `cities` VALUES ('460', '18', 'Angat');
INSERT INTO `cities` VALUES ('461', '18', 'Bulakan');
INSERT INTO `cities` VALUES ('462', '18', 'Guiguinto');
INSERT INTO `cities` VALUES ('463', '18', 'Meycauayan');
INSERT INTO `cities` VALUES ('464', '18', 'Paombong');
INSERT INTO `cities` VALUES ('465', '18', 'San Jose del Monte');
INSERT INTO `cities` VALUES ('466', '18', 'Balagtas');
INSERT INTO `cities` VALUES ('467', '18', 'Bustos');
INSERT INTO `cities` VALUES ('468', '18', 'Hagonoy');
INSERT INTO `cities` VALUES ('469', '18', 'Norzagaray');
INSERT INTO `cities` VALUES ('470', '18', 'Plaridel');
INSERT INTO `cities` VALUES ('471', '18', 'San Miguel');
INSERT INTO `cities` VALUES ('472', '18', 'Baliuag');
INSERT INTO `cities` VALUES ('473', '18', 'Calumpit');
INSERT INTO `cities` VALUES ('474', '18', 'Malolos');
INSERT INTO `cities` VALUES ('475', '18', 'Obando');
INSERT INTO `cities` VALUES ('476', '18', 'Pulilan');
INSERT INTO `cities` VALUES ('477', '18', 'San Rafael');
INSERT INTO `cities` VALUES ('478', '18', 'Bocaue');
INSERT INTO `cities` VALUES ('479', '18', 'Dona Remedios Trinidad');
INSERT INTO `cities` VALUES ('480', '18', 'Marilao');
INSERT INTO `cities` VALUES ('481', '18', 'Pandi');
INSERT INTO `cities` VALUES ('482', '18', 'San Ildefonso');
INSERT INTO `cities` VALUES ('483', '18', 'Santa Maria');
INSERT INTO `cities` VALUES ('484', '19', 'Aliaga');
INSERT INTO `cities` VALUES ('485', '19', 'Carranglan');
INSERT INTO `cities` VALUES ('486', '19', 'General Mamerto Natividad');
INSERT INTO `cities` VALUES ('487', '19', 'Laur');
INSERT INTO `cities` VALUES ('488', '19', 'Munoz');
INSERT INTO `cities` VALUES ('489', '19', 'Penaranda');
INSERT INTO `cities` VALUES ('490', '19', 'San Isidro');
INSERT INTO `cities` VALUES ('491', '19', 'Santo Domingo');
INSERT INTO `cities` VALUES ('492', '19', 'Bongabon');
INSERT INTO `cities` VALUES ('493', '19', 'Cuyapo');
INSERT INTO `cities` VALUES ('494', '19', 'General Tinio (Papaya)');
INSERT INTO `cities` VALUES ('495', '19', 'Licab');
INSERT INTO `cities` VALUES ('496', '19', 'Nampicuan');
INSERT INTO `cities` VALUES ('497', '19', 'Quezon');
INSERT INTO `cities` VALUES ('498', '19', 'San Jose');
INSERT INTO `cities` VALUES ('499', '19', 'Talavera');
INSERT INTO `cities` VALUES ('500', '19', 'Cabanatuan');
INSERT INTO `cities` VALUES ('501', '19', 'Gabaldon');
INSERT INTO `cities` VALUES ('502', '19', 'Guimba');
INSERT INTO `cities` VALUES ('503', '19', 'Llanera');
INSERT INTO `cities` VALUES ('504', '19', 'Palayan');
INSERT INTO `cities` VALUES ('505', '19', 'Rizal');
INSERT INTO `cities` VALUES ('506', '19', 'San Leonardo');
INSERT INTO `cities` VALUES ('507', '19', 'Talugtug');
INSERT INTO `cities` VALUES ('508', '19', 'Cabiao');
INSERT INTO `cities` VALUES ('509', '19', 'Gapan');
INSERT INTO `cities` VALUES ('510', '19', 'Jaen');
INSERT INTO `cities` VALUES ('511', '19', 'Lupao');
INSERT INTO `cities` VALUES ('512', '19', 'Pantangan');
INSERT INTO `cities` VALUES ('513', '19', 'San Antonio');
INSERT INTO `cities` VALUES ('515', '19', 'Santa Rosa');
INSERT INTO `cities` VALUES ('516', '19', 'Zaragoza');
INSERT INTO `cities` VALUES ('517', '20', 'Angeles');
INSERT INTO `cities` VALUES ('518', '20', 'Candaba');
INSERT INTO `cities` VALUES ('519', '20', 'Mabalacat');
INSERT INTO `cities` VALUES ('520', '20', 'Mexico');
INSERT INTO `cities` VALUES ('521', '20', 'San Luis');
INSERT INTO `cities` VALUES ('522', '20', 'Santo Tomas');
INSERT INTO `cities` VALUES ('523', '20', 'Apalit');
INSERT INTO `cities` VALUES ('524', '20', 'Floridablanca');
INSERT INTO `cities` VALUES ('525', '20', 'Macabebe');
INSERT INTO `cities` VALUES ('526', '20', 'Minalim');
INSERT INTO `cities` VALUES ('527', '20', 'San Simon');
INSERT INTO `cities` VALUES ('528', '20', 'Sasmuan');
INSERT INTO `cities` VALUES ('529', '20', 'Arayat');
INSERT INTO `cities` VALUES ('530', '20', 'Guagua');
INSERT INTO `cities` VALUES ('531', '20', 'Magalang');
INSERT INTO `cities` VALUES ('533', '20', 'Porac');
INSERT INTO `cities` VALUES ('534', '20', 'Santa Ana');
INSERT INTO `cities` VALUES ('535', '20', 'Bacolor');
INSERT INTO `cities` VALUES ('536', '20', 'Lubao');
INSERT INTO `cities` VALUES ('537', '20', 'Masantol');
INSERT INTO `cities` VALUES ('538', '20', 'San Fernando');
INSERT INTO `cities` VALUES ('539', '20', 'Santa Rita');
INSERT INTO `cities` VALUES ('540', '21', 'Anao');
INSERT INTO `cities` VALUES ('541', '21', 'Concepcion');
INSERT INTO `cities` VALUES ('542', '21', 'Moncada');
INSERT INTO `cities` VALUES ('543', '21', 'San Clemente');
INSERT INTO `cities` VALUES ('544', '21', 'Tarlac City');
INSERT INTO `cities` VALUES ('545', '21', 'Bamban');
INSERT INTO `cities` VALUES ('546', '21', 'Gerona');
INSERT INTO `cities` VALUES ('547', '21', 'Paniqui');
INSERT INTO `cities` VALUES ('548', '21', 'San Jose');
INSERT INTO `cities` VALUES ('549', '21', 'Victoria');
INSERT INTO `cities` VALUES ('550', '21', 'Camiling');
INSERT INTO `cities` VALUES ('551', '21', 'La Paz');
INSERT INTO `cities` VALUES ('552', '21', 'Pura');
INSERT INTO `cities` VALUES ('553', '21', 'San Miguel');
INSERT INTO `cities` VALUES ('554', '21', 'Capas');
INSERT INTO `cities` VALUES ('555', '21', 'Mayantoc');
INSERT INTO `cities` VALUES ('556', '21', 'Ramos');
INSERT INTO `cities` VALUES ('557', '21', 'Santa Ignacia');
INSERT INTO `cities` VALUES ('558', '22', 'Botolan');
INSERT INTO `cities` VALUES ('559', '22', 'Iba');
INSERT INTO `cities` VALUES ('560', '22', 'San Antonio');
INSERT INTO `cities` VALUES ('561', '22', 'Santa Cruz');
INSERT INTO `cities` VALUES ('562', '22', 'Cabangan');
INSERT INTO `cities` VALUES ('563', '22', 'Masinloc');
INSERT INTO `cities` VALUES ('564', '22', 'San Felipe');
INSERT INTO `cities` VALUES ('565', '22', 'Subic');
INSERT INTO `cities` VALUES ('566', '22', 'Candelaria');
INSERT INTO `cities` VALUES ('567', '22', 'Olongapo');
INSERT INTO `cities` VALUES ('568', '22', 'San Marcelino');
INSERT INTO `cities` VALUES ('569', '22', 'Castallejos');
INSERT INTO `cities` VALUES ('570', '22', 'Palauig');
INSERT INTO `cities` VALUES ('571', '22', 'San Narciso');
INSERT INTO `cities` VALUES ('572', '23', 'Manila');
INSERT INTO `cities` VALUES ('573', '24', 'Mandaluyong');
INSERT INTO `cities` VALUES ('574', '24', 'San Juan');
INSERT INTO `cities` VALUES ('575', '24', 'Marikina');
INSERT INTO `cities` VALUES ('576', '24', 'Pasig');
INSERT INTO `cities` VALUES ('577', '24', 'Quezon City');
INSERT INTO `cities` VALUES ('578', '24', 'Caloocan');
INSERT INTO `cities` VALUES ('579', '24', 'Malabon');
INSERT INTO `cities` VALUES ('580', '24', 'Navotas');
INSERT INTO `cities` VALUES ('581', '24', 'Valenzuela');
INSERT INTO `cities` VALUES ('582', '24', 'Las Pinas');
INSERT INTO `cities` VALUES ('583', '24', 'Pasay');
INSERT INTO `cities` VALUES ('584', '24', 'Makati');
INSERT INTO `cities` VALUES ('585', '24', 'Peteros');
INSERT INTO `cities` VALUES ('586', '24', 'Muntinlupa');
INSERT INTO `cities` VALUES ('587', '24', 'Taguig');
INSERT INTO `cities` VALUES ('588', '24', 'Paranaque');
INSERT INTO `cities` VALUES ('589', '46', 'Boac');
INSERT INTO `cities` VALUES ('590', '46', 'Santa Cruz');
INSERT INTO `cities` VALUES ('591', '46', 'Buenavista');
INSERT INTO `cities` VALUES ('592', '46', 'Torrijos');
INSERT INTO `cities` VALUES ('593', '46', 'Gasan');
INSERT INTO `cities` VALUES ('594', '46', 'Mogpog');
INSERT INTO `cities` VALUES ('595', '47', 'Abra de Ilog');
INSERT INTO `cities` VALUES ('596', '47', 'Magsaysay');
INSERT INTO `cities` VALUES ('597', '47', 'Sablayan');
INSERT INTO `cities` VALUES ('598', '47', 'Calintaan');
INSERT INTO `cities` VALUES ('599', '47', 'Mamburao');
INSERT INTO `cities` VALUES ('600', '47', 'San Jose');
INSERT INTO `cities` VALUES ('601', '47', 'Looc');
INSERT INTO `cities` VALUES ('602', '47', 'Paluan');
INSERT INTO `cities` VALUES ('603', '47', 'Santa Cruz');
INSERT INTO `cities` VALUES ('604', '47', 'Lubang');
INSERT INTO `cities` VALUES ('605', '47', 'Rizal');
INSERT INTO `cities` VALUES ('606', '48', 'Baco');
INSERT INTO `cities` VALUES ('607', '48', 'Bangsud');
INSERT INTO `cities` VALUES ('608', '48', 'Bongabong');
INSERT INTO `cities` VALUES ('610', '48', 'Bulalacao');
INSERT INTO `cities` VALUES ('612', '48', 'Calapan');
INSERT INTO `cities` VALUES ('613', '48', 'Gloria');
INSERT INTO `cities` VALUES ('614', '48', 'Mansalay');
INSERT INTO `cities` VALUES ('615', '48', 'Naujan');
INSERT INTO `cities` VALUES ('616', '48', 'Pinamalayan');
INSERT INTO `cities` VALUES ('617', '48', 'Pola');
INSERT INTO `cities` VALUES ('618', '48', 'Puerto Galera');
INSERT INTO `cities` VALUES ('619', '48', 'Roxas');
INSERT INTO `cities` VALUES ('620', '48', 'San Teodoro');
INSERT INTO `cities` VALUES ('621', '48', 'Socorro');
INSERT INTO `cities` VALUES ('622', '48', 'Victoria');
INSERT INTO `cities` VALUES ('623', '49', 'Aborlan');
INSERT INTO `cities` VALUES ('624', '49', 'Bataraza');
INSERT INTO `cities` VALUES ('625', '49', 'Coron');
INSERT INTO `cities` VALUES ('626', '49', 'El Nido');
INSERT INTO `cities` VALUES ('627', '49', 'Narra');
INSERT INTO `cities` VALUES ('628', '49', 'Roxas');
INSERT INTO `cities` VALUES ('629', '49', 'Agutaya');
INSERT INTO `cities` VALUES ('630', '49', 'Brooke\'s Point');
INSERT INTO `cities` VALUES ('631', '49', 'Colion');
INSERT INTO `cities` VALUES ('632', '49', 'Kalayaan');
INSERT INTO `cities` VALUES ('633', '49', 'Puerto Prinsesa');
INSERT INTO `cities` VALUES ('634', '49', 'San Vicente');
INSERT INTO `cities` VALUES ('635', '49', 'Araceli');
INSERT INTO `cities` VALUES ('636', '49', 'Busuanga');
INSERT INTO `cities` VALUES ('637', '49', 'Cuyo');
INSERT INTO `cities` VALUES ('638', '49', 'Linapacan');
INSERT INTO `cities` VALUES ('639', '49', 'Quezon');
INSERT INTO `cities` VALUES ('640', '49', 'Sofronio Espanola');
INSERT INTO `cities` VALUES ('641', '49', 'Balabac');
INSERT INTO `cities` VALUES ('642', '49', 'Cagayancillo');
INSERT INTO `cities` VALUES ('643', '49', 'Dumaran');
INSERT INTO `cities` VALUES ('644', '49', 'Magsaysay');
INSERT INTO `cities` VALUES ('645', '49', 'Rizal');
INSERT INTO `cities` VALUES ('646', '49', 'Taytay');
INSERT INTO `cities` VALUES ('647', '50', 'Alcantara');
INSERT INTO `cities` VALUES ('648', '50', 'Concepcion');
INSERT INTO `cities` VALUES ('649', '50', 'Magdiwang');
INSERT INTO `cities` VALUES ('650', '50', 'San Andres');
INSERT INTO `cities` VALUES ('651', '50', 'Santa Maria (Imelda)');
INSERT INTO `cities` VALUES ('652', '50', 'Banton');
INSERT INTO `cities` VALUES ('653', '50', 'Corcuera');
INSERT INTO `cities` VALUES ('654', '50', 'Odiongan');
INSERT INTO `cities` VALUES ('655', '50', 'San Fernando');
INSERT INTO `cities` VALUES ('656', '50', 'Cajidiocan');
INSERT INTO `cities` VALUES ('657', '50', 'Ferrol');
INSERT INTO `cities` VALUES ('658', '50', 'Romblon');
INSERT INTO `cities` VALUES ('659', '50', 'San Jose');
INSERT INTO `cities` VALUES ('660', '50', 'Calatrava');
INSERT INTO `cities` VALUES ('661', '50', 'Looc');
INSERT INTO `cities` VALUES ('662', '50', 'San Agustin');
INSERT INTO `cities` VALUES ('663', '50', 'Santa Fe');
INSERT INTO `cities` VALUES ('664', '51', 'Bacacay');
INSERT INTO `cities` VALUES ('665', '51', 'Jovellar');
INSERT INTO `cities` VALUES ('666', '51', 'Malilipot');
INSERT INTO `cities` VALUES ('667', '51', 'Pio Duran');
INSERT INTO `cities` VALUES ('668', '51', 'Tabaco');
INSERT INTO `cities` VALUES ('669', '51', 'Camalig');
INSERT INTO `cities` VALUES ('670', '51', 'Legazpi');
INSERT INTO `cities` VALUES ('671', '51', 'Malinao');
INSERT INTO `cities` VALUES ('672', '51', 'Polangui');
INSERT INTO `cities` VALUES ('673', '51', 'Tiwi');
INSERT INTO `cities` VALUES ('674', '51', 'Daraga');
INSERT INTO `cities` VALUES ('675', '51', 'Libon');
INSERT INTO `cities` VALUES ('676', '51', 'Manito');
INSERT INTO `cities` VALUES ('677', '51', 'Rapu-rapu');
INSERT INTO `cities` VALUES ('678', '51', 'Guinobatan');
INSERT INTO `cities` VALUES ('679', '51', 'Ligao');
INSERT INTO `cities` VALUES ('680', '51', 'Oas');
INSERT INTO `cities` VALUES ('681', '51', 'Santo Domingo');
INSERT INTO `cities` VALUES ('682', '52', 'Basud');
INSERT INTO `cities` VALUES ('683', '52', 'Labo');
INSERT INTO `cities` VALUES ('684', '52', 'San Vicente');
INSERT INTO `cities` VALUES ('685', '52', 'Capalonga');
INSERT INTO `cities` VALUES ('686', '52', 'Mercedes');
INSERT INTO `cities` VALUES ('687', '52', 'Santa Elena');
INSERT INTO `cities` VALUES ('688', '52', 'Daet');
INSERT INTO `cities` VALUES ('690', '52', 'Paracale');
INSERT INTO `cities` VALUES ('691', '52', 'Talisay');
INSERT INTO `cities` VALUES ('692', '52', 'Jose Panganiban');
INSERT INTO `cities` VALUES ('693', '52', 'San Lorenzo');
INSERT INTO `cities` VALUES ('694', '52', 'Vinzons');
INSERT INTO `cities` VALUES ('695', '53', 'Baao');
INSERT INTO `cities` VALUES ('696', '53', 'Buhi');
INSERT INTO `cities` VALUES ('697', '53', 'Camaligan');
INSERT INTO `cities` VALUES ('698', '53', 'Gainza');
INSERT INTO `cities` VALUES ('699', '53', 'Lagonoy');
INSERT INTO `cities` VALUES ('700', '53', 'Milaor');
INSERT INTO `cities` VALUES ('701', '53', 'Ocampo');
INSERT INTO `cities` VALUES ('702', '53', 'Presentación (Parubcan)');
INSERT INTO `cities` VALUES ('703', '53', 'San Jose');
INSERT INTO `cities` VALUES ('704', '53', 'Tinambac');
INSERT INTO `cities` VALUES ('705', '53', 'Balatan');
INSERT INTO `cities` VALUES ('706', '53', 'Bula');
INSERT INTO `cities` VALUES ('707', '53', 'Canaman');
INSERT INTO `cities` VALUES ('708', '53', 'Garchitorena');
INSERT INTO `cities` VALUES ('709', '53', 'Libmanan');
INSERT INTO `cities` VALUES ('710', '53', 'Minalabac');
INSERT INTO `cities` VALUES ('711', '53', 'Pamplona');
INSERT INTO `cities` VALUES ('712', '53', 'Ragay');
INSERT INTO `cities` VALUES ('713', '53', 'Sipocot');
INSERT INTO `cities` VALUES ('714', '53', 'Cabusao');
INSERT INTO `cities` VALUES ('715', '53', 'Bato');
INSERT INTO `cities` VALUES ('716', '53', 'Caramoan');
INSERT INTO `cities` VALUES ('717', '53', 'Goa');
INSERT INTO `cities` VALUES ('718', '53', 'Lupi');
INSERT INTO `cities` VALUES ('719', '53', 'Nabua');
INSERT INTO `cities` VALUES ('720', '53', 'Pasacao');
INSERT INTO `cities` VALUES ('721', '53', 'Sagñay');
INSERT INTO `cities` VALUES ('722', '53', 'Siruma');
INSERT INTO `cities` VALUES ('723', '53', 'Bombon');
INSERT INTO `cities` VALUES ('724', '53', 'Calabanga');
INSERT INTO `cities` VALUES ('725', '53', 'Del Gallego');
INSERT INTO `cities` VALUES ('726', '53', 'Iriga');
INSERT INTO `cities` VALUES ('727', '53', 'Magarao');
INSERT INTO `cities` VALUES ('728', '53', 'Naga');
INSERT INTO `cities` VALUES ('729', '53', 'Pili');
INSERT INTO `cities` VALUES ('730', '53', 'San Fernando');
INSERT INTO `cities` VALUES ('731', '53', 'Tigaon');
INSERT INTO `cities` VALUES ('732', '54', 'Bagamanoc');
INSERT INTO `cities` VALUES ('733', '54', '');
INSERT INTO `cities` VALUES ('734', '54', 'Gigmoto');
INSERT INTO `cities` VALUES ('735', '54', 'San Miguel');
INSERT INTO `cities` VALUES ('736', '54', 'Baras');
INSERT INTO `cities` VALUES ('737', '54', 'Pandan');
INSERT INTO `cities` VALUES ('738', '54', 'Viga');
INSERT INTO `cities` VALUES ('739', '54', 'Bato');
INSERT INTO `cities` VALUES ('740', '54', 'Panganiban (Payo)');
INSERT INTO `cities` VALUES ('741', '54', 'Virac');
INSERT INTO `cities` VALUES ('742', '54', 'Caramoran');
INSERT INTO `cities` VALUES ('743', '54', 'San Andres (Calolbon)');
INSERT INTO `cities` VALUES ('744', '55', 'Aroroy');
INSERT INTO `cities` VALUES ('745', '55', 'Cataingan');
INSERT INTO `cities` VALUES ('746', '55', 'Esperanza');
INSERT INTO `cities` VALUES ('747', '55', 'Mobo');
INSERT INTO `cities` VALUES ('748', '55', 'Placer');
INSERT INTO `cities` VALUES ('749', '55', 'Uson');
INSERT INTO `cities` VALUES ('750', '55', 'Baleno');
INSERT INTO `cities` VALUES ('751', '55', 'Cawayan');
INSERT INTO `cities` VALUES ('752', '55', 'Mandaon');
INSERT INTO `cities` VALUES ('753', '55', 'Monreal');
INSERT INTO `cities` VALUES ('754', '55', 'San Fernando');
INSERT INTO `cities` VALUES ('755', '55', 'Balud');
INSERT INTO `cities` VALUES ('756', '55', 'Claveria');
INSERT INTO `cities` VALUES ('757', '55', 'Masbate City');
INSERT INTO `cities` VALUES ('758', '55', 'Palanas');
INSERT INTO `cities` VALUES ('759', '55', 'San Jacinto');
INSERT INTO `cities` VALUES ('760', '55', 'Batuan');
INSERT INTO `cities` VALUES ('761', '55', 'Dimasalang');
INSERT INTO `cities` VALUES ('762', '55', 'Milagros');
INSERT INTO `cities` VALUES ('763', '55', 'Pio V. Corpuz (Limbuhan)');
INSERT INTO `cities` VALUES ('764', '55', 'San Pascual');
INSERT INTO `cities` VALUES ('765', '56', 'sorsogon');
INSERT INTO `cities` VALUES ('766', '57', 'Altavas');
INSERT INTO `cities` VALUES ('767', '57', 'Buruanga');
INSERT INTO `cities` VALUES ('768', '57', 'Libacao');
INSERT INTO `cities` VALUES ('769', '57', 'Malinao');
INSERT INTO `cities` VALUES ('770', '57', 'Tangalan');
INSERT INTO `cities` VALUES ('771', '57', 'Balete');
INSERT INTO `cities` VALUES ('772', '57', 'Ibajay');
INSERT INTO `cities` VALUES ('773', '57', 'Madalag');
INSERT INTO `cities` VALUES ('774', '57', 'Nabas');
INSERT INTO `cities` VALUES ('775', '57', 'Banga');
INSERT INTO `cities` VALUES ('776', '57', 'Kalibo');
INSERT INTO `cities` VALUES ('777', '57', 'Makato');
INSERT INTO `cities` VALUES ('778', '57', 'New Washington');
INSERT INTO `cities` VALUES ('779', '57', 'Batan');
INSERT INTO `cities` VALUES ('780', '57', 'Lezo');
INSERT INTO `cities` VALUES ('781', '57', 'Malay');
INSERT INTO `cities` VALUES ('782', '57', 'Numancia');
INSERT INTO `cities` VALUES ('783', '59', 'Anini-y');
INSERT INTO `cities` VALUES ('784', '59', 'Anini-y');
INSERT INTO `cities` VALUES ('785', '59', 'Caluya');
INSERT INTO `cities` VALUES ('786', '59', 'Libertad');
INSERT INTO `cities` VALUES ('787', '59', 'San Remigio');
INSERT INTO `cities` VALUES ('788', '59', 'Tobias Fornier (Dao)');
INSERT INTO `cities` VALUES ('789', '59', 'Barbaza');
INSERT INTO `cities` VALUES ('790', '59', 'Culasi');
INSERT INTO `cities` VALUES ('791', '59', 'Pandan');
INSERT INTO `cities` VALUES ('792', '59', 'Sebaste');
INSERT INTO `cities` VALUES ('793', '59', 'Valderrama');
INSERT INTO `cities` VALUES ('794', '59', 'Belison');
INSERT INTO `cities` VALUES ('795', '59', 'Hamtic');
INSERT INTO `cities` VALUES ('796', '59', 'Patnongon');
INSERT INTO `cities` VALUES ('797', '59', 'Sibalom');
INSERT INTO `cities` VALUES ('798', '59', 'Bugasong');
INSERT INTO `cities` VALUES ('799', '59', '\r\nLaua-an');
INSERT INTO `cities` VALUES ('800', '59', 'San Jose de');
INSERT INTO `cities` VALUES ('801', '59', 'Buenavista');
INSERT INTO `cities` VALUES ('802', '59', 'Tibiao');
INSERT INTO `cities` VALUES ('803', '60', 'Cuartero');
INSERT INTO `cities` VALUES ('804', '60', 'Ivisan');
INSERT INTO `cities` VALUES ('805', '60', 'Panay');
INSERT INTO `cities` VALUES ('806', '60', 'President Roxas');
INSERT INTO `cities` VALUES ('807', '60', 'Tapaz');
INSERT INTO `cities` VALUES ('808', '60', 'Dao');
INSERT INTO `cities` VALUES ('809', '60', 'Jamindan');
INSERT INTO `cities` VALUES ('810', '60', 'Panitan');
INSERT INTO `cities` VALUES ('811', '60', 'Roxas City');
INSERT INTO `cities` VALUES ('812', '60', 'Dumalag');
INSERT INTO `cities` VALUES ('813', '60', 'Ma-ayon');
INSERT INTO `cities` VALUES ('814', '60', 'Pilar');
INSERT INTO `cities` VALUES ('815', '60', 'Sapian');
INSERT INTO `cities` VALUES ('816', '60', 'Dumarao');
INSERT INTO `cities` VALUES ('817', '60', 'Mambusao');
INSERT INTO `cities` VALUES ('818', '60', 'Pontevedra');
INSERT INTO `cities` VALUES ('819', '60', 'Sigma');
INSERT INTO `cities` VALUES ('820', '61', 'Buenavista');
INSERT INTO `cities` VALUES ('821', '61', 'Sibunag');
INSERT INTO `cities` VALUES ('822', '61', 'Jordan');
INSERT INTO `cities` VALUES ('823', '61', 'Nueva Valencia');
INSERT INTO `cities` VALUES ('824', '61', 'San Lorenzo');
INSERT INTO `cities` VALUES ('825', '62', 'Ajuy');
INSERT INTO `cities` VALUES ('826', '62', 'Balasan');
INSERT INTO `cities` VALUES ('827', '62', 'Batad');
INSERT INTO `cities` VALUES ('828', '62', 'Carles');
INSERT INTO `cities` VALUES ('829', '62', 'Dumangas');
INSERT INTO `cities` VALUES ('830', '62', 'Iloilo City');
INSERT INTO `cities` VALUES ('831', '62', 'Lemery');
INSERT INTO `cities` VALUES ('832', '62', 'Mina');
INSERT INTO `cities` VALUES ('833', '62', 'Pavia');
INSERT INTO `cities` VALUES ('834', '62', 'San Joaquin');
INSERT INTO `cities` VALUES ('835', '62', 'Sara');
INSERT INTO `cities` VALUES ('836', '62', 'Alimodian');
INSERT INTO `cities` VALUES ('837', '62', 'Banate');
INSERT INTO `cities` VALUES ('838', '62', 'Bingawan');
INSERT INTO `cities` VALUES ('839', '62', 'Concepcion');
INSERT INTO `cities` VALUES ('840', '62', 'Estancia');
INSERT INTO `cities` VALUES ('841', '62', 'Janiuay');
INSERT INTO `cities` VALUES ('842', '62', 'Leon');
INSERT INTO `cities` VALUES ('843', '62', 'New Lucena\r\n');
INSERT INTO `cities` VALUES ('844', '62', 'Pototan');
INSERT INTO `cities` VALUES ('845', '62', 'San Miguel');
INSERT INTO `cities` VALUES ('846', '62', 'Tigbauan');
INSERT INTO `cities` VALUES ('847', '62', 'Anilao');
INSERT INTO `cities` VALUES ('848', '62', 'Barotac Nuevo');
INSERT INTO `cities` VALUES ('849', '62', 'Cabatuan');
INSERT INTO `cities` VALUES ('850', '62', 'Dingle');
INSERT INTO `cities` VALUES ('851', '62', 'Guimbal');
INSERT INTO `cities` VALUES ('852', '62', 'Lambunao');
INSERT INTO `cities` VALUES ('853', '62', 'Maasin');
INSERT INTO `cities` VALUES ('854', '62', 'Oton');
INSERT INTO `cities` VALUES ('855', '62', 'San Dionisio');
INSERT INTO `cities` VALUES ('856', '62', 'San Rafael');
INSERT INTO `cities` VALUES ('857', '62', 'Tubungan');
INSERT INTO `cities` VALUES ('858', '62', 'Badiangan');
INSERT INTO `cities` VALUES ('859', '62', 'Barotac Viejo');
INSERT INTO `cities` VALUES ('860', '62', 'Calinog');
INSERT INTO `cities` VALUES ('861', '62', 'Dueñas');
INSERT INTO `cities` VALUES ('862', '62', 'Igbaras');
INSERT INTO `cities` VALUES ('863', '62', 'Leganes');
INSERT INTO `cities` VALUES ('864', '62', 'Miagao');
INSERT INTO `cities` VALUES ('865', '62', 'Passi');
INSERT INTO `cities` VALUES ('866', '62', 'San Enrique');
INSERT INTO `cities` VALUES ('867', '62', 'Santa Barbara');
INSERT INTO `cities` VALUES ('868', '62', 'Zarraga');
INSERT INTO `cities` VALUES ('869', '63', 'Bacolod');
INSERT INTO `cities` VALUES ('870', '63', 'Bago');
INSERT INTO `cities` VALUES ('871', '63', 'Binalbagan');
INSERT INTO `cities` VALUES ('872', '63', 'Cadiz');
INSERT INTO `cities` VALUES ('873', '63', 'Calatrava');
INSERT INTO `cities` VALUES ('874', '63', 'Candoni');
INSERT INTO `cities` VALUES ('875', '63', 'Cauayan');
INSERT INTO `cities` VALUES ('876', '63', 'Enrique B. Magalona (Saravia)');
INSERT INTO `cities` VALUES ('877', '63', 'Escalante');
INSERT INTO `cities` VALUES ('878', '63', 'Himamaylan');
INSERT INTO `cities` VALUES ('879', '63', 'Hinigaran');
INSERT INTO `cities` VALUES ('880', '63', 'Hinoba-an (Asia)');
INSERT INTO `cities` VALUES ('881', '63', 'Ilog');
INSERT INTO `cities` VALUES ('882', '63', 'Isabela');
INSERT INTO `cities` VALUES ('883', '63', 'Kabankalan');
INSERT INTO `cities` VALUES ('884', '63', 'La Carlota');
INSERT INTO `cities` VALUES ('885', '63', 'La Castellana');
INSERT INTO `cities` VALUES ('886', '63', 'Manapla');
INSERT INTO `cities` VALUES ('887', '63', 'Moises Padilla (Magallon)');
INSERT INTO `cities` VALUES ('888', '63', 'Murcia');
INSERT INTO `cities` VALUES ('889', '63', 'Pontevedra');
INSERT INTO `cities` VALUES ('890', '63', 'Pulupandan');
INSERT INTO `cities` VALUES ('891', '63', 'Sagay');
INSERT INTO `cities` VALUES ('892', '63', 'Salvador Benedicto');
INSERT INTO `cities` VALUES ('893', '63', 'San Carlos');
INSERT INTO `cities` VALUES ('894', '63', 'San Enrique');
INSERT INTO `cities` VALUES ('895', '63', 'Silay');
INSERT INTO `cities` VALUES ('896', '63', 'Sipalay');
INSERT INTO `cities` VALUES ('897', '63', 'Talisay');
INSERT INTO `cities` VALUES ('898', '63', 'Toboso');
INSERT INTO `cities` VALUES ('899', '63', 'Valladolid');
INSERT INTO `cities` VALUES ('900', '63', 'Victorias');
INSERT INTO `cities` VALUES ('901', '64', 'Alburquerque');
INSERT INTO `cities` VALUES ('902', '64', 'Alicia');
INSERT INTO `cities` VALUES ('903', '64', 'Anda');
INSERT INTO `cities` VALUES ('904', '64', 'Antequera');
INSERT INTO `cities` VALUES ('905', '64', 'Baclayon');
INSERT INTO `cities` VALUES ('906', '64', 'Balilihan');
INSERT INTO `cities` VALUES ('907', '64', 'Batuan');
INSERT INTO `cities` VALUES ('908', '64', 'Bien Unido');
INSERT INTO `cities` VALUES ('909', '64', 'Bilar');
INSERT INTO `cities` VALUES ('910', '64', 'Buenavista');
INSERT INTO `cities` VALUES ('911', '64', 'Calape');
INSERT INTO `cities` VALUES ('912', '64', 'Candijay');
INSERT INTO `cities` VALUES ('913', '64', 'Carmen');
INSERT INTO `cities` VALUES ('914', '64', 'Catigbian');
INSERT INTO `cities` VALUES ('915', '64', 'Clarin');
INSERT INTO `cities` VALUES ('916', '64', 'Corella');
INSERT INTO `cities` VALUES ('917', '64', 'Cortes');
INSERT INTO `cities` VALUES ('918', '64', 'Dagohoy');
INSERT INTO `cities` VALUES ('919', '64', 'Danao');
INSERT INTO `cities` VALUES ('920', '64', 'Dauis');
INSERT INTO `cities` VALUES ('921', '64', 'Dimiao');
INSERT INTO `cities` VALUES ('922', '64', 'Duero');
INSERT INTO `cities` VALUES ('923', '64', 'Garcia Hernandez');
INSERT INTO `cities` VALUES ('924', '64', 'Getafe');
INSERT INTO `cities` VALUES ('925', '64', 'Guindulman');
INSERT INTO `cities` VALUES ('926', '64', 'Inabanga');
INSERT INTO `cities` VALUES ('927', '64', 'Jagna');
INSERT INTO `cities` VALUES ('928', '64', 'Lila');
INSERT INTO `cities` VALUES ('929', '64', 'Loay');
INSERT INTO `cities` VALUES ('930', '64', 'Loboc');
INSERT INTO `cities` VALUES ('931', '64', 'Loon');
INSERT INTO `cities` VALUES ('932', '64', 'Mabini');
INSERT INTO `cities` VALUES ('933', '64', 'Maribojoc');
INSERT INTO `cities` VALUES ('934', '64', 'Panglao');
INSERT INTO `cities` VALUES ('935', '64', 'Pilar');
INSERT INTO `cities` VALUES ('936', '64', 'President Carlos P. Garcia (Pitogo)');
INSERT INTO `cities` VALUES ('937', '64', 'Sagbayan (Borja)');
INSERT INTO `cities` VALUES ('938', '64', 'San Isidro');
INSERT INTO `cities` VALUES ('939', '64', 'San Miguel');
INSERT INTO `cities` VALUES ('940', '64', 'Sevilla');
INSERT INTO `cities` VALUES ('941', '64', 'Sierra Bullones');
INSERT INTO `cities` VALUES ('942', '64', 'Sikatuna');
INSERT INTO `cities` VALUES ('943', '64', 'Tagbilaran');
INSERT INTO `cities` VALUES ('944', '64', 'Talibon');
INSERT INTO `cities` VALUES ('945', '64', 'Trinidad');
INSERT INTO `cities` VALUES ('946', '64', 'Tubigon');
INSERT INTO `cities` VALUES ('947', '64', 'Ubay');
INSERT INTO `cities` VALUES ('948', '65', 'Alcantara');
INSERT INTO `cities` VALUES ('949', '65', 'Alcoy');
INSERT INTO `cities` VALUES ('950', '65', 'Alegria');
INSERT INTO `cities` VALUES ('951', '65', 'Aloguinsan');
INSERT INTO `cities` VALUES ('952', '65', 'Argao');
INSERT INTO `cities` VALUES ('953', '65', 'Asturias');
INSERT INTO `cities` VALUES ('954', '65', 'Badian');
INSERT INTO `cities` VALUES ('955', '65', 'Balamban');
INSERT INTO `cities` VALUES ('956', '65', 'Bantayan');
INSERT INTO `cities` VALUES ('957', '65', 'Barili');
INSERT INTO `cities` VALUES ('958', '65', 'Bogo');
INSERT INTO `cities` VALUES ('959', '65', 'Boljoon');
INSERT INTO `cities` VALUES ('960', '65', 'Borbon');
INSERT INTO `cities` VALUES ('961', '65', 'Carcar');
INSERT INTO `cities` VALUES ('962', '65', 'Carmen');
INSERT INTO `cities` VALUES ('963', '65', 'Catmon');
INSERT INTO `cities` VALUES ('964', '65', 'Cebu City');
INSERT INTO `cities` VALUES ('965', '65', 'Compostela');
INSERT INTO `cities` VALUES ('966', '65', 'Consolacion');
INSERT INTO `cities` VALUES ('967', '65', 'Cordova');
INSERT INTO `cities` VALUES ('968', '65', 'Daanbantayan');
INSERT INTO `cities` VALUES ('969', '65', 'Dalaguete');
INSERT INTO `cities` VALUES ('970', '65', 'Danao');
INSERT INTO `cities` VALUES ('971', '65', 'Dumanjug');
INSERT INTO `cities` VALUES ('972', '65', 'Ginatilan');
INSERT INTO `cities` VALUES ('973', '65', 'Lapu-Lapu (Opon)');
INSERT INTO `cities` VALUES ('975', '65', 'Liloan');
INSERT INTO `cities` VALUES ('976', '65', 'Madridejos');
INSERT INTO `cities` VALUES ('977', '65', 'Malabuyoc');
INSERT INTO `cities` VALUES ('978', '65', 'Mandaue');
INSERT INTO `cities` VALUES ('979', '65', 'Medellin');
INSERT INTO `cities` VALUES ('980', '65', 'Minglanilla');
INSERT INTO `cities` VALUES ('981', '65', 'Moalboal');
INSERT INTO `cities` VALUES ('982', '65', 'Naga');
INSERT INTO `cities` VALUES ('983', '65', 'Oslob');
INSERT INTO `cities` VALUES ('984', '65', 'Pilar');
INSERT INTO `cities` VALUES ('985', '65', 'Pinamungajan');
INSERT INTO `cities` VALUES ('986', '65', 'Poro');
INSERT INTO `cities` VALUES ('987', '65', 'Ronda');
INSERT INTO `cities` VALUES ('988', '65', 'Samboan');
INSERT INTO `cities` VALUES ('989', '65', 'San Fernando');
INSERT INTO `cities` VALUES ('990', '65', 'San Francisco');
INSERT INTO `cities` VALUES ('991', '65', 'San Remigio');
INSERT INTO `cities` VALUES ('992', '65', 'Santa Fe');
INSERT INTO `cities` VALUES ('993', '65', 'Santander');
INSERT INTO `cities` VALUES ('994', '65', 'Sibonga');
INSERT INTO `cities` VALUES ('995', '65', 'Sogod');
INSERT INTO `cities` VALUES ('996', '65', 'Tabogon');
INSERT INTO `cities` VALUES ('997', '65', 'Tabuelan');
INSERT INTO `cities` VALUES ('998', '65', 'Talisay');
INSERT INTO `cities` VALUES ('999', '65', 'Toledo');
INSERT INTO `cities` VALUES ('1000', '65', 'Tuburan');
INSERT INTO `cities` VALUES ('1001', '66', 'Amlan (Ayuquitan)');
INSERT INTO `cities` VALUES ('1002', '66', 'Ayungon');
INSERT INTO `cities` VALUES ('1003', '66', 'Bacong');
INSERT INTO `cities` VALUES ('1004', '66', 'Bais');
INSERT INTO `cities` VALUES ('1005', '66', 'Basay');
INSERT INTO `cities` VALUES ('1006', '66', 'Bayawan (Tulong)');
INSERT INTO `cities` VALUES ('1007', '66', 'Bindoy (Payabon)');
INSERT INTO `cities` VALUES ('1008', '66', 'Canlaon');
INSERT INTO `cities` VALUES ('1009', '66', 'Dauin');
INSERT INTO `cities` VALUES ('1010', '66', 'Dumaguete');
INSERT INTO `cities` VALUES ('1011', '66', 'Guihulngan');
INSERT INTO `cities` VALUES ('1012', '66', 'Jimalalud');
INSERT INTO `cities` VALUES ('1013', '66', 'La Libertad');
INSERT INTO `cities` VALUES ('1014', '66', 'Mabinay');
INSERT INTO `cities` VALUES ('1016', '66', 'Manjuyod');
INSERT INTO `cities` VALUES ('1017', '66', 'Pamplona');
INSERT INTO `cities` VALUES ('1018', '66', 'San Jose');
INSERT INTO `cities` VALUES ('1019', '66', 'Santa Catalina');
INSERT INTO `cities` VALUES ('1020', '66', 'Siaton');
INSERT INTO `cities` VALUES ('1021', '66', 'Sibulan');
INSERT INTO `cities` VALUES ('1022', '66', 'Tanjay');
INSERT INTO `cities` VALUES ('1023', '66', 'Tayasan');
INSERT INTO `cities` VALUES ('1024', '66', 'Valencia (Luzurriaga)');
INSERT INTO `cities` VALUES ('1025', '66', 'Vallehermoso');
INSERT INTO `cities` VALUES ('1026', '66', 'Zamboanguita');
INSERT INTO `cities` VALUES ('1028', '67', 'Enrique Villanueva');
INSERT INTO `cities` VALUES ('1029', '67', 'Larena');
INSERT INTO `cities` VALUES ('1030', '67', 'Lazi');
INSERT INTO `cities` VALUES ('1031', '67', 'Maria');
INSERT INTO `cities` VALUES ('1032', '67', 'San Juan');
INSERT INTO `cities` VALUES ('1033', '67', 'Siquijor');
INSERT INTO `cities` VALUES ('1034', '67', 'Sorsogon Province');
INSERT INTO `cities` VALUES ('1035', '68', 'Almeria');
INSERT INTO `cities` VALUES ('1036', '68', 'Biliran');
INSERT INTO `cities` VALUES ('1037', '68', 'Cabucgayan');
INSERT INTO `cities` VALUES ('1038', '68', 'Caibiran');
INSERT INTO `cities` VALUES ('1039', '68', 'Culaba');
INSERT INTO `cities` VALUES ('1040', '68', 'Kawayan');
INSERT INTO `cities` VALUES ('1041', '68', 'Maripipi');
INSERT INTO `cities` VALUES ('1042', '68', 'Naval');
INSERT INTO `cities` VALUES ('1043', '69', 'Arteche');
INSERT INTO `cities` VALUES ('1044', '69', 'Balangiga');
INSERT INTO `cities` VALUES ('1045', '69', 'Balangkayan');
INSERT INTO `cities` VALUES ('1046', '69', 'Borongan');
INSERT INTO `cities` VALUES ('1047', '69', 'Can-avid');
INSERT INTO `cities` VALUES ('1048', '69', 'Dolores');
INSERT INTO `cities` VALUES ('1049', '69', 'General MacArthur');
INSERT INTO `cities` VALUES ('1050', '69', 'Giporlos');
INSERT INTO `cities` VALUES ('1051', '69', 'Guiuan');
INSERT INTO `cities` VALUES ('1052', '69', 'Hernani');
INSERT INTO `cities` VALUES ('1053', '69', 'Jipapad');
INSERT INTO `cities` VALUES ('1054', '69', 'Lawaan');
INSERT INTO `cities` VALUES ('1055', '69', 'Llorente');
INSERT INTO `cities` VALUES ('1056', '69', 'Maslog');
INSERT INTO `cities` VALUES ('1057', '69', 'Maydolong');
INSERT INTO `cities` VALUES ('1058', '69', 'Mercedes');
INSERT INTO `cities` VALUES ('1059', '69', 'Oras');
INSERT INTO `cities` VALUES ('1060', '69', 'Quinapondan');
INSERT INTO `cities` VALUES ('1061', '69', 'Salcedo');
INSERT INTO `cities` VALUES ('1062', '69', 'San Julian');
INSERT INTO `cities` VALUES ('1063', '69', 'San Policarpo');
INSERT INTO `cities` VALUES ('1064', '69', 'Sulat');
INSERT INTO `cities` VALUES ('1065', '69', 'Taft');
INSERT INTO `cities` VALUES ('1066', '70', 'Abuyog');
INSERT INTO `cities` VALUES ('1067', '70', 'Alangalang');
INSERT INTO `cities` VALUES ('1068', '70', 'Albuera');
INSERT INTO `cities` VALUES ('1069', '70', 'Babatngon');
INSERT INTO `cities` VALUES ('1070', '70', 'Barugo');
INSERT INTO `cities` VALUES ('1071', '70', 'Bato');
INSERT INTO `cities` VALUES ('1072', '70', 'Baybay');
INSERT INTO `cities` VALUES ('1073', '70', 'Burauen');
INSERT INTO `cities` VALUES ('1074', '70', 'Calubian');
INSERT INTO `cities` VALUES ('1075', '70', 'Capoocan');
INSERT INTO `cities` VALUES ('1076', '70', 'Carigara');
INSERT INTO `cities` VALUES ('1077', '70', 'Dagami');
INSERT INTO `cities` VALUES ('1078', '70', 'Dulag');
INSERT INTO `cities` VALUES ('1079', '70', 'Hilongos');
INSERT INTO `cities` VALUES ('1080', '70', 'Hindang');
INSERT INTO `cities` VALUES ('1081', '70', 'Inopacan');
INSERT INTO `cities` VALUES ('1082', '70', 'Isabel');
INSERT INTO `cities` VALUES ('1083', '70', 'Jaro');
INSERT INTO `cities` VALUES ('1084', '70', 'Javier (Bugho)');
INSERT INTO `cities` VALUES ('1085', '70', 'Julita');
INSERT INTO `cities` VALUES ('1086', '70', 'Kananga');
INSERT INTO `cities` VALUES ('1087', '70', 'La Paz');
INSERT INTO `cities` VALUES ('1088', '70', 'Leyte');
INSERT INTO `cities` VALUES ('1089', '70', 'MacArthur');
INSERT INTO `cities` VALUES ('1090', '70', 'Mahaplag');
INSERT INTO `cities` VALUES ('1091', '70', 'Matag-ob');
INSERT INTO `cities` VALUES ('1092', '70', 'Matalom');
INSERT INTO `cities` VALUES ('1093', '70', 'Mayorga');
INSERT INTO `cities` VALUES ('1094', '70', 'Merida');
INSERT INTO `cities` VALUES ('1095', '70', 'Ormoc');
INSERT INTO `cities` VALUES ('1096', '70', 'Palo');
INSERT INTO `cities` VALUES ('1097', '70', 'Palompon');
INSERT INTO `cities` VALUES ('1098', '70', 'Pastrana');
INSERT INTO `cities` VALUES ('1099', '70', 'San Isidro');
INSERT INTO `cities` VALUES ('1100', '70', 'San Miguel');
INSERT INTO `cities` VALUES ('1101', '70', 'Santa Fe');
INSERT INTO `cities` VALUES ('1102', '70', 'Tabango');
INSERT INTO `cities` VALUES ('1103', '70', 'Tabontabon');
INSERT INTO `cities` VALUES ('1104', '70', 'Tacloban');
INSERT INTO `cities` VALUES ('1105', '70', 'Tanauan');
INSERT INTO `cities` VALUES ('1106', '70', 'Tolosa');
INSERT INTO `cities` VALUES ('1107', '70', 'Tunga');
INSERT INTO `cities` VALUES ('1108', '70', 'Villaba');
INSERT INTO `cities` VALUES ('1109', '71', 'Allen');
INSERT INTO `cities` VALUES ('1110', '71', 'Biri');
INSERT INTO `cities` VALUES ('1111', '71', 'Bobon');
INSERT INTO `cities` VALUES ('1112', '71', 'Capul');
INSERT INTO `cities` VALUES ('1113', '71', 'Catarman');
INSERT INTO `cities` VALUES ('1114', '71', 'Catubig');
INSERT INTO `cities` VALUES ('1115', '71', 'Gamay');
INSERT INTO `cities` VALUES ('1116', '71', 'Laoang');
INSERT INTO `cities` VALUES ('1117', '71', 'Lapinig');
INSERT INTO `cities` VALUES ('1118', '71', 'Las Navas');
INSERT INTO `cities` VALUES ('1119', '71', 'Lavezares');
INSERT INTO `cities` VALUES ('1120', '71', 'Lope de Vega');
INSERT INTO `cities` VALUES ('1121', '71', 'Mapanas');
INSERT INTO `cities` VALUES ('1122', '71', 'Mondragon');
INSERT INTO `cities` VALUES ('1123', '71', 'Palapag');
INSERT INTO `cities` VALUES ('1124', '71', 'Pambujan');
INSERT INTO `cities` VALUES ('1125', '71', 'Rosario');
INSERT INTO `cities` VALUES ('1126', '71', 'San Antonio');
INSERT INTO `cities` VALUES ('1127', '71', 'San Isidro');
INSERT INTO `cities` VALUES ('1128', '71', 'San Jose');
INSERT INTO `cities` VALUES ('1129', '71', 'San Roque');
INSERT INTO `cities` VALUES ('1130', '71', 'San Vicente');
INSERT INTO `cities` VALUES ('1131', '71', 'Silvino Lobos');
INSERT INTO `cities` VALUES ('1132', '71', 'Victoria');
INSERT INTO `cities` VALUES ('1133', '72', 'Almagro');
INSERT INTO `cities` VALUES ('1134', '72', 'Basey');
INSERT INTO `cities` VALUES ('1135', '72', 'Calbayog');
INSERT INTO `cities` VALUES ('1136', '72', 'Calbiga');
INSERT INTO `cities` VALUES ('1137', '72', 'Catbalogan');
INSERT INTO `cities` VALUES ('1138', '72', 'Daram');
INSERT INTO `cities` VALUES ('1139', '72', 'Gandara');
INSERT INTO `cities` VALUES ('1140', '72', 'Hinabangan');
INSERT INTO `cities` VALUES ('1141', '72', 'Jiabong');
INSERT INTO `cities` VALUES ('1142', '72', 'Marabut');
INSERT INTO `cities` VALUES ('1143', '72', 'Matuguinao');
INSERT INTO `cities` VALUES ('1144', '72', 'Motiong');
INSERT INTO `cities` VALUES ('1145', '72', 'Pagsanghan');
INSERT INTO `cities` VALUES ('1146', '72', 'Paranas (Wright)');
INSERT INTO `cities` VALUES ('1147', '72', 'Pinabacdao');
INSERT INTO `cities` VALUES ('1148', '72', 'San Jorge');
INSERT INTO `cities` VALUES ('1149', '72', 'San Jose de Buan');
INSERT INTO `cities` VALUES ('1150', '72', 'San Sebastian');
INSERT INTO `cities` VALUES ('1151', '72', 'Santa Margarita');
INSERT INTO `cities` VALUES ('1152', '72', 'Santa Rita');
INSERT INTO `cities` VALUES ('1153', '72', 'Santo Niño');
INSERT INTO `cities` VALUES ('1154', '72', 'Tagapul-an');
INSERT INTO `cities` VALUES ('1155', '72', 'Talalora');
INSERT INTO `cities` VALUES ('1156', '72', 'Tarangnan');
INSERT INTO `cities` VALUES ('1157', '72', 'Villareal');
INSERT INTO `cities` VALUES ('1158', '72', 'Zumarraga');
INSERT INTO `cities` VALUES ('1159', '73', 'Anahawan');
INSERT INTO `cities` VALUES ('1160', '73', 'Bontoc');
INSERT INTO `cities` VALUES ('1161', '73', 'Hinunangan');
INSERT INTO `cities` VALUES ('1162', '73', 'Hinundayan');
INSERT INTO `cities` VALUES ('1163', '73', 'Libagon');
INSERT INTO `cities` VALUES ('1164', '73', 'Liloan');
INSERT INTO `cities` VALUES ('1165', '73', 'Limasawa');
INSERT INTO `cities` VALUES ('1166', '73', 'Maasin');
INSERT INTO `cities` VALUES ('1167', '73', 'Macrohon');
INSERT INTO `cities` VALUES ('1168', '73', 'Malitbog');
INSERT INTO `cities` VALUES ('1169', '73', 'Padre Burgos');
INSERT INTO `cities` VALUES ('1170', '73', 'Pintuyan');
INSERT INTO `cities` VALUES ('1171', '73', 'Saint Bernard');
INSERT INTO `cities` VALUES ('1172', '73', 'San Francisco');
INSERT INTO `cities` VALUES ('1173', '73', 'San Juan (Cabalian)');
INSERT INTO `cities` VALUES ('1174', '73', 'San Ricardo');
INSERT INTO `cities` VALUES ('1175', '73', 'Silago');
INSERT INTO `cities` VALUES ('1176', '73', 'Sogod');
INSERT INTO `cities` VALUES ('1177', '73', 'Tomas Oppus');
INSERT INTO `cities` VALUES ('1178', '74', 'Baliguian');
INSERT INTO `cities` VALUES ('1179', '74', 'Dapitan');
INSERT INTO `cities` VALUES ('1180', '74', 'Dipolog');
INSERT INTO `cities` VALUES ('1181', '74', 'Godod');
INSERT INTO `cities` VALUES ('1182', '74', 'Gutalac');
INSERT INTO `cities` VALUES ('1183', '74', 'Jose Dalman (Ponot)');
INSERT INTO `cities` VALUES ('1184', '74', 'Kalawit');
INSERT INTO `cities` VALUES ('1185', '74', 'Katipunan');
INSERT INTO `cities` VALUES ('1186', '74', 'La Libertad');
INSERT INTO `cities` VALUES ('1187', '74', 'Labason');
INSERT INTO `cities` VALUES ('1188', '74', 'Leon B. Postigo (Bacungan)');
INSERT INTO `cities` VALUES ('1189', '74', 'Liloy');
INSERT INTO `cities` VALUES ('1190', '74', 'Manukan');
INSERT INTO `cities` VALUES ('1191', '74', 'Mutia');
INSERT INTO `cities` VALUES ('1192', '74', 'Piñan (New Piñan)');
INSERT INTO `cities` VALUES ('1193', '74', 'Polanco');
INSERT INTO `cities` VALUES ('1194', '74', 'President Manuel A. Roxas');
INSERT INTO `cities` VALUES ('1195', '74', 'Rizal');
INSERT INTO `cities` VALUES ('1196', '74', 'Salug');
INSERT INTO `cities` VALUES ('1197', '74', 'Sergio Osmeña Sr.');
INSERT INTO `cities` VALUES ('1198', '74', 'Siayan');
INSERT INTO `cities` VALUES ('1199', '74', 'Sibuco');
INSERT INTO `cities` VALUES ('1200', '74', 'Sibutad');
INSERT INTO `cities` VALUES ('1201', '74', 'Sindangan');
INSERT INTO `cities` VALUES ('1202', '74', 'Siocon');
INSERT INTO `cities` VALUES ('1203', '74', 'Sirawai');
INSERT INTO `cities` VALUES ('1204', '74', 'Tampilisan');
INSERT INTO `cities` VALUES ('1205', '75', 'Aurora');
INSERT INTO `cities` VALUES ('1206', '75', 'Bayog');
INSERT INTO `cities` VALUES ('1207', '75', 'Dimataling');
INSERT INTO `cities` VALUES ('1208', '75', 'Dinas');
INSERT INTO `cities` VALUES ('1209', '75', 'Dumalinao');
INSERT INTO `cities` VALUES ('1210', '75', 'Dumingag');
INSERT INTO `cities` VALUES ('1211', '75', 'Guipos');
INSERT INTO `cities` VALUES ('1212', '75', 'Josefina');
INSERT INTO `cities` VALUES ('1213', '75', 'Kumalarang');
INSERT INTO `cities` VALUES ('1215', '75', 'Labangan');
INSERT INTO `cities` VALUES ('1216', '75', 'Lakewood');
INSERT INTO `cities` VALUES ('1217', '75', 'Lapuyan');
INSERT INTO `cities` VALUES ('1218', '75', 'Mahayag');
INSERT INTO `cities` VALUES ('1219', '75', 'Margosatubig');
INSERT INTO `cities` VALUES ('1220', '75', 'Midsalip');
INSERT INTO `cities` VALUES ('1221', '75', 'Molave');
INSERT INTO `cities` VALUES ('1222', '75', 'Pagadian');
INSERT INTO `cities` VALUES ('1223', '75', 'Pitogo');
INSERT INTO `cities` VALUES ('1224', '75', 'Ramon Magsaysay (Liargo)');
INSERT INTO `cities` VALUES ('1225', '75', 'San Miguel');
INSERT INTO `cities` VALUES ('1226', '75', 'San Pablo');
INSERT INTO `cities` VALUES ('1227', '75', 'Sominot (Don Mariano Marcos)');
INSERT INTO `cities` VALUES ('1228', '75', 'Tabina');
INSERT INTO `cities` VALUES ('1229', '75', 'Tambulig');
INSERT INTO `cities` VALUES ('1230', '75', 'Tigbao');
INSERT INTO `cities` VALUES ('1231', '75', 'Tukuran');
INSERT INTO `cities` VALUES ('1232', '75', 'Vincenzo A. Sagun');
INSERT INTO `cities` VALUES ('1234', '75', 'Zamboanga City');
INSERT INTO `cities` VALUES ('1235', '76', 'Alicia');
INSERT INTO `cities` VALUES ('1236', '76', 'Buug');
INSERT INTO `cities` VALUES ('1237', '76', 'Diplahan');
INSERT INTO `cities` VALUES ('1238', '76', 'Imelda');
INSERT INTO `cities` VALUES ('1239', '76', 'Ipil');
INSERT INTO `cities` VALUES ('1240', '76', 'Kabasalan');
INSERT INTO `cities` VALUES ('1241', '76', 'Mabuhay');
INSERT INTO `cities` VALUES ('1242', '76', 'Malangas');
INSERT INTO `cities` VALUES ('1243', '76', 'Naga');
INSERT INTO `cities` VALUES ('1244', '76', 'Olutanga');
INSERT INTO `cities` VALUES ('1245', '76', 'Payao');
INSERT INTO `cities` VALUES ('1246', '76', 'Roseller Lim');
INSERT INTO `cities` VALUES ('1247', '76', 'Siay');
INSERT INTO `cities` VALUES ('1248', '76', 'Talusan');
INSERT INTO `cities` VALUES ('1249', '76', 'Titay');
INSERT INTO `cities` VALUES ('1250', '76', 'Tunga');
INSERT INTO `cities` VALUES ('1251', '77', 'Baungon');
INSERT INTO `cities` VALUES ('1252', '77', 'Cabanglasan');
INSERT INTO `cities` VALUES ('1253', '77', 'Damulog');
INSERT INTO `cities` VALUES ('1254', '77', 'Dangcagan');
INSERT INTO `cities` VALUES ('1255', '77', 'Don Carlos');
INSERT INTO `cities` VALUES ('1256', '77', 'Impasugong');
INSERT INTO `cities` VALUES ('1257', '77', 'Kadingilan');
INSERT INTO `cities` VALUES ('1258', '77', 'Kalilangan');
INSERT INTO `cities` VALUES ('1259', '77', 'Kibawe');
INSERT INTO `cities` VALUES ('1260', '77', 'Kitaotao');
INSERT INTO `cities` VALUES ('1261', '77', 'Lantapan');
INSERT INTO `cities` VALUES ('1262', '77', 'Libona');
INSERT INTO `cities` VALUES ('1263', '77', 'Malaybalay');
INSERT INTO `cities` VALUES ('1264', '77', 'Malitbog');
INSERT INTO `cities` VALUES ('1265', '77', 'Manolo Fortich');
INSERT INTO `cities` VALUES ('1266', '77', 'Maramag');
INSERT INTO `cities` VALUES ('1267', '77', 'Pangantucan');
INSERT INTO `cities` VALUES ('1268', '77', 'Quezon');
INSERT INTO `cities` VALUES ('1269', '77', 'San Fernando');
INSERT INTO `cities` VALUES ('1270', '77', 'Sumilao');
INSERT INTO `cities` VALUES ('1271', '77', 'Talakag');
INSERT INTO `cities` VALUES ('1273', '77', 'Valencia');
INSERT INTO `cities` VALUES ('1274', '78', 'Catarman');
INSERT INTO `cities` VALUES ('1275', '78', 'Guinsiliban');
INSERT INTO `cities` VALUES ('1276', '78', 'Mahinog');
INSERT INTO `cities` VALUES ('1277', '78', 'Mambajao');
INSERT INTO `cities` VALUES ('1278', '78', 'Sagay');
INSERT INTO `cities` VALUES ('1279', '79', 'Bacolod');
INSERT INTO `cities` VALUES ('1280', '79', 'Baloi');
INSERT INTO `cities` VALUES ('1281', '79', 'Baroy');
INSERT INTO `cities` VALUES ('1282', '79', 'Iligan');
INSERT INTO `cities` VALUES ('1283', '79', 'Kapatagan');
INSERT INTO `cities` VALUES ('1284', '79', 'Kauswagan');
INSERT INTO `cities` VALUES ('1286', '79', 'Kolambugan');
INSERT INTO `cities` VALUES ('1287', '79', 'Lala');
INSERT INTO `cities` VALUES ('1288', '79', 'Linamon');
INSERT INTO `cities` VALUES ('1289', '79', 'Magsaysay');
INSERT INTO `cities` VALUES ('1290', '79', 'Maigo');
INSERT INTO `cities` VALUES ('1291', '79', 'Matungao');
INSERT INTO `cities` VALUES ('1292', '79', 'Munai');
INSERT INTO `cities` VALUES ('1293', '79', 'Nunungan');
INSERT INTO `cities` VALUES ('1294', '79', 'Pantao Ragat');
INSERT INTO `cities` VALUES ('1295', '79', 'Pantar');
INSERT INTO `cities` VALUES ('1296', '79', 'Poona Piagapo');
INSERT INTO `cities` VALUES ('1297', '79', 'Salvador');
INSERT INTO `cities` VALUES ('1298', '79', 'Sapad');
INSERT INTO `cities` VALUES ('1301', '79', 'Sultan Naga Dimaporo (Karomatan)');
INSERT INTO `cities` VALUES ('1305', '79', 'Tagoloan');
INSERT INTO `cities` VALUES ('1306', '79', 'Tangcal');
INSERT INTO `cities` VALUES ('1307', '79', 'Tubod');
INSERT INTO `cities` VALUES ('1308', '80', 'Aloran');
INSERT INTO `cities` VALUES ('1309', '80', 'Baliangao');
INSERT INTO `cities` VALUES ('1310', '80', 'Bonifacio');
INSERT INTO `cities` VALUES ('1311', '80', 'Calamba');
INSERT INTO `cities` VALUES ('1312', '80', 'Clarin');
INSERT INTO `cities` VALUES ('1313', '80', 'Concepcion');
INSERT INTO `cities` VALUES ('1314', '80', 'Don Victoriano Chiongbian (Don Mariano Marcos)');
INSERT INTO `cities` VALUES ('1315', '80', 'Jimenez');
INSERT INTO `cities` VALUES ('1316', '80', 'Lopez Jaena');
INSERT INTO `cities` VALUES ('1317', '80', 'Oroquieta');
INSERT INTO `cities` VALUES ('1318', '80', 'Ozamiz');
INSERT INTO `cities` VALUES ('1319', '80', 'Panaon');
INSERT INTO `cities` VALUES ('1320', '80', 'Plaridel');
INSERT INTO `cities` VALUES ('1321', '80', 'Sapang Dalaga');
INSERT INTO `cities` VALUES ('1322', '80', 'Sinacaban');
INSERT INTO `cities` VALUES ('1323', '80', 'Tangub');
INSERT INTO `cities` VALUES ('1324', '80', 'Tudela');
INSERT INTO `cities` VALUES ('1325', '81', 'Alubijid');
INSERT INTO `cities` VALUES ('1326', '81', 'Balingasag');
INSERT INTO `cities` VALUES ('1327', '81', 'Balingoan');
INSERT INTO `cities` VALUES ('1328', '81', 'Binuangan');
INSERT INTO `cities` VALUES ('1329', '81', 'Cagayan de Oro');
INSERT INTO `cities` VALUES ('1330', '81', 'Claveria');
INSERT INTO `cities` VALUES ('1331', '81', 'El Salvador');
INSERT INTO `cities` VALUES ('1332', '81', 'Gingoog');
INSERT INTO `cities` VALUES ('1333', '81', 'Gitagum');
INSERT INTO `cities` VALUES ('1334', '81', 'Initao');
INSERT INTO `cities` VALUES ('1335', '81', 'Jasaan');
INSERT INTO `cities` VALUES ('1336', '81', 'Kinoguitan');
INSERT INTO `cities` VALUES ('1337', '81', 'Lagonglong');
INSERT INTO `cities` VALUES ('1338', '81', 'Laguindingan');
INSERT INTO `cities` VALUES ('1339', '81', 'Libertad');
INSERT INTO `cities` VALUES ('1340', '81', 'Lugait');
INSERT INTO `cities` VALUES ('1341', '81', 'Magsaysay (Linugos)');
INSERT INTO `cities` VALUES ('1342', '81', 'Manticao');
INSERT INTO `cities` VALUES ('1343', '81', 'Medina');
INSERT INTO `cities` VALUES ('1344', '81', 'Naawan');
INSERT INTO `cities` VALUES ('1345', '81', 'Opol');
INSERT INTO `cities` VALUES ('1346', '81', 'Salay');
INSERT INTO `cities` VALUES ('1347', '81', 'Sugbongcogon');
INSERT INTO `cities` VALUES ('1348', '81', 'Tagoloan');
INSERT INTO `cities` VALUES ('1349', '81', 'Talisayan');
INSERT INTO `cities` VALUES ('1350', '81', 'Villanueva');
INSERT INTO `cities` VALUES ('1351', '82', 'Compostela');
INSERT INTO `cities` VALUES ('1352', '82', 'Laak (San Vicente)');
INSERT INTO `cities` VALUES ('1353', '82', 'Mabini (Doña Alicia)');
INSERT INTO `cities` VALUES ('1354', '82', 'Maco');
INSERT INTO `cities` VALUES ('1355', '82', 'Maragusan (San Mariano)');
INSERT INTO `cities` VALUES ('1356', '82', 'Mawab');
INSERT INTO `cities` VALUES ('1357', '82', 'Monkayo');
INSERT INTO `cities` VALUES ('1358', '82', 'Montevista');
INSERT INTO `cities` VALUES ('1359', '82', 'Nabunturan');
INSERT INTO `cities` VALUES ('1360', '82', 'New Bataan');
INSERT INTO `cities` VALUES ('1361', '82', 'Pantukan');
INSERT INTO `cities` VALUES ('1362', '83', 'Asuncion (Saug)');
INSERT INTO `cities` VALUES ('1363', '83', 'Braulio E. Dujali');
INSERT INTO `cities` VALUES ('1364', '83', 'Carmen');
INSERT INTO `cities` VALUES ('1365', '83', 'Kapalong');
INSERT INTO `cities` VALUES ('1366', '83', 'New Corella');
INSERT INTO `cities` VALUES ('1367', '83', 'Panabo');
INSERT INTO `cities` VALUES ('1368', '83', 'Samal');
INSERT INTO `cities` VALUES ('1369', '83', 'San Isidro');
INSERT INTO `cities` VALUES ('1370', '83', 'Santo Tomas');
INSERT INTO `cities` VALUES ('1371', '83', 'Tagum');
INSERT INTO `cities` VALUES ('1372', '83', 'Talaingod');
INSERT INTO `cities` VALUES ('1373', '84', 'Bansalan');
INSERT INTO `cities` VALUES ('1374', '84', 'Davao City');
INSERT INTO `cities` VALUES ('1375', '84', 'Digos');
INSERT INTO `cities` VALUES ('1376', '84', 'Hagonoy');
INSERT INTO `cities` VALUES ('1377', '84', 'Kiblawan');
INSERT INTO `cities` VALUES ('1378', '84', 'Magsaysay');
INSERT INTO `cities` VALUES ('1379', '84', 'Malalag');
INSERT INTO `cities` VALUES ('1380', '84', 'Matanao');
INSERT INTO `cities` VALUES ('1381', '84', 'Padada');
INSERT INTO `cities` VALUES ('1382', '84', 'Santa Cruz');
INSERT INTO `cities` VALUES ('1383', '84', 'Sulop');
INSERT INTO `cities` VALUES ('1384', '85', 'Don Marcelino');
INSERT INTO `cities` VALUES ('1385', '85', 'Jose Abad Santos (Trinidad)');
INSERT INTO `cities` VALUES ('1386', '85', 'Malita');
INSERT INTO `cities` VALUES ('1388', '85', 'Santa Maria');
INSERT INTO `cities` VALUES ('1389', '85', 'Sarangani');
INSERT INTO `cities` VALUES ('1390', '86', 'Baganga');
INSERT INTO `cities` VALUES ('1391', '86', 'Banaybanay');
INSERT INTO `cities` VALUES ('1392', '86', 'Boston');
INSERT INTO `cities` VALUES ('1393', '86', 'Caraga');
INSERT INTO `cities` VALUES ('1394', '86', 'Cateel');
INSERT INTO `cities` VALUES ('1395', '86', 'Governor Generoso');
INSERT INTO `cities` VALUES ('1396', '86', 'Lupon');
INSERT INTO `cities` VALUES ('1397', '86', 'Manay');
INSERT INTO `cities` VALUES ('1398', '86', 'Mati');
INSERT INTO `cities` VALUES ('1399', '86', 'San Isidro');
INSERT INTO `cities` VALUES ('1400', '86', 'Tarragona');
INSERT INTO `cities` VALUES ('1401', '87', 'Cotobato');
INSERT INTO `cities` VALUES ('1402', '88', 'Alabel');
INSERT INTO `cities` VALUES ('1403', '88', 'Glan');
INSERT INTO `cities` VALUES ('1404', '88', 'Kiamba');
INSERT INTO `cities` VALUES ('1405', '88', 'Maasim');
INSERT INTO `cities` VALUES ('1406', '88', 'Maitum');
INSERT INTO `cities` VALUES ('1407', '88', 'Malapatan');
INSERT INTO `cities` VALUES ('1408', '88', 'Malungon');
INSERT INTO `cities` VALUES ('1409', '89', 'South Cotobato');
INSERT INTO `cities` VALUES ('1410', '90', 'Bagumbayan');
INSERT INTO `cities` VALUES ('1411', '90', 'Columbio');
INSERT INTO `cities` VALUES ('1412', '90', 'Esperanza');
INSERT INTO `cities` VALUES ('1413', '90', 'Isulan');
INSERT INTO `cities` VALUES ('1414', '90', 'Kalamansig');
INSERT INTO `cities` VALUES ('1415', '90', 'Lambayong (Mariano Marcos)');
INSERT INTO `cities` VALUES ('1416', '90', 'Lebak');
INSERT INTO `cities` VALUES ('1417', '90', 'Lutayan');
INSERT INTO `cities` VALUES ('1418', '90', 'Palimbang');
INSERT INTO `cities` VALUES ('1419', '90', 'President Quirino');
INSERT INTO `cities` VALUES ('1420', '90', 'Senator Ninoy Aquino');
INSERT INTO `cities` VALUES ('1421', '91', 'Tacurong');
INSERT INTO `cities` VALUES ('1422', '91', 'Buenavista');
INSERT INTO `cities` VALUES ('1423', '91', 'Butuan');
INSERT INTO `cities` VALUES ('1424', '91', 'Cabadbaran');
INSERT INTO `cities` VALUES ('1425', '91', 'Carmen');
INSERT INTO `cities` VALUES ('1426', '91', 'Jabonga');
INSERT INTO `cities` VALUES ('1427', '91', 'Kitcharao');
INSERT INTO `cities` VALUES ('1428', '91', 'Las Nieves');
INSERT INTO `cities` VALUES ('1429', '91', 'Magallanes');
INSERT INTO `cities` VALUES ('1430', '91', 'Nasipit');
INSERT INTO `cities` VALUES ('1431', '91', 'Remedios T. Romualdez');
INSERT INTO `cities` VALUES ('1432', '91', 'Santiago');
INSERT INTO `cities` VALUES ('1433', '91', 'Tubay');
INSERT INTO `cities` VALUES ('1434', '92', 'Bayugan');
INSERT INTO `cities` VALUES ('1435', '92', 'Bunawan');
INSERT INTO `cities` VALUES ('1436', '92', 'Esperanza');
INSERT INTO `cities` VALUES ('1437', '92', 'La Paz');
INSERT INTO `cities` VALUES ('1438', '92', 'Loreto');
INSERT INTO `cities` VALUES ('1439', '92', 'Prosperidad');
INSERT INTO `cities` VALUES ('1440', '92', 'Rosario');
INSERT INTO `cities` VALUES ('1441', '92', 'San Francisco');
INSERT INTO `cities` VALUES ('1442', '92', 'San Luis');
INSERT INTO `cities` VALUES ('1443', '92', 'Santa Josefa');
INSERT INTO `cities` VALUES ('1444', '92', 'Sibagat');
INSERT INTO `cities` VALUES ('1445', '92', 'Talacogon');
INSERT INTO `cities` VALUES ('1446', '92', 'Trento');
INSERT INTO `cities` VALUES ('1447', '92', 'Veruela');
INSERT INTO `cities` VALUES ('1448', '93', 'Basilisa (Rizal)');
INSERT INTO `cities` VALUES ('1449', '93', 'Cagdianao');
INSERT INTO `cities` VALUES ('1450', '93', 'Dinagat');
INSERT INTO `cities` VALUES ('1451', '93', 'Libjo (Albor)');
INSERT INTO `cities` VALUES ('1452', '93', 'Loreto');
INSERT INTO `cities` VALUES ('1453', '93', 'San Jose');
INSERT INTO `cities` VALUES ('1454', '93', 'Tubajon');
INSERT INTO `cities` VALUES ('1455', '94', 'Alegria');
INSERT INTO `cities` VALUES ('1456', '94', 'Bacuag');
INSERT INTO `cities` VALUES ('1457', '94', 'Burgos');
INSERT INTO `cities` VALUES ('1458', '94', 'Claver');
INSERT INTO `cities` VALUES ('1459', '94', 'Dapa');
INSERT INTO `cities` VALUES ('1460', '94', 'Del Carmen');
INSERT INTO `cities` VALUES ('1461', '94', 'General Luna');
INSERT INTO `cities` VALUES ('1462', '94', 'Gigaquit');
INSERT INTO `cities` VALUES ('1463', '94', 'Mainit');
INSERT INTO `cities` VALUES ('1464', '94', 'Malimono');
INSERT INTO `cities` VALUES ('1465', '94', 'Pilar');
INSERT INTO `cities` VALUES ('1466', '94', 'Placer');
INSERT INTO `cities` VALUES ('1467', '94', 'San Benito');
INSERT INTO `cities` VALUES ('1468', '94', 'San Francisco (Anao-Aon)');
INSERT INTO `cities` VALUES ('1469', '94', 'San Isidro');
INSERT INTO `cities` VALUES ('1470', '94', 'Santa Monica (Sapao)');
INSERT INTO `cities` VALUES ('1471', '94', 'Sison');
INSERT INTO `cities` VALUES ('1472', '94', 'Socorro');
INSERT INTO `cities` VALUES ('1473', '94', 'Surigao City');
INSERT INTO `cities` VALUES ('1474', '94', 'Tagana-an');
INSERT INTO `cities` VALUES ('1475', '94', 'Tubod');
INSERT INTO `cities` VALUES ('1476', '95', 'Barobo');
INSERT INTO `cities` VALUES ('1477', '95', 'Bayabas');
INSERT INTO `cities` VALUES ('1478', '95', 'Bislig');
INSERT INTO `cities` VALUES ('1479', '95', 'Cagwait');
INSERT INTO `cities` VALUES ('1480', '95', 'Cantilan');
INSERT INTO `cities` VALUES ('1481', '95', 'Carmen');
INSERT INTO `cities` VALUES ('1482', '95', 'Carrascal');
INSERT INTO `cities` VALUES ('1483', '95', 'Cortes');
INSERT INTO `cities` VALUES ('1484', '95', 'Hinatuan');
INSERT INTO `cities` VALUES ('1485', '95', 'Lanuza');
INSERT INTO `cities` VALUES ('1486', '95', 'Lianga');
INSERT INTO `cities` VALUES ('1487', '95', 'Lingig');
INSERT INTO `cities` VALUES ('1488', '95', 'Madrid');
INSERT INTO `cities` VALUES ('1489', '95', 'Marihatag');
INSERT INTO `cities` VALUES ('1490', '95', 'San Agustin');
INSERT INTO `cities` VALUES ('1491', '95', 'San Miguel');
INSERT INTO `cities` VALUES ('1492', '95', 'Tagbina');
INSERT INTO `cities` VALUES ('1493', '95', 'Tago');
INSERT INTO `cities` VALUES ('1494', '95', 'Tandag');
INSERT INTO `cities` VALUES ('1495', '96', 'Akbar');
INSERT INTO `cities` VALUES ('1496', '96', 'Al-Barka');
INSERT INTO `cities` VALUES ('1497', '96', 'Hadji Mohammad Ajul');
INSERT INTO `cities` VALUES ('1498', '96', 'Hadji Muhtamad');
INSERT INTO `cities` VALUES ('1499', '96', 'Isabela City');
INSERT INTO `cities` VALUES ('1500', '96', 'Lamitan');
INSERT INTO `cities` VALUES ('1501', '96', 'Lantawan');
INSERT INTO `cities` VALUES ('1502', '96', 'Maluso');
INSERT INTO `cities` VALUES ('1503', '96', 'Sumisip');
INSERT INTO `cities` VALUES ('1504', '96', 'Tabuan-Lasa');
INSERT INTO `cities` VALUES ('1505', '96', 'Tipo-Tipo');
INSERT INTO `cities` VALUES ('1506', '96', 'Tuburan');
INSERT INTO `cities` VALUES ('1507', '96', 'Ungkaya Pukan');
INSERT INTO `cities` VALUES ('1508', '97', 'Amai Manabilang (Bumbaran)');
INSERT INTO `cities` VALUES ('1509', '97', 'Bacolod-Kalawi (Bacolod-Grande)');
INSERT INTO `cities` VALUES ('1510', '97', 'Balabagan');
INSERT INTO `cities` VALUES ('1511', '97', 'Balindong (Watu)');
INSERT INTO `cities` VALUES ('1512', '97', 'Bayang');
INSERT INTO `cities` VALUES ('1513', '97', 'Binidayan');
INSERT INTO `cities` VALUES ('1514', '97', 'Buadiposo-Buntong');
INSERT INTO `cities` VALUES ('1515', '97', 'Bubong');
INSERT INTO `cities` VALUES ('1516', '97', 'Butig');
INSERT INTO `cities` VALUES ('1517', '97', 'Calanogas');
INSERT INTO `cities` VALUES ('1518', '97', 'Ditsaan-Ramain');
INSERT INTO `cities` VALUES ('1519', '97', 'Ganassi');
INSERT INTO `cities` VALUES ('1520', '97', 'Kapai');
INSERT INTO `cities` VALUES ('1521', '97', 'Kapatagan');
INSERT INTO `cities` VALUES ('1522', '97', 'Lumba-Bayabao (Maguing)');
INSERT INTO `cities` VALUES ('1523', '97', 'Lumbaca-Unayan');
INSERT INTO `cities` VALUES ('1525', '97', 'Lumbatan');
INSERT INTO `cities` VALUES ('1526', '97', 'Lumbayanague');
INSERT INTO `cities` VALUES ('1527', '97', 'Madalum');
INSERT INTO `cities` VALUES ('1528', '97', 'Madamba');
INSERT INTO `cities` VALUES ('1529', '97', 'Maguing');
INSERT INTO `cities` VALUES ('1530', '97', 'Malabang');
INSERT INTO `cities` VALUES ('1531', '97', 'Marantao');
INSERT INTO `cities` VALUES ('1532', '97', 'Marawi');
INSERT INTO `cities` VALUES ('1533', '97', 'Marogong');
INSERT INTO `cities` VALUES ('1534', '97', 'Masiu');
INSERT INTO `cities` VALUES ('1535', '97', 'Mulondo');
INSERT INTO `cities` VALUES ('1536', '97', 'Pagayawan (Tatarikan)');
INSERT INTO `cities` VALUES ('1537', '97', 'Piagapo');
INSERT INTO `cities` VALUES ('1538', '97', 'Picong (Sultan Gumander)');
INSERT INTO `cities` VALUES ('1539', '97', 'Poona Bayabao (Gata)');
INSERT INTO `cities` VALUES ('1540', '97', 'Pualas');
INSERT INTO `cities` VALUES ('1541', '97', 'Saguiaran');
INSERT INTO `cities` VALUES ('1542', '97', 'Sultan Dumalondong');
INSERT INTO `cities` VALUES ('1543', '97', 'Tagoloan II');
INSERT INTO `cities` VALUES ('1544', '97', 'Tamparan');
INSERT INTO `cities` VALUES ('1545', '97', 'Taraka');
INSERT INTO `cities` VALUES ('1546', '97', 'Tubaran');
INSERT INTO `cities` VALUES ('1547', '97', 'Tugaya');
INSERT INTO `cities` VALUES ('1548', '97', 'Wao');
INSERT INTO `cities` VALUES ('1549', '98', 'Ampatuan');
INSERT INTO `cities` VALUES ('1550', '98', 'Barira');
INSERT INTO `cities` VALUES ('1551', '98', 'Buldon');
INSERT INTO `cities` VALUES ('1552', '98', 'Buluan');
INSERT INTO `cities` VALUES ('1553', '98', 'Cotabato City');
INSERT INTO `cities` VALUES ('1554', '98', 'Datu Abdullah Sangki');
INSERT INTO `cities` VALUES ('1555', '98', 'Datu Anggal Midtimbang');
INSERT INTO `cities` VALUES ('1556', '98', 'Datu Blah T. Sinsuat');
INSERT INTO `cities` VALUES ('1557', '98', 'Datu Hoffer Ampatuan');
INSERT INTO `cities` VALUES ('1558', '98', 'Datu Montawal (Pagagawan)');
INSERT INTO `cities` VALUES ('1559', '98', 'Datu Odin Sinsuat (Dinaig)');
INSERT INTO `cities` VALUES ('1560', '98', 'Datu Paglas');
INSERT INTO `cities` VALUES ('1561', '98', 'Datu Piang (Dulawan)');
INSERT INTO `cities` VALUES ('1562', '98', 'Datu Salibo');
INSERT INTO `cities` VALUES ('1563', '98', 'Datu Saudi-Ampatuan');
INSERT INTO `cities` VALUES ('1564', '98', 'Datu Unsay');
INSERT INTO `cities` VALUES ('1565', '98', 'General Salipada K. Pendatun');
INSERT INTO `cities` VALUES ('1566', '98', 'Guindulungan');
INSERT INTO `cities` VALUES ('1567', '98', 'Kabuntalan (Tumbao)');
INSERT INTO `cities` VALUES ('1568', '98', 'Mamasapano');
INSERT INTO `cities` VALUES ('1569', '98', 'Mangudadatu');
INSERT INTO `cities` VALUES ('1570', '98', 'Matanog');
INSERT INTO `cities` VALUES ('1571', '98', 'Northern Kabuntalan');
INSERT INTO `cities` VALUES ('1572', '98', 'Pagalungan');
INSERT INTO `cities` VALUES ('1573', '98', 'Paglat');
INSERT INTO `cities` VALUES ('1574', '98', 'Pandag');
INSERT INTO `cities` VALUES ('1575', '98', 'Parang');
INSERT INTO `cities` VALUES ('1576', '98', 'Rajah Buayan');
INSERT INTO `cities` VALUES ('1577', '98', 'Shariff Aguak (Maganoy)');
INSERT INTO `cities` VALUES ('1578', '98', 'Shariff Saydona Mustapha');
INSERT INTO `cities` VALUES ('1579', '98', 'South Upi');
INSERT INTO `cities` VALUES ('1580', '98', 'Sultan Kudarat (Nuling)');
INSERT INTO `cities` VALUES ('1581', '9', 'Sultan Mastura');
INSERT INTO `cities` VALUES ('1582', '98', 'Sultan sa Barongis (Lambayong)');
INSERT INTO `cities` VALUES ('1583', '98', 'Sultan Sumagka (Talitay)');
INSERT INTO `cities` VALUES ('1584', '98', 'Talayan');
INSERT INTO `cities` VALUES ('1585', '98', 'Upi');
INSERT INTO `cities` VALUES ('1586', '99', 'Banguingui (Tongkil)');
INSERT INTO `cities` VALUES ('1587', '99', 'Hadji Panglima Tahil (Marunggas)');
INSERT INTO `cities` VALUES ('1588', '99', 'Indanan');
INSERT INTO `cities` VALUES ('1589', '99', 'Jolo');
INSERT INTO `cities` VALUES ('1590', '99', 'Kalingalan Caluang');
INSERT INTO `cities` VALUES ('1591', '99', 'Lugus');
INSERT INTO `cities` VALUES ('1592', '99', 'Luuk');
INSERT INTO `cities` VALUES ('1593', '99', 'Maimbung');
INSERT INTO `cities` VALUES ('1594', '99', 'Old Panamao');
INSERT INTO `cities` VALUES ('1595', '99', 'Omar');
INSERT INTO `cities` VALUES ('1596', '99', 'Pandami');
INSERT INTO `cities` VALUES ('1597', '99', 'Panglima Estino (New Panamao)');
INSERT INTO `cities` VALUES ('1598', '99', 'Pangutaran');
INSERT INTO `cities` VALUES ('1599', '99', 'Parang');
INSERT INTO `cities` VALUES ('1600', '99', 'Pata');
INSERT INTO `cities` VALUES ('1601', '99', 'Patikul');
INSERT INTO `cities` VALUES ('1602', '99', 'Siasi');
INSERT INTO `cities` VALUES ('1603', '99', 'Talipao');
INSERT INTO `cities` VALUES ('1604', '99', 'Tapul');
INSERT INTO `cities` VALUES ('1605', '100', 'Bongao');
INSERT INTO `cities` VALUES ('1606', '100', 'Languyan');
INSERT INTO `cities` VALUES ('1607', '100', 'Mapun (Cagayan de Tawi-Tawi)');
INSERT INTO `cities` VALUES ('1608', '100', 'Panglima Sugala (Balimbing)');
INSERT INTO `cities` VALUES ('1609', '100', 'Sapa-Sapa');
INSERT INTO `cities` VALUES ('1610', '100', 'Sibutu');
INSERT INTO `cities` VALUES ('1611', '100', 'Simunul');
INSERT INTO `cities` VALUES ('1612', '100', 'Sitangkai');
INSERT INTO `cities` VALUES ('1613', '100', 'South Ubian');
INSERT INTO `cities` VALUES ('1614', '100', 'Tandubas');
INSERT INTO `cities` VALUES ('1615', '100', 'Turtle Islands (Taganak)');
INSERT INTO `cities` VALUES ('1616', '17', 'OLONGAPO');
INSERT INTO `cities` VALUES ('1617', '17', 'OLONGAPO');
INSERT INTO `cities` VALUES ('1618', '89', 'General Santos City');
INSERT INTO `cities` VALUES ('1619', '20', 'Sta. Lucia');
INSERT INTO `cities` VALUES ('1620', '20', 'Malabanias');

-- ----------------------------
-- Table structure for `clusters`
-- ----------------------------
DROP TABLE IF EXISTS `clusters`;
CREATE TABLE `clusters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cluster` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of clusters
-- ----------------------------
INSERT INTO `clusters` VALUES ('1', 'North Luzon');
INSERT INTO `clusters` VALUES ('2', 'NCR');
INSERT INTO `clusters` VALUES ('3', 'South Luzon');
INSERT INTO `clusters` VALUES ('4', 'Visayas');
INSERT INTO `clusters` VALUES ('5', 'Mindanao');

-- ----------------------------
-- Table structure for `customers`
-- ----------------------------
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) NOT NULL,
  `contact_number` varchar(255) DEFAULT '',
  `logged_by` varchar(255) NOT NULL,
  `logged_time` varchar(255) NOT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `updated_time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of customers
-- ----------------------------
INSERT INTO `customers` VALUES ('1', 'Grandtech Head Office', '09XXXXXXXXX', 'admin', '2022-05-24 12:10:37', null, null);
INSERT INTO `customers` VALUES ('2', 'KFC Lolomboy', '12311231', 'julius', '2022-06-11 14:31:06', null, null);

-- ----------------------------
-- Table structure for `employees`
-- ----------------------------
DROP TABLE IF EXISTS `employees`;
CREATE TABLE `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(30) NOT NULL,
  `fk_position` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `mname` varchar(50) DEFAULT NULL,
  `lname` varchar(50) NOT NULL,
  `suffix` varchar(10) DEFAULT NULL,
  `bday` varchar(100) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `contact_number` varchar(100) NOT NULL,
  `fk_cluster` int(11) NOT NULL,
  `fk_region` int(11) NOT NULL,
  `fk_region_area` int(11) NOT NULL,
  `fk_city` int(11) NOT NULL,
  `house_address` text NOT NULL,
  `date_hired` varchar(100) NOT NULL,
  `end_of_contract` varchar(100) DEFAULT '',
  `employment_status` varchar(50) NOT NULL,
  `emergency_contact_persons` varchar(255) DEFAULT NULL,
  `emergency_contact_numbers` varchar(255) DEFAULT NULL,
  `emergency_contact_relations` varchar(255) DEFAULT NULL,
  `availability` tinyint(4) NOT NULL DEFAULT 1,
  `logged_by` varchar(100) NOT NULL,
  `logged_time` varchar(100) NOT NULL,
  `updated_by` varchar(100) DEFAULT '',
  `updated_time` varchar(100) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `fk_cluster` (`fk_cluster`),
  KEY `fk_region` (`fk_region`),
  KEY `fk_region_area` (`fk_region_area`),
  KEY `fk_city` (`fk_city`),
  KEY `fk_position` (`fk_position`),
  CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`fk_cluster`) REFERENCES `clusters` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `employees_ibfk_2` FOREIGN KEY (`fk_region`) REFERENCES `regions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `employees_ibfk_3` FOREIGN KEY (`fk_region_area`) REFERENCES `provinces` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `employees_ibfk_4` FOREIGN KEY (`fk_city`) REFERENCES `cities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `employees_ibfk_5` FOREIGN KEY (`fk_position`) REFERENCES `positions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of employees
-- ----------------------------
INSERT INTO `employees` VALUES ('1', '2022-006', '1', 'Julius Rio', 'De Castro', 'Banting', '', '09/12/1997', 'Male', '09327107326', '3', '6', '43', '7', '34 Salaguinto, Langgam', '07/05/2022', '01/05/2023', 'Probationary', 'Mavell Z. Banting', '09324311929', 'Spouse', '1', 'julius', '2022-07-05 10:38:41', null, null);

-- ----------------------------
-- Table structure for `employees_services`
-- ----------------------------
DROP TABLE IF EXISTS `employees_services`;
CREATE TABLE `employees_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_employee` int(11) NOT NULL,
  `fk_service` int(11) NOT NULL,
  `logged_by` varchar(255) NOT NULL,
  `logged_time` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_employee` (`fk_employee`),
  KEY `fk_service` (`fk_service`),
  CONSTRAINT `employees_services_ibfk_1` FOREIGN KEY (`fk_employee`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `employees_services_ibfk_2` FOREIGN KEY (`fk_service`) REFERENCES `services` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of employees_services
-- ----------------------------

-- ----------------------------
-- Table structure for `overtimes`
-- ----------------------------
DROP TABLE IF EXISTS `overtimes`;
CREATE TABLE `overtimes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_attendance` int(11) NOT NULL,
  `fk_overtime_status` int(11) NOT NULL,
  `overtime_start` varchar(255) NOT NULL,
  `overtime_end` varchar(255) NOT NULL,
  `overtime_remarks` varchar(255) DEFAULT '',
  `approved_start` varchar(255) DEFAULT '',
  `approved_end` varchar(255) DEFAULT NULL,
  `approval_remarks` varchar(255) DEFAULT '',
  `logged_by` varchar(255) NOT NULL,
  `logged_time` varchar(255) NOT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `approved_time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_attendance` (`fk_attendance`),
  KEY `fk_overtime_status` (`fk_overtime_status`),
  CONSTRAINT `overtimes_ibfk_1` FOREIGN KEY (`fk_attendance`) REFERENCES `attendances` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `overtimes_ibfk_2` FOREIGN KEY (`fk_overtime_status`) REFERENCES `overtimes_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of overtimes
-- ----------------------------

-- ----------------------------
-- Table structure for `overtimes_status`
-- ----------------------------
DROP TABLE IF EXISTS `overtimes_status`;
CREATE TABLE `overtimes_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `overtime_status` varchar(255) DEFAULT NULL,
  `availability` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of overtimes_status
-- ----------------------------
INSERT INTO `overtimes_status` VALUES ('1', 'New', '1');
INSERT INTO `overtimes_status` VALUES ('2', 'Approved', '1');
INSERT INTO `overtimes_status` VALUES ('3', 'Rejected', '1');
INSERT INTO `overtimes_status` VALUES ('4', 'Cancelled', '1');

-- ----------------------------
-- Table structure for `payments`
-- ----------------------------
DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_booking` int(11) NOT NULL,
  `mode_of_payment` enum('Cash','GCash','Paymaya','Debit Card','Credit Card') NOT NULL,
  `payment_amount` float NOT NULL,
  `promo` int(11) NOT NULL,
  `discount` float NOT NULL,
  `payment_date` varchar(255) NOT NULL,
  `logged_by` varchar(255) NOT NULL,
  `logged_time` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_booking` (`fk_booking`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`fk_booking`) REFERENCES `bookings` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of payments
-- ----------------------------

-- ----------------------------
-- Table structure for `positions`
-- ----------------------------
DROP TABLE IF EXISTS `positions`;
CREATE TABLE `positions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position` varchar(255) NOT NULL,
  `availability` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of positions
-- ----------------------------
INSERT INTO `positions` VALUES ('1', 'Owner', '1');
INSERT INTO `positions` VALUES ('2', 'Receptionist', '1');
INSERT INTO `positions` VALUES ('3', 'Nail Artist', '1');

-- ----------------------------
-- Table structure for `promos`
-- ----------------------------
DROP TABLE IF EXISTS `promos`;
CREATE TABLE `promos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `promo` varchar(255) NOT NULL,
  `percentage` int(11) NOT NULL,
  `minimum_amount` float NOT NULL,
  `expiration_date` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of promos
-- ----------------------------
INSERT INTO `promos` VALUES ('1', 'Opening Promo', '10', '1000', '2024-02-30');

-- ----------------------------
-- Table structure for `provinces`
-- ----------------------------
DROP TABLE IF EXISTS `provinces`;
CREATE TABLE `provinces` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_region` int(11) NOT NULL,
  `province` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `fk_region` (`fk_region`),
  CONSTRAINT `provinces_ibfk_1` FOREIGN KEY (`fk_region`) REFERENCES `regions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of provinces
-- ----------------------------
INSERT INTO `provinces` VALUES ('1', '1', 'Abra');
INSERT INTO `provinces` VALUES ('2', '1', 'Apayao');
INSERT INTO `provinces` VALUES ('3', '1', 'Benguet');
INSERT INTO `provinces` VALUES ('4', '1', 'Ifugao');
INSERT INTO `provinces` VALUES ('5', '1', 'Kalinga');
INSERT INTO `provinces` VALUES ('6', '1', 'Moutain Province');
INSERT INTO `provinces` VALUES ('7', '2', 'Ilocos Norte');
INSERT INTO `provinces` VALUES ('8', '2', 'Ilocos Sur');
INSERT INTO `provinces` VALUES ('9', '2', 'La Union');
INSERT INTO `provinces` VALUES ('10', '2', 'Pangasinan');
INSERT INTO `provinces` VALUES ('11', '3', 'Batanes');
INSERT INTO `provinces` VALUES ('12', '3', 'Cagayan');
INSERT INTO `provinces` VALUES ('13', '3', 'Isabela');
INSERT INTO `provinces` VALUES ('14', '3', 'Nueva Vizcaya');
INSERT INTO `provinces` VALUES ('15', '3', 'Quirino');
INSERT INTO `provinces` VALUES ('16', '4', 'Aurora');
INSERT INTO `provinces` VALUES ('17', '4', 'Bataan');
INSERT INTO `provinces` VALUES ('18', '4', 'Bulacan');
INSERT INTO `provinces` VALUES ('19', '4', 'Nueva Ecija');
INSERT INTO `provinces` VALUES ('20', '4', 'Pampanga');
INSERT INTO `provinces` VALUES ('21', '4', 'Tarlac');
INSERT INTO `provinces` VALUES ('22', '4', 'Zambales');
INSERT INTO `provinces` VALUES ('23', '5', 'Manila');
INSERT INTO `provinces` VALUES ('24', '5', 'Metro Manila');
INSERT INTO `provinces` VALUES ('41', '6', 'Batangas');
INSERT INTO `provinces` VALUES ('42', '6', 'Cavite');
INSERT INTO `provinces` VALUES ('43', '6', 'Laguna');
INSERT INTO `provinces` VALUES ('44', '6', 'Quezon');
INSERT INTO `provinces` VALUES ('45', '6', 'Rizal');
INSERT INTO `provinces` VALUES ('46', '7', 'Marinduque');
INSERT INTO `provinces` VALUES ('47', '7', 'Occidental Mindoro');
INSERT INTO `provinces` VALUES ('48', '7', 'Oriental Mindoro');
INSERT INTO `provinces` VALUES ('49', '7', 'Palawan');
INSERT INTO `provinces` VALUES ('50', '7', 'Romblon');
INSERT INTO `provinces` VALUES ('51', '8', 'Albay');
INSERT INTO `provinces` VALUES ('52', '8', 'Camarines Norte');
INSERT INTO `provinces` VALUES ('53', '8', 'Camarines Sur');
INSERT INTO `provinces` VALUES ('54', '8', 'Catanduanes');
INSERT INTO `provinces` VALUES ('55', '8', 'Masbate');
INSERT INTO `provinces` VALUES ('56', '8', 'Sorsogon');
INSERT INTO `provinces` VALUES ('57', '9', 'Aklan');
INSERT INTO `provinces` VALUES ('59', '9', 'Antique');
INSERT INTO `provinces` VALUES ('60', '9', 'Capiz');
INSERT INTO `provinces` VALUES ('61', '9', 'Guimaras');
INSERT INTO `provinces` VALUES ('62', '9', 'Iloilo');
INSERT INTO `provinces` VALUES ('63', '9', 'Negros Occidental');
INSERT INTO `provinces` VALUES ('64', '10', 'Bohol');
INSERT INTO `provinces` VALUES ('65', '10', 'Cebu');
INSERT INTO `provinces` VALUES ('66', '10', 'Negros Oriental');
INSERT INTO `provinces` VALUES ('67', '10', 'Siquijor');
INSERT INTO `provinces` VALUES ('68', '11', 'Biliran');
INSERT INTO `provinces` VALUES ('69', '11', 'Eastern Samar');
INSERT INTO `provinces` VALUES ('70', '11', 'Leyte');
INSERT INTO `provinces` VALUES ('71', '11', 'Northern Samar');
INSERT INTO `provinces` VALUES ('72', '11', 'Samar');
INSERT INTO `provinces` VALUES ('73', '11', 'Southern Leyte');
INSERT INTO `provinces` VALUES ('74', '12', 'Zamboanga del Norte');
INSERT INTO `provinces` VALUES ('75', '12', 'Zamboanga del Sur');
INSERT INTO `provinces` VALUES ('76', '12', 'Zamboanga Sibugay');
INSERT INTO `provinces` VALUES ('77', '13', 'Bukidnon');
INSERT INTO `provinces` VALUES ('78', '13', 'Camiguin');
INSERT INTO `provinces` VALUES ('79', '13', 'Lanao del Norte');
INSERT INTO `provinces` VALUES ('80', '13', 'Misamis Occidental');
INSERT INTO `provinces` VALUES ('81', '13', 'Misamis Oriental');
INSERT INTO `provinces` VALUES ('82', '14', 'Davao de Oro');
INSERT INTO `provinces` VALUES ('83', '14', 'Davao del Norte');
INSERT INTO `provinces` VALUES ('84', '14', 'Davao del Sur');
INSERT INTO `provinces` VALUES ('85', '14', 'Davao Occidental');
INSERT INTO `provinces` VALUES ('86', '14', 'Davao Oriental');
INSERT INTO `provinces` VALUES ('87', '15', 'Cotobato');
INSERT INTO `provinces` VALUES ('88', '15', 'Sarangani');
INSERT INTO `provinces` VALUES ('89', '15', 'South Cotobato');
INSERT INTO `provinces` VALUES ('90', '15', 'Sultan Kudarat');
INSERT INTO `provinces` VALUES ('91', '16', 'Agusan del Norte');
INSERT INTO `provinces` VALUES ('92', '16', 'Agusan del Sur');
INSERT INTO `provinces` VALUES ('93', '16', 'Dinagat Islands');
INSERT INTO `provinces` VALUES ('94', '16', 'Surigao del Norte');
INSERT INTO `provinces` VALUES ('95', '16', 'Surigao del Sur');
INSERT INTO `provinces` VALUES ('96', '17', 'Basilan');
INSERT INTO `provinces` VALUES ('97', '17', 'Lanao del Sur');
INSERT INTO `provinces` VALUES ('98', '17', 'Maguindanao');
INSERT INTO `provinces` VALUES ('99', '17', 'Sulu');
INSERT INTO `provinces` VALUES ('100', '17', 'Tawi-tawi');

-- ----------------------------
-- Table structure for `regions`
-- ----------------------------
DROP TABLE IF EXISTS `regions`;
CREATE TABLE `regions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_cluster` int(11) NOT NULL,
  `region` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cluster` (`fk_cluster`),
  CONSTRAINT `regions_ibfk_1` FOREIGN KEY (`fk_cluster`) REFERENCES `clusters` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of regions
-- ----------------------------
INSERT INTO `regions` VALUES ('1', '1', 'CAR', 'CAR');
INSERT INTO `regions` VALUES ('2', '1', 'Region 1', 'Ilocos Region');
INSERT INTO `regions` VALUES ('3', '1', 'Region 2', 'Cagayan Valley');
INSERT INTO `regions` VALUES ('4', '1', 'Region 3', 'Central Luzon');
INSERT INTO `regions` VALUES ('5', '2', 'NCR', 'NCR');
INSERT INTO `regions` VALUES ('6', '3', 'Region 4A', 'CALABARZON');
INSERT INTO `regions` VALUES ('7', '3', 'Region 4B', 'MIMAROPA');
INSERT INTO `regions` VALUES ('8', '3', 'Region 5', 'Bicol Region');
INSERT INTO `regions` VALUES ('9', '4', 'Region 6', 'Western Visayas');
INSERT INTO `regions` VALUES ('10', '4', 'Region 7', 'Central Visayas');
INSERT INTO `regions` VALUES ('11', '4', 'Region 8', 'Eastern Visayas');
INSERT INTO `regions` VALUES ('12', '5', 'Region 9', 'Zamboanga Peninsula');
INSERT INTO `regions` VALUES ('13', '5', 'Region 10', 'Northern Mindanao');
INSERT INTO `regions` VALUES ('14', '5', 'Region 11', 'Davao Region');
INSERT INTO `regions` VALUES ('15', '5', 'Region 12', 'Soccskargen');
INSERT INTO `regions` VALUES ('16', '5', 'Region 13', 'Caraga Region');
INSERT INTO `regions` VALUES ('17', '5', 'BARMM', 'BARMM');

-- ----------------------------
-- Table structure for `services`
-- ----------------------------
DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_name` varchar(255) NOT NULL,
  `service_fee` float NOT NULL,
  `completion_time` int(11) NOT NULL,
  `logged_by` varchar(255) NOT NULL,
  `logged_time` varchar(255) NOT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `updated_time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of services
-- ----------------------------

-- ----------------------------
-- Table structure for `services_fees_changes`
-- ----------------------------
DROP TABLE IF EXISTS `services_fees_changes`;
CREATE TABLE `services_fees_changes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_service` int(11) NOT NULL,
  `old_service_fee` float NOT NULL,
  `new_service_fee` float NOT NULL,
  `logged_by` varchar(255) NOT NULL,
  `logged_time` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_service` (`fk_service`),
  CONSTRAINT `services_fees_changes_ibfk_1` FOREIGN KEY (`fk_service`) REFERENCES `services` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of services_fees_changes
-- ----------------------------

-- ----------------------------
-- Table structure for `undertimes`
-- ----------------------------
DROP TABLE IF EXISTS `undertimes`;
CREATE TABLE `undertimes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_attendance` int(11) NOT NULL,
  `fk_undertime_status` int(11) NOT NULL,
  `undertime_start` varchar(255) NOT NULL,
  `undertime_end` varchar(255) NOT NULL,
  `undertime_remarks` varchar(255) DEFAULT '',
  `approved_start` varchar(255) DEFAULT '',
  `approved_end` varchar(255) DEFAULT NULL,
  `approval_remarks` varchar(255) DEFAULT '',
  `logged_by` varchar(255) NOT NULL,
  `logged_time` varchar(255) NOT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `approved_time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_attendance` (`fk_attendance`),
  KEY `fk_undertime_status` (`fk_undertime_status`),
  CONSTRAINT `undertimes_ibfk_1` FOREIGN KEY (`fk_attendance`) REFERENCES `attendances` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `undertimes_ibfk_2` FOREIGN KEY (`fk_undertime_status`) REFERENCES `undertimes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of undertimes
-- ----------------------------

-- ----------------------------
-- Table structure for `undertimes_status`
-- ----------------------------
DROP TABLE IF EXISTS `undertimes_status`;
CREATE TABLE `undertimes_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `overtime_status` varchar(255) DEFAULT NULL,
  `availability` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of undertimes_status
-- ----------------------------
INSERT INTO `undertimes_status` VALUES ('1', 'New', '1');
INSERT INTO `undertimes_status` VALUES ('2', 'Approved', '1');
INSERT INTO `undertimes_status` VALUES ('3', 'Rejected', '1');
INSERT INTO `undertimes_status` VALUES ('4', 'Cancelled', '1');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `fk_employee_id` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(100) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `password_reset_token` varchar(255) DEFAULT '',
  `user_access` varchar(100) DEFAULT NULL,
  `availability` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` varchar(255) NOT NULL DEFAULT '',
  `updated_at` varchar(255) DEFAULT NULL,
  `auth_key` varchar(255) DEFAULT NULL,
  `verification_token` varchar(255) DEFAULT NULL,
  `managers_code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=246 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('10', 'julius', '2022-006', 'jrbanting@e-cmv.ph', '$2y$13$5sZdUwQI54rfb1pNAWEsquX.7nD82visyHo5.LO8h.wZLQFu0/8Au', '10', 'u4u4i6DWHsi3yWIjiTdnKam2yFUKQxzP_1681358033', 'Administrator', '1', '2021-06-18 16:23:20', '2021-10-22 16:15:41', null, null, '1234');
INSERT INTO `user` VALUES ('245', 'admin', '2022-001', 'aep@e-cmv.ph', '$2y$13$5sZdUwQI54rfb1pNAWEsquX.7nD82visyHo5.LO8h.wZLQFu0/8Au', '10', null, 'Administrator', '1', '2022-05-23 17:55:31', null, null, null, null);

-- ----------------------------
-- View structure for `attendance_report`
-- ----------------------------
DROP VIEW IF EXISTS `attendance_report`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `attendance_report` AS select `att`.`id` AS `id`,date_format(`att`.`sign_in`,'%W, %e %M %Y') AS `date`,concat(`emp`.`fname`,' ',`emp`.`lname`) AS `employee_name`,'' AS `schedule_start`,'' AS `schedule_end`,substr(cast(`att`.`sign_in` as time(6)),1,5) AS `sign_in`,substr(cast(`att`.`sign_out` as time(6)),1,5) AS `sign_out`,concat(lpad(hour(timediff(concat(cast(`att`.`sign_in` as date),' 08:00:00'),`att`.`sign_in`)),2,'0'),':',lpad(minute(timediff(concat(cast(`att`.`sign_in` as date),' 08:00:00'),`att`.`sign_in`)),2,'0')) AS `late`,`ut`.`undertime_start` AS `filed_undertime_start`,`ut`.`undertime_end` AS `filed_undertime_end`,`ut`.`undertime_remarks` AS `undertime_remarks`,`ot`.`overtime_start` AS `filed_ot_start`,`ot`.`overtime_end` AS `filed_ot_end`,`ot`.`overtime_remarks` AS `overtime_remarks`,concat(lpad(hour(timediff(`ot`.`overtime_end`,`ot`.`overtime_start`)),2,'0'),':',lpad(minute(timediff(`ot`.`overtime_end`,`ot`.`overtime_start`)),2,'0')) AS `filed_duration`,if(`ot`.`fk_overtime_status` in (1,2),`ot`.`approved_start`,'') AS `approved_ot_start`,if(`ot`.`fk_overtime_status` in (1,2),`ot`.`approved_end`,'') AS `approved_ot_end`,if(`ot`.`fk_overtime_status` in (1,2),`ot`.`approval_remarks`,'') AS `approval_remarks`,if(`ot`.`fk_overtime_status` in (1,2),concat(lpad(hour(timediff(`ot`.`approved_end`,`ot`.`approved_start`)),2,'0'),':',lpad(minute(timediff(`ot`.`approved_end`,`ot`.`approved_start`)),2,'0')),'') AS `approved_duration`,`ot`.`logged_by` AS `logged_by`,`ot`.`logged_time` AS `logged_time`,`ot`.`approved_by` AS `approved_by`,`ot`.`approved_time` AS `approved_time` from (((`employees` `emp` join `attendances` `att` on(`emp`.`id` = `att`.`fk_employee`)) left join `overtimes` `ot` on(`att`.`id` = `ot`.`fk_attendance`)) left join `undertimes` `ut` on(`att`.`id` = `ut`.`fk_attendance`)) group by `att`.`id` order by `emp`.`id`,cast( `att`.`sign_in` as date);
