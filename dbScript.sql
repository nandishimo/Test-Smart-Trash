DROP TABLE IF EXISTS userroles;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS roles;

-- Table structure for `users`

CREATE TABLE users(
    user_id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (user_id)
)ENGINE=InnoDB;
ALTER TABLE users AUTO_INCREMENT=11;

-- Table structure for `roles`

CREATE TABLE roles (
    role_id INT AUTO_INCREMENT,
    role_name VARCHAR(20) NOT NULL,
    role_description varchar(40),
    role_rank INT NOT NULL,
    CHECK (role_rank <= 10),
    PRIMARY KEY (role_id)
)ENGINE=InnoDB;

-- Table structure for `userroles`

CREATE TABLE userroles(
    user_id INT NOT NULL,
    role_id INT DEFAULT 4,
    PRIMARY KEY (user_id,role_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (role_id) REFERENCES roles(role_id)
) ENGINE=InnoDB;

INSERT INTO roles (role_name, role_description, role_rank) VALUES
('root', 'root access', 0),
('administrator', 'site administator', 2),
('moderator', 'content moderator', 3),
('user', 'regular user', 10);

INSERT INTO users (username, password) VALUES ('rootuser','$2y$10$FT2uCTknvJ79wnKZXiEHVeI3/3aQlWF1cTesN18xQsXCoSNMeNwDe'); -- password is: testpw1234
INSERT INTO userroles (user_id, role_id) VALUES (LAST_INSERT_ID(),1);
INSERT INTO users (username, password) VALUES ('administrator','$2y$10$JnechEiorvE/T2i3avKcDOWvdn5zV49vx2bPYW.mfLq6Xp4zFwYFS'); -- password is: password
INSERT INTO userroles (user_id, role_id) VALUES (LAST_INSERT_ID(),2);
INSERT INTO users (username, password) VALUES ('moderator','$2y$10$dS/.UHz8RL9njrlb2bkbFuUt3yBAoOCj4OFQlemYrjvtUwD9DTEkK'); -- password is: moderator
INSERT INTO userroles (user_id, role_id) VALUES (LAST_INSERT_ID(),3);
INSERT INTO users (username, password) VALUES ('testuser','$2y$10$ngjwyeA8J.4bKCLw5ZMh4O6AAGtcMIHroZNGf7dNDZWqYZchN/QZ2'); -- password is: test1234
INSERT INTO userroles (user_id, role_id) VALUES (LAST_INSERT_ID(),4);