<?php
/*
 --
 example_ticketlog - ticket list report for Example.com with specific reqs
 Copyright (C) 2013 Vladimir Gusev, https://gusev.pro
 --

 LICENSE

 This code is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 reports is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with reports. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
*/

/*
 * ----------------------------------------------------------------------
 * Original Author of file: Vladimir Gusev
 *
 * The main goal:
 *  - generate report as the tickets list
 * ----------------------------------------------------------------------
*/

//Options for GLPI 0.71 and newer : need slave db to access the report
$USEDBREPLICATE         = 1 ;
$DBCONNECTION_REQUIRED  = 0 ;  // not really a big SQL request

define ( 'GLPI_ROOT' , '../../../..' ) ;
include ( GLPI_ROOT . "/inc/includes.php" ) ;

$report  = new PluginReportsAutoReport ( ) ;

//Report's search criteria
new PluginReportsDateIntervalCriteria ( $report , "t.date" ) ;

//Display criteria form is needed
$report  -> displayCriteriasForm ( ) ;

//If criteria have been validated
if ( $report -> criteriasValidated ( ) ) {

  $report  -> setSubNameAuto ( ) ;

  //Names of the columns to be displayed
  $report -> setColumns ( array (
    new PluginReportsColumn( "ID" ,
                             $LANG['common'][2] ,
                             array ( 'sorton' => 'ID'        ) ) ,
    new PluginReportsColumn( "Submitted" ,
                             $LANG['plugin_reports']['example_ticketlog'][2] , array ( 'sorton' => 'Submitted' )
                           ) ,
    new PluginReportsColumn( "Title" ,
                             $LANG['common'][57] ,
                             array ( 'sorton' => 'Title' )
                           ) ,
    new PluginReportsColumn( "Description" ,
                             $LANG['joblist'][6] ,
                             array ( )
                           ) ,
    new PluginReportsColumn( "Status" ,
                             $LANG['state'][0] ,
                             array ( 'sorton' => 'Status' )
                           ) ,
    new PluginReportsColumn( "User name" ,
                             $LANG['plugin_reports']['example_ticketlog'][3] ,
                             array ( 'sorton' => 'u.realname , u.firstname' )
                           ) ,
    new PluginReportsColumn( "Source" ,
                             $LANG['job'][44] ,
                             array ( 'sorton' => 'Source' )
                           ) ,
    new PluginReportsColumn( "Type" ,
                             $LANG['common'][36] ,
                             array ( 'sorton' => 'Type' )
                           ) ,
    new PluginReportsColumn( "Solution" ,
                             $LANG['jobresolution'][1] ,
                             array ( )
                           ) ,
             )
  ) ;

  //Colunmns mappings if needed
/*  $columns_mappings  = array (
    'linked_action' => array (
             Log::HISTORY_DELETE_ITEM         => $LANG['log'][22]      ,
             Log::HISTORY_RESTORE_ITEM        => $LANG['log'][23]      ,
             Log::HISTORY_ADD_DEVICE          => $LANG['devices'][25]  ,
             Log::HISTORY_UPDATE_DEVICE       => $LANG['log'][28]      ,
             Log::HISTORY_DELETE_DEVICE       => $LANG['devices'][26]  ,
             Log::HISTORY_INSTALL_SOFTWARE    => $LANG['software'][44] ,
             Log::HISTORY_UNINSTALL_SOFTWARE  => $LANG['software'][45] ,
             Log::HISTORY_DISCONNECT_DEVICE   => $LANG['central'][6]   ,
             Log::HISTORY_CONNECT_DEVICE      => $LANG['log'][55]      ,
             Log::HISTORY_OCS_IMPORT          => $LANG['ocsng'][7]     ,
             Log::HISTORY_OCS_DELETE          => $LANG['ocsng'][46]    ,
             Log::HISTORY_OCS_LINK            => $LANG['ocsng'][47]    ,
             Log::HISTORY_OCS_IDCHANGED       => $LANG['ocsng'][48]    ,
             Log::HISTORY_LOG_SIMPLE_MESSAGE  => ""
    )
  ) ;

  $report  -> setColumnsMappings ( $columns_mappings ) ;
*/

  $query  = '
    SELECT
    DISTINCT
      t.id                                      AS "ID"          ,  -- ticket ID
      t.date                                    AS "Submitted"   ,  -- ticket submission (aka opening) date and time
      t.name                                    AS "Title"       ,  -- ticket title
      t.content                                 AS "Description" ,  -- ticket description (aka body)
      t.status                                  AS "Status"      ,  -- ticket status
      concat ( u.realname , " " , u.firstname ) AS "User name"   ,  -- ticket combined author (user) name
      s.name                                    AS "Source"      ,  -- ticket source (phone/email/etc)
      c.completename                            AS "Type"        ,  -- ticket category assigned
      t.solution                                AS "Solution"       -- ticket solution provided
    FROM
      glpi_tickets         AS t  ,
      glpi_users           AS u  ,
      glpi_requesttypes    AS s  ,
      glpi_itilcategories  AS c  ,
      glpi_tickets_users   AS tu
    WHERE
      t.entities_id        = ' . $_SESSION["glpiactive_entity"] . '  -- current entity we go in
      AND
      t.is_deleted         = 0                                       -- not-deleted tickets
      AND
      tu.tickets_id        = t.id
      AND
      tu.type              = 1                                       -- 1 for "requester", 2 for "resolver, 3 for "watcher" (as per http://www.glpi-project.org/wiki/doku.php?id=en:importticketsintoglpi)
      AND
      tu.users_id          = u.id
      AND
      t.requesttypes_id    = s.id
      AND
      t.itilcategories_id  = c.id
  ' . $report -> addSqlCriteriasRestriction ( "AND" )
    . $report -> getOrderBy('Submitted')
  ;

  $report  -> setSqlRequest ( $query ) ;
  $report  -> execute ( ) ;

} ;

// DEBUG: print "<hr><hr>" . $query . "<hr><hr>" ;

?>
