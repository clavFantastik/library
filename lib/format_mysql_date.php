<?php
	function format_mysql_date($mysql_date) {
		$date = DateTime::createFromFormat('Y-m-d H:i:s', $mysql_date);
        $date->setTimezone(new DateTimeZone('Europe/Moscow'));
		return $date->format('d.m.Y H:i');
	}
?>