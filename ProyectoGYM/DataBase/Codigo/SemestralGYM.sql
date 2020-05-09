CREATE DATABASE GYM
USE GYM

--CREACION DE PROCEDIMIENTOS Y FUNCIONES
--------------------------------------------------------------------------------------------------------------------------------------

--1
GO
CREATE PROCEDURE SP_INSCRIPCIONES(
    @NRO_INS INT,
    @FECHA_INS DATE,
    @ID_CLI INT,
    @PL_ID VARCHAR(15),
    @INICIO DATE,
    @FIN DATE,
    @DEUDAS DECIMAL,
    @DESCRIPCION VARCHAR(40)
    
)AS
BEGIN
    INSERT INTO INSCRIPCIONES VALUES(@NRO_INS, @FECHA_INS, @ID_CLI, @PL_ID, @INICIO, @FIN, @DEUDAS, @DESCRIPCION)
END 



--2
GO
CREATE PROCEDURE SP_HISTORIAL(
    @ID INT,
    @INGRESO DATE
)AS 
BEGIN
    DECLARE @COD INT

    SELECT @COD = (SELECT ID FROM CLIENTES WHERE ID = @ID)

    IF @COD IS NOT NULL 
        BEGIN
            INSERT INTO HISTORIAL VALUES(@ID, @INGRESO)
        END
    ELSE
        PRINT 'EL CLIENTE SOLICITADO NO EXISTE'
END



--3
GO
CREATE PROCEDURE SP_ACTUALIZA_INSCRIP(
    @COD INT, 
    @PLAN VARCHAR(15)
)AS
BEGIN
    DECLARE 
        @CODI INT,
        @NUEVA_DEUDA DECIMAL

    SELECT @CODI = (SELECT ID_CLIENTE FROM INSCRIPCIONES WHERE ID_CLIENTE = @COD)
    SELECT @NUEVA_DEUDA = (SELECT COSTO FROM PLANES WHERE ID = @PLAN)

    IF @CODI IS NOT NULL 
        BEGIN
            UPDATE INSCRIPCIONES SET PLAN_ID = @PLAN, DEUDA = @NUEVA_DEUDA WHERE ID_CLIENTE = @COD
        END
    ELSE
        PRINT 'EL CLIENTE SOLICITADO NO EXISTE'
END



--4
GO
CREATE PROCEDURE SP_PERFIL(
    @CODPER INT
)AS
BEGIN
    INSERT INTO LESIONADOS VALUES(@CODPER, NULL, NULL, NULL)
    INSERT INTO LESIONES VALUES(@CODPER, NULL, NULL) 
END



--5
GO
CREATE PROCEDURE SP_REDES(
    @ID INT,
    @WHATS VARCHAR(25),
    @FACE VARCHAR(30),
    @INSTA VARCHAR(30),
    @CORREO VARCHAR(40)
)AS
BEGIN
    INSERT INTO REDES VALUES(@ID, @WHATS, @FACE, @INSTA, @CORREO)
END


SELECT * FROM INFO_CONTACTO
--6
GO
CREATE PROCEDURE SP_ACTUALIZA_REDES(
    @ID INT,
    @WHATS VARCHAR(25),
    @FACE VARCHAR(30),
    @INSTA VARCHAR(30),
    @CORREO VARCHAR(40)
)AS
BEGIN
     DECLARE 
        @CODI INT

    SELECT @CODI = (SELECT ID_SOCIAL FROM INFO_CONTACTO WHERE ID_SOCIAL = @ID)

    IF @CODI IS NOT NULL 
        BEGIN
            UPDATE REDES SET WHATSAPP = @WHATS, FACEBOOK = @FACE, INSTAGRAM = @INSTA, 
            CORREO = @CORREO WHERE ID_REDES = @ID
        END
    ELSE
        PRINT 'EL CLIENTE SOLICITADO NO EXISTE'
END

SELECT * from INFO_CONTACTO

