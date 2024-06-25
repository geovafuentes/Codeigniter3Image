CREATE TABLE items (
  id int NOT NULL,
  name varchar(255) NOT NULL,
  description text NOT NULL,
  image varchar(255) NOT NULL,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)

CREATE TABLE users (
  id int NOT NULL,
  username varchar(100) NOT NULL,
  password varchar(250) NOT NULL
)