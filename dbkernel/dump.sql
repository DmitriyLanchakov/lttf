--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner:
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner:
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: Lift_ACL; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_ACL" (
    id integer NOT NULL,
    "group" integer NOT NULL,
    class character varying(255) NOT NULL,
    function character varying(255) NOT NULL
);


ALTER TABLE public."Lift_ACL" OWNER TO postgres;

--
-- Name: Lift_ACL_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_ACL_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_ACL_id_seq" OWNER TO postgres;

--
-- Name: Lift_ACL_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_ACL_id_seq" OWNED BY "Lift_ACL".id;


--
-- Name: Lift_Badge; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_Badge" (
    id integer NOT NULL,
    type integer NOT NULL,
    "user" integer NOT NULL,
    issue_time timestamp without time zone NOT NULL
);


ALTER TABLE public."Lift_Badge" OWNER TO postgres;

--
-- Name: Lift_Badge_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_Badge_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_Badge_id_seq" OWNER TO postgres;

--
-- Name: Lift_Badge_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_Badge_id_seq" OWNED BY "Lift_Badge".id;


--
-- Name: Lift_Badge_type; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_Badge_type" (
    id integer NOT NULL,
    title character varying(255) NOT NULL,
    hint text NOT NULL,
    image bytea NOT NULL
);


ALTER TABLE public."Lift_Badge_type" OWNER TO postgres;

--
-- Name: Lift_Badge_type_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_Badge_type_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_Badge_type_id_seq" OWNER TO postgres;

--
-- Name: Lift_Badge_type_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_Badge_type_id_seq" OWNED BY "Lift_Badge_type".id;


--
-- Name: Lift_Blog; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_Blog" (
    id integer NOT NULL,
    type integer NOT NULL,
    title character varying(255) NOT NULL,
    administrator integer NOT NULL,
    creation_time timestamp without time zone NOT NULL,
    editing_time timestamp without time zone NOT NULL,
    avatar character varying(255),
    text text,
    deleted boolean DEFAULT false
);


ALTER TABLE public."Lift_Blog" OWNER TO postgres;

--
-- Name: Lift_Blog_Follow; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_Blog_Follow" (
    id integer NOT NULL,
    blog integer NOT NULL,
    "user" integer NOT NULL
);


ALTER TABLE public."Lift_Blog_Follow" OWNER TO postgres;

--
-- Name: Lift_Blog_Follow_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_Blog_Follow_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_Blog_Follow_id_seq" OWNER TO postgres;

--
-- Name: Lift_Blog_Follow_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_Blog_Follow_id_seq" OWNED BY "Lift_Blog_Follow".id;


--
-- Name: Lift_Blog_Heading; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_Blog_Heading" (
    id integer NOT NULL,
    blog integer NOT NULL,
    heading integer NOT NULL
);


ALTER TABLE public."Lift_Blog_Heading" OWNER TO postgres;

--
-- Name: Lift_Blog_Heading_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_Blog_Heading_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_Blog_Heading_id_seq" OWNER TO postgres;

--
-- Name: Lift_Blog_Heading_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_Blog_Heading_id_seq" OWNED BY "Lift_Blog_Heading".id;


--
-- Name: Lift_Blog_Subject; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_Blog_Subject" (
    id integer NOT NULL,
    blog integer NOT NULL,
    subject integer NOT NULL
);


ALTER TABLE public."Lift_Blog_Subject" OWNER TO postgres;

--
-- Name: Lift_Blog_Subject_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_Blog_Subject_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_Blog_Subject_id_seq" OWNER TO postgres;

--
-- Name: Lift_Blog_Subject_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_Blog_Subject_id_seq" OWNED BY "Lift_Blog_Subject".id;


--
-- Name: Lift_Blog_access; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_Blog_access" (
    id integer NOT NULL,
    "user" integer NOT NULL,
    blog integer NOT NULL,
    level integer NOT NULL
);


ALTER TABLE public."Lift_Blog_access" OWNER TO postgres;

--
-- Name: Lift_Blog_access_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_Blog_access_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_Blog_access_id_seq" OWNER TO postgres;

--
-- Name: Lift_Blog_access_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_Blog_access_id_seq" OWNED BY "Lift_Blog_access".id;


--
-- Name: Lift_Blog_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_Blog_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_Blog_id_seq" OWNER TO postgres;

--
-- Name: Lift_Blog_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_Blog_id_seq" OWNED BY "Lift_Blog".id;


--
-- Name: Lift_Commentary; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_Commentary" (
    id integer NOT NULL,
    deleted boolean DEFAULT false,
    parent integer,
    post integer NOT NULL,
    "user" integer NOT NULL,
    text text NOT NULL,
    creation_time timestamp without time zone NOT NULL
);


ALTER TABLE public."Lift_Commentary" OWNER TO postgres;

--
-- Name: Lift_Commentary_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_Commentary_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_Commentary_id_seq" OWNER TO postgres;

--
-- Name: Lift_Commentary_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_Commentary_id_seq" OWNED BY "Lift_Commentary".id;


--
-- Name: Lift_Curators_resume; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_Curators_resume" (
    id integer NOT NULL,
    "user" integer NOT NULL,
    heading integer NOT NULL,
    data json NOT NULL
);


ALTER TABLE public."Lift_Curators_resume" OWNER TO postgres;

--
-- Name: Lift_Curators_resume_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_Curators_resume_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_Curators_resume_id_seq" OWNER TO postgres;

--
-- Name: Lift_Curators_resume_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_Curators_resume_id_seq" OWNED BY "Lift_Curators_resume".id;


--
-- Name: Lift_Heading; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_Heading" (
    id integer NOT NULL,
    name character varying(255) NOT NULL
);


ALTER TABLE public."Lift_Heading" OWNER TO postgres;

--
-- Name: Lift_Heading_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_Heading_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_Heading_id_seq" OWNER TO postgres;

--
-- Name: Lift_Heading_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_Heading_id_seq" OWNED BY "Lift_Heading".id;


--
-- Name: Lift_Media_file; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_Media_file" (
    id integer NOT NULL,
    type integer NOT NULL,
    title character varying(255) NOT NULL,
    description text NOT NULL,
    path text NOT NULL
);


ALTER TABLE public."Lift_Media_file" OWNER TO postgres;

--
-- Name: Lift_Media_file_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_Media_file_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_Media_file_id_seq" OWNER TO postgres;

--
-- Name: Lift_Media_file_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_Media_file_id_seq" OWNED BY "Lift_Media_file".id;


--
-- Name: Lift_Media_page; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_Media_page" (
    id integer NOT NULL,
    media_file integer NOT NULL,
    page integer NOT NULL
);


ALTER TABLE public."Lift_Media_page" OWNER TO postgres;

--
-- Name: Lift_Media_page_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_Media_page_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_Media_page_id_seq" OWNER TO postgres;

--
-- Name: Lift_Media_page_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_Media_page_id_seq" OWNED BY "Lift_Media_page".id;


--
-- Name: Lift_Media_post; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_Media_post" (
    id integer NOT NULL,
    media_file integer NOT NULL,
    post integer NOT NULL
);


ALTER TABLE public."Lift_Media_post" OWNER TO postgres;

--
-- Name: Lift_Media_post_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_Media_post_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_Media_post_id_seq" OWNER TO postgres;

--
-- Name: Lift_Media_post_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_Media_post_id_seq" OWNED BY "Lift_Media_post".id;


--
-- Name: Lift_Page; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_Page" (
    id integer NOT NULL,
    title character varying(255) NOT NULL,
    text text NOT NULL,
    status boolean DEFAULT true
);


ALTER TABLE public."Lift_Page" OWNER TO postgres;

--
-- Name: Lift_Page_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_Page_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_Page_id_seq" OWNER TO postgres;

--
-- Name: Lift_Page_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_Page_id_seq" OWNED BY "Lift_Page".id;


--
-- Name: Lift_Post; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_Post" (
    id integer NOT NULL,
    blog integer NOT NULL,
    title character varying(255) NOT NULL,
    text text NOT NULL,
    creation_time timestamp without time zone NOT NULL,
    editing_time timestamp without time zone NOT NULL,
    "user" integer NOT NULL,
    status integer NOT NULL,
    avatar character varying(255),
    background character varying(255),
    annotation text,
    deleted boolean DEFAULT false
);


ALTER TABLE public."Lift_Post" OWNER TO postgres;

--
-- Name: Lift_Post_Heading; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_Post_Heading" (
    id integer NOT NULL,
    post integer NOT NULL,
    heading integer NOT NULL
);


ALTER TABLE public."Lift_Post_Heading" OWNER TO postgres;

--
-- Name: Lift_Post_Heading_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_Post_Heading_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_Post_Heading_id_seq" OWNER TO postgres;

--
-- Name: Lift_Post_Heading_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_Post_Heading_id_seq" OWNED BY "Lift_Post_Heading".id;


--
-- Name: Lift_Post_Subject; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_Post_Subject" (
    id integer NOT NULL,
    post integer NOT NULL,
    subject integer NOT NULL
);


ALTER TABLE public."Lift_Post_Subject" OWNER TO postgres;

--
-- Name: Lift_Post_Subject_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_Post_Subject_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_Post_Subject_id_seq" OWNER TO postgres;

--
-- Name: Lift_Post_Subject_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_Post_Subject_id_seq" OWNED BY "Lift_Post_Subject".id;


--
-- Name: Lift_Post_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_Post_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_Post_id_seq" OWNER TO postgres;

--
-- Name: Lift_Post_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_Post_id_seq" OWNED BY "Lift_Post".id;


--
-- Name: Lift_Post_ip; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_Post_ip" (
    id integer NOT NULL,
    post integer NOT NULL,
    ip text
);


ALTER TABLE public."Lift_Post_ip" OWNER TO postgres;

--
-- Name: Lift_Post_ip_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_Post_ip_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_Post_ip_id_seq" OWNER TO postgres;

--
-- Name: Lift_Post_ip_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_Post_ip_id_seq" OWNED BY "Lift_Post_ip".id;


--
-- Name: Lift_Post_tag; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_Post_tag" (
    id integer NOT NULL,
    post integer NOT NULL,
    tag integer NOT NULL
);


ALTER TABLE public."Lift_Post_tag" OWNER TO postgres;

--
-- Name: Lift_Post_tag_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_Post_tag_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_Post_tag_id_seq" OWNER TO postgres;

--
-- Name: Lift_Post_tag_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_Post_tag_id_seq" OWNED BY "Lift_Post_tag".id;


--
-- Name: Lift_Prcommentary; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_Prcommentary" (
    id integer NOT NULL,
    deleted boolean DEFAULT false,
    parent integer,
    post integer NOT NULL,
    "user" integer NOT NULL,
    text text NOT NULL,
    creation_time timestamp without time zone NOT NULL
);


ALTER TABLE public."Lift_Prcommentary" OWNER TO postgres;

--
-- Name: Lift_Prcommentary_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_Prcommentary_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_Prcommentary_id_seq" OWNER TO postgres;

--
-- Name: Lift_Prcommentary_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_Prcommentary_id_seq" OWNED BY "Lift_Prcommentary".id;


--
-- Name: Lift_Project; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_Project" (
    id integer NOT NULL,
    type integer NOT NULL,
    title character varying(255) NOT NULL,
    heading integer NOT NULL,
    administrator integer NOT NULL,
    creation_time timestamp without time zone NOT NULL,
    editing_time timestamp without time zone NOT NULL,
    start_time timestamp without time zone,
    end_time timestamp without time zone,
    background character varying(255),
    description text,
    relevance text,
    purpose text,
    solutions text,
    avatar character varying(255),
    deleted boolean DEFAULT false
);


ALTER TABLE public."Lift_Project" OWNER TO postgres;

--
-- Name: Lift_Project_access; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_Project_access" (
    id integer NOT NULL,
    "user" integer NOT NULL,
    project integer NOT NULL,
    level integer NOT NULL
);


ALTER TABLE public."Lift_Project_access" OWNER TO postgres;

--
-- Name: Lift_Project_access_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_Project_access_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_Project_access_id_seq" OWNER TO postgres;

--
-- Name: Lift_Project_access_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_Project_access_id_seq" OWNED BY "Lift_Project_access".id;


--
-- Name: Lift_Project_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_Project_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_Project_id_seq" OWNER TO postgres;

--
-- Name: Lift_Project_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_Project_id_seq" OWNED BY "Lift_Project".id;


--
-- Name: Lift_Prpost; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_Prpost" (
    id integer NOT NULL,
    project integer NOT NULL,
    title character varying(255) NOT NULL,
    text text NOT NULL,
    creation_time timestamp without time zone NOT NULL,
    editing_time timestamp without time zone NOT NULL,
    "user" integer NOT NULL,
    status integer NOT NULL,
    background character varying(255),
    annotation text,
    avatar character varying(255),
    deleted boolean DEFAULT false
);


ALTER TABLE public."Lift_Prpost" OWNER TO postgres;

--
-- Name: Lift_Prpost_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_Prpost_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_Prpost_id_seq" OWNER TO postgres;

--
-- Name: Lift_Prpost_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_Prpost_id_seq" OWNED BY "Lift_Prpost".id;


--
-- Name: Lift_Prpost_ip; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_Prpost_ip" (
    id integer NOT NULL,
    post integer NOT NULL,
    ip text
);


ALTER TABLE public."Lift_Prpost_ip" OWNER TO postgres;

--
-- Name: Lift_Prpost_ip_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_Prpost_ip_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_Prpost_ip_id_seq" OWNER TO postgres;

--
-- Name: Lift_Prpost_ip_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_Prpost_ip_id_seq" OWNED BY "Lift_Prpost_ip".id;


--
-- Name: Lift_Site; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_Site" (
    id integer NOT NULL,
    domain character varying(255) NOT NULL,
    name character varying(255) NOT NULL
);


ALTER TABLE public."Lift_Site" OWNER TO postgres;

--
-- Name: Lift_Site_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_Site_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_Site_id_seq" OWNER TO postgres;

--
-- Name: Lift_Site_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_Site_id_seq" OWNED BY "Lift_Site".id;


--
-- Name: Lift_Subject; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_Subject" (
    id integer NOT NULL,
    name character varying(255) NOT NULL
);


ALTER TABLE public."Lift_Subject" OWNER TO postgres;

--
-- Name: Lift_Subject_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_Subject_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_Subject_id_seq" OWNER TO postgres;

--
-- Name: Lift_Subject_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_Subject_id_seq" OWNED BY "Lift_Subject".id;


--
-- Name: Lift_Tag; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_Tag" (
    id integer NOT NULL,
    title character varying(255) NOT NULL
);


ALTER TABLE public."Lift_Tag" OWNER TO postgres;

--
-- Name: Lift_Tag_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_Tag_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_Tag_id_seq" OWNER TO postgres;

--
-- Name: Lift_Tag_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_Tag_id_seq" OWNED BY "Lift_Tag".id;


--
-- Name: Lift_Task; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_Task" (
    id integer NOT NULL,
    project integer NOT NULL,
    title character varying(255) NOT NULL,
    text text NOT NULL,
    creation_time timestamp without time zone NOT NULL,
    editing_time timestamp without time zone NOT NULL,
    "user" integer NOT NULL,
    status integer NOT NULL,
    start_time timestamp without time zone,
    end_time timestamp without time zone,
    deleted boolean DEFAULT false
);


ALTER TABLE public."Lift_Task" OWNER TO postgres;

--
-- Name: Lift_Task_access; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_Task_access" (
    id integer NOT NULL,
    "user" integer NOT NULL,
    task integer NOT NULL,
    level integer NOT NULL
);


ALTER TABLE public."Lift_Task_access" OWNER TO postgres;

--
-- Name: Lift_Task_access_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_Task_access_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_Task_access_id_seq" OWNER TO postgres;

--
-- Name: Lift_Task_access_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_Task_access_id_seq" OWNED BY "Lift_Task_access".id;


--
-- Name: Lift_Task_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_Task_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_Task_id_seq" OWNER TO postgres;

--
-- Name: Lift_Task_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_Task_id_seq" OWNED BY "Lift_Task".id;


--
-- Name: Lift_Token; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_Token" (
    id integer NOT NULL,
    token text NOT NULL,
    "user" integer NOT NULL
);


ALTER TABLE public."Lift_Token" OWNER TO postgres;

--
-- Name: Lift_Token_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_Token_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_Token_id_seq" OWNER TO postgres;

--
-- Name: Lift_Token_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_Token_id_seq" OWNED BY "Lift_Token".id;


--
-- Name: Lift_Tskcommentary; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_Tskcommentary" (
    id integer NOT NULL,
    deleted boolean DEFAULT false,
    parent integer,
    task integer NOT NULL,
    "user" integer NOT NULL,
    text text NOT NULL,
    creation_time timestamp without time zone NOT NULL
);


ALTER TABLE public."Lift_Tskcommentary" OWNER TO postgres;

--
-- Name: Lift_Tskcommentary_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_Tskcommentary_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_Tskcommentary_id_seq" OWNER TO postgres;

--
-- Name: Lift_Tskcommentary_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_Tskcommentary_id_seq" OWNED BY "Lift_Tskcommentary".id;


--
-- Name: Lift_User; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_User" (
    id integer NOT NULL,
    deleted boolean DEFAULT false,
    first_name character varying(255) NOT NULL,
    middle_name character varying(255) NOT NULL,
    second_name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    "group" integer NOT NULL,
    type integer NOT NULL,
    about text,
    registration_time timestamp without time zone NOT NULL,
    update_time timestamp without time zone NOT NULL,
    data text,
    avatar character varying(255),
    background character varying(255)
);


ALTER TABLE public."Lift_User" OWNER TO postgres;

--
-- Name: Lift_User_group; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Lift_User_group" (
    id integer NOT NULL,
    name character varying(255) NOT NULL
);


ALTER TABLE public."Lift_User_group" OWNER TO postgres;

--
-- Name: Lift_User_group_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_User_group_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_User_group_id_seq" OWNER TO postgres;

--
-- Name: Lift_User_group_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_User_group_id_seq" OWNED BY "Lift_User_group".id;


--
-- Name: Lift_User_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Lift_User_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Lift_User_id_seq" OWNER TO postgres;