--7
GO
CREATE PROCEDURE SP_ACTUALIZA_LESIONES(
    @ID INT,
    @POSEE VARCHAR(5),
    @NOM VARCHAR(20)
)AS
BEGIN
     DECLARE 
        @CODI INT

    SELECT @CODI = (SELECT ID_PER FROM LESIONES WHERE ID_PER = @ID)

    IF @CODI IS NOT NULL 
        BEGIN
            UPDATE LESIONES SET POSEE_LESIONES = @POSEE, NOMBRE_LESION = @NOM
            WHERE ID_PER = @ID
        END
    ELSE
        PRINT 'EL CLIENTE SOLICITADO NO EXISTE'
END



--8
GO
CREATE PROCEDURE SP_ACTUALIZA_LESIONADOS(
    @ID INT,
    @NOM VARCHAR(20),
    @DIA DATE,
    @DESC VARCHAR(50)
)AS
BEGIN
     DECLARE 
        @CODI INT

    SELECT @CODI = (SELECT ID_PERF FROM LESIONADOS WHERE ID_PERF = @ID)

    IF @CODI IS NOT NULL 
        BEGIN
            UPDATE LESIONADOS SET NOMBRE_LESION = @NOM, DIA = @DIA, DESCRIPCION = @DESC
            WHERE ID_PERF = @ID
        END
    ELSE
        PRINT 'EL CLIENTE SOLICITADO NO EXISTE'
END


--9
GO 
CREATE PROCEDURE SP_CLIENTES_INSCRITOS_UNO(
    @ID INT
)AS
BEGIN
    SELECT C.ID, C.NOMBRE, C.APELLIDO, C.CEDULA, C.F_NACIMIENTO, 
    I.FECHA_INSCRIPCION, I.PLAN_ID AS TIPO_DE_PLAN, I.DEUDA  
    FROM CLIENTES C 
    INNER JOIN INSCRIPCIONES I 
    ON C.ID = I.ID_CLIENTE
    WHERE C.ID = I.ID_CLIENTE AND C.ID = @ID
END

--10
GO 
CREATE PROCEDURE SP_ASISTENCIA_UNO(
    @ID INT
)AS
BEGIN 
    SELECT C.ID, C.NOMBRE, C.APELLIDO, C.CEDULA, H.FECHA
    FROM CLIENTES C 
    INNER JOIN HISTORIAL H  
    ON C.ID = H.ID 
    WHERE C.ID = H.ID AND C.ID = @ID 
END


--11
GO 
CREATE PROCEDURE SP_ESTADO_CLIENTES_UNO(
    @ID INT
)AS
BEGIN 
    SELECT C.ID, C.NOMBRE, C.APELLIDO, C.CEDULA, P.ESTATURA, P.PESO_INICIAL, 
    P.PESO_ACTUAL, L.NOMBRE_LESION, L.DIA, L.DESCRIPCION
    FROM CLIENTES C 
    INNER JOIN PERFILES P 
    ON C.ID = P.ID_CLIENTE
    INNER JOIN LESIONADOS L
    ON P.ID_PERFIL = L.ID_PERF
    WHERE C.ID = P.ID_PERFIL AND C.ID = @ID 
END


--12
GO 
CREATE PROCEDURE SP_CONTACTO_UNO( 
    @COD INT 
)AS
BEGIN 
    SELECT C.ID, C.NOMBRE, C.APELLIDO, C.CEDULA, R.WHATSAPP, R.FACEBOOK, R.INSTAGRAM,
    R.CORREO, I.TEL_FAMILIAR, I.DIRECCION
    FROM CLIENTES C 
    INNER JOIN INFO_CONTACTO I
    ON C.ID = I.ID_CLIENTE 
    INNER JOIN REDES R
    ON I.ID_SOCIAL = R.ID_REDES
    WHERE C.ID = I.ID_CLIENTE AND C.ID = @COD 
END



--13
GO 
CREATE PROCEDURE SP_HISTORIAL_DE_PAGOS_UNO( 
    @COD INT 
)AS
BEGIN 
    SELECT C.ID, C.NOMBRE, C.APELLIDO, C.CEDULA, P.SALDO, P.FECHA, P.DETALLES
    FROM CLIENTES C 
    INNER JOIN INSCRIPCIONES I
    ON C.ID = I.ID_CLIENTE
    INNER JOIN PAGO P
    ON I.NRO_INSCRIPCION = P.COD_INSCRIPCION
    WHERE C.ID = I.ID_CLIENTE AND C.ID = @COD 
