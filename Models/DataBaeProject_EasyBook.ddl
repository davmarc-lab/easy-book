-- *********************************************
-- * Standard SQL generation                   
-- *--------------------------------------------
-- * DB-MAIN version: 11.0.2              
-- * Generator date: Sep 14 2021              
-- * Generation date: Sat Jul 15 16:42:07 2023 
-- * LUN file: E:\FILES\Università\SecondoAnno\DataBase_2023\easy-book\Models\EasyBook.lun 
-- * Schema: FirstModel/SQL 
-- ********************************************* 


-- Database Section
-- ________________ 

create database FirstModel;


-- DBSpace Section
-- _______________


-- Tables Section
-- _____________ 

create table AGENZIA_ (
     id numeric(1) not null,
     U_A_id numeric(1) not null,
     proprietario char(1) not null,
     sedeFisica char(1) not null,
     constraint ID_AGENZIA__ID primary key (id),
     constraint FKUTE_AGE_ID unique (U_A_id));

create table CLIENTE (
     id numeric(1) not null,
     constraint FKUTE_CLI_ID primary key (id));

create table COUPON (
     id char(1) not null,
     codiceSconto char(1) not null,
     descrizione char(1) not null,
     Dis_id numeric(1) not null,
     constraint ID_COUPON_ID primary key (id));

create table DIPENDENTE (
     id numeric(1) not null,
     Con_id numeric(1) not null,
     constraint FKUTE_DIP_ID primary key (id));

create table effettua (
     ID_MAN numeric(10) not null,
     id char(1) not null,
     constraint ID_effettua_ID primary key (id, ID_MAN));

create table impiega (
     I_M_id char(1) not null,
     id char(1) not null,
     constraint ID_impiega_ID primary key (I_M_id, id));

create table LOCALITA (
     id char(1) not null,
     nome char(1) not null,
     stato char(1) not null,
     continente char(1) not null,
     constraint ID_LOCALITA_ID primary key (id));

create table MANUTENZIONE (
     ID_MAN -- Sequence attribute not implemented -- not null,
     RIPARAZIONE numeric(10),
     REVISIONE numeric(10),
     constraint ID_ID primary key (ID_MAN));

create table MEZZO (
     id char(1) not null,
     Pos_id numeric(1) not null,
     constraint ID_MEZZO_ID primary key (id));

create table prenota (
     P_C_id numeric(1) not null,
     id char(1) not null,
     numeroPersone char(1) not null,
     constraint ID_prenota_ID primary key (P_C_id, id));

create table REVISIONE (
     ID_MAN numeric(10) not null,
     constraint FKMAN_REV_ID primary key (ID_MAN));

create table RIPARAZIONE (
     ID_MAN numeric(10) not null,
     constraint FKMAN_RIP_ID primary key (ID_MAN));

create table UTENTE (
     id numeric(1) not null,
     nome varchar(1) not null,
     cognome char(1) not null,
     telefono char(1) not null,
     email char(1) not null,
     password char(1) not null,
     DIPENDENTE numeric(1),
     CLIENTE numeric(1),
     AGENZIA_ numeric(1),
     constraint ID_UTENTE_ID primary key (id));

create table verso (
     V_L_id char(1) not null,
     id char(1) not null,
     constraint ID_verso_ID primary key (V_L_id, id));

create table VIAGGIO (
     id char(1) not null,
     postiDisponibili char(1) not null,
     dataPartenza char(1) not null,
     dataArrivo char(1) not null,
     descrizione char(1) not null,
     prezzo char(1) not null,
     Org_id numeric(1) not null,
     constraint ID_VIAGGIO_ID primary key (id));


-- Constraints Section
-- ___________________ 

alter table AGENZIA_ add constraint ID_AGENZIA__CHK
     check(exists(select * from DIPENDENTE
                  where DIPENDENTE.Con_id = id)); 

alter table AGENZIA_ add constraint ID_AGENZIA__CHK
     check(exists(select * from MEZZO
                  where MEZZO.Pos_id = id)); 

alter table AGENZIA_ add constraint FKUTE_AGE_FK
     foreign key (U_A_id)
     references UTENTE;

alter table CLIENTE add constraint FKUTE_CLI_FK
     foreign key (id)
     references UTENTE;

alter table COUPON add constraint FKdispone_FK
     foreign key (Dis_id)
     references AGENZIA_;

