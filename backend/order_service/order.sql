/*==============================================================*/
/* Table: ORDERS                                                */
/*==============================================================*/
create table ORDERS
(
   ORDER_ID             varchar(10) not null  comment '',
   CUSTOMER_ID          varchar(10)  comment '',
   RESERVATION_ID       varchar(10)  comment '',
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
