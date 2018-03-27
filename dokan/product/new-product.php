CREATE TABLE "PRODUCTS"
(
"ID" number,
"CATEGORY_ID" number,
"COLOR_ID" varchar2(5),
"BRAND_ID" number,
"NAME" varchar2(30),
constraint PRODUCTS_PK PRIMARY KEY ("ID")
CREATE  sequence "PRODUCTS_SEQ"
/
CREATE trigger "BI_PRODUCTS"
before insert on "PRODUCTS"
for each row
begin
select "PRODUCTS_SEQ".nextval into :NEW."ID" from dual;
end;
/

)
/
CREATE TABLE "SUPPLIERS" (
"ID" number,
"COUNTRY_ID" bfile,
"NAME" varchar2,
"URL" varchar2,
"SHIPPING_PRICE" number,
constraint SUPPLIERS_PK PRIMARY KEY ("ID")
CREATE sequence "SUPPLIERS_SEQ"
/
CREATE trigger "BI_SUPPLIERS"
before insert on "SUPPLIERS"
for each row
begin
select "SUPPLIERS_SEQ".nextval into :NEW."ID" from dual;
end;
/

)
/
CREATE TABLE "BIDS" (
"ID" number,
"PRODUCT_ID" number,
"SUPPLIER_ID" number,
"NAME" varchar2,
"PRICE" number,
"CREATED" DATE,
"QUANTITY" number,
"URL" varchar2,
constraint BIDS_PK PRIMARY KEY ("ID")
CREATE sequence "BIDS_SEQ"
/
CREATE trigger "BI_BIDS"
before insert on "BIDS"
for each row
begin
select "BIDS_SEQ".nextval into :NEW."ID" from dual;
end;
/

)
/
CREATE TABLE "CATEGORIES" (
"ID" number,
"NAME" varchar2,
constraint CATEGORIES_PK PRIMARY KEY ("ID")
CREATE sequence "CATEGORIES_SEQ"
/
CREATE trigger "BI_CATEGORIES"
before insert on "CATEGORIES"
for each row
begin
select "CATEGORIES_SEQ".nextval into :NEW."ID" from dual;
end;
/

)
/
CREATE TABLE "COLORS" (
"ID" number,
"NAME" varchar2,
constraint COLORS_PK PRIMARY KEY ("ID")
CREATE sequence "COLORS_SEQ"
/
CREATE trigger "BI_COLORS"
before insert on "COLORS"
for each row
begin
select "COLORS_SEQ".nextval into :NEW."ID" from dual;
end;
/

)
/
CREATE TABLE "BRANDS" (
"ID" number,
"NAME" varchar2,
constraint BRANDS_PK PRIMARY KEY ("ID")
CREATE sequence "BRANDS_SEQ"
/
CREATE trigger "BI_BRANDS"
before insert on "BRANDS"
for each row
begin
select "BRANDS_SEQ".nextval into :NEW."ID" from dual;
end;
/

)
/
CREATE TABLE "COUNTRY" (
"ID" number,
"NAME" varchar2,
constraint COUNTRY_PK PRIMARY KEY ("ID")
CREATE sequence "COUNTRY_SEQ"
/
CREATE trigger "BI_COUNTRY"
before insert on "COUNTRY"
for each row
begin
select "COUNTRY_SEQ".nextval into :NEW."ID" from dual;
end;
/

)
/
ALTER TABLE "PRODUCTS" ADD CONSTRAINT "PRODUCTS_fk0" FOREIGN KEY ("CATEGORY_ID") REFERENCES CATEGORIES("ID");
ALTER TABLE "PRODUCTS" ADD CONSTRAINT "PRODUCTS_fk1" FOREIGN KEY ("COLOR_ID") REFERENCES COLORS("ID");
ALTER TABLE "PRODUCTS" ADD CONSTRAINT "PRODUCTS_fk2" FOREIGN KEY ("BRAND_ID") REFERENCES BRANDS("ID");

ALTER TABLE "SUPPLIERS" ADD CONSTRAINT "SUPPLIERS_fk0" FOREIGN KEY ("COUNTRY_ID") REFERENCES COUNTRY("ID");

ALTER TABLE "BIDS" ADD CONSTRAINT "BIDS_fk0" FOREIGN KEY ("PRODUCT_ID") REFERENCES PRODUCTS("ID");
ALTER TABLE "BIDS" ADD CONSTRAINT "BIDS_fk1" FOREIGN KEY ("SUPPLIER_ID") REFERENCES SUPPLIERS("ID");