alter table DIPENDENTE add constraint FKUTE_DIP_FK
     foreign key (id)
     references UTENTE;

alter table DIPENDENTE add constraint FKcontratto_FK
     foreign key (Con_id)
     references AGENZIA_;

alter table effettua add constraint FKeff_MEZ
     foreign key (id)
     references MEZZO;

alter table effettua add constraint FKeff_MAN_FK
     foreign key (ID_MAN)
     references MANUTENZIONE;

alter table impiega add constraint FKimp_VIA_FK
     foreign key (id)
     references VIAGGIO;

alter table impiega add constraint FKimp_MEZ
     foreign key (I_M_id)
     references MEZZO;

alter table LOCALITA add constraint ID_LOCALITA_CHK
     check(exists(select * from verso
                  where verso.V_L_id = id)); 

alter table MANUTENZIONE add constraint EXTONE_MANUTENZIONE
     check((REVISIONE is not null and RIPARAZIONE is null)
           or (REVISIONE is null and RIPARAZIONE is not null)); 

alter table MEZZO add constraint ID_MEZZO_CHK
     check(exists(select * from impiega
                  where impiega.I_M_id = id)); 

alter table MEZZO add constraint FKpossiede_FK
     foreign key (Pos_id)
     references AGENZIA_;

alter table prenota add constraint FKpre_VIA_FK
     foreign key (id)
     references VIAGGIO;

alter table prenota add constraint FKpre_CLI
     foreign key (P_C_id)
     references CLIENTE;

alter table REVISIONE add constraint FKMAN_REV_FK
     foreign key (ID_MAN)
     references MANUTENZIONE;

alter table RIPARAZIONE add constraint FKMAN_RIP_FK
     foreign key (ID_MAN)
     references MANUTENZIONE;

alter table UTENTE add constraint EXTONE_UTENTE
     check((AGENZIA_ is not null and DIPENDENTE is null and CLIENTE is null)
           or (AGENZIA_ is null and DIPENDENTE is not null and CLIENTE is null)
           or (AGENZIA_ is null and DIPENDENTE is null and CLIENTE is not null)); 

alter table verso add constraint FKver_VIA_FK
     foreign key (id)
     references VIAGGIO;

alter table verso add constraint FKver_LOC
     foreign key (V_L_id)
     references LOCALITA;

alter table VIAGGIO add constraint ID_VIAGGIO_CHK
     check(exists(select * from impiega
                  where impiega.id = id)); 

alter table VIAGGIO add constraint ID_VIAGGIO_CHK
     check(exists(select * from verso
                  where verso.id = id)); 

alter table VIAGGIO add constraint FKorganizza_FK
     foreign key (Org_id)
     references AGENZIA_;


-- Index Section
-- _____________ 

create unique index ID_AGENZIA__IND
     on AGENZIA_ (id);

create unique index FKUTE_AGE_IND
     on AGENZIA_ (U_A_id);

create unique index FKUTE_CLI_IND
     on CLIENTE (id);

create unique index ID_COUPON_IND
     on COUPON (id);

create index FKdispone_IND
     on COUPON (Dis_id);

create unique index FKUTE_DIP_IND
     on DIPENDENTE (id);

create index FKcontratto_IND
     on DIPENDENTE (Con_id);

create unique index ID_effettua_IND
     on effettua (id, ID_MAN);

create index FKeff_MAN_IND
     on effettua (ID_MAN);

create unique index ID_impiega_IND
     on impiega (I_M_id, id);

create index FKimp_VIA_IND
     on impiega (id);

create unique index ID_LOCALITA_IND
     on LOCALITA (id);

create unique index ID_IND
     on MANUTENZIONE (ID_MAN);

create unique index ID_MEZZO_IND
     on MEZZO (id);

create index FKpossiede_IND
     on MEZZO (Pos_id);

create unique index ID_prenota_IND
     on prenota (P_C_id, id);

create index FKpre_VIA_IND
     on prenota (id);

create unique index FKMAN_REV_IND
     on REVISIONE (ID_MAN);

create unique index FKMAN_RIP_IND
     on RIPARAZIONE (ID_MAN);

create unique index ID_UTENTE_IND
     on UTENTE (id);

create unique index ID_verso_IND
     on verso (V_L_id, id);

create index FKver_VIA_IND
     on verso (id);

create unique index ID_VIAGGIO_IND
     on VIAGGIO (id);

create index FKorganizza_IND
     on VIAGGIO (Org_id);

