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
	start with 38
	increment by 1
	nomaxvalue;
	
CREATE TABLE TAG_IMAGE(image_id numeric(10), user_name varchar2(30) NOT NULL, image_link varchar2(30) NOT NULL, caption varchar2(100), rating numeric(10) default 0  not null, view_no numeric(10) default 0  not null, upload_date timestamp(6) NOT NULL,
	CONSTRAINT image_pk PRIMARY KEY (image_id),
	CONSTRAINT user_uploaded_fk FOREIGN KEY (user_name) REFERENCES tag_user(user_name),
	CHECK (view_no >= 0));

CREATE SEQUENCE IMG_SEQ
	start with 54
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
	start with 55 
	increment by 1
	nomaxvalue;

CREATE TABLE TAG_VOTE(vote_id numeric(10), vote numeric(10), user_name varchar2(30) NOT NULL, image_id numeric(10) NOT NULL,
	CONSTRAINT vote_pk PRIMARY KEY (vote_id),
	CONSTRAINT user_vote_fk FOREIGN KEY (user_name) REFERENCES tag_user(user_name),
	CONSTRAINT image_vote_fk FOREIGN KEY (image_id) REFERENCES tag_image(image_id) on delete cascade,
	CONSTRAINT unique_user_vote UNIQUE (user_name, image_id), 
	CHECK (vote in (-1, 1)));

CREATE SEQUENCE VOTE_SEQ
	start with 156
	increment by 1
	nomaxvalue;

CREATE TABLE TAG_RECORD(record_id numeric(10), rank_type varchar2(30) NOT NULL, rank_value varchar2(30) NOT NULL, report_date timestamp(6) NOT NULL,
	CONSTRAINT record_pk PRIMARY KEY (record_id));

CREATE SEQUENCE RECORD_SEQ
	start with 11
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
INSERT INTO TAG_USER VALUES ('ChengGuevara','user','password');
INSERT INTO TAG_USER VALUES ('newuser','user','password');
INSERT INTO TAG_USER VALUES ('username','user','password');
INSERT INTO TAG_USER VALUES ('password','user','password');
INSERT INTO TAG_USER VALUES ('tagteam','user','password');
INSERT INTO TAG_USER VALUES ('thedoctor','user','password');

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
INSERT INTO TAG VALUES (11, 'Doge');
INSERT INTO TAG VALUES (12, 'Spoilers');
INSERT INTO TAG VALUES (13, 'Archer');
INSERT INTO TAG VALUES (14, 'Arrested Development');
INSERT INTO TAG VALUES (15, 'TV Shows');
INSERT INTO TAG VALUES (16, 'Politics');
INSERT INTO TAG VALUES (17, 'Food');
INSERT INTO TAG VALUES (18, 'Controversial');
INSERT INTO TAG VALUES (19, 'Meme');
INSERT INTO TAG VALUES (20, 'Games');
INSERT INTO TAG VALUES (21, 'Computer Science');
INSERT INTO TAG VALUES (22, 'UBC');
INSERT INTO TAG VALUES (23, 'Movie');
INSERT INTO TAG VALUES (24, 'Comics');
INSERT INTO TAG VALUES (25, 'Breaking Bad');
INSERT INTO TAG VALUES (26, 'Music');
INSERT INTO TAG VALUES (27, 'IT Crowd');
INSERT INTO TAG VALUES (28, 'Sherlock');
INSERT INTO TAG VALUES (29, '30 rock');
INSERT INTO TAG VALUES (30, 'Anchorman');
INSERT INTO TAG VALUES (31, 'Bob`s Burgers');
INSERT INTO TAG VALUES (32, 'Sunny');
INSERT INTO TAG VALUES (33, 'Basterds');
INSERT INTO TAG VALUES (34, 'Office');
INSERT INTO TAG VALUES (35, 'DanIRL');
INSERT INTO TAG VALUES (36, '90s');
INSERT INTO TAG VALUES (37, 'cat');

INSERT INTO TAG_IMAGE VALUES (1, 'victoria', 'http://goo.gl/EcaItJ', 'FLUFFERNUTTERS are delicious', '5', 1, '2013-11-25 00:00:00'); 
INSERT INTO TAG_IMAGE VALUES (2, 'jodi', 'http://imgur.com/ppDsu.jpg', 'A baby ocelot', '5', 5, '2013-10-10 17:50:59');  
INSERT INTO TAG_IMAGE VALUES (3, 'victoria', 'http://imgur.com/xbvaWh.jpg', '', '2', 5, '2013-10-13 00:00:00');  
INSERT INTO TAG_IMAGE VALUES (4, 'nicole', 'http://goo.gl/ka8g38', 'Self-cannibalism', '1', 5, '2013-10-18 12:00:00'); 
INSERT INTO TAG_IMAGE VALUES (5, 'nicole', 'http://goo.gl/p0B7Bt', 'Ballmer Peak', '0', 5, '2013-10-20 23:59:59'); 
INSERT INTO TAG_IMAGE VALUES (6, 'kenny', 'http://imgur.com/xbvaWh.jpg', '', '-2', 3, '2013-10-22 00:00:00');  
INSERT INTO TAG_IMAGE (image_id, user_name, image_link, caption, upload_date) VALUES (7, 'kenny', 'http://i.imgur.com/MEupNL5.jpg', '', '2013-10-22 00:00:00');  