END


--CREACION DE TRIGGERS 
--------------------------------------------------------------------------------------------------------------------------------------

--1
GO
CREATE TRIGGER T_INSCRIPCION
ON CLIENTES INSTEAD OF INSERT
AS 
BEGIN
    DECLARE 
        @NUM INT,
        @FECHA_ACTUAL DATE,
        @CLIENTE_ID INT,
        @PLAN VARCHAR(15),
        @INICIO DATE,
        @FIN DATE,
        @DESCRIP VARCHAR(40),
        @NOMB VARCHAR(15),
        @APE VARCHAR(20),
        @CEDU VARCHAR(10),
        @SEXO VARCHAR(10),
        @NACIMI DATE,
        @DEUDA DECIMAL

        SET @CLIENTE_ID = (SELECT ISNULL(MAX(ID), 0) + 1 FROM CLIENTES)
        SET @NOMB = (SELECT NOMBRE FROM inserted)
        SET @APE = (SELECT APELLIDO FROM inserted)
        SELECT @CEDU = (SELECT CEDULA FROM inserted)
        SELECT @SEXO = (SELECT SEXO FROM inserted)
        SELECT @NACIMI = (SELECT F_NACIMIENTO FROM inserted) 

        INSERT INTO CLIENTES VALUES(@CLIENTE_ID, @NOMB, @APE, @CEDU, @SEXO, @NACIMI)

        SET @NUM = (SELECT ISNULL(MAX(NRO_INSCRIPCION), 0) + 1 FROM INSCRIPCIONES)
        SET @FECHA_ACTUAL = (SELECT CURRENT_TIMESTAMP)
        SET @PLAN = (SELECT ID FROM PLANES WHERE COSTO = 60.00)
        SET @INICIO = @FECHA_ACTUAL
        SELECT @FIN = (SELECT DATEADD(month, 1, (SELECT CONVERT (date, CURRENT_TIMESTAMP))))
        SELECT @DESCRIP = (SELECT DESCRIPCION FROM PLANES WHERE ID = @PLAN)
        SELECT @DEUDA = (SELECT COSTO FROM PLANES WHERE ID = @PLAN)

        EXEC SP_INSCRIPCIONES @NUM, @FECHA_ACTUAL, @CLIENTE_ID, @PLAN, @INICIO, @FIN, @DEUDA, @DESCRIP           
END



--2
GO 
CREATE TRIGGER T_DELETE_CLIENTE
ON CLIENTES INSTEAD OF DELETE
AS
BEGIN
    DECLARE 
        @COD_DELETED INT, 
        @N_INSCRIPCION INT,
        @CODI_CLI INT,
        @id_soc INT

        SELECT @COD_DELETED = (SELECT ID FROM deleted) 
        SELECT @N_INSCRIPCION = (SELECT NRO_INSCRIPCION FROM INSCRIPCIONES WHERE ID_CLIENTE = @COD_DELETED) 
        SELECT @CODI_CLI = (SELECT ID FROM CLIENTES WHERE ID = @COD_DELETED)
        SELECT @id_soc = (SELECT ID_SOCIAL FROM INFO_CONTACTO WHERE ID_CLIENTE = @COD_DELETED)

        IF @CODI_CLI IS NOT NULL
            BEGIN
                DELETE FROM PAGO WHERE COD_INSCRIPCION = @N_INSCRIPCION
                DELETE FROM INSCRIPCIONES WHERE NRO_INSCRIPCION = @N_INSCRIPCION 
                DELETE FROM INFO_CONTACTO WHERE ID_CLIENTE = @COD_DELETED
                DELETE FROM REDES WHERE ID_REDES = @id_soc
                DELETE FROM LESIONES WHERE ID_PER = (SELECT ID_PERFIL FROM PERFILES WHERE ID_CLIENTE = @COD_DELETED)
                DELETE FROM LESIONADOS WHERE ID_PERF = (SELECT ID_PERFIL FROM PERFILES WHERE ID_CLIENTE = @COD_DELETED)
                DELETE FROM PERFILES WHERE ID_CLIENTE = @COD_DELETED
                DELETE FROM HISTORIAL WHERE ID = @COD_DELETED
                DELETE FROM CLIENTES WHERE ID = @COD_DELETED
            END
        ELSE
            PRINT 'EL CLIENTE SOLICITADO NO ESTA INSCRITO'