--
-- Name: Lift_User_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Lift_User_id_seq" OWNED BY "Lift_User".id;


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_ACL" ALTER COLUMN id SET DEFAULT nextval('"Lift_ACL_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Badge" ALTER COLUMN id SET DEFAULT nextval('"Lift_Badge_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Badge_type" ALTER COLUMN id SET DEFAULT nextval('"Lift_Badge_type_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Blog" ALTER COLUMN id SET DEFAULT nextval('"Lift_Blog_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Blog_Follow" ALTER COLUMN id SET DEFAULT nextval('"Lift_Blog_Follow_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Blog_Heading" ALTER COLUMN id SET DEFAULT nextval('"Lift_Blog_Heading_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Blog_Subject" ALTER COLUMN id SET DEFAULT nextval('"Lift_Blog_Subject_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Blog_access" ALTER COLUMN id SET DEFAULT nextval('"Lift_Blog_access_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Commentary" ALTER COLUMN id SET DEFAULT nextval('"Lift_Commentary_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Curators_resume" ALTER COLUMN id SET DEFAULT nextval('"Lift_Curators_resume_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Heading" ALTER COLUMN id SET DEFAULT nextval('"Lift_Heading_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Media_file" ALTER COLUMN id SET DEFAULT nextval('"Lift_Media_file_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Media_page" ALTER COLUMN id SET DEFAULT nextval('"Lift_Media_page_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Media_post" ALTER COLUMN id SET DEFAULT nextval('"Lift_Media_post_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Page" ALTER COLUMN id SET DEFAULT nextval('"Lift_Page_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Post" ALTER COLUMN id SET DEFAULT nextval('"Lift_Post_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Post_Heading" ALTER COLUMN id SET DEFAULT nextval('"Lift_Post_Heading_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Post_Subject" ALTER COLUMN id SET DEFAULT nextval('"Lift_Post_Subject_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Post_ip" ALTER COLUMN id SET DEFAULT nextval('"Lift_Post_ip_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Post_tag" ALTER COLUMN id SET DEFAULT nextval('"Lift_Post_tag_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Prcommentary" ALTER COLUMN id SET DEFAULT nextval('"Lift_Prcommentary_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Project" ALTER COLUMN id SET DEFAULT nextval('"Lift_Project_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Project_access" ALTER COLUMN id SET DEFAULT nextval('"Lift_Project_access_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Prpost" ALTER COLUMN id SET DEFAULT nextval('"Lift_Prpost_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Prpost_ip" ALTER COLUMN id SET DEFAULT nextval('"Lift_Prpost_ip_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Site" ALTER COLUMN id SET DEFAULT nextval('"Lift_Site_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Subject" ALTER COLUMN id SET DEFAULT nextval('"Lift_Subject_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Tag" ALTER COLUMN id SET DEFAULT nextval('"Lift_Tag_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Task" ALTER COLUMN id SET DEFAULT nextval('"Lift_Task_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Task_access" ALTER COLUMN id SET DEFAULT nextval('"Lift_Task_access_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Token" ALTER COLUMN id SET DEFAULT nextval('"Lift_Token_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Tskcommentary" ALTER COLUMN id SET DEFAULT nextval('"Lift_Tskcommentary_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_User" ALTER COLUMN id SET DEFAULT nextval('"Lift_User_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_User_group" ALTER COLUMN id SET DEFAULT nextval('"Lift_User_group_id_seq"'::regclass);


--
-- Data for Name: Lift_ACL; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_ACL" (id, "group", class, function) FROM stdin;
50	1	Lift_Post	readAll
51	1	Lift_Post	readLimitOffset
52	1	Lift_Post	amount
53	1	Lift_Post	amountUser_id
54	1	Lift_Post	create
55	1	Lift_Post	amountBlog_id
56	1	Lift_Post	readLimitOffsetBlog_id
57	1	Lift_Post	read
58	1	Lift_Post	update
59	1	Lift_Post	delete
65	1	Lift_Commentary	create
66	2	Lift_Commentary	create
67	1	Lift_Commentary	getLastId
68	2	Lift_Commentary	getLastId
69	1	Lift_Commentary	delete
70	2	Lift_Commentary	delete
71	3	Lift_Commentary	create
72	3	Lift_Commentary	getLastId
73	3	Lift_Commentary	delete
77	3	Lift_Post	readAll
78	3	Lift_Post	readLimitOffset
79	3	Lift_Post	amount
80	3	Lift_Post	amountUser_id
81	3	Lift_Post	create
82	3	Lift_Post	amountBlog_id
83	3	Lift_Post	readLimitOffsetBlog_id
84	3	Lift_Post	read
85	3	Lift_Post	update
86	3	Lift_Post	delete
113	2	Lift_Project_access	create
114	2	Lift_Project_access	read
115	2	Lift_Project_access	delete
116	1	Lift_Project_access	create
117	1	Lift_Project_access	read
118	1	Lift_Project_access	delete
131	1	Lift_Tskcommentary	create
132	1	Lift_Tskcommentary	getLastId
133	1	Lift_Tskcommentary	read
134	1	Lift_Tskcommentary	read_task
135	1	Lift_Tskcommentary	delete
136	1	Lift_Tskcommentary	read_LastId
137	2	Lift_Tskcommentary	create
138	2	Lift_Tskcommentary	getLastId
139	2	Lift_Tskcommentary	read
140	2	Lift_Tskcommentary	read_task
141	2	Lift_Tskcommentary	delete
142	2	Lift_Tskcommentary	read_LastId
143	3	Lift_Tskcommentary	create
144	3	Lift_Tskcommentary	getLastId
145	3	Lift_Tskcommentary	read
146	3	Lift_Tskcommentary	read_task
147	3	Lift_Tskcommentary	delete
148	3	Lift_Tskcommentary	read_LastId
158	1	Lift_Task	delete
159	2	Lift_Task	readAll
160	2	Lift_Task	readLimitOffset
161	2	Lift_Task	amount
162	2	Lift_Task	amountUser_id
163	2	Lift_Task	create
164	2	Lift_Task	amountBlog_id
165	2	Lift_Task	readLimitOffsetBlog_id
166	2	Lift_Task	read
167	2	Lift_Task	update
168	2	Lift_Task	delete
169	3	Lift_Task	readAll
170	3	Lift_Task	readLimitOffset
171	3	Lift_Task	amount
172	3	Lift_Task	amountUser_id
173	3	Lift_Task	create
174	3	Lift_Task	amountBlog_id
175	3	Lift_Task	readLimitOffsetBlog_id
176	3	Lift_Task	read
177	3	Lift_Task	update
178	3	Lift_Task	delete
183	2	Lift_Prpost	create
185	3	Lift_Prpost	update
187	3	Lift_Prpost	delete
189	1	Lift_Post	getLastId
190	3	Lift_Post	getLastId
194	1	Lift_Page	create
196	1	Lift_Page	update
198	2	Lift_Blog_Follow	create
200	1	Lift_Blog_Follow	delete
202	3	Lift_Blog_Follow	delete
209	2	Lift_Blog_Follow	read
1	1	Lift_User	read
2	1	Lift_User	create
3	1	Lift_User	update
4	1	Lift_User	delete
5	1	Lift_User	readAll
6	1	Lift_User	readLimitOffset
7	1	Lift_User	amount
8	1	Lift_User	update_self
9	2	Lift_User	update_self
10	2	Lift_User	read
11	2	Lift_User	readAll
12	2	Lift_User	amount
13	2	Lift_User	readLimitOffset
14	1	Lift_User	getLastId
15	3	Lift_User	read
16	3	Lift_User	readAll
17	3	Lift_User	readLimitOffset
18	3	Lift_User	getLastId
19	1	Lift_User_group	readAll
20	3	Lift_User_group	readAll
21	2	Lift_User_group	readAll
22	3	Lift_Heading	create
23	3	Lift_Heading	readAll
24	1	Lift_Heading	create
25	1	Lift_Heading	readAll
26	1	Lift_Blog	create
27	3	Lift_Blog	readLimitOffsetStatus1
28	3	Lift_Blog	amountStatus1
29	3	Lift_Blog	create
30	1	Lift_Blog	getLastId
31	1	Lift_Blog	readAll
32	1	Lift_Blog	delete
33	1	Lift_Blog	read
34	1	Lift_Blog	update
35	1	Lift_Blog	readLimitOffsetStatus1
36	1	Lift_Blog	amountStatus1
37	2	Lift_Blog	read
38	2	Lift_Blog	delete
39	2	Lift_Blog	update
40	3	Lift_Blog	getLastId
41	3	Lift_Blog	readAll
42	3	Lift_Blog	delete
43	3	Lift_Blog	read
44	3	Lift_Blog	update
45	1	Lift_Blog_access	read
46	1	Lift_Blog_access	create
48	2	Lift_Blog_Access	read
49	3	Lift_Blog_access	read
60	2	Lift_Post	create
61	2	Lift_Post	update
62	2	Lift_Post	delete
63	2	Lift_Post	readLimitOffsetBlog_id
64	2	Lift_Post	amountBlog_id
74	3	Lift_User	update_self
75	3	Lift_Blog_access	create
76	3	Lift_Blog_access	delete
87	1	Lift_Project	create
88	1	Lift_Project	getLastId
89	1	Lift_Project	readAll
90	1	Lift_Project	delete
91	1	Lift_Project	read
92	1	Lift_Project	update
93	1	Lift_Project	readLimitOffsetStatus1
94	1	Lift_Project	amountStatus1
95	3	Lift_Project	readAll
96	3	Lift_Project	readLimitOffset
97	3	Lift_Project	amount
98	3	Lift_Project	amountUser_id
99	3	Lift_Project	create
100	3	Lift_Project	amountBlog_id
101	3	Lift_Project	readLimitOffsetBlog_id
102	3	Lift_Project	read
103	3	Lift_Project	update
104	3	Lift_Project	delete
105	2	Lift_Project	create
106	2	Lift_Project	getLastId
107	2	Lift_Project	readAll
108	2	Lift_Project	delete
109	2	Lift_Project	read
110	2	Lift_Project	update
111	2	Lift_Project	readLimitOffsetStatus1
112	2	Lift_Project	amountStatus1
119	1	Lift_Prpost	create
120	1	Lift_Prpost	delete
121	1	Lift_Prpost	update
122	1	Lift_Prcommentary	create
123	1	Lift_Prcommentary	getLastId
124	1	Lift_Prcommentary	delete
125	2	Lift_Prcommentary	delete
126	2	Lift_Prcommentary	create
127	2	Lift_Prcommentary	getLastId
128	3	Lift_Prcommentary	delete
129	3	Lift_Prcommentary	create
130	3	Lift_Prcommentary	getLastId
149	1	Lift_Task	readAll
150	1	Lift_Task	readLimitOffset
151	1	Lift_Task	amount
152	1	Lift_Task	amountUser_id
153	1	Lift_Task	create
154	1	Lift_Task	amountBlog_id
155	1	Lift_Task	readLimitOffsetBlog_id
156	1	Lift_Task	read
157	1	Lift_Task	update
179	1	Lift_Task	getLastId
180	1	Lift_Task_access	create
181	1	Lift_Task_access	read
182	1	Lift_Task_access	delete
184	3	Lift_Prpost	create
186	2	Lift_Prpost	update
188	2	Lift_Prpost	delete
191	2	Lift_Post	getLastId
195	1	Lift_Page	delete
197	1	Lift_Blog_Follow	create
199	3	Lift_Blog_Follow	create
201	2	Lift_Blog_Follow	delete
210	1	Lift_Blog_Follow	read
208	3	Lift_Blog_Follow	read
211	1	Lift_Token	read
\.


--
-- Name: Lift_ACL_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_ACL_id_seq"', 115, true);


--
-- Data for Name: Lift_Badge; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_Badge" (id, type, "user", issue_time) FROM stdin;
\.


--
-- Name: Lift_Badge_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_Badge_id_seq"', 1, false);


--
-- Data for Name: Lift_Badge_type; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_Badge_type" (id, title, hint, image) FROM stdin;
\.


--
-- Name: Lift_Badge_type_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_Badge_type_id_seq"', 1, false);


--
-- Data for Name: Lift_Blog; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_Blog" (id, type, title, administrator, creation_time, editing_time, avatar, text, deleted) FROM stdin;
71	1	Личный блог пользователя ssss@ssss.ssss	27	2014-08-01 05:56:19	2014-08-01 05:56:19	\N	\N	f
72	1	Личный блог пользователя fj@fj.fj	28	2014-08-01 06:06:35	2014-08-01 06:06:35	\N	\N	f
70	2	Блог о науке	1	2014-08-01 05:53:37	2014-08-01 05:53:37	\N	\N	f
73	2	Блог о науке	1	2014-08-15 23:55:51	2014-08-15 23:55:51	\N	short	f
60	2	Блог о науке	1	2014-07-26 22:11:39	2014-08-15 23:57:02	f333bb786439a4ce2b08bae07bf1a09a.jpg	7777777777	f
61	2	Блог о науке	1	2014-07-26 22:19:47	2014-07-26 22:19:47	\N	\N	f
63	2	Блог о науке	1	2014-07-26 23:12:33	2014-07-26 23:13:57	a6wW98R_460s_v1.jpg	\N	f
64	2	Блог о науке	1	2014-07-26 23:16:26	2014-07-26 23:16:26	sunearthpanel_sts129.si.jpg	\N	f
62	2	Блог о науке	1	2014-07-26 22:21:00	2014-07-26 23:28:13	1744570649a6wW98R_460s_v1.jpg	\N	f
66	2	Блог о науке	1	2014-07-29 08:28:23	2014-07-29 08:28:23	\N	\N	f
67	2	Блог о науке	1	2014-07-29 08:29:59	2014-07-29 08:29:59	\N	\N	f
68	2	Блог о науке	1	2014-07-29 08:30:21	2014-07-29 08:30:21	\N	\N	f
69	2	Блог о науке	1	2014-07-29 09:02:22	2014-07-29 09:02:22	\N	\N	f
74	1	Личный блог пользователя ed@mailinator.com	30	2014-09-01 05:05:23	2014-09-01 05:05:23	\N	\N	f
75	2	safsdasf	1	2014-09-05 16:01:12	2014-09-05 16:01:12	c6b08bdd76ecd9ea6702467a7401e6ff.jpg		f
76	1	Личный блог пользователя rbt86@mail.ru	31	2014-09-09 05:06:45	2014-09-09 05:06:45	\N	\N	f
77	1	Личный блог пользователя aivengot@mail.ru	32	2014-09-09 05:07:36	2014-09-09 05:07:36	\N	\N	f
78	1	Личный блог пользователя lttf-user@lifttothefuture.ru	33	2014-09-09 05:11:49	2014-09-09 05:11:49	\N	\N	f
79	1	Личный блог пользователя lttf-curator@lifttothefuture.ru	34	2014-09-09 05:12:22	2014-09-09 05:12:22	\N	\N	f
80	1	Личный блог пользователя lttf-admin@lifttothefuture.ru	35	2014-09-09 05:12:50	2014-09-09 05:12:50	\N	\N	f
81	1	Личный блог пользователя alex@shnayder.pro	36	2014-09-09 10:18:49	2014-09-09 10:18:49	\N	\N	f
82	1	Личный блог пользователя osjf@os.ru	37	2014-09-11 01:15:03	2014-09-11 01:15:03	\N	\N	f
83	1	Личный блог пользователя osdf@os.ru	38	2014-09-11 01:20:08	2014-09-11 01:20:08	\N	\N	f
84	1	Личный блог пользователя sfl@os.ru	39	2014-09-11 12:46:44	2014-09-11 12:46:44	\N	\N	f
85	1	Личный блог пользователя oashf@os.ru	40	2014-09-11 08:47:35	2014-09-11 08:47:35	\N	\N	f
86	1	Личный блог пользователя oj@os.ru	41	2014-09-11 12:49:12	2014-09-11 12:49:12	\N	\N	f
87	1	Личный блог пользователя test@mailinator.com	42	2014-09-11 14:29:45	2014-09-11 14:29:45	\N	\N	f
88	1	Личный блог пользователя fairwe11@yandex.ru	43	2014-09-12 09:02:51	2014-09-12 09:02:51	\N	\N	f
89	1	Личный блог пользователя a.bodrov@festivalnauki.ru	44	2014-09-15 13:49:25	2014-09-15 13:49:25	\N	\N	f
90	1	Личный блог пользователя tarkhanova1307@gmail.com	45	2014-09-15 15:30:03	2014-09-15 15:30:03	\N	\N	f
91	2	4d	1	2014-09-25 08:33:33	2014-09-25 08:33:33	\N	asdfsd	t
\.


--
-- Data for Name: Lift_Blog_Follow; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_Blog_Follow" (id, blog, "user") FROM stdin;
\.


--
-- Name: Lift_Blog_Follow_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_Blog_Follow_id_seq"', 49, true);


--
-- Data for Name: Lift_Blog_Heading; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_Blog_Heading" (id, blog, heading) FROM stdin;
32	91	1
\.


--
-- Name: Lift_Blog_Heading_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_Blog_Heading_id_seq"', 32, true);


--
-- Data for Name: Lift_Blog_Subject; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_Blog_Subject" (id, blog, subject) FROM stdin;
29	91	2
\.


--
-- Name: Lift_Blog_Subject_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_Blog_Subject_id_seq"', 29, true);


--
-- Data for Name: Lift_Blog_access; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_Blog_access" (id, "user", blog, level) FROM stdin;
235	1	91	1
\.


--
-- Name: Lift_Blog_access_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_Blog_access_id_seq"', 235, true);


--
-- Name: Lift_Blog_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_Blog_id_seq"', 91, true);


--
-- Data for Name: Lift_Commentary; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_Commentary" (id, deleted, parent, post, "user", text, creation_time) FROM stdin;
\.


--
-- Name: Lift_Commentary_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_Commentary_id_seq"', 273, true);


--
-- Data for Name: Lift_Curators_resume; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_Curators_resume" (id, "user", heading, data) FROM stdin;
\.


--
-- Name: Lift_Curators_resume_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_Curators_resume_id_seq"', 1, false);


--
-- Data for Name: Lift_Heading; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_Heading" (id, name) FROM stdin;
1	Телеком
2	Промышленность
3	Биотех
4	Экология
5	Транспорт
6   Энергетика
7   Космос
8   «Лифт в будущее»
9   Образовательные программы
10	Международные проекты
\.


