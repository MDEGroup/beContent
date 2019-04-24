<?php


	/*
	
	This file is part of beContent.

    Foobar is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Foobar is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with beContent.  If not, see <http://www.gnu.org/licenses/>.
    
    http://www.becontent.org
    
    */




/* ///////////////////////////////////// SYSTEM ENTITIES //////////////////////// */

/* GROUPS - It is important to have it in this position */

$groupsEntity = new Entity($database,"groups");
$groupsEntity->setPresentation("name");

$groupsEntity->addField("name", VARCHAR, 50);
$groupsEntity->addField("description", TEXT);

$groupsEntity->connect();

/* ENTITIES - It is important to have it in this position */

$entitiesEntity = new Entity($database, "entities");
$entitiesEntity->setPresentation("name");

$entitiesEntity->addPrimaryKey("name", VARCHAR, 50);
$entitiesEntity->addField("content_name", VARCHAR, 50);
$entitiesEntity->addField("owner", VARCHAR, 1);


$entitiesEntity->addField("forum", VARCHAR, 1);
$entitiesEntity->addReference($groupsEntity, "forum_moderator");

$entitiesEntity->addReference($groupsEntity,"moderator_group");
$entitiesEntity->addReference($groupsEntity,"priviledged_group");

$entitiesEntity->connect();


/* USERS */

$usersEntity = new Entity($database, "users");
$usersEntity->setPresentation("%name %surname (%username)");
#$usersEntity->setPresentation("name surname (username)");

$usersEntity->addPrimaryKey("username", VARCHAR, 15);
$usersEntity->addField("password", PASSWORD);
$usersEntity->addField("email", VARCHAR, 100);
$usersEntity->addField("name", VARCHAR, 50);
$usersEntity->addField("surname", VARCHAR, 50);
$usersEntity->addField("phone", VARCHAR, 20);
$usersEntity->addField("fax", VARCHAR, 20);
$usersEntity->addField("active", VARCHAR, 1);

/* These are necessary for the newsletter management */

$usersEntity->addField("active_newsletter", VARCHAR, 1);
$usersEntity->addField("processed", VARCHAR, 1);

/* additional fields follow here */

$usersEntity->connect();

$usersEntity->setTextSearchFields("name", "surname", "email", "phone");
$usersEntity->setSearchPresentationHead("name", "surname");
$usersEntity->setSearchPresentationBody("email", "phone");
$usersEntity->setHandler("home.php");


/* USER-GROUPS */

$usersGroupsRelation = new Relation($usersEntity, $groupsEntity);

$usersGroupsRelation->connect();

/* SERVICE CATEGORIES */

$servicecategoryEntity = new Entity($database, "servicecategory");
$servicecategoryEntity->setPresentation("name");

$servicecategoryEntity->addField("name", VARCHAR, 40);
$servicecategoryEntity->addField("position", POSITION);

$servicecategoryEntity->connect();



/* SERVICES */

$servicesEntity = new Entity($database,"services");
$servicesEntity->setPresentation("name");

$servicesEntity->addField("name", VARCHAR, 50);
$servicesEntity->addField("script", VARCHAR, 100);
$servicesEntity->addField("entry", VARCHAR, 30);
$servicesEntity->addReference($servicecategoryEntity, "servicecategory");
$servicesEntity->addField("visible", VARCHAR, 1);
$servicesEntity->addField("des", TEXT);
$servicesEntity->addReference($entitiesEntity, "id_entities");
$servicesEntity->addReference($groupsEntity, "superuser_group");
$servicesEntity->addField("position", POSITION);

$servicesEntity->connect();

/* SERVICES-GROUPS */

$servicesGroupsRelation = new Relation($servicesEntity, $groupsEntity);
$servicesGroupsRelation->connect();

/* LOGGING */

$logEntity = new Entity($database, "logs");

$logEntity->setPresentation("date", "entity", "operation");

$logEntity->addField("operation", VARCHAR, 20);
$logEntity->addField("entity", VARCHAR, 100);
$logEntity->addField("itemid", VARCHAR, 255);
$logEntity->addField("service", VARCHAR, 100);
$logEntity->addField("username", VARCHAR, 15);
$logEntity->addField("date", LONGDATE);
$logEntity->addField("ip",VARCHAR, 15);

$logEntity->connect();


/* ///////////////////////////////////// RSS MANAGEMENT //////////////////////// */