END


--3
GO
CREATE TRIGGER T_PAGOS
ON PAGO INSTEAD OF INSERT
AS
BEGIN
    DECLARE
        @COD INT,
        @FECHA DATE, 
        @SAL DECIMAL,
        @DETALLE VARCHAR(30),
        @ID_CLIENTE INT,
        @INGRESO DATE,
        @SALIDA DATE,
        @COM_INS INT,
        @DEUDAS DECIMAL

        SELECT @COD = (SELECT COD_INSCRIPCION FROM inserted)
        SELECT @FECHA = (SELECT CURRENT_TIMESTAMP)
        SELECT @SAL = (SELECT SALDO FROM inserted)
        SELECT @DETALLE = (SELECT DETALLES FROM inserted)
        SELECT @ID_CLIENTE = (SELECT ID_CLIENTE FROM INSCRIPCIONES WHERE NRO_INSCRIPCION = @COD)
        SELECT @INGRESO = (SELECT SYSDATETIME())
        SELECT @DEUDAS = (SELECT DEUDA FROM INSCRIPCIONES WHERE ID_CLIENTE = @ID_CLIENTE)
        SELECT @COM_INS = (SELECT NRO_INSCRIPCION FROM INSCRIPCIONES WHERE NRO_INSCRIPCION = @COD)

        IF @COM_INS IS NOT NULL
            BEGIN
                INSERT INTO PAGO VALUES(@COD, @FECHA, @SAL, @DETALLE)
                UPDATE INSCRIPCIONES SET DEUDA = @DEUDAS - @SAL WHERE ID_CLIENTE = @ID_CLIENTE
                EXEC SP_HISTORIAL @ID_CLIENTE, @INGRESO
            END
        ELSE
            PRINT 'EL CLIENTE SOLICITADO NO ESTA INSCRITO'
END


--4
GO
CREATE TRIGGER T_CONTACTO
ON INFO_CONTACTO INSTEAD OF INSERT
AS
BEGIN
    DECLARE
        @ID_CLI INT,
        @TEL VARCHAR(15),
        @TEL_F VARCHAR(15),
        @DIREC VARCHAR(40),
        @ID_SOC INT,
        @VERIF INT

        SET @ID_SOC = (SELECT ISNULL(MAX(ID_REDES), 0) + 1 FROM REDES)
        SELECT @TEL = (SELECT TELEFONO FROM inserted)
        SELECT @TEL_F = (SELECT TEL_FAMILIAR FROM inserted)
        SELECT @DIREC = (SELECT DIRECCION FROM inserted)
        SELECT @ID_CLI = (SELECT ID_CLIENTE FROM inserted)

        SELECT @VERIF = (SELECT ID FROM CLIENTES WHERE ID = @ID_CLI)

        IF @VERIF IS NOT NULL
            BEGIN
                EXEC SP_REDES @ID_SOC, @TEL, NULL, NULL, NULL
                INSERT INTO INFO_CONTACTO VALUES(@ID_CLI, @TEL, @TEL_F, @DIREC, @ID_SOC)
            END
        ELSE
            PRINT 'EL CLIENTE SOLICITADO NO EXISTE'
END


--5
GO 
CREATE TRIGGER T_CREA_PERFIL
ON PERFILES INSTEAD OF INSERT
AS
BEGIN
    DECLARE 
        @CODI INT,
        @CLIENT INT,
        @ESTATURA DECIMAL,
        @PESOINI INT,
        @PESOFIN INT,
        @VERIFICAR_COD INT

        SELECT @CODI = (SELECT ISNULL(MAX(ID_PERFIL), 0) + 1 FROM PERFILES)
        SELECT @CLIENT = (SELECT ID_CLIENTE FROM inserted)
        SELECT @ESTATURA = (SELECT ESTATURA FROM inserted)
        SELECT @PESOINI = (SELECT PESO_INICIAL FROM inserted)
        SELECT @PESOFIN = (SELECT PESO_ACTUAL FROM inserted)
        
        SELECT @VERIFICAR_COD = (SELECT ID FROM CLIENTES WHERE ID = @CLIENT)

        IF @VERIFICAR_COD IS NOT NULL
            BEGIN
                INSERT INTO PERFILES VALUES(@CODI, @CLIENT, @ESTATURA, @PESOINI, @PESOFIN)
                EXEC SP_PERFIL @CODI
            END
        ELSE
            PRINT 'EL CLIENTE SOLICITADO NO EXISTE'