-- image template
--INSERT INTO TAG_IMAGE VALUES (7, 'kenny', 'link', 'caption', 'rating', viewnum, '2013-11-25 00:00:00'); 
-- CHANGE DATES LATER, vary users

INSERT INTO TAG_IMAGE VALUES (8, 'kenny', 'http://i.imgur.com/PSXkC0Q.jpg', 'Much Doge.  Many cutes.  Wow.', '5', 6, '2013-09-01 11:00:00'); 
INSERT INTO TAG_IMAGE VALUES (9, 'jodi', 'http://i.imgur.com/Cp9gZco.gif', 'Spoilers', '4', 5, '2013-09-02 12:00:00'); 
INSERT INTO TAG_IMAGE VALUES (10, 'kenny', 'http://i.imgur.com/BHaDbCq.jpg', 'To those that litter...', '3', 8, '2013-09-03 00:31:00'); 
INSERT INTO TAG_IMAGE VALUES (11, 'victoria', 'http://i.imgur.com/EmkfMSs.gif', 'I have to use emacs?', '2', 8, '2013-09-04 00:42:00'); 
INSERT INTO TAG_IMAGE VALUES (12, 'kenny', 'http://i.imgur.com/YARnJ7X.jpg', 'Enough in there for you?', '-2', 10, '2013-09-05 00:52:00'); 
INSERT INTO TAG_IMAGE VALUES (13, 'nicole', 'http://i.imgur.com/kFyKOgj.gif', 'End of term deadlines...', '2', 18, '2013-09-06 00:32:00'); 
INSERT INTO TAG_IMAGE VALUES (14, 'jodi', 'http://i.imgur.com/JRplAMd.gif', 'I need this now.', '3', 11, '2013-09-07 00:13:00'); 
INSERT INTO TAG_IMAGE VALUES (15, 'kenny', 'http://i.imgur.com/SG1y84E.png', 'Good Guy Ted Cruz', '4', 13, '2013-09-08 00:16:00'); 
INSERT INTO TAG_IMAGE VALUES (16, 'nicole', 'http://i.imgur.com/1DX3ouA.png', 'Ain`t nobody walk into Mordor', '4', 9, '2013-09-09 08:00:00'); 
INSERT INTO TAG_IMAGE VALUES (17, 'kenny', 'http://i.imgur.com/qD7UuUh.gif', 'Wish I had those moves', '1', 7, '2013-09-10 06:00:00'); 
INSERT INTO TAG_IMAGE VALUES (18, 'jodi', 'http://i.imgur.com/dCXuu99.jpg', 'This doge knows more than me', '2', 11, '2013-09-11 04:00:00'); 
INSERT INTO TAG_IMAGE VALUES (19, 'kenny', 'http://i.imgur.com/sOS2Ic3.jpg', 'Every start of a term', '3', 13, '2013-09-12 11:00:00'); 
INSERT INTO TAG_IMAGE VALUES (20, 'kenny', 'http://i.imgur.com/ahlPnGY.png', 'Found Ryan Lochte`s mentor', '4', 9, '2013-09-17 12:00:00'); 
INSERT INTO TAG_IMAGE VALUES (21, 'victoria', 'http://i.imgur.com/MK4tsnk.jpg', 'The Mark V', '5', 11, '2013-09-19 03:00:00'); 
INSERT INTO TAG_IMAGE VALUES (22, 'nicole', 'http://i.imgur.com/3oFyK2L.gif', 'This will determine the gender distribution of our user base', '2', 14, '2013-09-24 00:30:00'); 
INSERT INTO TAG_IMAGE VALUES (23, 'kenny', 'http://i.imgur.com/LGlz1H4.jpg', '(Computer) SCIENCE!', '1', 11, '2013-09-25 00:42:00'); 
INSERT INTO TAG_IMAGE VALUES (24, 'victoria', 'http://i.imgur.com/uKW0R7h.jpg', 'All I want for Christmas is a Sennheiser HD 800', '2', 16, '2013-09-27 00:52:00'); 
INSERT INTO TAG_IMAGE VALUES (25, 'kenny', 'http://i.imgur.com/TVtGcjW.jpg', 'But...Did you try turning it off and on again?', '3', 18, '2013-09-28 00:32:00'); 
INSERT INTO TAG_IMAGE VALUES (26, 'jodi', 'http://i.imgur.com/SsiD6ql.gif', 'Every single time.', '4', 15, '2013-11-01 09:00:00'); 
INSERT INTO TAG_IMAGE VALUES (27, 'kenny', 'http://i.imgur.com/PPGu7bH.gif', 'I love sports.', '5', 11, '2013-11-03 10:00:00'); 
INSERT INTO TAG_IMAGE VALUES (28, 'victoria', 'http://i.imgur.com/ghjOSEJ.gif', 'While watching 12 years a slave', '6', 15, '2013-11-06 11:00:00'); 
INSERT INTO TAG_IMAGE VALUES (29, 'nicole', 'http://i.imgur.com/XQHLlwv.gif', 'My weekends are so thrilling', '2', 16, '2013-11-01 08:12:00'); 
INSERT INTO TAG_IMAGE VALUES (30, 'kenny', 'http://i.imgur.com/KQn4pqR.gif', 'The thought has crossed my mind', '1', 17, '2013-11-09 11:52:00'); 
INSERT INTO TAG_IMAGE VALUES (31, 'jodi', 'http://i.imgur.com/2eco43V.gif', 'The epitome of eloquence.', '3', 15, '2013-11-10 08:36:00'); 
INSERT INTO TAG_IMAGE VALUES (32, 'kenny', 'http://i.imgur.com/Z0zH6RS.gif', 'ATTN: little sister that wants to go shopping', '4', 11, '2013-11-11 07:52:00'); 
INSERT INTO TAG_IMAGE VALUES (33, 'victoria', 'http://i.imgur.com/FR6np.jpg', 'Hey, let`s hang out somet- Oh. Okay.', '5', 13, '2013-11-13 21:00:00'); 
INSERT INTO TAG_IMAGE VALUES (34, 'kenny', 'http://i.imgur.com/mCwIH.gif', 'Sums it up perfectly', '2', 15, '2013-11-14 16:00:00'); 
INSERT INTO TAG_IMAGE VALUES (35, 'kenny', 'http://i.imgur.com/mqQdZ.jpg', 'Petition for a crossover, anyone?', '5', 8, '2013-11-15 17:00:00'); 
INSERT INTO TAG_IMAGE VALUES (36, 'nicole', 'http://i.imgur.com/qfL8E.gif', 'If only it were that easy', '3', 8, '2013-11-16 18:00:00'); 
INSERT INTO TAG_IMAGE VALUES (37, 'kenny', 'http://i.imgur.com/pXzBXzn.gif', 'Das ist ein BINGO', '4', 10, '2013-11-17 19:00:00'); 
INSERT INTO TAG_IMAGE VALUES (38, 'kenny', 'http://i.imgur.com/G0PZpj4.gif', 'MRW singled out in class', '3', 15, '2013-11-18 20:00:00'); 
INSERT INTO TAG_IMAGE VALUES (39, 'victoria', 'http://i.imgur.com/Z2VNx.jpg', 'Proud to be Canadian', '5', 11, '2013-11-19 22:24:00'); 
INSERT INTO TAG_IMAGE VALUES (40, 'kenny', 'http://i.imgur.com/fMEtxry.jpg', 'Who else is dreading graduation?', '7', 12, '2013-11-20 22:24:00'); 
INSERT INTO TAG_IMAGE VALUES (41, 'jodi', 'http://i.imgur.com/grfpOCM.gif', 'Is your cat making too much noise all the time?', '1', 13, '2013-11-21 12:52:00'); 
INSERT INTO TAG_IMAGE VALUES (42, 'kenny', 'http://i.imgur.com/awreS.gif', 'Final stretch, let`s do this', '3', 13, '2013-11-22 12:53:00'); 
INSERT INTO TAG_IMAGE VALUES (43, 'kenny', 'http://i.imgur.com/DIBT7l7.gif', 'Missing my bus on the weekends', '4', 16, '2013-11-23 13:52:00'); 
INSERT INTO TAG_IMAGE VALUES (44, 'victoria', 'http://i.imgur.com/BTvfPMj.jpg', 'News Team! Assemble!', '2', 16, '2013-11-24 16:24:00'); 
INSERT INTO TAG_IMAGE VALUES (45, 'kenny', 'http://i.imgur.com/bEyK3pe.png', 'I say the stupidest things sometimes.', '3', 7, '2013-11-24 11:52:00'); 
INSERT INTO TAG_IMAGE VALUES (46, 'kenny', 'http://i.imgur.com/eFcaS0O.png', 'This movie is incredible', '5', 9, '2013-11-24 11:55:00'); 
INSERT INTO TAG_IMAGE VALUES (47, 'jodi', 'http://i.imgur.com/tcvks0B.gif', 'Sitting in the back of the bus', '1', 11, '2013-11-24 12:53:00'); 
INSERT INTO TAG_IMAGE VALUES (48, 'kenny', 'http://i.imgur.com/Wz993Pk.gif', 'Homework...why must you be that way.', '3', 11, '2013-11-24 13:55:00'); 
INSERT INTO TAG_IMAGE VALUES (49, 'kenny', 'http://i.imgur.com/lxXBOpC.jpg', 'Bob`s burgers just gets me', '2', 15, '2013-11-24 15:15:00'); 
INSERT INTO TAG_IMAGE VALUES (50, 'nicole', 'http://i.imgur.com/Ksmdg.gif', 'At the gym', '1', 15, '2013-11-24 16:17:00'); 
INSERT INTO TAG_IMAGE VALUES (51, 'kenny', 'http://i.imgur.com/xYuSrKW.jpg', 'Those were the days...', '4', 15, '2013-11-24 18:19:00'); 
INSERT INTO TAG_IMAGE VALUES (52, 'kenny', 'http://i.imgur.com/3WpdbwE.jpg', 'Ain`t nobody got time for that', '0', 15, '2013-11-25 18:20:00'); 
INSERT INTO TAG_IMAGE VALUES (53, 'kenny', 'http://i.imgur.com/ioJs8Uz.jpg', 'Business cat', '0', 15, '2013-11-25 18:25:00'); 