--
-- Name: Lift_Heading_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_Heading_id_seq"', 6, true);


--
-- Data for Name: Lift_Media_file; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_Media_file" (id, type, title, description, path) FROM stdin;
\.


--
-- Name: Lift_Media_file_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_Media_file_id_seq"', 1, false);


--
-- Data for Name: Lift_Media_page; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_Media_page" (id, media_file, page) FROM stdin;
\.


--
-- Name: Lift_Media_page_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_Media_page_id_seq"', 1, false);


--
-- Data for Name: Lift_Media_post; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_Media_post" (id, media_file, post) FROM stdin;
\.


--
-- Name: Lift_Media_post_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_Media_post_id_seq"', 1, false);


--
-- Data for Name: Lift_Page; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_Page" (id, title, text, status) FROM stdin;
74	Конкурсы «Лифт в будущее»	<h1 style="margin: 0px 0px 30px; font-family: Roboto, 'PT Sans', Arial, Tahoma, Verdana, sans-serif; font-weight: normal; line-height: 29.3999996185303px; color: #000000; text-rendering: optimizelegibility; font-size: 2.1em;">&nbsp;</h1>\r\n<h1 style="margin: 0px 0px 30px; font-family: Roboto, 'PT Sans', Arial, Tahoma, Verdana, sans-serif; font-weight: normal; line-height: 29.3999996185303px; color: #000000; text-rendering: optimizelegibility; font-size: 2.1em;">Система приоритетов</h1>\r\n<h2 style="margin: 20px 0px 10px; font-family: Roboto, 'PT Sans', Arial, Tahoma, Verdana, sans-serif; font-weight: normal; line-height: normal; color: #272727; text-rendering: optimizelegibility; font-size: 1.59em;">Цели конкурса</h2>\r\n<p style="margin: 8px 0px 15px; line-height: 1.3em; color: #272727; font-family: Arial, Tahoma, Verdana, sans-serif; font-size: 14px;">Конкурс &laquo;Система приоритетов&raquo; &ndash; это возможность стать участником Программы &laquo;Лифт в будущее&raquo;, вступить в сообщество сверстников, которые так же, как и вы интересуются исследовательской и проектной деятельностью, ищут площадки для реализации своих интересов, планируют дальнейший профессиональный рост, хотят обучаться в ведущих вузах России.</p>\r\n<h2 style="margin: 20px 0px 10px; font-family: Roboto, 'PT Sans', Arial, Tahoma, Verdana, sans-serif; font-weight: normal; line-height: normal; color: #272727; text-rendering: optimizelegibility; font-size: 1.59em;">Участие</h2>\r\n<p style="margin: 8px 0px 15px; line-height: 1.3em; color: #272727; font-family: Arial, Tahoma, Verdana, sans-serif; font-size: 14px;">Победители и призеры&nbsp;Конкурса награждаются путевками во Всероссийскую научно-образовательную школу &laquo;Лифт в будущее&raquo; и получают право представить свой проект на Ежегодной международной научной школьной конференции &laquo;Лифт в будущее&raquo;, которая в 2014 году будет проходить Москве.</p>\r\n<p style="margin: 8px 0px 15px; line-height: 1.3em; color: #272727; font-family: Arial, Tahoma, Verdana, sans-serif; font-size: 14px;">Дипломанты&nbsp;Конкурса награждаются путевками в межрегиональные научно-образовательные школы &laquo;Лифт в будущее&raquo;.</p>\r\n<p style="margin: 8px 0px 15px; line-height: 1.3em; color: #272727; font-family: Arial, Tahoma, Verdana, sans-serif; font-size: 14px;">Педагогам, подготовившим победителей Конкурса, будет предложено обучение по программе повышения квалификации на факультете &laquo;Высшая школа управления и инноваций&raquo; МГУ имени М.В.Ломоносова.</p>\r\n<p style="margin: 8px 0px 15px; line-height: 1.3em; color: #272727; font-family: Arial, Tahoma, Verdana, sans-serif; font-size: 14px;">Конкурс за 2014 год окончен; новый этап &laquo;Системы приоритетов&raquo; появится перед летними каникулами 2015 года.&nbsp;Для участия нужно зарегистрироваться на нашем интернет-портале:&nbsp;<a style="color: #1f92e1;" href="http://sp.lifttothefuture.ru/">sp.lifttothefuture.ru</a></p>\r\n<p>&nbsp;</p>\r\n<h1 style="margin: 0px 0px 30px; font-family: Roboto, 'PT Sans', Arial, Tahoma, Verdana, sans-serif; font-weight: normal; line-height: 29.3999996185303px; color: #000000; text-rendering: optimizelegibility; font-size: 2.1em;">Открытый молодежный конкурс &laquo;Intellect2All&raquo;</h1>\r\n<h2 style="margin: 20px 0px 10px; font-family: Roboto, 'PT Sans', Arial, Tahoma, Verdana, sans-serif; font-weight: normal; line-height: normal; color: #272727; text-rendering: optimizelegibility; font-size: 1.59em;">Цели конкурса</h2>\r\n<ul style="padding: 0px; margin: 0px 0px 10px 25px; color: #272727; font-family: Arial, Tahoma, Verdana, sans-serif; font-size: 14px; line-height: normal;">\r\n<li style="line-height: 20px;">Привлечение студентов, молодых ученых и специалистов к решению научно-технических и инновационных задач в интересах развития экономики РФ и отраслевой науки;</li>\r\n<li style="line-height: 20px;">выявление перспективных работ студентов, молодых ученых и специалистов и содействие их дальнейшему развитию, привлечение молодёжи к участию в проектах &laquo;Лифт в будущее&raquo;;</li>\r\n<li style="line-height: 20px;">содействие внедрению инноваций в производственный сектор АФК &laquo;Система&raquo;.</li>\r\n</ul>\r\n<h2 style="margin: 20px 0px 10px; font-family: Roboto, 'PT Sans', Arial, Tahoma, Verdana, sans-serif; font-weight: normal; line-height: normal; color: #272727; text-rendering: optimizelegibility; font-size: 1.59em;">Прием заявок</h2>\r\n<p style="margin: 8px 0px 15px; line-height: 1.3em; color: #272727; font-family: Arial, Tahoma, Verdana, sans-serif; font-size: 14px;">Прием заявок на конкурс осуществляется с 10 июня по 20 октября 2014.</p>\r\n<h2 style="margin: 20px 0px 10px; font-family: Roboto, 'PT Sans', Arial, Tahoma, Verdana, sans-serif; font-weight: normal; line-height: normal; color: #272727; text-rendering: optimizelegibility; font-size: 1.59em;">Участники конкурса</h2>\r\n<p style="margin: 8px 0px 15px; line-height: 1.3em; color: #272727; font-family: Arial, Tahoma, Verdana, sans-serif; font-size: 14px;">В конкурсе могут принимать участие студенты, аспиранты, молодые ученые и специалисты, в том числе работники малых инновационных компаний и предприятий реального сектора экономики.</p>\r\n<p style="margin: 8px 0px 15px; line-height: 1.3em; color: #272727; font-family: Arial, Tahoma, Verdana, sans-serif; font-size: 14px;">Возраст участников, не имеющих научной степени, и кандидатов наук не должен превышать 30 лет, для докторов наук &ndash; 35 лет на дату подачи конкурсной заявки.</p>\r\n<p style="margin: 8px 0px 15px; line-height: 1.3em; color: #272727; font-family: Arial, Tahoma, Verdana, sans-serif; font-size: 14px;">Заявки по технологическим открытиям и технологическим разработкам могут быть поданы от единственного лица, а также от команды, численность которой не должна превышать 3-х человек.</p>\r\n<p style="margin: 8px 0px 15px; line-height: 1.3em; color: #272727; font-family: Arial, Tahoma, Verdana, sans-serif; font-size: 14px;">Заявки в номинации &laquo;Лучший стартап в информационных и телекоммуникационных технологиях&raquo; подаются исключительно от команды, состоящей из 2-х и более участников.</p>\r\n<p style="margin: 8px 0px 15px; line-height: 1.3em; color: #272727; font-family: Arial, Tahoma, Verdana, sans-serif; font-size: 14px;">От одного участника или команды может быть подано неограниченное количество заявок.</p>\r\n<p style="margin: 8px 0px 15px; line-height: 1.3em; color: #272727; font-family: Arial, Tahoma, Verdana, sans-serif; font-size: 14px;">Для участия требуется подать заявку на <a href="http://lifttothefuture.ru/intellect2all">сайте конкурса</a>.</p>\r\n<p>&nbsp;</p>	t
75	Летние школы	<p>Lorem ipsum</p>	t
78	Событие 3	<p><span style="line-height: 22.3999996185303px;">Lorem ipsum</span></p>	t
76	Первая научная конференция школьников «Лифт в будущее»!	<p>Российский университет дружбы народов, 8 августа, 10.00.</p>\r\n<p>Ещё не закончили регистрацию гости и участники международного форума, ещё фотографировались у фонтанов &nbsp;команды зарубежных стран, а в фойе уже застрекотали, затарахтели, зажужжали действующие модели роботов, приборов, установок. Партнёры программы &laquo;Лифт в будущее&raquo; выставили здесь свои самые свежие наработки. Вот соревновательные роботы от &laquo;Технолаба&raquo;: стендистам достаточно было показать их возможности один раз, и пульт управления стал переходить из рук в руки мальчишек и девчонок, которые ещё за минуту до этого нерешительно стояли у стены.</p>\r\n<p>А вот электробайки, представленные студентами МАМИ. Один из создателей Антон Демьянов охотно рассказывал о конструктивных и технических особенностях своего детища, при этом разрешал на нём посидеть, посигналить, &nbsp;попереключать скорости,&nbsp;&ndash;&nbsp;в общем, почувствовать себя байкером. К нему даже очередь выстроилась. Все тут &nbsp;же расступились, увидев, что технику хочет опробовать &nbsp;одна из самых старших участников конференции &ndash; преподаватель школы из Великобритании Джулия Салмон. Леди уверенно подержала равновесие, покрутила руль, одобрила экологический &nbsp;принцип модели и отправилась изучать другие экспонаты.</p>\r\n<p>О научных интересах зарубежных гостей можно было догадаться по местам их скоплений. &laquo;Космонавты&raquo; совершали интерактивную экскурсию на Марс, энергетики то и дело просили включить ускоритель гидродинамического потока &nbsp;для гидро- и ветрогенераторов. Много вопросов было по карту для первоначальной спортивной подготовки &ndash; дублированное управление позволяло &nbsp;управлять машиной людям с ограниченными возможностями.</p>\r\n<p>Всё происходящее активно снимало студенческое телевидение РУДН.</p>\r\n<p>Белым караваном прибыли 7 автобусов с участниками Всероссийской школы &laquo;Лифт в будущее&raquo;. Жёлтые футболки, красные рюкзачки, фиолетовые ветровки,&nbsp;&ndash;&nbsp;площадь перед главным зданием РУДН &nbsp;стала похожа на огромную клумбу. &nbsp;300 победителей и призёров &nbsp;конкурса региональных школьных проектов &laquo;Система приоритетов&raquo; приехали в Москву &nbsp;для дальнейшего обучения &nbsp;проектной деятельности, и первые пять дней &nbsp; они будут &nbsp;работать в формате &nbsp; международной конференции. &nbsp;</p>\r\n<p>14.00. &nbsp;Актовый зал университета. Торжественная церемония открытия &nbsp;началась &nbsp; с приветствия заместителя министра образования и науки Российской Федерации &nbsp;Вениамина Каганова. &nbsp;Он поблагодарил всех гостей, приехавших на &nbsp;Первую международную конференцию &laquo;Лифт в будущее&raquo;. &nbsp;Это &nbsp;не просто &nbsp;творческое состязание, - сказал В. Каганов, &nbsp; &nbsp;- а широкий обмен опытом, &nbsp;возможность обсудить &nbsp; подходы к развитию научно-технического &nbsp;образования в разных странах.</p>\r\n<p>- Добро пожаловать в Россию, добро пожаловать в Москву! Двери корпорации &laquo;Система&raquo; всегда открыты для умных, активных и &nbsp;трудолюбивых детей, - &nbsp;президент Благотворительного фонда &laquo;Система&raquo; Татьяна Гвилава &nbsp;выразила уверенность, что ребята из 18 стран подружатся между собой и &nbsp;обогатят друг друга новыми творческими идеями.</p>\r\n<p>Руководитель программы &nbsp;&laquo;Лифт в будущее&raquo; Елена Шмелёва &nbsp;подчеркнула: никакие современные средства &nbsp;коммуникации &nbsp;не могут заменить &nbsp;человеческое общение. Поэтому организаторы нынешней конференции сделают всё, чтобы международная конференция &nbsp;проводилась &nbsp;ежегодно. Затем под аплодисменты зала Татьяна Гвилава и Елена Шмелёва вручили &nbsp; &nbsp;дипломы победителей авторам работ, признанных лучшими по итогам конкурса &laquo;Система приоритетов&raquo;. Эти 19 &nbsp;парней и девушек и &nbsp;вошли в команду, представляющую программу &nbsp;&laquo;Лифт в будущее&raquo; на международном форуме.</p>\r\n<p>Продолжил торжественную церемонию &nbsp; директор Московского Химического лицея &nbsp;Сергей Семёнов. Благодаря &nbsp;многолетнему &nbsp;успешному выступлению команды лицея на Международной научной школьной ярмарке, &nbsp; Российская Федерация &nbsp;в 2014 году впервые получила &nbsp; право &nbsp; принять ISSF. Сергей Евгеньевич привёл такие цифры: 18 стран-участниц ISSF &ndash; это всего 8% от общего числа стран, но это более 50% населения земного шара и 65 % валового продукта. А всех людей объединяет биосфера: воздух, вода, - им не требуется визы. Вывод простой&ndash; мы взаимосвязаны.</p>\r\n<p>Сергей Евгеньевич пригласил на сцену члена-корреспондента &nbsp;РАН, доктора химических наук, директора Института проблем устойчивого развития РХТУ им. Д. И. Менделеева, члена бюро Международного союза по теоретической и прикладной химии (IUPAC) Наталью Павловну Тарасову. &nbsp;Зал приготовился услышать серьёзные &nbsp; профессиональные тезисы, но из её уст &nbsp;прозвучало нечто поэтическое: &laquo; Химия &ndash; это музыка жизни, а химические элементы составляют гармонию всего живого и неживого вокруг нас. Нужно выстраивать гармонию между окружающей средой и развитием человечества&raquo;.</p>\r\n<p>Завершился выход Химического &nbsp;лицея &nbsp;совсем неожиданно &ndash; &nbsp;выступлением хора, встреченного горячими аплодисментами.</p>\r\n<p>Настроение зала подхватил ректор РУДН, &nbsp;в стенах которого проходит форум, Владимир Филиппов. Он напомнил лозунг Российского университета дружбы народов &ndash; &laquo;Мы готовим мировую элиту&raquo; и пожелал юным творцам стать мировой элитой, а для этого надо ставить перед собой высокие цели.</p>\r\n<p>Высокая цель тут же была сформулирована. Это сделал &nbsp;вице-президент компании &laquo;Башнефть&raquo; Олег Михайлов. Он заявил, что хочет обратиться к &nbsp;участникам конференции с вызовом. &nbsp;Человечество не готово отказаться от нефти и газа,- сказал он. &ndash; К сожалению, их добыча происходит с негативным воздействием на окружающую среду. Придумайте, как снабжать планету энергией и не выбрасывать такое количество СО2 в атмосферу! &nbsp;Сфокусируйте свои усилия на том, что даст прорыв человечеству!</p>\r\n<p>На этой высокой &nbsp;ноте конференция была объявлена открытой. &nbsp;Ребята разошлись по аудиториям, где начались презентации школьных проектов по направлениям: биотехнологии и медицина; инженерное дело и робототехника; информационно-телекоммуникационные технологии; устойчивое развитие и экология; энергетика.</p>	t
77	Просто о сложном	<p>&laquo;Просто о сложном&raquo; &ndash; так назывался конкурс программы &laquo;Лифт в будущее&raquo; для молодых ученых и журналистов, пишущих о науке, победителями которого мы стали. Я &ndash; одна из счастливцев и хочу поделиться своими впечатлениями. Чтобы получить главный приз &ndash; поездку в Гамбург, мы писали статьи на близкие нам темы и пытались понятным широкому кругу читателей языком рассказать о своей работе, явлениях, экспериментах и открытиях, опубликованных в серьезных научных журналах. Это оказалось не так просто: пришлось поломать голову над переводом с научного языка на популярный.</p>\r\n<p>Кто мы и откуда? Мы &ndash; победители конкурса &laquo;Просто о сложном-2013&raquo;. Студенты, аспиранты, молодые специалисты: Александра Виноградова (математик), Антон Колядин (физик), Артём Поромов (эколог), Елена Супрун (химик) из Москвы; Екатерина Коваленко и Данила Барский (химики) из Новосибирска; Мария Дзамукова (биолог) из Казани. Впервые встречаемся в аэропорту Гамбурга и не можем наговориться, как будто мы давно знакомы: &laquo;О чем была твоя статья?&raquo;, &laquo;Как ты узнал о конкурсе?&raquo;. Все настолько разные, но увлеченные, самостоятельные, активные. Нас встретил Александр Клиймук &ndash; куратор, переводчик и гид, ставший другом и сплотивший всех вокруг себя. Едем в гостиницу. Завтра начинается стажировка.</p>\r\n<p>На руках программа: день за днем расписан до мелочей, жизнь в течение двух недель перед нами. Увидев список мероприятий, каждый был уверен, что он составлен специально для него. Так вот зачем мы заранее заполняли анкету, где рассказали о своих интересах и пожеланиях к стажировке! Это оказалось не формальностью, а руководством для составления программы &ndash; интересы каждого были учтены. Для нашей команды основными направлениями стажировки стали химия и физика. Мы посетили такие предприятия, как Elantas Beck GmbH (производство изоляционных полимеров); PFANNENBERG GmbH (производство электротехники); Eurofins GmbH (анализ продуктов питания); Hydro Aluminium (прокат алюминия). Несколько исследовательских центров и лабораторий: DESY (Deutsches Elektronen-Synchrotron, электронный синхротрон); Гамбурский Университет (институты Прикладной физики и Физической химии); Центр прикладных нанотехнологий, Университет прикладных исследований. В программу входили лекции в музее электричества Electrum Hamburg; в музее пищевых добавок Deutsches Zusatzstoffmuseum, беседа в отделе науки газеты DIE ZEIT и многое другое.</p>\r\n<p>Каждый день мы узнавали для себя что-то новое. Нам было интересно всё, ведь развитие разных наук и отраслей идёт во взаимодействии и взаимопроникновении. Нам рассказали и показали, как делают подсветку для Эйфелевой башни, кондиционеры и сигнализации Pfannenberg; как определяют содержание тяжелых металлов и пестицидов в продуктах питания в Eurofins GmbH; как переплавляют алюминий и делают прокат на Hydro Aluminium; что находится внутри электронного синхротрона HERA и сколько &laquo;колец&raquo;, по которым движутся элементарные частицы, под Гамбургом:</p>\r\n<p><img style="display: block; margin: 0px auto;" src="https://lifttothefuture.ru/uploads/materials/students/5.jpg" alt="" width="940" /></p>	t
73	Научно-образовательные школы «Лифт в будущее»	<h1 style="margin: 0px 0px 30px; font-family: Roboto, 'PT Sans', Arial, Tahoma, Verdana, sans-serif; font-weight: normal; line-height: 29.399999618530273px; color: #000000; text-rendering: optimizelegibility; font-size: 2.1em;">&nbsp;</h1>\r\n<h1 style="margin: 0px 0px 30px; font-family: Roboto, 'PT Sans', Arial, Tahoma, Verdana, sans-serif; font-weight: normal; line-height: 29.399999618530273px; color: #000000; text-rendering: optimizelegibility; font-size: 2.1em;">Всероссийские научно-образовательные школы &laquo;Лифт в будущее&raquo;&nbsp;</h1>\r\n<p style="margin: 8px 0px 15px; line-height: 1.3em; color: #272727; font-family: Arial, Tahoma, Verdana, sans-serif; font-size: 14px;">Всероссийские научно-образовательные школы &laquo;Лифт в будущее&raquo; для учащихся, перешедших в 7-11 классы &ndash; это ежегодный образовательный проект программы &laquo;Лифт в будущее&raquo;. Школы традиционно проводятся летом, в августе для победителей и призеров Всероссийского конкурса региональных школьных проектов &laquo;Система приоритетов&raquo;, а также для победителей партнерских конкурсов.</p>\r\n<p style="margin: 8px 0px 15px; line-height: 1.3em; color: #272727; font-family: Arial, Tahoma, Verdana, sans-serif; font-size: 14px;">В 2012 и 2013 годах в летней школе прошло обучение около 400 талантливых школьников со всей территории Российской Федерации. Во время пребывания в летней школе с помощью преподавателя-куратора учащиеся выполняют и защищают исследовательские проекты, разрабатывают стратегии развития отраслей российской экономики и регионов РФ. В школе, кроме обязательной образовательной программы, ребята встречаются с ведущими представителями российского бизнеса, участвуют в мастер-классах, деловых играх и тренингах личностного роста, посещают экскурсии.</p>\r\n<h2 style="margin: 20px 0px 10px; font-family: Roboto, 'PT Sans', Arial, Tahoma, Verdana, sans-serif; font-weight: normal; line-height: normal; color: #272727; text-rendering: optimizelegibility; font-size: 1.59em;">Всероссийские научно-образовательные школы &laquo;Лифт в будущее&raquo; проводятся в целях:</h2>\r\n<ul style="padding: 0px; margin: 0px 0px 10px 25px; color: #272727; font-family: Arial, Tahoma, Verdana, sans-serif; font-size: 14px; line-height: normal;">\r\n<li style="line-height: 20px;">освоения школьниками современных технологий проектной работы, получения ими знаний о ее организационном и ресурсном обеспечении,</li>\r\n<li style="line-height: 20px;">приобретения ими опыта работы в проектных командах при решении междисциплинарных, отраслевых и технико-технологических задач.</li>\r\n</ul>\r\n<h2 style="margin: 20px 0px 10px; font-family: Roboto, 'PT Sans', Arial, Tahoma, Verdana, sans-serif; font-weight: normal; line-height: normal; color: #272727; text-rendering: optimizelegibility; font-size: 1.59em;">Задачи научно-образовательных школ &laquo;Лифт в будущее&raquo;:</h2>\r\n<ul style="padding: 0px; margin: 0px 0px 10px 25px; color: #272727; font-family: Arial, Tahoma, Verdana, sans-serif; font-size: 14px; line-height: normal;">\r\n<li style="line-height: 20px;">погружение школьников в теорию и практику проектной деятельности, включая обучение навыкам идентификации ключевой проблемы, формулирования (постановки) перечня задач, направленных на ее преодоление, разработки технологий их решения проектным методом;</li>\r\n<li style="line-height: 20px;">формирование и организация работы проектных команд для решения конкретных задач &ndash; ситуаций (проблемно ситуативное обучение) по тематическим направлениям Всероссийского конкурса региональных школьных проектов &laquo;Система приоритетов&raquo;;</li>\r\n<li style="line-height: 20px;">расширение представлений школьников об актуальных социально-экономических, научных, технологических проблемах через коммуникационное взаимодействие участников с представителями высокотехнологичного бизнеса, науки, органов власти;</li>\r\n<li style="line-height: 20px;">профессиональная ориентация школьников через создание обучающей ситуации для осознанного выбора будущей сферы и вида профессиональной деятельности.</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<h1 style="margin: 0px 0px 30px; font-family: Roboto, 'PT Sans', Arial, Tahoma, Verdana, sans-serif; font-weight: normal; line-height: 29.399999618530273px; color: #000000; text-rendering: optimizelegibility; font-size: 2.1em;">Межрегиональные научно-образовательные школы &laquo;Лифт в будущее&raquo;</h1>\r\n<p style="margin: 8px 0px 15px; line-height: 1.3em;">Проводятся для дипломантов Всероссийского конкурса региональных школьных проектов &laquo;Система приоритетов&raquo;.</p>\r\n<p style="margin: 8px 0px 15px; line-height: 1.3em;">Задачи Межрегиональных научно-образовательных школ &laquo;Лифт в будущее&raquo; совпадают с задачами Всероссийских школ. Однако при их проведении учитываются особенности развития и социально-экономической ситуации в регионе, на территории которого проводится школа.</p>\r\n<ul style="padding: 0px; margin: 0px 0px 10px 25px;">\r\n<li style="line-height: 20px; color: #272727; font-family: Arial, Tahoma, Verdana, sans-serif; font-size: 14px;"><a style="color: #1f92e1;" title="" href="https://lifttothefuture.ru/uploads/materials/pdf/f4770.pdf">Программа Зимней школы (PDF)</a></li>\r\n<li style="line-height: 20px; color: #272727; font-family: Arial, Tahoma, Verdana, sans-serif; font-size: 14px;"><a style="color: #1f92e1;" title="" href="https://lifttothefuture.ru/presentation-of-projects">О результатах проектной деятельности участников</a></li>\r\n<li><a style="color: #1f92e1;" title="" href="https://lifttothefuture.ru/winter-school-dairy">Отчет о Зимней научно-образовательной школе</a><span style="line-height: 20px;">&nbsp;&laquo;Лифт в будущее&raquo; для школьников Дальнего Востока</span></li>\r\n</ul>	t
\.


