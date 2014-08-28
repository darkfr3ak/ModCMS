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
  * XML Class
  * Represent the structure of a xml file, after to create the xml object you can create a root and and the nodes that you need.
  * when you finish with the xml you can get it in a string or save it into a file.
  * When you create a new XML object you should specify the version and the encoding,
  * the default value are 1.0 and UTF-8
  *  
  * @author Mauricio Souto - Sp�ria Software - www.spiria.com.uy
  */

class XML{
	var $version;
	var $encoding;
	var $root;
	
	function __construct($version_xml = "1.0", $ecoding_xml = "UTF-8"){
		$this->version = $version_xml;
		$this->encoding = $ecoding_xml;
	}
	
	function setVersion($version_xml){
		$this->version = $version_xml;
	}
	
	function setEcodig($ecoding_xml){
		$this->encoding = $ecoding_xml;
	}
	
	function getEcodig(){
		return $this->encoding;
	}
	
	function getVersion(){
		return $this->version;
	}
	
	function createRoot($root_name){
		$this->root = new XMLNode($root_name);
		return $this->root;
	}
	
	function getRoot(){
		return $this->root;
	}
	
	//Return a string that represent the XML file
	function toString($attibutesAsChilds = false){
		$string = "<?xml version='".$this->version."' encoding='".$this->encoding."' standalone='yes' ?>\n";
		if ($this->root != null){
			$string .= $this->root->toString(0, $attibutesAsChilds);
		}
		return $string;
	}
	
	
	function toFile($path, $file_name, $attibutesAsChilds = false){
		if ($path[strlen($path)-1] == "/"){
			$finalPath = $path.$file_name;
		} else {
			$finalPath = $path."/".$file_name;
		}
		$Handle = fopen($finalPath, 'w');
		$Data = $this->toString($attibutesAsChilds); 
		fwrite($Handle, $Data); 
		fclose($Handle);
	}
	
}
?>
