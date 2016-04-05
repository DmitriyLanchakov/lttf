-- https://my.vertabelo.com/public-model-view/9ZygNGUrjItZ0TauCxQDtcCLvs6uHXvtfwPSJRbu5gscswte7VjC8izpljBwnDVV?x=4841&y=4359&zoom=1.0

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET search_path = public, pg_catalog;
SET default_tablespace = '';
SET default_with_oids = false;



CREATE TABLE "Lift_User_group"
(
  "id" serial primary key not null ,
  "name" character varying (255) not null
);


CREATE TABLE "Lift_ACL"
(
  "id" serial primary key not null,
  "group" integer REFERENCES "Lift_User_group" ("id") not null,
  "class" character varying (255) not null,
  "function" character varying (255) not null,
   UNIQUE ("group", "class", "function")

);

CREATE TABLE "Lift_Page"
(
  "id" serial primary key not null,
  "title" character varying (255) not null,
  "text" text not null,
  "status" boolean DEFAULT TRUE

);


CREATE TABLE "Lift_Blog_Follow"
(
  "id" serial primary key not null,
  "blog" integer REFERENCES "Lift_Blog" ("id") not null,
  "user" integer REFERENCES "Lift_User" ("id") not null,
  UNIQUE ("blog", "user")

);




CREATE TABLE "Lift_User"
(
  "id" serial primary key not null ,
  "deleted" boolean DEFAULT FALSE,
  "first_name" character varying (255) not null,
  "middle_name" character varying (255) not null,
  "second_name" character varying (255) not null,
  "email" character varying (255) not null unique,
  "password" character varying (255) not null,
  "group" integer REFERENCES "Lift_User_group" ("id") not null,
  "type" integer not null,
  "about" text,
  "registration_time" timestamp without time zone not null,
  "update_time" timestamp without time zone not null,
   data json


);


CREATE TABLE "Lift_Token"
(
  "id" serial primary key not null,
  "token" text not null,
  "user" integer REFERENCES "Lift_User" ("id") not null


);


CREATE TABLE "Lift_Heading"
(
  "id" serial primary key not null,
  "name" character varying (255) not null

);


CREATE TABLE "Lift_Subject"
(
  "id" serial primary key not null,
  "name" character varying (255) not null

);


CREATE TABLE "Lift_Post_Subject"
(
  "id" serial primary key not null,
  "post" integer REFERENCES "Lift_Post" ("id") not null,
  "subject" integer REFERENCES "Lift_Subject" ("id") not null

);

CREATE TABLE "Lift_Blog_Subject"
(
  "id" serial primary key not null,
  "blog" integer REFERENCES "Lift_Blog" ("id") not null,
  "subject" integer REFERENCES "Lift_Subject" ("id") not null

);


CREATE TABLE "Lift_Post_Heading"
(
  "id" serial primary key not null,
  "post" integer REFERENCES "Lift_Post" ("id") not null,
  "heading" integer REFERENCES "Lift_Heading" ("id") not null

);


CREATE TABLE "Lift_Blog_Heading"
(
  "id" serial primary key not null,
  "blog" integer REFERENCES "Lift_Blog" ("id") not null,
  "heading" integer REFERENCES "Lift_Heading" ("id") not null

);






CREATE TABLE "Lift_Blog"
(
  "id" serial primary key not null,
  "type" integer not null,
  "title" character varying (255) not null,
  "heading" integer REFERENCES "Lift_Heading" ("id") not null,
  "administrator" integer REFERENCES "Lift_User" ("id") not null ON DELETE CASCADE,
  "creation_time" timestamp without time zone not null,
  "editing_time" timestamp without time zone not null

);

CREATE TABLE "Lift_Project"
(
  "id" serial primary key not null,
  "type" integer not null,
  "title" character varying (255) not null,
  "heading" integer REFERENCES "Lift_Heading" ("id") not null,
  "administrator" integer REFERENCES "Lift_User" ("id") not null ,
  "creation_time" timestamp without time zone not null,
  "editing_time" timestamp without time zone not null,
  "start_time" timestamp without time zone null,
  "end_time" timestamp without time zone null

);






CREATE TABLE "Lift_Post"
(
  "id" serial primary key not null,
  "blog" integer REFERENCES "Lift_Blog" ("id")  not null,
  "title" character varying (255) not null,
  "text" text not null,
  "creation_time" timestamp without time zone not null,
  "editing_time" timestamp without time zone not null,
  "user" integer REFERENCES "Lift_User" ("id") not null,
  "status" integer not null

);


CREATE TABLE "Lift_Post_ip"
(
  "id" serial primary key not null,
  "post" integer REFERENCES "Lift_Post" ("id")  not null,
  "ip" text,
  UNIQUE ("post", "ip")

);


CREATE TABLE "Lift_Prpost_ip"
(
  "id" serial primary key not null,
  "post" integer REFERENCES "Lift_Prpost" ("id")  not null,
  "ip" text,
  UNIQUE ("post", "ip")

);

CREATE TABLE "Lift_Prpost"
(
  "id" serial primary key not null,
  "project" integer REFERENCES "Lift_Project" ("id")  not null,
  "title" character varying (255) not null,
  "text" text not null,
  "creation_time" timestamp without time zone not null,
  "editing_time" timestamp without time zone not null,
  "user" integer REFERENCES "Lift_User" ("id") not null,
  "status" integer not null

);