INSERT INTO TAG_MANY_IMAGE VALUES (1, 1);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 2);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 3);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 4);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 5);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 6);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 7);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 8);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 9);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 10);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 11);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 12);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 13);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 14);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 15);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 16);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 17);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 18);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 19);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 20);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 21);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 22);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 23);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 24);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 25);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 26);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 27);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 28);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 29);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 30);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 31);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 32);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 33);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 34);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 35);
INSERT INTO TAG_MANY_IMAGE VALUES (1, 36);
INSERT INTO TAG_MANY_IMAGE VALUES (2, 6);
INSERT INTO TAG_MANY_IMAGE VALUES (2, 7);
INSERT INTO TAG_MANY_IMAGE VALUES (2, 8);
INSERT INTO TAG_MANY_IMAGE VALUES (3, 9);
INSERT INTO TAG_MANY_IMAGE VALUES (3, 10);
INSERT INTO TAG_MANY_IMAGE VALUES (4, 6);
INSERT INTO TAG_MANY_IMAGE VALUES (6, 10);
INSERT INTO TAG_MANY_IMAGE VALUES (8,11);
INSERT INTO TAG_MANY_IMAGE VALUES (9,9);
INSERT INTO TAG_MANY_IMAGE VALUES (10,13);
INSERT INTO TAG_MANY_IMAGE VALUES (11,14);
INSERT INTO TAG_MANY_IMAGE VALUES (12,16);
INSERT INTO TAG_MANY_IMAGE VALUES (13,15);
INSERT INTO TAG_MANY_IMAGE VALUES (14,17);
INSERT INTO TAG_MANY_IMAGE VALUES (15,16);
INSERT INTO TAG_MANY_IMAGE VALUES (16,19);
INSERT INTO TAG_MANY_IMAGE VALUES (17,20);
INSERT INTO TAG_MANY_IMAGE VALUES (18,11);
INSERT INTO TAG_MANY_IMAGE VALUES (18,21);
INSERT INTO TAG_MANY_IMAGE VALUES (19,11);
INSERT INTO TAG_MANY_IMAGE VALUES (20,11);
INSERT INTO TAG_MANY_IMAGE VALUES (21,22);
INSERT INTO TAG_MANY_IMAGE VALUES (22,23);
INSERT INTO TAG_MANY_IMAGE VALUES (22,24);
INSERT INTO TAG_MANY_IMAGE VALUES (23,25);
INSERT INTO TAG_MANY_IMAGE VALUES (24,26);
INSERT INTO TAG_MANY_IMAGE VALUES (25,27);
INSERT INTO TAG_MANY_IMAGE VALUES (26,27);
INSERT INTO TAG_MANY_IMAGE VALUES (27,27);
INSERT INTO TAG_MANY_IMAGE VALUES (28,27);
INSERT INTO TAG_MANY_IMAGE VALUES (29,27);
INSERT INTO TAG_MANY_IMAGE VALUES (30,27);
INSERT INTO TAG_MANY_IMAGE VALUES (31,27);
INSERT INTO TAG_MANY_IMAGE VALUES (32,27);
INSERT INTO TAG_MANY_IMAGE VALUES (33,28);
INSERT INTO TAG_MANY_IMAGE VALUES (34,28);
INSERT INTO TAG_MANY_IMAGE VALUES (35,28);
INSERT INTO TAG_MANY_IMAGE VALUES (35,9);
INSERT INTO TAG_MANY_IMAGE VALUES (36,29);
INSERT INTO TAG_MANY_IMAGE VALUES (37,33);
INSERT INTO TAG_MANY_IMAGE VALUES (38,33);
INSERT INTO TAG_MANY_IMAGE VALUES (39,32);
INSERT INTO TAG_MANY_IMAGE VALUES (40,32);
INSERT INTO TAG_MANY_IMAGE VALUES (41,32);
INSERT INTO TAG_MANY_IMAGE VALUES (42,32);
INSERT INTO TAG_MANY_IMAGE VALUES (43,34);
INSERT INTO TAG_MANY_IMAGE VALUES (44,30);
INSERT INTO TAG_MANY_IMAGE VALUES (45,35);
INSERT INTO TAG_MANY_IMAGE VALUES (46,23);
INSERT INTO TAG_MANY_IMAGE VALUES (47,30);
INSERT INTO TAG_MANY_IMAGE VALUES (48,31);
INSERT INTO TAG_MANY_IMAGE VALUES (49,31);
INSERT INTO TAG_MANY_IMAGE VALUES (50,31);
INSERT INTO TAG_MANY_IMAGE VALUES (51,36);
INSERT INTO TAG_MANY_IMAGE VALUES (52,27);
INSERT INTO TAG_MANY_IMAGE VALUES (53,37);



