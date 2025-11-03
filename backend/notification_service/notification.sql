/*==============================================================*/
/* Table: NOTIFICATIONS                                         */
/*==============================================================*/
CREATE TABLE NOTIFICATIONS (
   NOTIFICATION_ID      VARCHAR(10) NOT NULL COMMENT '',
   SENDER_ID            VARCHAR(10) NULL COMMENT '',
   RECEIVER_ID          VARCHAR(10) NULL COMMENT '',
   RECEIVER_TYPE        ENUM('CUSTOMER','ADMIN') NOT NULL DEFAULT 'CUSTOMER' COMMENT '',
   TITLE                VARCHAR(100) NULL COMMENT '',
   MESSAGE              TEXT COMMENT '',
   TYPE                 VARCHAR(50) COMMENT '',
   LINK                 VARCHAR(255) NULL COMMENT '',
   SENT_AT              DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT '',
   IS_READ              BOOLEAN DEFAULT FALSE COMMENT '',
   primary key (NOTIFICATION_ID)
);

/*==============================================================*/
/* Table: EMAIL_LOG                                             */
/*==============================================================*/
create table EMAIL_LOG
(
   EMAILLOG_ID          varchar(10) not null  comment '',
   CUSTOMER_ID          varchar(10)  comment '',
   RECIPIENT_EMAIL      text  comment '',
   SUBJECT              text  comment '',
   SENT_TIME            datetime  comment '',
   STATUS               text  comment '',
   ERRORMESSAGE         text  comment '',
   primary key (EMAILLOG_ID)
);
