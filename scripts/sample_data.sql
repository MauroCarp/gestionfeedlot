-- Sample demo data for feedlot system (non-real)
-- Target DB: feedlot
-- Safe to run multiple times; uses NOT EXISTS guards for reference data.

START TRANSACTION;
USE feedlot;

-- Reference data: razas (only insert if missing)
INSERT INTO razas(raza)
SELECT 'Angus' WHERE NOT EXISTS (SELECT 1 FROM razas WHERE raza='Angus');
INSERT INTO razas(raza)
SELECT 'Hereford' WHERE NOT EXISTS (SELECT 1 FROM razas WHERE raza='Hereford');
INSERT INTO razas(raza)
SELECT 'Braford' WHERE NOT EXISTS (SELECT 1 FROM razas WHERE raza='Braford');
INSERT INTO razas(raza)
SELECT 'Cruza' WHERE NOT EXISTS (SELECT 1 FROM razas WHERE raza='Cruza');
INSERT INTO razas(raza)
SELECT 'Brangus' WHERE NOT EXISTS (SELECT 1 FROM razas WHERE raza='Brangus');

-- Columnas completas segun formato requerido
INSERT INTO ingresos (
	feedlot,tropa,adpv,renspa,LID,IDE,peso,raza,sexo,numDTE,estadoTropa,estadoAnimal,origen,proveedor,notas,corral,fecha,hora,destino,gdm,gpv,dias,estado,statusDate,grupo,caravanaValida
)
VALUES
('Demo Feedlot','DEMO-INGRESO-001',0.0,'RNSP-0001',NULL,'DF-ING-001-001',325,'Angus','Macho','10001','Bueno','Bueno','La Pampa','Proveedor Demo SRL','', 'A1','2025-11-20','08:15:00','Planta Demo',NULL,NULL,NULL,'Bueno',NULL,NULL,0),
('Demo Feedlot','DEMO-INGRESO-001',0.0,'RNSP-0001',NULL,'DF-ING-001-002',338,'Hereford','Hembra','10001','Bueno','Bueno','La Pampa','Proveedor Demo SRL','', 'A1','2025-11-20','08:16:00','Planta Demo',NULL,NULL,NULL,'Bueno',NULL,NULL,0),
('Demo Feedlot','DEMO-INGRESO-001',0.0,'RNSP-0001',NULL,'DF-ING-001-003',351,'Braford','Macho','10001','Regular','Regular','La Pampa','Proveedor Demo SRL','', 'A1','2025-11-20','08:17:00','Planta Demo',NULL,NULL,NULL,'Regular',NULL,NULL,0),
('Demo Feedlot','DEMO-INGRESO-001',0.0,'RNSP-0001',NULL,'DF-ING-001-004',360,'Angus','Hembra','10001','Bueno','Bueno','La Pampa','Proveedor Demo SRL','', 'A1','2025-11-20','08:18:00','Planta Demo',NULL,NULL,NULL,'Bueno',NULL,NULL,0),
('Demo Feedlot','DEMO-INGRESO-001',0.0,'RNSP-0001',NULL,'DF-ING-001-005',342,'Cruza','Macho','10001','Bueno','Bueno','La Pampa','Proveedor Demo SRL','', 'A1','2025-11-20','08:19:00','Planta Demo',NULL,NULL,NULL,'Bueno',NULL,NULL,0),
('Demo Feedlot','DEMO-INGRESO-001',0.0,'RNSP-0001',NULL,'DF-ING-001-006',330,'Hereford','Hembra','10001','Regular','Regular','La Pampa','Proveedor Demo SRL','', 'A1','2025-11-20','08:20:00','Planta Demo',NULL,NULL,NULL,'Regular',NULL,NULL,0),
('Demo Feedlot','DEMO-INGRESO-001',0.0,'RNSP-0001',NULL,'DF-ING-001-007',355,'Braford','Macho','10001','Bueno','Bueno','La Pampa','Proveedor Demo SRL','', 'A1','2025-11-20','08:21:00','Planta Demo',NULL,NULL,NULL,'Bueno',NULL,NULL,0),
('Demo Feedlot','DEMO-INGRESO-001',0.0,'RNSP-0001',NULL,'DF-ING-001-008',348,'Angus','Hembra','10001','Bueno','Bueno','La Pampa','Proveedor Demo SRL','', 'A1','2025-11-20','08:22:00','Planta Demo',NULL,NULL,NULL,'Bueno',NULL,NULL,0);

