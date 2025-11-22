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
   primary key (RESERVATION_ID)
);
