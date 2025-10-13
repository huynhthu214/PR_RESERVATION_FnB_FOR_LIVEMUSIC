/*==============================================================*/
/* Table: ADMIN_USERS                                           */
/*==============================================================*/
create table ADMIN_USERS
(
   ADMIN_ID           varchar(10) not null  comment '',
   USERNAME             text  comment '',
   EMAIL                text  comment '',
   PASSWORD             text  comment '',
   ROLE                 text  comment '',
   CREATED_AT           datetime  comment '',
   primary key (ADMIN_ID)
);

/*==============================================================*/
/* Table: VENUES                                                */
/*==============================================================*/
create table VENUES
(
   VENUE_ID             varchar(10) not null  comment '',
   NAME                 text  comment '',
   ADDRESS              text  comment '',
   CAPACITY             int  comment '',
   SEAT_LAYOUT          text  comment '',
   primary key (VENUE_ID)
);

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
/* Table: EVENTS                                                */
/*==============================================================*/
create table EVENTS
(
   EVENT_ID             varchar(10) not null  comment '',
   VENUE_ID             varchar(10)  comment '',
   BAND_NAME            text  comment '',
   EVENT_DATE           datetime  comment '',
   START_TIME           datetime  comment '',
   TICKET_PRICE         float  comment '',
   STATUS               text  comment '',
   DESCRIPTION          text  comment '',
   END_TIME             datetime  comment '',
   IMAGE_URL            text  comment '',
   primary key (EVENT_ID)
);

/*==============================================================*/
/* Table: MENU_ITEMS                                            */
/*==============================================================*/
create table MENU_ITEMS
(
   ITEM_ID              varchar(10) not null  comment '',
   NAME                 text  comment '',
   DESCRIPTION          text  comment '',
   PRICE                float  comment '',
   CATEGORY             text  comment '',
   STOCK_QUANTITY       numeric(8,0)  comment '',
   IS_AVAILABLE         bool  comment '',
   primary key (ITEM_ID)
);

/*==============================================================*/
/* Table: PROMOTIONS                                            */
/*==============================================================*/
create table PROMOTIONS
(
   PROMO_ID             varchar(10) not null  comment '',
   CODE                 varchar(10)  comment '',
   DISCOUNT_PERCENT     numeric(8,0)  comment '',
   VALID_FROM           datetime  comment '',
   VALID_TO             datetime  comment '',
   IS_ACTIVE            bool  comment '',
   APPLY_TO             text  comment '',
   primary key (PROMO_ID)
);