--
-- Name: Lift_Page_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_Page_id_seq"', 78, true);


--
-- Data for Name: Lift_Post; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_Post" (id, blog, title, text, creation_time, editing_time, "user", status, avatar, background, annotation, deleted) FROM stdin;
175	90	АМС «New Horizons» вышла на финишную прямую	<p style="margin: 0cm 0cm 0.0001pt; text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Плутон &mdash; одно из&nbsp;самых крупных небесных тел в&nbsp;поясе Койпера. Ещё до&nbsp;недавнего времени Плутон считался классической планетой, но в&nbsp;2006&nbsp;году его &laquo;разжаловали&raquo; в&nbsp;карлики.</span></p>\r\n<p style="margin: 0cm 0cm 0.0001pt; text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Существование этой планеты было предсказано в&nbsp;1905&nbsp;году известным американским астрономом Персивалем Лоуэллом. Наблюдая за&nbsp;Нептуном и Ураном, Лоуэлл обнаружил отклонения в&nbsp;их орбитах и предположил, что это вызвано действием гравитации неизвестного крупного объекта. В&nbsp;1915&nbsp;году Лоуэлл рассчитал возможное местоположение &laquo;планеты Икс&raquo;, однако найти её не успел. Девятая планета солнечной системы была открыта лишь спустя 15&nbsp;лет молодым сотрудником Бостонской обсерватории Лоуэлла &mdash; Клайдом Томбо.</span></p>\r\n<blockquote>\r\n<p style="margin: 0cm; margin-bottom: .0001pt; text-align: justify; text-indent: 35.45pt;"><em><span style="font-size: 14.0pt;">Клайд Томбо потратил на&nbsp;поиски Плутона почти год. За&nbsp;это время он открыл одну новую комету, несколько десятков переменных звезд и обнаружил сотни неизвестных до&nbsp;той поры астероидов.</span></em></p>\r\n</blockquote>\r\n<p style="margin: 0cm 0cm 0.0001pt; text-indent: 35.45pt; text-align: left;"><span style="font-size: 14pt; text-indent: 35.45pt; line-height: 1.4;">Клайд Томбо родился в&nbsp;1906 году в&nbsp;небогатой семье фермеров-арендаторов. Может, так и прожил бы всю свою жизнь в&nbsp;Канзасе, занимаясь сельским хозяйством, если бы однажды не увидел Луну в&nbsp;телескоп. С&nbsp;этого момента жизнь двенадцатилетнего мальчишки круто изменилась. Он увлекся астрономией.</span></p>\r\n<p style="margin: 0cm 0cm 0.0001pt; text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Когда Клайд заканчивал среднюю школу, его одноклассники написали в&nbsp;книге выпускников шутливое пророчество: &laquo;Томбо откроет новый мир&raquo;. Верил ли кто-нибудь из&nbsp;них, что это предсказание сбудется в&nbsp;самом скором времени?</span></p>\r\n<p style="margin: 0cm 0cm 0.0001pt; text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Свой первый телескоп Клайд построил сам. Он начал вести наблюдения за&nbsp;звездным небом и делать зарисовки планет: лунных кратеров, полярных шапок Марса, спутников Юпитера.</span></p>\r\n<p style="margin: 0cm 0cm 0.0001pt; text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Однажды Томбо отправил несколько своих рисунков в&nbsp;Лоуэлловскую обсерваторию. К&nbsp;величайшему удивлению юноши, директор обсерватории Весто Мелвин Слайфер очень высоко оценил его незаурядные способности и&hellip; предложил работу! Так двадцатидвухлетний канзасский фермер стал лаборантом-фотографом Лоуэлловской обсерватории.</span></p>\r\n<p style="margin: 0cm 0cm 0.0001pt; text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Задачу перед молодым лаборантом, не имевшим никакого специального образования, поставили непростую: заняться поисками &laquo;планеты Икс&raquo;.</span></p>\r\n<p style="margin: 0cm 0cm 0.0001pt; text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Томбо начал &laquo;охоту&raquo; за&nbsp;девятой планетой в&nbsp;начале апреля 1929 года. Он работал по 14 часов в&nbsp;сутки. В&nbsp;ночные часы Томбо фотографировал звезды в&nbsp;созвездии Близнецов &mdash; там, где, по мнению Лоуэлла, должна была находиться &laquo;планета Икс&raquo;, &mdash; а затем сравнивал снимки 2&ndash;3-дневной давности. Причем каждый участок звездного неба он снимал по три раза! </span></p>\r\n<p style="margin: 0cm 0cm 0.0001pt; text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Это была очень кропотливая, методичная и, конечно же, изматывающая работа.</span></p>\r\n<p style="margin: 0cm 0cm 0.0001pt; text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Парные негативы Томбо сравнивал на&nbsp;специальном приборе &mdash; блинк-микроскопе. Прибор был устроен так, что при быстрой смене изображений движущийся объект, если таковой попадался на&nbsp;снимке, как бы перепрыгивал с&nbsp;одного места на&nbsp;другое, а звезды при этом оставались неподвижными.</span></p>\r\n<p style="margin: 0cm 0cm 0.0001pt; text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">18&nbsp;февраля&nbsp;1930&nbsp;года Клайд Томбо наконец-то обнаружил крохотную прыгающую точку вблизи звезды дельты Близнецов. От&nbsp;неожиданности и от&nbsp;радости Клайд громко крикнул на&nbsp;всю лабораторию: &laquo;Вот она!</span></p>\r\n<blockquote>\r\n<p style="margin: 0cm; margin-bottom: .0001pt; text-align: justify; text-indent: 35.45pt;"><em><span style="font-size: 14.0pt;">Имя новой планете придумала одиннадцатилетняя школьница из&nbsp;Оксфорда Венеция Бёрни и получила за&nbsp;это в&nbsp;качестве награды 5&nbsp;фунтов стерлингов.</span></em></p>\r\n</blockquote>\r\n<p style="margin: 0cm 0cm 0.0001pt; text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Открытие Плутона стало настоящим открытием нового мира, как и предсказывали Томбо его одноклассники. Оно позволило отодвинуть границы нашей Солнечной системы сразу на&nbsp;полтора миллиарда километров.</span></p>\r\n<p style="margin: 0cm 0cm 0.0001pt; text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Клайд Томбо умер в&nbsp;1997</span><span lang="EN-US" style="font-size: 14.0pt; mso-ansi-language: EN-US;">&nbsp;</span><span style="font-size: 14.0pt;">году. Часть его праха, помещенная в&nbsp;специальную капсулу, летит сейчас на&nbsp;борту автоматической межпланетной станции &laquo;New Horizons&raquo;. </span></p>\r\n<p style="margin: 0cm 0cm 0.0001pt; text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">По расчетам НАСА, 15&nbsp;июля&nbsp;2015&nbsp;года &laquo;New Horizons&raquo; приблизится к&nbsp;Плутону на&nbsp;минимальное расстояние и пройдет всего лишь в&nbsp;12,5 тысяч километров от&nbsp;его поверхности. В&nbsp;этот период полета, который продлится девять дней, будет проведено детальное дистанционное исследование Плутона и Харона. В&nbsp;том числе будет проведена съемка ледяного карлика и его спутника с&nbsp;разрешением от&nbsp;1&nbsp;до&nbsp;40 километров, составлена карта распределения температур поверхности, исследована атмосфера этих небесных тел. Предполагается, что за&nbsp;это время станция соберет и впоследствии передаст на&nbsp;Землю более 4,5 гигабайт ценной научной информации. Скорость передачи данных будет составлять 768 бит/с. Таким образом, на&nbsp;передачу всех материалов исследования Плутона может быть затрачено полтора года.</span></p>\r\n<p style="margin: 0cm 0cm 0.0001pt; text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Плутон &mdash; это главная, но не конечная цель беспрецедентной космической экспедиции НАСА. В&nbsp;программу научных исследований &laquo;New Horizons&raquo; входит также возможное изучение других небесных тел пояса Койпера. А вот к&nbsp;кому из&nbsp;ледяных карликов, обитающих возле самых границ Солнечной системы, космическая станция отправится в&nbsp;гости после выполнения своей основной миссии, пока еще не известно.</span></p>\r\n<p style="margin: 0cm 0cm 0.0001pt; text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Первоначально миссия была рассчитана на&nbsp;15&ndash;17 лет. Но сейчас разработчики полагают, что станция сможет продолжить свою работу до&nbsp;2026</span><span lang="EN-US" style="font-size: 14.0pt; mso-ansi-language: EN-US;">&nbsp;</span><span style="font-size: 14.0pt;">года и выйти за&nbsp;пределы Солнечной системы.</span></p>	2014-09-18 15:45:01	2014-09-19 08:44:05	45	1	ba2e046aef7841a5a7f178b042e5b703.jpg	74a03cfe25315e8ee979c3fbb48178a0.jpg	Главная цель космической экспедиции НАСА, стартовавшей в январе 2006 года, — планета Плутон и её естественный спутник Харон.	f
174	90	Урбанизация способна изменить ландшафт, климат и… размер	<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Естественная среда обитания пауков-золотопрядов Nephila plumipes &mdash; австралийский буш. Золотопрядами их называют за&nbsp;золотистый отблеск нитей паутины. Nephila plumipes &mdash; самые крупные плетущие пауки Австралии, их размер (вместе с&nbsp;размахом ног) может достигать 12</span><span lang="EN-US" style="font-size: 14.0pt; mso-ansi-language: EN-US;">&nbsp;</span><span style="font-size: 14.0pt;">сантиметров. При таких габаритах золотопрядам &laquo;по зубам&raquo; даже маленькие птички. Но городские собратья пауков-золотопрядов еще крупнее. И виновата в&nbsp;этом урбанизация.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Наступление человека на&nbsp;природу ведется повсеместно, Австралия не исключение. Мегаполисы с&nbsp;их плотной городской застройкой, индустриальные центры, асфальтовые и бетонные дороги кардинально изменяют не только ландшафт, но и местный климат. Большинство животных, вытесненных человеком из&nbsp;естественной среды обитания, либо просто исчезает, либо влачит жалкое существование, не в&nbsp;силах обеспечить себя привычным пропитанием и надежным укрытием для выведения потомства. </span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Однако не для всех животных урбанизация несет гибель. Некоторые виды приспосабливаются к&nbsp;новым условиям и прекрасно выживают на&nbsp;асфальте в&nbsp;окружение железобетонных стен. Более того, в&nbsp;городе они чувствуют себя гораздо комфортней, чем в&nbsp;условиях нетронутой природы. Здесь теплее, больше еды, меньше конкуренция.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Один из&nbsp;самых наглядных индикаторов комфортного проживания &mdash; размер тела. Особи одного и того же вида, проживающие во враждебной среде и в&nbsp;благоприятной, по размерам значительно отличаются друг от&nbsp;друга. Вспомним хотя бы упитанных городских крыс. Или парковых белок.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">В ходе исследования австралийские ученые анализировали изменения физических характеристик пауков-золотопрядов, проживающих в&nbsp;разных районах Сиднея и в&nbsp;буше: производили анатомические измерения, определяли толщину жирового запаса и вес яичников. В&nbsp;результате выяснилось, что городские пауки не только крупнее и толще, они еще и плодовитее &mdash; быстрее размножаются и дают больше потомства, чем их &laquo;дикие&raquo; родственники. И это неудивительно. Ведь паукам, живущим в&nbsp;буше, чтобы &laquo;прокормить семью&raquo;, приходится целыми днями сидеть в&nbsp;засаде возле своей золотистой сети, карауля редкую добычу. А городским достаточно руку&hellip; эээ&hellip; лапу протянуть &mdash; и только успевай вынимать из&nbsp;сетей да консервировать впрок насекомых, откормленных на&nbsp;городских мусорных свалках.</span><span style="font-size: 16px; line-height: 1.4;">&nbsp;</span></p>\r\n<p style="margin: 0cm 0cm 0.0001pt; text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Работа австралийских ученых, опубликованная в&nbsp;журнале &laquo;PLoS ONE&raquo;, убедительно доказала, что некоторые животные прекрасно приспосабливаются к&nbsp;жизни в&nbsp;&laquo;каменных джунглях&raquo;. И что урбанизация, как это ни странно, даже способствует их процветанию.</span></p>	2014-09-18 15:30:56	2014-09-19 08:44:23	45	1	e1ea62fe2fab96786482ad462cab5a77.jpg	7e51f5ce697d1f92a98bfd03b5b17d51.jpg	Чем дальше в город — тем крупнее пауки. К такому выводу пришли австралийские биологи, исследовав 222 паука-золотопряда Nephila plumipes.	f
181	90	Китайский военный робот-пес	<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Первый китайский киберпес был создан в военном научно-исследовательском институте NORINCO. 130-килограммовый Da&nbsp;Gou способен бежать со скоростью 6 километров в час, преодолевать подъемы крутизной до 30 градусов и при этом нести 30 кг полезного груза.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">30 килограммов&nbsp;&mdash; это очень мало. Аналогичный американский киберпес АльфаДог, который, как говорят, послужил &laquo;образцом для подражания&raquo; китайским военным технологам, способен поднять и нести 160 кг. Хотя по своим габаритам и весу создание компании Boston Dynamics схоже с китайской моделью. Правда, у АльфаДога в груди вместо сердца бьется &laquo;пламенный мотор&raquo;&nbsp;&mdash; двигатель внутреннего сгорания. А у ДаГоу всего лишь аккумуляторная батарея, заряда которой хватает на два часа работы. </span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Впрочем, китайские разработчики уверяют, что &laquo;еще не вечер&raquo;. И что ДаГоу со временем тоже &laquo;научится&raquo; носить груз, превышающий его собственный вес. Ведь и АльфаДог не сразу &laquo;строился&raquo;. Его предшественник БигДог, созданный компанией Boston Dynamics в 2007 году, тоже поначалу больше ста килограммов не поднимал, да еще и тарахтел, как мотоцикл.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">АльфаДог работает гораздо тише. Он крупнее своего предшественника и больше похож на быка, чем на собаку, однако, не смотря на внушительные габариты, передвигается довольно-таки шустро. Киберпес легко взбирается на валуны и перепрыгивает через поваленные стволы деревьев. При этом скачет, как лошадь. Благодаря четырем гидравлическим ногам и системе стабилизации АльфаДог очень устойчив, может передвигаться по местности, недоступной для другого наземного транспорта, а также умеет вставать без посторонней помощи из положения &laquo;лежа на спине&raquo; и &laquo;лежа на боку&raquo;. </span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Но самое главное&nbsp;&mdash; железный новобранец Корпуса Морской Пехоты США не нуждается в непосредственном управлении. Командовать им можно удаленно. А при условии предварительного программирования АльфаДог способен сам передвигаться по пересеченной местности, выбирая наиболее подходящий маршрут. Для этого &laquo;механическая собачка&raquo; использует встроенные в него лазерный гироскоп, бинокулярную оптическую систему и <strong><span style="font-weight: normal; mso-bidi-font-weight: bold;">GPS-навигацию.</span></strong></span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><strong><span style="font-size: 14.0pt; font-weight: normal; mso-bidi-font-weight: bold;">Новая &laquo;игрушка&raquo; Пентагона, как и китайская киберсобака, предназначены в первую очередь для перевозки провизии и оружия в горной и городской местности. Возможно, в будущем эти &laquo;железные собачки&raquo; будут принимать участие в боевых действиях, но для этого их придется вооружить. А вот российский сторожевой пес-робот или, как записано в его официальной &laquo;родословной&raquo;, мобильный робототехнический комплекс&nbsp;&mdash; изначально задумывался, как настоящий &laquo;пес-воин&raquo;.</span></strong></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><strong><span style="font-size: 14.0pt; font-weight: normal; mso-bidi-font-weight: bold;">Впрочем, назвать &laquo;собачкой&raquo; это 900-килограммовое железное создание большой огневой мощности можно только условно.</span></strong></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><strong><span style="font-size: 14.0pt; font-weight: normal; mso-bidi-font-weight: bold;">Инженеры-технологи, электронщики и программисты Ижевского радиозавода, используя самые передовые промышленные технологии, оснастили сторожевого пса-робота не только лазерным дальномером, камерами, радаром, но и тяжелым пулеметом, а также другим современным оружием. Каким именно&nbsp;&mdash; военная тайна. </span></strong></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><strong><span style="font-size: 14.0pt; font-weight: normal; mso-bidi-font-weight: bold;">Скорость ижевской самоходной или даже &laquo;самобеглой&raquo; огневой точки&nbsp;&mdash; 45 километров в час, а заряда аккумулятора ему хватает на 10 часов работы.</span></strong></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><strong><span style="font-size: 14.0pt; font-weight: normal; mso-bidi-font-weight: bold;">У российского сторожевого робота-пса, презентованного ижевскими разработчиками в конце 2013 года, пока еще нет домашней клички. Но западные журналисты уже окрестили его (точнее, обозвали) Терминатором.</span></strong><strong><span style="font-size: 14.0pt; font-weight: normal; mso-bidi-font-weight: bold;">&nbsp;</span></strong></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><em><strong><span style="font-size: 14.0pt; font-weight: normal; mso-bidi-font-weight: bold;">Самые разнообразные роботы, созданные участниками проекта &laquo;Лифт в будущее&raquo;, имеют исключительно мирные профессии.&nbsp;</span></strong></em><em><strong><span style="font-size: 14.0pt; font-weight: normal; mso-bidi-font-weight: bold;">Например, в рамках нынешней Московской летней научно-образовательной школы был представлен проект сельскохозяйственного робота для точечной посадки семян с подкормкой и поливом.</span></strong></em><span style="font-size: 16px; line-height: 1.4;">&nbsp;</span><em><strong><span style="font-size: 14.0pt; font-weight: normal; mso-bidi-font-weight: bold;">А команда башкирских школьников продемонстрировала действующую модель робота-беспилотника для мониторинга экологической ситуации и взятия проб. Для его создания были использованы детали конструктора </span></strong></em><span style="font-size: 14.0pt;"><em>Lego, два микрокомпьютера NXT, датчик концентрации кислорода Vernier, беспроводная веб-камера c TV тюнером и пять моторов.</em></span></p>	2014-09-19 09:00:18	2014-09-19 09:01:12	45	1	8ef4349ad0653a5fa936b09f360c1272.jpg	36005c42a588849604719304cce7440a.jpg	Официально он называется «Горный четвероногий биоробот». Но есть и домашняя кличка — ДаГоу (Da Gou), что в переводе с мандаринского означает «большая собака».	f
182	90	Изобретение наркоза	<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">В древности врачи проводили подготовку пациента к хирургической операции в два этапа. Сначала ему давали выпить какую-нибудь одурманивающую настойку или отвар, чтобы хоть немного притупить боль. Затем пациента обездвиживали. Например, медным тазом. По голове. Или специальной деревянной колотушкой, обтянутой кожей. Такой наркоз давали в Древнем Египте. А в Древней Ассирии с этой же целью пациента перед операцией&hellip; душили. Слегка. Временная потеря сознания от удара по голове или от сдавленной сонной артерии давала возможность проводить несложные хирургические операции.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Шли столетия, проходили тысячелетия, но ничего не менялось.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">В донаркозные времена смерть на операционном столе от болевого шока никого не удивляла. А как врачи могли помочь пациентам справиться с болью? Никак. Разве что оттачивать свое мастерство и оперировать с космической скоростью. </span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Вот, например, наш знаменитый русский хирург Николай Иванович Пирогов был настоящим ассом своего дела. Он проводил ампутацию конечностей всего лишь за три минуты! Но даже такие первоклассные хирурги как Пирогов и мечтать не могли о более сложных и долгих операциях.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Все изменилось только в 1844 году. Знаете, что тогда произошло? У одного молодого американского дантиста Горация Уэлза&hellip; разболелись зубы. Представьте себе, у зубных врачей тоже иногда случаются неприятности с зубами. </span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Гораций Уэлз, всеми силами старался избежать встречи с зубоврачебным креслом. Он, как и большинство его пациентов, боялся боли. Уэлз мучился много дней. И вот однажды, пытаясь хоть как-то отвлечься от невыносимой зубной боли, Гораций отправился на ярмарку. А там какой-то бродячий фокусник развлекал публику действием веселящего газа&nbsp;&mdash; закиси азота. Фокусник вызывал на сцену добровольца, давал ему подышать закисью азота и уже через несколько минут опьяненный газом доброволец начинал нести забавную чушь и выделывать замысловатые &laquo;па&raquo; на потеху публике. </span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Уэлз тоже решил поучаствовать в представлении. Он вышел на сцену, вдохнул веселящий газ и вдруг с удивлением обнаружил, что зубная боль прошла.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">На следующий день Гораций Уэлз решил повторить эксперимент. Он вновь сходил на ярмарку, вдоволь надышался закисью азота, а затем отправился к своему коллеге дантисту и попросил вырвать больной зуб. </span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Первая в мире операция под наркозом прошла безболезненно. Уэлз воскликнул тогда от радости: &laquo;Начинается эпоха расцвета зубоврачебного дела!&raquo; На самом деле начиналось нечто большее&nbsp;&mdash; эпоха расцвета оперативной медицины.</span>&nbsp;</p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Изобретение наркоза считается одним из величайших открытий девятнадцатого века. Так что иногда даже больной зуб может изменить историю.</span></p>	2014-09-19 09:06:15	2014-09-19 09:08:26	45	1	7d56df1b32777aedc539152c21d4b69c.jpg	4af906690ebbcf42ab735f44b47f388e.jpg	Современная оперативная медицина немыслима без наркоза. Ведь человек может терпеть интенсивную боль не дольше пяти минут. А операции порой продолжаются несколько часов.	f
180	90	ДНК-компьютеры будущего	<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Разработчики разных прототипов компьютеров будущего преследуют по сути одну цель: создание полнофункционального квантового компьютера. Ведь все микрочастицы &mdash; атомы, молекулы, фотоны &mdash; подчиняются единым законам квантовой механики. Поэтому работы над любым типом машин, будь то молекулярные, квантовые, оптические или ДНК-компьютеры, имеют общий фундамент и общую проблему. Их задача &mdash; объединение частиц в совокупности и работа как с каждой частицей в отдельности, так и с совокупностью в целом.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Кроме того, система управления должна поддерживать масштабируемость системы частиц. Иначе невозможно будет наращивать мощность компьютера. Решение всех этих проблем станет очередным прорывом в науке.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Самой перспективной разработкой сегодня считается создание ДНК-компьютеров.</span></p>\r\n<blockquote>\r\n<p class="MsoNormal" style="text-align: justify; text-indent: 35.45pt;"><span style="font-size: 14.0pt;">&nbsp;</span><em><span style="font-size: 14.0pt;">Еще в&nbsp;далеком 1953&nbsp;году нобелевские лауреаты Фрэнсис Крик, Джеймс Уотсон и&nbsp;Морис Уилкинс, расшифровавшие структуру ДНК, сравнивали эту молекулу с&nbsp;машиной Тьюринга, гипотетическим предвестником современных процессоров.</span>&nbsp;</em></p>\r\n</blockquote>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Согласно прогнозу агентства IDC, к&nbsp;2020 году объем данных, созданных и&nbsp;сохраненных человечеством, достигнет 40&nbsp;000&nbsp;эксабайт. Это 40&nbsp;трлн гигабайт или 5200&nbsp;гигабайт на&nbsp;душу населения. Для хранения всей этой информации было&nbsp;бы достаточно менее 100&nbsp;г ДНК.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14pt; color: black; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;">Проблема защиты информации является одной из важнейших в современном мире. И речь здесь идет не только о государственных тайнах, новейших технологиях или оборонных секретах. Наши персональные данные, личная переписка и даже история покупок через интернет &mdash; все, что мы с легкостью доверяем &laquo;всемирной паутине&raquo;, &mdash; тоже могут представлять определенный интерес.</span>&nbsp;&nbsp;</p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><em><span style="font-size: 14pt; color: black; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;">В рамках летней научно-образовательной школы &laquo;Лифт в будущее&raquo;, проходившей в июне этого года во Владимире, было представлено два проекта, посвященных этой проблеме: &laquo;Диагностика безопасности Wi-</span><span lang="EN-US" style="font-size: 14pt; color: black; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;">F</span><span style="font-size: 14pt; color: black; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;">i сетей&raquo; и &laquo;Аутентификация пользователей по биометрическим параметрам&raquo;.</span></em></p>	2014-09-19 06:02:49	2014-09-19 08:41:44	45	1	1eee18e4597f1a7e99ef8295fc6ee981.jpg	ae9aa7f65bc9106d12b935a7f9e08c0c.png	Современные компьютеры давно не справляются с задачами, которые ставит перед ними человек. Какие устройства придут на смену устаревшим машинам: молекулярные, оптические, квантовые или ДНК-компьютеры?	f
176	90	Топливо из воды и солнечного света	<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Этот успешный эксперимент исследователей из национального университета в&nbsp;Канберре &mdash; ещё один шаг на пути к созданию экологически чистого и доступного альтернативного топлива. А также реальная возможность уменьшить зависимость человечества от углеводородных ископаемых ресурсов, запасы которых, в отличие от солнечного света и воды, не возобновляемы. </span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Над проблемой искусственного фотосинтеза ученые всего мира бьются вот уже лет тридцать, если не больше. Однако эффективно повторить это важнейшее эволюционное достижение природы до сих пор не удавалось никому. Скорость самых быстрых реакций, полученных в лабораторных условиях, была на два порядка ниже, чем у самого распоследнего сорняка, растущего где-нибудь в тени на обочине.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">И вот наконец-то австралийским учёным удалось добиться желаемого результата и повторить реакцию фотосинтеза со скоростью, близкой к природной.</span></p>\r\n<blockquote>\r\n<p class="MsoNormal" style="text-align: justify; text-indent: 35.45pt;"><em><span style="font-size: 14.0pt;">Фотосинтез &mdash; это процесс образования растениями и некоторыми бактериями органических веществ из неорганических (углекислого газа и воды) при помощи энергии света. У всех наземных растений и у большей части водных в ходе фотосинтеза выделяется кислород.</span></em>&nbsp;</p>\r\n</blockquote>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Чтобы повторить реакцию фотосинтеза австралийские исследователи использовали природный белок ферритин, который содержится в клетках тканей всех живых существ, в том числе человека, и служит для хранения железа. Но для своего эксперимента ученые заменили железо в белке на марганец. После чего подвергли модифицированный белок воздействию солнечного света.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Ученым удалось зафиксировать явный признак переноса электрического заряда, как в природном фотосинтезе. Руководитель исследовательской группы Уорвик Хилльер назвал это &laquo;электрическим сердцебиением&raquo;.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">&laquo;Все, что нам теперь остается сделать, &mdash; сказал ассистент профессора Хилльера доктор Хингрэни, &mdash; это создать генетически модифицированные бактерии Е-</span><span lang="EN-US" style="font-size: 14.0pt; mso-ansi-language: EN-US;">coli</span><span style="font-size: 14.0pt;">, которые стали бы источником готовых фотосинтетических белков, и просто &laquo;пролить&raquo; на них свет&raquo;.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Попытки использовать реакцию фотосинтеза для создания экологически чистого топлива предпринимаются не только в Австралии. Весной нынешнего года группе ученых из Швейцарского федерального технологического института в Цюрихе также удалось добиться серьезных успехов в этом направлении. Швейцарские ученые разработали многоэтапный процесс превращения воды, углекислого газа и солнечного света в керосин для реактивных двигателей. Свой проект они назвали SOLAR-JET.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Топливо будущего создается в специальной установке, где вода и углекислый газ подвергаются воздействию сконцентрированного солнечного света. Нагревание компонентов происходит в специальном реакторе из пористого материала на основе оксида цезия. В результате образуется так называемый синтез-газ &mdash; смесь водорода с монооксидом углерода (угарным газом), &mdash; который на заключительном этапе перерабатывается в жидкий углеводород. </span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Еще одной успешной попыткой создания экологически чистого топлива с помощью реакции фотосинтеза можно считать разработки исследовательской лаборатории автомобилестроительного концерна AUDI.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Немецкие ученые привлекли к сотрудничеству бактерий. Генетически модифицированные микроорганизмы с помощью солнечной энергии перерабатывают углекислый газ и воду в необычное синтетическое горючее, получившее название &laquo;е-топливо&raquo;.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Разработчики уже провели первую серию тестов и выяснили, что е-топливо сгорает более эффективно, чем горючее, полученное из жидких углеводородов. Энергии при этом вырабатывается больше, а вредных выбросов в атмосферу &mdash; меньше. К тому же в е-топливе полностью отсутствуют олефины и ароматические углеводороды.</span>&nbsp;</p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><em><span style="font-size: 14.0pt;">Московские участники нынешней летней научно-образовательной школы &laquo;Лифт в будущее&raquo; предложили свой вариант экологически чистого топлива. Они представили проект &laquo;Водородный аккумулятор&raquo;.</span></em></p>	2014-09-18 16:02:23	2014-09-19 08:42:40	45	1	34f1d8ce4d81cb0bcfde7e73af32a841.jpg	42934dbdf5919570d1a39fbb89a08985.jpg	Австралийским ученым удалось повторить одну из самых сложных природных технологий и воспроизвести реакцию фотосинтеза в лабораторных условиях.	f
179	90	Шестое массовое вымирание животных уже началось	<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Антропогенное давление на биосферу усиливается с каждым годом. В этих условиях все живые организмы &mdash; вне зависимости от того, какими формами они представлены, &mdash; должны быстро реагировать на экологическую дестабилизацию, чтобы сохранить свое присутствие на Земле. Но проблема заключается в том, что человек разрушает и уничтожает живую природу быстрее, чем она успевает перестраиваться и подстраиваться к новым условиям существования.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Сегодня под угрозой исчезновения находится около 20&nbsp;тысяч видов представителей фауны и флоры. Это 30% всей биомассы нашей планеты. По данным Международного Союза охраны природы, за последние 500&nbsp;лет полностью вымерло 844&nbsp;вида животных. По мнению экспертов, сами по себе эти цифры не настолько страшны, чтобы говорить о наступлении апокалипсиса. Но, к сожалению, нынешняя скорость исчезновения видов гораздо выше, чем во все предшествующие массовые вымирания. Если подобные темпы сохранятся, то уже в самое ближайшее время, через каких-нибудь 200&ndash;300&nbsp;лет, биосферу нашей планеты накроет очередная катастрофическая волна.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">В истории Земли массовые вымирания животных происходили не раз и не два. Большинство исследователей сходятся во мнении, что было, по меньшей мере, пять великих массовых вымираний и около десяти малых.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Первое великое массовое вымирание &mdash; <strong>Ордовикско-силурийское</strong> &mdash; произошло примерно 440&nbsp;миллионов лет тому назад. Тогда с лица Земли исчезло около 60% видов морских беспозвоночных. Причиной их гибели было резкое падение уровня мирового океана, глобальное похолодание и оледенение.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Второе &mdash; <strong>Девонское</strong> &mdash; массовое вымирание началось примерно 374&nbsp;миллиона лет назад. Оно продолжалось почти 15&nbsp;миллионов лет и состояло из двух пиков. Во время Девонского вымирания биосфера планеты лишилась половины всех существовавших родов и 20%</span><span lang="EN-US" style="font-size: 14.0pt; mso-ansi-language: EN-US;">&nbsp;</span><span style="font-size: 14.0pt;">семейств. Наиболее вероятной причиной этой катастрофы ученые считают распространение океанической аноксии, то есть недостатка кислорода. </span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Третье массовое вымирание было самым значительным глобальным биотическим кризисом в истории Земли. Пермско-триасовое или, как его еще называют, <strong>Великое пермское вымирание</strong>, произошло 250</span><span lang="EN-US" style="font-size: 14.0pt; mso-ansi-language: EN-US;">&nbsp;</span><span style="font-size: 14.0pt;">миллионов лет назад и полностью уничтожило почти всех обитателей планеты. Его жертвой пало 95%&nbsp;видов живых существ. И впервые за всю историю массовых вымираний подобная катастрофа затронула насекомых. Погибло 57%&nbsp;родов и 83%&nbsp;видов.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Следующее великое массовое вымирание животных &mdash; <strong>Триасово-юрское</strong> &mdash; произошло 200&nbsp;миллионов лет тому назад. Его считают самым крупным вымиранием мезозойской эры и самым скоротечным. Всего лишь за 10&nbsp;тысяч лет, то есть, по геологическим меркам почти мгновенно, погибла половина известных сейчас видов. В том числе 90%&nbsp;видов протомлекопитающих. Подлинный виновник этой трагедии до сих пор не установлен. Может быть, гибель животных произошла из-за падения на Землю крупного астероида. Может быть, из-за повышенной вулканической активности, отмеченной на границе триаса и юрского периода. Массовые извержения вулканов выбросили в атмосферу Земли огромное количество углекислого газа и диоксида серы, это стало причиной сначала глобального потепления до критически высоких температур, а затем резкого похолодания.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Пятое массовое вымирание животных &mdash; <strong>Мел-палеогеновое</strong> &mdash; известно даже маленьким детям как &laquo;Гибель динозавров&raquo;. Оно произошло 65 миллионов лет тому назад. Причиной мел-палеогенового массового вымирания чаще всего называют глобальное потепление, которое началось из-за падения на Землю астероида или метеорита, либо из-за столкновения Земли с кометой. Но есть и альтернативные версии. По одной из них в это самое время началось массовое распространение цветковых растений, и динозавры не смогли приспособиться к новой растительной пище.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">До сих пор все великие и малые массовые вымирания животных на нашей планете происходили по вине каких-либо природных катаклизмов или космических &laquo;пришельцев&raquo;. Ответственность за грядущую катастрофу целиком и полностью ляжет на нас. Если ученые правы и шестое массовое вымирание животных уже началось, то мы являемся не просто свидетелями, но и соучастниками убийства жизни на планете.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Впрочем, так называемая &laquo;точка невозврата&raquo; ещё не пройдена. И ещё есть возможность отсрочить или даже остановить процесс. Для этого нужно попытаться спасти от исчезновения те виды, которые оказались в критической опасности, и сохранить те, которые находятся в уязвимом положении. Иначе нашим далеким потомкам из всего разнообразия нынешних видов достанутся лишь членистоногие.</span>&nbsp;</p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Членистоногие, в отличие от остальных &laquo;братьев наших меньших&raquo;, обладают самой высокой потенциальной способностью противостоять экологическим стрессам. Но и им порой приходится несладко. Ученики одной из уфимских школ нынешним летом провели экологическую оценку почвы и водных объектов до и после загрязнения нефтепродуктами и выяснили, как живется дафниям в таких условиях. Их проект &laquo;Бедные дафнии&raquo; рассматривался в рамках летней научно-образовательной школы &laquo;Лифт в будущее&raquo; в Башкортостане.</span></p>	2014-09-19 05:54:03	2014-09-19 08:43:28	45	1	23dc77563d6e1d9d5300d649c23a636a.png	ee54ee91042658228203c060ddafd64e.jpg	Впервые за всю историю Земли причиной подобной катастрофы стала деятельность человека. Можно ли спасти исчезающие виды и сохранить видовое разнообразие фауны нашей планеты?	f
178	90	Эх, полным-полна моя… Вселенная	<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><strong><span style="font-size: 14.0pt;">Алмазные планеты</span></strong></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Первую алмазную планету открыли в 2004&nbsp;году. Американо-французская группа астрофизиков обнаружила ее в созвездии Рака &mdash; совсем недалеко от нас, всего лишь на расстоянии каких-нибудь 40&nbsp;световых лет. Планету назвали 55&nbsp;Cancri&nbsp;е по имени звезды 55&nbsp;Cancri, вокруг которой она вращается. На изучение этой уникальной планеты ученые потратили восемь лет. Они выяснили, что 55&nbsp;Cancri&nbsp;е почти полностью состоит из углерода &mdash; алмаза и графита. Причем большая часть алмазов аналогичны земным. А общий вес этих сокровищ соответствует массе трёх таких планет, как Земля. Помимо алмазов и графита на поверхности углеродной планеты было обнаружено очень небольшое количество железа и различных соединений кремния.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">К сожалению, даже если мы когда-нибудь доберемся до этой планеты, добывать алмазы на ней не получится, поскольку температура её поверхности превышает 1600&nbsp;градусов по шкале Цельсия. Слишком жарко.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Вторая алмазная планета была открыта совсем недавно, два года назад. Она находится гораздо дальше от нас. Но зато она в 4</span><span lang="EN-US" style="font-size: 14.0pt; mso-ansi-language: EN-US;">&nbsp;</span><span style="font-size: 14.0pt;">раза больше Земли и тоже почти целиком состоит из кристаллического углерода. Углеродная планета вращается вокруг миллисекундного пульсара PSR</span><span lang="EN-US" style="font-size: 14.0pt; mso-ansi-language: EN-US;">&nbsp;</span><span style="font-size: 14.0pt;">J1719-1438, поэтому ей присвоили имя PSR</span><span lang="EN-US" style="font-size: 14.0pt; mso-ansi-language: EN-US;">&nbsp;</span><span style="font-size: 14.0pt;">J1719-1438</span><span lang="EN-US" style="font-size: 14.0pt; mso-ansi-language: EN-US;">&nbsp;</span><span style="font-size: 14.0pt;">b.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Сам пульсар был открыт еще в 1992</span><span lang="EN-US" style="font-size: 14.0pt; mso-ansi-language: EN-US;">&nbsp;</span><span style="font-size: 14.0pt;">году. По массе он в полтора раза тяжелее нашего Солнца, но крохотный по размеру &mdash; в диаметре не более 20</span><span lang="EN-US" style="font-size: 14.0pt; mso-ansi-language: EN-US;">&nbsp;</span><span style="font-size: 14.0pt;">километров. Исследователи считают, что в прошлом он был частью звездной бинарной системы, которая взорвалась. Сейчас пульсар вращается вокруг своей оси с чудовищной скоростью &mdash; 10 тысяч оборотов в минуту.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Возможно, алмазная планета PSR</span><span lang="EN-US" style="font-size: 14.0pt; mso-ansi-language: EN-US;">&nbsp;</span><span style="font-size: 14.0pt;">J1719-1438</span><span lang="EN-US" style="font-size: 14.0pt; mso-ansi-language: EN-US;">&nbsp;</span><span style="font-size: 14.0pt;">b &mdash; это как раз и есть погибшая звезда, с которой бешено вращающийся пульсар содрал все: и корону, и мантию, и что там ещё у неё было, оставив только ядро, состоящее из кристаллического углерода и кислорода. Однако даже эти &laquo;остатки&raquo; в три тысячи раз крупнее самого пульсара.</span><span style="font-size: 14pt; text-indent: 35.45pt; line-height: 1.4;">&nbsp;</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;"><strong>Самая холодная звезда</strong></span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Это уникальное небесное тело было обнаружено в 2011</span><span lang="EN-US" style="font-size: 14.0pt; mso-ansi-language: EN-US;">&nbsp;</span><span style="font-size: 14.0pt;">году по соседству с Солнечной системой. Температура поверхности звезды, зарегистрированной под именем WISE</span><span lang="EN-US" style="font-size: 14.0pt; mso-ansi-language: EN-US;">&nbsp;</span><span style="font-size: 14.0pt;">1828+2650, не превышает 25</span><span lang="EN-US" style="font-size: 14.0pt; mso-ansi-language: EN-US;">&nbsp;</span><span style="font-size: 14.0pt;">градусов по Цельсию! Самая холодная звезда во Вселенной относится к классу &laquo;несостоявшихся звезд&raquo; или коричневых карликов. В отличие от обычных звезд, коричневые карлики не обладают массой, нужной для начала термоядерной реакции. Поэтому они постепенно угасают и охлаждаются. Но WISE</span><span lang="EN-US" style="font-size: 14.0pt; mso-ansi-language: EN-US;">&nbsp;</span><span style="font-size: 14.0pt;">1828+2650 превзошла всех своих несостоявшихся сестер. И, тем не менее, продолжает считаться звездой.</span>&nbsp;</p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;"><strong>Самая горячая звезда</strong></span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Самая горячая звезда во Вселенной была открыта в том же году, что и самая холодная. Группа астрофизиков Манчестерского университета обнаружила эту раскаленную до 200</span><span lang="EN-US" style="font-size: 14.0pt; mso-ansi-language: EN-US;">&nbsp;</span><span style="font-size: 14.0pt;">тысяч градусов звезду в планетарной туманности Бабочки &mdash; одной из самых красивых туманностей Вселенной.</span><span style="font-size: 14pt; text-indent: 35.45pt; line-height: 1.4;">&nbsp;</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;"><strong>Облака</strong></span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Какие только облака не встречаются на просторах Вселенной. Чаще всего, конечно, газопылевые. Но не так давно ученые обнаружили в космосе огромную дрейфующую тучу. Это самое большое из когда-либо виданных скоплений водяного пара. Размеры космической тучи в 100</span><span lang="EN-US" style="font-size: 14.0pt; mso-ansi-language: EN-US;">&nbsp;</span><span style="font-size: 14.0pt;">тысяч раз превышают размеры нашего Солнца. А запасов &laquo;дождика&raquo; в этой туче в 140</span><span lang="EN-US" style="font-size: 14.0pt; mso-ansi-language: EN-US;">&nbsp;</span><span style="font-size: 14.0pt;">триллионов раз больше, чем всей воды на Земле.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Информация про огромное кислотное облако, размером 16</span><span lang="EN-US" style="font-size: 14.0pt; mso-ansi-language: EN-US;">&nbsp;</span><span style="font-size: 14.0pt;">миллионов километров, впервые появилась в 2005</span><span lang="EN-US" style="font-size: 14.0pt; mso-ansi-language: EN-US;">&nbsp;</span><span style="font-size: 14.0pt;">году и с тех пор неоднократно то подтверждалась, то опровергалась. Одни ученые говорили, что облако кислотного тумана, рожденное черной дырой галактики Андромеда, движется к Земле со скоростью света и предрекали гибель нашей планеты 1</span><span lang="EN-US" style="font-size: 14.0pt; mso-ansi-language: EN-US;">&nbsp;</span><span style="font-size: 14.0pt;">июня 2014</span><span lang="EN-US" style="font-size: 14.0pt; mso-ansi-language: EN-US;">&nbsp;</span><span style="font-size: 14.0pt;">года. Другие ученые уверяли, что подобный объект не в состоянии передвигаться с такой скоростью, а если бы даже и мог, то его полет растянулся бы на 28</span><span lang="EN-US" style="font-size: 14.0pt; mso-ansi-language: EN-US;">&nbsp;</span><span style="font-size: 14.0pt;">тысяч лет. Так или иначе, но очередной предсказанный конец света мы пережили. И сейчас кислотное облако-убийцу все чаще называют &laquo;облаком-уткой&raquo;. Хотя его первооткрыватель &mdash; американский астрофизик Альберт Шервинский &mdash; продолжает доказывать существование в космосе кислотных облаков. </span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">На днях все мировые СМИ облетела сенсационная новость: неподалеку от центра галактики Млечный Путь обнаружено очередное уникальное облако, состоящее из&hellip; спирта!</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Размеры этого облака поражают воображение, ведь его протяженность 463</span><span lang="EN-US" style="font-size: 14.0pt; mso-ansi-language: EN-US;">&nbsp;</span><span style="font-size: 14.0pt;">миллиарда километров. В основном оно состоит из метилового спирта, также известного как древесный, и небольшого (по космическим меркам) количества этилового.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt;">Ученые уверяют, что в существовании спиртовых облаков нет ничего необычного, так как для их образования нужна комбинация достаточно распространённых во Вселенной веществ: водорода, углерода и кислорода. Тем не менее, доктор Лиза Харви-Смит &mdash; руководитель группы астрофизиков, обнаруживших в космосе исполинские запасы алкоголя, &mdash; считает, что &laquo;исследование &laquo;спиртовых облаков&raquo; может перевернуть наши представления о Вселенной, поскольку каждое новое вещество, обнаруженное в космосе, грозит переворотом в научной жизни&raquo;.</span></p>\r\n<p class="MsoNormal" style="text-indent: 35.45pt; text-align: left;"><span style="font-size: 14.0pt; mso-bidi-font-weight: bold;">Кстати, в одном из российских СМИ сообщение про спиртовое облако вышло под заголовком &laquo;Недосягаемое счастье&raquo;</span><span style="font-size: 14.0pt; font-family: Wingdings; mso-ascii-font-family: 'Times New Roman'; mso-hansi-font-family: 'Times New Roman'; mso-char-type: symbol; mso-symbol-font-family: Wingdings; mso-bidi-font-weight: bold;">J</span><span style="font-size: 14.0pt; mso-bidi-font-weight: bold;">.</span></p>	2014-09-19 05:47:34	2014-09-19 08:43:49	45	1	f291d4bf1474a58a0823f86d8047d6c6.jpg	c99b60d5742dfd51ec3b8c3e3621bae3.jpg	Чего только не обнаружили астрономы за годы изучения космоса: от алмазных планет до облаков спирта.	f
183	71	4de	<p>asfd</p>	2014-09-25 08:39:29	2014-09-25 08:39:29	1	1			asfsd	t
184	71	4444d	<p>asfd</p>	2014-09-25 13:48:34	2014-09-25 13:48:34	1	1			saf	t
\.