END 


--6
GO 
CREATE TRIGGER T_DELETE_PERFIL
ON PERFILES INSTEAD OF DELETE
AS
BEGIN
    DECLARE 
        @COD_DELETED INT, 
        @VERIFY INT

        SELECT @COD_DELETED = (SELECT ID_PERFIL FROM deleted) 
        SELECT @VERIFY = (SELECT ID FROM CLIENTES WHERE ID = @COD_DELETED)

        IF @VERIFY IS NOT NULL
            BEGIN 
                DELETE FROM LESIONES WHERE ID_PER = (SELECT ID_PERFIL FROM PERFILES WHERE ID_CLIENTE = @COD_DELETED)
                DELETE FROM LESIONADOS WHERE ID_PERF = (SELECT ID_PERFIL FROM PERFILES WHERE ID_CLIENTE = @COD_DELETED)
                DELETE FROM PERFILES WHERE ID_CLIENTE = @COD_DELETED
            END
        ELSE
            PRINT 'EL CLIENTE SOLICITADO NO ESTA INSCRITO'

END


--7
GO 
CREATE TRIGGER T_UPDATE_PAGO
ON PAGO INSTEAD OF UPDATE
AS
BEGIN
    DECLARE 
        @COD_DELETED INT,
        @in DATE,
        @SAL DECIMAL,  
        @SALOLD DECIMAL,
        @FECHAOLD DATE,
        @deta VARCHAR(30),
        @DEUDATOT DECIMAL,
        @DEUDAS DECIMAL,
        @VERIFY INT

        SELECT @COD_DELETED = (SELECT COD_INSCRIPCION FROM deleted)
        SELECT @in = (SELECT FECHA FROM inserted)
        SELECT @SAL = (SELECT SALDO FROM inserted)
        SELECT @FECHAOLD =(SELECT FECHA FROM deleted)
        SELECT @SALOLD = (SELECT SALDO FROM deleted)
        SELECT @DEUDATOT = (SELECT (DEUDA + @SALOLD) FROM INSCRIPCIONES WHERE NRO_INSCRIPCION = @COD_DELETED)
        SELECT @deta = (SELECT DETALLES FROM inserted)
        SELECT @VERIFY = (SELECT COD_INSCRIPCION FROM PAGO WHERE COD_INSCRIPCION = @COD_DELETED)

        IF @VERIFY IS NOT NULL
            BEGIN 
                UPDATE HISTORIAL SET FECHA = @in WHERE ID = @VERIFY
                UPDATE PAGO SET FECHA = @in, SALDO = @SAL, DETALLES = @deta WHERE COD_INSCRIPCION = @COD_DELETED  AND FECHA = @FECHAOLD
                UPDATE INSCRIPCIONES SET DEUDA = @DEUDATOT - @SAL WHERE NRO_INSCRIPCION = @COD_DELETED
            END
        ELSE
            PRINT 'EL CLIENTE SOLICITADO NO ESTA INSCRITO'
END


--CREACION DE CURSORES
--------------------------------------------------------------------------------------------------------------------------------------

--1
DECLARE @PLAN VARCHAR(15)

DECLARE PLANES_CURSOR CURSOR FOR
SELECT ID 
FROM PLANES

OPEN PLANES_CURSOR

FETCH NEXT FROM PLANES_CURSOR INTO @PLAN

WHILE @@FETCH_STATUS = 0 
    BEGIN
        SELECT P.NOMBRE AS PLANES, COUNT(I.ID_CLIENTE) AS INSCRITOS
        FROM INSCRIPCIONES I 
        INNER JOIN PLANES P ON I.PLAN_ID = P.ID
        WHERE P.ID = @PLAN
        GROUP BY P.NOMBRE
        FETCH NEXT FROM PLANES_CURSOR INTO @PLAN
    END

