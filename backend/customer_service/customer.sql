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
/* Table: OTP                                                   */
/*==============================================================*/
create table OTP
(
   OTP_ID               varchar(10) not null  comment '',
   CUSTOMER_ID          varchar(10)  comment '',
   PAYMENT_ID           varchar(10)  comment '',
   CODE                 varchar(10)  comment '',
   CREATED_AT           datetime  comment '',
   EXPIRES_AT           datetime  comment '',
   IS_USED              bool  comment '',
   STATUS               text  comment '',
   primary key (OTP_ID)
);