--
-- Data for Name: Lift_Post_Heading; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_Post_Heading" (id, post, heading) FROM stdin;
101	180	1
102	176	4
103	179	4
104	178	4
105	175	4
106	174	4
108	181	1
110	182	3
111	183	3
112	184	3
\.


--
-- Name: Lift_Post_Heading_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_Post_Heading_id_seq"', 112, true);


--
-- Data for Name: Lift_Post_Subject; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_Post_Subject" (id, post, subject) FROM stdin;
\.


--
-- Name: Lift_Post_Subject_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_Post_Subject_id_seq"', 41, true);


--
-- Name: Lift_Post_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_Post_id_seq"', 184, true);


--
-- Data for Name: Lift_Post_ip; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_Post_ip" (id, post, ip) FROM stdin;
34856	182	128.68.30.212
34706	174	91.221.60.82
34707	175	91.221.60.82
34857	182	195.7.190.130
34858	182	199.19.249.196
34859	180	195.7.190.130
34860	180	199.19.249.196
34861	180	92.100.74.134
34717	176	91.221.60.82
34720	174	94.251.15.180
34722	175	94.251.15.180
34723	174	37.144.166.183
34724	175	37.144.166.183
34726	176	37.144.166.183
34871	183	127.0.0.1
34732	176	94.251.15.180
34877	184	127.0.0.1
34880	182	62.113.218.160
34739	174	66.249.78.180
34740	175	66.249.78.187
34741	176	66.249.78.180
34881	181	62.113.218.160
34882	180	62.113.218.160
34883	179	62.113.218.160
34884	178	62.113.218.160
34885	176	62.113.218.160
34886	175	62.113.218.160
34748	178	91.221.60.82
34807	181	91.221.60.82
34887	174	62.113.218.160
34751	179	91.221.60.82
34809	182	91.221.60.82
34754	180	91.221.60.82
34755	180	94.251.15.180
34756	179	94.251.15.180
34758	178	94.251.15.180
34890	181	37.204.37.126
34814	176	5.255.253.76
34815	175	5.255.253.76
34816	180	109.124.55.136
34817	174	5.255.253.76
34818	182	109.124.55.136
34822	179	5.255.253.76
34823	178	5.255.253.76
34824	182	5.255.253.76
34825	180	5.255.253.76
34827	181	5.255.253.76
34828	175	128.68.30.212
34829	174	128.68.30.212
34830	176	128.68.30.212
34831	178	128.68.30.212
34832	179	128.68.30.212
34838	180	66.249.65.106
34839	181	66.249.65.98
34840	178	66.249.65.106
34841	182	66.249.65.106
34842	179	66.249.65.98
34845	175	109.124.55.136
34849	181	109.124.55.136
34850	182	94.251.15.180
34851	181	94.251.15.180
\.


