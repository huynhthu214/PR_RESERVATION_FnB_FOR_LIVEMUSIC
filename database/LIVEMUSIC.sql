/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     17/11/2025 9:09:34 PM                        */
/*==============================================================*/


alter table CMS_PAGES 
   drop foreign key FK_CMS_PAGE_ADMIN_CMS_ADMIN_US;

alter table EMAIL_LOG 
   drop foreign key FK_EMAIL_LO_CUSTOMER__CUSTOMER;

alter table EVENTS 
   drop foreign key FK_EVENTS_ADMIN_EVE_ADMIN_US;

alter table EVENTS 
   drop foreign key FK_EVENTS_VENUE_EVE_VENUES;

alter table MENU_ITEMS 
   drop foreign key FK_MENU_ITE_ADMIN_MEN_ADMIN_US;

alter table MENU_PROMO 
   drop foreign key FK_MENU_PRO_MENU_PROM_MENU_ITE;

alter table MENU_PROMO 
   drop foreign key FK_MENU_PRO_MENU_PROM_PROMOTIO;

alter table NOTIFICATIONS 
   drop foreign key FK_NOTIFICA_CUSTOMER__CUSTOMER;

alter table ORDERS 
   drop foreign key FK_ORDERS_CUSTOMER__CUSTOMER;

alter table ORDERS 
   drop foreign key FK_ORDERS_ODER_PROM_PROMOTIO;

alter table ORDERS 
   drop foreign key FK_ORDERS_RESER_ORD_RESERVAT;

alter table ORDER_ITEMS 
   drop foreign key FK_ORDER_IT_MENU_ORDE_MENU_ITE;

alter table ORDER_ITEMS 
   drop foreign key FK_ORDER_IT_ORDER_ORD_ORDERS;

alter table OTP 
   drop foreign key FK_OTP_CUSTOMER__CUSTOMER;

alter table OTP 
   drop foreign key FK_OTP_OTP_PAYME_PAYMENTS;

alter table PAYMENTS 
   drop foreign key FK_PAYMENTS_CUSTOMER__CUSTOMER;

alter table PAYMENTS 
   drop foreign key FK_PAYMENTS_ORDER_PAY_ORDERS;

alter table PROMOTIONS 
   drop foreign key FK_PROMOTIO_ADMIN_PRO_ADMIN_US;

alter table PROMOTIONS 
   drop foreign key FK_PROMOTIO_PROMO_EVE_EVENTS;

alter table RESERVATIONS 
   drop foreign key FK_RESERVAT_CUSTOMER__CUSTOMER;

alter table RESERVATIONS 
   drop foreign key FK_RESERVAT_EVENT_RES_EVENTS;

alter table RESERVATIONS 
   drop foreign key FK_RESERVAT_SEAT_RESE_SEATS;

alter table SEATS 
   drop foreign key FK_SEATS_VENUE_SEA_VENUES;

alter table VENUES 
   drop foreign key FK_VENUES_ADMIN_VEN_ADMIN_US;

drop table if exists ADMIN_USERS;


alter table CMS_PAGES 
   drop foreign key FK_CMS_PAGE_ADMIN_CMS_ADMIN_US;

drop table if exists CMS_PAGES;

drop table if exists CUSTOMER_USERS;


alter table EMAIL_LOG 
   drop foreign key FK_EMAIL_LO_CUSTOMER__CUSTOMER;

drop table if exists EMAIL_LOG;


alter table EVENTS 
   drop foreign key FK_EVENTS_VENUE_EVE_VENUES;

alter table EVENTS 
   drop foreign key FK_EVENTS_ADMIN_EVE_ADMIN_US;

drop table if exists EVENTS;


alter table MENU_ITEMS 
   drop foreign key FK_MENU_ITE_ADMIN_MEN_ADMIN_US;

drop table if exists MENU_ITEMS;


alter table MENU_PROMO 
   drop foreign key FK_MENU_PRO_MENU_PROM_MENU_ITE;

alter table MENU_PROMO 
   drop foreign key FK_MENU_PRO_MENU_PROM_PROMOTIO;

drop table if exists MENU_PROMO;


alter table NOTIFICATIONS 
   drop foreign key FK_NOTIFICA_CUSTOMER__CUSTOMER;

drop table if exists NOTIFICATIONS;


