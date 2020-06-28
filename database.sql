CREATE TABLE users(
id INT (255) auto_increment NOT NULL,
name    varchar(100),
surname varchar(200),
nickname    varchar(100),
email   varchar(255),
role    varchar(20),
description TEXT,
password    varchar(255),
image   varchar(255),
created_at  datetime,
updated_at  datetime,
remember_token  varchar(255),
CONSTRAINT  pk_users PRIMARY KEY(id)

)ENGINE=InnoDb;

CREATE TABLE images(
id INT auto_increment NOT NULL,
user_id INT,
description TEXT,
image_path varchar(255),
created_at  datetime,
updated_at  datetime,
CONSTRAINT pk_images PRIMARY KEY(id),
CONSTRAINT fk_images_users FOREIGN KEY(user_id) REFERENCES users(id)

)ENGINE=InnoDb;

CREATE TABLE comments(
    id INT auto_increment NOT NULL,
    user_id INT,
    image_id INT,
    content text,
    created_at  datetime,
    updated_at  datetime,
    CONSTRAINT pk_comments PRIMARY KEY(id),
    CONSTRAINT fk_comments_users FOREIGN KEY(user_id) REFERENCES users(id),
    CONSTRAINT fk_comments_images FOREIGN KEY(image_id) REFERENCES images(id)

    
)ENGINE=Innodb;

CREATE TABLE likes(
    id INT auto_increment NOT NULL,
    user_id INT,
    image_id INT,
    comment_id INT,
    created_at  datetime,
    updated_at  datetime,
    CONSTRAINT pk_likes PRIMARY KEY(id),
    CONSTRAINT fk_likes_users FOREIGN KEY(user_id) REFERENCES users(id),
    CONSTRAINT fk_likes_images FOREIGN KEY(image_id) REFERENCES images(id),
    CONSTRAINT fk_likes_comments FOREIGN KEY(comment_id) REFERENCES comments(id)
   
)ENGINE=Innodb;

CREATE TABLE likes(
    id INT auto_increment NOT NULL,
    user_id INT,
    image_id INT,
    comment_id INT,
    created_at  datetime,
    updated_at  datetime,
    CONSTRAINT pk_likes PRIMARY KEY(id),
    CONSTRAINT fk_likes_users FOREIGN KEY(user_id) REFERENCES users(id),
    CONSTRAINT fk_likes_images FOREIGN KEY(image_id) REFERENCES images(id),
    CONSTRAINT fk_likes_comments FOREIGN KEY(comment_id) REFERENCES comments(id)
   
)ENGINE=Innodb;


CREATE TABLE followers(
    id INT NOT NULL auto_increment,
    user_id INT, 
    followers INT,
    created_at  datetime,
    updated_at  datetime,
    CONSTRAINT pk_followers PRIMARY KEY(id),
    CONSTRAINT fk_followers_users FOREIGN KEY(user_id) REFERENCES users(id)
    
)ENGINE=Innodb;