--
-- Name: Lift_Post_ip_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_Post_ip_id_seq"', 34890, true);


--
-- Data for Name: Lift_Post_tag; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_Post_tag" (id, post, tag) FROM stdin;
\.


--
-- Name: Lift_Post_tag_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_Post_tag_id_seq"', 1, false);


--
-- Data for Name: Lift_Prcommentary; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_Prcommentary" (id, deleted, parent, post, "user", text, creation_time) FROM stdin;
\.


--
-- Name: Lift_Prcommentary_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_Prcommentary_id_seq"', 18, true);


--
-- Data for Name: Lift_Project; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_Project" (id, type, title, heading, administrator, creation_time, editing_time, start_time, end_time, background, description, relevance, purpose, solutions, avatar, deleted) FROM stdin;
101	2	проект	2	1	2014-09-25 13:56:32	2014-09-25 13:56:32	\N	\N		<p>asfd</p>	<p>asfsd</p>	<p>asf</p>	<p>asfsd</p>		t
100	2	4de	2	1	2014-09-25 08:47:25	2014-09-25 08:47:26	\N	\N		<p>asfd</p>	<p>asfd</p>	<p>asdfsd</p>	<p>sadfsd</p>		t
\.


--
-- Data for Name: Lift_Project_access; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_Project_access" (id, "user", project, level) FROM stdin;
\.


