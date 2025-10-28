
/*==============================================================*/
/* Table: SEATS                                                 */
/*==============================================================*/
create table SEATS
(
   SEAT_ID              varchar(10) not null  comment '',
   VENUE_ID             varchar(10)  comment '',
   ROW_NUMBER           numeric(8,0)  comment '',
   SEAT_NUMBER          numeric(8,0)  comment '',
   SEAT_TYPE            text  comment '',
   PRICE_MULTIPLIER     numeric(8,0)  comment '',
   IS_AVAILABLE         bool  comment '',
   primary key (SEAT_ID)
);

/*==============================================================*/
/* Table: RESERVATIONS                                          */
/*==============================================================*/
create table RESERVATIONS
(
   RESERVATION_ID       varchar(10) not null  comment '',
   EVENT_ID             varchar(10)  comment '',
   SEAT_ID              varchar(10)  comment '',
   CUSTOMER_ID          varchar(10)  comment '',
   RESERVATION_TIME     datetime  comment '',
   STATUS               text  comment '',
   TOTAL_AMOUNT         float  comment '',
   primary key (RESERVATION_ID)
);