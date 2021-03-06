<?php
/* @(#) $Id: help.php,v 1.10 2008/03/04 14:26:41 dcid Exp $ */

/* Copyright (C) 2006-2013 Trend Micro
 * All rights reserved.
 *
 * This program is a free software; you can redistribute it
 * and/or modify it under the terms of the GNU General Public
 * License (version 3) as published by the FSF - Free Software
 * Foundation
 */

/*This file has been modified by:
 *Jorge Alzate	jrglzt@gmail.com
 *2014/12/01
 */
    


/* OS PHP init */
if (!function_exists('os_handle_start'))
{
    echo "<b class='red'>You are not allowed direct access.</b><br />\n";
    return(1);
}
?>

<h2>About</h2>
<br />
<font size="2">
RCWUI is a an open source web interface for the <a href="http://www.ossec.net">OSSEC-HIDS</a> project. RCWUI is derivatives of OSSEC WebUI. For details on
how to install, configure or use it, please take a look at <a href="https://github.com/jrglzt/rcwui">https://github.com/jrglzt/rcwui</a>. <br /><br />

Autor:
<dd><strong>Jorge Alzate</strong> - jrglzt ( at ) gmail.com</dd>

<br /><br /><br />

<h3 class="my">License</h3>
<font size="2"> 
      Copyright &copy; 2006 - 2013 <a href="http://www.trendmicro.com">Trend Micro</a>.  All rights reserved.
<br /><br />
      
RCWUI is a free software; you can redistribute it and/or modify it under the terms of the GNU General Public License (version 3) as published by the FSF - Free Software Foundation. 
<br /><br />
OSSEC is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
</font>
