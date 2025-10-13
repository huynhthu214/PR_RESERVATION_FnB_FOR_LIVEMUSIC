/*==============================================================*/
/* Table: CUSTOMER_USERS                                        */
/*==============================================================*/
create table CUSTOMER_USERS
(
   CUSTOMER_ID          varchar(10) not null  comment '',
   USERNAME             text  comment '',
   EMAIL                text  comment '',
   PASSWORD             text  comment '',
   CREATED_AT           datetime  comment '',
   primary key (CUSTOMER_ID)
);

/*==============================================================*/
/* Table: RESERVATIONS                                          */
/*==============================================================*/
create table RESERVATIONS
(
   RESERVATION_ID       varchar(10) not null  comment '',
   EVENT_ID             varchar(10)  comment '',
   SEAT_ID              varchar(10)  comment '',
   CUSTOMER_ID              varchar(10)  comment '',
   RESERVATION_TIME     datetime  comment '',
   STATUS               text  comment '',
   TOTAL_AMOUNT         float  comment '',
   primary key (RESERVATION_ID)
);

/*==============================================================*/
/* Table: NOTIFICATIONS                                         */
/*==============================================================*/
create table NOTIFICATIONS
(
   NOTIFICATION_ID      varchar(10) not null  comment '',
   CUSTOMER_ID              varchar(10)  comment '',
   MESSAGE              text  comment '',
   TYPE                 text  comment '',
   SENT_AT              datetime  comment '',
   IS_READ              bool  comment '',
   primary key (NOTIFICATION_ID)
);