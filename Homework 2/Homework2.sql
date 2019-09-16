--HW 2 Question 1

DROP FUNCTION IF EXISTS fHW2_1_paukerj //
CREATE FUNCTION fHW2_1_paukerj(s INT) 
RETURNS varchar(250)

BEGIN 
DECLARE result INT DEFAULT 0 ; 
SELECT count(salary) INTO result FROM CPS3740.Staff 
WHERE salary >= s ; 

IF (s is null) THEN 
	RETURN('Error! Amount cannot be NULL') ; 
ELSEIF (result = 0) THEN 
	RETURN('No record found!') ; 
ELSE 
RETURN CONCAT('There are ' ,result, ' staff who salary >=' ,s) ; 
	END IF ; 
END
//
delimiter ;


--HW 2 Question 2

delimiter //
DROP PROCEDURE IF EXISTS pHW2_2_paukerj //
CREATE PROCEDURE pHW2_2_paukerj(cty varchar(250)) 
BEGIN 
DECLARE c varchar(250) default 0 ; 

    	SELECT b.branchno as branchno, s.sex as sex, count(s.sex) as myct 
		FROM CPS3740.Branch b, CPS3740.Staff s WHERE b.branchno = s.branchno 
		AND b.city = cty 
		GROUP BY b.branchno, s.sex ; 

IF ((cty is null) OR (cty = '')) THEN 
	SELECT "Please input a valid city name." as message ; 
ELSE	 
	SELECT city INTO c FROM CPS3740.Branch 
	WHERE city = cty ; 
	SELECT CONCAT("No branchno found in the city: ",cty) as message ;

END IF; 
END
//
delimiter ;

--HW 2 Question 3

delimiter //
DROP PROCEDURE IF EXISTS pHW2_3_paukerj //
CREATE PROCEDURE pHW2_3_paukerj(IN arg varchar(250), OUT argg varchar(250)) 

BEGIN 
DECLARE result varchar(250) default null; 
SELECT GROUP_CONCAT(DISTINCT guestname) into result 
FROM CPS3740.Guest 
WHERE guestaddress like CONCAT('%', arg , '%') ; 
SET argg = result; 

IF ((arg is null) OR (arg = '')) THEN 
	SELECT "Please input a valid city name." into result ; 
	SET argg = result; 
ELSEIF(argg is NOT null) THEN 
	SELECT result into result; 
ELSE 
	SELECT CONCAT("NO people found for city: ", arg) into result ; 
    SET argg = result; 
    END IF; 
END
//
delimiter ;

--HW 2 Question 4

delimiter //
DROP FUNCTION IF EXISTS pHW2_4_paukerj //
CREATE FUNCTION pHW2_4_paukerj(cty varchar(250)) 
RETURNS varchar(250) 
BEGIN DECLARE name varchar(250) DEFAULT null ; 
SELECT GROUP_CONCAT(DISTINCT guestname) into name FROM CPS3740.Guest 
WHERE guestaddress like CONCAT('%', cty , '%'); 

IF ((cty is null) or (cty = '')) THEN 
	RETURN('Please input a valid city.') ; 
ELSEIF (name is NOT null) THEN 
	RETURN(name) ; 
ELSE 
	RETURN ('No results found.'); 
    END IF ; 
END
//
delimiter ;

--HW 2 Question 5

delimiter //
DROP FUNCTION IF EXISTS fHW2_5_paukerj //
CREATE FUNCTION fHW2_5_paukerj(num INT) 
RETURNS varchar(250)

BEGIN 
DECLARE total INT DEFAULT 0 ; 
DECLARE x INT DEFAULT 0 ;
DECLARE N INT DEFAULT 0 ;
DECLARE P INT DEFAULT 1 ;
DECLARE str varchar(250) default '' ;
SET N = num ;

IF (num < 0) THEN 
	RETURN('Please input a positive number.') ; 
ELSEIF ((num > 0) and (num <= 5)) THEN 
	WHILE (num > 0) DO
		SET x := x + num ;
        SET total := x ;
        SET num := num - 1;
	END WHILE ;
		WHILE (P < N) DO
			SET str = CONCAT(str, P, '+');
			SET P := P + 1 ;
		END WHILE ;
	RETURN CONCAT(str, N, '=',total) ;
ELSE 
	WHILE (num > 0) DO
		SET x := x + num ;
        SET total := x ;
        SET num := num - 1;
    END WHILE ;
	RETURN CONCAT('1+2+..+',N-1, '+' ,N,'=',total) ;
	END IF ; 
END
//
delimiter ;