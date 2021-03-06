<?php
/**
* My Handy Restaurant
*
* http://www.myhandyrestaurant.org
*
* My Handy Restaurant is a restaurant complete management tool.
* Visit {@link http://www.myhandyrestaurant.org} for more info.
* Copyright (C) 2003-2004 Fabio De Pascale
* 
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
* 
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
* 
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*
* @author		Fabio 'Kilyerd' De Pascale <public@fabiolinux.com>
* @package		MyHandyRestaurant
* @copyright		Copyright 2003-2005, Fabio De Pascale
*/

class country extends object {
	function country ($id=0) {
		$this -> db = 'common';
		$this->table=$GLOBALS['table_prefix'].'countries';
		$this->id=$id;

		$this -> fetch_data();
	}
	
	function list_all_conf ($varname,$selected) {
		$query = "SELECT * FROM `".$this->table."`";
		$res=common_query($query,__FILE__,__LINE__);
		if(!$res) return ERR_MYSQL;

		if(!mysql_num_rows($res)) return '';

		$output = '
	<select name="data['.$varname.']">';
		
		while ($arr=mysql_fetch_array($res)) {
			if($selected == $arr['id']) $sel = ' selected';
			else $sel = '';
			
			$htmlcode = $arr['currency_html'];
			if (empty($htmlcode)) $htmlcode = '';
			else $htmlcode = ' ('.$htmlcode.')';
			
			$output .= '
		<option value="'.$arr['id'].'"'.$sel.'>'.$arr['name'].' - '.$arr['currency_letter'].$htmlcode.'</option>';
		}
		$output .= '
	</select>'."\n";
		return $output;
	}
}

function country_conf_currency ($html=false) {
	$id = get_conf(__FILE__,__LINE__,'country');
	$country = new country ($id);
	
	$curr_lett = $country -> data['currency_letter'];
	if(!$html) return $curr_lett;
	
	$curr_html = $country -> data['currency_html'];
	if (empty($curr_html)) return $curr_lett;
	
	return $curr_html;
}

?>