alter table ORDERS 
   drop foreign key FK_ORDERS_RESER_ORD_RESERVAT;

alter table ORDERS 
   drop foreign key FK_ORDERS_CUSTOMER__CUSTOMER;

alter table ORDERS 
   drop foreign key FK_ORDERS_ODER_PROM_PROMOTIO;

drop table if exists ORDERS;


alter table ORDER_ITEMS 
   drop foreign key FK_ORDER_IT_ORDER_ORD_ORDERS;

alter table ORDER_ITEMS 
   drop foreign key FK_ORDER_IT_MENU_ORDE_MENU_ITE;

drop table if exists ORDER_ITEMS;


alter table OTP 
   drop foreign key FK_OTP_CUSTOMER__CUSTOMER;

alter table OTP 
   drop foreign key FK_OTP_OTP_PAYME_PAYMENTS;

drop table if exists OTP;


alter table PAYMENTS 
   drop foreign key FK_PAYMENTS_ORDER_PAY_ORDERS;

alter table PAYMENTS 
   drop foreign key FK_PAYMENTS_CUSTOMER__CUSTOMER;

drop table if exists PAYMENTS;


alter table PROMOTIONS 
   drop foreign key FK_PROMOTIO_ADMIN_PRO_ADMIN_US;

alter table PROMOTIONS 
   drop foreign key FK_PROMOTIO_PROMO_EVE_EVENTS;

drop table if exists PROMOTIONS;


alter table RESERVATIONS 
   drop foreign key FK_RESERVAT_CUSTOMER__CUSTOMER;

alter table RESERVATIONS 
   drop foreign key FK_RESERVAT_EVENT_RES_EVENTS;

alter table RESERVATIONS 
   drop foreign key FK_RESERVAT_SEAT_RESE_SEATS;

drop table if exists RESERVATIONS;


alter table SEATS 
   drop foreign key FK_SEATS_VENUE_SEA_VENUES;

drop table if exists SEATS;


alter table VENUES 
   drop foreign key FK_VENUES_ADMIN_VEN_ADMIN_US;

drop table if exists VENUES;

/*==============================================================*/
/* Table: ADMIN_USERS                                           */
/*==============================================================*/
create table ADMIN_USERS
(
   ADMIN_ID             varchar(10) not null  comment '',
   USERNAME             text  comment '',
   EMAIL                text  comment '',
   PASSWORD             text  comment '',
   ROLE                 text  comment '',
   CREATED_AT           datetime  comment '',
   primary key (ADMIN_ID)
);

/*==============================================================*/
/* Table: CMS_PAGES                                             */
/*==============================================================*/
create table CMS_PAGES
(
   PAGE_ID              varchar(10) not null  comment '',
   ADMIN_ID             varchar(10)  comment '',
   TYPE                 text  comment '',
   TITLE                text  comment '',
   CONTENT_             text  comment '',
   UPDATED_AT           datetime  comment '',
   primary key (PAGE_ID)
);

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

/*==============================================================*/
/* Table: EVENTS                                                */
/*==============================================================*/
create table EVENTS
(
   EVENT_ID             varchar(10) not null  comment '',
   ADMIN_ID             varchar(10)  comment '',
   VENUE_ID             varchar(10)  comment '',
   BAND_NAME            text  comment '',
   EVENT_DATE           datetime  comment '',
   START_TIME           datetime  comment '',
   TICKET_PRICE         float  comment '',
   STATUS               text  comment '',
   DESCRIPTION          text  comment '',
   END_TIME             datetime  comment '',
   IMAGE_URL            text  comment '',
   ARTIST_NAME          text  comment '',
   IMG_ARTIST           text  comment '',
   primary key (EVENT_ID)
);

/*==============================================================*/
/* Table: MENU_ITEMS                                            */
/*==============================================================*/
create table MENU_ITEMS
(
   ITEM_ID              varchar(10) not null  comment '',
   ADMIN_ID             varchar(10)  comment '',
   NAME                 text  comment '',
   DESCRIPTION          text  comment '',
   PRICE                float  comment '',
   CATEGORY             text  comment '',
   STOCK_QUANTITY       numeric(8,0)  comment '',
   IS_AVAILABLE         bool  comment '',
   primary key (ITEM_ID)
);