INSERT INTO TAG_COMMENT VALUES (1, 'nicole', 1, 'FIRST', '2013-11-25 00:00:01');
INSERT INTO TAG_COMMENT VALUES (2, 'nicole', 1, 'comment that is unrelated to the fluffs and nuts', '2013-11-25 00:00:01');
INSERT INTO TAG_COMMENT VALUES (3, 'fluffernutter', 1, 'I LOVE FLUFFERNUTTERS! <3', '2013-11-25 00:00:02');
INSERT INTO TAG_COMMENT VALUES (4, 'kenny', 2, 'HE REMEMBERS ME!!!!!', '2013-10-13 00:00:01');
INSERT INTO TAG_COMMENT VALUES (5, 'nicole', 2, 'IT''S SAO KEWT! I WANT ONE.', '2013-10-17 00:00:01');
INSERT INTO TAG_COMMENT VALUES (6, 'nicole', 2, 'This is old. The exact same image was uploaded exactly 9 days ago. Is it possible to report this as a duplicate?', '2013-10-22 00:00:01');
INSERT INTO TAG_COMMENT (comment_id, user_name, image_id, user_comment, comment_date) VALUES (7, 'nicole', 2, 'This is old. The exact same image was uploaded exactly 9 days ago. Is it possible to report this as a duplicate?', '2013-10-22 00:00:01');

