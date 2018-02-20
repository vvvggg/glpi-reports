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
  "ПримерКо - журнал заявок расширенный" ;  // The report name
$LANG['plugin_reports']['example_ticketlog_extended'][2]  =
  "Внесено" ;                               // Date/Time of submission
$LANG['plugin_reports']['example_ticketlog_extended'][3]  =
  "ФИО" ;                                   // Requester full name
$LANG['plugin_reports']['example_ticketlog_extended'][4]  =
  "Решено" ;                                // Ticket solution Date/Time
$LANG['plugin_reports']['example_ticketlog_extended'][5]  =
  "Закрыто" ;                               // Date/Time of the ticket closure
$LANG['plugin_reports']['example_ticketlog_extended'][6]  =
  "Срочность" ;                             // Ticket urgency
$LANG['plugin_reports']['example_ticketlog_extended'][7]  =
  "Группа" ;                                // Requester group
$LANG['plugin_reports']['example_ticketlog_extended'][8]  =
  "Отдел" ;                                 // Requester location (OU)
$LANG['plugin_reports']['example_ticketlog_extended'][9]  =
  "Назначен" ;                              // Assigned technician
$LANG['plugin_reports']['example_ticketlog_extended'][10]  =
  "ожидание" ;                              // Waiting for something
$LANG['plugin_reports']['example_ticketlog_extended'][11]  =
  "закрыто" ;                               // The ticket is closed
$LANG['plugin_reports']['example_ticketlog_extended'][12]  =
  "решено" ;                                // Ticket is resolved but still open


?>