--
-- Name: Lift_Project_access_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_Project_access_id_seq"', 604, true);


--
-- Name: Lift_Project_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_Project_id_seq"', 101, true);


--
-- Data for Name: Lift_Prpost; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_Prpost" (id, project, title, text, creation_time, editing_time, "user", status, background, annotation, avatar, deleted) FROM stdin;
64	101	пост в проекте	<p>asf</p>	2014-09-25 13:56:51	2014-09-25 13:56:51	1	1		<p>asf</p>		t
\.


--
-- Name: Lift_Prpost_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_Prpost_id_seq"', 64, true);


--
-- Data for Name: Lift_Prpost_ip; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_Prpost_ip" (id, post, ip) FROM stdin;
25166	64	127.0.0.1
\.


--
-- Name: Lift_Prpost_ip_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_Prpost_ip_id_seq"', 25166, true);


--
-- Data for Name: Lift_Site; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_Site" (id, domain, name) FROM stdin;
\.


--
-- Name: Lift_Site_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_Site_id_seq"', 1, false);


--
-- Data for Name: Lift_Subject; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_Subject" (id, name) FROM stdin;
1	Математика
2	Информатика
3	Физика
4	Химия
5	Биология
6	Экология
7	География
8	История
\.


--
-- Name: Lift_Subject_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_Subject_id_seq"', 8, true);


--
-- Data for Name: Lift_Tag; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_Tag" (id, title) FROM stdin;
\.


--
-- Name: Lift_Tag_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_Tag_id_seq"', 1, false);


--
-- Data for Name: Lift_Task; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_Task" (id, project, title, text, creation_time, editing_time, "user", status, start_time, end_time, deleted) FROM stdin;
54	101	задача в проекте	<p>asfd</p>	2014-09-25 13:57:40	2014-09-25 13:57:40	1	1	2014-09-18 00:00:00	2014-09-26 00:00:00	t
\.


--
-- Data for Name: Lift_Task_access; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_Task_access" (id, "user", task, level) FROM stdin;
53	1	54	1
\.


--
-- Name: Lift_Task_access_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_Task_access_id_seq"', 53, true);


--
-- Name: Lift_Task_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_Task_id_seq"', 54, true);


--
-- Data for Name: Lift_Token; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_Token" (id, token, "user") FROM stdin;
70	640162f618c2df5d22d0900b01d8cb32	33
73	1e8bb84e2b663472e8b3660c3f5b3e05	1
74	a7e3e42d4c8cbd740262b20e13ca71a7	1
88	79414c140371f8a9978c5810a94ed3fc	4
89	656efbb3043b3eb0d4feac89b511c028	1
93	1b2c2a202a7ff3819d74a4306a1b80ad	1
94	64e40f0002a46f426fa124d6f916708e	2
95	8f2f03e127378fca9580df08c74be927	1
96	f2e6eb231cbfce3dbbdfe071c6fadb09	1
97	b3ab3df550eb4cc8d0de69a9035e401c	1
98	34eeb6041071a2104bd81b8a22f2fea1	1
100	c3fa0c6e904e45b91020a78e338364ef	1
101	0f46c737ba87aa7a22b0f16f2e6efddd	1
102	860ffc71384e6fcd74eeb802cea136dc	1
117	1f7779609f3f3b303a5998ed8722b8f6	6
118	fc6e79871a29a25dce69e3a839bbc37b	1
119	a6f7699ee366aa75855925b452d37d10	1
120	4ac05e9b4b7a4c3e8db5e4209a18f2d4	1
121	ed9ce2818bb02244b83bb666ef20b504	1
122	6a33001e0812f47cc1dbbd733455fff6	1
123	4912c039db74749a14eea6275da6530c	1
124	e937df63cbd8398bd0bdbe80dbd4a77b	1
125	ad5087e90dfc6f0e2ba9f6e5834a4b50	1
126	82b42854184f5ce32bbbf3aeb284d22e	1
127	81c3ddb7ca99d4a7139083579c82fdf4	1
129	5547c3470566df58435eeef14a338b94	1
130	cd8e066bd354f16f86fba38e7b4d29c1	1
133	ec0f8812ac2ca087b9ebaf2f7ef793d0	2
134	0b912355c3684b6559ddba874f43cfb5	1
136	b0a10c7ae316759ca9a26570cf060bab	1
137	606775ffc02de12f8a826e4f20d36cd1	1
141	79f8858c9db6930375cb01d31662acdb	1
142	85034c26f6af158e9452335be1593e13	1
146	0970dd907b0b57381fd26da2ba0dfada	1
147	234c990fd046844127976a729d3b0039	1
148	49e4a1e2fa0736f403c49b54fb9d02ff	1
154	8fabb52c52eb4cd5ac2ed9fffb30f8d1	1
155	0ca816dcb0aa991682ef99c2414de87c	1
156	246f7423385b27ae74b241c2178972ad	1
157	3e70b664bd420708e53d0e084725da3a	1
159	700f66da9280b1c4fe4402b128301f05	1
160	9ec41facf0ad091089b5d834d0eeb282	1
161	20d49ce380d0ef7efced960c1e387f3a	1
162	dcf9d6f9da6c7e903fb63ef94413e47e	1
164	aca7d735a13a40694b05a9a54fa9b159	1
167	de47f2638096e007c0fed36ae8cabbc6	29
169	78df008812862006de82fe47a03dc3cb	1
197	493a08db4526c4c74ea5efacbf9a1da2	1
198	690fe1ef2e363d497b955539d497db2e	1
199	59af90ece4c596033e7a469b0ffe0d8c	1
200	28c2005aebe04f40e3908e26ed185820	1
201	8f325bbc116f0af11655989273d85b08	1
206	2963265e75d90b156e41a52c6d0dfc37	1
208	6a760bdacf7f604c3652c5bdcc7955e7	30
209	93d07d44d2a178a8c25ea20d3699ae64	30
214	2c6a7dd3c81341578763e51bbc6d99bc	1
215	aee0452b382e84047acade1561aeda24	1
216	aa95b874b05fb4fff736ae830767e23b	1
217	9662bfff6890512a93f0729a467569f3	1
218	cce17a8a088c79b97d50e1378c55cdb0	1
219	3fc2a11bc019c3354c178a20e0583f13	1
220	93f25f7b115e496ce78cbe4ab0c13236	1
221	869f8d5bb74f31a8dd3a9fd1a2175cc9	1
222	5825409a39dc92c489380845e1c8089b	1
223	d4b59abe08a1d8f162c15e836f84f127	1
224	c4619fbc7908d4545ef1aaf6eef9f843	1
225	2ae272cb9ccaf29dde387e20fa043fdc	1
226	c82a9875bf5b99eaf76e90ccf01dc08c	1
227	c8c3ab79090c94c87cc6ceab1f6a69be	1
228	be8c780570af18110234108875eaad9d	1
229	d63950a8f503c282218b61a2931fea21	1
230	e5231f0ee7d6b6978907747df821e52c	1
231	b8ca8c127f44dbee0568d0fde806ce44	1
232	673af861bee60d021acf283bfd77d904	2
233	7304b218cb8cd9c5604321aca83c0263	1
234	284c2cad644e672351a7ebbfde8b0845	1
236	32a0e4d2eb0075aa614217c5c36adf94	1
239	2a79725ffaff4360b255e7df969b0991	1
241	de8aab7c1d38a10a8f66be5ce27799fd	29
243	fc9c8e29ba2c816bb014decf3d76355c	1
244	247ba621f06bf759cea481eafaf0ff02	1
245	35764502d8eb809520ddb0eb55215254	30
246	da2bcf410ea9867e6ca59be37cc71237	29
247	23ea86349a0759439d675acdad5467f3	29
248	a9fcbb0dd2c69fd02334527a9b6a4f51	1
250	b9c0c4d43fe986b3e892c44b8bf29180	1
251	cc6c077a0dc47201d4984dbf4d2696bd	1
252	f32662c091d544df3aab6beabb1e024c	1
253	83bec81d072911d287970f70936b734c	1
255	1e85376d39bd56f9f34d5ffc8c8d1a5b	1
256	04757e400a258e9ca0e2fcdd094ee422	1
257	a413aebc107b6f3fe659353bac2977be	1
258	a413aebc107b6f3fe659353bac2977be	1
259	a413aebc107b6f3fe659353bac2977be	1
260	a413aebc107b6f3fe659353bac2977be	1
261	a413aebc107b6f3fe659353bac2977be	1
262	a413aebc107b6f3fe659353bac2977be	1
263	a413aebc107b6f3fe659353bac2977be	1
264	a413aebc107b6f3fe659353bac2977be	1
265	a413aebc107b6f3fe659353bac2977be	1
266	a413aebc107b6f3fe659353bac2977be	1
267	a413aebc107b6f3fe659353bac2977be	1
268	a413aebc107b6f3fe659353bac2977be	1
269	a413aebc107b6f3fe659353bac2977be	1
270	a413aebc107b6f3fe659353bac2977be	1
271	a413aebc107b6f3fe659353bac2977be	1
272	a413aebc107b6f3fe659353bac2977be	1
273	a413aebc107b6f3fe659353bac2977be	1
274	9e86f9a6e3bc2f5345d9df9ca8fda9b4	1
323	757d833daa59d2280a8360f2991768bb	1
324	494c0738bf66eab1df27dd72bbed98da	1
325	d98391d4ae335f75126361e4c9f863ef	1
326	4c9b6ded5b810e2ee706bf204177aab0	1
281	c2383b2805e5ab4973059c16e539029b	1
282	17688a20739605a7c8c50f8ddb6b2b5a	1
283	6dc6e3a2c3a7398591636269cf4f868e	1
285	44f69c4c278b93d94447be1e92e6eaeb	32
330	85b605289637c40ae5deeb1ac209162e	1
289	5a69c64482b809cf5e0a4db6113114c5	32
290	8d0e684ba7a50a0ea6a803b05b9d0197	1
333	46c3cf99d73a9f9fdc6f7268d33d0754	36
335	63eb5052f3e88dd63562e3190aaecf80	36
336	e67bfd11b5b8fb4a37fa4b5fb2177d16	36
340	c44e53e9ac13d4f3f870ad23e12fd383	36
341	f67116e34d26e0da33b610d1e376e39e	31
342	ffb9c4eb87204c1becd0c18ee4a471f5	32
303	04e325e189c36e623b47fb2526254f9f	1
304	57159fcc9652ed07c28476ee436e6c41	32
305	b6bb8f8ab87e23ae9778cf057d015e46	1
306	02ba43a2235fc169de609dfa4f0326ec	31
343	c0e718990bff0c6b89f69486d9764632	36
308	a97d8ee2f2ec8cfc81697e7f6d133481	36
309	6d13b20c8afd7ba1bef760e26a913cb0	1
344	0cdfb96f018bfbda0a21c4acb72766f2	33
311	6e27481779f4783aaa78908f79d7204a	1
312	3f458d618563d59b44fd684539feac39	1
314	e7eaf738ab974a6090db1b44ca9548f4	1
346	91c29b191ccefc1675474a6ee70c4ef3	31
316	d8e782c45372d4477cd30c40deae6e78	38
318	2623256f707a1b3a3e89575ff4151f49	1
319	4c33b9a36189e80b3e6bfd97a93231e8	1
349	e141d38440afa58e968b4f1317f49125	33
350	65b43fa3ea66b9af255a4926d6b65227	33
352	96efa48083bb40bdfb4ad60a9617a9c4	32
353	6488936a0eb4435b21dba1014e054bea	32
356	154ae0471a85801955ebf2ad5b5f514e	31
357	ac5ee79bb8e1005d490ff1087960bb69	36
358	58f7bb6c2a004186ce79dfeb58575469	43
359	fdffab4f924f735b0be1709060f0c660	36
360	dc7262f3270b02188f0a74a3e84c89b9	35
361	a103aad606f05682ee562c72dcab83b7	1
362	40963108975dabdab180b2c465d65651	1
363	aa127ece51ef49831e44c0ed1aca579b	1
364	4d25ff8288cb851d27fd582758a6800d	1
366	7f5cd08afce80416d2a10598408dfb02	44
367	def57ae31ebd95f2cfbc07e5c6552626	45
369	338942cb8657f1405d0dacd023102a6f	1
370	0373aae473df2a22addef2523ceeee84	1
371	178f3e0d9a5ea10bc86da6d0526a900a	2
372	5cbc2b84162211209eb60b6aeedef987	1
378	bc19e68e17c45fd9713335ca67e84095	1
379	7d858b0baa8c5b93ab8ddb01706603f1	45
380	034528e023bffda4c16a49c09fb99603	1
381	d9f1aef4b98f44a1f8021d47785ff943	1
382	8d76a59cf309afd260152f165eaf0ece	45
383	1e3edc9524a383a9b939b545215a16fd	45
384	ee5ff2227365c2ce021046339841a85c	1
385	7d577eed6a68fcbefcefdfdbab266938	1
386	c64a518ff58309fb740a434529355c9d	1
387	e8bfa27145378085041cd27dd0c4030d	1
388	c6cebbab03a25e345ce8b4e6d07f7df8	1
390	9212b73564fffeb9551ac9dbfa23c48c	45
391	ab5689f530901397587b7e1bbc651d3d	1
392	83a191d2103992d1eba0fcc6d0e8cc23	35
393	a8ed71b8b1493d4a99b4ff0267a02580	45
394	b6a66e75c24b6b571856f4070a002e32	1
396	4ae0794768d55af6fa8c2529176ebfa6	45
397	6cdc2668a14108709f725ab6e1b822b6	1
398	48ead66dfc42535a2f82907ea413253a	45
400	177a6a8cc4128029b1bad87cd212d850	1
401	a1a3eb7874425c2fec73f7f57cc0b8b4	1
403	8bc3cb6f2363664c4d6d0a3c270d1764	1
404	61d3fd46bb11494376094b4e6061ed8a	1
405	c10a58d41e0ee60c4df84a5da9bcae02	35
\.


--
-- Name: Lift_Token_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_Token_id_seq"', 405, true);


--
-- Data for Name: Lift_Tskcommentary; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_Tskcommentary" (id, deleted, parent, task, "user", text, creation_time) FROM stdin;
\.


--
-- Name: Lift_Tskcommentary_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_Tskcommentary_id_seq"', 39, true);


