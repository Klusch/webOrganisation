CREATE TABLE cars (
    id            INTEGER AUTO_INCREMENT,
    name          VARCHAR(100) NOT NULL,    
    hsn           VARCHAR(5),
    tsn           VARCHAR(5),
    modified      DATETIME,
    created       DATETIME,
    PRIMARY KEY (id)
) CHARSET=utf8;

CREATE TABLE tire_types (
    id            INTEGER AUTO_INCREMENT,
    name          VARCHAR(100) NOT NULL,    
    modified      DATETIME,
    created       DATETIME,
    PRIMARY KEY (id),
    UNIQUE (name)
) CHARSET=utf8;

CREATE TABLE tires (
    id            INTEGER AUTO_INCREMENT,
    car_id        INTEGER,
    brand         VARCHAR(200) NOT NULL,    
    produced_at   DATETIME,
    profile1      DECIMAL(2,1),
    profile2      DECIMAL(2,1),
    profile3      DECIMAL(2,1),
    profile4      DECIMAL(2,1),
    modified      DATETIME,
    created       DATETIME,
    PRIMARY KEY (id),
    FOREIGN KEY(car_id) REFERENCES cars(id)
) CHARSET=utf8;

-- lnk_tires__tire_types
CREATE TABLE tires_tire_types (
    id            INTEGER AUTO_INCREMENT,
    tire_id       INTEGER,
    tire_type_id  INTEGER,
    PRIMARY KEY (id),
    FOREIGN KEY(tire_id) REFERENCES tires(id),
    FOREIGN KEY(tire_type_id) REFERENCES tire_types(id)
) CHARSET=utf8;

CREATE TABLE shops (
    id            INTEGER AUTO_INCREMENT,
    name          VARCHAR(100) NOT NULL,    
    modified      DATETIME,
    created       DATETIME,
    PRIMARY KEY (id),
    UNIQUE (name)
) CHARSET=utf8;

-- ALTER TABLE troubleshootings DROP FOREIGN KEY troubleshootings_ibfk_1;
-- ALTER TABLE troubleshootings DROP COLUMN utility_id;
CREATE TABLE troubleshootings (
    id            INTEGER AUTO_INCREMENT,
    description   VARCHAR(255) NOT NULL,    
    modified      DATETIME,
    created       DATETIME,
    PRIMARY KEY (id)
) CHARSET=utf8;

-- ALTER TABLE utilities ADD COLUMN troubleshooting_id INTEGER;
-- ALTER TABLE utilities ADD CONSTRAINT FOREIGN KEY(troubleshooting_id) REFERENCES troubleshootings(id);
CREATE TABLE utilities (
    id            INTEGER AUTO_INCREMENT,
    name          VARCHAR(100) NOT NULL,
    shop_id       INTEGER,
    troubleshooting_id INTEGER,
    price         DECIMAL(4,2),
    ordered       DATETIME,
    delivered     DATETIME,
    modified      DATETIME,
    created       DATETIME,
    PRIMARY KEY (id),
    UNIQUE (name),
    FOREIGN KEY(shop_id) REFERENCES shops(id),
    FOREIGN KEY(troubleshooting_id) REFERENCES troubleshootings(id)
) CHARSET=utf8;

CREATE TABLE problem_locations (
    id            INTEGER AUTO_INCREMENT,
    name          VARCHAR(100) NOT NULL,    
    modified      DATETIME,
    created       DATETIME,
    PRIMARY KEY (id),
    UNIQUE (name)
) CHARSET=utf8;

CREATE TABLE colors (
    id            INTEGER AUTO_INCREMENT,
    name          VARCHAR(255) NOT NULL,
    red           INTEGER,
    green         INTEGER,
    blue          INTEGER,
    modified      DATETIME,
    created       DATETIME,
    PRIMARY KEY (id),
    UNIQUE (name),
    UNIQUE (red, green, blue)
) CHARSET=utf8;

CREATE TABLE priorities (
    id            INTEGER AUTO_INCREMENT,
    name          VARCHAR(100) NOT NULL,
    color_id      INTEGER,
    PRIMARY KEY (id),
    UNIQUE (name),
    FOREIGN KEY(color_id) REFERENCES colors(id)
) CHARSET=utf8;

CREATE TABLE problems (
    id            INTEGER AUTO_INCREMENT,
    description   VARCHAR(255) NOT NULL,
    problem_location_id   INTEGER,
    priority_id   INTEGER,
    troubleshooting_id    INTEGER,
    solved        TINYINT(1),
    PRIMARY KEY (id),
    FOREIGN KEY(problem_location_id) REFERENCES problem_locations(id),
    FOREIGN KEY(priority_id) REFERENCES priorities(id),
    FOREIGN KEY(troubleshooting_id) REFERENCES troubleshootings(id)
) CHARSET=utf8;

-- lnk_cars__problems
CREATE TABLE cars_problems (
    id            INTEGER AUTO_INCREMENT,
    car_id        INTEGER,
    problem_id    INTEGER,
    PRIMARY KEY (id),
    FOREIGN KEY(car_id) REFERENCES cars(id),
    FOREIGN KEY(problem_id) REFERENCES problems(id)
) CHARSET=utf8;

CREATE TABLE fittings (
    id            INTEGER AUTO_INCREMENT,
    car_id        INTEGER,    
    name          VARCHAR(255),
    description   VARCHAR(255),
    modified      DATETIME,
    created       DATETIME,
    PRIMARY KEY (id),
    FOREIGN KEY(car_id) REFERENCES cars(id)
) CHARSET=utf8;