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
   EVENT_NAME           text  comment '',
   primary key (EVENT_ID)
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
/* Table: CMS_PAGES                                             */
/*==============================================================*/
create table CMS_PAGES
(
   PAGE_ID              varchar(10) not null  comment '',
   ADMIN_ID             varchar(10)  comment '',
   TYPE                 text  comment '',
   TITLE                text  comment '',
   CONTENT            text  comment '',
   UPDATED_AT           datetime  comment '',
   primary key (PAGE_ID)
);
