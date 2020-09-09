<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%country}}`.
 */
class m200909_035839_create_country_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
    	if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%country}}', [
            'id'      => $this->primaryKey(),
            'number'  => $this->smallInteger(3)->notNull(),
            'alpha'   => $this->string(2)->unique()->notNull(),
            'calling' => $this->smallInteger(3)->notNull(),
            'name_en' => $this->string(255)->notNull(),
            'name_ru' => $this->string(255)->notNull(),
            'name_uk' => $this->string(255)->notNull(),
        ], $tableOptions);

        $this->execute($this->getCountrySql());

        $this->alterColumn('{{%user}}', 'country', $this->integer()->notNull());

        $this->createIndex(
            'idx-user-country',
            '{{%user}}',
            'country'
        );
        $this->addForeignKey(
            'fk-user-country',
            '{{%user}}',
            'country',
            '{{%country}}',
            'id',
            'RESTRICT'
        );

        $this->alterColumn('{{%clients}}', 'country', $this->integer()->notNull());

        $this->createIndex(
            'idx-clients-country',
            '{{%clients}}',
            'country'
        );
        $this->addForeignKey(
            'fk-clients-country',
            '{{%clients}}',
            'country',
            '{{%country}}',
            'id',
            'RESTRICT'
        );
    }

    private function getCountrySql(){
        return "INSERT IGNORE INTO `country` (`id`, `number`, `alpha`, `calling`, `name_en`, `name_ru`, `name_uk`) VALUES
            (1, 4, 'af', 93, 'Afghanistan', 'Афганистан', 'Афганістан'),
            (2, 8, 'al', 355, 'Albania', 'Албания', 'Албанія'),
            (3, 10, 'aq', 672, 'Antarctica', 'Антарктика', 'Антарктика'),
            (4, 12, 'dz', 213, 'Algeria', '', ''),
            (5, 16, 'as', 1, 'American Samoa', '', ''),
            (6, 20, 'ad', 376, 'Andorra', 'Андора', 'Андора'),
            (7, 24, 'ao', 244, 'Angola', 'Ангола', 'Ангола'),
            (8, 28, 'ag', 1, 'Antigua and Barbuda', '', ''),
            (9, 31, 'az', 994, 'Azerbaijan', '', ''),
            (10, 32, 'ar', 54, 'Argentina', 'Аргентина', 'Аргентина'),
            (11, 36, 'au', 61, 'Australia', 'Австралия', 'Австралія'),
            (12, 40, 'at', 43, 'Austria', 'Австрия', 'Австрія'),
            (13, 44, 'bs', 1, 'The Bahamas', '', ''),
            (14, 48, 'bh', 973, 'Bahrain', '', ''),
            (15, 50, 'bd', 880, 'Bangladesh', '', ''),
            (16, 51, 'am', 374, 'Armenia', 'Армения', 'Арменія'),
            (17, 52, 'bb', 1, 'Barbados', '', ''),
            (18, 56, 'be', 32, 'Belgium', 'Белгия', 'Белгія'),
            (19, 60, 'bm', 1, 'Bermuda', '', ''),
            (20, 64, 'bt', 975, 'Bhutan', '', ''),
            (21, 68, 'bo', 591, 'Bolivia', 'Боливия', 'Болівія'),
            (22, 70, 'ba', 387, 'Bosnia and Herzegovina', '', ''),
            (23, 72, 'bw', 267, 'Botswana', '', ''),
            (24, 74, 'bv', 47, 'Bouvet Island', '', ''),
            (25, 76, 'br', 55, 'Brazil', 'Бразилия', 'Бразилія'),
            (26, 84, 'bz', 501, 'Belize', '', ''),
            (27, 86, 'io', 246, 'British Indian Ocean Territory', '', ''),
            (28, 90, 'sb', 677, 'Solomon Islands', '', ''),
            (29, 92, 'vg', 1, 'British Virgin Islands', '', ''),
            (30, 96, 'bn', 673, 'Brunei', '', ''),
            (31, 100, 'bg', 359, 'Bulgaria', '', ''),
            (32, 104, 'mm', 95, 'Myanmar', '', ''),
            (33, 108, 'bi', 257, 'Burundi', '', ''),
            (34, 112, 'by', 375, 'Belarus', 'Белорусия', 'Білорусія'),
            (35, 116, 'kh', 855, 'Cambodia', '', ''),
            (36, 120, 'cm', 237, 'Cameroon', 'Камерун', 'Камерун'),
            (37, 124, 'ca', 1, 'Canada', '', ''),
            (38, 132, 'cv', 238, 'Cabo Verde', '', ''),
            (39, 136, 'ky', 1, 'Cayman Islands', '', ''),
            (40, 140, 'cf', 236, 'Central African Republic', '', ''),
            (41, 144, 'lk', 94, 'Sri Lanka', '', ''),
            (42, 148, 'td', 235, 'Chad', '', ''),
            (43, 152, 'cl', 56, 'Chile', '', ''),
            (44, 156, 'cn', 86, 'China', '', ''),
            (45, 158, 'tw', 886, 'Taiwan', '', ''),
            (46, 162, 'cx', 61, 'Christmas Island', '', ''),
            (47, 166, 'cc', 61, 'Cocos Islands', '', ''),
            (48, 170, 'co', 57, 'Colombia', '', ''),
            (49, 174, 'km', 269, 'Comoros', '', ''),
            (50, 175, 'yt', 262, 'Mayotte', '', ''),
            (51, 178, 'cg', 242, 'Republic of the Congo', '', ''),
            (52, 180, 'cd', 243, 'Democratic Republic of the Congo', '', ''),
            (53, 184, 'ck', 682, 'Cook Islands', '', ''),
            (54, 188, 'cr', 506, 'Costa Rica', '', ''),
            (55, 191, 'hr', 385, 'Croatia', '', ''),
            (56, 192, 'cu', 53, 'Cuba', '', ''),
            (57, 196, 'cy', 357, 'Cyprus', '', ''),
            (58, 203, 'cz', 420, 'Czech Republic', '', ''),
            (59, 204, 'bj', 229, 'Benin', '', ''),
            (60, 208, 'dk', 45, 'Denmark', '', ''),
            (61, 212, 'dm', 1, 'Dominica', '', ''),
            (62, 214, 'do', 1, 'Dominican Republic', '', ''),
            (63, 218, 'ec', 593, 'Ecuador', '', ''),
            (64, 222, 'sv', 503, 'El Salvador', '', ''),
            (65, 226, 'gq', 240, 'Equatorial Guinea', '', ''),
            (66, 231, 'et', 251, 'Ethiopia', '', ''),
            (67, 232, 'er', 291, 'Eritrea', '', ''),
            (68, 233, 'ee', 372, 'Estonia', '', ''),
            (69, 234, 'fo', 298, 'Faroe Islands', '', ''),
            (70, 238, 'fk', 500, 'Falkland Islands', '', ''),
            (71, 239, 'gs', 500, 'South Georgia and the South Sandwich Islands', '', ''),
            (72, 242, 'fj', 679, 'Fiji', '', ''),
            (73, 246, 'fi', 358, 'Finland', '', ''),
            (74, 248, 'ax', 358, '?land Islands', '', ''),
            (75, 250, 'fr', 33, 'France', '', ''),
            (76, 254, 'gf', 594, 'French Guiana', '', ''),
            (77, 258, 'pf', 689, 'French Polynesia', '', ''),
            (78, 260, 'tf', 33, 'French Southern and Antarctic Lands', '', ''),
            (79, 262, 'dj', 253, 'Djibouti', '', ''),
            (80, 266, 'ga', 241, 'Gabon', '', ''),
            (81, 268, 'ge', 995, 'Georgia', '', ''),
            (82, 270, 'gm', 220, 'Gambia', '', ''),
            (83, 275, 'ps', 970, 'Palestine', '', ''),
            (84, 276, 'de', 49, 'Germany', '', ''),
            (85, 288, 'gh', 233, 'Ghana', '', ''),
            (86, 292, 'gi', 350, 'Gibraltar', '', ''),
            (87, 296, 'ki', 686, 'Kiribati', '', ''),
            (88, 300, 'gr', 30, 'Greece', '', ''),
            (89, 304, 'gl', 299, 'Greenland', '', ''),
            (90, 308, 'gd', 1, 'Grenada', '', ''),
            (91, 312, 'gp', 590, 'Guadeloupe', '', ''),
            (92, 316, 'gu', 1, 'Guam', '', ''),
            (93, 320, 'gt', 502, 'Guatemala', '', ''),
            (94, 324, 'gn', 224, 'Guinea', '', ''),
            (95, 328, 'gy', 592, 'Guyana', '', ''),
            (96, 332, 'ht', 509, 'Haiti', '', ''),
            (97, 334, 'hm', 61, 'Heard Island and McDonald Islands', '', ''),
            (98, 336, 'va', 39, 'Vatican City', '', ''),
            (99, 340, 'hn', 504, 'Honduras', '', ''),
            (100, 344, 'hk', 852, 'Hong Kong', '', ''),
            (101, 348, 'hu', 36, 'Hungary', '', ''),
            (102, 352, 'is', 354, 'Iceland', '', ''),
            (103, 356, 'in', 91, 'India', '', ''),
            (104, 360, 'id', 62, 'Indonesia', '', ''),
            (105, 364, 'ir', 98, 'Iran', '', ''),
            (106, 368, 'iq', 964, 'Iraq', '', ''),
            (107, 372, 'ie', 353, 'Ireland', '', ''),
            (108, 376, 'il', 972, 'Israel', '', ''),
            (109, 380, 'it', 39, 'Italy', '', ''),
            (110, 384, 'ci', 225, 'Ivory Coast', '', ''),
            (111, 388, 'jm', 1, 'Jamaica', '', ''),
            (112, 392, 'jp', 81, 'Japan', '', ''),
            (113, 398, 'kz', 7, 'Kazakhstan', '', ''),
            (114, 400, 'jo', 962, 'Jordan', '', ''),
            (115, 404, 'ke', 254, 'Kenya', '', ''),
            (116, 408, 'kp', 850, 'North Korea', '', ''),
            (117, 410, 'kr', 82, 'South Korea', '', ''),
            (118, 414, 'kw', 965, 'Kuwait', '', ''),
            (119, 417, 'kg', 996, 'Kyrgyzstan', '', ''),
            (120, 418, 'la', 856, 'Laos', '', ''),
            (121, 422, 'lb', 961, 'Lebanon', '', ''),
            (122, 426, 'ls', 266, 'Lesotho', '', ''),
            (123, 428, 'lv', 371, 'Latvia', '', ''),
            (124, 430, 'lr', 231, 'Liberia', '', ''),
            (125, 434, 'ly', 218, 'Libya', '', ''),
            (126, 438, 'li', 423, 'Liechtenstein', '', ''),
            (127, 440, 'lt', 370, 'Lithuania', '', ''),
            (128, 442, 'lu', 352, 'Luxembourg', '', ''),
            (129, 446, 'mo', 853, 'Macau', '', ''),
            (130, 450, 'mg', 261, 'Madagascar', '', ''),
            (131, 454, 'mw', 265, 'Malawi', '', ''),
            (132, 458, 'my', 60, 'Malaysia', '', ''),
            (133, 462, 'mv', 960, 'Maldives', '', ''),
            (134, 466, 'ml', 223, 'Mali', '', ''),
            (135, 470, 'mt', 356, 'Malta', '', ''),
            (136, 474, 'mq', 596, 'Martinique', '', ''),
            (137, 478, 'mr', 222, 'Mauritania', '', ''),
            (138, 480, 'mu', 230, 'Mauritius', '', ''),
            (139, 484, 'mx', 52, 'Mexico', '', ''),
            (140, 492, 'mc', 377, 'Monaco', '', ''),
            (141, 496, 'mn', 976, 'Mongolia', '', ''),
            (142, 498, 'md', 373, 'Moldova', '', ''),
            (143, 499, 'me', 382, 'Montenegro', '', ''),
            (144, 500, 'ms', 1, 'Montserrat', '', ''),
            (145, 504, 'ma', 212, 'Morocco', '', ''),
            (146, 508, 'mz', 258, 'Mozambique', '', ''),
            (147, 512, 'om', 968, 'Oman', '', ''),
            (148, 516, 'na', 264, 'Namibia', '', ''),
            (149, 520, 'nr', 674, 'Nauru', '', ''),
            (150, 524, 'np', 977, 'Nepal', '', ''),
            (151, 528, 'nl', 31, 'Netherlands', '', ''),
            (152, 531, 'cw', 599, 'Cura?ao', '', ''),
            (153, 533, 'aw', 297, 'Aruba', '', ''),
            (154, 534, 'sx', 1, 'Sint Maarten', '', ''),
            (155, 535, 'bq', 599, 'Caribbean Netherlands', '', ''),
            (156, 540, 'nc', 687, 'New Caledonia', '', ''),
            (157, 548, 'vu', 678, 'Vanuatu', '', ''),
            (158, 554, 'nz', 64, 'New Zealand', '', ''),
            (159, 558, 'ni', 505, 'Nicaragua', '', ''),
            (160, 562, 'ne', 227, 'Niger', '', ''),
            (161, 566, 'ng', 234, 'Nigeria', '', ''),
            (162, 570, 'nu', 683, 'Niue', '', ''),
            (163, 574, 'nf', 672, 'Norfolk Island', '', ''),
            (164, 578, 'no', 47, 'Norway', '', ''),
            (165, 580, 'mp', 1, 'Northern Mariana Islands', '', ''),
            (166, 581, 'um', 1, 'United States Minor Outlying Islands', '', ''),
            (167, 583, 'fm', 691, 'Federated States of Micronesia', '', ''),
            (168, 584, 'mh', 692, 'Marshall Islands', '', ''),
            (169, 585, 'pw', 680, 'Palau', '', ''),
            (170, 586, 'pk', 92, 'Pakistan', '', ''),
            (171, 591, 'pa', 507, 'Panama', '', ''),
            (172, 598, 'pg', 675, 'Papua New Guinea', '', ''),
            (173, 600, 'py', 595, 'Paraguay', '', ''),
            (174, 604, 'pe', 51, 'Peru', '', ''),
            (175, 608, 'ph', 63, 'Philippines', '', ''),
            (176, 612, 'pn', 64, 'Pitcairn Islands', '', ''),
            (177, 616, 'pl', 48, 'Poland', '', ''),
            (178, 620, 'pt', 351, 'Portugal', '', ''),
            (179, 624, 'gw', 245, 'Guinea-Bissau', '', ''),
            (180, 626, 'tl', 670, 'East Timor', '', ''),
            (181, 630, 'pr', 1, 'Puerto Rico', '', ''),
            (182, 634, 'qa', 974, 'Qatar', '', ''),
            (183, 638, 're', 262, 'R?union', '', ''),
            (184, 642, 'ro', 40, 'Romania', '', ''),
            (185, 643, 'ru', 7, 'Russia', 'Россия', 'Росія'),
            (186, 646, 'rw', 250, 'Rwanda', '', ''),
            (187, 652, 'bl', 590, 'Saint Barth?lemy', '', ''),
            (188, 654, 'sh', 290, 'Saint Helena, Ascension and Tristan da Cunha', '', ''),
            (189, 659, 'kn', 1, 'Saint Kitts and Nevis', '', ''),
            (190, 660, 'ai', 1, 'Anguilla', '', ''),
            (191, 662, 'lc', 1, 'Saint Lucia', '', ''),
            (192, 663, 'mf', 590, 'Saint Martin', '', ''),
            (193, 666, 'pm', 508, 'Saint Pierre and Miquelon', '', ''),
            (194, 670, 'vc', 1, 'Saint Vincent and the Grenadines', '', ''),
            (195, 674, 'sm', 378, 'San Marino', '', ''),
            (196, 678, 'st', 239, 'S?o Tom? and Pr?ncipe', '', ''),
            (197, 682, 'sa', 966, 'Saudi Arabia', '', ''),
            (198, 686, 'sn', 221, 'Senegal', '', ''),
            (199, 688, 'rs', 381, 'Serbia', '', ''),
            (200, 690, 'sc', 248, 'Seychelles', '', ''),
            (201, 694, 'sl', 232, 'Sierra Leone', '', ''),
            (202, 702, 'sg', 65, 'Singapore', '', ''),
            (203, 703, 'sk', 421, 'Slovakia', '', ''),
            (204, 704, 'vn', 84, 'Vietnam', '', ''),
            (205, 705, 'si', 386, 'Slovenia', '', ''),
            (206, 706, 'so', 252, 'Somalia', '', ''),
            (207, 710, 'za', 27, 'South Africa', '', ''),
            (208, 716, 'zw', 263, 'Zimbabwe', '', ''),
            (209, 724, 'es', 34, 'Spain', '', ''),
            (210, 728, 'ss', 211, 'South Sudan', '', ''),
            (211, 729, 'sd', 249, 'Sudan', '', ''),
            (212, 732, 'eh', 212, 'Western Sahara', '', ''),
            (213, 740, 'sr', 597, 'Suriname', '', ''),
            (214, 744, 'sj', 47, 'Svalbard and Jan Mayen', '', ''),
            (215, 748, 'sz', 268, 'Swaziland', '', ''),
            (216, 752, 'se', 46, 'Sweden', '', ''),
            (217, 756, 'ch', 41, 'Switzerland', '', ''),
            (218, 760, 'sy', 963, 'Syria', '', ''),
            (219, 762, 'tj', 992, 'Tajikistan', '', ''),
            (220, 764, 'th', 66, 'Thailand', '', ''),
            (221, 768, 'tg', 228, 'Togo', '', ''),
            (222, 772, 'tk', 690, 'Tokelau', '', ''),
            (223, 776, 'to', 676, 'Tonga', '', ''),
            (224, 780, 'tt', 1, 'Trinidad and Tobago', '', ''),
            (225, 784, 'ae', 971, 'United Arab Emirates', '', ''),
            (226, 788, 'tn', 216, 'Tunisia', '', ''),
            (227, 792, 'tr', 90, 'Turkey', '', ''),
            (228, 795, 'tm', 993, 'Turkmenistan', '', ''),
            (229, 796, 'tc', 1, 'Turks and Caicos Islands', '', ''),
            (230, 798, 'tv', 688, 'Tuvalu', '', ''),
            (231, 800, 'ug', 256, 'Uganda', '', ''),
            (232, 804, 'ua', 380, 'Ukraine', 'Украина', 'Україна'),
            (233, 807, 'mk', 389, 'Macedonia', '', ''),
            (234, 818, 'eg', 20, 'Egypt', '', ''),
            (235, 826, 'gb', 44, 'United Kingdom', '', ''),
            (236, 831, 'gg', 44, 'Guernsey', '', ''),
            (237, 832, 'je', 44, 'Jersey', '', ''),
            (238, 833, 'im', 44, 'Isle of Man', '', ''),
            (239, 834, 'tz', 255, 'Tanzania', '', ''),
            (240, 840, 'us', 1, 'United States', '', ''),
            (241, 850, 'vi', 1, 'United States Virgin Islands', '', ''),
            (242, 854, 'bf', 226, 'Burkina Faso', '', ''),
            (243, 858, 'uy', 598, 'Uruguay', '', ''),
            (244, 860, 'uz', 998, 'Uzbekistan', '', ''),
            (245, 862, 've', 58, 'Venezuela', '', ''),
            (246, 876, 'wf', 681, 'Wallis and Futuna', '', ''),
            (247, 882, 'ws', 685, 'Samoa', '', ''),
            (248, 887, 'ye', 967, 'Yemen', '', ''),
            (249, 894, 'zm', 260, 'Zambia', '', '')";
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%country}}');
    }
}
