CREATE TABLE CLIENTE (
ID INT PRIMARY KEY,
NOMBRE VARCHAR (100),
APELLIDO VARCHAR (100),
TELEFONO BIGINT,
TELEFONO_ALT BIGINT,
DIRECCION VARCHAR (254));

CREATE TABLE USUARIO (
ID INT PRIMARY KEY,
NOMBRE VARCHAR(100),
APELLIDO VARCHAR(100),
TELEFONO BIGINT,
DIRECCION VARCHAR (254));

CREATE TABLE GARANTIA (
ID INT PRIMARY KEY,
FECHA DATE,
DURACION INT,
CONCEPTO TEXT,
COSTO VARCHAR(10),
DESCRIPCION TEXT,
IDCLIENTE INT,
IDUSUARIO INT,
CONSTRAINT FKCLIENTEG FOREIGN KEY (IDCLIENTE) REFERENCES CLIENTE(ID),
CONSTRAINT FKUSUARIOG FOREIGN KEY (IDUSUARIO) REFERENCES USUARIO(ID));

CREATE TABLE PRODUCTO (
ID INT PRIMARY KEY,
TIPO VARCHAR (50),
MARCA VARCHAR (100),
MODELO VARCHAR (100),
IDCLIENTE INT,
ANTICIPO VARCHAR(100),
FALLA TEXT,
CONTROL VARCHAR (254),
CABLE BOOLEAN,
OTROS VARCHAR (254),
IDUSUARIO INT,
IDGARANTIA INT,
CONSTRAINT FKCLIENTE FOREIGN KEY (IDCLIENTE) REFERENCES CLIENTE(ID),
CONSTRAINT FKUSUARIO FOREIGN KEY (IDUSUARIO) REFERENCES USUARIO(ID),
SERVICIO VARCHAR(100)
);

INSERT INTO USUARIO VALUES (0, "ALFREDO", "SOLIS", 5611037671, "Mariano Matamoros N.Ext 13 N.Int 4 San José Guadalupe, Toluca, Estado de México"),
(1, "JARED", "SOLIS", 7292641466, "Manuel J. Clouthier. # 46 San Jerónimo Chicahualco, Metepec, Estado de México");

-- Inserts para hacer tes
INSERT INTO CLIENTE (ID, NOMBRE, APELLIDO, DIRECCION, TELEFONO, TELEFONO_ALT) VALUES 
(0, "Diana", "Arrowny Zamora", "Calle falsa 123 #45 Casa 678, Colonia falsa, Municipio 1, Estado #2", 1234567890, 8765432109),
(1, "Paola", "Zambrano", "Calle sin nombre, #34 Lote 45 Estado de Mexico", 4356435643, 7766885544),
(2, "Reimu", "Hakurei", "Santuario Hakurei S/N En Gensokyo, Perfectura Gensokyo, Japón", 2343765879, 2234357683)
INSERT INTO GARANTIA (ID, FECHA, DURACION, CONCEPTO, COSTO, DESCRIPCION, IDCLIENTE, IDUSUARIO) VALUES 
(0, "2021-06-02", 30, "Concepto de prueba 1","100.00", "Descripción de Garantia 1", 0, 0),
(1, "2021-06-02", 30, "Concepto de prueba 2","1500.00", "Descripción de Garantia 2", 0, 0),
(2, "2021-06-02", 60, "Concepto de prueba 3","2000", "Descripción de Garantia 3", 2, 0),
(3, "2021-06-02", 7, "Concepto de prueba 4","50", "Descripción de Garantia 4", 1, 0),
(4, "2021-06-02", 7, "Concepto de prueba 5","50.00", "Descripción de Garantia 5", 2, 0),
(5, "2021-06-02", 60, "Concepto de prueba 6","450", "Descripción de Garantia 6", 0, 0),
(6, "2021-06-02", 30, "Concepto de prueba 7","500", "Descripción de Garantia 7", 2, 0),
(7, "2021-06-02", 7, "Concepto de prueba 8","900", "Descripción de Garantia 8", 1, 0)

