PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
CREATE TABLE "migrations" ("migration" varchar not null, "batch" integer not null);
INSERT INTO "migrations" VALUES('2014_10_12_000000_create_users_table',1);
INSERT INTO "migrations" VALUES('2014_10_12_100000_create_password_resets_table',1);
INSERT INTO "migrations" VALUES('2015_03_10_140153_create_genders_table',1);
INSERT INTO "migrations" VALUES('2015_03_10_142938_create_states_table',1);
INSERT INTO "migrations" VALUES('2015_03_10_154237_create_towns_table',1);
INSERT INTO "migrations" VALUES('2015_03_10_154410_create_parishes_table',1);
INSERT INTO "migrations" VALUES('2015_03_10_154455_create_directions_table',1);
INSERT INTO "migrations" VALUES('2015_03_10_154557_create_profiles_table',1);
INSERT INTO "migrations" VALUES('2015_03_10_173459_create_nationalities_table',1);
INSERT INTO "migrations" VALUES('2015_03_10_173503_create_people_table',1);
INSERT INTO "migrations" VALUES('2015_03_13_193841_create_makers_table',1);
INSERT INTO "migrations" VALUES('2015_03_13_194526_create_categories_table',1);
INSERT INTO "migrations" VALUES('2015_03_13_195124_create_sub_categories_table',1);
INSERT INTO "migrations" VALUES('2015_03_13_202223_create_products_table',1);
INSERT INTO "migrations" VALUES('2015_03_13_205316_create_purchases_table',1);
INSERT INTO "migrations" VALUES('2015_03_13_205446_create_promotions_table',1);
INSERT INTO "migrations" VALUES('2015_03_13_205519_create_product_promotion_table',1);
INSERT INTO "migrations" VALUES('2015_03_13_205737_create_files_table',1);
INSERT INTO "migrations" VALUES('2015_03_13_212413_create_images_table',1);
INSERT INTO "migrations" VALUES('2015_03_13_212630_create_characteristics_table',1);
INSERT INTO "migrations" VALUES('2015_03_13_214205_create_features_table',1);
INSERT INTO "migrations" VALUES('2015_03_13_214850_create_mechanical_infos_table',1);
INSERT INTO "migrations" VALUES('2015_03_13_215620_create_nutritionals_table',1);
INSERT INTO "migrations" VALUES('2015_03_13_220817_create_visits_table',1);
INSERT INTO "migrations" VALUES('2015_03_13_221555_create_banks_table',1);
INSERT INTO "migrations" VALUES('2015_03_13_221616_create_card_types_table',1);
INSERT INTO "migrations" VALUES('2015_03_13_221820_create_billings_table',1);
INSERT INTO "migrations" VALUES('2015_03_13_234614_create_maker_sub_category',1);
INSERT INTO "migrations" VALUES('2015_03_14_000527_create_product_sub_category_table',1);
CREATE TABLE "users" ("id" integer not null primary key autoincrement, "profile_id" integer not null, "name" varchar not null, "email" varchar not null, "password" varchar not null, "remember_token" varchar null, "created_at" datetime not null, "updated_at" datetime not null, "deleted_at" datetime null);
INSERT INTO "users" VALUES(1,1,'tester','tester@tester.com','$2y$10$D.SjAUigcg1.INB6yZ24L.ZiS8NdUNMXuV2SjIcfjEed0ElQrODfi',NULL,'current_timestampt','current_timestampt',NULL);
CREATE TABLE "password_resets" ("email" varchar not null, "token" varchar not null, "created_at" datetime not null);
CREATE TABLE "genders" ("id" integer not null primary key autoincrement, "description" varchar not null, "created_at" datetime not null, "updated_at" datetime not null);
INSERT INTO "genders" VALUES(1,'Masculino','2015-03-15 16:31:20','2015-03-15 16:31:20');
INSERT INTO "genders" VALUES(2,'Femenino','2015-03-15 16:31:20','2015-03-15 16:31:20');
CREATE TABLE "states" ("id" integer not null primary key autoincrement, "description" varchar not null, "created_at" datetime not null, "updated_at" datetime not null);
INSERT INTO "states" VALUES(1,'Distrito Capital','2015-03-15 21:01:20','2015-03-15 21:01:20');
CREATE TABLE "towns" ("id" integer not null primary key autoincrement, "state_id" integer not null, "description" varchar not null, "created_at" datetime not null, "updated_at" datetime not null, foreign key("state_id") references "states"("id"));
INSERT INTO "towns" VALUES(1,1,'Libertador','2015-03-15 21:01:20','2015-03-15 21:01:20');
CREATE TABLE "parishes" ("id" integer not null primary key autoincrement, "town_id" integer not null, "description" varchar not null, "created_at" datetime not null, "updated_at" datetime not null, foreign key("town_id") references "towns"("id"));
INSERT INTO "parishes" VALUES(1,1,'Altagracia','2015-03-15 21:01:20','2015-03-15 21:01:20');
CREATE TABLE "directions" ("id" integer not null primary key autoincrement, "directionable_id" integer not null, "directionable_type" varchar not null, "parish_id" integer not null, "details" varchar null, "created_at" datetime not null, "updated_at" datetime not null, "created_by" integer not null, "updated_by" integer not null, "deleted_at" datetime null, foreign key("parish_id") references "parishes"("id"), foreign key("created_by") references "users"("id"), foreign key("updated_by") references "users"("id"));
INSERT INTO "directions" VALUES(1,1,'App\Person',1,'Calle del tester.','2015-03-15 16:31:21','2015-03-15 16:31:21',1,1,NULL);
INSERT INTO "directions" VALUES(2,1,'App\Product',1,'Calle Adam, 32, 5º D','2015-03-15 16:31:21','2015-03-15 16:31:21',1,1,NULL);
INSERT INTO "directions" VALUES(3,2,'App\Product',1,'Passeig Samaniego, 71, 75º 7º','2015-03-15 16:31:21','2015-03-15 16:31:21',1,1,NULL);
INSERT INTO "directions" VALUES(4,3,'App\Product',1,'Ruela Riojas, 70, 00º E','2015-03-15 16:31:21','2015-03-15 16:31:21',1,1,NULL);
CREATE TABLE "profiles" ("id" integer not null primary key autoincrement, "description" varchar not null, "created_at" datetime not null, "updated_at" datetime not null);
INSERT INTO "profiles" VALUES(1,'Administrador','2015-03-15 16:31:20','2015-03-15 16:31:20');
INSERT INTO "profiles" VALUES(2,'Usuario','2015-03-15 16:31:20','2015-03-15 16:31:20');
INSERT INTO "profiles" VALUES(3,'Desactivado','2015-03-15 16:31:20','2015-03-15 16:31:20');
CREATE TABLE "nationalities" ("id" integer not null primary key autoincrement, "description" varchar not null, "created_at" datetime not null, "updated_at" datetime not null);
INSERT INTO "nationalities" VALUES(1,'Venezolano','2015-03-15 16:31:20','2015-03-15 16:31:20');
INSERT INTO "nationalities" VALUES(2,'Extrangero','2015-03-15 16:31:20','2015-03-15 16:31:20');
CREATE TABLE "people" ("id" integer not null primary key autoincrement, "user_id" integer not null, "gender_id" integer not null, "nationality_id" integer not null, "first_name" varchar not null, "last_name" varchar null, "first_surname" varchar not null, "last_surname" varchar null, "identity_card" varchar not null, "phone" varchar null, "birth_date" date null, "created_at" datetime not null, "updated_at" datetime not null, foreign key("user_id") references "users"("id") on delete cascade, foreign key("gender_id") references "genders"("id"), foreign key("nationality_id") references "nationalities"("id"));
INSERT INTO "people" VALUES(1,1,1,1,'tester',NULL,'tester',NULL,'10000001','+58-(212)-111-2233','1999-09-09','current_timestampt','current_timestampt');
CREATE TABLE "makers" ("id" integer not null primary key autoincrement, "name" varchar not null, "slug" varchar not null, "domain" varchar null, "url" varchar null, "logo_path" varchar null, "logo_alt" varchar null, "created_at" datetime not null, "updated_at" datetime not null);
INSERT INTO "makers" VALUES(1,'Gestora Agosto S. de H.','gestora-agosto-s-de-h','sanabriacuellar.com','http://www.delgadocastellanos.com/neque-est-corporis-aperiam-suscipit.html',NULL,NULL,'2015-03-15 16:31:21','2015-03-15 16:31:21');
INSERT INTO "makers" VALUES(2,'Quiñones de Tejeda','quinones-de-tejeda','grupo.es','http://grupo.com/nisi-et-dolor-qui-omnis-ratione',NULL,NULL,'2015-03-15 16:31:21','2015-03-15 16:31:21');
INSERT INTO "makers" VALUES(3,'Muñiz-Roldán e Hija','muniz-roldan-e-hija','centro.com','http://www.grupo.es/quia-deleniti-est-consequatur-molestiae-libero-aut',NULL,NULL,'2015-03-15 16:31:21','2015-03-15 16:31:21');
INSERT INTO "makers" VALUES(4,'Tello de Córdova e Hijo','tello-de-cordova-e-hijo','alvarez.es','http://www.grupo.com/explicabo-et-ea-eligendi-tenetur-tempora-tempore',NULL,NULL,'2015-03-15 16:31:21','2015-03-15 16:31:21');
INSERT INTO "makers" VALUES(5,'Vélez, Cintrón y Calero y Flia.','velez-cintron-y-calero-y-flia','empresa.com','http://www.torres.es/',NULL,NULL,'2015-03-15 16:31:21','2015-03-15 16:31:21');
INSERT INTO "makers" VALUES(6,'Corporación Santillán SA','corporacion-santillan-sa','vila.com','http://www.cordero.com/',NULL,NULL,'2015-03-15 16:31:21','2015-03-15 16:31:21');
INSERT INTO "makers" VALUES(7,'Muñóz-Ros','munoz-ros','soria.es','http://viajes.es/',NULL,NULL,'2015-03-15 16:31:21','2015-03-15 16:31:21');
INSERT INTO "makers" VALUES(8,'Guevara, Ramos y Sola SA','guevara-ramos-y-sola-sa','font.com','http://mojica.com/quam-doloremque-deleniti-aliquam-est',NULL,NULL,'2015-03-15 16:31:21','2015-03-15 16:31:21');
INSERT INTO "makers" VALUES(9,'Flórez-Ávalos','florez-avalos','grupo.net','http://www.leyva.net/excepturi-tenetur-fuga-sint-ipsum-ea-molestias-ut.html',NULL,NULL,'2015-03-15 16:31:21','2015-03-15 16:31:21');
INSERT INTO "makers" VALUES(10,'Treviño y Corona e Hijo','trevino-y-corona-e-hijo','air.com.es','http://cuevas.com/corporis-aliquid-amet-culpa-quia-officia-quibusdam-a-nam.html',NULL,NULL,'2015-03-15 16:31:21','2015-03-15 16:31:21');
INSERT INTO "makers" VALUES(11,'Arteaga-Campos','arteaga-campos','gestora.es','http://centro.es/quo-voluptates-occaecati-explicabo-sed-unde-assumenda',NULL,NULL,'2015-03-15 16:31:21','2015-03-15 16:31:21');
INSERT INTO "makers" VALUES(12,'Air Fierro-Sosa','air-fierro-sosa','camposespinoza.org','http://velaporras.es/vero-blanditiis-maxime-voluptatem-quo-ex.html',NULL,NULL,'2015-03-15 16:31:21','2015-03-15 16:31:21');
INSERT INTO "makers" VALUES(13,'Valencia, Santillán y Moran SA','valencia-santillan-y-moran-sa','godoy.es','http://robledo.com/totam-ut-distinctio-veritatis-asperiores-perferendis-sint',NULL,NULL,'2015-03-15 16:31:21','2015-03-15 16:31:21');
INSERT INTO "makers" VALUES(14,'Corporación Villalpando-Valle','corporacion-villalpando-valle','jasso.com','https://www.air.com/dignissimos-laborum-saepe-voluptas-consequatur',NULL,NULL,'2015-03-15 16:31:21','2015-03-15 16:31:21');
CREATE TABLE "categories" ("id" integer not null primary key autoincrement, "description" varchar not null, "slug" varchar not null, "created_at" datetime not null, "updated_at" datetime not null);
INSERT INTO "categories" VALUES(1,'Productos Agro-Industriales','productos-agro-industriales','2015-03-15 16:31:21','2015-03-15 16:31:21');
INSERT INTO "categories" VALUES(2,'Productos Alimenticios','productos-alimenticios','2015-03-15 16:31:21','2015-03-15 16:31:21');
CREATE TABLE "sub_categories" ("id" integer not null primary key autoincrement, "category_id" integer not null, "description" varchar not null, "slug" varchar not null, "created_at" datetime not null, "updated_at" datetime not null, foreign key("category_id") references "categories"("id") on delete cascade);
INSERT INTO "sub_categories" VALUES(1,1,'Maquinaria Pesada','maquinaria-pesada','2015-03-15 16:31:21','2015-03-15 16:31:21');
INSERT INTO "sub_categories" VALUES(2,1,'Tractores','tractores','2015-03-15 16:31:21','2015-03-15 16:31:21');
INSERT INTO "sub_categories" VALUES(3,1,'Maquinaria Ligera','maquinaria-ligera','2015-03-15 16:31:21','2015-03-15 16:31:21');
INSERT INTO "sub_categories" VALUES(4,2,'Chocolate','chocolate','2015-03-15 16:31:21','2015-03-15 16:31:21');
INSERT INTO "sub_categories" VALUES(5,2,'Arroz','arroz','2015-03-15 16:31:21','2015-03-15 16:31:21');
INSERT INTO "sub_categories" VALUES(6,2,'Avena','avena','2015-03-15 16:31:21','2015-03-15 16:31:21');
INSERT INTO "sub_categories" VALUES(7,2,'Soya','soya','2015-03-15 16:31:21','2015-03-15 16:31:21');
CREATE TABLE "products" ("id" integer not null primary key autoincrement, "user_id" integer not null, "maker_id" integer not null, "title" varchar not null, "description" text not null, "price" float not null, "quantity" integer not null, "slug" varchar not null, "created_at" datetime not null, "updated_at" datetime not null, "created_by" integer not null, "updated_by" integer not null, "deleted_at" datetime null, foreign key("user_id") references "users"("id") on delete cascade, foreign key("maker_id") references "makers"("id"), foreign key("created_by") references "users"("id"), foreign key("updated_by") references "users"("id"));
INSERT INTO "products" VALUES(1,1,5,'Laudantium possimus aperiam beatae explicabo.','Rerum cum id asperiores minima quod perferendis aliquid. Tenetur voluptate corrupti repellendus adipisci. Quaerat sed molestiae consequatur molestiae veritatis nobis.',5657320319.54,14,'laudantium-possimus-aperiam-beatae-explicabo','2015-03-15 16:31:21','2015-03-15 16:31:21',1,1,NULL);
INSERT INTO "products" VALUES(2,1,1,'Dolorem doloremque vero ut expedita in voluptatibus.','Laborum aut autem blanditiis consectetur quo expedita. Nihil sunt odio aliquam excepturi. Ea dolores voluptatem quas assumenda molestias. Et optio dicta nostrum.',9547242972.64,13,'dolorem-doloremque-vero-ut-expedita-in-voluptatibus','2015-03-15 16:31:21','2015-03-15 16:31:21',1,1,NULL);
INSERT INTO "products" VALUES(3,1,7,'Quibusdam est sed est.','Laboriosam suscipit voluptas est autem. Porro repudiandae possimus impedit officia illo cumque. Beatae sit fugit sunt fugiat.',5749274690.54,19,'quibusdam-est-sed-est','2015-03-15 16:31:21','2015-03-15 16:31:21',1,1,NULL);
CREATE TABLE "purchases" ("id" integer not null primary key autoincrement, "user_id" integer not null, "product_id" integer not null, "quantity" integer not null, "date" date not null, "created_by" integer not null, "updated_by" integer not null, "created_at" datetime not null, "updated_at" datetime not null, foreign key("user_id") references "users"("id") on delete cascade, foreign key("product_id") references "products"("id"), foreign key("created_by") references "users"("id"), foreign key("updated_by") references "users"("id"));
CREATE TABLE "promotions" ("id" integer not null primary key autoincrement, "title" varchar not null, "percentage" integer null, "static" integer null, "begins" date not null, "ends" date not null, "created_at" datetime not null, "updated_at" datetime not null);
CREATE TABLE "product_promotion" ("product_id" integer not null, "promotion_id" integer not null, foreign key("product_id") references "products"("id"), foreign key("promotion_id") references "promotions"("id"));
CREATE TABLE "files" ("id" integer not null primary key autoincrement, "fileable_id" integer not null, "fileable_type" varchar not null, "path" varchar not null, "mime" varchar not null, "created_at" datetime not null, "updated_at" datetime not null, "created_by" integer not null, "updated_by" integer not null, foreign key("created_by") references "users"("id"), foreign key("updated_by") references "users"("id"));
INSERT INTO "files" VALUES(1,1,'App\Feature','products/1/201503150403032121-75Ro2f6ATAAqRm6V67Xg.pdf','application/pdf','2015-03-15 16:31:21','2015-03-15 16:31:21',1,1);
INSERT INTO "files" VALUES(2,2,'App\Feature','products/1/201503150403032222-2TVB8rOnFt8dh1ROY8xP.pdf','application/pdf','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "files" VALUES(3,3,'App\Feature','products/1/201503150403032222-vKlhJ4fk5BvcJeFypzXm.pdf','application/pdf','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "files" VALUES(4,4,'App\Feature','products/1/201503150403032222-2osLS52toVFpfxAFoAAO.pdf','application/pdf','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "files" VALUES(5,5,'App\Feature','products/1/201503150403032222-SaN0nHi9vXtzrOhDmqWI.pdf','application/pdf','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "files" VALUES(6,6,'App\Feature','products/2/201503150403032222-3CHYnCz4r9X13Z2C5vUZ.pdf','application/pdf','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "files" VALUES(7,7,'App\Feature','products/2/201503150403032222-liHD7djBRIdWatpHkpNh.pdf','application/pdf','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "files" VALUES(8,8,'App\Feature','products/2/201503150403032222-mp7LWsNib0EIegQMtcOb.pdf','application/pdf','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "files" VALUES(9,9,'App\Feature','products/2/201503150403032222-wzI2ClbQUEfB0UT4ZmYc.pdf','application/pdf','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "files" VALUES(10,10,'App\Feature','products/2/201503150403032222-mUPFUZvKGpklZXRW5kST.pdf','application/pdf','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "files" VALUES(11,11,'App\Feature','products/3/201503150403032222-UAEaj7Mcos7tuTjSodkD.pdf','application/pdf','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "files" VALUES(12,12,'App\Feature','products/3/201503150403032222-B9JFP0ueMSSbX34YckDn.pdf','application/pdf','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "files" VALUES(13,13,'App\Feature','products/3/201503150403032222-cLjOMG8CZ2EuvdnLGpdy.pdf','application/pdf','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "files" VALUES(14,14,'App\Feature','products/3/201503150403032222-ev116mglZNlwqrG0s3v5.pdf','application/pdf','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "files" VALUES(15,15,'App\Feature','products/3/201503150403032222-1soNz700se5ylx1rNk8r.pdf','application/pdf','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
CREATE TABLE "images" ("id" integer not null primary key autoincrement, "imageable_id" integer not null, "imageable_type" varchar not null, "path" varchar not null, "mime" varchar not null, "alt" varchar not null, "created_at" datetime not null, "updated_at" datetime not null, "created_by" integer not null, "updated_by" integer not null, foreign key("created_by") references "users"("id"), foreign key("updated_by") references "users"("id"));
INSERT INTO "images" VALUES(1,1,'App\Feature','products/1/201503150403032121-2m8C4eXt8WRiTdJiAsLx.gif','image/gif','orbiagro.com.ve subastas compra y venta: tester','2015-03-15 16:31:21','2015-03-15 16:31:21',1,1);
INSERT INTO "images" VALUES(2,2,'App\Feature','products/1/201503150403032121-HGi2ttqhvYRWW9Z1VH9n.gif','image/gif','orbiagro.com.ve subastas compra y venta: tester','2015-03-15 16:31:21','2015-03-15 16:31:21',1,1);
INSERT INTO "images" VALUES(3,3,'App\Feature','products/1/201503150403032222-xorm7UflNnolphrHQmhD.gif','image/gif','orbiagro.com.ve subastas compra y venta: tester','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "images" VALUES(4,4,'App\Feature','products/1/201503150403032222-CnYw2E1p7CltP8i9kmZt.gif','image/gif','orbiagro.com.ve subastas compra y venta: tester','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "images" VALUES(5,5,'App\Feature','products/1/201503150403032222-dTAlgRvgSJCcG09RRzV6.gif','image/gif','orbiagro.com.ve subastas compra y venta: tester','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "images" VALUES(6,6,'App\Feature','products/2/201503150403032222-ygGx6I8gwvKfGz7buUi7.gif','image/gif','orbiagro.com.ve subastas compra y venta: tester','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "images" VALUES(7,7,'App\Feature','products/2/201503150403032222-D0JQAX1bsLampgaPPmIl.gif','image/gif','orbiagro.com.ve subastas compra y venta: tester','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "images" VALUES(8,8,'App\Feature','products/2/201503150403032222-mgi41USLo5g5I3rRhVjO.gif','image/gif','orbiagro.com.ve subastas compra y venta: tester','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "images" VALUES(9,9,'App\Feature','products/2/201503150403032222-DoOnWj29kuEFKX91qjqe.gif','image/gif','orbiagro.com.ve subastas compra y venta: tester','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "images" VALUES(10,10,'App\Feature','products/2/201503150403032222-dRY1bJh52EglNs1oj6mQ.gif','image/gif','orbiagro.com.ve subastas compra y venta: tester','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "images" VALUES(11,11,'App\Feature','products/3/201503150403032222-y8iEmD9t2RIFADZOz0pv.gif','image/gif','orbiagro.com.ve subastas compra y venta: tester','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "images" VALUES(12,12,'App\Feature','products/3/201503150403032222-XHb9wZcaBU839hhwOHDX.gif','image/gif','orbiagro.com.ve subastas compra y venta: tester','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "images" VALUES(13,13,'App\Feature','products/3/201503150403032222-1OFN0LQTGjIaAjFBEPFc.gif','image/gif','orbiagro.com.ve subastas compra y venta: tester','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "images" VALUES(14,14,'App\Feature','products/3/201503150403032222-oX0Oks4GrfYEeajjPfGA.gif','image/gif','orbiagro.com.ve subastas compra y venta: tester','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "images" VALUES(15,15,'App\Feature','products/3/201503150403032222-KuCoVIHDVzmnHEDnhjQZ.gif','image/gif','orbiagro.com.ve subastas compra y venta: tester','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
CREATE TABLE "characteristics" ("id" integer not null primary key autoincrement, "product_id" integer not null, "height" integer null, "width" integer null, "depth" integer null, "weight" integer null, "units" integer null, "created_at" datetime not null, "updated_at" datetime not null, "created_by" integer not null, "updated_by" integer not null, foreign key("product_id") references "products"("id"), foreign key("created_by") references "users"("id"), foreign key("updated_by") references "users"("id"));
CREATE TABLE "features" ("id" integer not null primary key autoincrement, "product_id" integer not null, "title" varchar not null, "description" varchar not null, "created_at" datetime not null, "updated_at" datetime not null, "created_by" integer not null, "updated_by" integer not null, foreign key("product_id") references "products"("id"), foreign key("created_by") references "users"("id"), foreign key("updated_by") references "users"("id"));
INSERT INTO "features" VALUES(1,1,'tester','tester','2015-03-15 16:31:21','2015-03-15 16:31:21',1,1);
INSERT INTO "features" VALUES(2,1,'tester','tester','2015-03-15 16:31:21','2015-03-15 16:31:21',1,1);
INSERT INTO "features" VALUES(3,1,'tester','tester','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "features" VALUES(4,1,'tester','tester','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "features" VALUES(5,1,'tester','tester','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "features" VALUES(6,2,'tester','tester','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "features" VALUES(7,2,'tester','tester','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "features" VALUES(8,2,'tester','tester','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "features" VALUES(9,2,'tester','tester','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "features" VALUES(10,2,'tester','tester','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "features" VALUES(11,3,'tester','tester','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "features" VALUES(12,3,'tester','tester','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "features" VALUES(13,3,'tester','tester','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "features" VALUES(14,3,'tester','tester','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
INSERT INTO "features" VALUES(15,3,'tester','tester','2015-03-15 16:31:22','2015-03-15 16:31:22',1,1);
CREATE TABLE "mechanical_infos" ("id" integer not null primary key autoincrement, "product_id" integer not null, "motor" varchar null, "cylinders" integer null, "horsepower" integer null, "mileage" integer null, "traction" integer null, "lift" integer null, "created_at" datetime not null, "updated_at" datetime not null, "created_by" integer not null, "updated_by" integer not null, foreign key("product_id") references "products"("id"), foreign key("created_by") references "users"("id"), foreign key("updated_by") references "users"("id"));
CREATE TABLE "nutritionals" ("id" integer not null primary key autoincrement, "product_id" integer not null, "due" date null, "created_at" datetime not null, "updated_at" datetime not null, "created_by" integer not null, "updated_by" integer not null, foreign key("product_id") references "products"("id"), foreign key("created_by") references "users"("id"), foreign key("updated_by") references "users"("id"));
CREATE TABLE "visits" ("id" integer not null primary key autoincrement, "visitable_id" integer not null, "visitable_type" varchar not null, "total" integer not null, "created_at" datetime not null, "updated_at" datetime not null);
CREATE TABLE "banks" ("id" integer not null primary key autoincrement, "description" varchar not null, "created_at" datetime not null, "updated_at" datetime not null);
CREATE TABLE "card_types" ("id" integer not null primary key autoincrement, "description" varchar not null, "created_at" datetime not null, "updated_at" datetime not null);
CREATE TABLE "billings" ("id" integer not null primary key autoincrement, "user_id" integer not null, "bank_id" integer null, "card_type_id" integer null, "card_number" varchar null, "bank_number" varchar null, "expiration" date null, "comments" varchar null, "created_at" datetime not null, "updated_at" datetime not null, "created_by" integer not null, "updated_by" integer not null, foreign key("user_id") references "users"("id") on delete cascade, foreign key("bank_id") references "banks"("id"), foreign key("card_type_id") references "card_types"("id"), foreign key("created_by") references "users"("id"), foreign key("updated_by") references "users"("id"));
CREATE TABLE "maker_sub_category" ("maker_id" integer not null, "sub_category_id" integer not null, foreign key("maker_id") references "makers"("id"), foreign key("sub_category_id") references "sub_categories"("id"));
INSERT INTO "maker_sub_category" VALUES(1,1);
INSERT INTO "maker_sub_category" VALUES(2,1);
INSERT INTO "maker_sub_category" VALUES(3,2);
INSERT INTO "maker_sub_category" VALUES(4,2);
INSERT INTO "maker_sub_category" VALUES(5,3);
INSERT INTO "maker_sub_category" VALUES(6,3);
INSERT INTO "maker_sub_category" VALUES(7,4);
INSERT INTO "maker_sub_category" VALUES(8,4);
INSERT INTO "maker_sub_category" VALUES(9,5);
INSERT INTO "maker_sub_category" VALUES(10,5);
INSERT INTO "maker_sub_category" VALUES(11,6);
INSERT INTO "maker_sub_category" VALUES(12,6);
INSERT INTO "maker_sub_category" VALUES(13,7);
INSERT INTO "maker_sub_category" VALUES(14,7);
CREATE TABLE "product_sub_category" ("product_id" integer not null, "sub_category_id" integer not null, foreign key("product_id") references "products"("id"), foreign key("sub_category_id") references "sub_categories"("id"));
INSERT INTO "product_sub_category" VALUES(1,1);
INSERT INTO "product_sub_category" VALUES(2,4);
INSERT INTO "product_sub_category" VALUES(3,6);
DELETE FROM sqlite_sequence;
INSERT INTO "sqlite_sequence" VALUES('profiles',3);
INSERT INTO "sqlite_sequence" VALUES('genders',2);
INSERT INTO "sqlite_sequence" VALUES('nationalities',2);
INSERT INTO "sqlite_sequence" VALUES('states',1);
INSERT INTO "sqlite_sequence" VALUES('towns',1);
INSERT INTO "sqlite_sequence" VALUES('parishes',1);
INSERT INTO "sqlite_sequence" VALUES('users',1);
INSERT INTO "sqlite_sequence" VALUES('people',1);
INSERT INTO "sqlite_sequence" VALUES('directions',4);
INSERT INTO "sqlite_sequence" VALUES('categories',2);
INSERT INTO "sqlite_sequence" VALUES('sub_categories',7);
INSERT INTO "sqlite_sequence" VALUES('makers',14);
INSERT INTO "sqlite_sequence" VALUES('products',3);
INSERT INTO "sqlite_sequence" VALUES('features',15);
INSERT INTO "sqlite_sequence" VALUES('images',15);
INSERT INTO "sqlite_sequence" VALUES('files',15);
CREATE UNIQUE INDEX users_email_unique on "users" ("email");
CREATE INDEX password_resets_email_index on "password_resets" ("email");
CREATE INDEX password_resets_token_index on "password_resets" ("token");
COMMIT;