--template
--INSERT INTO TAG_COMMENT VALUES (comment_id, user_name, image_id, user_comment, comment_date)
/* 
Nicole:
	Don't forget to modify the dates here as well Kenny! *Oh dear.  Do I have to make em all after the upload date...  I was just randomly keying those in...*
	If there's time, add a few comments to some of the images so that there isn't just one per image? *did that
	Not all the images need to have comments. Leave some without comments maybe to make it easier on yourself *wish i did that
*/
INSERT INTO TAG_COMMENT VALUES (8, 'jodi', 9, 'Silence will fall.', '2013-11-25 00:00:01');
INSERT INTO TAG_COMMENT VALUES (9, 'kenny', 10, 'This is how you get upvotes', '2013-11-25 00:00:02');
INSERT INTO TAG_COMMENT VALUES (10, 'kenny', 11, 'You COUNTry loving music... text editor.', '2013-11-25 00:00:03');
INSERT INTO TAG_COMMENT VALUES (11, 'victoria', 12, 'It`s okay, he`ll get enough to eat', '2013-11-25 00:00:04');
INSERT INTO TAG_COMMENT VALUES (12, 'kenny', 13, 'Upvote anything Colbert', '2013-11-25 00:00:05');
INSERT INTO TAG_COMMENT VALUES (13, 'nicole', 14, 'If only it were healthy...', '2013-11-25 00:00:06');
INSERT INTO TAG_COMMENT VALUES (14, 'kenny', 15, 'That guy just never gives up', '2013-11-25 00:00:07');
INSERT INTO TAG_COMMENT VALUES (15, 'nicole', 16, 'She was pretty game on Tosh', '2013-11-25 00:00:08');
INSERT INTO TAG_COMMENT VALUES (16, 'kenny', 17, 'NOICE!', '2013-11-25 00:00:11');
INSERT INTO TAG_COMMENT VALUES (17, 'jodi', 18, './doge much', '2013-11-25 00:00:12');
INSERT INTO TAG_COMMENT VALUES (18, 'kenny', 19, 'Not for long.', '2013-11-25 00:00:13');
INSERT INTO TAG_COMMENT VALUES (19, 'victoria', 20, 'They should`ve given the dog a reality show instead...', '2013-11-25 00:00:05');
INSERT INTO TAG_COMMENT VALUES (20, 'kenny', 21, 'I need to take cooler courses.', '2013-11-25 00:00:17');
INSERT INTO TAG_COMMENT VALUES (21, 'nicole', 22, 'Nope.  Hiddleston will prevail regardless of gender.  You know it to be true.', '2013-11-25 00:00:18');
INSERT INTO TAG_COMMENT VALUES (22, 'nicole', 23, 'MUSIC.', '2013-11-25 00:00:19');
INSERT INTO TAG_COMMENT VALUES (23, 'victoria', 24, 'Too bad the open design of it means it`ll always have to stay at home.', '2013-11-25 00:00:22');
INSERT INTO TAG_COMMENT VALUES (24, 'kenny', 25, 'Maurice would make a great doctor', '2013-11-25 00:00:25');
INSERT INTO TAG_COMMENT VALUES (25, 'jodi', 26, 'It`s weird that no one tries that first', '2013-11-25 00:00:01');
INSERT INTO TAG_COMMENT VALUES (26, 'jodi', 27, 'Such a description for tennis would keep me on the edge of my seat', '2013-11-25 00:00:26');
INSERT INTO TAG_COMMENT VALUES (27, 'kenny', 28, 'That movie made me feel uncomfortable.  As it should.', '2013-11-25 00:00:27');
INSERT INTO TAG_COMMENT VALUES (28, 'jodi', 29, 'Did you try turning your weekends off and on again?', '2013-11-25 00:00:28');
INSERT INTO TAG_COMMENT VALUES (29, 'nicole', 30, 'This show just gets me', '2013-11-25 00:00:30');
INSERT INTO TAG_COMMENT VALUES (30, 'kenny', 31, 'Too many people that act like this.', '2013-11-25 00:00:31');
INSERT INTO TAG_COMMENT VALUES (31, 'jodi', 32, ' Fire - exclamation mark - fire - exclamation mark - help me - exclamation mark. 123 Cavendon Road. Looking forward to hearing from you. Yours truly, Maurice Moss.﻿', '2013-11-25 00:00:32');
INSERT INTO TAG_COMMENT VALUES (32, 'kenny', 33, 'That never happens to me', '2013-11-25 00:00:33');
INSERT INTO TAG_COMMENT VALUES (33, 'nicole', 34, ':(', '2013-11-25 00:00:34');
INSERT INTO TAG_COMMENT VALUES (35, 'kenny', 35, 'The two solving mysteries together would make quite the spinoff', '2013-11-25 00:00:35');
INSERT INTO TAG_COMMENT VALUES (36, 'jodi', 37, 'We just say Bingo here.', '2013-11-25 00:00:37');
INSERT INTO TAG_COMMENT VALUES (37, 'kenny', 37, 'BINGOoooo. How fun!', '2013-11-25 00:00:38');
INSERT INTO TAG_COMMENT VALUES (38, 'nicole', 38, 'Who doesn`t want cream with their strudel?', '2013-11-25 00:00:39');
INSERT INTO TAG_COMMENT VALUES (39, 'kenny', 39, 'shots fired.', '2013-11-25 00:00:40');
INSERT INTO TAG_COMMENT VALUES (40, 'jodi', 40, 'The debt doesn`t help either', '2013-11-25 00:00:41');
INSERT INTO TAG_COMMENT VALUES (41, 'kenny', 42, 'Isn`t he on coke in this?', '2013-11-25 00:00:44');
INSERT INTO TAG_COMMENT VALUES (42, 'jodi', 43, 'I feel the same way getting on the bus', '2013-11-25 00:00:45');
INSERT INTO TAG_COMMENT VALUES (43, 'kenny', 44, 'We`re right here, Ron.', '2013-11-25 00:00:46');
INSERT INTO TAG_COMMENT VALUES (44, 'nicole', 45, 'You and me too.  I mean, both.  Blargh.  Blargh?  Blergh.', '2013-11-25 00:00:47');
INSERT INTO TAG_COMMENT VALUES (45, 'kenny', 46, 'Don`t watch it if you want a fun time though', '2013-11-25 00:00:48');
INSERT INTO TAG_COMMENT VALUES (46, 'nicole', 47, 'I LOVE LAMP', '2013-11-25 00:00:50');
INSERT INTO TAG_COMMENT VALUES (47, 'victoria', 48, 'Let`s see your everything is okay face.', '2013-11-25 00:00:51');
INSERT INTO TAG_COMMENT VALUES (48, 'jodi', 49, 'Tina is my soul animal.', '2013-11-25 00:00:53');
INSERT INTO TAG_COMMENT VALUES (49, 'kenny', 50, 'This.  All the time.', '2013-11-25 00:00:55');
INSERT INTO TAG_COMMENT VALUES (50, 'nicole', 41, 'YOUR SO STUPID', '2013-11-25 00:00:56');
INSERT INTO TAG_COMMENT VALUES (51, 'jodi', 8, 'Much Original.  Little contrived.  Amaze.', '2013-11-25 00:00:59');
INSERT INTO TAG_COMMENT VALUES (52, 'kenny', 32, ' Subject: Fire. Dear Sir/Madam, I am writing to inform you of a fire that has broken out on the premises of 123 Cavendon Road... no, that`s too formal.[deletes text, starts again]', '2013-11-25 00:00:31');
INSERT INTO TAG_COMMENT VALUES (53, 'kenny', 32, '0118999881999119725...3.', '2013-11-25 00:00:30');
INSERT INTO TAG_COMMENT VALUES (54, 'kenny', 51, 'If they teamed up... They would be unstoppable.', '2013-11-25 00:00:33');

