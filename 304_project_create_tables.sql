DROP TABLE TAG_RECORD;
DROP TABLE TAG_VOTE;
DROP TABLE TAG_COMMENT;
DROP TABLE TAG_MANY_IMAGE;
DROP TABLE TAG_IMAGE;
DROP TABLE TAG;
DROP TABLE TAG_USER;

DROP SEQUENCE TAG_SEQ;
DROP SEQUENCE IMG_SEQ;
DROP SEQUENCE COMMENT_SEQ;
DROP SEQUENCE VOTE_SEQ;
DROP SEQUENCE RECORD_SEQ;

 
CREATE TABLE TAG_USER (user_name varchar2(30) NOT NULL, user_type varchar2(30) not null, password varchar2(30) NOT NULL,
	CONSTRAINT user_pk PRIMARY KEY (user_name), CHECK(user_type IN ('admin', 'user')));

CREATE TABLE TAG(tag_id numeric(10), tag_value varchar2(30) NOT NULL,
CONSTRAINT tag_pk PRIMARY KEY (tag_id));

CREATE SEQUENCE TAG_SEQ
	start with 11
	increment by 1
	nomaxvalue;
	
CREATE TABLE TAG_IMAGE(image_id numeric(10), user_name varchar2(30) NOT NULL, image_link varchar2(30) NOT NULL, caption varchar2(30), rating numeric(10) default 0  not null, view_no numeric(10) default 0  not null, upload_date timestamp(6) NOT NULL,
	CONSTRAINT image_pk PRIMARY KEY (image_id),
	CONSTRAINT user_uploaded_fk FOREIGN KEY (user_name) REFERENCES tag_user(user_name),
	CHECK (view_no >= 0));

CREATE SEQUENCE IMG_SEQ
	start with 7
	increment by 1
	nomaxvalue;

CREATE TABLE TAG_MANY_IMAGE(image_id numeric(10) 
REFERENCES tag_image(image_id) on delete cascade, tag_id numeric(10) REFERENCES tag(tag_id), 
	CONSTRAINT tag_image_comp_pk PRIMARY KEY (image_id, tag_id)); 

--CREATE TABLE TAG_COMMENT (comment_id numeric (10), user_name varchar2(30) NOT NULL, image_id numeric(10) NOT NULL, user_comment varchar2(255), comment_date timestamp(6) NOT NULL, comment_rating numeric(10) default 0 not null, 

CREATE TABLE TAG_COMMENT (comment_id numeric (10), user_name varchar2(30) NOT NULL, image_id numeric(10) NOT NULL, user_comment varchar2(255), comment_date timestamp(6) NOT NULL, 
	CONSTRAINT comment_pk PRIMARY KEY (comment_id),
	CONSTRAINT image_comment_fk FOREIGN KEY (image_id) 
REFERENCES tag_image(image_id) on delete cascade,
	CONSTRAINT user_comment_fk FOREIGN KEY (user_name) 
REFERENCES tag_user(user_name));

CREATE SEQUENCE COMMENT_SEQ
	start with 8 
	increment by 1
	nomaxvalue;

CREATE TABLE TAG_VOTE(vote_id numeric(10), vote numeric(10), user_name varchar2(30) NOT NULL, image_id numeric(10) NOT NULL,
	CONSTRAINT vote_pk PRIMARY KEY (vote_id),
	CONSTRAINT user_vote_fk FOREIGN KEY (user_name) REFERENCES tag_user(user_name),
	CONSTRAINT image_vote_fk FOREIGN KEY (image_id) REFERENCES tag_image(image_id) on delete cascade,
	CONSTRAINT unique_user_vote UNIQUE (user_name, image_id), 
	CHECK (vote in (-1, 1)));

CREATE SEQUENCE VOTE_SEQ
	start with 16
	increment by 1
	nomaxvalue;

CREATE TABLE TAG_RECORD(record_id numeric(10), rank_type varchar2(30) NOT NULL, rank_value varchar2(30) NOT NULL, 
	CONSTRAINT record_pk PRIMARY KEY (record_id));

CREATE SEQUENCE RECORD_SEQ
	start with 7
	increment by 1
	nomaxvalue;

/*
----------------------------------------------------------------------------------------
									INSERTED TUPLES
----------------------------------------------------------------------------------------
*/
INSERT INTO TAG_USER VALUES ('nicole','admin','changeme');
INSERT INTO TAG_USER VALUES ('victoria','admin','changeme');
INSERT INTO TAG_USER VALUES ('kenny','admin','changeme');
INSERT INTO TAG_USER VALUES ('jodi','admin','changeme');
INSERT INTO TAG_USER VALUES ('fluffernutter','user','PBandFLUFF');

INSERT INTO TAG VALUES (1, 'First tag');
INSERT INTO TAG VALUES (2, 'Peanut butter');
INSERT INTO TAG VALUES (3, 'Marshmallow fluff');
INSERT INTO TAG VALUES (4, 'Fluffernutter');
INSERT INTO TAG VALUES (5, 'Cats');
INSERT INTO TAG VALUES (6, 'Cute');
INSERT INTO TAG VALUES (7, 'Ocelot');
INSERT INTO TAG VALUES (8, 'imgur');
INSERT INTO TAG VALUES (9, 'Doctor Who');
INSERT INTO TAG VALUES (10, 'Tardis');

INSERT INTO TAG_IMAGE VALUES (1, 'victoria', 'http://goo.gl/EcaItJ', 'FLUFFERNUTTERS are delicious', '3', 5, '2013-10-01 00:00:00'); 
INSERT INTO TAG_IMAGE VALUES (2, 'jodi', 'http://imgur.com/ppDsu.jpg', 'A baby ocelot', '5', 5, '2013-10-10 17:50:59');  
INSERT INTO TAG_IMAGE VALUES (3, 'victoria', 'http://imgur.com/xbvaWh.jpg', '', '2', 5, '2013-10-13 00:00:00');  
INSERT INTO TAG_IMAGE VALUES (4, 'nicole', 'http://goo.gl/ka8g38', 'Self-cannibalism', '1', 5, '2013-10-18 12:00:00'); 
INSERT INTO TAG_IMAGE VALUES (5, 'nicole', 'http://goo.gl/p0B7Bt', 'Ballmer Peak', '0', 5, '2013-10-20 23:59:59'); 
INSERT INTO TAG_IMAGE VALUES (6, 'kenny', 'http://imgur.com/xbvaWh.jpg', '', '-2', 1, '2013-10-22 00:00:00');  
INSERT INTO TAG_IMAGE (image_id, user_name, image_link, caption, upload_date) VALUES (7, 'kenny', 'http://i.imgur.com/MEupNL5.jpg', '', '2013-10-22 00:00:00');  


INSERT INTO TAG_MANY_IMAGE VALUES (1, 2);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 3);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 4);
INSERT INTO TAG_MANY_IMAGE VALUES (2, 6);
INSERT INTO TAG_MANY_IMAGE VALUES (2, 7);
INSERT INTO TAG_MANY_IMAGE VALUES (2, 8);
INSERT INTO TAG_MANY_IMAGE VALUES (3, 9);
INSERT INTO TAG_MANY_IMAGE VALUES (3, 10);
INSERT INTO TAG_MANY_IMAGE VALUES (4, 6);
INSERT INTO TAG_MANY_IMAGE VALUES (6, 10);

