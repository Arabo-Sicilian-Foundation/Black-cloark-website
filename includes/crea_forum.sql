DROP TABLE forum_membres;
DROP TABLE forum_post;
DROP TABLE forum_topic;

CREATE TABLE forum_membres (
membre_id int(11) NOT NULL AUTO_INCREMENT,
membre_pseudo varchar(30) collate latin1_general_ci NOT NULL,
membre_mdp varchar(32) collate latin1_general_ci NOT NULL,
membre_email varchar(32) collate latin1_general_ci NOT NULL,
membre_inscrit int(11) NOT NULL,
membre_derniere_visite int(11) NOT NULL,
membre_rang tinyint (4) DEFAULT 2,
membre_post int(11) NOT NULL,
PRIMARY KEY  (`membre_id`)
);



CREATE TABLE forum_post (
post_id int(11) AUTO_INCREMENT,
post_createur int(11),
post_texte text,
post_time int(11),
topic_id int(11),
PRIMARY KEY  (post_id)
);


CREATE TABLE forum_topic (
topic_id int(11) AUTO_INCREMENT,
topic_titre char(60) collate latin1_general_ci NOT NULL,
topic_createur int(11) NOT NULL,
topic_time int(11),
topic_last_post int(11) DEFAULT 0,
PRIMARY KEY  (topic_id),
UNIQUE KEY topic_last_post (topic_last_post)
);
