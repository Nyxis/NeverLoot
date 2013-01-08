SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


INSERT INTO `wow_boss` (`id_boss`, `id_raid`, `nom_fr`, `nom_en`, `ordre`, `cadavre_fr`, `cadavre_en`, `image`) VALUES
(1, 1, 'Ultraxion', NULL, 5, 'Cache inférieure des Aspects', NULL, 'ultraxion.jpg'),
(2, 1, 'Echine de Deathwing', NULL, 7, 'Cache supérieure des Aspects', NULL, 'echine_deathwing.jpg'),
(3, 1, 'Folie de Deathwing', NULL, 8, 'Fragment d’élémentium', NULL, 'folie_deathwing.jpg'),
(4, 1, 'Hagara la Lieuse des tempêtes', NULL, 4, 'Hagara la Lieuse des tempêtes', NULL, 'hagara.jpg'),
(5, 1, 'Morchok', NULL, 1, 'Morchok', NULL, 'morchok.jpg'),
(6, 1, 'Seigneur de guerre Zon’ozz', NULL, 2, 'Seigneur de guerre Zon’ozz', NULL, 'zonozz.jpg'),
(7, 1, 'Yor''sahj l’Insomniaque', NULL, 3, 'Yor''sahj l’Insomniaque', NULL, 'yorsahj.jpg'),
(8, 1, 'Maître de guerre Corne-Noire', NULL, 6, 'Maître de guerre Corne-Noire', NULL, 'corne_noire.jpg'),
(9, 7, 'Protecteurs de l’Éternel', 'Protectors of the Endless', 1, 'Protecteur Kaolan', 'Protector Kaolan', NULL),
(10, 7, 'Tsulong', 'Tsulong', 2, 'Tsulong', 'Tsulong', NULL),
(11, 7, 'Lei Shi', 'Lei Shi', 3, 'Lei Shi', 'Lei Shi', NULL),
(12, 7, 'Sha de la Peur', 'Sha of Fear', 4, 'Sha de la Peur', 'Sha of Fear', NULL),
(13, 5, 'La garde de pierre', 'The Stone Guard', 1, 'La garde de pierre', 'The Stone Guard', NULL),
(14, 5, 'Feng le Maudit', 'Feng the Accursed', 2, 'Feng le Maudit', 'Feng the Accursed', NULL),
(15, 5, 'Gara’jal le Lieur d’esprit', 'Gara''jal the Spiritbinder', 3, 'Gara’jal le Lieur d’esprit', 'Gara''jal the Spiritbinder', NULL),
(16, 5, 'Les esprits-rois', 'The Spirit Kings', 4, 'Les esprits-rois', 'The Spirit Kings', NULL),
(17, 5, 'Elegon ', 'Elegon ', 5, 'Cache d’énergie pure', 'Cache of Pure Energy', NULL),
(18, 5, 'Volonté de l’empereur', 'Will of the Emperor', 6, 'Jan Xi', 'Jan Xi', NULL),
(19, 6, 'Vizir impérial Zor’lok', 'Imperial Vizier Zor''lok', 1, 'Vizir impérial Zor’lok', 'Imperial Vizier Zor''lok', NULL),
(20, 6, 'Seigneur des lames Ta’yak', 'Blade Lord Ta''yak', 2, 'Seigneur des lames Ta’yak', 'Blade Lord Ta''yak', NULL),
(21, 6, 'Garalon', 'Garalon', 3, 'Garalon', 'Garalon', NULL),
(22, 6, 'Seigneur du Vent Mel’jarak', 'Wind Lord Mel''jarak', 4, 'Seigneur du Vent Mel’jarak', 'Wind Lord Mel''jarak', NULL),
(25, 6, 'Sculpte-ambre Un’sok ', 'Amber-Shaper Un''sok', 5, 'Sculpte-ambre Un’sok ', 'Amber-Shaper Un''sok', NULL),
(26, 6, 'Grande impératrice Shek’zeer', 'Grand Empress Shek''zeer', 6, 'Grande impératrice Shek’zeer', 'Grand Empress Shek''zeer', NULL),
(27, 8, 'Jin''rokh le Briseur', 'Jin''rokh the Breaker', 1, 'Jin''rokh le Briseur', 'Jin''rokh the Breaker', NULL),
(28, 8, 'Horridon', 'Horridon', 2, 'Horridon', 'Horridon', NULL),
(29, 8, 'Conseil des anciens', 'Old council', 3, 'Conseil des anciens', 'Old council', NULL),
(30, 8, 'Tortos', 'Tortos', 4, 'Tortos', 'Tortos', NULL),
(31, 8, 'Megaera', 'Megaera', 5, 'Megaera', 'Megaera', NULL),
(32, 8, 'Ji-Kun', 'Ji-Kun', 6, 'Ji-Kun', 'Ji-Kun', NULL),
(33, 8, 'Durumu', 'Durumu', 7, 'Durumu', 'Durumu', NULL),
(34, 8, 'Primordius', 'Primordius', 8, 'Primordius', 'Primordius', NULL),
(35, 8, 'Sombre Animus', 'Dark Animus', 10, 'Sombre Animus', 'Dark Animus', NULL),
(36, 8, 'Stone Guard v2', 'Stone Guard v2', 11, 'Stone Guard v2', 'Stone Guard v2', NULL),
(37, 8, 'Les jumelles consort', 'Twins consort', 13, 'Les jumelles consort', 'Twins consort', NULL),
(38, 8, 'Lei Shen le Roi Tonnerre', 'Lei Shen', 14, 'Lei Shen', 'Lei Shen', NULL),
(39, 8, 'Ra-den', 'Ra-den', 15, 'Ra-den', 'Ra-den', NULL);

INSERT INTO `wow_raid` (`id_raid`, `id_zone`, `nom_fr`, `nom_en`, `image`) VALUES
(1, 5892, 'L''Ame des Dragons', 'Dragon Soul', 'vignette_dragon_soul.jpg'),
(2, 5723, 'Terres de Feu', 'Firelands', 'firelands.jpg'),
(3, 5334, 'Bastion du Crépuscule', 'Bastion of Twilight', 'bot.jpg'),
(4, 5638, 'Trône des Quatre-Vents', 'Four Winds Throne', 't4v.jpg'),
(5, 6125, 'Caveaux Mogu''shan', 'Mogu''shan Vaults', 'mogushan_caveaux.jpg'),
(6, 6297, 'Coeur de la peur', 'Heart of the Fear', NULL),
(7, 6067, 'Terrasse Printanière', 'Terrace of Endless Spring', NULL),
(8, 6622, 'Trône du Tonnerre', 'Throne of Thunder', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
