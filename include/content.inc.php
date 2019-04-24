<?php

	/*
	
	This file is part of beContent.

    Foobar is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Foobar is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with beContent.  If not, see <http://www.gnu.org/licenses/>.
    
    http://www.becontent.org
    
    */


require_once 'include/Pager/Pager.php';

DEFINE("SINGLE", "SINGLE");
DEFINE("FILTER", "FILTER");
#DEFINE("NORMAL", "NORMAL");
#DEFINE("ALL", "ALL");
DEFINE("HIERARCHICAL", "HIERARCHICAL");
DEFINE("INDEXED", "INDEXED");
DEFINE("ISEMPTY", "ISEMPTY");
DEFINE("ISNOTEMPTY", "ISNOTEMPTY");

DEFINE('ACTIVE', "active = '*'");

Class Content {
	var 
		$entity_name,
		$join_entities,
		$join_entities_2,
		$join_rules,
		$join_rules_2,
		$join_condition,
		
		$template_single,
		$template_multiple,
		$template,
		$template_alt,
		$templates,
		
		$buffer,
		
		$mode,
		$filters,
		$condition,
		$order_fields,
		$limit,
		$copies,
		$triggers,
		$propagate,
		$cache,
		$languages,
		$parameters, 
		$style,
		$presentation,
		$values,
		
		$pager,
		
		$debug;
			
		
	function Content($entity) {
		
		$args = func_get_args();
		
		if (count($args)>1) {
			
			for($i=1; $i<count($args); $i++) {
				
				$item = $args[$i];
				$this->join_entities[$item->name] = $item->name;	
				$this->join_entities_2[] = $item->name;
				
				$this->join_rules[$item->name] = "";
				$this->join_rules_2[$item->name][] = "";
			}
			
			
		}
			
		$this->entities = func_get_args();
			
		$this->entity_name = $entity->name;
		$this->template_single = $entity->name."_single";
		$this->template_multiple = $entity->name."_multiple";
		$this->template = false;
		$this->template_alt = false;
		$this->limit = false;
		$this->copies = false;
		$this->triggers = false;
		$this->presentation = false;
		$this->pager = false;
		$this->debug = false;
		
		$this->style = NORMAL;
		
		$this->order_fields = $this->detectOrderFields();

		if (isset($GLOBALS['config']['languages'])) {
			foreach ($GLOBALS['config']['languages'] as $k => $v) {
				$this->languages[$k] = $k;
			}
		}
						
		$this->detectCardinality();
		
	}
	
	function setJoinRules() {
		
		$args = func_get_args();
		$i=0;
		foreach($this->join_rules as $name => $rule) {
			$this->join_rules[$name] = $args[$i];
			$this->join_rules_2[$name][] = $args[$i];
			
			$i++;
		}
	}
	
	function setJoinCondition($condition) {
		$this->join_condition = $condition;
	}
	
	function setTemplate($name) {
		$this->template = $name;
	}
	
	function setContent($name, $value) {
		$this->values[$name] = $value;
	}
	
	function setConditionalTemplate($template1, $template2, $cond, $field) {
		
		$this->template_alt["true"] = $template1; 
		$this->template_alt["false"] = $template2; 
		$this->template_alt["expr"] = $cond; 
		$this->template_alt["field"] = $field; 
	}
	
	function getName($name) {
		return $this->entity_name."_".$name;
	}
	
	function setParameter($name, $value) {
		
		$this->parameters[$name] = $value;
	}
	
	
	
	function clean() {
		
		$entity = $GLOBALS['database']->getEntityByName($this->entity_name);
		
		unset($_REQUEST["{$this->entity_name}_{$entity->fields[0]['name']}"]);
	}
	
	
	function unsetParameter($name) {
		unset($_REQUEST[$name]);
	}
	
	function enableParameters() {
		if (is_array($this->parameters)) {
			foreach($this->parameters as $k => $v) {
				$_REQUEST[$k] = $v;
			}
		}
		
	}
	
	function disableParameters() {
		if (is_array($this->parameters)) {
			foreach($this->parameters as $k => $v) {
				unset($_REQUEST[$k]);
			}
		}
	}
	
	function setPager() {
		$this->pager = true;
	}
	
	function setDebug() {
		$this->debug = true;
	}
	
	
	function setPresentation() {
		
		$this->presentation = func_get_args();
	}
	
	function getEntityFields() {
		
		$result = "";

		$id = uniqid(time());
		
		foreach($this->entities[0]->fields as $field) {
			
			if (ereg("_{$GLOBALS['config']['currentlanguage']}$", $field['name'])) {
				
				$result .= aux::first_comma($id, ", ");
				
				$result .= "{$this->entity_name}.{$field['name']} AS {$this->entity_name}_";
				$result .= substr($field['name'], 0, strlen($field['name'])-3);
			
				
			} else {
			
				switch ($field['type']) {
					case FILE:
						$result .= aux::first_comma($id, ", ");
						$result .= "{$this->entity_name}.{$field['name']}_filename AS {$this->entity_name}_{$field['name']}_filename";	
						$result .= aux::first_comma($id, ", ");
						$result .= "{$this->entity_name}.{$field['name']}_size AS {$this->entity_name}_{$field['name']}_size";	
						$result .= aux::first_comma($id, ", ");
						$result .= "{$this->entity_name}.{$field['name']}_type AS {$this->entity_name}_{$field['name']}_type";	
						break;
					
					default:
						$result .= aux::first_comma($id, ", ");
						$result .= "\n"; 
						$result .= "{$this->entity_name}.{$field['name']} AS {$this->entity_name}_{$field['name']}";
						break;
				}
			}
		}
		
		if (is_array($this->join_entities_2)) {
			
			foreach($this->join_entities_2 as $name) {
				
				$join_entities[$name][] = true;
				
				if (count($join_entities[$name]) == 1) {
					$postfix = "";
				} else {
					$postfix = "_".count($join_entities[$name]);
				}
				
				$entity = $GLOBALS['database']->getEntityByName($name);
				
				foreach($entity->fields as $field) {
					

					if (ereg("_{$GLOBALS['config']['currentlanguage']}$", $field['name'])) {
						
						$result .= aux::first_comma($id, ", ");
					
						$result .= "{$entity->name}.{$field['name']} AS {$entity->name}{$postfix}_";
						$result .= substr($field['name'], 0, strlen($field['name'])-3);
						
				
					} else {
			
						switch ($field['type']) {
							case FILE:
								$result .= aux::first_comma($id, ", ");
								$result .= "{$entity->name}{$postfix}.{$field['name']}_filename AS {$entity->name}{$postfix}_{$field['name']}_filename";
								
								$result .= aux::first_comma($id, ", ");
								$result .= "{$entity->name}{$postfix}.{$field['name']}_size AS {$entity->name}{$postfix}_{$field['name']}_size";	
								
								$result .= aux::first_comma($id, ", ");
								$result .= "{$entity->name}{$postfix}.{$field['name']}_type AS {$entity->name}{$postfix}_{$field['name']}_type";	
								break;
					
							default:
								$result .= aux::first_comma($id, ", ");
								$result .= "\n"; 
								$result .= "{$entity->name}{$postfix}.{$field['name']} AS {$entity->name}{$postfix}_{$field['name']}";
								break;
						}
						
						#$result .= "{$entity->name}.{$field['name']} AS {$entity->name}_{$field['name']}";
					}
					
					
					
				}
			}
		}
		
		if (is_array($this->copies)) {
			foreach($this->copies as $copy) {
				$result .= aux::first_comma($id, ", ");
				$result .= "$copy[0] AS $copy[1]";
			}
		}
		
		return $result;
	}
	
	function getEntityFields2() {
		
		$result = "";

		$id = uniqid(time());
		
		foreach($this->entities[0]->fields as $field) {
			
			if (ereg("_{$GLOBALS['config']['currentlanguage']}$", $field['name'])) {
				
				$result .= aux::first_comma($id, ", ");
				
				$result .= "{$this->entity_name}.{$field['name']} AS {$this->entity_name}_";
				$result .= substr($field['name'], 0, strlen($field['name'])-3);
			
				
			} else {
			
				switch ($field['type']) {
					case FILE:
						$result .= aux::first_comma($id, ", ");
						$result .= "{$this->entity_name}.{$field['name']}_filename AS {$this->entity_name}_{$field['name']}_filename";	
						$result .= aux::first_comma($id, ", ");
						$result .= "{$this->entity_name}.{$field['name']}_size AS {$this->entity_name}_{$field['name']}_size";	
						$result .= aux::first_comma($id, ", ");
						$result .= "{$this->entity_name}.{$field['name']}_type AS {$this->entity_name}_{$field['name']}_type";	
						break;
					
					default:
						$result .= aux::first_comma($id, ", ");
						$result .= "{$this->entity_name}.{$field['name']} AS {$this->entity_name}_{$field['name']}";
						break;
				}
			}
		}
		
		if (is_array($this->join_entities)) {
			
			foreach($this->join_entities as $name) {
				
				$entity = $GLOBALS['database']->getEntityByName($name);
				
				foreach($entity->fields as $field) {
					
					

					if (ereg("_{$GLOBALS['config']['currentlanguage']}$", $field['name'])) {
						
						$result .= aux::first_comma($id, ", ");
					
						$result .= "{$entity->name}.{$field['name']} AS {$entity->name}_";
						$result .= substr($field['name'], 0, strlen($field['name'])-3);
				
					} else {
			
						switch ($field['type']) {
							case FILE:
								$result .= aux::first_comma($id, ", ");
								$result .= "{$entity->name}.{$field['name']}_filename AS {$entity->name}_{$field['name']}_filename";	
								$result .= aux::first_comma($id, ", ");
								$result .= "{$entity->name}.{$field['name']}_size AS {$entity->name}_{$field['name']}_size";	
								$result .= aux::first_comma($id, ", ");
								$result .= "{$entity->name}.{$field['name']}_type AS {$entity->name}_{$field['name']}_type";	
								break;
					
							default:
								$result .= aux::first_comma($id, ", ");
								$result .= "{$entity->name}.{$field['name']} AS {$entity->name}_{$field['name']}";
								break;
						}
						
						#$result .= "{$entity->name}.{$field['name']} AS {$entity->name}_{$field['name']}";
					}
					
					
					
				}
			}
		}
		
		if (is_array($this->copies)) {
			foreach($this->copies as $copy) {
				$result .= aux::first_comma($id, ", ");
				$result .= "$copy[0] AS $copy[1]";
			}
		}
		
		return $result;
	}
	
	
	
	
	function setOrderFields() {
		$this->order_fields = func_get_args();
	}
	
	function setFilter($filter) {
		$this->condition = $filter;
	}
	
	function setLimit($limit) {
		$this->limit = $limit;
	}
	
	function copy($field_1, $field_2) {
		$this->copies[] = Array($field_1, $field_2);
	}
	
	function setTrigger($name, $value) {
		$this->triggers[] = Array($name, $value);
	}
	
	function propagate($field_1, $field_2 = "") {
		
		if ($field_2 != "") {
			$this->propagate[] = Array($field_1, $field_2);
		} else {
			$this->propagate[] = Array($field_1, $field_1);
		}
	}
	
	function detectCardinality() {
		
		$entity = $GLOBALS['database']->getEntityByName($this->entity_name);
		
		if (array_key_exists($this->getName($entity->fields[0]['name']),$_REQUEST)) {
			$this->mode = SINGLE;
		} else {
			
			for($i=1; $i<count($entity->fields); $i++) {
				
				if (array_key_exists($this->getName($entity->fields[$i]['name']), $_REQUEST)) {
					$filters[] = $this->getName($entity->fields[$i]['name']);
				}
			}
				
			if (is_array($this->join_entities)) {
				$i=0;
				foreach($this->join_entities as $k => $name) {
					$entity = $GLOBALS['database']->getEntityByName($name);
					
					foreach($entity->fields as $field) {
						if (array_key_exists("{$entity->name}_{$field['name']}", $_REQUEST)) {
							$filters[] = $field['name']; 
						}
					}
					$i++;
				}	
			}
			
			if (isset($filters)) {
				if (count($filters) > 0) {
					$this->mode = FILTER;
				} else {
					$this->mode = ALL;
				}
			} else {
				$this->mode = ALL;
			}
		}
	}
	
	function detectOrderFields() {
		
		$entity = $GLOBALS['becontent']->entities[$this->entity_name];
		
		if ($entity->referenceOrder != "") {
			$result[] = $entity->referenceOrder;
			                 
			return $result;
		}
	}
	
	function setStyle($style) {
		$this->style = $style;
	}
		
	function getOrderClause() {
		
		$id = uniqid(time());
		$order_clause = "";
		
		if (count($this->order_fields) > 0) {
			$order_clause .= "ORDER BY ";
			foreach($this->order_fields as $v) {
				
				if (ereg("[[:alnum:]]*\.[[:alnum:]]*", $v)) {
					$order_clause .= aux::first_comma($id, ", ")."{$v}";
				} else {
				
					$order_clause .= aux::first_comma($id, ", ")."{$this->entity_name}.{$v}";
				}
			}
		}
		
		return $order_clause;
	}
	
	function getJoinClause2() {
		
		$entity = $GLOBALS['database']->getEntityByName($this->entity_name);
		
		$fields = $this->getEntityFields();
		$join_clause = "";
		
		if (count($this->join_entities) > 0) {	
			
			foreach($this->join_entities as $name => $name2) {
				
				$entity2 = $GLOBALS['database']->getEntityByName($name2);
				
				$join_clause .= " LEFT JOIN {$entity2->name} ";
				if ($this->join_rules[$name] == "") {
					
					foreach ($entity2->fields as $v) {
						if (isset($v['reference_name'])) {
							if ($v['reference_name'] == $entity2->name) { 
								$foreign_key = $v['name'];
							}
						}
					}
					
					if ($this->join_condition != "") {	
						$join_clause .= "ON {$this->join_condition}";
					} else {
						if ((get_class($entity2) == "relation") or (get_class($entity2) == "Relation")) {
						
							$join_clause .= "ON {$entity->name}.{$entity->fields[0]['name']}={$this->entity_name}.{$entity->fields[0]['name']}";
						
						} else {
				
							$join_clause .= "ON {$entity->name}.{$entity->fields[0]['name']}={$this->entity_name}.{$foreign_key}";
						}
					}
				
				
				} else {
					
					foreach ($this->join_rules[$name]->fields as $v) {
						if ($v['reference_name'] == $entity->name) { 
							$foreign_key = $v['name'];
							
						}
					}
					
					$join_clause .= "ON {$entity->name}.{$entity->fields[0]['name']}={$this->join_rules[$name]->name}.{$foreign_key}"; 
				}
			}
		}
		
		
		return $join_clause;
	}
	
	function getJoinClause() {
		
		$current_entity = $GLOBALS['database']->getEntityByName($this->entity_name);
		
		$fields = $this->getEntityFields();
		$join_clause = "";
		
		if (count($this->join_entities) > 0) {	
			
			foreach($this->join_entities_2 as $name) {
				
				$join_entities[$name][] = true;
				
				if (count($join_entities[$name]) == 1) {
					$postfix = "";
				} else {
					$postfix = "_".count($join_entities[$name]);
				}
				
				$entity = $GLOBALS['database']->getEntityByName($name);
				
				$join_clause .= " LEFT JOIN {$entity->name} ";
				
				if ($postfix != "") {
					$join_clause .= "AS {$entity->name}{$postfix} ";
				}
				
				
				if ($this->join_rules[$name] == "") {
					
					$foreign_key = "";
					
					$count = 0;
					
					foreach ($current_entity->fields as $v) {
						if (isset($v['reference_name'])) {
							if ($v['reference_name'] == $entity->name) {
								
								$count++;
								
								#if ($foreign_key == "") {				
								if ($count == count($join_entities[$name])) {
									$foreign_key = $v['name'];
								}
							}
						}
					}
					
					if ($this->join_condition != "") {	
						$join_clause .= "ON {$this->join_condition}";
					} else {
						if ((get_class($entity) == "relation") or (get_class($entity) == "Relation")) {
						
							$join_clause .= "ON {$entity->name}{$postfix}.{$entity->fields[0]['name']}={$this->entity_name}.{$current_entity->fields[0]['name']}";
						
						} else {
				
							$join_clause .= "ON {$entity->name}{$postfix}.{$entity->fields[0]['name']}={$this->entity_name}.{$foreign_key}";
						}
					}
				
				
				} else {
					
					foreach ($this->join_rules[$name]->fields as $v) {
						if ($v['reference_name'] == $entity->name) { 
							$foreign_key = $v['name'];
							
						}
					}
					
					$join_clause .= "ON {$entity->name}{$postfix}.{$entity->fields[0]['name']}={$this->join_rules[$name]->name}.{$foreign_key}"; 
				}
			}
		}
		
		
		return $join_clause;
	}
	
	function getLimitClause() {
		if ($this->limit) {
			$limit_clause = "LIMIT {$this->limit}";	
		} else {
			$limit_clause = "";
		}
		
		return $limit_clause;
	}
	
	function getWhereClause() {
		
		$where_clause = "";
		$id = uniqid(time());
		
		foreach ($_REQUEST as $k => $v) {
			
			if ($this->isField($k, $token)) {
				
				$where_clause .= aux::first_comma($id, " AND ");
				$where_clause .= "{$token['entity']}.{$token['field']}='{$_REQUEST[$k]}'";
			
			}
		}
		
		
		
		if ($where_clause != "") {
			$where_clause = " WHERE ".$where_clause;
		}
		
		if ($this->condition != "") {
			if ($where_clause != "") {
				$where_clause .= " AND ".$this->condition;
			} else {
				$where_clause = " WHERE ".$this->condition;
			}
			
		}
		
		if (is_array($this->parameters)) {
			
			foreach($this->parameters as $name => $value) {
			
				if ($where_clause != "") {
					$where_clause .= " AND {$name} = '{$value}'";
				} else {
					$where_clause = " WHERE {$name} = '{$value}'";
				}
			}
			
		}
		
		
		
		
		return $where_clause;
	}
	
	function getValue($name) {
		
		
		
		if (isset($this->buffer[0][$name])) {
			return $this->buffer[0][$name];
		} else {
			return false;
		}
		
	}
	
	
	function get($key = "") {
		
		$entity = $GLOBALS['database']->getEntityByName($this->entity_name);
		
		$this->enableParameters();
		$this->detectCardinality();
		
		
		
		$order_clause = $this->getOrderClause();
		$join_clause = $this->getJoinClause();
		$limit_clause = $this->getLimitClause();
		$where_clause = $this->getWhereClause();	
		
		switch ($this->mode) {
			
			case SINGLE:
				$query = "SELECT ".$this->getEntityFields()." 
				                          FROM {$this->entity_name}
				                               {$join_clause}
				                               WHERE {$this->entity_name}.{$entity->fields[0]['name']} = '".$_REQUEST[$this->getName($entity->fields[0]['name'])]."'";
					
				$data = aux::getResult($query);
				
				if ($this->debug) {
					echo "<div class=\"debug\">{$query}</div>";
				}
					
				$this->buffer = $data;	
				/*	echo "SELECT ".$this->getEntityFields()." 
				                          FROM {$this->entity->name}
				                               {$join_clause}
				                               WHERE {$this->entity->name}.{$this->entity->fields[0]['name']} = '".$_REQUEST[$this->getName($this->entity->fields[0]['name'])]."'<hr>SINGLE"; */
				
				break;
			case ALL:
				
				$query = "SELECT ".$this->getEntityFields()." 
				                          FROM {$this->entity_name}
				                               {$join_clause}
				                               {$where_clause}
				                               {$order_clause}
				                               {$limit_clause}";
				
				$data = aux::getResult($query);
				
				
				if ($this->debug) {
					echo "<div class=\"debug\">{$query}</div>";
				}
				 
				break;
			case FILTER:
				
				$query = "SELECT ".$this->getEntityFields()." 
			    	                      FROM {$this->entity_name}
   			        	                       {$join_clause}
   			            	                   {$where_clause}
				            	               {$order_clause}
				                	           {$limit_clause}";
				
				$data = aux::getResult($query);
				
				if ($this->debug) {
					echo "<div class=\"debug\">{$query}</div>";
				}
				
				break;
		}
		
		
		
		
		
		
		
		
		
		
		if ($this->template) { 
			$template = new Template("skins/{$GLOBALS['config']['skin']}/dtml/{$this->template}.html");
		} else {
			if ($this->template_alt) {
				switch($this->template_alt['expr']) {
					case ISNOTEMPTY:
						if ($data[0][$this->template_alt['field']] != "") {
							$template = new Template("skins/{$GLOBALS['config']['skin']}/dtml/{$this->template_alt['true']}.html");
						} else {
							$template = new Template("skins/{$GLOBALS['config']['skin']}/dtml/{$this->template_alt['false']}.html");
						}
						break;
				}
			} else {
				switch($this->mode) {
					case SINGLE:
						$template = new Template("skins/{$GLOBALS['config']['skin']}/dtml/{$this->template_single}.html");
						break;
					case ALL:
					case FILTER:
						$template = new Template("skins/{$GLOBALS['config']['skin']}/dtml/{$this->template_multiple}.html");
						
						break;
				}
			}
		}
		
		
		switch ($this->style) {
			case NORMAL:
				
				if (is_array($data)) {
					
					foreach ($data as $index => $item) {
						
						foreach($item as $k => $v) {
							
							do {
								$result = ereg("\[([[:alnum:]]*)\.([[:alnum:]]*)\]", $data[$index][$k], $token);
								
								if ($result) {
							
									switch ($token[1]) {
										case "user":
											$value = $_SESSION['user'][$token[2]];
											$data[$index][$k] = ereg_replace("\[user\.{$token[2]}\]", $value, $data[$index][$k]);
											break;
										case "homepage":
											
											$data2 = aux::getResult("SELECT * 
										  	                           FROM {$token[1]} 
												                   ORDER BY position
												                      LIMIT 1");
											
											switch ($token[2]) {
												case "edit":
												
													$value = "home-manager.php?action=edit&page=1&value={$data2[0]['id']}";
													break;
												case "add":
													$value = "home-manager.php?action=add";
													break;
											}
											$data[$index][$k] = ereg_replace("\[{$token[1]}\.{$token[2]}\]", $value, $data[$index][$k]);
											
											break;
									}
								}
							} while ($result);
							
							
							
							$template->setContent($k, $data[$index][$k]);
						}
					}
				} 
			break;
			case HIERARCHICAL:
				
				
				if (is_array($data)) {
					
					if (!$this->presentation) {
						foreach($data[0] as $k => $v) {
							$this->presentation[] = $k; 
						}
					} 
					
					$entity = $GLOBALS['database']->getEntityByName($this->entity_name);
					
					foreach($entity->fields as $k => $v) {
						if ($v['localtype'] == "reference") {
							$index[] = $k;
						}
					}
					
					$entity_name = $entity->fields[$index[0]]['entity'];
					
					foreach($this->presentation as $k => $v) {
						
						if (ereg("{$entity->fields[$index[0]]['entity']}_", $v)) {
							$index2[] = $k;
						}
					}
					
					$field = $this->presentation[$index2[0]];
					
					foreach ($data as $item) {
						foreach($this->presentation as $v) {
							
							if ($v == $field) {
								if ($change[$field] != $item[$field]) {
								
									$template->setContent($v, $item[$v]);
									$change[$v] = $item[$v];
								}
							} else {
								$template->setContent($v, $item[$v]);
							}

							
						}
					}
					
					/* foreach ($data as $item) {
						foreach($this->presentation as $v) {
							
							if ($change[$v] != $item[$v]) {
								
								$template->setContent($v, $item[$v]);
								$change[$v] = $item[$v];
							}
						}
					} */
					
				}
			break;
		}
		
		if (is_array($this->values)) {
			foreach($this->values as $k => $v) {
				
				$template->setContent($k,$v);
			}
		}
		

		
		if (is_array($this->propagate)) {
			foreach ($this->propagate as $propagate) {		
				$_REQUEST[$propagate[1]] = $data[0][$propagate[0]];	
			}
		}
		
		$this->disableParameters();
		
		return $template->get();
		
	}
	
	function getPager($length = 10) {
		
		$entity = $GLOBALS['database']->getEntityByName($this->entity_name);
		
		$this->enableParameters();
		$this->detectCardinality();
		
		
		
		$order_clause = $this->getOrderClause();
		$join_clause = $this->getJoinClause();
		$limit_clause = $this->getLimitClause();
		$where_clause = $this->getWhereClause();	
		
		switch ($this->mode) {
			
			case SINGLE:
						
				$data = aux::getResult(
					"SELECT ".$this->getEntityFields()." 
				                          FROM {$this->entity_name}
				                               {$join_clause}
				                               WHERE {$this->entity_name}.{$entity->fields[0]['name']} = '".$_REQUEST[$this->getName($entity->fields[0]['name'])]."'");
					
				
				
				break;
			
			case ALL:
			case FILTER:
				
				
				
				$data = aux::getResult("SELECT ".$this->getEntityFields()." 
				                          FROM {$this->entity_name}
				                               {$join_clause}
				                               {$where_clause}
				                               {$order_clause}
				                               {$limit_clause}");
				
				
				
				break;
			
		}
		



		$params = array(
	    	'itemData' => $data,
	    	'perPage' => $length,
	    	'delta' => 2,             // for 'Jumping'-style a lower number is better
	    	'append' => true,
	    	//'separator' => ' | ',
	    	'clearIfVoid' => false,
	    	'urlVar' => 'entrant',
	    	'useSessions' => true,
	    	'closeSession' => true,
	    	'mode'  => 'Sliding',    //try switching modes
	    	//'mode'  => 'Jumping',
	
		);


	
		$pager = & Pager::factory($params); 
		$page_data = $pager->getPageData(); 
		$links = $pager->getLinks();
	
		$selectBox = $pager->getPerPageSelectBox();
				
		if ($this->template) { 
			$template = new Template("skins/{$GLOBALS['config']['skin']}/dtml/{$this->template}.html");
		} else {
			if ($this->template_alt) {
				switch($this->template_alt['expr']) {
					case ISNOTEMPTY:
						if ($data[0][$this->template_alt['field']] != "") {
							$template = new Template("skins/{$GLOBALS['config']['skin']}/dtml/{$this->template_alt['true']}.html");
						} else {
							$template = new Template("skins/{$GLOBALS['config']['skin']}/dtml/{$this->template_alt['false']}.html");
						}
						break;
				}
			} else {
				switch($this->mode) {
					case SINGLE:
						$template = new Template("skins/{$GLOBALS['config']['skin']}/dtml/{$this->template_single}.html");
						break;
					case ALL:
					case FILTER:
						$template = new Template("skins/{$GLOBALS['config']['skin']}/dtml/{$this->template_multiple}.html");
						
						break;
				}
			}
		}
			
		$template->setContent("pager", "<div class=\"pager\">{$links['all']}</div>");
		
		$items = $pager->getPageData();
					
		if (is_array($items)) {
			
			foreach ($items as $index => $item) {
				
				foreach($item as $k => $v) {
					
					do {
						$result = ereg("\[([[:alnum:]]*)\.([[:alnum:]]*)\]", $data[$index][$k], $token);
						
						if ($result) {
					
							switch ($token[1]) {
								case "user":
									$value = $_SESSION['user'][$token[2]];
									$data[$index][$k] = ereg_replace("\[user\.{$token[2]}\]", $value, $data[$index][$k]);
									break;
								case "homepage":
									
									$data2 = aux::getResult("SELECT * 
								  	                           FROM {$token[1]} 
										                   ORDER BY position
										                      LIMIT 1");
									
									switch ($token[2]) {
										case "edit":
										
											$value = "home-manager.php?action=edit&page=1&value={$data2[0]['id']}";
											break;
										case "add":
											$value = "home-manager.php?action=add";
											break;
									}
									$data[$index][$k] = ereg_replace("\[{$token[1]}\.{$token[2]}\]", $value, $data[$index][$k]);
									
									break;
							}
						}
					} while ($result);
					
					$template->setContent($k, $data[$index][$k]);
				}
			}
		} 
	
			
		if (is_array($this->values)) {
			foreach($this->values as $k => $v) {
					
				$template->setContent($k,$v);
			}	
		}
		

		
		if (is_array($this->propagate)) {
			foreach ($this->propagate as $propagate) {		
				$_REQUEST[$propagate[1]] = $data[0][$propagate[0]];	
			}
		}
		
		$this->disableParameters();
		
		return $template->get();
		
	}
	
	function cleanField($field) {
		
		ereg("([[:alnum:]\_]*)\_([[:alnum:]]*)$", $field, $token);
				
		$result['table'] = $token[1];
		$result['field'] = $token[2];
		
		return $result;
	}
	
	
	function cleanField2($field) {
		
		ereg("^([[:alnum:]]*)\_([[:alnum:]]*)$", $field, $token);
		
		#return substr($field, strlen($this->entity->name) + 1);
		return $token[2];
	}
	
	function isField($field, &$token) {
		
		$entity = $GLOBALS['database']->getEntityByName($this->entity_name);
		
		$field2 = substr($field, strlen($this->entity_name) + 1);
		$trovato = false;
		
		foreach ($entity->fields as $k => $v) {
			
			if (($this->getName($v['name']) == $field)) {
				$trovato = true;
				$element = $this->cleanField($field);
				$token['entity'] = $element['table'];
				$token['field'] = $element['field'];
				
			}
		}
		
		if (!$trovato) {
			if (is_array($this->join_entities)) {
				
				foreach($this->join_entities as $name) {
					
					$entity = $GLOBALS['database']->getEntityByName($name);
					
					foreach($entity->fields as $f) {
						
						if ("{$entity->name}_{$f['name']}" == $field) {

							$trovato = true;
							$token['entity'] = $entity->name;
							$token['field'] = $f['name'];
							
						}
					}
				}
			}
		}
		
		return $trovato;
	}
	
	function getIndexed() {
		$this->enableParameters();
		
		if (!$this->template) {
			
			echo "Warning: you need to specify a template for the indexed mode in {$this->entity_name} content.";
			exit;
			
		} 
		
		$template = new Template("skins/{$GLOBALS['config']['skin']}/dtml/{$this->template}.html");
		
		$id = uniqid(time());
		$order_clause = $this->getOrderClause();
		$join_clause = $this->getJoinClause();
		$where_clause = $this->getWhereClause();
		$limit_clause = $this->getLimitClause();
		
		$fields = $this->getEntityFields();
				
		$data = aux::getResult("SELECT ".$this->getEntityFields()." 
				                  FROM {$this->entity_name}
				                  {$join_clause}
				                  {$where_clause}
				                  {$order_clause}
				                  {$limit_clause}");

		
		
		$index = 0;
		if (is_array($data)) {
			foreach ($data as $item) {
				$index++;
				foreach($item as $k => $v) {
					$template->setContent("{$k}_{$index}", $v);	
				}
			}
		}
		
		
		$template->setContent("skin", $GLOBALS['config']['skin']);
		
		if (is_array($this->values)) {
			foreach($this->values as $k => $v) {
				
				$template->setContent($k,$v);
			}
		}
		
		$this->disableParameters();
		return $template->get();
		
	}
	
	function apply(&$skin, $prefix = "") {
		
		$entity = $GLOBALS['database']->getEntityByName($this->entity_name);
		
		if ($prefix != "") {
			$prefix .= "_";
		}
		
		$data = $this->getRaw();
		
		if (is_array($data)) {
			foreach($data as $item) {
			
				if (is_array($this->triggers)) {
				
				
					if ($_REQUEST["{$this->entity_name}_{$entity->fields[0]['name']}"] == $item["{$this->entity_name}_{$entity->fields[0]['name']}"]) {
						$skin->setContent($this->triggers[0][0], $this->triggers[0][1]);
					} else {
						$skin->setContent($this->triggers[0][0], "");
					}				
				}
			
				
				foreach($item as $k => $v) {
					$skin->setContent("{$prefix}{$k}",$v);
				}
				
			}
		}		
		
		if (is_array($this->propagate)) {
			foreach ($this->propagate as $propagate) {		
				$_REQUEST[$propagate[1]] = $data[0][$propagate[0]];	
			}
		}
		
	}
	
	function applyIndexed(&$skin) {
		
		$entity = $GLOBALS['database']->getEntityByName($this->entity_name);
		
		$data = $this->getRaw();
		
		$index = 0;
		if (is_array($data)) {
			foreach($data as $item) {
				$index++;
				foreach($item as $k => $v) {
					$skin->setContent("{$k}_{$index}",$v);
				}
			}
		}
	}
		
		 
	
	function applyItem(&$skin, $key, $prefix = "") {
		
		if ($prefix != "") {
			$prefix .= "_";
		}
		
		$data = $this->getRaw($key);
		
		foreach($data as $k => $v) {
			$skin->setContent("{$prefix}{$k}",$v);
		}
		
		if (is_array($this->propagatepropagate)) {
			foreach ($this->propagate as $propagate) {
				$_REQUEST[$propagate[1]] = $data[0][$propagate[0]];	
			}
		}
	}
	
	
	function getRaw($key = "") {
	
		$entity = $GLOBALS['database']->getEntityByName($this->entity_name);
		
		$this->enableParameters();
		
		if (isset($this->cache[$key])) {
			$result = $this->cache[$key];
		} else {
		
			$join_clause = $this->getJoinClause();
	
		
			if ($key != "") {
				$data = aux::getResult("SELECT ".$this->getEntityFields()." 
									      FROM {$this->entity_name} 
									           {$join_clause}
				        	             WHERE {$this->entity_name}.{$entity->fields[0]['name']} = '{$key}'");
				$result = $data[0];
				
			} else {
			
				
				$order_clause = $this->getOrderClause();
				$limit_clause = $this->getLimitClause();
				$where_clause = $this->getWhereClause();
				$join_clause = $this->getJoinClause();
				
				
				$data = aux::getResult("SELECT ".$this->getEntityFields()."
									  	  FROM {$this->entity_name}
									  	       {$join_clause}
									  	       {$where_clause}
									  	       {$order_clause}
									  	       {$limit_clause}");
				
				$result = $data;
			}
			
			#$this->cache[$key] = $result;
			
		}
		
		$this->disableParameters();
		
		return $result;
		
		
	}
	
	function getFieldRaw($key, $field) {
		
		$entity = $GLOBALS['database']->getEntityByName($this->entity_name);
		
		if ($this->limit) {
			$limit_clause = "LIMIT {$this->limit}";	
		} else {
			$limit_clause = "";
		}
		
		$data = aux::getResult("SELECT ".$this->getEntityFields()."
								  FROM {$this->entity_name} 
				                 WHERE {$this->entity_name}.{$entity->fields[0]['name']} = '{$key}'
				                 {$limit_clause}");
		
		return $data[0][$this->getName($field)];
		
	}
		
}



?>