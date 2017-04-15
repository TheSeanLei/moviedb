-- Movie DB 


-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

CREATE TABLE IF NOT EXISTS `movie` (
  `title` varchar(30) NOT NULL,
  `release_year` int NOT NULL,
  `rating` float DEFAULT NULL,
  `running_time_minutes` integer NOT NULL CHECK (running_time_minutes>=1),
  `platform` ENUM('Netflix','Amazon Instant','Youtube','HBO GO', 'none') DEFAULT 'none',
  PRIMARY KEY (`title`, `release_year`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `movie`
--

INSERT INTO `movie` (`title`, `release_year`, `rating`, `running_time_minutes`, `platform`) VALUES
('Logan', 2017, 8.6, 137, 'none'),
('Arrival', 2016, 8.0, 116, 'none'), 
('Moana', 2016, 7.8, 97, 'none'),
('The Shawshank Redemption', 1994, 9.3, 142, 'none'),
('Frozen', 2013, 7.5, 92, 'none'),
('The Dark Knight', 2008, 9.0, 152, 'none'),
('The Lion King', 1994, 8.5, 164, 'none'),
('The Dark Knight Rises', 2012, 8.5, 164, 'none'),
('Interstellar', 2014, 8.6, 169, 'none');

-- --------------------------------------------------------
-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE IF NOT EXISTS `genre` (
  `title` varchar(30) NOT NULL,
  `release_year` int NOT NULL,
  `genre` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`title`, `release_year`, `genre`)
    ON UPDATE CASCADE,
  FOREIGN KEY (`title`) REFERENCES movie(`title`)
    ON UPDATE CASCADE,
  FOREIGN KEY (`release_year`) REFERENCES movie(`release_year`
    ON UPDATE CASCADE)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`title`, `release_year`, `genre`) VALUES
('Logan', 2017, 'action'),
('Logan', 2017, 'drama'),
('Logan', 2017, 'sci-fi'),
('Logan', 2017, 'thriller'),
('Arrival', 2016, 'drama'), 
('Arrival', 2016, 'mystery'),
('Arrival', 2016, 'sci-fi'),
('Arrival', 2016, 'thriller'),
('Moana', 2016, 'animation'),
('Moana', 2016, 'adventure'),
('Moana', 2016, 'comedy'),
('Moana', 2016, 'family'),
('Moana', 2016, 'fantasy'),
('Moana', 2016, 'musical'),
('The Shawshank Redemption', 1994, 'crime'),
('The Shawshank Redemption', 1994, 'drama'),
('Frozen', 2013, 'animation'),
('Frozen', 2013, 'adventure'),
('Frozen', 2013, 'comedy'),
('Frozen', 2013, 'family'),
('Frozen', 2013, 'fantasy'),
('Frozen', 2013, 'musical'),
('The Dark Knight', 2008, 'action'),
('The Dark Knight', 2008, 'crime'),
('The Dark Knight', 2008, 'drama'),
('The Dark Knight', 2008, 'thriller'),
('The Lion King', 1994, 'animation'),
('The Lion King', 1994, 'adventure'),
('The Lion King', 1994, 'drama'),
('The Lion King', 1994, 'family'),
('The Lion King', 1994, 'musical'),
('The Dark Knight Rises', 2012, 'action'),
('The Dark Knight Rises', 2012, 'thriller'),
('Interstellar', 2014, 'adventure'),
('Interstellar', 2014, 'drama'),
('Interstellar', 2014, 'sci-fi');


-- --------------------------------------------------------

--
-- Table structure for table `movie_maker`
--

CREATE TABLE IF NOT EXISTS `movie_maker` (
  `id` int NOT NULL CHECK (id>=1),
  `fname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL, 
  `birth_date_yyyy-mm-dd` DATE,
  `death_date_yyyy-mm-dd` DATE,
  `age` int,
  `country` varchar(50),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `movie_maker`
--

INSERT INTO `movie_maker` (`id`, `fname`,`lname`, `birth_date_yyyy-mm-dd`, `death_date_yyyy-mm-dd`, `age`, `country`) VALUES
(1, 'Angelina', 'Jolie','1975-06-04',NULL,NULL,'USA'),
(2, 'Hugh', 'Jackman', '1968-10-12',NULL,NULL, 'AU'),
(3,'Patrick', 'Stewart','1940-07-13',NULL,NULL,'UK'),
(4, 'Amy', 'Adams', '1974-08-20',NULL,NULL, 'IT'),
(5, 'Dwayne', 'Johnson', '1972-05-02',NULL,NULL,'USA'),
(6, 'Kristen', 'Bell','1980-07-18',NULL,NULL,'USA'),
(7, 'Morgan', 'Freeman','1937-06-01',NULL,NULL,'USA'),
(8, 'Matt', 'Damon','1970-10-08',NULL,NULL,'USA'),
(9, 'Christian', 'Bale','1974-01-30',NULL,NULL,'UK'),
(10, 'Heath', 'Ledger','1979-04-04',NULL,NULL,'AU'),
(11, 'Ellen', 'Burstyn','1932-12-07',NULL,NULL,'USA'),
(12, 'Matthew', 'McConaughey','1969-11-04',NULL,NULL,'USA'),
(13, 'Chris', 'Buck','1960-00-00',NULL,NULL,'USA'),
(14, 'Jennifer', 'Lee','1971-00-00',NULL,NULL,'USA'),
(15, 'Christopher', 'Nolan','1970-05-30',NULL,NULL,'UK'),
(16, 'Roger', 'Allers','1949-00-00',NULL,NULL,'USA'),
(17, 'Rob', 'Minkoff','1962-08-11',NULL,NULL,'USA'),
(18, 'Jonathan', 'Roberts','1956-05-10',NULL,NULL,'USA'),
(19, 'Eric', 'Heisserer','1970-00-00',NULL,NULL,'USA'),
(20, 'Jóhann', 'Jóhannsson','1969-09-19',NULL,NULL,'IS'),
(21, 'Hans', 'Zimmer', '1957-09-12',NULL,NULL,'FRG'),
(22, 'Thomas', 'Newman','1955-10-20',NULL,NULL, 'USA');

-- --------------------------------------------------------


--
-- Table structure for table ‘acts’
--

CREATE TABLE IF NOT EXISTS `acts` (
 `title` varchar(50) NOT NULL,
 `release_year`  int NOT NULL,
 `id` int NOT NULL,
 `roleName` varchar(30),
 `type` ENUM('Lead', 'Secondary', 'Tertiary', 'Extra'),
  PRIMARY KEY (`title`, `release_year`, `id`),
  FOREIGN KEY (`title`) REFERENCES movie(`title`)
    ON UPDATE CASCADE,
  FOREIGN KEY (`release_year`) REFERENCES movie(`release_year`)
    ON UPDATE CASCADE,
  FOREIGN KEY (`id`) REFERENCES movie_maker(`id`)
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data into ‘acts’
--
-- ---------------------------------------------------------
INSERT INTO `acts` (`title`, `release_year`, `id`, `roleName`, `type`)
VALUES
('Logan', 2017, 2, 'James Howlett/Logan/Wolverine', 'Lead'),
('The Dark Knight', 2018, 7, 'Lucius Fox', 'Secondary'),
('The Dark Knight Rises', 2012, 7, 'Lucius Fox', 'Secondary'),
('Interstellar', 2014, 12, 'Joseph “Coop” Cooper', 'Lead'),
('Frozen', 2013, 6, 'Anna, the 18-year-old', 'Lead');
-- ----------------------------------------------------------

--
-- Constraints for table 'directs'
--

CREATE TABLE IF NOT EXISTS `directs` (
`title` varchar(50) NOT NULL,
`release_year` int NOT NULL,
`id` int NOT NULL, 
PRIMARY KEY(`title`, `release_year`, `id`),
FOREIGN KEY (`title`) REFERENCES movie(`title`)
    ON UPDATE CASCADE,
FOREIGN KEY (`release_year`) REFERENCES movie(`release_year`)
    ON UPDATE CASCADE,
FOREIGN KEY (`id`) REFERENCES movie_maker(`id`)
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data into 'directs'
--
-- -----------------------------------------------------
INSERT INTO `directs` (`title`, `release_year`, `id`)
VALUES
('Frozen', 2013, 13),
('The Dark Knight', 2008, 15),
('The Dark Knight Rises', 2012, 15),
('Interstellar', 2014, 15) ;
-- -----------------------------------------------------

--
-- Constraints for table 'writes'
--

CREATE TABLE IF NOT EXISTS `writes` (
`title` varchar(50) NOT NULL,
`release_year` year NOT NULL,
`id` int NOT NULL, 
PRIMARY KEY(`title`, `release_year`, `id`),
FOREIGN KEY (`title`) REFERENCES movie(`title`)
    ON UPDATE CASCADE,
FOREIGN KEY (`release_year`) REFERENCES movie(`release_year`)
    ON UPDATE CASCADE,
FOREIGN KEY (`id`) REFERENCES movie_maker(`id`)
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data into 'writes'
--
-- -----------------------------------------------------
INSERT INTO `writes` (`title`, `release_year`, `ID`) VALUES
('Frozen', 2013, 14),
('Interstellar', 2014, 15),
('The Dark Knight', 2008, 15),
('The Lion King',1994, 18),
('Arrival', 2016, 19);
-- -----------------------------------------------------


--
-- Constraints for table 'scores'
--

CREATE TABLE IF NOT EXISTS `scores` (
`title` varchar(50) NOT NULL,
`release_year` year NOT NULL,
`id` int NOT NULL, 
`disks` int,
`tracks` int,
PRIMARY KEY(`title`, `release_year`, `id`),
FOREIGN KEY (`title`) REFERENCES movie(`title`)
    ON UPDATE CASCADE,
FOREIGN KEY (`release_year`) REFERENCES movie(`release_year`)
    ON UPDATE CASCADE,
FOREIGN KEY (`id`) REFERENCES movie_maker(`id`)
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data into 'scores'
--
-- -----------------------------------------------------
INSERT INTO `scores` (`title`, `release_year`, `id`, `disks`, `tracks`)
VALUES
('Arrival', 2016, 20, 01, 20),
('Interstellar', 2014, 21, 01, 16),
('The Dark Knight', 2008, 21, 01, 14),
('The Shawshank Redemption',1994, 22, 01, 21),
('The Dark Knight Rises', 2012, 21, 01, 18);
-- -----------------------------------------------------


--
-- Constraints for table 'produces'
--

CREATE TABLE IF NOT EXISTS `produces` (
`title` varchar(50) NOT NULL,
`release_year` year NOT NULL,
`id` int NOT NULL, 
PRIMARY KEY(`title`, `release_year`, `id`),
FOREIGN KEY (`title`) REFERENCES movie(`title`)
    ON UPDATE CASCADE,
FOREIGN KEY (`release_year`) REFERENCES movie(`release_year`)
    ON UPDATE CASCADE,
FOREIGN KEY (`id`) REFERENCES movie_maker(`id`)
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data into 'produces'
--
-- -----------------------------------------------------
INSERT INTO `produces` (`title`, `release_year`, `id`)
VALUES
('Maleficent', 2014, 1),
('X-Men Origins: Wolverine', 2009, 2),
('Star Trek: Insurrection', 1998, 3),
('Baywatch',2017, 5),
('Gold', 2016, 12);
-- -----------------------------------------------------

--
-- Constraints for table 'subbed'
--

CREATE TABLE IF NOT EXISTS `subbed` (
`title` varchar(50) NOT NULL,
`release_year` year NOT NULL,
`language` varchar(50) NOT NULL,
PRIMARY KEY(`title`, `release_year`, `language`),
FOREIGN KEY (`title`) REFERENCES movie(`title`)
    ON UPDATE CASCADE,
FOREIGN KEY (`release_year`) REFERENCES movie(`release_year`)
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data into 'subbed'
--
-- -----------------------------------------------------
INSERT INTO `subbed` (`title`, `release_year`, `language`) VALUES
('Frozen', 2013, 'English'),
('Frozen', 2013, 'French'),
('Frozen', 2013, 'German'),
('Frozen',2013, 'Dutch'),
('Frozen', 2013, 'Italian');
-- -----------------------------------------------------



--
-- Constraints for table 'dubbed'
--

CREATE TABLE IF NOT EXISTS `dubbed` (
`title` varchar(50) NOT NULL,
`release_year` year NOT NULL,
`language` varchar(50) NOT NULL,
PRIMARY KEY(`title`, `release_year`, `language`),
FOREIGN KEY (`title`) REFERENCES movie(`title`)
    ON UPDATE CASCADE,
FOREIGN KEY (`release_year`) REFERENCES movie(`release_year`)
    ON UPDATE CASCADE                          
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data into 'dubbed'
--
-- -----------------------------------------------------
INSERT INTO `dubbed` (`title`, `release_year`, `language`)
VALUES
('Frozen', 2013, 'English'),
('Frozen', 2013, 'French'),
('Frozen', 2013, 'German'),
('Frozen', 2013, 'Dutch'),
('Frozen', 2013, 'Italian');
-- -----------------------------------------------------