CLOSE PLANES_CURSOR

DEALLOCATE PLANES_CURSOR



--2
DECLARE @SUCURSAL VARCHAR(15)

DECLARE CANTI_SUCURSAL_CURSOR CURSOR FOR
SELECT COD_SUCURSAL 
FROM PLANES

OPEN CANTI_SUCURSAL_CURSOR

FETCH NEXT FROM CANTI_SUCURSAL_CURSOR INTO @SUCURSAL

WHILE @@FETCH_STATUS = 0 
    BEGIN
        SELECT S.NOMBRE_SUCURSAL AS SUCURSALES, COUNT(P.COD_SUCURSAL) AS CLIENTES
        FROM SUCURSALES S
        INNER JOIN PLANES P ON S.ID_SUCURSAL = P.COD_SUCURSAL 
        WHERE P.COD_SUCURSAL = @SUCURSAL
        GROUP BY S.NOMBRE_SUCURSAL
        FETCH NEXT FROM CANTI_SUCURSAL_CURSOR INTO @SUCURSAL
    END

CLOSE CANTI_SUCURSAL_CURSOR

DEALLOCATE CANTI_SUCURSAL_CURSOR



--3
DECLARE @COD INT

DECLARE DEUDORES_CURSOR CURSOR FOR
SELECT ID_CLIENTE
FROM INSCRIPCIONES

OPEN DEUDORES_CURSOR

FETCH NEXT FROM DEUDORES_CURSOR INTO @COD

WHILE @@FETCH_STATUS = 0 
    BEGIN
        SELECT C.ID AS CODIGO, C.NOMBRE AS NOMBRE, C.APELLIDO AS APELLIDO,
        C.CEDULA AS CEDULA, I.PLAN_ID AS TIPO_PLAN, I.DEUDA AS DEUDA_PENDIENTE
        FROM CLIENTES C 
        INNER JOIN INSCRIPCIONES I 
        ON C.ID = I.ID_CLIENTE
        WHERE C.ID = @COD
        GROUP BY C.ID, C.NOMBRE, C.APELLIDO, C.CEDULA, I.PLAN_ID, I.DEUDA
        FETCH NEXT FROM DEUDORES_CURSOR INTO @COD
    END

CLOSE DEUDORES_CURSOR

DEALLOCATE DEUDORES_CURSOR



--4
DECLARE @CODIG INT

DECLARE HISTORIAL_CURSOR CURSOR FOR
SELECT ID
FROM HISTORIAL

OPEN HISTORIAL_CURSOR

FETCH NEXT FROM HISTORIAL_CURSOR INTO @CODIG

WHILE @@FETCH_STATUS = 0 
    BEGIN
        SELECT C.ID AS CODIGO, C.NOMBRE AS NOMBRE, C.APELLIDO AS APELLIDO,
        C.CEDULA AS CEDULA, COUNT(H.INGRESO) AS ASISTENCIA
        FROM CLIENTES C 
        INNER JOIN HISTORIAL H ON C.ID = H.ID
        WHERE C.ID = @CODIG
        GROUP BY C.ID, C.NOMBRE, C.APELLIDO, C.CEDULA, H.INGRESO
        FETCH NEXT FROM HISTORIAL_CURSOR INTO @CODIG
    END

CLOSE HISTORIAL_CURSOR

DEALLOCATE HISTORIAL_CURSOR



--VISTAS
--------------------------------------------------------------------------------------------------------------------------------------

--1
GO
CREATE VIEW CLIENTES_INSCRITOS 
AS
SELECT C.ID, C.NOMBRE, C.APELLIDO, C.CEDULA, C.F_NACIMIENTO, 
I.FECHA_INSCRIPCION, I.PLAN_ID AS TIPO_DE_PLAN, I.DEUDA 
FROM CLIENTES C 
INNER JOIN INSCRIPCIONES I 
ON C.ID = I.ID_CLIENTE
WHERE C.ID = I.ID_CLIENTE 
GO



