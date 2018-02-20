<?php
/*
 --
 example_ticketlog_extended - extended ticket list report
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
 *  - generate report as the `extended' ticket list
 * ----------------------------------------------------------------------
*/

$LANG['plugin_reports']['example_ticketlog_extended'][1]  =
  "Example.com - ticket log extended" ;  // The report name
$LANG['plugin_reports']['example_ticketlog_extended'][2]  =
  "Submitted" ;                          // Date/Time of submission
$LANG['plugin_reports']['example_ticketlog_extended'][3]  =
  "User Name" ;                          // Requester full name
$LANG['plugin_reports']['example_ticketlog_extended'][4]  =
  "Solution date" ;                      // Ticket solution Date/Time
$LANG['plugin_reports']['example_ticketlog_extended'][5]  =
  "Closing date" ;                       // Date/Time of the ticket closure
$LANG['plugin_reports']['example_ticketlog_extended'][6]  =
  "Urgency" ;                            // Ticket urgency
$LANG['plugin_reports']['example_ticketlog_extended'][7]  =
  "User group" ;                         // Requester group
$LANG['plugin_reports']['example_ticketlog_extended'][8]  =
  "User location" ;                      // Requester location (OU)
$LANG['plugin_reports']['example_ticketlog_extended'][9]  =
  "Assigned to" ;                        // Ticket/problem assigned technician
$LANG['plugin_reports']['example_ticketlog_extended'][10] =
  "waiting" ;                            // Waiting for something
$LANG['plugin_reports']['example_ticketlog_extended'][11] =
  "closed" ;                             // The ticket is closed
$LANG['plugin_reports']['example_ticketlog_extended'][12] =
  "solved" ;                             // Ticket is resolved, but still open

?>
