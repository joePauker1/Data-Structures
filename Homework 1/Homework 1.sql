//HW1
CREATE view vHW1_1_paukerj as 
SELECT fname as Name, salary as Salary 
FROM CPS3740.Staff 
WHERE sex='M' and position='Manager';

//HW2
CREATE view vHW1_2_paukerj as 
SELECT lname as Last_Name, position as Position 
FROM CPS3740.Staff  
WHERE fname like '%e%' 
ORDER BY lname ASC;

//HW3
CREATE view vHW1_3_paukerj as
SELECT count(s.sex) as London_Female_Count
FROM CPS3740.Staff s, CPS3740.Branch b
WHERE b.Branchno=s.Branchno and sex='F' and b.city='London';


//HW4
CREATE view vHW1_4_paukerj as 
SELECT Hotel.hotelname, Room.price
FROM CPS3740.Hotel, CPS3740.Room
WHERE Hotel.hotelno = Room.hotelno and Room.price =
(SELECT max(price) FROM CPS3740.Room);

//HW5
CREATE view vHW1_5_paukerj as 
SELECT e.fname as Employee_Name, e.position as Position, m.fname as Manager_Name, m.position as Postion
FROM CPS3740.Staff e, CPS3740.Staff m
WHERE e.managerno = m.staffno and e.sex='M';

//HW6
CREATE view vHW1_6_paukerj as 
SELECT city as Branch_City, count(city) as How_Many_Branches
FROM CPS3740.Branch b, CPS3740.Staff s
WHERE b.branchno = s.branchno 
GROUP BY b.branchno
HAVING count(s.branchno) >= 2;

//HW7
CREATE view vHW1_7_paukerj as
SELECT guestname, hotelname, datediff(dateto,datefrom) as Number_Of_Days, price*datediff(dateto,datefrom) as Total_Paid
FROM CPS3740.Guest natural join CPS3740.Hotel natural join CPS3740.Room natural join CPS3740.Booking 
WHERE dateto is not null;


//HW8
CREATE TABLE Money_paukerj(
	mid int NOT NULL AUTO_INCREMENT,
	code varchar(50) NOT NULL UNIQUE,
	cid int NOT NULL,
	sid int NOT NULL,
	type char(1) NOT NULL,
	amount float NOT NULL,
	mydatetime datetime NOT NULL,
	note varchar(255),
	PRIMARY KEY (mid),
	FOREIGN KEY (cid) REFERENCES CPS3740.Customers(id),
	FOREIGN KEY (sid) REFERENCES CPS3740.Sources(id));

//HW9
INSERT INTO Money_paukerj				
VALUES ('mid', 'code', 'cid', 'sid', 'type','amount' , 'mydatetime' , 'note');
VALUES ('' , '00x' , 1 , 3 , 'D' , 75000 , NOW() , 'Manually inserted');
VALUES ('' , '01x' , 1 , 2 , 'D' , 2500  , NOW() , 'Manually inserted');
VALUES ('' , '02x' , 1 , 1 , 'W' , -1200 , NOW() , 'Manually inserted');
VALUES ('' , '03x' , 1 , 4 , 'W' , -5000 , NOW() , 'Manually inserted');
VALUES ('' , '04x' , 1 , 2 , 'D' , 2000 , NOW() , 'test');
