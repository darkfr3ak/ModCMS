<?php

/*-
 * Copyright (c) 2009 Sp�ria Software - www.spiria.com.uy
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 * 3. Neither the name of copyright holders nor the names of its
 *    contributors may be used to endorse or promote products derived
 *    from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * ``AS IS'' AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED
 * TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED.  IN NO EVENT SHALL COPYRIGHT HOLDERS OR CONTRIBUTORS
 * BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */
 
 
 /**
  * Attribute Class
  * Represent an attribute of a node and its value.
  * Is importante to specify when you want to scape the special character
  * of the sttribute value, to scape that character the class use the CDATA tag.
  * 
  * 
  * @author Mauricio Souto - Sp�ria Software - www.spiria.com.uy
  */
  
  

class XMLAttribute{
	var $name;
	var $value;
	var $scape = false;
	
	function __construct($att_name = "", $att_value = "", $att_scape = true){
		$this->name = $att_name;
		$this->value = $att_value;
		$this->scape = $att_scape;
	}
	
	function setName($att_name){
		$this->name = $att_name;
	}
	
	function setValue($att_value){
		$this->value = $att_value;
	}
	
	function setScape($att_scape){
		$this->scape = $att_scape;
	}
	
	function getName(){
		return $this->name;
	}
	
	function getValue(){
		return $this->value;
	}
	
	function getScape(){
		return $this->scape;
	}
	
	function toString($level = 0, $asChild = false){
		$i = 0;
		$tab = "";
		while ($i < $level){
			$tab .= "\t";
			$i = $i + 1;
		}
		if ($this->scape == false){
			if ($asChild){
				return $tab."<".$this->name.">".$this->value."</".$this->name.">\n";
			} else {
				return " ".$this->name."='".$this->value."'";	
			}
		} else {
			$str = $tab."<".$this->name." _is_att=\"YES\">\n";
			$str .= $tab."\t<![CDATA[".$this->value."]]>\n";
			$str .= $tab."</".$this->name.">\n";
			return $str;
		}
	}
}
?>