/*==============================================================*/
/* Table: MENU_PROMO                                            */
/*==============================================================*/
create table MENU_PROMO
(
   ITEM_ID              varchar(10) not null  comment '',
   PROMO_ID             varchar(10) not null  comment '',
   primary key (ITEM_ID, PROMO_ID)
);

/*==============================================================*/
/* Table: NOTIFICATIONS                                         */
/*==============================================================*/
create table NOTIFICATIONS
(
   NOTIFICATION_ID      varchar(10) not null  comment '',
   CUSTOMER_ID          varchar(10)  comment '',
   MESSAGE              text  comment '',
   TYPE                 text  comment '',
   SENT_AT              datetime  comment '',
   IS_READ              bool  comment '',
   primary key (NOTIFICATION_ID)
);

/*==============================================================*/
/* Table: ORDERS                                                */
/*==============================================================*/
create table ORDERS
(
   ORDER_ID             varchar(10) not null  comment '',
   CUSTOMER_ID          varchar(10)  comment '',
   RESERVATION_ID       varchar(10)  comment '',
   PROMO_ID             varchar(10)  comment '',
   ORDER_TIME           datetime  comment '',
   TOTAL_AMOUNT         float  comment '',
   STATUS               text  comment '',
   DELIVERY_NOTES       text  comment '',
   primary key (ORDER_ID)
);