CREATE TABLE "Lift_Task"
(
  "id" serial primary key not null,
  "project" integer REFERENCES "Lift_Project" ("id")  not null,
  "title" character varying (255) not null,
  "text" text not null,
  "creation_time" timestamp without time zone not null,
  "editing_time" timestamp without time zone not null,
  "user" integer REFERENCES "Lift_User" ("id") not null,
  "status" integer not null,
  "start_time" timestamp without time zone null,
  "end_time" timestamp without time zone null

);


CREATE TABLE "Lift_Tag"
(
  "id" serial primary key not null,
  "title" character varying (255) not null

);

CREATE TABLE "Lift_Post_tag"
(
  "id" serial primary key,
  "post" integer REFERENCES "Lift_Post" ("id")  not null,
  "tag" integer REFERENCES "Lift_Tag" ("id") not null

);

CREATE TABLE "Lift_Commentary"
(
  "id" serial primary key not null,
  "deleted" boolean DEFAULT FALSE,
  "parent" integer REFERENCES "Lift_Commentary" ("id"),
  "post" integer REFERENCES "Lift_Post" ("id") not null,
  "user" integer REFERENCES "Lift_User" ("id") not null,
  "text" text not null,
  "creation_time" timestamp without time zone not null

);

CREATE TABLE "Lift_Prcommentary"
(
  "id" serial primary key not null,
  "deleted" boolean DEFAULT FALSE,
  "parent" integer REFERENCES "Lift_Prcommentary" ("id"),
  "post" integer REFERENCES "Lift_Prpost" ("id") not null,
  "user" integer REFERENCES "Lift_User" ("id") not null,
  "text" text not null,
  "creation_time" timestamp without time zone not null

);

CREATE TABLE "Lift_Tskcommentary"
(
  "id" serial primary key not null,
  "deleted" boolean DEFAULT FALSE,
  "parent" integer REFERENCES "Lift_Tskcommentary" ("id"),
  "task" integer REFERENCES "Lift_Task" ("id") not null,
  "user" integer REFERENCES "Lift_User" ("id") not null,
  "text" text not null,
  "creation_time" timestamp without time zone not null

);

CREATE TABLE "Lift_Task_access"
(
  "id" serial primary key not null,
  "user" integer REFERENCES "Lift_User" ("id") not null,
  "task" integer REFERENCES "Lift_Task" ("id")  not null,
  "level" integer not null,
  UNIQUE ("user", "task")

);


CREATE TABLE "Lift_Blog_access"
(
  "id" serial primary key not null,
  "user" integer REFERENCES "Lift_User" ("id") not null,
  "blog" integer REFERENCES "Lift_Blog" ("id")  not null,
  "level" integer not null,
  UNIQUE ("user", "blog")

);


CREATE TABLE "Lift_Project_access"
(
  "id" serial primary key not null,
  "user" integer REFERENCES "Lift_User" ("id") not null,
  "project" integer REFERENCES "Lift_Project" ("id")  not null,
  "level" integer not null,
  UNIQUE ("user", "project")

);

CREATE TABLE "Lift_Badge_type"
(
  "id" serial primary key not null,
  "title" character varying (255) not null,
  "hint" text not null,
  "image" bytea not null

);

CREATE TABLE "Lift_Badge"
(
    "id" serial primary key not null,
    "type" integer REFERENCES "Lift_Badge_type" ("id")  not null,
    "user" integer REFERENCES "Lift_User" ("id") not null,
    "issue_time" timestamp without time zone not null

);

CREATE TABLE "Lift_Curators_resume"
(
  "id" serial primary key not null,
  "user" integer REFERENCES "Lift_User" ("id")  not null,
  "heading" integer REFERENCES "Lift_Heading" ("id")  not null,
  "data" json not null

);

CREATE TABLE "Lift_Site"
(
  "id" serial primary key  not null,
  "domain" character varying (255) not null,
  "name" character varying (255) not null

);

CREATE TABLE "Lift_Page"
(
  "id" serial primary key  not null,
  "url" character varying (255)  not null,
  "subdomain" integer REFERENCES "Lift_Site" ("id")  not null,
  "user" integer REFERENCES "Lift_User" ("id")  not null,
  "heading" integer REFERENCES "Lift_Heading" ("id")  not null,
  "creation_time" timestamp without time zone not null,
  "editing_time" timestamp without time zone not null

);

CREATE TABLE "Lift_Media_file"
(
  "id" serial primary key  not null,
  "type" integer not null,
  "title" character varying (255) not null,
  "description" text not null,
  "path" text not null

);


CREATE TABLE "Lift_Media_page"
(
  "id" serial primary key  not null,
  "media_file" integer REFERENCES "Lift_Media_file" ("id") not null,
  "page" integer REFERENCES "Lift_Page" ("id") not null

);


CREATE TABLE "Lift_Media_post"
(
  "id" serial primary key  not null,
  "media_file" integer REFERENCES "Lift_Media_file" ("id") not null,
  "post" integer REFERENCES "Lift_Post" ("id") not null

);