/* 

	This entity is preposed for the Rss channels gestion. 
	Is important that all the fields have the correspondent name of 
	the Rss 2.0 TAG. The field title,link and description is MANDATORY.
	
	For the composed Tag (es. <image>) is sufficient have fields 
	for the children Tag (es. <link> ) as parent_cildren (es. image_link)
	Is possible define a n<->n relation only if the name is'n 
	automaticaly generation and don't contain bc_channel that substring
	
	
*/


/* LANGUAGES */

$lanEntity = new Entity($database, "rsslanguages");
$lanEntity->setPresentation("code", "name");

$lanEntity->addPrimaryKey("code", VARCHAR, 8);
$lanEntity->addField("name", VARCHAR, 50);

$lanEntity->connect();

/* CHANNELS */

$channelEntity = new Entity($database,"bc_channel");
$channelEntity->setPresentation("title");

$channelEntity->addField("title",VARCHAR,50,MANDATORY);
$channelEntity->addField("link",VARCHAR,100,MANDATORY);
$channelEntity->addField("description",VARCHAR,150,MANDATORY);
$channelEntity->addReference($lanEntity, "language");

$channelEntity->addField("image_title",VARCHAR,50);
$channelEntity->addField("image_link",VARCHAR,100);
$channelEntity->addField("image",FILE);


$channelEntity->connect();

/*Channel-entity*/

$channelAssotiation = new Entity($database,"channel_entity");
$channelAssotiation->setPresentation("entity");
$channelAssotiation->addField("entity",VARCHAR,50,MANDATORY);
$channelAssotiation->addReference($channelEntity);

$channelAssotiation->connect();

$rssMod=new Entity($database,"bc_rss_mod");
$rssMod->setPresentation("entity");
$rssMod->addPrimaryKey("entity",VARCHAR,50);
$rssMod->addField("modality",VARCHAR,20,MANDATORY);


$rssMod->connect();

/* ////////////////////////////// COMMENTS ////////////////////////// */

$commentEntity = new Entity($database, "comments", WITH_OWNER);
$commentEntity->setPresentation("entityname", "itemid");

$commentEntity->addField("entityname", VARCHAR, 100);
$commentEntity->addField("itemid", VARCHAR, 255);
$commentEntity->addField("body", TEXT);
$commentEntity->addField("rate", VARCHAR, 1);
$commentEntity->addField("ratenumbers", INT);
$commentEntity->addField("active", VARCHAR, 1);
$commentEntity->addField("new", VARCHAR, 1);

$commentEntity->connect();

/* ////////////////////////////////////////////////////////////////// */


/* SECTIONS */

$sectionEntity = new Entity($database, "section");
$sectionEntity->setPresentation("name");

$sectionEntity->addField("name", VARCHAR, 40);

$sectionEntity->connect();

/* PAGE CONTENTS - OK*/


$pageEntity = new Entity($database, "page", WITH_OWNER);
$pageEntity->setPresentation("title");

$pageEntity->addReference($sectionEntity, "section");
$pageEntity->addField("title", VARCHAR, 100);
$pageEntity->addField("description", TEXT);
$pageEntity->addField("subtitle", VARCHAR, 100); 
$pageEntity->addField("body", TEXT);
$pageEntity->addField("foto", FILE);
$pageEntity->addField("position", POSITION);
$pageEntity->addField("link", VARCHAR, 100);

$pageEntity->connect();

$pageEntity->setTextSearchFields("title", "body");
$pageEntity->setSearchPresentationHead("title");
$pageEntity->setSearchPresentationBody("body");
$pageEntity->setHandler("page.php");

/* MENU - OK*/

$menuEntity = new Entity($database, "menu");
$menuEntity->setPresentation("entry");

$menuEntity->addField("entry", VARCHAR, 50);  
$menuEntity->addField("link", VARCHAR, 255);
$menuEntity->addReference($pageEntity, "page_id");
$menuEntity->addReference($menuEntity, "parent_id");
$menuEntity->addField("position", POSITION);

$menuEntity->connect();

/* NEWS */

$newsEntity = new Entity($database, "news", WITH_OWNER);
$newsEntity->setPresentation("title");

$newsEntity->addField("title", VARCHAR, 68, MANDATORY);

$newsEntity->addField("date", LONGDATE, MANDATORY);
$newsEntity->addField("active", VARCHAR, 1);
$newsEntity->addField("body", TEXT); 

$newsEntity->addRss($channelEntity,"title=\"title\" description=\"body\" pubDate=\"date\"");
#$newsEntity->addRssFilter("active = '*'");

$newsEntity->connect();

$newsEntity->setTextSearchFields("title", "body");
$newsEntity->setSearchPresentationHead("title");
$newsEntity->setSearchPresentationBody("body");
$newsEntity->setHandler("news.php");




?>