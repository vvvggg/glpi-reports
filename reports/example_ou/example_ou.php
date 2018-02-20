<?php
/*
 --
 example_ou - Example.com organization units (OU) report with ticket stats
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
 *  - generate report as the ticket list by OU
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

  $report -> setSubNameAuto ( ) ;

  //Names of the columns to be displayed
  $report -> setColumns ( array (
    new PluginReportsColumn( "Location" ,
                             $LANG['common'][15] ,
                             array ( 'sorton' => 'Location' )
                           ) ,
    new PluginReportsColumn( "Type" ,
                             $LANG['common'][17] ,
                             array ( 'sorton' => 'Type'  )
                           ) ,
    new PluginReportsColumn( "Tickets"  ,
                             $LANG['plugin_reports']['example_ou'][2] ,
                             array ( 'sorton' => 'Tickets'  )
                           ) ,
// display ticket IDS in each group
//    new PluginReportsColumn( "IDs" ,
//                             $LANG['plugin_reports']['example_ou'][3] ,
//                             array (  )
//                           ) ,
                          )
  ) ;

  $query      = '
    SELECT
      l.completename                                       AS "Location" ,
      tt.title                                             AS "Type"     ,
      count(t.id)                                          AS "Tickets"  ,
      group_concat(t.id ORDER BY t.id ASC SEPARATOR ", ")  AS "IDs"
    FROM
      glpi_tickets         AS t  ,
      glpi_users           AS u  ,
      glpi_requesttypes    AS s  ,
      glpi_itilcategories  AS c  ,
      glpi_tickets_users   AS tu ,
      glpi_locations       AS l  ,
      glpi_ticket_types    AS tt
    WHERE
      t.entities_id        = ' . $_SESSION["glpiactive_entity"] . '
      AND
      t.is_deleted         = 0
      AND
      tu.tickets_id        = t.id
      AND
      tu.type              = 1
      AND
      tu.users_id          = u.id
      AND
      t.requesttypes_id    = s.id
      AND
      t.itilcategories_id  = c.id
      AND
      u.locations_id       = l.id
      AND
      t.type               = tt.id
  ' . $report -> addSqlCriteriasRestriction ( "AND" )
    . '
    GROUP BY
      l.completename  ,
      tt.title
    UNION
    SELECT
      "N/A"                                                AS "Location" ,
      tt.title                                             AS "Type"     ,
      count(t.id)                                          AS "Tickets"  ,
      group_concat(t.id ORDER BY t.id ASC SEPARATOR ", ")  AS "IDs"
    FROM
      glpi_tickets        AS t  ,
      glpi_users          AS u  ,
      glpi_requesttypes   AS s  ,
      glpi_itilcategorie  AS c  ,
      glpi_tickets_users  AS tu ,
      glpi_locations      AS l  ,
      glpi_ticket_types   AS tt
    WHERE
      t.entities_id        = ' . $_SESSION["glpiactive_entity"] . '
      AND
      t.is_deleted         = 0
      AND
      tu.tickets_id        = t.id
      AND
      tu.type              = 1
      AND
      tu.users_id          = u.id
      AND
      t.requesttypes_id    = s.id
      AND
      t.itilcategories_id  = c.id
      AND
      u.locations_id       = 0    -- those users who have no location specified
      AND
      t.type               = tt.id
  ' . $report -> addSqlCriteriasRestriction ( "AND" )
    . '
    GROUP BY
      l.completename ,
      tt.title
  ' . $report -> getOrderBy('Tickets')
  ;

  $report  -> setSqlRequest ( $query ) ;
  $report  -> execute ( ) ;

} ;

?>
