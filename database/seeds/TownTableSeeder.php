<?php

use Illuminate\Database\Seeder;

class TownTableSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::statement("INSERT INTO towns
      (id, state_id, description, created_at, updated_at)
      VALUES
      (1, 1, 'Libertador', current_timestamp, current_timestamp),
      (2, 15, 'Baruta', current_timestamp, current_timestamp),
      (3, 15, 'Chacao', current_timestamp, current_timestamp),
      (4, 15, 'Sucre', current_timestamp, current_timestamp),
      (5, 15, 'El Hatillo', current_timestamp, current_timestamp),
      (6, 15, 'Acevedo', current_timestamp, current_timestamp),
      (7, 15, 'Andres Bello', current_timestamp, current_timestamp),
      (8, 15, 'Brion', current_timestamp, current_timestamp),
      (9, 15, 'Buroz', current_timestamp, current_timestamp),
      (10, 15, 'Carrizal', current_timestamp, current_timestamp),
      (11, 15, 'Cristobal Rojas', current_timestamp, current_timestamp),
      (12, 15, 'Guacaipuro', current_timestamp, current_timestamp),
      (13, 15, 'Independencia', current_timestamp, current_timestamp),
      (14, 15, 'Lander', current_timestamp, current_timestamp),
      (15, 15, 'Los Salias', current_timestamp, current_timestamp),
      (16, 15, 'Paez', current_timestamp, current_timestamp),
      (17, 15, 'Paz Castillo', current_timestamp, current_timestamp),
      (18, 15, 'Pedro Gual', current_timestamp, current_timestamp),
      (19, 15, 'Plaza', current_timestamp, current_timestamp),
      (20, 15, 'Simon Bolivar', current_timestamp, current_timestamp),
      (21, 15, 'Urdaneta', current_timestamp, current_timestamp),
      (22, 15, 'Zamora', current_timestamp, current_timestamp),
      (23, 23, 'Vargas', current_timestamp, current_timestamp),
      (24, 12, 'Camaguan', current_timestamp, current_timestamp),
      (25, 12, 'Chaguaramas', current_timestamp, current_timestamp),
      (26, 12, 'El Socorro', current_timestamp, current_timestamp),
      (27, 12, 'Francisco de Miranda', current_timestamp, current_timestamp),
      (28, 12, 'Jose Felix Ribas', current_timestamp, current_timestamp),
      (29, 12, 'Jose Tadeo Monagas', current_timestamp, current_timestamp),
      (30, 12, 'Juan German Roscio', current_timestamp, current_timestamp),
      (31, 12, 'Julian Mellado', current_timestamp, current_timestamp),
      (32, 12, 'Las Mercedes del Llano', current_timestamp, current_timestamp),
      (33, 12, 'Leonardo Infante', current_timestamp, current_timestamp),
      (34, 12, 'Ortiz', current_timestamp, current_timestamp),
      (35, 12, 'Pedro Zaraza', current_timestamp, current_timestamp),
      (36, 12, 'San Geronimo de Guayabal', current_timestamp, current_timestamp),
      (37, 12, 'San Jose de Guaribe', current_timestamp, current_timestamp),
      (38, 12, 'Santa Maria de Ipire', current_timestamp, current_timestamp),
      (39, 5, 'Bolivar', current_timestamp, current_timestamp),
      (41, 5, 'Camatagua', current_timestamp, current_timestamp),
      (42, 5, 'Francisco Linares', current_timestamp, current_timestamp),
      (43, 5, 'Giradot', current_timestamp, current_timestamp),
      (44, 5, 'Jose Angel Lamas', current_timestamp, current_timestamp),
      (45, 5, 'Jose Felix Ribas', current_timestamp, current_timestamp),
      (46, 5, 'Jose Revenga', current_timestamp, current_timestamp),
      (47, 5, 'Libertador', current_timestamp, current_timestamp),
      (48, 5, 'Mario Iragorry', current_timestamp, current_timestamp),
      (49, 5, 'Ocumare de la costa', current_timestamp, current_timestamp),
      (50, 5, 'San Casimiro', current_timestamp, current_timestamp),
      (51, 5, 'San Sebastian', current_timestamp, current_timestamp),
      (52, 5, 'Santiago Mariño', current_timestamp, current_timestamp),
      (53, 5, 'Santos Michelena', current_timestamp, current_timestamp),
      (54, 5, 'Sucre', current_timestamp, current_timestamp),
      (55, 5, 'Tovar', current_timestamp, current_timestamp),
      (56, 5, 'Urdaneta', current_timestamp, current_timestamp),
      (57, 5, 'Zamora', current_timestamp, current_timestamp),
      (58, 8, 'Bejuma', current_timestamp, current_timestamp),
      (59, 8, 'Carlos Arevalo', current_timestamp, current_timestamp),
      (60, 8, 'Diego Ibarra', current_timestamp, current_timestamp),
      (61, 8, 'Guacara', current_timestamp, current_timestamp),
      (62, 8, 'Juan Jose Mora', current_timestamp, current_timestamp),
      (63, 8, 'Libertador', current_timestamp, current_timestamp),
      (64, 8, 'Los Guayos', current_timestamp, current_timestamp),
      (65, 8, 'Miranda', current_timestamp, current_timestamp),
      (66, 8, 'Montalban', current_timestamp, current_timestamp),
      (67, 8, 'Naguanagua', current_timestamp, current_timestamp),
      (68, 8, 'Puerto Cabello', current_timestamp, current_timestamp),
      (69, 8, 'San Diego', current_timestamp, current_timestamp),
      (70, 8, 'San Joaquin', current_timestamp, current_timestamp),
      (71, 8, 'Valencia', current_timestamp, current_timestamp),
      (72, 2, 'Anaco', current_timestamp, current_timestamp),
      (73, 2, 'Aragua', current_timestamp, current_timestamp),
      (74, 2, 'Bolivar', current_timestamp, current_timestamp),
      (75, 2, 'Bruzual', current_timestamp, current_timestamp),
      (76, 2, 'Cajigal', current_timestamp, current_timestamp),
      (77, 2, 'Carvajal', current_timestamp, current_timestamp),
      (78, 2, 'Diego Bautista Urbaneja', current_timestamp, current_timestamp),
      (79, 2, 'Freites', current_timestamp, current_timestamp),
      (80, 2, 'Guanipa', current_timestamp, current_timestamp),
      (81, 2, 'Guanta', current_timestamp, current_timestamp),
      (82, 2, 'Independencia', current_timestamp, current_timestamp),
      (83, 2, 'Libertad', current_timestamp, current_timestamp),
      (84, 2, 'Mcgregor', current_timestamp, current_timestamp),
      (85, 2, 'Miranda', current_timestamp, current_timestamp),
      (86, 2, 'Monagas', current_timestamp, current_timestamp),
      (87, 2, 'Peñalver', current_timestamp, current_timestamp),
      (88, 2, 'Piritu', current_timestamp, current_timestamp),
      (89, 2, 'San Juan de Capistrano', current_timestamp, current_timestamp),
      (90, 2, 'Santa Ana', current_timestamp, current_timestamp),
      (91, 2, 'Simón Rodriguez', current_timestamp, current_timestamp),
      (92, 2, 'Sotillo', current_timestamp, current_timestamp),
      (93, 3, 'Alto Orinoco', current_timestamp, current_timestamp),
      (94, 3, 'Atabapo', current_timestamp, current_timestamp),
      (95, 3, 'Atures', current_timestamp, current_timestamp),
      (96, 3, 'Autana', current_timestamp, current_timestamp),
      (97, 3, 'Manapiare', current_timestamp, current_timestamp),
      (98, 3, 'Maroa', current_timestamp, current_timestamp),
      (99, 3, 'Rio Negro', current_timestamp, current_timestamp),
      (100, 4, 'Achaguas', current_timestamp, current_timestamp),
      (101, 4, 'Biruaca', current_timestamp, current_timestamp),
      (102, 4, 'Muños', current_timestamp, current_timestamp),
      (103, 4, 'Paez', current_timestamp, current_timestamp),
      (104, 4, 'Pedro Camejo', current_timestamp, current_timestamp),
      (105, 4, 'Romulo Gallegos', current_timestamp, current_timestamp),
      (106, 4, 'San Fernando', current_timestamp, current_timestamp),
      (107, 6, 'Alberto Arvelo Torrealba', current_timestamp, current_timestamp),
      (108, 6, 'Andrés Eloy Blanco', current_timestamp, current_timestamp),
      (109, 6, 'Antonio José de Sucre', current_timestamp, current_timestamp),
      (110, 6, 'Arismendi', current_timestamp, current_timestamp),
      (111, 6, 'Barinas', current_timestamp, current_timestamp),
      (112, 6, 'Bolívar', current_timestamp, current_timestamp),
      (113, 6, 'Cruz Paredes', current_timestamp, current_timestamp),
      (114, 6, 'Ezequiel Zamora', current_timestamp, current_timestamp),
      (115, 6, 'Obispos', current_timestamp, current_timestamp),
      (116, 6, 'Pedraza', current_timestamp, current_timestamp),
      (117, 6, 'Rojas', current_timestamp, current_timestamp),
      (118, 6, 'Sosa', current_timestamp, current_timestamp),
      (119, 7, 'Caroní', current_timestamp, current_timestamp),
      (120, 7, 'Cedeño', current_timestamp, current_timestamp),
      (121, 7, 'El Callao', current_timestamp, current_timestamp),
      (122, 7, 'Gran Sabana', current_timestamp, current_timestamp),
      (123, 7, 'Heres', current_timestamp, current_timestamp),
      (124, 7, 'Piar', current_timestamp, current_timestamp),
      (125, 7, 'Raul Leoni', current_timestamp, current_timestamp),
      (126, 7, 'Roscio', current_timestamp, current_timestamp),
      (127, 7, 'Sifontes', current_timestamp, current_timestamp),
      (128, 7, 'Sucre', current_timestamp, current_timestamp),
      (129, 7, 'Padre Pedro Chen', current_timestamp, current_timestamp),
      (130, 9, 'Anzoategui', current_timestamp, current_timestamp),
      (131, 9, 'Falcon', current_timestamp, current_timestamp),
      (132, 9, 'Giraldot', current_timestamp, current_timestamp),
      (133, 9, 'Lima Blanco', current_timestamp, current_timestamp),
      (134, 9, 'Pao de San Juan Bautista', current_timestamp, current_timestamp),
      (135, 9, 'Ricaurte', current_timestamp, current_timestamp),
      (136, 9, 'Rómulo Gallegos', current_timestamp, current_timestamp),
      (137, 9, 'San Carlos', current_timestamp, current_timestamp),
      (138, 9, 'Tinaco', current_timestamp, current_timestamp),
      (139, 10, 'Antonio Díaz', current_timestamp, current_timestamp),
      (140, 10, 'Casacoima', current_timestamp, current_timestamp),
      (141, 10, 'Pedernales', current_timestamp, current_timestamp),
      (142, 10, 'Tucupita', current_timestamp, current_timestamp),
      (143, 11, 'Acosta', current_timestamp, current_timestamp),
      (144, 11, 'Bolívar', current_timestamp, current_timestamp),
      (145, 11, 'Buchivacoa', current_timestamp, current_timestamp),
      (146, 11, 'Cacique Manaure', current_timestamp, current_timestamp),
      (147, 11, 'Carirubana', current_timestamp, current_timestamp),
      (148, 11, 'Colina', current_timestamp, current_timestamp),
      (149, 11, 'Dabajuro', current_timestamp, current_timestamp),
      (150, 11, 'Democracia', current_timestamp, current_timestamp),
      (151, 11, 'Falcón', current_timestamp, current_timestamp),
      (152, 11, 'Federacion', current_timestamp, current_timestamp),
      (153, 11, 'Jacura', current_timestamp, current_timestamp),
      (154, 11, 'Los Taques', current_timestamp, current_timestamp),
      (155, 11, 'Mauroa', current_timestamp, current_timestamp),
      (156, 11, 'Miranda', current_timestamp, current_timestamp),
      (157, 11, 'Monseñor Iturriza', current_timestamp, current_timestamp),
      (158, 11, 'Palmasola', current_timestamp, current_timestamp),
      (159, 11, 'Petit', current_timestamp, current_timestamp),
      (160, 11, 'Piritu', current_timestamp, current_timestamp),
      (161, 11, 'San Francisco', current_timestamp, current_timestamp),
      (162, 11, 'Silva', current_timestamp, current_timestamp),
      (163, 11, 'Sucre', current_timestamp, current_timestamp),
      (164, 11, 'Tocopero', current_timestamp, current_timestamp),
      (165, 11, 'Union', current_timestamp, current_timestamp),
      (166, 11, 'Urumaco', current_timestamp, current_timestamp),
      (167, 11, 'Zamora', current_timestamp, current_timestamp),
      (168, 13, 'Andrés Eloy Blanco', current_timestamp, current_timestamp),
      (169, 13, 'Crespo', current_timestamp, current_timestamp),
      (170, 13, 'Iribarren', current_timestamp, current_timestamp),
      (171, 13, 'Jiménez', current_timestamp, current_timestamp),
      (172, 13, 'Morán', current_timestamp, current_timestamp),
      (173, 13, 'Palavecino', current_timestamp, current_timestamp),
      (174, 13, 'Simón Planas', current_timestamp, current_timestamp),
      (175, 13, 'Torres', current_timestamp, current_timestamp),
      (176, 13, 'Urdaneta', current_timestamp, current_timestamp),
      (177, 14, 'Alberto Adriani', current_timestamp, current_timestamp),
      (178, 14, 'Andrés Bello ', current_timestamp, current_timestamp),
      (179, 14, 'Antonio Pinto Salinas ', current_timestamp, current_timestamp),
      (180, 14, 'Acarigua', current_timestamp, current_timestamp),
      (181, 14, 'Arzobispo Chacón', current_timestamp, current_timestamp),
      (182, 14, 'Campo Elías', current_timestamp, current_timestamp),
      (183, 14, 'Caracciolo Parra Olmedo ', current_timestamp, current_timestamp),
      (184, 14, 'Cardenal Quintero', current_timestamp, current_timestamp),
      (185, 14, 'Guaraque', current_timestamp, current_timestamp),
      (186, 14, 'Julio César Salas ', current_timestamp, current_timestamp),
      (187, 14, 'Justo Briceño', current_timestamp, current_timestamp),
      (188, 14, 'Libertador', current_timestamp, current_timestamp),
      (189, 14, 'Miranda', current_timestamp, current_timestamp),
      (190, 14, 'Obispo Ramos de Lora ', current_timestamp, current_timestamp),
      (191, 14, 'Padre Norega', current_timestamp, current_timestamp),
      (192, 14, 'Pueblo Llano', current_timestamp, current_timestamp),
      (193, 14, 'Rangel', current_timestamp, current_timestamp),
      (194, 14, 'Rivas Dávila', current_timestamp, current_timestamp),
      (195, 14, 'Santos Marquina', current_timestamp, current_timestamp),
      (196, 14, 'Sucre', current_timestamp, current_timestamp),
      (197, 14, 'Tovar', current_timestamp, current_timestamp),
      (198, 14, 'Tulio Febres Cordero', current_timestamp, current_timestamp),
      (199, 14, 'Zea', current_timestamp, current_timestamp),
      (200, 16, 'Acosta', current_timestamp, current_timestamp),
      (201, 16, 'Aguasay', current_timestamp, current_timestamp),
      (202, 16, 'Bolívar', current_timestamp, current_timestamp),
      (203, 16, 'Caripe', current_timestamp, current_timestamp),
      (204, 16, 'Cedeño', current_timestamp, current_timestamp),
      (205, 16, 'Ezequiel Zamora', current_timestamp, current_timestamp),
      (206, 16, 'Libertador', current_timestamp, current_timestamp),
      (207, 16, 'Maturín', current_timestamp, current_timestamp),
      (208, 16, 'Piar', current_timestamp, current_timestamp),
      (209, 16, 'Punceres', current_timestamp, current_timestamp),
      (210, 16, 'Santa Bárbara', current_timestamp, current_timestamp),
      (211, 16, 'Sotillo', current_timestamp, current_timestamp),
      (212, 16, 'Uracoa', current_timestamp, current_timestamp),
      (213, 17, 'Antolín del Campo', current_timestamp, current_timestamp),
      (214, 17, 'Arismendi', current_timestamp, current_timestamp),
      (215, 17, 'Díaz', current_timestamp, current_timestamp),
      (216, 17, 'García', current_timestamp, current_timestamp),
      (217, 17, 'Gómez', current_timestamp, current_timestamp),
      (218, 17, 'Maneiro', current_timestamp, current_timestamp),
      (219, 17, 'Marcano', current_timestamp, current_timestamp),
      (220, 17, 'Mariño', current_timestamp, current_timestamp),
      (221, 17, 'Península de Macanao', current_timestamp, current_timestamp),
      (222, 17, 'Tubores', current_timestamp, current_timestamp),
      (223, 17, 'Villalba', current_timestamp, current_timestamp),
      (224, 18, 'Agua Blanca', current_timestamp, current_timestamp),
      (225, 18, 'Araure', current_timestamp, current_timestamp),
      (226, 18, 'Esteller', current_timestamp, current_timestamp),
      (227, 18, 'Guanare', current_timestamp, current_timestamp),
      (228, 18, 'Guanarito', current_timestamp, current_timestamp),
      (229, 18, 'Monseñor José Vicenti de Unda', current_timestamp, current_timestamp),
      (230, 18, 'Ospino', current_timestamp, current_timestamp),
      (231, 18, 'Páez', current_timestamp, current_timestamp),
      (232, 18, 'Papelón', current_timestamp, current_timestamp),
      (233, 18, 'San Genaro de Boconoíto', current_timestamp, current_timestamp),
      (234, 18, 'San Rafael de Onoto', current_timestamp, current_timestamp),
      (235, 18, 'Santa Rosalía', current_timestamp, current_timestamp),
      (236, 18, 'Sucre', current_timestamp, current_timestamp),
      (237, 18, 'Turén', current_timestamp, current_timestamp),
      (238, 19, 'Andrés Eloy Blanco19', current_timestamp, current_timestamp),
      (239, 19, 'Andrés Mata', current_timestamp, current_timestamp),
      (240, 19, 'Arismendi', current_timestamp, current_timestamp),
      (241, 19, 'Benítez', current_timestamp, current_timestamp),
      (242, 19, 'Beremúdez', current_timestamp, current_timestamp),
      (243, 19, 'Bolívar', current_timestamp, current_timestamp),
      (244, 19, 'Cagigal', current_timestamp, current_timestamp),
      (245, 19, 'Cruz Salmerón Acosta', current_timestamp, current_timestamp),
      (246, 19, 'Libertador', current_timestamp, current_timestamp),
      (247, 19, 'Mariño', current_timestamp, current_timestamp),
      (248, 19, 'Mejía', current_timestamp, current_timestamp),
      (249, 19, 'Montes', current_timestamp, current_timestamp),
      (250, 19, 'Ribero', current_timestamp, current_timestamp),
      (251, 19, 'Sucre', current_timestamp, current_timestamp),
      (252, 19, 'Valdez', current_timestamp, current_timestamp),
      (253, 20, 'Andrés Bello', current_timestamp, current_timestamp),
      (254, 20, 'Antonio Rómulo Costa', current_timestamp, current_timestamp),
      (255, 20, 'Ayacucho', current_timestamp, current_timestamp),
      (256, 20, 'Bolívar', current_timestamp, current_timestamp),
      (257, 20, 'Cárdenas', current_timestamp, current_timestamp),
      (258, 20, 'Córdova', current_timestamp, current_timestamp),
      (259, 20, 'Fernández Feo', current_timestamp, current_timestamp),
      (260, 20, 'Francisco de Miranda', current_timestamp, current_timestamp),
      (261, 20, 'García de Hevia', current_timestamp, current_timestamp),
      (262, 20, 'Guásimos', current_timestamp, current_timestamp),
      (263, 20, 'Independencia', current_timestamp, current_timestamp),
      (264, 20, 'Jáuregui', current_timestamp, current_timestamp),
      (265, 20, 'José María Vargas', current_timestamp, current_timestamp),
      (266, 20, 'Junín', current_timestamp, current_timestamp),
      (267, 20, 'Libertad', current_timestamp, current_timestamp),
      (268, 20, 'Libertador', current_timestamp, current_timestamp),
      (269, 20, 'Lobatera', current_timestamp, current_timestamp),
      (270, 20, 'Michelena', current_timestamp, current_timestamp),
      (271, 20, 'Panamericano', current_timestamp, current_timestamp),
      (272, 20, 'Pedro María Ureña', current_timestamp, current_timestamp),
      (273, 20, 'Rafael Urdaneta', current_timestamp, current_timestamp),
      (274, 20, 'Samuel Darío Maldonado', current_timestamp, current_timestamp),
      (275, 20, 'San Cristóbal', current_timestamp, current_timestamp),
      (276, 20, 'Seboruco', current_timestamp, current_timestamp),
      (277, 20, 'Simón Rodríguez', current_timestamp, current_timestamp),
      (278, 20, 'Sucre', current_timestamp, current_timestamp),
      (279, 20, 'Torbes', current_timestamp, current_timestamp),
      (280, 20, 'Uribante', current_timestamp, current_timestamp),
      (281, 20, 'San Judas Tadeo', current_timestamp, current_timestamp),
      (282, 21, 'Andrés Bello', current_timestamp, current_timestamp),
      (283, 21, 'Boconó', current_timestamp, current_timestamp),
      (284, 21, 'Bolívar', current_timestamp, current_timestamp),
      (285, 21, 'Candelaria', current_timestamp, current_timestamp),
      (286, 21, 'Carache', current_timestamp, current_timestamp),
      (287, 21, 'Escuque', current_timestamp, current_timestamp),
      (288, 21, 'José Felipe Márquez Cañizalez', current_timestamp, current_timestamp),
      (289, 21, 'Juan Vicente Campos Elías', current_timestamp, current_timestamp),
      (290, 21, 'La Ceiba', current_timestamp, current_timestamp),
      (291, 21, 'Miranda', current_timestamp, current_timestamp),
      (292, 21, 'Monte Carmelo', current_timestamp, current_timestamp),
      (293, 21, 'Motatán', current_timestamp, current_timestamp),
      (294, 21, 'Pampán', current_timestamp, current_timestamp),
      (295, 21, 'Pampanito', current_timestamp, current_timestamp),
      (296, 21, 'Rafael Rangel', current_timestamp, current_timestamp),
      (297, 21, 'San Rafael de Carvajal', current_timestamp, current_timestamp),
      (298, 21, 'Sucre', current_timestamp, current_timestamp),
      (299, 21, 'Trujillo', current_timestamp, current_timestamp),
      (300, 21, 'Urdaneta', current_timestamp, current_timestamp),
      (301, 21, 'Valera', current_timestamp, current_timestamp),
      (302, 22, 'Veroes', current_timestamp, current_timestamp),
      (303, 22, 'Arístides Bastidas', current_timestamp, current_timestamp),
      (304, 22, 'Bolívar', current_timestamp, current_timestamp),
      (305, 22, 'Bruzal', current_timestamp, current_timestamp),
      (306, 22, 'Cocorote', current_timestamp, current_timestamp),
      (307, 22, 'Independencia', current_timestamp, current_timestamp),
      (308, 22, 'José Antonio Páez', current_timestamp, current_timestamp),
      (309, 22, 'La Trinidad', current_timestamp, current_timestamp),
      (310, 22, 'Manuel Monge', current_timestamp, current_timestamp),
      (311, 22, 'Nirgua', current_timestamp, current_timestamp),
      (312, 22, 'Peña', current_timestamp, current_timestamp),
      (313, 22, 'San Felipe', current_timestamp, current_timestamp),
      (314, 22, 'Sucre', current_timestamp, current_timestamp),
      (315, 22, 'Urachiche', current_timestamp, current_timestamp),
      (316, 24, 'Almirante Padilla', current_timestamp, current_timestamp),
      (317, 24, 'Baralt', current_timestamp, current_timestamp),
      (318, 24, 'Cabimas', current_timestamp, current_timestamp),
      (319, 24, 'Catatumbo', current_timestamp, current_timestamp),
      (320, 24, 'Colón', current_timestamp, current_timestamp),
      (321, 24, 'Francisco Javier Pulgar', current_timestamp, current_timestamp),
      (322, 24, 'Jesús Enrique Losada', current_timestamp, current_timestamp),
      (323, 24, 'La Cañada de Urdaneta', current_timestamp, current_timestamp),
      (324, 24, 'Lagunillas', current_timestamp, current_timestamp),
      (325, 24, 'Machiques de Perijá', current_timestamp, current_timestamp),
      (326, 24, 'Mara', current_timestamp, current_timestamp),
      (327, 24, 'Maracaibo', current_timestamp, current_timestamp),
      (328, 24, 'Miranda', current_timestamp, current_timestamp),
      (329, 24, 'Páez', current_timestamp, current_timestamp),
      (330, 24, 'Rosario de Perijá', current_timestamp, current_timestamp),
      (331, 24, 'San Francisco', current_timestamp, current_timestamp),
      (332, 24, 'Santa Rita', current_timestamp, current_timestamp),
      (333, 24, 'Simón Bolívar', current_timestamp, current_timestamp),
      (334, 24, 'Sucre', current_timestamp, current_timestamp),
      (335, 24, 'Valmore Rodríguez', current_timestamp, current_timestamp),
      (336, 24, 'Jesús María Semprún', current_timestamp, current_timestamp);");

    $this->command->info('Los municipios de venezuela fueron creados por el elegido.');
  }

}