-- Registro resumen de ingresos para DEMO-INGRESO-001
INSERT INTO registroingresos(feedlot,tropa,fecha,cantidad,pesoPromedio,renspa,proveedor,estado,adpv)
VALUES ('Demo Feedlot','DEMO-INGRESO-001','2025-11-20',8,341.1,'RNSP-0001','Proveedor Demo SRL','Bueno',0.0);

-- Status sanitario para DEMO-INGRESO-001
INSERT INTO status(feedlot,tropa,fechaIngreso,animales)
VALUES ('Demo Feedlot','DEMO-INGRESO-001','2025-11-20',8);

INSERT INTO ingresos (
	feedlot,tropa,adpv,renspa,LID,IDE,peso,raza,sexo,numDTE,estadoTropa,estadoAnimal,origen,proveedor,notas,corral,fecha,hora,destino,gdm,gpv,dias,estado,statusDate,grupo,caravanaValida
)
VALUES
('Demo Feedlot','DEMO-INGRESO-002',0.0,'RNSP-0002',NULL,'DF-ING-002-001',340,'Hereford','Macho','10002','Bueno','Bueno','Buenos Aires','Proveedor Demo SRL','', 'B2','2025-12-03','09:05:00','Planta Demo',NULL,NULL,NULL,'Bueno',NULL,NULL,0),
('Demo Feedlot','DEMO-INGRESO-002',0.0,'RNSP-0002',NULL,'DF-ING-002-002',352,'Angus','Hembra','10002','Bueno','Bueno','Buenos Aires','Proveedor Demo SRL','', 'B2','2025-12-03','09:06:00','Planta Demo',NULL,NULL,NULL,'Bueno',NULL,NULL,0),
('Demo Feedlot','DEMO-INGRESO-002',0.0,'RNSP-0002',NULL,'DF-ING-002-003',333,'Cruza','Macho','10002','Regular','Regular','Buenos Aires','Proveedor Demo SRL','', 'B2','2025-12-03','09:07:00','Planta Demo',NULL,NULL,NULL,'Regular',NULL,NULL,0),
('Demo Feedlot','DEMO-INGRESO-002',0.0,'RNSP-0002',NULL,'DF-ING-002-004',347,'Brangus','Macho','10002','Bueno','Bueno','Buenos Aires','Proveedor Demo SRL','', 'B2','2025-12-03','09:08:00','Planta Demo',NULL,NULL,NULL,'Bueno',NULL,NULL,0),
('Demo Feedlot','DEMO-INGRESO-002',0.0,'RNSP-0002',NULL,'DF-ING-002-005',361,'Angus','Hembra','10002','Bueno','Bueno','Buenos Aires','Proveedor Demo SRL','', 'B2','2025-12-03','09:09:00','Planta Demo',NULL,NULL,NULL,'Bueno',NULL,NULL,0),
('Demo Feedlot','DEMO-INGRESO-002',0.0,'RNSP-0002',NULL,'DF-ING-002-006',339,'Hereford','Hembra','10002','Regular','Regular','Buenos Aires','Proveedor Demo SRL','', 'B2','2025-12-03','09:10:00','Planta Demo',NULL,NULL,NULL,'Regular',NULL,NULL,0);

-- Ingreso de ejemplo proporcionado: Prueba Feedlot
INSERT INTO ingresos (
	feedlot,tropa,adpv,renspa,LID,IDE,peso,raza,sexo,numDTE,estadoTropa,estadoAnimal,origen,proveedor,notas,corral,fecha,hora,destino,gdm,gpv,dias,estado,statusDate,grupo,caravanaValida
)
VALUES
('Prueba Feedlot','Tropa Ingreso 1',0.56,'20.008.0.05582/01',NULL,'1234',350,'Hereford','Macho','1231','Bueno','Bueno','Corrientes','Proveedor 1','Ninguna Nota','6','2022-06-16','12:00:00','Frigorifico',NULL,NULL,NULL,'Bueno',NULL,NULL,0);

