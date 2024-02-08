<!DOCTYPE html>

<!-- PHP Functions -->
<?php

// Global Variables
$color=get_random_color();

// Define Functions
function get_XForwardedFor()
{
    // If not set, return NULL, else return value
    if (!isset ($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return "None";
    } else {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
}

function get_protocol()
{
    // Check if we are using HTTPS
    if (empty($_SERVER['HTTPS'])) {
        return "HTTP";
    } else {
        return "HTTPS";
    }
}

function get_protocol_color()
{
    // Check if we are using HTTPS
    if (empty($_SERVER['HTTPS'])) {
        return "red";
    } else {
        return "green";
    }
}

function get_random_color()
{
    // Obtain random color creted at VM startup
    return '#' . file_get_contents("/usr/share/nginx/html/Color");
}

function display_local_ipv4_addr_table()
{
  $ip_array = explode(PHP_EOL,shell_exec("/sbin/ifconfig ens3 | awk '/inet addr:/' | awk '{print $2}' | sed 's/addr://'"));
  foreach($ip_array as $str) {
    if(isset($str) && $str !== '') {
      echo "<tr><td style='border:none; text-align:center'>$str</td></tr>";
    }
  }
}

function display_local_ipv6_addr_table()
{
  $ip_array = explode(PHP_EOL,shell_exec("/sbin/ifconfig ens3 | grep 'inet6' | sed 's/^.*inet6 addr: //' | sed 's/ Scope.*$//' | sed 's/\/.*$//'"));
  foreach($ip_array as $str) {
    if(isset($str) && $str !== '') {
      echo "<tr><td style='border:none; text-align:center'>$str</td></tr>";
    }
  }
}

?>


<html>

<head>
  <style>
    td {
      font-size:105%;
    }

    #download-heading {
      border-bottom: 2px solid red;
      font-family: "Courier New", monospace;
      font-style: normal;
      font-size: 15px;
      text-align: center;
      color: black;
      background-color: lightcyan;
    }

    #download-links {
      font-family: "Courier New", monospace;
      font-style: normal;
      font-size: 15px;
      text-align: center;
      color: blue;
    }
  </style>

  <title>Iwan Hoogendoorn  - <?php echo $_SERVER['SERVER_ADDR'];?></title>
  <link rel="icon" type="image/x-icon" href="favicon.ico"/>
</head>

<body>

<center>
<table style="border:25px; border-style:solid; border-color:<?php echo $color; ?>; background-color:<?php echo $color; ?>;">
  <tr>
    <td>
      <a href="https://iwanhoogendoorn.nl" target="_blank">
        <img src="Iwan-hoogendoorn.logo.png" alt="Iwan Hoogendoorn"></img>
      </a>
    </td>
  </tr>
</table>
</center>

<center>
<!-- Download Files -->
<table style="margin-bottom: 15px; border:1px; border-style:solid; border-color:black">
  <tr>
    <td colspan="20"; id="download-heading">Files To Perform Download Speed Tests</td>
  </tr>
  <tr id="download-links">
    <td style="padding-left:10px; padding-right:10px"><a href="health.html">health.html</a></td>
    &nbsp;
    <td style="padding-left:10px; padding-right:10px"><a href="files/1KB.txt">1KB</a></td>
    &nbsp;
    <td style="padding-left:10px; padding-right:10px"><a href="files/10KB.txt">10KB</a></td>
    &nbsp;
    <td style="padding-left:10px; padding-right:10px"><a href="files/100KB.txt">100KB</a></td>
    &nbsp;
    <td style="padding-left:10px; padding-right:10px"><a href="files/500KB.txt">500KB</a></td>
    &nbsp;
    <td style="padding-left:10px; padding-right:10px"><a href="files/1MB.txt">1MB</a></td>
    &nbsp;
    <td  style="padding-left:10px; padding-right:10px"><a href="files/5MB.txt">5MB</a></td>
  </tr>
</table>
</center>

<center>
<!-- main request info outter table -->
<table border="5" bgcolor="#EFEFEE"><tr><td>
<center>
<table border="0"><!-- request info inner table for data-->
  <tr><center style="font-size:175%"><b>Request Information</b></center></tr>
</table>

<!-- Client/Server Side Table -->
<table style="border:4px; border-style:outset; margin-left:25px; margin-right:25px">
  <br>
  <tr>
    <td colspan="2"; style="border:none; text-align:center; font-size:125%"><u><b>Client</b></u></td>
    <td style="border:none">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td colspan="2"; style="border:none; text-align:center; font-size:125%"><u><b>Server</b></u></td>
  </tr>
  <tr>
    <td style="border:none; text-align:right">Client IP:</td>
    <td style="border:none"><?php echo $_SERVER['REMOTE_ADDR'];?></td>
    <td style="border:none"></td>
    <td style="border:none; text-align:right">Server IP:</td>
    <td style="border:none"><?php echo $_SERVER['SERVER_ADDR'];?></td>
  </tr>
  <tr>
    <td style="border:none; text-align:right">Client Port:</td>
    <td style="border:none"><?php echo $_SERVER['REMOTE_PORT'];?></td>
    <td style="border:none"></td>
    <td style="border:none; text-align:right">Server Port:</td>
    <td style="border:none"><?php echo $_SERVER['SERVER_PORT'];?></td>
  </tr>
  <tr>
    <td style="border:none; text-align:right">X-Forwarded-For:</td>
    <td style="border:none"><?php echo get_XForwardedFor();?></td>
    <td style="border:none"></td>
    <td style="border:none; text-align:right">Protocol:</td>
    <td style="border:none"><?php echo $_SERVER['SERVER_PROTOCOL']." (<B style='color:".get_protocol_color()."'>".get_protocol();?></B>)</td>
  </tr>
</table>

<!-- Other Details Table -->
<table border="4">
  <br>
  <tr>
    <td colspan="2"; style="border:none; text-align:center; font-size:125%"><u><b>Other Details</b></u></td>
  </tr>
  <tr>
    <td style="border:none; text-align:right">Method:</td><td style="border:none"><?php echo $_SERVER['REQUEST_METHOD'];?></td>
  </tr>
  <tr>
    <td style="border:none; text-align:right">Host Header:</td><td style="border:none"><?php echo $_SERVER['HTTP_HOST'];?></td>
  </tr>
  <tr>
    <td style="border:none; text-align:right">Requested URI:</td><td style="border:none"><?php echo $_SERVER['REQUEST_URI'];?></td>
  </tr>
  <tr>
    <td style="border:none; text-align:right">Current Time (GMT):</td><td style="border:none"><?php echo date("F j, Y, g:i:s a");?></td>
  </tr>
</table><!-- Other Details table -->

<!-- IP Address Table -->
<table border="4">
  <br>
  <tr>
    <td style="border:none; text-align:center; font-size:125%"><u><b>IP Addresses</b></u></td>
  </tr>
  <?php display_local_ipv4_addr_table();?>
  <?php display_local_ipv6_addr_table();?>
</table><!-- IP Address Table -->
</center>

<br>
</table>

<!-- Display Version -->
<p style="text-align:center; color:blue; font-size:20px">This page generated by <a href="https://iwanhoogendoorn.nl" target="_blank">Iwan Hoogendoorn</a> </p>
</center>

</body>
</html>