/*==============================================================*/
/* Table: ORDER_ITEMS                                           */
/*==============================================================*/
create table ORDER_ITEMS
(
   ORDER_ITEM_ID        varchar(10) not null  comment '',
   ORDER_ID             varchar(10)  comment '',
   ITEM_ID              varchar(10)  comment '',
   QUANTITY             numeric(8,0)  comment '',
   UNIT_PRICE           numeric(8,0)  comment '',
   primary key (ORDER_ITEM_ID)
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

/*==============================================================*/
/* Table: PAYMENTS                                              */
/*==============================================================*/
create table PAYMENTS
(
   PAYMENT_ID           varchar(10) not null  comment '',
   ORDER_ID             varchar(10)  comment '',
   CUSTOMER_ID          varchar(10)  comment '',
   AMOUNT               numeric(8,0)  comment '',
   PAYMENT_METHOD       text  comment '',
   TRANSACTION_ID       varchar(10)  comment '',
   PAYMENT_TIME         datetime  comment '',
   PAYMENT_STATUS       text  comment '',
   primary key (PAYMENT_ID)
);

/*==============================================================*/
/* Table: PROMOTIONS                                            */
/*==============================================================*/
create table PROMOTIONS
(
   PROMO_ID             varchar(10) not null  comment '',
   EVENT_ID             varchar(10)  comment '',
   ADMIN_ID             varchar(10)  comment '',
   CODE                 varchar(10)  comment '',
   DISCOUNT_PERCENT     numeric(8,0)  comment '',
   VALID_FROM           datetime  comment '',
   VALID_TO             datetime  comment '',
   IS_ACTIVE            bool  comment '',
   APPLY_TO             text  comment '',
   DESCRIPTION          text  comment '',
   primary key (PROMO_ID)
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
/* Table: VENUES                                                */
/*==============================================================*/
create table VENUES
(
   VENUE_ID             varchar(10) not null  comment '',
   ADMIN_ID             varchar(10)  comment '',
   NAME                 text  comment '',
   ADDRESS              text  comment '',
   CAPACITY             int  comment '',
   SEAT_LAYOUT          text  comment '',
   primary key (VENUE_ID)
);

alter table CMS_PAGES add constraint FK_CMS_PAGE_ADMIN_CMS_ADMIN_US foreign key (ADMIN_ID)
      references ADMIN_USERS (ADMIN_ID) on delete restrict on update restrict;

alter table EMAIL_LOG add constraint FK_EMAIL_LO_CUSTOMER__CUSTOMER foreign key (CUSTOMER_ID)
      references CUSTOMER_USERS (CUSTOMER_ID) on delete restrict on update restrict;

alter table EVENTS add constraint FK_EVENTS_ADMIN_EVE_ADMIN_US foreign key (ADMIN_ID)
      references ADMIN_USERS (ADMIN_ID) on delete restrict on update restrict;

alter table EVENTS add constraint FK_EVENTS_VENUE_EVE_VENUES foreign key (VENUE_ID)
      references VENUES (VENUE_ID) on delete restrict on update restrict;

alter table MENU_ITEMS add constraint FK_MENU_ITE_ADMIN_MEN_ADMIN_US foreign key (ADMIN_ID)
      references ADMIN_USERS (ADMIN_ID) on delete restrict on update restrict;

alter table MENU_PROMO add constraint FK_MENU_PRO_MENU_PROM_MENU_ITE foreign key (ITEM_ID)
      references MENU_ITEMS (ITEM_ID) on delete restrict on update restrict;

alter table MENU_PROMO add constraint FK_MENU_PRO_MENU_PROM_PROMOTIO foreign key (PROMO_ID)
      references PROMOTIONS (PROMO_ID) on delete restrict on update restrict;

alter table NOTIFICATIONS add constraint FK_NOTIFICA_CUSTOMER__CUSTOMER foreign key (CUSTOMER_ID)
      references CUSTOMER_USERS (CUSTOMER_ID) on delete restrict on update restrict;

alter table ORDERS add constraint FK_ORDERS_CUSTOMER__CUSTOMER foreign key (CUSTOMER_ID)
      references CUSTOMER_USERS (CUSTOMER_ID) on delete restrict on update restrict;

alter table ORDERS add constraint FK_ORDERS_ODER_PROM_PROMOTIO foreign key (PROMO_ID)
      references PROMOTIONS (PROMO_ID) on delete restrict on update restrict;

alter table ORDERS add constraint FK_ORDERS_RESER_ORD_RESERVAT foreign key (RESERVATION_ID)
      references RESERVATIONS (RESERVATION_ID) on delete restrict on update restrict;

alter table ORDER_ITEMS add constraint FK_ORDER_IT_MENU_ORDE_MENU_ITE foreign key (ITEM_ID)
      references MENU_ITEMS (ITEM_ID) on delete restrict on update restrict;

alter table ORDER_ITEMS add constraint FK_ORDER_IT_ORDER_ORD_ORDERS foreign key (ORDER_ID)
      references ORDERS (ORDER_ID) on delete restrict on update restrict;

alter table OTP add constraint FK_OTP_CUSTOMER__CUSTOMER foreign key (CUSTOMER_ID)
      references CUSTOMER_USERS (CUSTOMER_ID) on delete restrict on update restrict;

alter table OTP add constraint FK_OTP_OTP_PAYME_PAYMENTS foreign key (PAYMENT_ID)
      references PAYMENTS (PAYMENT_ID) on delete restrict on update restrict;

alter table PAYMENTS add constraint FK_PAYMENTS_CUSTOMER__CUSTOMER foreign key (CUSTOMER_ID)
      references CUSTOMER_USERS (CUSTOMER_ID) on delete restrict on update restrict;

alter table PAYMENTS add constraint FK_PAYMENTS_ORDER_PAY_ORDERS foreign key (ORDER_ID)
      references ORDERS (ORDER_ID) on delete restrict on update restrict;

alter table PROMOTIONS add constraint FK_PROMOTIO_ADMIN_PRO_ADMIN_US foreign key (ADMIN_ID)
      references ADMIN_USERS (ADMIN_ID) on delete restrict on update restrict;

alter table PROMOTIONS add constraint FK_PROMOTIO_PROMO_EVE_EVENTS foreign key (EVENT_ID)
      references EVENTS (EVENT_ID) on delete restrict on update restrict;

alter table RESERVATIONS add constraint FK_RESERVAT_CUSTOMER__CUSTOMER foreign key (CUSTOMER_ID)
      references CUSTOMER_USERS (CUSTOMER_ID) on delete restrict on update restrict;

alter table RESERVATIONS add constraint FK_RESERVAT_EVENT_RES_EVENTS foreign key (EVENT_ID)
      references EVENTS (EVENT_ID) on delete restrict on update restrict;

alter table RESERVATIONS add constraint FK_RESERVAT_SEAT_RESE_SEATS foreign key (SEAT_ID)
      references SEATS (SEAT_ID) on delete restrict on update restrict;

alter table SEATS add constraint FK_SEATS_VENUE_SEA_VENUES foreign key (VENUE_ID)
      references VENUES (VENUE_ID) on delete restrict on update restrict;

alter table VENUES add constraint FK_VENUES_ADMIN_VEN_ADMIN_US foreign key (ADMIN_ID)
      references ADMIN_USERS (ADMIN_ID) on delete restrict on update restrict;