--
-- Data for Name: Lift_User; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_User" (id, deleted, first_name, middle_name, second_name, email, password, "group", type, about, registration_time, update_time, data, avatar, background) FROM stdin;
6	f	Павел	Александрович	Корниенков	curator@curator.curator	9ff79b2993e09f6ff66283f07f952b83	3	2	\N	2014-07-01 03:22:01	2014-07-26 20:16:36	{\r\n    "glossary": {\r\n        "title": "example glossary",\r\n\t\t"GlossDiv": {\r\n            "title": "S",\r\n\t\t\t"GlossList": {\r\n                "GlossEntry": {\r\n                    "ID": "SGML",\r\n\t\t\t\t\t"SortAs": "SGML",\r\n\t\t\t\t\t"GlossTerm": "Standard Generalized Markup Language",\r\n\t\t\t\t\t"Acronym": "SGML",\r\n\t\t\t\t\t"Abbrev": "ISO 8879:1986",\r\n\t\t\t\t\t"GlossDef": {\r\n                        "para": "A meta-markup language, used to create markup languages such as DocBook.",\r\n\t\t\t\t\t\t"GlossSeeAlso": ["GML", "XML"]\r\n                    },\r\n\t\t\t\t\t"GlossSee": "markup"\r\n                }\r\n            }\r\n        }\r\n    }\r\n}	2.jpg	\N
32	f	2	2	2	aivengot@mail.ru	e9f888456b213a97571d4c844d04ce79	3	1		2014-09-09 05:07:36	2014-09-09 09:32:18	{"phone":"","skype":"","website":""}	\N	\N
29	f	Mikhail	Vasiljevitch	Matvienko	mourhoon@gmail.com	7eceead5bbb010c411ccc30ae95840e3	1	1	\N	2014-08-28 05:58:41	2014-08-28 06:19:33	{"phone":"9266662898","skype":"mike.matvienko","website":"www.ru"}	\N	\N
34	f	lttf-curator	1	1	lttf-curator@lifttothefuture.ru	194b0a668a869612d6c7488fb7fb2535	3	1	\N	2014-09-09 05:12:22	2014-09-09 06:28:01	{"phone":"","skype":"","website":""}	\N	\N
35	f	lttf-admin	22	22	lttf-admin@lifttothefuture.ru	194b0a668a869612d6c7488fb7fb2535	1	1	\N	2014-09-09 05:12:50	2014-09-09 06:28:06	{"phone":"","skype":"","website":""}	\N	\N
1	f	Павел	Александрович	Корниенков	admin@admin.admin	bdb8905effde22d56ccaa28afa7c5b10	1	1		2010-10-10 00:00:00	2014-09-12 06:12:18	{"phone":"","skype":"sdfgsdfgsdfhwe","website":""}	782044464bruce.jpg	922298445beautiful-small-flower-garden-kzg4x0uw.jpg
31	f	1	1	1	rbt86@mail.ru	e9f888456b213a97571d4c844d04ce79	1	1		2014-09-09 05:06:45	2014-09-09 06:27:47	{"phone":"","skype":"","website":""}	402b25f3b076f6465d9391579c206781.jpg	9ae4713375ba119a27c18c027f5d8ab6.jpg
36	f	Александр	Сергеевич	Шнайдер	alex@shnayder.pro	ca42448e8c3768daba8d4920f731963a	1	1		2014-09-09 10:18:49	2014-09-09 18:52:45	{"phone":"","skype":"","website":""}	5290be97b61bd6f5af60aaf2b55eb011.jpg	a84b73de9de9119768bdbc4c18d36cca.jpg
30	f	Миа	Брюсовна	Уоллес	ed@mailinator.com	3feccd25b1776bc14e8d71519d3d0b52	2	1		2014-09-01 05:05:23	2014-09-01 05:05:23	{"phone":"","skype":"","website":""}	1518936608mia.jpg	\N
33	f	User	Test	Test	lttf-user@lifttothefuture.ru	194b0a668a869612d6c7488fb7fb2535	2	1		2014-09-09 05:11:49	2014-09-12 06:13:40	{"phone":"91890912091029121212","skype":"Jldgadfasf","website":"adsfasdfasdf"}	a2feb01a570eec57198f198c3ff3a767.jpg	197600d9a8367afcd2eea1f9d6be5dc1.jpg
43	f	Камиль	Ринатович	Залипукин	fairwe11@yandex.ru	a7d0a861007441d8cf7c2cdfab186fed	2	1		2014-09-12 09:02:51	2014-09-12 09:02:51	{"phone":"9952819192","skype":"","website":""}	\N	\N
44	f	Andrey	Palich	Bodrov	a.bodrov@festivalnauki.ru	bd817d0a172719950ccfea5905b11089	2	1		2014-09-15 13:49:25	2014-09-15 13:49:25	{"phone":"","skype":"","website":""}	\N	\N
45	f	Александра	Николаевна	Тарханова	tarkhanova1307@gmail.com	2681a0dc8bc25ce2d16b36cb2307e59b	2	1		2014-09-15 15:30:03	2014-09-15 15:30:03	{"phone":"","skype":"","website":""}	\N	\N
\.


--
-- Data for Name: Lift_User_group; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Lift_User_group" (id, name) FROM stdin;
1	admins
2	users
3	curators
\.


--
-- Name: Lift_User_group_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_User_group_id_seq"', 1, true);


--
-- Name: Lift_User_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Lift_User_id_seq"', 45, true);


--
-- Name: Lift_ACL_group_class_function_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_ACL"
    ADD CONSTRAINT "Lift_ACL_group_class_function_key" UNIQUE ("group", class, function);


--
-- Name: Lift_ACL_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_ACL"
    ADD CONSTRAINT "Lift_ACL_pkey" PRIMARY KEY (id);


--
-- Name: Lift_Badge_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Badge"
    ADD CONSTRAINT "Lift_Badge_pkey" PRIMARY KEY (id);


--
-- Name: Lift_Badge_type_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Badge_type"
    ADD CONSTRAINT "Lift_Badge_type_pkey" PRIMARY KEY (id);


--
-- Name: Lift_Blog_Follow_blog_user_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Blog_Follow"
    ADD CONSTRAINT "Lift_Blog_Follow_blog_user_key" UNIQUE (blog, "user");


--
-- Name: Lift_Blog_Follow_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Blog_Follow"
    ADD CONSTRAINT "Lift_Blog_Follow_pkey" PRIMARY KEY (id);


--
-- Name: Lift_Blog_Heading_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Blog_Heading"
    ADD CONSTRAINT "Lift_Blog_Heading_pkey" PRIMARY KEY (id);


--
-- Name: Lift_Blog_Subject_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Blog_Subject"
    ADD CONSTRAINT "Lift_Blog_Subject_pkey" PRIMARY KEY (id);


--
-- Name: Lift_Blog_access_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Blog_access"
    ADD CONSTRAINT "Lift_Blog_access_pkey" PRIMARY KEY (id);


--
-- Name: Lift_Blog_access_user_blog_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Blog_access"
    ADD CONSTRAINT "Lift_Blog_access_user_blog_key" UNIQUE ("user", blog);


--
-- Name: Lift_Blog_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Blog"
    ADD CONSTRAINT "Lift_Blog_pkey" PRIMARY KEY (id);


--
-- Name: Lift_Commentary_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Commentary"
    ADD CONSTRAINT "Lift_Commentary_pkey" PRIMARY KEY (id);


--
-- Name: Lift_Curators_resume_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Curators_resume"
    ADD CONSTRAINT "Lift_Curators_resume_pkey" PRIMARY KEY (id);


--
-- Name: Lift_Heading_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Heading"
    ADD CONSTRAINT "Lift_Heading_pkey" PRIMARY KEY (id);


--
-- Name: Lift_Media_file_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Media_file"
    ADD CONSTRAINT "Lift_Media_file_pkey" PRIMARY KEY (id);


--
-- Name: Lift_Media_page_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Media_page"
    ADD CONSTRAINT "Lift_Media_page_pkey" PRIMARY KEY (id);


--
-- Name: Lift_Media_post_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Media_post"
    ADD CONSTRAINT "Lift_Media_post_pkey" PRIMARY KEY (id);


--
-- Name: Lift_Page_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Page"
    ADD CONSTRAINT "Lift_Page_pkey" PRIMARY KEY (id);


--
-- Name: Lift_Post_Heading_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Post_Heading"
    ADD CONSTRAINT "Lift_Post_Heading_pkey" PRIMARY KEY (id);


--
-- Name: Lift_Post_Subject_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Post_Subject"
    ADD CONSTRAINT "Lift_Post_Subject_pkey" PRIMARY KEY (id);


--
-- Name: Lift_Post_ip_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Post_ip"
    ADD CONSTRAINT "Lift_Post_ip_pkey" PRIMARY KEY (id);


--
-- Name: Lift_Post_ip_post_ip_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Post_ip"
    ADD CONSTRAINT "Lift_Post_ip_post_ip_key" UNIQUE (post, ip);


--
-- Name: Lift_Post_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Post"
    ADD CONSTRAINT "Lift_Post_pkey" PRIMARY KEY (id);


--
-- Name: Lift_Post_tag_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Post_tag"
    ADD CONSTRAINT "Lift_Post_tag_pkey" PRIMARY KEY (id);


--
-- Name: Lift_Prcommentary_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Prcommentary"
    ADD CONSTRAINT "Lift_Prcommentary_pkey" PRIMARY KEY (id);


--
-- Name: Lift_Project_access_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Project_access"
    ADD CONSTRAINT "Lift_Project_access_pkey" PRIMARY KEY (id);


--
-- Name: Lift_Project_access_user_project_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Project_access"
    ADD CONSTRAINT "Lift_Project_access_user_project_key" UNIQUE ("user", project);


--
-- Name: Lift_Project_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Project"
    ADD CONSTRAINT "Lift_Project_pkey" PRIMARY KEY (id);


--
-- Name: Lift_Prpost_ip_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Prpost_ip"
    ADD CONSTRAINT "Lift_Prpost_ip_pkey" PRIMARY KEY (id);


--
-- Name: Lift_Prpost_ip_post_ip_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Prpost_ip"
    ADD CONSTRAINT "Lift_Prpost_ip_post_ip_key" UNIQUE (post, ip);


--
-- Name: Lift_Prpost_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Prpost"
    ADD CONSTRAINT "Lift_Prpost_pkey" PRIMARY KEY (id);


--
-- Name: Lift_Site_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Site"
    ADD CONSTRAINT "Lift_Site_pkey" PRIMARY KEY (id);


--
-- Name: Lift_Subject_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Subject"
    ADD CONSTRAINT "Lift_Subject_pkey" PRIMARY KEY (id);


--
-- Name: Lift_Tag_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Tag"
    ADD CONSTRAINT "Lift_Tag_pkey" PRIMARY KEY (id);


--
-- Name: Lift_Task_access_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Task_access"
    ADD CONSTRAINT "Lift_Task_access_pkey" PRIMARY KEY (id);


--
-- Name: Lift_Task_access_user_task_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Task_access"
    ADD CONSTRAINT "Lift_Task_access_user_task_key" UNIQUE ("user", task);


--
-- Name: Lift_Task_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Task"
    ADD CONSTRAINT "Lift_Task_pkey" PRIMARY KEY (id);


--
-- Name: Lift_Token_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Token"
    ADD CONSTRAINT "Lift_Token_pkey" PRIMARY KEY (id);


--
-- Name: Lift_Tskcommentary_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_Tskcommentary"
    ADD CONSTRAINT "Lift_Tskcommentary_pkey" PRIMARY KEY (id);


--
-- Name: Lift_User_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_User"
    ADD CONSTRAINT "Lift_User_email_key" UNIQUE (email);


--
-- Name: Lift_User_group_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_User_group"
    ADD CONSTRAINT "Lift_User_group_pkey" PRIMARY KEY (id);


--
-- Name: Lift_User_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Lift_User"
    ADD CONSTRAINT "Lift_User_pkey" PRIMARY KEY (id);


--
-- Name: Lift_ACL_group_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_ACL"
    ADD CONSTRAINT "Lift_ACL_group_fkey" FOREIGN KEY ("group") REFERENCES "Lift_User_group"(id);


--
-- Name: Lift_Badge_type_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Badge"
    ADD CONSTRAINT "Lift_Badge_type_fkey" FOREIGN KEY (type) REFERENCES "Lift_Badge_type"(id);


--
-- Name: Lift_Blog_Follow_blog_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Blog_Follow"
    ADD CONSTRAINT "Lift_Blog_Follow_blog_fkey" FOREIGN KEY (blog) REFERENCES "Lift_Blog"(id);


--
-- Name: Lift_Blog_Follow_user_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Blog_Follow"
    ADD CONSTRAINT "Lift_Blog_Follow_user_fkey" FOREIGN KEY ("user") REFERENCES "Lift_User"(id);


--
-- Name: Lift_Blog_Heading_blog_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Blog_Heading"
    ADD CONSTRAINT "Lift_Blog_Heading_blog_fkey" FOREIGN KEY (blog) REFERENCES "Lift_Blog"(id);


--
-- Name: Lift_Blog_Heading_heading_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Blog_Heading"
    ADD CONSTRAINT "Lift_Blog_Heading_heading_fkey" FOREIGN KEY (heading) REFERENCES "Lift_Heading"(id);


--
-- Name: Lift_Blog_Subject_blog_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Blog_Subject"
    ADD CONSTRAINT "Lift_Blog_Subject_blog_fkey" FOREIGN KEY (blog) REFERENCES "Lift_Blog"(id);


--
-- Name: Lift_Blog_Subject_subject_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Blog_Subject"
    ADD CONSTRAINT "Lift_Blog_Subject_subject_fkey" FOREIGN KEY (subject) REFERENCES "Lift_Subject"(id);


--
-- Name: Lift_Commentary_parent_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Commentary"
    ADD CONSTRAINT "Lift_Commentary_parent_fkey" FOREIGN KEY (parent) REFERENCES "Lift_Commentary"(id);


--
-- Name: Lift_Commentary_post_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Commentary"
    ADD CONSTRAINT "Lift_Commentary_post_fkey" FOREIGN KEY (post) REFERENCES "Lift_Post"(id);


--
-- Name: Lift_Commentary_user_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Commentary"
    ADD CONSTRAINT "Lift_Commentary_user_fkey" FOREIGN KEY ("user") REFERENCES "Lift_User"(id);


--
-- Name: Lift_Curators_resume_heading_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Curators_resume"
    ADD CONSTRAINT "Lift_Curators_resume_heading_fkey" FOREIGN KEY (heading) REFERENCES "Lift_Heading"(id);


--
-- Name: Lift_Media_page_media_file_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Media_page"
    ADD CONSTRAINT "Lift_Media_page_media_file_fkey" FOREIGN KEY (media_file) REFERENCES "Lift_Media_file"(id);


--
-- Name: Lift_Media_post_media_file_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Media_post"
    ADD CONSTRAINT "Lift_Media_post_media_file_fkey" FOREIGN KEY (media_file) REFERENCES "Lift_Media_file"(id);


--
-- Name: Lift_Media_post_post_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Media_post"
    ADD CONSTRAINT "Lift_Media_post_post_fkey" FOREIGN KEY (post) REFERENCES "Lift_Post"(id);


--
-- Name: Lift_Post_Heading_heading_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Post_Heading"
    ADD CONSTRAINT "Lift_Post_Heading_heading_fkey" FOREIGN KEY (heading) REFERENCES "Lift_Heading"(id);


--
-- Name: Lift_Post_Heading_post_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Post_Heading"
    ADD CONSTRAINT "Lift_Post_Heading_post_fkey" FOREIGN KEY (post) REFERENCES "Lift_Post"(id);


--
-- Name: Lift_Post_Subject_post_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Post_Subject"
    ADD CONSTRAINT "Lift_Post_Subject_post_fkey" FOREIGN KEY (post) REFERENCES "Lift_Post"(id);


--
-- Name: Lift_Post_Subject_subject_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Post_Subject"
    ADD CONSTRAINT "Lift_Post_Subject_subject_fkey" FOREIGN KEY (subject) REFERENCES "Lift_Subject"(id);


--
-- Name: Lift_Post_ip_post_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Post_ip"
    ADD CONSTRAINT "Lift_Post_ip_post_fkey" FOREIGN KEY (post) REFERENCES "Lift_Post"(id);


--
-- Name: Lift_Post_tag_post_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Post_tag"
    ADD CONSTRAINT "Lift_Post_tag_post_fkey" FOREIGN KEY (post) REFERENCES "Lift_Post"(id);


--
-- Name: Lift_Post_tag_tag_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Post_tag"
    ADD CONSTRAINT "Lift_Post_tag_tag_fkey" FOREIGN KEY (tag) REFERENCES "Lift_Tag"(id);


--
-- Name: Lift_Prcommentary_parent_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Prcommentary"
    ADD CONSTRAINT "Lift_Prcommentary_parent_fkey" FOREIGN KEY (parent) REFERENCES "Lift_Prcommentary"(id);


--
-- Name: Lift_Prcommentary_post_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Prcommentary"
    ADD CONSTRAINT "Lift_Prcommentary_post_fkey" FOREIGN KEY (post) REFERENCES "Lift_Prpost"(id);


--
-- Name: Lift_Prcommentary_user_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Prcommentary"
    ADD CONSTRAINT "Lift_Prcommentary_user_fkey" FOREIGN KEY ("user") REFERENCES "Lift_User"(id);


--
-- Name: Lift_Project_access_user_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Project_access"
    ADD CONSTRAINT "Lift_Project_access_user_fkey" FOREIGN KEY ("user") REFERENCES "Lift_User"(id);


--
-- Name: Lift_Project_administrator_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Project"
    ADD CONSTRAINT "Lift_Project_administrator_fkey" FOREIGN KEY (administrator) REFERENCES "Lift_User"(id);


--
-- Name: Lift_Project_heading_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Project"
    ADD CONSTRAINT "Lift_Project_heading_fkey" FOREIGN KEY (heading) REFERENCES "Lift_Heading"(id);


--
-- Name: Lift_Prpost_ip_post_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Prpost_ip"
    ADD CONSTRAINT "Lift_Prpost_ip_post_fkey" FOREIGN KEY (post) REFERENCES "Lift_Prpost"(id);


--
-- Name: Lift_Prpost_user_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Prpost"
    ADD CONSTRAINT "Lift_Prpost_user_fkey" FOREIGN KEY ("user") REFERENCES "Lift_User"(id);


--
-- Name: Lift_Task_access_task_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Task_access"
    ADD CONSTRAINT "Lift_Task_access_task_fkey" FOREIGN KEY (task) REFERENCES "Lift_Task"(id);


--
-- Name: Lift_Task_access_user_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Task_access"
    ADD CONSTRAINT "Lift_Task_access_user_fkey" FOREIGN KEY ("user") REFERENCES "Lift_User"(id);


--
-- Name: Lift_Task_project_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Task"
    ADD CONSTRAINT "Lift_Task_project_fkey" FOREIGN KEY (project) REFERENCES "Lift_Project"(id);


--
-- Name: Lift_Task_user_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Task"
    ADD CONSTRAINT "Lift_Task_user_fkey" FOREIGN KEY ("user") REFERENCES "Lift_User"(id);


--
-- Name: Lift_Tskcommentary_parent_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Tskcommentary"
    ADD CONSTRAINT "Lift_Tskcommentary_parent_fkey" FOREIGN KEY (parent) REFERENCES "Lift_Tskcommentary"(id);


--
-- Name: Lift_Tskcommentary_task_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Tskcommentary"
    ADD CONSTRAINT "Lift_Tskcommentary_task_fkey" FOREIGN KEY (task) REFERENCES "Lift_Task"(id);


--
-- Name: Lift_Tskcommentary_user_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_Tskcommentary"
    ADD CONSTRAINT "Lift_Tskcommentary_user_fkey" FOREIGN KEY ("user") REFERENCES "Lift_User"(id);


--
-- Name: Lift_User_group_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Lift_User"
    ADD CONSTRAINT "Lift_User_group_fkey" FOREIGN KEY ("group") REFERENCES "Lift_User_group"(id);


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

