-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-06-2025 a las 13:45:43
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bienestarpolicial`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salud_mentales`
--

CREATE TABLE `salud_mentales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F70', 'DISCAPACIDAD INTELECTUAL LEVE', 'discapacidad intelectual leve');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F71', 'DISCAPACIDAD INTELECTUAL MODERADA', 'discapacidad intelectual moderada');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F72', 'DISCAPACIDAD INTELECTUAL GRAVE', 'discapacidad intelectual grave');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F73', 'DISCAPACIDAD INTELECTUAL PROFUNDA', 'discapacidad intelectual profunda');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F88', 'RETRASO GENERAL DEL DESARROLLO', 'retraso general del desarrollo');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F79', 'DISCAPACIDAD INTELECTUAL NO ESPECIFICADA', 'discapacidad intelectual no especificada');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F80.2', 'TRASTORNO DEL LENGUAJE', 'trastorno del lenguaje');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F80.0', 'TRASTORNO FONOLGICO', 'trastorno fonolgico');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F80.81', 'TRASTORNO DE FLUIDEZ DE INICIO EN LA INFANCIA', 'trastorno de fluidez de inicio en la infancia');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F84.0', 'TRASTORNO DEL ESPECTRO DEL AUTISMO', 'trastorno del espectro del autismo');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F90.2', 'TDAH    PRESENTACIÓN COMBINADA', 'tdah    presentación combinada');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F90.0', 'TDAH    PRESENTACIÓN CON FALTA DE ATENCIN', 'tdah    presentación con falta de atencin');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F90.1', 'TDAH    PRESENTACIÓN HIPERACTIVAIMPULSIVA', 'tdah    presentación hiperactivaimpulsiva');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F81.0', 'TRASTORNO ESPECFICO DEL APRENDIZAJE CON DIFICULTAD EN LA LECTURA', 'trastorno especfico del aprendizaje con dificultad en la lectura');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F81.81', 'TRASTORNO ESPECFICO DEL APRENDIZAJE CON DIFICULTAD EN LA EXPRESIN ESCRITA', 'trastorno especfico del aprendizaje con dificultad en la expresin escrita');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F81.2', 'TRASTORNO ESPECFICO DEL APRENDIZAJE CON DIFICULTAD MATEMTICA', 'trastorno especfico del aprendizaje con dificultad matemtica');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F80.0', 'TRASTORNO FONOLOGICO', 'trastorno fonologico');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F80.81', 'TRASTORNO DE FLUIDEZ DE INICIO EN LA INFANCIA', 'trastorno de fluidez de inicio en la infancia');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F80.89', 'TRASTORNO DE LA COMUNICACION SOCIAL PRAGMATICO', 'trastorno de la comunicacion social pragmatico');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F80.9', 'TRASTORNO DE LA COMUNICACION NO ESPECIFICADO', 'trastorno de la comunicacion no especificado');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F84.0', 'TRASTORNO DEL ESPECTRO DEL AUTISMO', 'trastorno del espectro del autismo');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F90.2', 'TDAH PRESENTACION COMBINADA', 'tdah presentacion combinada');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F90.0', 'TDAH PRESENTACION CON FALTA DE ATENCION', 'tdah presentacion con falta de atencion');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F90.1', 'TDAH PRESENTACION HIPERACTIVA IMPULSIVA', 'tdah presentacion hiperactiva impulsiva');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F81.0', 'TRASTORNO ESPECIFICO DEL APRENDIZAJE CON DIFICULTAD EN LA LECTURA', 'trastorno especifico del aprendizaje con dificultad en la lectura');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F81.81', 'TRASTORNO ESPECIFICO DEL APRENDIZAJE CON DIFICULTAD EN LA EXPRESION ESCRITA', 'trastorno especifico del aprendizaje con dificultad en la expresion escrita');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F81.2', 'TRASTORNO ESPECIFICO DEL APRENDIZAJE CON DIFICULTAD MATEMATICA', 'trastorno especifico del aprendizaje con dificultad matematica');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F82', 'TRASTORNO DEL DESARROLLO DE LA COORDINACION', 'trastorno del desarrollo de la coordinacion');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F98.4', 'TRASTORNO DE MOVIMIENTOS ESTEREOTIPADOS', 'trastorno de movimientos estereotipados');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F95.2', 'TRASTORNO DE LA TOURETTE', 'trastorno de la tourette');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F95.1', 'TRASTORNO DE TICS MOTORES O VOCALES PERSISTENTE', 'trastorno de tics motores o vocales persistente');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F95.0', 'TRASTORNO DE TICS TRANSITORIO', 'trastorno de tics transitorio');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F95.8', 'OTRO TRASTORNO DE TICS ESPECIFICADO', 'otro trastorno de tics especificado');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F95.9', 'TRASTORNO DE TICS NO ESPECIFICADO', 'trastorno de tics no especificado');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F88', 'OTRO TRASTORNO DEL DESARROLLO NEUROLOGICO ESPECIFICADO', 'otro trastorno del desarrollo neurologico especificado');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F89', 'TRASTORNO DEL DESARROLLO NEUROLOGICO NO ESPECIFICADO', 'trastorno del desarrollo neurologico no especificado');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F20.9', 'ESQUIZOFRENIA NO ESPECIFICADA', 'esquizofrenia no especificada');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F25.1', 'TRASTORNO ESQUIZOAFECTIVO TIPO DEPRESIVO', 'trastorno esquizoafectivo tipo depresivo');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F25.0', 'TRASTORNO ESQUIZOAFECTIVO TIPO MANIACO', 'trastorno esquizoafectivo tipo maniaco');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F25.2', 'TRASTORNO ESQUIZOAFECTIVO TIPO MIXTO', 'trastorno esquizoafectivo tipo mixto');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F25.8', 'OTRO TRASTORNO ESQUIZOAFECTIVO ESPECIFICADO', 'otro trastorno esquizoafectivo especificado');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F32.0', 'EPISODIO DEPRESIVO LEVE', 'episodio depresivo leve');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F32.1', 'EPISODIO DEPRESIVO MODERADO', 'episodio depresivo moderado');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F32.2', 'EPISODIO DEPRESIVO GRAVE SIN SINTOMAS PSICOTICOS', 'episodio depresivo grave sin sintomas psicoticos');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F32.3', 'EPISODIO DEPRESIVO GRAVE CON SINTOMAS PSICOTICOS', 'episodio depresivo grave con sintomas psicoticos');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F33.0', 'TRASTORNO DEPRESIVO RECURRENTE EPISODIO ACTUAL LEVE', 'trastorno depresivo recurrente episodio actual leve');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F33.1', 'TRASTORNO DEPRESIVO RECURRENTE EPISODIO ACTUAL MODERADO', 'trastorno depresivo recurrente episodio actual moderado');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F33.2', 'TRASTORNO DEPRESIVO RECURRENTE EPISODIO ACTUAL GRAVE SIN SINTOMAS PSICOTICOS', 'trastorno depresivo recurrente episodio actual grave sin sintomas psicoticos');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F33.3', 'TRASTORNO DEPRESIVO RECURRENTE EPISODIO ACTUAL GRAVE CON SINTOMAS PSICOTICOS', 'trastorno depresivo recurrente episodio actual grave con sintomas psicoticos');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F34.1', 'DISTIMIA', 'distimia');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F31.1', 'TRASTORNO BIPOLAR EPISODIO ACTUAL HIPOMANIACO', 'trastorno bipolar episodio actual hipomaniaco');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F31.2', 'TRASTORNO BIPOLAR EPISODIO ACTUAL MANIACO SIN SINTOMAS PSICOTICOS', 'trastorno bipolar episodio actual maniaco sin sintomas psicoticos');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F31.3', 'TRASTORNO BIPOLAR EPISODIO ACTUAL MANIACO CON SINTOMAS PSICOTICOS', 'trastorno bipolar episodio actual maniaco con sintomas psicoticos');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F31.4', 'TRASTORNO BIPOLAR EPISODIO ACTUAL DEPRESIVO LEVE O MODERADO', 'trastorno bipolar episodio actual depresivo leve o moderado');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F31.5', 'TRASTORNO BIPOLAR EPISODIO ACTUAL DEPRESIVO GRAVE SIN SINTOMAS PSICOTICOS', 'trastorno bipolar episodio actual depresivo grave sin sintomas psicoticos');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F31.6', 'TRASTORNO BIPOLAR EPISODIO ACTUAL DEPRESIVO GRAVE CON SINTOMAS PSICOTICOS', 'trastorno bipolar episodio actual depresivo grave con sintomas psicoticos');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F40.00', 'AGORAFOBIA SIN HISTORIAL DE TRASTORNO DE PANICO', 'agorafobia sin historial de trastorno de panico');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F40.01', 'AGORAFOBIA CON TRASTORNO DE PANICO', 'agorafobia con trastorno de panico');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F41.1', 'TRASTORNO DE ANSIEDAD GENERALIZADA', 'trastorno de ansiedad generalizada');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F41.0', 'TRASTORNO DE PANICO', 'trastorno de panico');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F42', 'TRASTORNO OBSESIVO COMPULSIVO', 'trastorno obsesivo compulsivo');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F43.10', 'TRASTORNO DE ESTRES POSTRAUMATICO', 'trastorno de estres postraumatico');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F43.0', 'REACCION AGUDA AL ESTRES', 'reaccion aguda al estres');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F43.21', 'TRASTORNO DE ADAPTACION CON ESTADO DE ANIMO DEPRIMIDO', 'trastorno de adaptacion con estado de animo deprimido');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F43.23', 'TRASTORNO DE ADAPTACION CON ANSIEDAD', 'trastorno de adaptacion con ansiedad');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F43.25', 'TRASTORNO DE ADAPTACION MIXTO CON ANSIEDAD Y ESTADO DE ANIMO DEPRIMIDO', 'trastorno de adaptacion mixto con ansiedad y estado de animo deprimido');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F50.0', 'ANOREXIA NERVIOSA', 'anorexia nerviosa');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F50.2', 'BULIMIA NERVIOSA', 'bulimia nerviosa');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F50.8', 'TRASTORNO POR ATRACONES', 'trastorno por atracones');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F98.3', 'ENURESIS NO DEBIDO A UNA CONDICION MEDICA', 'enuresis no debido a una condicion medica');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F98.1', 'ENCOPRESIS NO DEBIDO A UNA CONDICION MEDICA', 'encopresis no debido a una condicion medica');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F93.0', 'TRASTORNO DE ANSIEDAD POR SEPARACION', 'trastorno de ansiedad por separacion');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F94.0', 'MUTISMO SELECTIVO', 'mutismo selectivo');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F91.3', 'TRASTORNO NEGATIVISTA DESAFIANTE', 'trastorno negativista desafiante');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F91.1', 'TRASTORNO EXPLOSIVO INTERMITENTE', 'trastorno explosivo intermitente');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F91.9', 'TRASTORNO DE LA CONDUCTA NO ESPECIFICADO', 'trastorno de la conducta no especificado');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F60.3', 'TRASTORNO LIMITE DE LA PERSONALIDAD', 'trastorno limite de la personalidad');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F60.4', 'TRASTORNO HISTRIONICO DE LA PERSONALIDAD', 'trastorno histrionico de la personalidad');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F60.81', 'TRASTORNO NARCISISTA DE LA PERSONALIDAD', 'trastorno narcisista de la personalidad');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F60.2', 'TRASTORNO ANTISOCIAL DE LA PERSONALIDAD', 'trastorno antisocial de la personalidad');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F60.6', 'TRASTORNO EVITATIVO DE LA PERSONALIDAD', 'trastorno evitativo de la personalidad');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F60.7', 'TRASTORNO DEPENDIENTE DE LA PERSONALIDAD', 'trastorno dependiente de la personalidad');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F60.5', 'TRASTORNO OBSESIVO COMPULSIVO DE LA PERSONALIDAD', 'trastorno obsesivo compulsivo de la personalidad');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F60.0', 'TRASTORNO PARANOIDE DE LA PERSONALIDAD', 'trastorno paranoide de la personalidad');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F60.1', 'TRASTORNO ESQUIZOIDE DE LA PERSONALIDAD', 'trastorno esquizoide de la personalidad');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F60.8', 'OTRO TRASTORNO ESPECIFICO DE LA PERSONALIDAD', 'otro trastorno especifico de la personalidad');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F60.9', 'TRASTORNO DE LA PERSONALIDAD NO ESPECIFICADO', 'trastorno de la personalidad no especificado');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F68.10', 'TRASTORNO FACTICIO IMPUESTO A UNO MISMO', 'trastorno facticio impuesto a uno mismo');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F68.11', 'TRASTORNO FACTICIO IMPUESTO A OTRO', 'trastorno facticio impuesto a otro');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F54', 'SINTOMAS SOMATICOS RELACIONADOS CON FACTORES PSICOLOGICOS', 'sintomas somaticos relacionados con factores psicologicos');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F45.1', 'TRASTORNO DE ANSIEDAD POR ENFERMEDAD', 'trastorno de ansiedad por enfermedad');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F45.22', 'TRASTORNO DE SINTOMAS SOMATICOS PERSISTENTE', 'trastorno de sintomas somaticos persistente');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F06.4', 'TRASTORNO DE ANSIEDAD DEBIDO A OTRA AFECCION MEDICA', 'trastorno de ansiedad debido a otra afeccion medica');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F19.10', 'TRASTORNO POR CONSUMO DE SUSTANCIAS MULTIPLES', 'trastorno por consumo de sustancias multiples');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F17.20', 'TRASTORNO POR CONSUMO DE TABACO', 'trastorno por consumo de tabaco');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F55', 'USO DE OTRAS SUSTANCIAS SIN DEPENDENCIA', 'uso de otras sustancias sin dependencia');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F63.0', 'JUEGO PATOLOGICO', 'juego patologico');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F63.1', 'CLEPTOMANIA', 'cleptomania');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F63.2', 'PIROMANIA', 'piromania');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F64.1', 'TRASTORNO DE IDENTIDAD DE GENERO EN LA ADOLESCENCIA O ADULTEZ', 'trastorno de identidad de genero en la adolescencia o adultez');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F65.4', 'VOYEURISMO', 'voyeurismo');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F65.2', 'EXHIBICIONISMO', 'exhibicionismo');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F65.3', 'FROTTEURISMO', 'frotteurismo');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F65.0', 'PEDOFILIA', 'pedofilia');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F65.1', 'MASOQUISMO SEXUAL', 'masoquismo sexual');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F65.5', 'OTRO TRASTORNO PARAFILICO ESPECIFICADO', 'otro trastorno parafilico especificado');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F65.9', 'TRASTORNO PARAFILICO NO ESPECIFICADO', 'trastorno parafilico no especificado');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F98.5', 'TARTAMUDEO DE INICIO EN LA INFANCIA', 'tartamudeo de inicio en la infancia');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F98.6', 'TRASTORNO DE TICS NO ESPECIFICADO', 'trastorno de tics no especificado');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F99', 'TRASTORNO MENTAL NO ESPECIFICADO', 'trastorno mental no especificado');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F07.0', 'TRASTORNO ORGANICO DE LA PERSONALIDAD', 'trastorno organico de la personalidad');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F03', 'DEMENCIA NO ESPECIFICADA', 'demencia no especificada');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F01.9', 'DEMENCIA VASCULAR', 'demencia vascular');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F02.8', 'DEMENCIA EN OTRAS ENFERMEDADES', 'demencia en otras enfermedades');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F04', 'SINDROME AMNESICO ORGANICO', 'sindrome amnesico organico');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F05', 'DELIRIUM NO INDUCIDO POR SUSTANCIAS', 'delirium no inducido por sustancias');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F51.01', 'INSOMNIO DE INICIO', 'insomnio de inicio');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F51.02', 'INSOMNIO DE MANTENIMIENTO', 'insomnio de mantenimiento');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F51.03', 'DESPERTAR TEMPRANO', 'despertar temprano');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F51.04', 'INSOMNIO MIXTO', 'insomnio mixto');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F51.05', 'INSOMNIO NO ESPECIFICADO', 'insomnio no especificado');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F51.3', 'TRASTORNO DEL RITMO CIRCADIANO DEL SUENO', 'trastorno del ritmo circadiano del sueno');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F51.4', 'TERROR NOCTURNO', 'terror nocturno');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F51.5', 'SONAMBULISMO', 'sonambulismo');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F51.8', 'OTRO TRASTORNO DEL SUENO NO ORGANICO', 'otro trastorno del sueno no organico');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F52.0', 'DESEO SEXUAL HIPOACTIVO', 'deseo sexual hipoactivo');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F52.1', 'AVERSION SEXUAL', 'aversion sexual');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F52.2', 'FRACASO DE LA RESPUESTA GENITAL', 'fracaso de la respuesta genital');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F52.3', 'TRASTORNO ORGASMICO', 'trastorno orgasmico');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F52.4', 'EYACULACION PRECOZ', 'eyaculacion precoz');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F52.5', 'VAGINISMO NO ORGANICO', 'vaginismo no organico');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F52.6', 'DISPAREUNIA NO ORGANICA', 'dispareunia no organica');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F52.7', 'OTRO TRASTORNO DE DISFUNCION SEXUAL NO ORGANICA', 'otro trastorno de disfuncion sexual no organica');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F52.8', 'DISFUNCION SEXUAL NO ORGANICA NO ESPECIFICADA', 'disfuncion sexual no organica no especificada');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F06.30', 'TRASTORNO DEL ESTADO DE ANIMO DEBIDO A ENFERMEDAD MEDICA', 'trastorno del estado de animo debido a enfermedad medica');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F06.8', 'TRASTORNO MENTAL ORGANICO ESPECIFICADO', 'trastorno mental organico especificado');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F07.89', 'TRASTORNO NEUROCOGNITIVO LEVE POR OTRA AFECCION', 'trastorno neurocognitivo leve por otra afeccion');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F02.81', 'TRASTORNO NEUROCOGNITIVO MAYOR O LEVE POR TCE', 'trastorno neurocognitivo mayor o leve por tce');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F02.80', 'TRASTORNO NEUROCOGNITIVO MAYOR O LEVE POR VIH', 'trastorno neurocognitivo mayor o leve por vih');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F02.89', 'TRASTORNO NEUROCOGNITIVO MAYOR O LEVE POR HUNTINGTON', 'trastorno neurocognitivo mayor o leve por huntington');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F02.84', 'TRASTORNO NEUROCOGNITIVO MAYOR O LEVE POR PRIONES', 'trastorno neurocognitivo mayor o leve por priones');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F02.82', 'TRASTORNO NEUROCOGNITIVO MAYOR O LEVE POR PARKINSON', 'trastorno neurocognitivo mayor o leve por parkinson');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F02.83', 'TRASTORNO NEUROCOGNITIVO MAYOR O LEVE POR CUERPOS DE LEWY', 'trastorno neurocognitivo mayor o leve por cuerpos de lewy');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F05.1', 'DELIRIUM INDUCIDO POR MEDICACION', 'delirium inducido por medicacion');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F06.0', 'ALUCINACIONES DEBIDAS A OTRA AFECCION MEDICA', 'alucinaciones debidas a otra afeccion medica');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F06.2', 'TRASTORNO CATATONICO DEBIDO A OTRA AFECCION MEDICA', 'trastorno catatonico debido a otra afeccion medica');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F15.10', 'TRASTORNO POR USO DE ESTIMULANTES', 'trastorno por uso de estimulantes');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F12.10', 'TRASTORNO POR USO DE CANNABIS', 'trastorno por uso de cannabis');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F11.10', 'TRASTORNO POR USO DE OPIACEOS', 'trastorno por uso de opiaceos');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F14.10', 'TRASTORNO POR USO DE COCAINA', 'trastorno por uso de cocaina');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F10.20', 'TRASTORNO POR USO DE ALCOHOL MODERADO', 'trastorno por uso de alcohol moderado');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F10.21', 'TRASTORNO POR USO DE ALCOHOL GRAVE', 'trastorno por uso de alcohol grave');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F10.239', 'TRASTORNO DE ABSTINENCIA DE ALCOHOL CON DELIRIUM', 'trastorno de abstinencia de alcohol con delirium');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F13.10', 'TRASTORNO POR USO DE SEDANTES HIPNOTICOS O ANSIOLITICOS', 'trastorno por uso de sedantes hipnoticos o ansioliticos');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F19.20', 'TRASTORNO POR USO DE SUSTANCIAS NO ESPECIFICADAS', 'trastorno por uso de sustancias no especificadas');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F13.232', 'ABSTINENCIA DE ANSIOLITICOS CON ALTERACION PERCEPTIVA', 'abstinencia de ansioliticos con alteracion perceptiva');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F16.10', 'TRASTORNO POR USO DE ALUCINOGENOS', 'trastorno por uso de alucinogenos');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F18.10', 'TRASTORNO POR USO DE INHALANTES', 'trastorno por uso de inhalantes');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F55.0', 'USO DE ESTEROIDES ANABOLICOS SIN TRASTORNO', 'uso de esteroides anabolicos sin trastorno');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F55.1', 'USO DE VITAMINAS SIN INDICACION', 'uso de vitaminas sin indicacion');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F06.1', 'TRASTORNO DELIRANTE DEBIDO A OTRA AFECCION', 'trastorno delirante debido a otra afeccion');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F06.31', 'TRASTORNO DEPRESIVO MAYOR DEBIDO A ENFERMEDAD MEDICA', 'trastorno depresivo mayor debido a enfermedad medica');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F07.8', 'TRASTORNO DE PERSONALIDAD ORGANICO RESIDUAL', 'trastorno de personalidad organico residual');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F99.9', 'CONDICION MENTAL SIN CLASIFICACION DIAGNOSTICA', 'condicion mental sin clasificacion diagnostica');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F15.21', 'INTOXICACION POR ANFETAMINAS CON DELIRIO', 'intoxicacion por anfetaminas con delirio');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F14.221', 'INTOXICACION POR COCAINA CON ALTERACION PERCEPTIVA', 'intoxicacion por cocaina con alteracion perceptiva');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F13.231', 'INTOXICACION POR ANSIOLITICOS SIN DELIRIO', 'intoxicacion por ansioliticos sin delirio');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F10.121', 'INTOXICACION POR ALCOHOL CON ALTERACIONES PERCEPTIVAS', 'intoxicacion por alcohol con alteraciones perceptivas');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F19.921', 'INTOXICACION POR MULTIPLES SUSTANCIAS', 'intoxicacion por multiples sustancias');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F15.93', 'TRASTORNO NO ESPECIFICADO ESTIMULANTES', 'trastorno no especificado estimulantes');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F12.99', 'TRASTORNO NO ESPECIFICADO CANNABIS', 'trastorno no especificado cannabis');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F19.99', 'TRASTORNO NO ESPECIFICADO MULTIPLES SUSTANCIAS', 'trastorno no especificado multiples sustancias');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F17.29', 'TRASTORNO POR USO DE TABACO NO ESPECIFICADO', 'trastorno por uso de tabaco no especificado');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F11.29', 'TRASTORNO POR USO DE OPIACEOS NO ESPECIFICADO', 'trastorno por uso de opiaceos no especificado');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F10.99', 'TRASTORNO POR USO DE ALCOHOL NO ESPECIFICADO', 'trastorno por uso de alcohol no especificado');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('F13.99', 'TRASTORNO POR USO DE SEDANTES NO ESPECIFICADO', 'trastorno por uso de sedantes no especificado');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z03.89', 'OBSERVACION POR SOSPECHA DE TRASTORNO MENTAL', 'observacion por sospecha de trastorno mental');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z63.0', 'PROBLEMAS DE RELACION CONYUGAL', 'problemas de relacion conyugal');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z63.5', 'PERDIDA DE UN MIEMBRO DE LA FAMILIA', 'perdida de un miembro de la familia');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z65.0', 'PROBLEMAS RELACIONADOS CON CONDENA O ENCARCELAMIENTO', 'problemas relacionados con condena o encarcelamiento');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z65.3', 'PROBLEMAS RELACIONADOS CON OTRAS CIRCUNSTANCIAS PSICOSOCIALES', 'problemas relacionados con otras circunstancias psicosociales');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z65.8', 'OTROS PROBLEMAS PSICOSOCIALES ESPECIFICADOS', 'otros problemas psicosociales especificados');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z71.9', 'CONSEJERIA NO ESPECIFICADA', 'consejeria no especificada');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z72.9', 'PROBLEMAS DE ESTILO DE VIDA NO ESPECIFICADOS', 'problemas de estilo de vida no especificados');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('R45.851', 'PENSAMIENTOS SUICIDAS', 'pensamientos suicidas');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('R45.1', 'AGITACION', 'agitacion');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('R45.2', 'IMPULSIVIDAD', 'impulsividad');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('R45.4', 'IRRITABILIDAD Y ENOJO', 'irritabilidad y enojo');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('R45.81', 'COMPORTAMIENTO SUICIDA', 'comportamiento suicida');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('R46.89', 'OTROS SINTOMAS DE SALUD MENTAL', 'otros sintomas de salud mental');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z03.89x', 'EVALUACION DE SALUD MENTAL SIN DIAGNOSTICO', 'evaluacion de salud mental sin diagnostico');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z04.6', 'EVALUACION PSIQUIATRICA LEGAL', 'evaluacion psiquiatrica legal');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z13.89', 'EXAMEN PARA DIAGNOSTICO MENTAL', 'examen para diagnostico mental');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z60.9', 'PROBLEMAS SOCIALES NO ESPECIFICADOS', 'problemas sociales no especificados');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z74.3', 'NECESIDAD DE SUPERVISION', 'necesidad de supervision');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z75.4', 'FALTA DE VIVIENDA ESTABLE', 'falta de vivienda estable');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z03.89B', 'OBSERVACION POR COMPORTAMIENTO INUSUAL', 'observacion por comportamiento inusual');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z55.9', 'PROBLEMAS EDUCATIVOS NO ESPECIFICADOS', 'problemas educativos no especificados');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z56.0', 'DESEMPLEO', 'desempleo');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z56.2', 'CAMBIO DE TRABAJO AMENAZANTE', 'cambio de trabajo amenazante');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z56.4', 'DISCORDIA LABORAL', 'discordia laboral');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z56.6', 'OTROS PROBLEMAS LABORALES ESPECIFICADOS', 'otros problemas laborales especificados');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z59.0', 'FALTA DE VIVIENDA', 'falta de vivienda');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z59.5', 'POBREZA EXTREMA', 'pobreza extrema');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z60.0', 'PROBLEMAS DE AJUSTE CULTURAL', 'problemas de ajuste cultural');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z60.2', 'EXCLUSION SOCIAL Y RECHAZO', 'exclusion social y rechazo');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z62.820', 'FALTA DE SUPERVISION PARENTAL', 'falta de supervision parental');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z62.891', 'HISTORIA DE ABUSO PSICOLOGICO INFANTIL', 'historia de abuso psicologico infantil');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z62.898', 'OTROS PROBLEMAS DE CRIANZA', 'otros problemas de crianza');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z63.8', 'OTROS PROBLEMAS FAMILIARES ESPECIFICADOS', 'otros problemas familiares especificados');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z64.4', 'PROBLEMAS RELACIONADOS CON DECISIONES REPRODUCTIVAS', 'problemas relacionados con decisiones reproductivas');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z65.1', 'PROBLEMAS CON BAJO NIVEL EDUCATIVO', 'problemas con bajo nivel educativo');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z65.2', 'PROBLEMAS CON ALFABETIZACION LIMITADA', 'problemas con alfabetizacion limitada');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z71.84', 'CUMPLIMIENTO INADECUADO TRATAMIENTO', 'cumplimiento inadecuado tratamiento');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z72.810', 'USO EXCESIVO DE VIDEOJUEGOS', 'uso excesivo de videojuegos');
INSERT INTO salud_mentales (codigo, name, slug) VALUES ('Z76.5', 'PERSONA FINGIENDO ENFERMEDAD', 'persona fingiendo enfermedad');

ALTER TABLE `salud_mentales`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `salud_mentales`
--
ALTER TABLE `salud_mentales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=893;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
