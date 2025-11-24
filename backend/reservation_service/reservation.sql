/*==============================================================*/
/* Table: RESERVATIONS                                          */
/*==============================================================*/
create table RESERVATIONS
(
   RESERVATION_ID       varchar(10) not null  comment '',
   EVENT_ID             varchar(10)  comment '',
   CUSTOMER_ID          varchar(10)  comment '',
   RESERVATION_TIME     datetime  comment '',
   STATUS               text  comment '',
   TOTAL_AMOUNT         float  comment '',
   PRICE                float  comment '',
   SEAT_NUMBER          numeric(8,0)  comment '',
   primary key (RESERVATION_ID)
);
/*==============================================================*/
/* Table: EMAIL_LOG                                             */
/*==============================================================*/
create table EMAIL_LOG
(
   EMAILLOG_ID          varchar(10) not null  comment '',
   ADMIN_ID             varchar(10)  comment '',
   CUSTOMER_ID          varchar(10)  comment '',
   RECIPIENT_EMAIL      text  comment '',
   SUBJECT              text  comment '',
   SENT_TIME            datetime  comment '',
   STATUS               text  comment '',
   ERRORMESSAGE         text  comment '',
   primary key (EMAILLOG_ID)
);