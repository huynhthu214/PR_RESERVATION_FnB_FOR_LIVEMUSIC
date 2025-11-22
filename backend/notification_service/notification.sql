/*==============================================================*/
/* Table: NOTIFICATIONS                                         */
/*==============================================================*/
create table NOTIFICATIONS
(
   NOTIFICATION_ID      varchar(10) not null  comment '',
   CUSTOMER_ID          varchar(10)  comment '',
   ADMIN_ID             varchar(10)  comment '',
   SENDER_ID            varchar(10)  comment '',
   RECEIVER_ID          varchar(10)  comment '',
   RECEIVER_TYPE        text  comment '',
   TITLE                text  comment '',
   MESSAGE              text  comment '',
   TYPE                 text  comment '',
   LINK                 text  comment '',
   SENT_AT              datetime  comment '',
   IS_READ              bool  comment '',
   primary key (NOTIFICATION_ID)
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