--INSERT INTO TAG_VOTE VALUES (vote_id, + or -1, 'name', imageid);

INSERT INTO TAG_VOTE VALUES (1, '1', 'nicole', 1);
INSERT INTO TAG_VOTE VALUES (2, '1', 'victoria', 1);
INSERT INTO TAG_VOTE VALUES (3, '-1', 'kenny', 1);
INSERT INTO TAG_VOTE VALUES (4, '1', 'jodi', 1);
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
--what  should I do with the image with image_id 7?
INSERT INTO TAG_VOTE VALUES (16, '1', 'kenny', 8);
INSERT INTO TAG_VOTE VALUES (17, '1', 'nicole', 8);
INSERT INTO TAG_VOTE VALUES (18, '1', 'jodi', 8);
INSERT INTO TAG_VOTE VALUES (19, '1', 'fluffernutter', 8);
INSERT INTO TAG_VOTE VALUES (20, '1', 'kenny', 9);
INSERT INTO TAG_VOTE VALUES (21, '1', 'nicole', 9);
INSERT INTO TAG_VOTE VALUES (22, '1', 'jodi', 9);
INSERT INTO TAG_VOTE VALUES (23, '1', 'fluffernutter', 9);
INSERT INTO TAG_VOTE VALUES (24,'1','ChengGuevara',10);
INSERT INTO TAG_VOTE VALUES (25,'1','newuser',10);
INSERT INTO TAG_VOTE VALUES (26,'1','username',10);
INSERT INTO TAG_VOTE VALUES (27,'1','ChengGuevara',11);
INSERT INTO TAG_VOTE VALUES (28,'1','newuser',11);
INSERT INTO TAG_VOTE VALUES (29,'-1','password',12);
INSERT INTO TAG_VOTE VALUES (30,'-1','tagteam',12);
INSERT INTO TAG_VOTE VALUES (31,'1','newuser',13);
INSERT INTO TAG_VOTE VALUES (32,'1','username',13);
INSERT INTO TAG_VOTE VALUES (33,'1','nicole',14);
INSERT INTO TAG_VOTE VALUES (34,'1','victoria',14);
INSERT INTO TAG_VOTE VALUES (35,'1','kenny',14);
INSERT INTO TAG_VOTE VALUES (36,'1','fluffernutter',15);
INSERT INTO TAG_VOTE VALUES (37,'1','ChengGuevara',15);
INSERT INTO TAG_VOTE VALUES (38,'1','newuser',15);
INSERT INTO TAG_VOTE VALUES (39,'1','username',15);
INSERT INTO TAG_VOTE VALUES (40, '1', 'victoria', 8);
INSERT INTO TAG_VOTE VALUES (41,'1','kenny',16);
INSERT INTO TAG_VOTE VALUES (42,'1','jodi',16);
INSERT INTO TAG_VOTE VALUES (43,'1','fluffernutter',16);
INSERT INTO TAG_VOTE VALUES (44,'1','ChengGuevara',16);
INSERT INTO TAG_VOTE VALUES (45,'1','kenny',17);
INSERT INTO TAG_VOTE VALUES (46,'1','victoria',18);
INSERT INTO TAG_VOTE VALUES (47,'1','kenny',18);
INSERT INTO TAG_VOTE VALUES (48,'1','kenny',19);
INSERT INTO TAG_VOTE VALUES (49,'1','jodi',19);
INSERT INTO TAG_VOTE VALUES (50,'1','fluffernutter',19);
INSERT INTO TAG_VOTE VALUES (51,'1','nicole',20);
INSERT INTO TAG_VOTE VALUES (52,'1','victoria',20);
INSERT INTO TAG_VOTE VALUES (53,'1','kenny',20);
INSERT INTO TAG_VOTE VALUES (54,'1','jodi',20);
INSERT INTO TAG_VOTE VALUES (55,'1','nicole',21);
INSERT INTO TAG_VOTE VALUES (56,'1','victoria',21);
INSERT INTO TAG_VOTE VALUES (57,'1','kenny',21);
INSERT INTO TAG_VOTE VALUES (58,'1','jodi',21);
INSERT INTO TAG_VOTE VALUES (59,'1','fluffernutter',21);
INSERT INTO TAG_VOTE VALUES (60,'1','nicole',22);
INSERT INTO TAG_VOTE VALUES (61,'1','victoria',22);
INSERT INTO TAG_VOTE VALUES (62,'1','kenny',23);
INSERT INTO TAG_VOTE VALUES (63,'1','nicole',24);
INSERT INTO TAG_VOTE VALUES (64,'1','victoria',24);
INSERT INTO TAG_VOTE VALUES (65,'1','kenny',25);
INSERT INTO TAG_VOTE VALUES (66,'1','nicole',25);
INSERT INTO TAG_VOTE VALUES (67,'1','victoria',25);
INSERT INTO TAG_VOTE VALUES (68,'1','kenny',26);
INSERT INTO TAG_VOTE VALUES (69,'1','jodi',26);
INSERT INTO TAG_VOTE VALUES (70,'1','fluffernutter',26);
INSERT INTO TAG_VOTE VALUES (71,'1','ChengGuevara',26);
INSERT INTO TAG_VOTE VALUES (72,'1','nicole',27);
INSERT INTO TAG_VOTE VALUES (73,'1','victoria',27);
INSERT INTO TAG_VOTE VALUES (74,'1','kenny',27);
INSERT INTO TAG_VOTE VALUES (75,'1','jodi',27);
INSERT INTO TAG_VOTE VALUES (76,'1','fluffernutter',27);
INSERT INTO TAG_VOTE VALUES (77,'1','victoria',28);
INSERT INTO TAG_VOTE VALUES (78,'1','kenny',28);
INSERT INTO TAG_VOTE VALUES (79,'1','jodi',28);
INSERT INTO TAG_VOTE VALUES (80,'1','fluffernutter',28);
INSERT INTO TAG_VOTE VALUES (81,'1','ChengGuevara',28);
INSERT INTO TAG_VOTE VALUES (82,'1','newuser',28);
INSERT INTO TAG_VOTE VALUES (83,'1','fluffernutter',29);
INSERT INTO TAG_VOTE VALUES (84,'1','ChengGuevara',29);
INSERT INTO TAG_VOTE VALUES (85,'1','kenny',30);
INSERT INTO TAG_VOTE VALUES (86,'1','newuser',31);
INSERT INTO TAG_VOTE VALUES (87,'1','username',31);
INSERT INTO TAG_VOTE VALUES (88,'1','password',31);
INSERT INTO TAG_VOTE VALUES (89,'1','newuser',32);
INSERT INTO TAG_VOTE VALUES (90,'1','username',32);
INSERT INTO TAG_VOTE VALUES (91,'1','password',32);
INSERT INTO TAG_VOTE VALUES (92,'1','tagteam',32);
INSERT INTO TAG_VOTE VALUES (93,'1','ChengGuevara',33);
INSERT INTO TAG_VOTE VALUES (94,'1','newuser',33);
INSERT INTO TAG_VOTE VALUES (95,'1','username',33);
INSERT INTO TAG_VOTE VALUES (96,'1','password',33);
INSERT INTO TAG_VOTE VALUES (97,'1','tagteam',33);
INSERT INTO TAG_VOTE VALUES (98,'1','fluffernutter',34);
INSERT INTO TAG_VOTE VALUES (99,'1','ChengGuevara',34);
INSERT INTO TAG_VOTE VALUES (100,'1','newuser',35);
INSERT INTO TAG_VOTE VALUES (101,'1','username',35);
INSERT INTO TAG_VOTE VALUES (102,'1','password',35);
INSERT INTO TAG_VOTE VALUES (103,'1','tagteam',35);
INSERT INTO TAG_VOTE VALUES (104,'1','thedoctor',35);
INSERT INTO TAG_VOTE VALUES (105,'1','jodi',36);
INSERT INTO TAG_VOTE VALUES (106,'1','fluffernutter',36);
INSERT INTO TAG_VOTE VALUES (107,'1','ChengGuevara',36);
INSERT INTO TAG_VOTE VALUES (108,'1','fluffernutter',37);
INSERT INTO TAG_VOTE VALUES (109,'1','ChengGuevara',37);
INSERT INTO TAG_VOTE VALUES (110,'1','newuser',37);
INSERT INTO TAG_VOTE VALUES (111,'1','username',37);
INSERT INTO TAG_VOTE VALUES (112,'1','nicole',38);
INSERT INTO TAG_VOTE VALUES (113,'1','victoria',38);
INSERT INTO TAG_VOTE VALUES (114,'1','kenny',38);
INSERT INTO TAG_VOTE VALUES (115,'1','fluffernutter',39);
INSERT INTO TAG_VOTE VALUES (116,'1','ChengGuevara',39);
INSERT INTO TAG_VOTE VALUES (117,'1','newuser',39);
INSERT INTO TAG_VOTE VALUES (118,'1','username',39);
INSERT INTO TAG_VOTE VALUES (119,'1','password',39);
INSERT INTO TAG_VOTE VALUES (120,'1','nicole',40);
INSERT INTO TAG_VOTE VALUES (121,'1','victoria',40);
INSERT INTO TAG_VOTE VALUES (122,'1','kenny',40);
INSERT INTO TAG_VOTE VALUES (123,'1','jodi',40);
INSERT INTO TAG_VOTE VALUES (124,'1','fluffernutter',40);
INSERT INTO TAG_VOTE VALUES (125,'1','ChengGuevara',40);
INSERT INTO TAG_VOTE VALUES (126,'1','newuser',40);
INSERT INTO TAG_VOTE VALUES (127,'1','kenny',41);
INSERT INTO TAG_VOTE VALUES (128,'1','ChengGuevara',42);
INSERT INTO TAG_VOTE VALUES (129,'1','newuser',42);
INSERT INTO TAG_VOTE VALUES (130,'1','username',42);
INSERT INTO TAG_VOTE VALUES (131,'1','newuser',43);
INSERT INTO TAG_VOTE VALUES (132,'1','username',43);
INSERT INTO TAG_VOTE VALUES (133,'1','password',43);
INSERT INTO TAG_VOTE VALUES (134,'1','tagteam',43);
INSERT INTO TAG_VOTE VALUES (135,'1','victoria',44);
INSERT INTO TAG_VOTE VALUES (136,'1','kenny',44);
INSERT INTO TAG_VOTE VALUES (137,'1','fluffernutter',45);
INSERT INTO TAG_VOTE VALUES (138,'1','ChengGuevara',45);
INSERT INTO TAG_VOTE VALUES (139,'1','newuser',45);
INSERT INTO TAG_VOTE VALUES (140,'1','newuser',46);
INSERT INTO TAG_VOTE VALUES (141,'1','username',46);
INSERT INTO TAG_VOTE VALUES (142,'1','password',46);
INSERT INTO TAG_VOTE VALUES (143,'1','tagteam',46);
INSERT INTO TAG_VOTE VALUES (144,'1','thedoctor',46);
INSERT INTO TAG_VOTE VALUES (145,'1','kenny',47);
INSERT INTO TAG_VOTE VALUES (146,'1','nicole',48);
INSERT INTO TAG_VOTE VALUES (147,'1','victoria',48);
INSERT INTO TAG_VOTE VALUES (148,'1','kenny',48);
INSERT INTO TAG_VOTE VALUES (149,'1','fluffernutter',49);
INSERT INTO TAG_VOTE VALUES (150,'1','ChengGuevara',49);
INSERT INTO TAG_VOTE VALUES (151,'1','kenny',50);
INSERT INTO TAG_VOTE VALUES (152,'1','password',51);
INSERT INTO TAG_VOTE VALUES (153,'1','fluffernutter',51);
INSERT INTO TAG_VOTE VALUES (154,'1','ChengGuevara',51);
INSERT INTO TAG_VOTE VALUES (155,'1','kenny',51);




INSERT INTO TAG_RECORD  VALUES (1, 'best', '1','2013-11-25 00:00:01');
INSERT INTO TAG_RECORD  VALUES (2, 'best', '2','2013-11-25 00:00:02');
INSERT INTO TAG_RECORD  VALUES (3, 'best', '3','2013-11-25 00:00:03');
INSERT INTO TAG_RECORD  VALUES (4, 'best', '4','2013-11-25 00:00:04');
INSERT INTO TAG_RECORD  VALUES (5, 'best', '5','2013-11-25 00:00:05');
INSERT INTO TAG_RECORD  VALUES (6, 'best', '6','2013-11-25 00:00:06');
INSERT INTO TAG_RECORD  VALUES (7, 'best', '7','2013-11-25 00:00:07');
INSERT INTO TAG_RECORD  VALUES (8, 'best', '8','2013-11-25 00:00:08');
INSERT INTO TAG_RECORD  VALUES (9, 'best', '9','2013-11-25 00:00:09');
INSERT INTO TAG_RECORD  VALUES (10, 'best', '10','2013-11-25 00:00:10');


-- don't forget this, or nothing will be saved to the database!
commit;