INSERT INTO TAG_COMMENT VALUES (1, 'nicole', 1, 'FIRST', '2013-10-01 00:00:01');
INSERT INTO TAG_COMMENT VALUES (2, 'nicole', 1, 'comment that is unrelated to the fluffs and nuts', '2013-10-01 00:00:01');
INSERT INTO TAG_COMMENT VALUES (3, 'fluffernutter', 1, 'I LOVE FLUFFERNUTTERS! <3', '2013-10-01 00:00:02');
INSERT INTO TAG_COMMENT VALUES (4, 'kenny', 2, 'HE REMEMBERS ME!!!!!', '2013-10-13 00:00:01');
INSERT INTO TAG_COMMENT VALUES (5, 'nicole', 2, 'IT''S SAO KEWT! I WANT ONE.', '2013-10-17 00:00:01');
INSERT INTO TAG_COMMENT VALUES (6, 'nicole', 2, 'This is old. The exact same image was uploaded exactly 9 days ago. Is it possible to report this as a duplicate?', '2013-10-22 00:00:01');
INSERT INTO TAG_COMMENT (comment_id, user_name, image_id, user_comment, comment_date) VALUES (7, 'nicole', 2, 'This is old. The exact same image was uploaded exactly 9 days ago. Is it possible to report this as a duplicate?', '2013-10-22 00:00:01');

INSERT INTO TAG_VOTE VALUES (1, '1', 'nicole', 1);
INSERT INTO TAG_VOTE VALUES (2, '1', 'victoria', 1);
INSERT INTO TAG_VOTE VALUES (3, '-1', 'kenny', 1);
INSERT INTO TAG_VOTE VALUES (4, '1', 'jodi', 1);
INSERT INTO TAG_VOTE VALUES (5, '1', 'fluffernutter', 1);
INSERT INTO TAG_VOTE VALUES (6, '1', 'nicole', 2);
INSERT INTO TAG_VOTE VALUES (7, '1', 'victoria', 2);
INSERT INTO TAG_VOTE VALUES (8, '1', 'kenny', 2);
INSERT INTO TAG_VOTE VALUES (9, '1', 'jodi', 2);
INSERT INTO TAG_VOTE VALUES (10, '1', 'fluffernutter', 2);
INSERT INTO TAG_VOTE VALUES (11, '1', 'victoria', 3);
INSERT INTO TAG_VOTE VALUES (12, '1', 'kenny', 3);
INSERT INTO TAG_VOTE VALUES (13, '1', 'nicole', 4);
INSERT INTO TAG_VOTE VALUES (14, '-1', 'nicole', 6);
INSERT INTO TAG_VOTE VALUES (15, '-1', 'victoria', 6);

INSERT INTO TAG_RECORD  VALUES (1, 'best', '1');
INSERT INTO TAG_RECORD  VALUES (2, 'best', '2');
INSERT INTO TAG_RECORD  VALUES (3, 'best', '3');
INSERT INTO TAG_RECORD  VALUES (4, 'best', '4');
INSERT INTO TAG_RECORD  VALUES (5, 'best', '5');
INSERT INTO TAG_RECORD  VALUES (6, 'best', '6');

-- don't forget this, or nothing will be saved to the database!
commit;



