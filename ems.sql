-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 26, 2014 at 12:20 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ems`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE IF NOT EXISTS `activity_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `activity_date` int(11) NOT NULL COMMENT 'Activity Date',
  `user_id` int(11) unsigned NOT NULL COMMENT 'ID of User execute action',
  `activity_type` int(11) unsigned NOT NULL COMMENT 'Activity Type',
  `action_group` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Action Group',
  `action_id` int(11) unsigned NOT NULL COMMENT 'ID of user been action',
  `ip_logged` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'IP Adrress',
  PRIMARY KEY (`id`),
  KEY `FK_activity_log_1` (`user_id`),
  KEY `FK_activity_log_2` (`action_id`),
  KEY `FK_activity_log_3` (`activity_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=727 ;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `activity_date`, `user_id`, `activity_type`, `action_group`, `action_id`, `ip_logged`) VALUES
(433, 1387698706, 1, 2, 'user', 1, '127.0.0.1'),
(434, 1387698713, 1, 1, 'user', 1, '127.0.0.1'),
(435, 1387703082, 1, 16, 'vacation', 1, '127.0.0.1'),
(436, 1387703104, 1, 16, 'vacation', 1, '127.0.0.1'),
(437, 1387703112, 1, 16, 'vacation', 1, '127.0.0.1'),
(438, 1387703280, 1, 16, 'vacation', 1, '127.0.0.1'),
(439, 1387703329, 1, 16, 'vacation', 1, '127.0.0.1'),
(440, 1387703332, 1, 16, 'vacation', 1, '127.0.0.1'),
(441, 1387703457, 1, 16, 'vacation', 1, '127.0.0.1'),
(442, 1387703556, 1, 16, 'vacation', 1, '127.0.0.1'),
(443, 1387703588, 1, 16, 'vacation', 1, '127.0.0.1'),
(444, 1387704007, 1, 16, 'vacation', 1, '127.0.0.1'),
(445, 1387704015, 1, 16, 'vacation', 1, '127.0.0.1'),
(446, 1387704138, 1, 3, 'user', 1, '127.0.0.1'),
(447, 1387704142, 1, 4, 'user', 1, '127.0.0.1'),
(448, 1387704165, 1, 8, 'user', 20, '127.0.0.1'),
(449, 1387704166, 1, 4, 'user', 1, '127.0.0.1'),
(450, 1387705186, 1, 3, 'user', 1, '127.0.0.1'),
(451, 1387705186, 1, 4, 'user', 1, '127.0.0.1'),
(452, 1387705192, 1, 8, 'user', 21, '127.0.0.1'),
(453, 1387705192, 1, 4, 'user', 1, '127.0.0.1'),
(454, 1387705272, 1, 2, 'user', 1, '127.0.0.1'),
(455, 1387705335, 20, 1, 'user', 20, '127.0.0.1'),
(456, 1387707135, 20, 4, 'user', 20, '127.0.0.1'),
(457, 1387707363, 20, 3, 'user', 20, '127.0.0.1'),
(458, 1387707363, 20, 4, 'user', 20, '127.0.0.1'),
(459, 1387707372, 20, 8, 'user', 22, '127.0.0.1'),
(460, 1387707372, 20, 4, 'user', 20, '127.0.0.1'),
(461, 1387707385, 20, 4, 'user', 20, '127.0.0.1'),
(462, 1387709948, 20, 10, 'employee', 20, '127.0.0.1'),
(463, 1387901811, 1, 1, 'user', 1, '127.0.0.1'),
(464, 1388083516, 22, 1, 'user', 22, '127.0.0.1'),
(465, 1388083529, 22, 10, 'employee', 22, '127.0.0.1'),
(466, 1388083553, 22, 4, 'user', 22, '127.0.0.1'),
(467, 1388083570, 22, 4, 'user', 22, '127.0.0.1'),
(468, 1388083664, 22, 4, 'user', 22, '127.0.0.1'),
(469, 1388083735, 22, 4, 'user', 22, '127.0.0.1'),
(470, 1388083737, 22, 4, 'user', 22, '127.0.0.1'),
(471, 1388083744, 22, 4, 'user', 22, '127.0.0.1'),
(472, 1388083770, 22, 10, 'employee', 22, '127.0.0.1'),
(473, 1388083781, 22, 10, 'employee', 22, '127.0.0.1'),
(474, 1388083846, 21, 1, 'user', 21, '127.0.0.1'),
(475, 1388083854, 21, 4, 'user', 21, '127.0.0.1'),
(476, 1388083861, 21, 4, 'user', 21, '127.0.0.1'),
(477, 1388083897, 22, 4, 'user', 22, '127.0.0.1'),
(478, 1388084137, 21, 4, 'user', 21, '127.0.0.1'),
(479, 1388084227, 21, 2, 'user', 21, '127.0.0.1'),
(480, 1388084237, 21, 1, 'user', 21, '127.0.0.1'),
(481, 1388085437, 22, 10, 'employee', 22, '127.0.0.1'),
(482, 1388085449, 21, 10, 'employee', 21, '127.0.0.1'),
(483, 1388085454, 21, 10, 'employee', 21, '127.0.0.1'),
(484, 1388085490, 21, 10, 'employee', 21, '127.0.0.1'),
(485, 1388085492, 21, 10, 'employee', 21, '127.0.0.1'),
(486, 1388085493, 21, 10, 'employee', 21, '127.0.0.1'),
(487, 1388085495, 21, 10, 'employee', 21, '127.0.0.1'),
(488, 1388085523, 21, 10, 'employee', 21, '127.0.0.1'),
(489, 1388085637, 22, 10, 'employee', 22, '127.0.0.1'),
(490, 1388085686, 21, 4, 'user', 21, '127.0.0.1'),
(491, 1388085706, 22, 10, 'employee', 22, '127.0.0.1'),
(492, 1388085716, 21, 4, 'user', 21, '127.0.0.1'),
(493, 1388085806, 21, 4, 'user', 21, '127.0.0.1'),
(494, 1388085895, 22, 10, 'employee', 22, '127.0.0.1'),
(495, 1388085986, 20, 1, 'user', 20, '127.0.0.1'),
(496, 1388086092, 20, 10, 'employee', 20, '127.0.0.1'),
(497, 1388086140, 20, 11, 'employee', 21, '127.0.0.1'),
(498, 1388086140, 20, 10, 'employee', 20, '127.0.0.1'),
(499, 1388086142, 20, 11, 'employee', 21, '127.0.0.1'),
(500, 1388086142, 20, 10, 'employee', 20, '127.0.0.1'),
(501, 1388086173, 21, 4, 'user', 21, '127.0.0.1'),
(502, 1388086179, 21, 4, 'user', 21, '127.0.0.1'),
(503, 1388086354, 21, 10, 'employee', 21, '127.0.0.1'),
(504, 1388086362, 22, 10, 'employee', 22, '127.0.0.1'),
(505, 1388086375, 20, 10, 'employee', 20, '127.0.0.1'),
(506, 1388086382, 20, 4, 'user', 20, '127.0.0.1'),
(507, 1388086385, 20, 4, 'user', 20, '127.0.0.1'),
(508, 1388086393, 21, 4, 'user', 21, '127.0.0.1'),
(509, 1388086435, 22, 4, 'user', 22, '127.0.0.1'),
(510, 1388086590, 20, 23, 'contract', 20, '127.0.0.1'),
(511, 1388087873, 21, 4, 'user', 21, '127.0.0.1'),
(512, 1388088120, 22, 4, 'user', 22, '127.0.0.1'),
(513, 1388088980, 22, 10, 'employee', 22, '127.0.0.1'),
(514, 1388089010, 22, 10, 'employee', 22, '127.0.0.1'),
(515, 1388089107, 21, 10, 'employee', 21, '127.0.0.1'),
(516, 1388089268, 21, 10, 'employee', 21, '127.0.0.1'),
(517, 1388089611, 20, 21, 'message', 20, '127.0.0.1'),
(518, 1388089696, 20, 21, 'message', 20, '127.0.0.1'),
(519, 1388110331, 1, 1, 'user', 1, '127.0.0.1'),
(520, 1388400995, 1, 1, 'user', 1, '127.0.0.1'),
(521, 1388681186, 20, 1, 'user', 20, '127.0.0.1'),
(522, 1388681202, 20, 2, 'user', 20, '127.0.0.1'),
(523, 1388681347, 20, 1, 'user', 20, '127.0.0.1'),
(524, 1388681468, 20, 3, 'user', 20, '127.0.0.1'),
(525, 1388681468, 20, 4, 'user', 20, '127.0.0.1'),
(526, 1388681486, 20, 5, 'user', 20, '127.0.0.1'),
(527, 1388681486, 20, 4, 'user', 20, '127.0.0.1'),
(528, 1388681687, 20, 5, 'user', 20, '127.0.0.1'),
(529, 1388681687, 20, 4, 'user', 20, '127.0.0.1'),
(530, 1388681800, 20, 3, 'user', 20, '127.0.0.1'),
(531, 1388681802, 20, 4, 'user', 20, '127.0.0.1'),
(532, 1388681811, 20, 5, 'user', 20, '127.0.0.1'),
(533, 1388681812, 20, 4, 'user', 20, '127.0.0.1'),
(534, 1388681818, 20, 8, 'user', 24, '127.0.0.1'),
(535, 1388681818, 20, 4, 'user', 20, '127.0.0.1'),
(536, 1388681854, 20, 5, 'user', 20, '127.0.0.1'),
(537, 1388681854, 20, 4, 'user', 20, '127.0.0.1'),
(538, 1388681920, 20, 3, 'user', 20, '127.0.0.1'),
(539, 1388681920, 20, 4, 'user', 20, '127.0.0.1'),
(540, 1388681926, 20, 8, 'user', 25, '127.0.0.1'),
(541, 1388681926, 20, 4, 'user', 20, '127.0.0.1'),
(542, 1388681989, 20, 3, 'user', 20, '127.0.0.1'),
(543, 1388681991, 20, 4, 'user', 20, '127.0.0.1'),
(544, 1388682045, 20, 3, 'user', 20, '127.0.0.1'),
(545, 1388682046, 20, 4, 'user', 20, '127.0.0.1'),
(546, 1388682048, 20, 8, 'user', 27, '127.0.0.1'),
(547, 1388682048, 20, 4, 'user', 20, '127.0.0.1'),
(548, 1388682056, 20, 8, 'user', 26, '127.0.0.1'),
(549, 1388682056, 20, 4, 'user', 20, '127.0.0.1'),
(550, 1388682170, 20, 21, 'message', 20, '127.0.0.1'),
(551, 1388682281, 20, 21, 'message', 20, '127.0.0.1'),
(552, 1388682355, 20, 21, 'message', 20, '127.0.0.1'),
(553, 1388682415, 20, 21, 'message', 20, '127.0.0.1'),
(554, 1388682510, 20, 21, 'message', 20, '127.0.0.1'),
(555, 1388682879, 20, 21, 'message', 20, '127.0.0.1'),
(556, 1388683097, 1, 1, 'user', 1, '127.0.0.1'),
(557, 1388683118, 20, 21, 'message', 20, '127.0.0.1'),
(558, 1388683280, 20, 21, 'message', 20, '127.0.0.1'),
(559, 1388685477, 20, 23, 'contract', 20, '127.0.0.1'),
(560, 1388685549, 20, 23, 'contract', 20, '127.0.0.1'),
(561, 1388685632, 20, 23, 'contract', 20, '127.0.0.1'),
(562, 1388685656, 20, 23, 'contract', 20, '127.0.0.1'),
(563, 1388685799, 20, 23, 'contract', 20, '127.0.0.1'),
(564, 1388685919, 20, 23, 'contract', 20, '127.0.0.1'),
(565, 1388686457, 20, 23, 'contract', 20, '127.0.0.1'),
(566, 1388686924, 1, 23, 'contract', 1, '127.0.0.1'),
(567, 1388687140, 20, 23, 'contract', 20, '127.0.0.1'),
(568, 1388687194, 20, 23, 'contract', 20, '127.0.0.1'),
(569, 1388687970, 20, 11, 'employee', 20, '127.0.0.1'),
(570, 1388687971, 20, 10, 'employee', 20, '127.0.0.1'),
(571, 1388687972, 20, 11, 'employee', 20, '127.0.0.1'),
(572, 1388687972, 20, 10, 'employee', 20, '127.0.0.1'),
(573, 1388687978, 20, 11, 'employee', 20, '127.0.0.1'),
(574, 1388687979, 20, 10, 'employee', 20, '127.0.0.1'),
(575, 1388687983, 20, 11, 'employee', 20, '127.0.0.1'),
(576, 1388687983, 20, 10, 'employee', 20, '127.0.0.1'),
(577, 1388687991, 20, 11, 'employee', 20, '127.0.0.1'),
(578, 1388687991, 20, 10, 'employee', 20, '127.0.0.1'),
(579, 1388687994, 20, 11, 'employee', 20, '127.0.0.1'),
(580, 1388687995, 20, 10, 'employee', 20, '127.0.0.1'),
(581, 1388687996, 20, 11, 'employee', 20, '127.0.0.1'),
(582, 1388687996, 20, 10, 'employee', 20, '127.0.0.1'),
(583, 1388687999, 20, 11, 'employee', 20, '127.0.0.1'),
(584, 1388687999, 20, 10, 'employee', 20, '127.0.0.1'),
(585, 1388688001, 20, 11, 'employee', 20, '127.0.0.1'),
(586, 1388688002, 20, 10, 'employee', 20, '127.0.0.1'),
(587, 1388688003, 20, 11, 'employee', 20, '127.0.0.1'),
(588, 1388688003, 20, 10, 'employee', 20, '127.0.0.1'),
(589, 1388688007, 20, 11, 'employee', 20, '127.0.0.1'),
(590, 1388688008, 20, 10, 'employee', 20, '127.0.0.1'),
(591, 1388688011, 20, 11, 'employee', 20, '127.0.0.1'),
(592, 1388688012, 20, 10, 'employee', 20, '127.0.0.1'),
(593, 1388688035, 1, 10, 'employee', 1, '127.0.0.1'),
(594, 1388688048, 20, 10, 'employee', 20, '127.0.0.1'),
(595, 1388711393, 20, 1, 'user', 20, '127.0.0.1'),
(596, 1388711613, 20, 1, 'user', 20, '127.0.0.1'),
(597, 1388711628, 20, 2, 'user', 20, '127.0.0.1'),
(598, 1388711683, 22, 1, 'user', 22, '127.0.0.1'),
(599, 1388711716, 22, 10, 'employee', 22, '127.0.0.1'),
(600, 1388711731, 22, 11, 'employee', 22, '127.0.0.1'),
(601, 1388711731, 22, 10, 'employee', 22, '127.0.0.1'),
(602, 1388711733, 22, 11, 'employee', 22, '127.0.0.1'),
(603, 1388711733, 22, 10, 'employee', 22, '127.0.0.1'),
(604, 1388711737, 22, 11, 'employee', 22, '127.0.0.1'),
(605, 1388711737, 22, 10, 'employee', 22, '127.0.0.1'),
(606, 1388711742, 22, 11, 'employee', 22, '127.0.0.1'),
(607, 1388711742, 22, 10, 'employee', 22, '127.0.0.1'),
(608, 1388711744, 22, 11, 'employee', 22, '127.0.0.1'),
(609, 1388711744, 22, 10, 'employee', 22, '127.0.0.1'),
(610, 1388711745, 22, 11, 'employee', 22, '127.0.0.1'),
(611, 1388711746, 22, 10, 'employee', 22, '127.0.0.1'),
(612, 1388711747, 22, 11, 'employee', 22, '127.0.0.1'),
(613, 1388711747, 22, 10, 'employee', 22, '127.0.0.1'),
(614, 1388711749, 22, 11, 'employee', 22, '127.0.0.1'),
(615, 1388711749, 22, 10, 'employee', 22, '127.0.0.1'),
(616, 1388711753, 22, 11, 'employee', 22, '127.0.0.1'),
(617, 1388711753, 22, 10, 'employee', 22, '127.0.0.1'),
(618, 1388711754, 22, 11, 'employee', 22, '127.0.0.1'),
(619, 1388711754, 22, 10, 'employee', 22, '127.0.0.1'),
(620, 1388711762, 22, 11, 'employee', 22, '127.0.0.1'),
(621, 1388711762, 22, 10, 'employee', 22, '127.0.0.1'),
(622, 1388711764, 22, 11, 'employee', 22, '127.0.0.1'),
(623, 1388711764, 22, 10, 'employee', 22, '127.0.0.1'),
(624, 1388711798, 22, 11, 'employee', 22, '127.0.0.1'),
(625, 1388711798, 22, 10, 'employee', 22, '127.0.0.1'),
(626, 1388732187, 20, 1, 'user', 20, '127.0.0.1'),
(627, 1388732389, 20, 4, 'user', 20, '127.0.0.1'),
(628, 1388732399, 20, 4, 'user', 20, '127.0.0.1'),
(629, 1388732405, 20, 10, 'employee', 20, '127.0.0.1'),
(630, 1388740174, 20, 2, 'user', 20, '127.0.0.1'),
(631, 1388740179, 20, 1, 'user', 20, '127.0.0.1'),
(632, 1388740314, 20, 11, 'employee', 22, '127.0.0.1'),
(633, 1388740314, 20, 10, 'employee', 20, '127.0.0.1'),
(634, 1388740544, 20, 15, 'vacation', 20, '127.0.0.1'),
(636, 1388740643, 20, 21, 'message', 20, '127.0.0.1'),
(637, 1393341764, 1, 1, 'user', 1, '127.0.0.1'),
(638, 1393603337, 1, 1, 'user', 1, '127.0.0.1'),
(639, 1393646891, 1, 1, 'user', 1, '127.0.0.1'),
(640, 1393647620, 1, 4, 'user', 1, '127.0.0.1'),
(641, 1393672665, 1, 10, 'employee', 1, '127.0.0.1'),
(642, 1393672667, 1, 10, 'employee', 1, '127.0.0.1'),
(643, 1393689050, 1, 1, 'user', 1, '127.0.0.1'),
(644, 1393689945, 1, 4, 'user', 1, '127.0.0.1'),
(645, 1393695080, 1, 2, 'user', 1, '127.0.0.1'),
(646, 1393737875, 20, 1, 'user', 20, '127.0.0.1'),
(647, 1393777585, 1, 1, 'user', 1, '127.0.0.1'),
(648, 1394032790, 1, 1, 'user', 1, '127.0.0.1'),
(649, 1394332120, 1, 1, 'user', 1, '127.0.0.1'),
(650, 1395447230, 1, 1, 'user', 1, '127.0.0.1'),
(651, 1396153963, 1, 1, 'user', 1, '127.0.0.1'),
(652, 1408415802, 1, 1, 'user', 1, '127.0.0.1'),
(653, 1408416171, 1, 1, 'user', 1, '127.0.0.1'),
(654, 1408500335, 1, 1, 'user', 1, '127.0.0.1'),
(655, 1408501413, 1, 3, 'user', 1, '127.0.0.1'),
(656, 1408501413, 1, 4, 'user', 1, '127.0.0.1'),
(657, 1408501486, 1, 3, 'user', 1, '127.0.0.1'),
(658, 1408501486, 1, 4, 'user', 1, '127.0.0.1'),
(659, 1408501554, 29, 1, 'user', 29, '127.0.0.1'),
(660, 1408501629, 1, 4, 'user', 1, '127.0.0.1'),
(661, 1408501635, 1, 2, 'user', 1, '127.0.0.1'),
(662, 1408501641, 1, 1, 'user', 1, '127.0.0.1'),
(663, 1408504446, 1, 8, 'user', 28, '127.0.0.1'),
(664, 1408504446, 1, 4, 'user', 1, '127.0.0.1'),
(665, 1408504448, 1, 4, 'user', 1, '127.0.0.1'),
(666, 1408504535, 1, 5, 'user', 1, '127.0.0.1'),
(667, 1408504535, 1, 4, 'user', 1, '127.0.0.1'),
(668, 1408504568, 29, 4, 'user', 29, '127.0.0.1'),
(669, 1408504571, 29, 2, 'user', 29, '127.0.0.1'),
(670, 1408504585, 29, 1, 'user', 29, '127.0.0.1'),
(671, 1408505835, 1, 5, 'user', 1, '127.0.0.1'),
(672, 1408505835, 1, 4, 'user', 1, '127.0.0.1'),
(673, 1408505843, 1, 2, 'user', 1, '127.0.0.1'),
(674, 1408505847, 20, 1, 'user', 20, '127.0.0.1'),
(675, 1408506754, 20, 4, 'user', 20, '127.0.0.1'),
(676, 1408506755, 20, 4, 'user', 20, '127.0.0.1'),
(677, 1408506759, 20, 1, 'user', 20, '127.0.0.1'),
(678, 1408507471, 20, 4, 'user', 20, '127.0.0.1'),
(679, 1408507472, 20, 4, 'user', 20, '127.0.0.1'),
(680, 1408507553, 20, 4, 'user', 20, '127.0.0.1'),
(681, 1408507554, 20, 4, 'user', 20, '127.0.0.1'),
(682, 1408507992, 20, 4, 'user', 20, '127.0.0.1'),
(683, 1408507993, 20, 4, 'user', 20, '127.0.0.1'),
(684, 1408525451, 20, 2, 'user', 20, '127.0.0.1'),
(685, 1408525462, 28, 1, 'user', 28, '127.0.0.1'),
(686, 1408525552, 20, 1, 'user', 20, '127.0.0.1'),
(687, 1408526995, 28, 2, 'user', 28, '127.0.0.1'),
(688, 1408527003, 20, 1, 'user', 20, '127.0.0.1'),
(689, 1408528446, 20, 2, 'user', 20, '127.0.0.1'),
(690, 1408528452, 28, 1, 'user', 28, '127.0.0.1'),
(691, 1408528473, 20, 1, 'user', 20, '127.0.0.1'),
(692, 1408529832, 28, 2, 'user', 28, '127.0.0.1'),
(693, 1408529836, 1, 1, 'user', 1, '127.0.0.1'),
(694, 1408530899, 20, 1, 'user', 20, '127.0.0.1'),
(695, 1408587287, 20, 1, 'user', 20, '127.0.0.1'),
(696, 1408588721, 20, 4, 'user', 20, '127.0.0.1'),
(697, 1408588722, 20, 4, 'user', 20, '127.0.0.1'),
(698, 1408588725, 20, 10, 'employee', 20, '127.0.0.1'),
(699, 1408588725, 20, 10, 'employee', 20, '127.0.0.1'),
(700, 1408588765, 20, 21, 'message', 20, '127.0.0.1'),
(701, 1408588784, 28, 1, 'user', 28, '127.0.0.1'),
(702, 1408593402, 20, 2, 'user', 20, '127.0.0.1'),
(703, 1408593411, 1, 1, 'user', 1, '127.0.0.1'),
(704, 1408593698, 1, 2, 'user', 1, '127.0.0.1'),
(705, 1408593704, 20, 1, 'user', 20, '127.0.0.1'),
(706, 1408596240, 20, 2, 'user', 20, '127.0.0.1'),
(707, 1408596260, 20, 1, 'user', 20, '127.0.0.1'),
(708, 1408596297, 29, 1, 'user', 29, '127.0.0.1'),
(709, 1408596325, 1, 1, 'user', 1, '::1'),
(710, 1408596805, 28, 1, 'user', 28, '127.0.0.1'),
(711, 1408605884, 1, 1, 'user', 1, '::1'),
(712, 1408674493, 20, 1, 'user', 20, '127.0.0.1'),
(713, 1408682976, 28, 1, 'user', 28, '127.0.0.1'),
(714, 1408682994, 28, 2, 'user', 28, '127.0.0.1'),
(715, 1408682999, 1, 1, 'user', 1, '127.0.0.1'),
(716, 1408690212, 20, 2, 'user', 20, '127.0.0.1'),
(717, 1408690227, 28, 1, 'user', 28, '127.0.0.1'),
(718, 1408690851, 1, 1, 'user', 1, '::1'),
(719, 1408695182, 1, 2, 'user', 1, '127.0.0.1'),
(720, 1408695218, 29, 1, 'user', 29, '127.0.0.1'),
(721, 1408933622, 20, 1, 'user', 20, '127.0.0.1'),
(722, 1408941196, 28, 1, 'user', 28, '127.0.0.1'),
(723, 1408949985, 1, 1, 'user', 1, '::1'),
(724, 1408951350, 20, 10, 'employee', 20, '127.0.0.1'),
(725, 1408951390, 20, 10, 'employee', 20, '127.0.0.1'),
(726, 1408951393, 20, 10, 'employee', 20, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `activity_type`
--

CREATE TABLE IF NOT EXISTS `activity_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `activity_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Activity Description',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `activity_type`
--

INSERT INTO `activity_type` (`id`, `activity_description`) VALUES
(1, 'log in'),
(2, 'log out'),
(3, 'create user'),
(4, 'view user'),
(5, 'edit user'),
(7, 'deactivate user'),
(8, 'activate user'),
(10, 'view profile'),
(11, 'edit profile'),
(13, 'withdraw vacation '),
(15, 'create vacation'),
(16, 'view vacation'),
(17, 'edit vacation'),
(18, 'acceppted vacation'),
(19, 'decline vacation'),
(20, 'Request cancel vacation'),
(21, 'Created message'),
(22, 'Updated message'),
(23, 'Create Contract'),
(24, 'Stop Contract');

-- --------------------------------------------------------

--
-- Table structure for table `contract`
--

CREATE TABLE IF NOT EXISTS `contract` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `probation_start_date` int(11) NOT NULL COMMENT 'Probation start date',
  `probation_length` int(11) NOT NULL COMMENT 'Month',
  `probation_end_date` int(11) NOT NULL,
  `contract_start_date` int(11) NOT NULL COMMENT 'Contract Start Date',
  `contract_length` int(11) NOT NULL COMMENT 'Contract length',
  `contract_end_date` int(11) NOT NULL COMMENT 'Contract end date',
  `contract_stop_date` int(11) DEFAULT NULL COMMENT 'Contract stop date',
  `contract_stop_reason` varchar(1000) DEFAULT NULL COMMENT 'Reason stop contract',
  `type` enum('Probation Contract','Limitation Contract','Non Limitation Contract') NOT NULL COMMENT 'Contract Type',
  `employee_id` int(11) unsigned NOT NULL COMMENT 'Employee ID',
  `created_id` int(11) unsigned NOT NULL COMMENT 'Created ID',
  `updated_id` int(11) unsigned DEFAULT NULL COMMENT 'Updated ID',
  `contract_status` int(11) unsigned NOT NULL DEFAULT '1' COMMENT '1: working; 0: non-working;',
  `created_date` int(11) DEFAULT NULL COMMENT 'Contract Created Date',
  `updated_date` int(11) DEFAULT NULL COMMENT 'Contract updated Date',
  PRIMARY KEY (`id`),
  KEY `FK_contract_1` (`employee_id`),
  KEY `FK_contract_2` (`created_id`),
  KEY `FK_contract_3` (`updated_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `contract`
--

INSERT INTO `contract` (`id`, `probation_start_date`, `probation_length`, `probation_end_date`, `contract_start_date`, `contract_length`, `contract_end_date`, `contract_stop_date`, `contract_stop_reason`, `type`, `employee_id`, `created_id`, `updated_id`, `contract_status`, `created_date`, `updated_date`) VALUES
(1, 1386003600, 2, 0, 1388422800, 6, 1404144000, 1388682000, '', 'Probation Contract', 22, 20, NULL, 0, 1388086589, NULL),
(2, 0, 0, 0, 1388509200, 12, 1420045200, 1388682000, '', 'Limitation Contract', 21, 20, NULL, 0, 1388685477, NULL),
(3, 1388509200, 2, 0, 0, 0, 0, NULL, NULL, 'Probation Contract', 24, 20, NULL, 1, 1388685549, NULL),
(4, 1388509200, 2, 0, 0, 0, 0, NULL, NULL, 'Probation Contract', 25, 20, NULL, 1, 1388685631, NULL),
(5, 1388509200, 0, 0, 0, 0, 0, NULL, NULL, 'Probation Contract', 25, 20, NULL, 1, 1388685656, NULL),
(6, 1388509200, 2, 0, 1393606800, 6, 1409500800, NULL, NULL, 'Probation Contract', 26, 20, NULL, 1, 1388685799, NULL),
(7, 1388509200, 2, 0, 1393606800, 6, 1409500800, NULL, NULL, 'Probation Contract', 27, 20, NULL, 1, 1388685919, NULL),
(12, 0, 0, 0, 0, 0, 0, NULL, NULL, 'Probation Contract', 21, 20, NULL, 1, 1388732576, NULL),
(13, 0, 0, 0, 0, 0, 0, NULL, NULL, 'Probation Contract', 21, 20, NULL, 1, 1388732586, NULL),
(14, 0, 0, 0, 0, 0, 0, NULL, NULL, 'Probation Contract', 21, 20, NULL, 1, 1388732590, NULL),
(15, 0, 0, 0, 0, 0, 0, NULL, NULL, 'Probation Contract', 21, 20, NULL, 1, 1388732598, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contract_salary`
--

CREATE TABLE IF NOT EXISTS `contract_salary` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `contract_id` int(11) unsigned NOT NULL COMMENT 'Contract ID',
  `gross_salary` decimal(10,2) NOT NULL COMMENT 'Employee Gross Salary',
  `net_salary` decimal(10,2) NOT NULL COMMENT 'Employee Net Salary',
  `petrol_allowance` decimal(10,2) DEFAULT NULL COMMENT 'Employee Petrol Allowance',
  `lunch_allowance` decimal(10,2) DEFAULT NULL COMMENT 'Employee Lunch Allowance',
  `other_allowance` decimal(10,2) DEFAULT NULL COMMENT 'Employee Other Allowance',
  PRIMARY KEY (`id`),
  KEY `FK_contract_salary_1` (`contract_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `contract_salary`
--

INSERT INTO `contract_salary` (`id`, `contract_id`, `gross_salary`, `net_salary`, `petrol_allowance`, `lunch_allowance`, `other_allowance`) VALUES
(1, 1, '4555.00', '5555.00', '0.00', '0.00', '0.00'),
(2, 2, '8000000.00', '9000000.00', '700000.00', '700000.00', '700000.00'),
(3, 3, '6666666.00', '666666.00', '0.00', '0.00', '0.00'),
(4, 4, '444444.00', '34534.00', '0.00', '0.00', '0.00'),
(5, 5, '444444.00', '34534.00', '0.00', '0.00', '0.00'),
(6, 6, '444444.00', '34534.00', '0.00', '0.00', '0.00'),
(7, 7, '444444.00', '34534.00', '700000.00', '700000.00', '700000.00');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`, `description`) VALUES
(2, 'Software', NULL),
(1, 'Bussiness', NULL),
(3, 'Test', NULL),
(4, 'HR', NULL),
(5, 'Reception', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(11) unsigned NOT NULL COMMENT 'Employee ID',
  `job_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Employee Job Title',
  `degree` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Degree Type',
  `degree_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Degree Name',
  `background` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Background of Employee',
  `telephone` int(11) unsigned DEFAULT NULL,
  `mobile` int(11) unsigned DEFAULT NULL,
  `homeaddress` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Employee Home Address',
  `education` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'Employee Education',
  `skill` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'Employee Skills',
  `experience` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'Employee Experience',
  `notes` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'Employee Notes',
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Employee Avatar',
  `cv` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Employee CV',
  `department_id` int(11) DEFAULT NULL COMMENT 'Department ID',
  `created_date` int(11) DEFAULT NULL COMMENT 'Employee Created Date',
  `updated_date` int(11) DEFAULT NULL COMMENT 'Employee Updated Date',
  `personal_email` varchar(255) DEFAULT NULL COMMENT 'Employee Personal Email',
  PRIMARY KEY (`id`),
  KEY `FK_employee_2` (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `job_title`, `degree`, `degree_name`, `background`, `telephone`, `mobile`, `homeaddress`, `education`, `skill`, `experience`, `notes`, `avatar`, `cv`, `department_id`, `created_date`, `updated_date`, `personal_email`) VALUES
(1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'Developer II', 'Bachelors', 'GTVT', 'IT', 989280619, 989280619, '36/28A D2 P25 Quận Bình Thạnh', '', '', '', '', 'Penguins.jpg', 'NguyenThiTuyen_bao cao.docx', 2, 1388688011, NULL, 'thituyen24@gmail.com'),
(28, 'Business Analyst', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1408501407, NULL, NULL),
(29, 'Jr Developer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1408501480, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_vacation`
--

CREATE TABLE IF NOT EXISTS `employee_vacation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `yearly_date` int(11) DEFAULT NULL COMMENT 'Number Vacation Date Yearly',
  `remaining_vacation` decimal(4,1) DEFAULT NULL COMMENT 'Remaining Vacation in Current Year',
  `employee_id` int(11) unsigned DEFAULT NULL COMMENT 'Employee ID',
  `year` int(11) DEFAULT NULL,
  `total_day_off` decimal(4,1) DEFAULT NULL COMMENT 'Total Date off in Current Year',
  `pre_year_date` decimal(4,1) DEFAULT NULL COMMENT 'Number Remaining Vacation in Last Year',
  `flag` tinyint(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_employee_vacation_1` (`employee_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- Dumping data for table `employee_vacation`
--

INSERT INTO `employee_vacation` (`id`, `yearly_date`, `remaining_vacation`, `employee_id`, `year`, `total_day_off`, `pre_year_date`, `flag`) VALUES
(14, 12, '11.0', 20, 2014, '1.0', NULL, 0),
(17, 12, '9.5', 20, 2014, '2.5', NULL, 0),
(18, 12, '9.5', 20, 2014, '2.5', NULL, 0),
(19, 12, '8.5', 20, 2014, '3.5', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `types` int(11) unsigned NOT NULL COMMENT 'Message''s type',
  `status` int(11) unsigned DEFAULT NULL COMMENT 'Message''s status',
  `created_date` int(11) DEFAULT NULL COMMENT 'Created Date',
  `message_info` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT 'Message Content',
  `mod_user_id` int(11) unsigned NOT NULL COMMENT 'Receiver ID',
  `mod_sender_id` int(11) unsigned NOT NULL COMMENT 'Sender ID',
  `title` varchar(500) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Title',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `types`, `status`, `created_date`, `message_info`, `mod_user_id`, `mod_sender_id`, `title`) VALUES
(4, 1, 1, 1388089611, '<p><strong>&aacute;dasdas</strong></p>\r\n', 0, 20, 'aaaaaaaaa'),
(5, 1, 2, 1388089696, '<p>adasdas</p>\r\n', 22, 20, 'ádasdasd'),
(6, 1, 1, 1388682170, '<p>We are a prolem need solve, everyone will repair</p>\r\n', 0, 20, 'Meeting on Monday'),
(7, 2, 1, 1388682281, '<p>Hi all,</p>\r\n\r\n<p>This weekend, my company will go to karaoke</p>\r\n', 0, 20, 'Party'),
(8, 3, 2, 1388682355, '<p>Remember turn on teamvier before go home</p>\r\n', 20, 20, 'Remember'),
(9, 1, 1, 1388682415, '<p>calendar vacation Tet Holiday: 29/1 - 9/2</p>\r\n', 0, 20, 'Vacation Tet holiday'),
(10, 2, 1, 1388682510, '<p>at 10AM on Monday 6/1/2014, client will visit my company&nbsp;</p>\r\n', 0, 20, 'client go to company'),
(12, 1, 1, 1388683118, '<p>test</p>\r\n', 0, 20, 'test'),
(13, 1, 1, 1388683280, '<p>test</p>\r\n', 0, 20, 'test'),
(14, 1, 1, 1388740643, '<p>nes</p>\r\n', 0, 20, 'test'),
(15, 1, 2, 1408588765, '<p>sdfsdfsd</p>\r\n', 28, 20, 'fdsdfsd');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'User ID',
  `firstname` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'User First Name',
  `lastname` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'User Last Name',
  `fullname` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'User Full Name',
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'User Email',
  `dob` int(11) NOT NULL COMMENT 'Date of Birth',
  `password` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'User Password',
  `activkey` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'User Activkey',
  `status` int(1) unsigned NOT NULL DEFAULT '0' COMMENT 'User Status: 0 Noactive, 1 Active, 2 Banned',
  `lastvisit` int(11) DEFAULT NULL COMMENT 'User Lastvisit',
  `created_date` int(11) DEFAULT NULL COMMENT 'User Create Date',
  `type` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '0: Non Supper Admin, 1: Supper Admin',
  `updated_date` int(11) DEFAULT NULL COMMENT 'User Update Date',
  `roles` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `fullname`, `email`, `dob`, `password`, `activkey`, `status`, `lastvisit`, `created_date`, `type`, `updated_date`, `roles`) VALUES
(1, 'Admin', 'EMS', 'Admin EMS', 'adm.ems.project@gmail.com', 638380800, '61bd60c60d9fb60cc8fc7767669d40a1', NULL, 1, 1370533160, 1370073600, 1, 1380598188, 1),
(20, 'Tuyền Nguyễn', 'Nguyễn', 'Nguyễn Tuyền', 'thituyen24@gmail.com', 638380800, '61bd60c60d9fb60cc8fc7767669d40a1', 'b027e2c0f34b96a56cc8cbbb4bb43ade', 1, NULL, 1387704128, 0, 1408505835, 3),
(28, 'kato', 'san', 'kato san', 'kato@neta.jp', 1407945600, '61bd60c60d9fb60cc8fc7767669d40a1', 'e387e270ee8005f711e3091f3d2137c0', 1, NULL, 1408501407, 0, NULL, 2),
(29, 'tuyentest', 'thanh', 'thanh tuyen', 'tuyen.developer@gmail.com', 1407168000, '61bd60c60d9fb60cc8fc7767669d40a1', '7894cbc6d639d49fda0bc44198671efa', 1, NULL, 1408501480, 0, 1408504535, 4);

-- --------------------------------------------------------

--
-- Table structure for table `vacation`
--

CREATE TABLE IF NOT EXISTS `vacation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `start_date` int(11) NOT NULL COMMENT 'Vacation start date',
  `end_date` int(11) NOT NULL COMMENT 'Vacation end date',
  `total` decimal(4,1) NOT NULL COMMENT 'Vacation total date',
  `type` int(11) NOT NULL COMMENT '1:vacation, 2:illness, 3:wedding, 4:bereavement, 5:maternity;',
  `reason` varchar(2000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Reason for Vacation',
  `user_id` int(11) unsigned NOT NULL COMMENT 'User Request Vacation',
  `approve_id` int(11) unsigned DEFAULT NULL COMMENT 'User Approve Vacation',
  `created_date` int(11) DEFAULT NULL COMMENT 'Vacation Created Date',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1:waiting, 2:withdraw, 3:request_cancel, 4:decline, 5:in_progress, 6:resolved, 7:close;',
  `updated_date` int(11) DEFAULT NULL COMMENT 'Vacation Updated Date',
  `request_day` int(12) NOT NULL,
  `time` enum('am','pm') DEFAULT NULL,
  `comment_one` longtext NOT NULL,
  `comment_two` longtext NOT NULL,
  `comment_three` longtext NOT NULL,
  `comment_four` longtext NOT NULL,
  `flag` int(11) NOT NULL DEFAULT '0',
  `medical_certificate` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_vacation_1` (`user_id`),
  KEY `FK_vacation_2` (`approve_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `vacation`
--

INSERT INTO `vacation` (`id`, `start_date`, `end_date`, `total`, `type`, `reason`, `user_id`, `approve_id`, `created_date`, `status`, `updated_date`, `request_day`, `time`, `comment_one`, `comment_two`, `comment_three`, `comment_four`, `flag`, `medical_certificate`) VALUES
(14, 1408930200, 1408960800, '1.0', 1, 'ádsdsádasdasda\r\n', 20, 1, NULL, 7, NULL, 1408949996, 'am', '', 'ok', 'ok2', '', 0, 0),
(15, 1408930200, 1408960800, '1.0', 1, 'rrrr ff&nbsp;\r\n', 20, 1, NULL, 3, NULL, 1408951186, 'am', '', 'okfhg', '', 'ềwegwg', 0, 0),
(16, 1408930200, 1408960800, '1.0', 1, 'mmm\r\n', 20, 28, NULL, 4, NULL, 1408951883, 'am', 'no ok', '', '', '', 0, 0),
(17, 1408930200, 1408942800, '0.5', 1, 'ádasdasd\r\n', 20, 1, NULL, 7, NULL, 1408953333, 'am', '', '', 'ok', '', 0, 0),
(18, 1408930200, 1409133600, '3.0', 3, 'dfsdfsdfsd\r\n', 20, 1, NULL, 7, NULL, 1408953623, 'am', '', 'ok', 'OK', '', 0, 0),
(19, 1408930200, 1408960800, '1.0', 3, 'ol\r\n', 20, 1, NULL, 7, NULL, 1408953674, 'am', '', 'ok', 'ok', '', 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