INSERT INTO PRODUCTO (ID, TIPO, MARCA, MODELO, IDCLIENTE, ANTICIPO, FALLA, CONTROL, CABLE, OTROS, IDGARANTIA, IDUSUARIO, SERVICIO) VALUES 
(0, "Pantalla", "LG", "HLC-55", 0, "", "falla en la tira de leds", "", 1, "", null, 0, "Servicio 1"),
(1, "Lavadora", "Whirlpool", "", 1, "1500", "Transmisión rota", "", 1, "", null, 0, "Servicio 2"),
(2, "Pantalla", "Atvio", "", 0, "1000", "falla en la tarjeta principal", "Control sin pilas", 0, "", null, 0, "Servicio 3"),
(3, "Pantalla", "Hisense", "KML-60MXC", 2, "Ninguno", "botonera", "Control intacto", 1, "", null, 0, "Servicio 4"),
(4, "Licuadora", "Oster", "HK47", 2, "", "Base barrida", "", 1, "Vaso", null, 0, "Servicio 5"),
(5, "Horno de microondas", "Philips", "", 1, "", "Falla cuatro", "", 1, "Plato y rueda", null, 0, "Servicio 6"),
(6, "Refrigerador", "LG", "", 2, "", "Gas", "", 1, "", null, 0, "Servicio 7"),
(7, "Horno de microondas", "Samsung", "", 0, "", "Falla variada", "", 1, "plato y rueda", null, 0, "Servicio 8")

--ya para producción
INSERT INTO CLIENTE (ID, NOMBRE, APELLIDO, DIRECCION, TELEFONO, TELEFONO_ALT) VALUES 
(0, "José Alfredo", "Ulloa Toledo", "Privada Luis Donaldo Colosio # 4 San José Guadalupe Otzacatipan Toluca México", 7221125931, 0),
(1, "Rocio", "Jimenez Hernández", "Privada 21 de marzo San Mateo Otzacatipan", 7227447338, 0),
(2, "Elvira", "Vilches Guerrero", "Residencial Cantabria", 7224984730, 0),
(3, "Gabriel", "González", "Callejón San Pedro", 7292414827, 0),
(4, "Deposito", "refrescó", "Central de abastos", 7291030074, 0),
(5, "Salud", "Espinoza", "Prol. Laguna del volcán s/n", 7228055348, 0),
(6, "Ericka", "Sánchez", "Privada de Canalejas. Depto. 4", 3312117631, 0),
(7, "Andrés", "Arriaga", "Av. Eucaliptos", 7222450420, 0),
(8, "Gabriel", "", "Santa María Rayón", 7223507359, 0),
(9, "Jorge", "mancilla", "Circuito gaviotas mz. 10 lote 11 -101", 7222641697, 0),
(10, "María Isabel", "Jiménez", "Tacuba s/n. San Juan tilapa", 7221608454, 0),
(11, "Alfredo", "rossano", "Priv. De Jurica sauces 5", 7223049589, 0),
(12, "Eleazar", "López Fernández", "Hacienda santa clara Lerma. Calle uvas #45 lote 15", 5521062841, 0),
(13, "Guadalupe", "Mendoza", "Rancho seco #117 A", 7224076415, 0),
(14, "Valentina", "Pichardo", "Galaxias San Lorenzo", 7291743078, 0),
(15, "Guadalupe", "Mejia", "Camelias 15 metepec", 7221057035, 0),
(16, "María", "de la luz", "Cerrillo vista hermosa", 5550838697, 0),
(17, "Octavio", "garrido", "Taquería cerrillo", 7228459711, 0),
(18, "Orlando", "verdalet", "Fuente de San José #12", 7221399424, 0),
(19, "Esther", "Velázquez", "1er privada 20 de noviembre casa 7", 7223550083, 0),
(20, "Leticia", "Villegas", "Circuito San José # 110", 7224907556, 0),
(21, "Laura", "Noriega", "Hda. Del rocío mz. 25 lote 73-A", 7221697928, 0),
(22, "Blanca", "", "Emiliano Zapata # 194", 7228595125, 0),
(23, "Rene", "", "Servicio en el taller", 5530116695, 0),
(24, "Alonso", "solache", "Alcatraces # 17", 7223975526, 0),
(25, "Norma", "jurado", "Taller", 5543275856, 0),
(26, "Norma", "Aguilera", "Unidad Isidro favela", 7222672547, 0),
(27, "Linda", "Villa", "De Río San Fernando", 7221168447, 0),
(28, "Jesus", "", "Acamaya #30 las marinas Metepec", 5510962298, 0),
(29, "Desiderio", "Vázquez Ortiz", "Juan de la Barrera # 13", 7228962400, 0),
(30, "Celso", "Hernández", "Paso de las misiones y paseo de la evangelización", 5515364533, 0),
(31, "Bolivar", "Domínguez", "Hernández chazaro #806 8 cedros", 7227828280, 0),
(32, "Ana", "Villegas", "Local", 6311891940, 0),
(33, "Cristian", "", "Niños héroes #39 San Pedro Totoltepec", 7221516214, 0),
(34, "Sergio", "Vazquez", "Convento de Valencia #23", 5512867257, 0)