--2
CREATE VIEW ESTADO_CLIENTES
AS
SELECT C.ID, C.NOMBRE, C.APELLIDO, C.CEDULA, P.ESTATURA, P.PESO_INICIAL, 
P.PESO_ACTUAL, L.NOMBRE_LESION, L.DIA, L.DESCRIPCION
FROM CLIENTES C 
INNER JOIN PERFILES P 
ON C.ID = P.ID_CLIENTE
INNER JOIN LESIONADOS L
ON P.ID_PERFIL = L.ID_PERF
WHERE C.ID = P.ID_PERFIL
GO


--3
CREATE VIEW ASISTENCIA 
AS
SELECT C.ID, C.NOMBRE, C.APELLIDO, C.CEDULA, H.FECHA
FROM CLIENTES C 
INNER JOIN HISTORIAL H 
ON C.ID = H.ID
WHERE C.ID = H.ID
GO


--4
CREATE VIEW CONTACTO 
AS
SELECT C.ID, C.NOMBRE, C.APELLIDO, C.CEDULA, R.WHATSAPP, R.FACEBOOK, R.INSTAGRAM,
R.CORREO, I.TEL_FAMILIAR, I.DIRECCION
FROM CLIENTES C 
INNER JOIN INFO_CONTACTO I
ON C.ID = I.ID_CLIENTE
INNER JOIN REDES R
ON I.ID_SOCIAL = R.ID_REDES
WHERE C.ID = I.ID_CLIENTE
GO


--5
CREATE VIEW HISTORIAL_DE_PAGOS
AS
SELECT C.ID, C.NOMBRE, C.APELLIDO, C.CEDULA, P.SALDO, P.FECHA, P.DETALLES
FROM CLIENTES C 
INNER JOIN INSCRIPCIONES I
ON C.ID = I.ID_CLIENTE
INNER JOIN PAGO P
ON I.NRO_INSCRIPCION = P.COD_INSCRIPCION
WHERE C.ID = I.ID_CLIENTE
GO


--6
CREATE VIEW CLIENTES_PLANES
AS
SELECT P.ID, P.NOMBRE AS PLANES, COUNT(I.ID_CLIENTE) AS INSCRITOS
FROM INSCRIPCIONES I 
INNER JOIN PLANES P ON I.PLAN_ID = P.ID
WHERE P.ID = I.PLAN_ID
GROUP BY P.ID, P.NOMBRE
GO


SELECT * FROM CLIENTES_INSCRITOS 
SELECT * FROM ESTADO_CLIENTES
SELECT * FROM ASISTENCIA
SELECT * FROM CONTACTO
SELECT * FROM HISTORIAL_DE_PAGOS
SELECT * FROM CLIENTES_PLANES



--COMANDOS UTILIZADOS
--------------------------------------------------------------------------------------------------------------------------------------
DELETE from PERFILES WHERE ID_PERFIL =28;
DELETE FROM LESIONADOS WHERE ID_PERF = 28;
EXEC SP_CLIENTES_INSCRITOS_UNO 1
SELECT * FROM USUARIOS
SELECT * FROM CLIENTES 
SELECT * FROM INSCRIPCIONES
SELECT * FROM INFO_CONTACTO
SELECT * FROM REDES
SELECT * FROM PLANES
SELECT * FROM SUCURSALES
SELECT * FROM PERFILES
SELECT * FROM LESIONADOS
SELECT * FROM LESIONES
SELECT * FROM PAGO
SELECT * FROM HISTORIAL
DELETE FROM PERFILES WHERE ID_PERFIL = 100
DROP TRIGGER T_CREA_PERFIL
DELETE FROM CLIENTES WHERE ID = 2
DROP TABLE CLIENTES
EXEC SP_ACTUALIZA_INSCRIP 28, 'P_D'
delete from USUARIOS
/*
DROP TABLE PERFILES
DROP TABLE LESIONES
DROP TABLE LESIONADOS
DROP TABLE PAGO
DROP TABLE INSCRIPCIONES
DROP TABLE HISTORIAL
DROP TABLE CLIENTES
DROP TABLE INFO_CONTACTO
DROP TABLE REDES*/

