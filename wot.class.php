<?php
 /*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:		2009
 * Date:		$Date$
 * -----------------------------------------------------------------------
 * @author		$Author$
 * @copyright	2006-2011 EQdkp-Plus Developer Team
 * @link		http://eqdkp-plus.com
 * @package		eqdkp-plus
 * @version		$Rev$
 * 
 * $Id$
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}

if(!class_exists('wot')) {
	class wot extends game_generic {
		public $version			= '0.5';
		protected $this_game	= 'wot';
		protected $types		= array('classes', 'races');
		protected $classes		= array();
		protected $races		= array();
		public $langs			= array('english', 'german');

		protected $class_dependencies = array(
			array(
				'name'		=> 'race',
				'type'		=> 'races',
				'admin'		=> false,
				'decorate'	=> true,
				'parent'	=> false
			),
			array(
				'name'		=> 'class',
				'type'		=> 'classes',
				'admin'		=> false,
				'decorate'	=> true,
				'primary'	=> true,
				'colorize'	=> true,
				'roster'	=> true,
				'recruitment' => true,
				'parent'	=> array(
					'race' => array(
						0 	=> 'all',	// Unknown
						1 	=> 'all',	// USA
						2 	=> 'all',	// UK
						3 	=> 'all',	// Germany
						4 	=> 'all',	// France
						5 	=> 'all',	// USSR
						6 	=> 'all',	// China
					),
				),
			)
		);
		
		protected $glang		= array();
		protected $lang_file	= array();
		protected $path			= '';
		public $lang			= false;
		
		public function profilefields(){
			$xml_fields = array(
				'tankclass'	=> array(
					'type'			=> 'dropdown',
					'category'		=> 'character',
					'lang'			=> 'uc_tank_type',
					'options'		=> array('T1 Cunningham'	=>	'uc_tank_1', 'M2 Light Tank'	=>	'uc_tank_2', 'T2 Light Tank'	=>	'uc_tank_3', 'M22 Locust'	=>	'uc_tank_4', 'M3 Stuart'	=>	'uc_tank_5', 'MTLS-1G14'	=>	'uc_tank_6', 'M5 Stuart'	=>	'uc_tank_7', 'M24 Chaffee'	=>	'uc_tank_8', 'T21'	=>	'uc_tank_9', 'T71'	=>	'uc_tank_10', 'Cruiser Mk. I'	=>	'uc_tank_11', 'Cruiser Mk. III'	=>	'uc_tank_12', 'Cruiser Mk. II'	=>	'uc_tank_13', 'Cruiser Mk. IV'	=>	'uc_tank_14', 'Covenanter'	=>	'uc_tank_15', 'Valentine'	=>	'uc_tank_16', 'Crusader'	=>	'uc_tank_17', 'Leichttraktor'	=>	'uc_tank_18', 'PzKpfw 35 (t)'	=>	'uc_tank_19', 'PzKpfw 38H735 (f)'	=>	'uc_tank_20', 'PzKpfw II'	=>	'uc_tank_21', 'PzKpfw 38 (t)'	=>	'uc_tank_22', 'PzKpfw II Ausf. J'	=>	'uc_tank_23', 'PzKpfw II Luchs'	=>	'uc_tank_24', 'PzKpfw III Ausf. A'	=>	'uc_tank_25', 'T-15'	=>	'uc_tank_26', 'PzKpfw 38 nA'	=>	'uc_tank_27', 'VK 1602 Leopard'	=>	'uc_tank_28', 'VK 2801'	=>	'uc_tank_29', 'RenaultFT'	=>	'uc_tank_30', 'D1'	=>	'uc_tank_31', 'Hotchkiss H35'	=>	'uc_tank_32', 'AMX 38'	=>	'uc_tank_33', 'AMX 40'	=>	'uc_tank_34', 'ELC AMX'	=>	'uc_tank_35', 'AMX 12t'	=>	'uc_tank_36', 'AMX 13 75'	=>	'uc_tank_37', 'AMX 13 90'	=>	'uc_tank_38', 'MS-1'	=>	'uc_tank_39', 'BT-2'	=>	'uc_tank_40', 'Tetrarch'	=>	'uc_tank_41', 'T-26'	=>	'uc_tank_42', 'BT-7'	=>	'uc_tank_43', 'BT-SV' 	=>	'uc_tank_44', 'M3 Stuart Lend Lease'	=>	'uc_tank_45', 'T-127'	=>	'uc_tank_46', 'T-46'	=>	'uc_tank_47', 'A-20'	=>	'uc_tank_48', 'T-50'	=>	'uc_tank_49', 'Valentine II'	=>	'uc_tank_50', 'T-50-2'	=>	'uc_tank_51', 'Type 62' 	=>	'uc_tank_52', 'T2 Medium Tank'	=>	'uc_tank_53', 'M2 Medium Tank'	=>	'uc_tank_54', 'M3 Lee'	=>	'uc_tank_55', 'M4 Sherman'	=>	'uc_tank_56', 'M4A2E4'	=>	'uc_tank_57', 'M7'	=>	'uc_tank_58', 'Ram-II'	=>	'uc_tank_59', 'M4A3E2'	=>	'uc_tank_60', 'M4A3E8 Sherman'	=>	'uc_tank_61', 'T20'	=>	'uc_tank_62', 'M26 Pershing'	=>	'uc_tank_63', 'T23'	=>	'uc_tank_64', 'T26E4 Super Pershing'	=>	'uc_tank_65', 'T69'	=>	'uc_tank_66', 'M46 Patton'	=>	'uc_tank_67', 'T54E1'	=>	'uc_tank_68', 'M48A1'	=>	'uc_tank_69', 'Vickers Medium Mk. I'	=>	'uc_tank_70', 'Vickers Medium Mk. II'	=>	'uc_tank_71', 'Vickers Medium Mk. III'	=>	'uc_tank_72', 'Matilda'	=>	'uc_tank_73', 'Matilda Black Prince'	=>	'uc_tank_74', 'Cromwell'	=>	'uc_tank_75', 'Comet'	=>	'uc_tank_76', 'Centurion Mk. I'	=>	'uc_tank_77', 'Centurion Mk. 7/1'	=>	'uc_tank_78', 'FV4202'	=>	'uc_tank_79', 'PzKpfw S35 739 (f)'	=>	'uc_tank_80', 'PzKpfw III'	=>	'uc_tank_81', 'PzKpfw III/IV'	=>	'uc_tank_82', 'PzKpfw IV'	=>	'uc_tank_83', 'PzKpfw IV Hydraulic'	=>	'uc_tank_84', 'T-25'	=>	'uc_tank_85', 'PzKpfw IV Schmalturm'	=>	'uc_tank_86', 'PzKpfw V-IV'	=>	'uc_tank_87', 'PzKpfw V-IV Alpha'	=>	'uc_tank_88', 'VK 3001 (H)'	=>	'uc_tank_89', 'VK 3001 (P)'	=>	'uc_tank_90', 'VK 3601 (H)'	=>	'uc_tank_91', 'Panther-M10'	=>	'uc_tank_92', 'PzKpfw V Panther'	=>	'uc_tank_93', 'VK 3002 (DB)'	=>	'uc_tank_94', 'Panther II'	=>	'uc_tank_95', 'E-50'	=>	'uc_tank_96', 'E-50 Ausf. M'	=>	'uc_tank_97', 'D2'	=>	'uc_tank_98', 'Lorraine 40 t'	=>	'uc_tank_99', 'Bat Chatillon 25 t'	=>	'uc_tank_100', 'A-32'	=>	'uc_tank_101', 'T-28'	=>	'uc_tank_102', 'Matilda IV'	=>	'uc_tank_103', 'T-34'	=>	'uc_tank_104', 'T-34-85'	=>	'uc_tank_105', 'KV-13'	=>	'uc_tank_106', 'T-43'	=>	'uc_tank_107', 'T-44'	=>	'uc_tank_108', 'T-54'	=>	'uc_tank_109', 'T-62A'	=>	'uc_tank_110', 'Type 59'	=>	'uc_tank_111', 'Type 59 G'	=>	'uc_tank_112', 'T1 Heavy Tank'	=>	'uc_tank_113', 'T14'	=>	'uc_tank_114', 'M6'	=>	'uc_tank_115', 'T29'	=>	'uc_tank_116', 'M6A2E1'	=>	'uc_tank_117', 'T32'	=>	'uc_tank_118', 'T34'	=>	'uc_tank_119', 'M103'	=>	'uc_tank_120', 'T110E5'	=>	'uc_tank_121', 'T57 Heavy Tank'	=>	'uc_tank_122', 'Churchill I'	=>	'uc_tank_123', 'Churchill VII'	=>	'uc_tank_124', 'TOG II*'	=>	'uc_tank_125', 'Black Prince'	=>	'uc_tank_126', 'Caernarvon'	=>	'uc_tank_127', 'Conqueror'	=>	'uc_tank_128', 'FV215b'	=>	'uc_tank_129', 'PzKpfw B2 740 (f)'	=>	'uc_tank_130', 'PzKpfw VI Tiger'	=>	'uc_tank_131', 'PzKpfw VI Tiger (P)'	=>	'uc_tank_132', 'Löwe'	=>	'uc_tank_133', 'PzKpfw VIB Tiger II'	=>	'uc_tank_134', 'VK 4502 (P) Ausf. A'	=>	'uc_tank_135', 'E-75'	=>	'uc_tank_136', 'VK 4502 (P) Ausf. B'	=>	'uc_tank_137', 'E-100'	=>	'uc_tank_138', 'Maus'	=>	'uc_tank_139', 'B1'	=>	'uc_tank_140', 'BDR G1B'	=>	'uc_tank_141', 'ARL 44'	=>	'uc_tank_142', 'AMX M4(1945)'	=>	'uc_tank_143', 'AMX 50 100'	=>	'uc_tank_144', 'FCM 50 t'	=>	'uc_tank_145', 'AMX 50 120'	=>	'uc_tank_146', 'AMX 50B'	=>	'uc_tank_147', 'Churchill III'	=>	'uc_tank_148', 'KV'	=>	'uc_tank_149', 'KV-1'	=>	'uc_tank_150', 'KV-220'	=>	'uc_tank_151', 'KV-220 Beta-Test'	=>	'uc_tank_152', 'KV-1S'	=>	'uc_tank_153', 'KV-2'	=>	'uc_tank_154', 'T-150'	=>	'uc_tank_155', 'IS'	=>	'uc_tank_156', 'KV-3'	=>	'uc_tank_157', 'IS-3'	=>	'uc_tank_158', 'IS-6'	=>	'uc_tank_159', 'KV-4'	=>	'uc_tank_160', 'KV-5'	=>	'uc_tank_161', 'IS-8'	=>	'uc_tank_162', 'ST-I'	=>	'uc_tank_163', 'IS-4'	=>	'uc_tank_164', 'IS-7'	=>	'uc_tank_165', 'WZ-111'	=>	'uc_tank_166', 'T18'	=>	'uc_tank_167', 'T82'	=>	'uc_tank_168', 'M8A1'	=>	'uc_tank_169', 'T40'	=>	'uc_tank_170', 'M10 Wolverine'	=>	'uc_tank_171', 'T49'	=>	'uc_tank_172', 'M18 Hellcat'	=>	'uc_tank_173', 'M36 Jackson'	=>	'uc_tank_174', 'T25 AT'	=>	'uc_tank_175', 'T25/2'	=>	'uc_tank_176', 'T28'	=>	'uc_tank_177', 'T28 Prototype'	=>	'uc_tank_178', 'T30'	=>	'uc_tank_179', 'T95'	=>	'uc_tank_180', 'T110E3'	=>	'uc_tank_181', 'T110E4'	=>	'uc_tank_182', 'AT-15A'	=>	'uc_tank_183', 'Panzerjäger I'	=>	'uc_tank_184', 'Marder II'	=>	'uc_tank_185', 'Hetzer'	=>	'uc_tank_186', 'StuG III'	=>	'uc_tank_187', 'Dicker Max'	=>	'uc_tank_188', 'JagdPz IV'	=>	'uc_tank_189', 'Jagdpanther'	=>	'uc_tank_190', '8.8 cm PaK 43 Jagdtiger'	=>	'uc_tank_191', 'Ferdinand'	=>	'uc_tank_192', 'Jagdpanther II'	=>	'uc_tank_193', 'Jagdtiger'	=>	'uc_tank_194', 'JagdPz E-100'	=>	'uc_tank_195', 'RenaultFT AC'	=>	'uc_tank_196', 'FCM36 PaK40'	=>	'uc_tank_197', 'Renault UE 57'	=>	'uc_tank_198', 'Somua SAu-40'	=>	'uc_tank_199', 'S-35 CA'	=>	'uc_tank_200', 'ARL V39'	=>	'uc_tank_201', 'AMX AC Mle. 1946'	=>	'uc_tank_202', 'AMX AC Mle. 1948'	=>	'uc_tank_203', 'AMX 50 Foch'	=>	'uc_tank_204', 'AMX-50 Foch (155)'	=>	'uc_tank_205', 'AT-1'	=>	'uc_tank_206', 'SU-76'	=>	'uc_tank_207', 'SU-85B'	=>	'uc_tank_208', 'SU-85'	=>	'uc_tank_209', 'SU-85I' 	=>	'uc_tank_210', 'SU-100'	=>	'uc_tank_211', 'SU-100M1'	=>	'uc_tank_212', 'SU-122-44' 	=>	'uc_tank_213', 'SU-152'	=>	'uc_tank_214', 'ISU-152'	=>	'uc_tank_215', 'SU-101'	=>	'uc_tank_216', 'Object 704'	=>	'uc_tank_217', 'SU-122-54'	=>	'uc_tank_218', 'Object 263'	=>	'uc_tank_219', 'Object 268'	=>	'uc_tank_220', 'T57'	=>	'uc_tank_221', 'M37'	=>	'uc_tank_222', 'M7 Priest'	=>	'uc_tank_223', 'M41'	=>	'uc_tank_224', 'M12'	=>	'uc_tank_225', 'M40/M43'	=>	'uc_tank_226', 'T92'	=>	'uc_tank_227', 'Sturmpanzer I Bison'	=>	'uc_tank_228', 'Sturmpanzer II'	=>	'uc_tank_229', 'Wespe'	=>	'uc_tank_230', 'Grille'	=>	'uc_tank_231', 'Hummel'	=>	'uc_tank_232', 'GW Panther'	=>	'uc_tank_233', 'GW Tiger'	=>	'uc_tank_234', 'GW Typ E'	=>	'uc_tank_235', 'RenaultBS'	=>	'uc_tank_236', 'Lorraine39 L AM'	=>	'uc_tank_237', '105 leFH18B2'	=>	'uc_tank_238', 'AMX 105AM'	=>	'uc_tank_239', 'AMX 13 F3 AM'	=>	'uc_tank_240', 'Lorraine155 50'	=>	'uc_tank_241', 'Lorraine155 51'	=>	'uc_tank_242', 'Bat Chatillon 155'	=>	'uc_tank_243', 'SU-18'	=>	'uc_tank_244', 'SU-26'	=>	'uc_tank_245', 'SU-5'	=>	'uc_tank_246', 'SU-8'	=>	'uc_tank_247', 'S-51'	=>	'uc_tank_248', 'SU-14'	=>	'uc_tank_249', 'Object 212'	=>	'uc_tank_250', 'Object 261'	=>	'uc_tank_251', 'Renault NC-31' => 'uc_tank_252', 'Vickers Mk. E Type B' => 'uc_tank_253', 'Type 2597 Chi-Ha' => 'uc_tank_254', 'M5A1 Stuart' => 'uc_tank_255', '59-16' => 'uc_tank_256', 'WZ-131' => 'uc_tank_257', 'WZ-132' => 'uc_tank_258', 'Type T-34' => 'uc_tank_259', 'Type 58' => 'uc_tank_260', 'T-34-1' => 'uc_tank_261', 'T-34-2' => 'uc_tank_262', 'WZ-120' => 'uc_tank_263', '121'=> 'uc_tank_264', 'IS-2' => 'uc_tank_265', '110' => 'uc_tank_266', 'WZ-111 model 1-4' => 'uc_tank_267', '113' => 'uc_tank_268', 'Universal Carrier QF 2 pounder' => 'uc_tank_269', 'Alecto' => 'uc_tank_270', 'Valentine AT' => 'uc_tank_271', 'АТ 2' => 'uc_tank_272', 'АТ 7' => 'uc_tank_273', 'Gun Carrier Churchill' => 'uc_tank_274', 'АТ 8' => 'uc_tank_275', 'АТ 15' => 'uc_tank_276', 'А39 Tortoise' => 'uc_tank_277', 'FV215b(183)' => 'uc_tank_278', 'Pz.I' => 'uc_tank_279', 'Pz.I Ausf.С' => 'uc_tank_280', 'Pz.II Ausf.G' => 'uc_tank_281', 'SU-100Y' => 'uc_tank_282', 'VK 20.01 (D)' => 'uc_tank_283', 'VK 30.02 (D) v1' => 'uc_tank_284', 'Indien Panzer' => 'uc_tank_285', 'Prototype der Arbeitsgruppe A' => 'uc_tank_286', 'Leopard 1' => 'uc_tank_287', 'Aufklärerpanzer Panther' => 'uc_tank_288', Т-60 => 'uc_tank_289', Т-70 => 'uc_tank_290', Т-80 => 'uc_tank_291'),
					'undeletable'	=> true,
					'visible'		=> true,
				),
				'team'	=> array(
					'type'			=> 'text',
					'category'		=> 'character',
					'lang'			=> 'uc_team',
					'size'			=> 40,
					'undeletable'	=> true,
					'visible'		=> true,
				)
			);
			return $xml_fields;
		}

		/**
		* Returns ImageTag with class-icon
		*
		* @param int $class_id
		* @param bool $big
		* @param bool $pathonly
		* @return html string
		*/
		public function decorate_classes($class_id, $big=false, $pathonly=false) {
		if($big AND !in_array('classes_big', $this->icons)) $big = false;
		$faction = ($class_id) ? $this->config->get('wot_faction')*8 : 0;
		$icon_path = $this->root_path.'games/'.$this->this_game.'/classes/'.($class_id+$faction).(($big) ? '_b.png' : '.png');
		if(is_file($icon_path)){
			return ($pathonly) ? $icon_path : "<img src='".$icon_path."' alt='' />";
		}
		return false;
		}

		public function install($install=false){
			

			//Do this SQL Query NOT if the Eqdkp is installed -> only @ the first install
			#if($install){
			#}
			
			return $info;
		}
	}
}
?>