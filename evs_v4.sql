DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE `utilisateurs` (
`utilisateur_id` int(11) NOT NULL AUTO_INCREMENT,
`uniq_id` varchar(255) NOT NULL,
`transport` varchar(25) DEFAULT NULL,
`outil_direction` varchar(3) DEFAULT NULL,
`sexe` varchar(1) DEFAULT NULL,
`age` int(11) DEFAULT NULL,
`occupation` varchar(250) DEFAULT NULL,
`score_test_1` int(11) DEFAULT 0,
`score_test_2` int(11) DEFAULT 0,
`score_test_3` int(11) DEFAULT 0,
`score_test_4` int(11) DEFAULT 0,
`score_test_5` int(11) DEFAULT 0,
PRIMARY KEY (`utilisateur_id`)
);

DROP TABLE IF EXISTS `rel_utilisateur_quartier`;
CREATE TABLE `rel_utilisateur_quartier` (
`utilisateur_id` int(11) NOT NULL,
`quart_id` int(11) NOT NULL,
`familiarite` int(11),
PRIMARY KEY (`utilisateur_id`, `quart_id`)
);

CREATE TABLE IF NOT EXISTS `landmarks` (
  `lmID` int(11) NOT NULL AUTO_INCREMENT,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `lmNom` text NOT NULL,
  `type` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quartier_id` int(11) NOT NULL,
  `classe` text NOT NULL,
  `fonction` text NOT NULL,
  `commentaire` text NOT NULL,
  PRIMARY KEY (`lmID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=124 ;

--
-- Dumping data for table `landmarks`
--

INSERT INTO `landmarks` (`lmID`, `lat`, `lng`, `lmNom`, `type`, `user_id`, `quartier_id`, `classe`, `fonction`, `commentaire`) VALUES
(1, 45.4269043, 4.4166756, 'piscine de la Marandinière', 'Officiel', 0, 1, 'édifice', 'loisirs', ''),
(2, 45.4281241, 4.4180703, 'CHPL', 'Officiel', 0, 1, 'édifice', 'hopital', ''),
(3, 45.4291783, 4.4225121, 'ENISE', 'Officiel', 0, 1, 'édifice', 'éducation', ''),
(4, 45.4151719, 4.4037366, 'Complexe "Le Nautilus"', 'Officiel', 0, 8, 'édifice', 'loisirs', ''),
(5, 45.414976, 4.3938875, 'place Léopold Sedar Senghor #Bellevue', 'Officiel', 0, 8, 'place', '', ''),
(6, 45.4104571, 4.3986726, 'contreflancs du pilot', 'Officiel', 0, 8, 'Repère lointain', 'relief', ''),
(7, 45.4389957, 4.3875575, 'hôtel de ville', 'Officiel', 0, 9, 'édifice + place', '', ''),
(8, 45.441788, 4.3862271, 'place jean jaures #marengo', 'Officiel', 0, 9, 'place', '', ''),
(9, 45.4364738, 4.388051, 'place du peuple', 'Officiel', 0, 9, 'place', '', ''),
(10, 45.4381526, 4.38855767, 'place dorian', 'Officiel', 0, 9, 'place', '', ''),
(11, 45.4347497, 4.3924464, 'place chavanelle', 'Officiel', 0, 9, 'place', '', ''),
(12, 45.4391011, 4.3870854, 'Rue du tram - Jean Jaures/Place du Peuple', 'Officiel', 0, 9, 'rue', '', '887m'),
(13, 45.4358489, 4.3901968, 'rue des martyrs?', 'Officiel', 0, 9, 'rue', '', '360m'),
(14, 45.4376482, 4.3933833, 'avenue de la Libération (route de lyon)', 'Officiel', 0, 9, 'rue', '', '1,3km'),
(15, 45.4385516, 4.3965483, 'rue etienne mimard', 'Officiel', 0, 9, 'rue', '', '850m'),
(16, 45.4383709, 4.3874288, 'plateau pieton #hypercentre', 'Officiel', 0, 9, 'zone', 'mobilier urbain', ''),
(17, 45.4356532, 4.3902826, 'rues pavées du quartier martyr', 'Officiel', 0, 9, 'zone', 'mobilier urbain', ''),
(18, 45.4402454, 4.3988228, 'cité des affaires', 'Officiel', 0, 5, 'édifice', 'entreprise', 'landmark "imposé"'),
(19, 45.4418112, 4.4013119, 'siège casino', 'Officiel', 0, 5, 'édifice', 'entreprise', ''),
(20, 45.4490373, 4.4191217, 'ikéa', 'Officiel', 0, 5, 'édifice', 'commerce', ''),
(21, 45.4432377, 4.3993968, 'gare chateaucreux', 'Officiel', 0, 5, 'édifice + place', 'transports', 'englobe l''esplanade'),
(22, 45.4395152, 4.3962479, 'place Fourneyron', 'Officiel', 0, 5, 'place', '', ''),
(23, 45.438812, 4.4001183, 'parc giron', 'Officiel', 0, 5, 'place', '', ''),
(24, 45.4409756, 4.4033933, 'rue de la montat - proximité chateaucreux', 'Officiel', 0, 5, 'rue', '', '1,2km'),
(25, 45.442978, 4.412384, 'rue de la montat - proximité monthieu', 'Officiel', 0, 5, 'rue', '', '1km'),
(26, 45.4421876, 4.4209135, 'zone commerciale montaud/pont de l''ane', 'Officiel', 0, 5, 'zone', 'zone commerciale', ''),
(27, 45.4545015, 4.36728, 'golf de saint etienne', 'Officiel', 0, 14, 'édifice', 'loisirs', 'zone mais non circulable. Peut être résumé à un point'),
(28, 45.4442501, 4.3717754, 'Collège Puits de la Loire', 'Officiel', 0, 14, 'édifice', 'éducation', ''),
(29, 45.4377009, 4.3797898, 'pole emploie le clapier', 'Officiel', 0, 13, 'édifice', 'collectivité', 'landmark "imposé"'),
(30, 45.4356983, 4.3835127, 'la comédie', 'Officiel', 0, 13, 'édifice', 'loisirs', ''),
(31, 45.4376708, 4.376893, 'musée de la mine', 'Officiel', 0, 13, 'édifice + place', 'loisirs', 'englobe le parc couriot'),
(32, 45.4392065, 4.3722153, 'crassiers de couriot', 'Officiel', 0, 13, 'Repère lointain', 'relief', ''),
(33, 45.442308, 4.3890274, 'escalier du cret de roc', 'Officiel', 0, 10, 'infrastructure', '', ''),
(34, 45.4419693, 4.3897569, 'assenceur du cret de roc', 'Officiel', 0, 10, 'infrastructure', '', ''),
(35, 45.4438286, 4.3904757, 'cimetière du cret de roc', 'Officiel', 0, 10, 'infrastructure', '', ''),
(36, 45.4431059, 4.3915057, 'colline du cret de roc', 'Officiel', 0, 10, 'zone', '', 'coline'),
(37, 45.408493, 4.3869352, 'CHU de Bellevue', 'Officiel', 0, 3, 'édifice', 'hopital', ''),
(38, 45.4164672, 4.3889952, 'Lycée Honoré d''Urfé', 'Officiel', 0, 3, 'édifice', 'éducation', ''),
(39, 45.4415853, 4.3820643, 'place jaquard', 'Officiel', 0, 6, 'place', '', ''),
(40, 45.4442953, 4.3856263, 'Rue du tram - Carnot/Jean Jaures', 'Officiel', 0, 6, 'rue', '', '824m'),
(41, 45.4234105, 4.3839955, 'colline de la cotonne', 'Officiel', 0, 4, 'zone', '', ''),
(42, 45.4365566, 4.4087362, 'IUFM', 'Officiel', 0, 17, 'edifice', 'éducation', ''),
(43, 45.4343884, 4.3988442, 'jardin des plantes', 'Officiel', 0, 17, 'zone', 'parc', 'coline - le relief peut être considéré comme un repère encore plus puissant comme il est en milieu de la ville'),
(44, 45.4227327, 4.4087791, 'école des mines', 'Officiel', 0, 2, 'édifice', 'education', ''),
(45, 45.4225738, 4.4316805, 'I.U.T de Saint Etienne', 'Officiel', 0, 2, 'édifice', 'éducation', ''),
(46, 45.4207237, 4.4114578, 'Le Rond Point', 'Officiel', 0, 2, 'nœud', 'rond point', ''),
(47, 45.4158647, 4.4163108, 'contreflancs du pilot', 'Officiel', 0, 2, 'Repère lointain', 'relief', ''),
(48, 45.4285458, 4.3984365, 'Cours Fauriel - Partie supèrieure', 'Officiel', 0, 2, 'rue', '', '1,35km (jusqu’à rue pierre blachon'),
(49, 45.4240731, 4.4076204, 'Cours Fauriel - Partie inferieur', 'Officiel', 0, 2, 'rue', '', '1,15km'),
(50, 45.4207447, 4.4158709, 'parc de l''europe', 'Officiel', 0, 2, 'zone', 'parc', ''),
(51, 45.4229662, 4.4257736, 'campus des sciences de la métare', 'Officiel', 0, 2, 'zone', 'campus universitaire', ''),
(52, 45.44699, 4.3849182, 'gare carnot', 'Officiel', 0, 15, 'édifice', 'transports', ''),
(53, 45.4502717, 4.385047, 'La platine #cité du design', 'Officiel', 0, 15, 'édifice', 'loisirs + entreprise', ''),
(54, 45.4497636, 4.390626, 'le fil', 'Officiel', 0, 15, 'édifice', 'loisirs', ''),
(55, 45.4542531, 4.3923748, 'le zenith', 'Officiel', 0, 15, 'édifice', 'loisirs', ''),
(56, 45.4519555, 4.3818935, 'place maréchal foch', 'Officiel', 0, 15, 'place', '', ''),
(57, 45.4477879, 4.3854547, 'place carnot', 'Officiel', 0, 15, 'place', '', ''),
(58, 45.4557874, 4.3827724, 'Rue du tram - Terasse/Carnot', 'Officiel', 0, 15, 'rue', '', '2,6km'),
(59, 45.4509491, 4.3719578, 'parc de monteau', 'Officiel', 0, 15, 'zone', 'parc', 'coline - le relief peut être considéré comme un repère puissant comme située en périphérie'),
(60, 45.4521232, 4.3869567, 'campus carnot', 'Officiel', 0, 15, 'zone', 'campus universitaire', ''),
(61, 45.450076, 4.3929005, 'parc françois mitterand #plaine achille', 'Officiel', 0, 15, 'zone', 'parc culturel', ''),
(62, 45.4505201, 4.3988442, 'grande mosquée Mohammed VI', 'Officiel', 0, 16, 'édifice', 'religieux', ''),
(63, 45.4515211, 4.4224691, 'teril de l''eparre', 'Officiel', 0, 16, 'Repère lointain', 'relief', ''),
(64, 45.4626591, 4.3857551, 'parc des sports de l''estivalière #méon', 'Officiel', 0, 16, 'zone', 'parc culturel', ''),
(65, 45.4607176, 4.3900681, 'geoffroy guichard', 'Officiel', 0, 7, 'édifice + place', 'loisirs', 'imagerie de saint Etienne'),
(66, 45.4700782, 4.4029319, 'esplanade de montreynaud', 'Officiel', 0, 7, 'place', '', ''),
(67, 45.422793, 4.3933833, 'centre deux', 'Officiel', 0, 11, 'édifice', 'commerce', ''),
(68, 45.4306414, 4.3901881, 'jardin anatole France', 'Officiel', 0, 11, 'place', '', ''),
(69, 45.429103, 4.3936408, 'place St Roch', 'Officiel', 0, 11, 'place', '', ''),
(70, 45.4302695, 4.3890595, 'Rue du tram - Place du Peuple/Trefilerie', 'Officiel', 0, 11, 'rue', '', '1,46m'),
(71, 45.4215505, 4.3921816, 'Rue du tram - Trefilerie/Bellevue', 'Officiel', 0, 11, 'rue', '', '1,7km'),
(72, 45.4266559, 4.3918276, 'campus trefilerie', 'Officiel', 0, 11, 'zone', 'campus universitaire', ''),
(73, 45.4314985, 4.3869635, 'musée d''art et d''industrie', 'Officiel', 0, 12, 'édifice', 'loisirs', ''),
(74, 45.4331085, 4.3877292, 'les halles #ursules', 'Officiel', 0, 12, 'édifice', 'commerce', ''),
(75, 45.4324866, 4.3878821, 'place albert thomas', 'Officiel', 0, 12, 'place', '', ''),
(76, 45.4346895, 4.3864632, 'ancienne école des beaux arts', 'Officiel', 0, 12, 'Repère lointain', 'batiment', ''),
(77, 45.4317683, 4.4318676, 'Bassin du Janon', 'Officiel', 0, 18, 'édifice', 'naturel', ''),
(78, 45.45664469, 4.4365025, 'Viaduc de Terrenoire', 'Officiel', 0, 18, 'édifice', 'infrastructure', ''),
(79, 45.4359204, 4.4374037, 'place jean et hyppolyte vial #terrenoire', 'Officiel', 0, 18, 'place', '', ''),
(80, 45.4246454, 4.4374895, 'contreflancs du pilot', 'Officiel', 0, 18, 'Repère lointain', 'relief', '');


CREATE TABLE IF NOT EXISTS `poi` (
  `POI_ID` int(11) NOT NULL AUTO_INCREMENT,
  `POINom` varchar(250) NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `POI_Type` varchar(100) NOT NULL,
  PRIMARY KEY (`POI_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;


CREATE TABLE IF NOT EXISTS `poi_ajouter` (
  `POI_id` int(11) NOT NULL AUTO_INCREMENT,
  `POI_nom` varchar(250) NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `quart_id` int(11) NOT NULL,
  PRIMARY KEY (`POI_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;


