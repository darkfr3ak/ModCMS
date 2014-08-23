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
  * Class Node
  * Represent a node of a xml file that have attributes and a list of childs
  * The first Node in the XML is the root Node, it is created from the XML class
  * All Node have a name, the default name of each node is "node", you can specify
  * the name of the node when you create one.
  * 
  * @author Mauricio Souto - Sp�ria Software - www.spiria.com.uy
  */

class XMLNode {
	var $name = "node";
	var $atts = array();
	var $childs = array();
	
	function __construct($name = "node"){
		$this->name = $name;
	}
	
	function setName($node_name){
		$this->name = $node_name;
	}
	
	function getName(){
		return $this->name;
	}
	
	function getAttributes(){
		return $this->atts;
	}
	
	function getChilds(){
		return $this->childs;
	}
	
	//Create a new attribute in the Node
	function addAttribute($att_name, $att_value, $scape = true){
		$a = new XMLAttribute($att_name, $att_value, $scape);
		array_push($this->atts, $a);
		return $a;
	}
	
	//Create a new Child in the Node
	function addChild($child_name){
		$n = new Node($child_name);
		array_push($this->childs, $n);
		return $n;
	}
	
	//Return the value associated to $att_name in the Node
	function getAttValue($att_name){
		$att_value = "";
		foreach ($this->att as $att){
			if ($att->getName() == $att_name){
				$att_value = $att->getValue();
				break;
			}
		}
		return $att_value;	
	}
	
	//Return the first child with name $child_name and $att_id=$att_val
	function getChild($child_name, $att_id, $att_val){
		$child_value = "";
		$find = false;
		foreach ($this->childs as $child){
			if ($child->getName() == $child_name){
				if ($child->getAttValue($att_id) == $att_val){
					$child_value = $child;
					break;	
				}
			}
		}
		return $child_value;	
	}
	
	function getChildsCount(){
		$i = 0;
		foreach ($this->childs as $child){
			$i = $i + 1;
		}
		return $i;
	}
	
	
	function toString($level = 0, $attibutesAsChilds = false){
		$tab = "";
		$i = 0;
		while ($i < $level){
			$tab .= "\t";
			$i = $i + 1;
		}
		$atts_scape = array();
		$string = $tab."<".$this->name;
		$scape = 0;
		if ($attibutesAsChilds){
			$attChilds = 0;
			$string .= ">\n";
			foreach ($this->atts as $att){
				if ($att->getScape() == false){
					$string .= $att->toString($level + 1,$attibutesAsChilds);
					$attChilds = $attChilds  + 1;
				} else {
					array_push($atts_scape, $att);
					$scape = $scape + 1;
				}
			}
			foreach ($atts_scape as $att){
				$string .= $att->toString($level + 1);
			}
			foreach ($this->childs as $child){
				$string .= $child->toString($level + 1,$attibutesAsChilds);
			}
			if (($this->getChildsCount() + $scape + $attChilds ) > 0){
				$string .= $tab."</".$this->name.">\n";
			}
		} else {
			foreach ($this->atts as $att){
				if ($att->getScape() == false){
					$string .= $att->toString($level + 1, false);
				} else {
					array_push($atts_scape, $att);
					$scape = $scape + 1;
				}
			}
			$string .= ((($this->getChildsCount() + $scape)>0)?">\n":"/>\n");
			foreach ($atts_scape as $att){
				$string .= $att->toString($level + 1);
			}
			foreach ($this->childs as $child){
				$string .= $child->toString($level + 1,$attibutesAsChilds);
			}
			if (($this->getChildsCount() + $scape) > 0){
				$string .= $tab."</".$this->name.">\n";
			}
		}
		return $string;
	}
}

?>