-- Registro resumen de ingresos para DEMO-INGRESO-002
INSERT INTO registroingresos(feedlot,tropa,fecha,cantidad,pesoPromedio,renspa,proveedor,estado,adpv)
VALUES ('Demo Feedlot','DEMO-INGRESO-002','2025-12-03',6,345.3,'RNSP-0002','Proveedor Demo SRL','Bueno',0.0);

-- Status sanitario para DEMO-INGRESO-002
INSERT INTO status(feedlot,tropa,fechaIngreso,animales)
VALUES ('Demo Feedlot','DEMO-INGRESO-002','2025-12-03',6);

-- Egresos: DEMO-EGRESO-001 (6 animales)
INSERT INTO egresos (feedlot,tropa,fecha,hora,IDE,proveedor,numeroDTE,origen,gdmTotal,gpvTotal,diasTotal,raza,sexo,destino,peso,notas)
VALUES
('Demo Feedlot','DEMO-EGRESO-001','2025-12-15','14:05:00','DF-EGR-001-001','Proveedor Demo SRL',5555,'La Pampa','1.35','150',120,'Angus','Macho','Frigorífico Demo',512,''),
('Demo Feedlot','DEMO-EGRESO-001','2025-12-15','14:06:00','DF-EGR-001-002','Proveedor Demo SRL',5555,'La Pampa','1.42','162',120,'Hereford','Hembra','Frigorífico Demo',528,''),
('Demo Feedlot','DEMO-EGRESO-001','2025-12-15','14:07:00','DF-EGR-001-003','Proveedor Demo SRL',5555,'La Pampa','1.28','140',120,'Angus','Macho','Frigorífico Demo',545,''),
('Demo Feedlot','DEMO-EGRESO-001','2025-12-15','14:08:00','DF-EGR-001-004','Proveedor Demo SRL',5555,'La Pampa','1.31','146',120,'Cruza','Macho','Frigorífico Demo',536,''),
('Demo Feedlot','DEMO-EGRESO-001','2025-12-15','14:09:00','DF-EGR-001-005','Proveedor Demo SRL',5555,'La Pampa','1.22','132',120,'Braford','Hembra','Frigorífico Demo',519,''),
('Demo Feedlot','DEMO-EGRESO-001','2025-12-15','14:10:00','DF-EGR-001-006','Proveedor Demo SRL',5555,'La Pampa','1.38','158',120,'Angus','Macho','Frigorífico Demo',552,'');

-- Registro resumen de egresos para DEMO-EGRESO-001
INSERT INTO registroegresos(feedlot,tropa,fecha,cantidad,destino,pesoPromedio,gmdPromedio,gpvPromedio)
VALUES ('Demo Feedlot','DEMO-EGRESO-001','2025-12-15',6,'Frigorífico Demo',532.0,1.33,148.0);

-- Muertes: DEMO-MUERTE-001 (3 animales)
INSERT INTO muertes (feedlot,tropa,IDE,peso,sexo,proveedor,corral,origen,totalDias,causaMuerte,fecha,hora)
VALUES
('Demo Feedlot','DEMO-MUERTE-001','DF-MUE-001-001',342,'Macho','Proveedor Demo SRL',7,'La Pampa',20,'Respiratorio','2025-10-10','09:15:00'),
('Demo Feedlot','DEMO-MUERTE-001','DF-MUE-001-002',358,'Hembra','Proveedor Demo SRL',7,'La Pampa',35,'Digestivo','2025-11-02','10:05:00'),
('Demo Feedlot','DEMO-MUERTE-001','DF-MUE-001-003',329,'Macho','Proveedor Demo SRL',7,'La Pampa',65,'Accidente','2025-12-01','07:50:00');

-- Registro resumen de muertes para DEMO-MUERTE-001
INSERT INTO registromuertes(feedlot,tropa,fecha,cantidad,causaMuerte)
VALUES ('Demo Feedlot','DEMO-MUERTE-001','2025-12-01',3,'Varias');

COMMIT;