INSERT INTO GARANTIA (ID, FECHA, DURACION, CONCEPTO, COSTO, DESCRIPCION, IDCLIENTE, IDUSUARIO) VALUES 
(0, "2021-05-04", 180, "Válvula de carga y carga de gas refrigerante","1100", "Carga de gas refrigerante. Y fuga en válvula de carga", 0, 0),
(1, "2021-05-03", 180, "Reparación de refrigerador","2500", "Sensor de temperatura freezer y conservación . Tarjeta electrónica solo en el relay de temperatura de área conservación", 1, 0),
(2, "2021-05-05", 180, "Reparación de refrigerador","3500", "Compresor y gas refrigerante Marca: Whirlpool Modelo: WRT16YAWQ", 2, 0),
(3, "2021-05-06", 180, "Reparación de refrigerador","1,000", "Tiene programador. Marca : blue point Modelo: s/n.", 3, 0),
(4, "2021-05-07", 90, "Cambio de compresor en refrigerador comercial","4,000", " Compresor. Toner. Gas refrigerante.", 4, 0),
(5, "2021-05-08", 180, "Reparación de refrigerador","1,500", "Motor ventilador freezer. Timer control.", 5, 0),
(6, "2021-05-08", 180, "Reparación de refrigerador Cambio de freezer","1,500", "Fuga de gas refrigerante", 6, 0),
(7, "2021-05-08", 180, "Reparación de tv. Marca: Philips Modelo: 50PFL3708","2,200", "Regletas LEDs de iluminación", 7, 0),
(8, "2021-05-08", 180, "Reparación de refrigerador Comercial","2,000", "Carga de gas refrigerante. Fugas en tubería", 8, 0),
(9, "2021-05-11", 180, "Reparación de refrigerador Marca : DAEWO modelo: DRF-1130DT","1,600", "Filtro desidratador. Fuga en tubería externa. Gas refrigerante.", 9, 0),
(10, "2021-05-12", 365, "Carga de gas refrigerante","1,200", "Carga de gas refrigerante.", 10, 0),
(11, "2021-05-13", 180, "Reparación de refrigerador Marca :Mabe Modelo twist air","1,200", "Ventilador freezer. Timer control.", 11, 0),
(12, "2021-05-17", 180, "Reparación de refrigerador Marca: Samsung Modelo: RT38K5982SL","2,000", "Filtro desidratador. Fugas en filtro desidratador Y válvula de carga. Gas refrigerante.", 12, 0),
(13, "2021-05-18", 180, "Reparación de refrigerador. Marca.: Daewoo Modelo: DFR- 1180DAT","1,200", "Gas refrigerante.", 13, 0),
(14, "2021-05-18", 180, "Venta Refrigerador Marca :DAEWO Modelo:","2,500", "En todos sus componentes.", 14, 0),
(15, "2021-05-20", 180, "Reparación de refrigerador Cambio de motor ventilador inferior","1,200", "Motor ventilador inferior.", 15, 0),
(16, "2021-05-20", 180, "Reparación de refrigerador Marca : Whirlpool Modelo: 7ED2HTQ","1,500", "Fuga en tubos exteriores Carga de gas refrigerante Válvula de carga.", 16, 0),
(17, "2021-05-21", 180, "Reparación de televisión Marca : HKPRO.mkp55uhd9 Modelo:","2,500", ": 2 regletas LEDs.", 17, 0),
(18, "2021-05-24", 180, "Reparación de tv. Marca LG. Modelo: 32lf580b","1,750", "Trajera principal. 'Main'", 18, 0),
(19, "2021-05-26", 180, "Reparación de refrigerador Marca :Whirlpool Modelo: QWT1020D","950", "'timer' controlador refrigerador.", 19, 0),
(20, "2021-06-01", 180, "Reparación de refrigerador Marca : Samsung Modelo: RF26HFENDSL","1,500", "Sensores de temperatura", 20, 0),
(21, "2021-06-01", 180, "Reparación de Refrigerador Marca :","1,700", "Fugas en tubos externos Y Gas refrigerante", 21, 0),
(22, "2021-06-04", 180, "Reparación de lavadora Marca: Whirlpool Modelo : duet","980", "Bomba de desagüe", 22, 0),
(23, "2021-06-07", 0, "Revisión de tv pantalla Marca LG. Modelo: 55UJ7750","150", "Revision", 23, 0),
(24, "2021-06-08", 180, "Reparación de refrigerador marca : LG Modelo : GM - R619YVP","1,000", "Carga de gas refrigerante", 24, 0),
(25, "2021-06-09", 0, "Revisión de tv. Pantalla Marca Samsung modelo UN49RU7300F","0.0", "Sin garantía solo revisión", 25, 0),
(26, "2021-06-11", 90, "Reparación de tv pantalla Marca : Pioneer Modelo 65 pulgadas","2,500", "Reparación de LED", 26, 0),
(27, "2021-06-16", 90, "Reparación de televisión Marca LG 50'","1,200", "Fallas en la tarjeta del Wifi", 27, 0),
(28, "2021-06-21", 0, "Revisión de tv marca : RCA. modelo: DEDC460M4","150", "Solo revisión", 28, 0),
(29, "2021-06-21", 180, "Reparación de refrigerador Marca : Whirlpool Modelo: WT9507s","1,700", "Fugas externas . Gas refrigerante Timer control", 29, 0),
(30, "2021-06-24", 180, "Reparacion de tv Marca : spectra Modelo : SPT5013","1,800", "LED de iluminación", 30, 0),
(31, "2021-06-24", 180, "Reparacion de Refrigerador Marca : DAEWOO MODELO: DFR1180DAN","1,500", "Fuga en tuberías externas y gas refrigerante", 31, 0),
(32, "2021-06-25", 180, "Reparación de pantalla. Marcá: RCA Modelo: DEDC460M4","2,200", "LEDs. De iluminación", 28, 0),
(33, "2021-06-30", 30, "Reparación del conector Micro-USB de una bocina Link bits modelo RFR-240","100", "El correcto funcionamiento del conector Micro USB durante un periodo de 30 días a partir de esta fecha.", 32, 0),
(34, "2021-07-01", 180, "Reparación de refrigerador","1,600", "Sensor de temperatura freezer Sensor bimetalico Sensor de puerta freezer", 33, 0),
(35, "2021-07-02", 180, "Reparación de refrigerador Marca : Samsung Modelo: RT32FBRHDSL","2,200", "Fugas externas Filtro desidratador Gas refrigerante", 34, 0)

-- Debo añadir una lista negra: entradas por hacerla:
-- (0, "Ana", "Villegas", "", 6311891940, null)
--