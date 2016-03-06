<?php
/*
==============================================================
PBMicro v 1.0
Simple PHP Framework in one file
==============================================================
*/

/* Traits */
trait AnyCall
{
	private $__anycall_conditions = [];
	
	public function __call($name, $args)
	{
		if ($this->__anycall_conditions && !in_array($name, ['if', 'elseif', 'else', 'endif']) && !end($this->__anycall_conditions))
			return $this;
		
		$name = 'anycall_' . $name;
		if (method_exists($this, $name))
			return call_user_func_array([$this, $name], $args);
		else
			Error::create('Unknown method call: ' . get_called_class() . '::' . $name . '() from ' . __CLASS__);
	}
	
	static public function __callStatic($name, $args)
	{
		$class = static::instance();
		$name = 'anycall_' . $name;
		if (method_exists($class, $name))
			return call_user_func_array([$class, $name], $args);
		else
			Error::create('Unknown method call: ' . get_called_class() . '::' . $name . '() from ' . __CLASS__);
	}
	
	private function anycall_if($cond)
	{
		array_push($this->__anycall_conditions, $cond);
		return $this;
	}
	
	private function anycall_elseif($cond)
	{
		array_pop($this->__anycall_conditions);
		array_push($this->__anycall_conditions, $cond);
		return $this;
	}
	
	private function anycall_else()
	{
		array_push($this->__anycall_conditions, !array_pop($this->__anycall_conditions));
		return $this;
	}
	
	private function anycall_endif()
	{
		array_pop($this->__anycall_conditions);
		return $this;
	}
}

trait Multiple
{
	protected function __construct() {}
	protected function __clone() {}
	
	static public function instance()
	{
		$class_name = get_called_class();
        $instance = new $class_name();
		if (method_exists($instance, 'init'))
			call_user_func_array(array($instance, 'init'), func_get_args());
		return $instance;
    }
}

trait Single
{
	static private $instances = array();
	
	protected function __construct() {}
	protected function __clone() {}
	
	static public function instance()
	{
		$class_name = get_called_class();
        if (!isset(self::$instances[$class_name]))
		{
			self::$instances[$class_name] = new $class_name();
			if (method_exists(self::$instances[$class_name], 'init'))
				call_user_func_array(array(self::$instances[$class_name], 'init'), func_get_args());
		}
		return self::$instances[$class_name];
    }
}

/* Basic Classes */
abstract class BasicClass {}

abstract class Model extends BasicClass {}

abstract class SingleModel extends Model { use Single; }

abstract class MultipleModel extends Model { use Multiple; }

abstract class Controller { use Multiple; }

/* Core Classes */
class Error
{
	static public function create($error)
	{
		switch ($error)
		{
			case 404:
				header('HTTP/1.1 404 Not Found');
				echo "404 Not Found";
				break;
			default:
				echo $error;
				break;
		}
		exit;
	}
}

final class Router
{
	static $routes = [];
	
	static public function map($methods, $url, $options, $callback)
	{
		$names = [];
		preg_match_all('/\{(.*)\}/U', $url, $matches, PREG_PATTERN_ORDER);
		$matches = $matches[1];
		if ($matches)
		{
			$reg = preg_quote($url, '/');
			array_map(function ($this) use (&$names, &$reg, $options, &$reg) {
				$names[] = $this;
				$rule = (isset($options['rules'][$this]) ? $options['rules'][$this] : '[^\/]*');
				$reg = str_replace('\{' . $this . '\}', '(' . $rule . ')', $reg);
				$reg = str_replace('\(', '(|', $reg);
				$reg = str_replace('\)', ')', $reg);
			}, $matches);
			$reg = '/^' . $reg . '$/';
		}
		else
			$reg = '/^' . preg_quote($url, '/') . '$/';
		self::$routes[] = (object)[
			'methods'=>$methods,
			'url'=>$url,
			'reg'=>$reg,
			'names'=>$names,
			'options'=>$options,
			'callback'=>$callback
		];
	}
	
	static public function find($url)
	{
		if (($pos = strpos($url, '?')) !== false)
			$url = substr($url, 0, $pos);
		$method = strtolower($_SERVER['REQUEST_METHOD']);
		foreach (self::$routes as $route)
		{
			if ((is_array($route->methods) && (!in_array($method, $route->methods))) ||
				(!is_array($route->methods) && ($route->methods != 'any') && ($route->methods != $method))) continue;
			if (preg_match($route->reg, $url, $matches))
			{
				$matches_new = [];
				foreach ($matches as $k=>$match)
					if (strpos($match, '/') === false)
						$matches_new[] = $match;
				$matches = $matches_new;
				
				$request = [];
				foreach ($matches as $k=>$match)
				{
					$request[$route->names[$k]] = $match;
				}
				$found_route = $route;
				break;
			}
		}
		if (isset($found_route))
		{
			if (is_callable($found_route->callback))
			{
				$function = $found_route->callback;
				$function((object)$request);
			}
			else
			{
				list($action, $class) = explode('@', $found_route->callback);
				$instance = $class::instance();
				$action = 'action_' . $action;
				$instance->$action((object)$request);
			}
		}
		else
			Error::create(404);
	}
	
	static public function url($alias, $values = [])
	{
		foreach (self::$routes as $route)
		{
			if (isset($route->options['as']) && ($route->options['as'] == $alias))
			{
				$url = $route->url;
				array_walk($values, function($value, $key) use (&$url) {
					$url = str_replace('{' . $key . '}', $value, $url);
				});
				return $url;
			}
		}
		return false;
	}
	
	static public function redirect($url)
	{
		header('Location: ' . $url);
		exit;
	}
	
	static public function back()
	{
		self::redirect($_SERVER['HTTP_REFERER']);
		exit;
	}
}

class Config extends SingleModel
{
	use AnyCall;
	
	private $data;
	private $section;
	
	private function anycall_section($section)
	{
		$this->section = $section;
		return $this;
	}
	
	private function anycall_get($key)
	{
		return $this->data[$this->section][$key];
	}
	
	private function anycall_set($key, $value)
	{
		$this->data[$this->section][$key] = $value;
		return $this;
	}
}

final class Application extends SingleModel
{
	use AnyCall;
	
	private $bound = [];
	private $include_paths_set = false;
	
	private function anycall_run()
	{
		Router::find($_SERVER['REQUEST_URI']);
		return $this;
	}
	
	private function anycall_configure($files)
	{
		foreach ($files as $file)
			include_once($file);
		return $this;
	}
	
	private function anycall_bind($class, $alias)
	{
		$this->bound[$alias] = $class::instance();
		return $this;
	}
	
	private function anycall_autoload($class)
	{
		if (!$this->include_paths_set)
		{
			set_include_path(implode(PATH_SEPARATOR, Config::section('main')->get('include_paths')));
			$this->include_paths_set = true;
		}
		return require_once($class . '.php');
	}
	
	public function __get($class)
	{
		return $this->bound[$class];
	}
}

/* Model Classes */
class Db extends SingleModel
{
	private $pdo;
	private $affected;
	
	public function init()
	{
		Config::section('database');
		$dsn = Config::get('type') . ":host=" . Config::get('host') . ";dbname=" . Config::get('name') . ";charset=" . Config::get('charset');
		$opt = array(
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
		);
		$this->pdo = new PDO($dsn, Config::get('user'), Config::get('password'), $opt);
	}
	
	public function query($query, $values = [], $on_prepare = null)
	{
		$stm = $this->pdo->prepare($query);
		if (is_callable($on_prepare))
			$on_prepare($stm);
		foreach ($values as $name=>$value)
			$stm->bindValue(":$name", $value, PDO::PARAM_STR);
		$stm->execute();
		$this->affected = $stm->rowCount();
		return $stm;
	}
	
	public function insert_id() { return $this->pdo->lastInsertId(); }
	public function affected() { return $this->affected; }
	public function raw() { return $this->pdo; }
}

class DataModel extends MultipleModel implements Iterator
{
	use AnyCall;
	
	private $db;
	private $data;
	private $data_primary;
	private $data_result;
	private $query;
	private $values;
	
	/* Select */
	private $select;
	private $where;
	private $where_operator;
	private $need = '';
	private $order;
	private $skip;
	private $take;
	
	private $opened_wheres;
	private $clamped_where = '';
	private $clamped_values = [];
	private $clamp_used;
	
	protected $_table;
	protected $_primary = 'id';
	protected $_autofill = [];
	
	public function init($data = null)
	{
		$this->db = Application::instance()->db;
		if ($data)
		{
			$this->data = $data;
			$this->data_primary = $data->{$this->_primary};
		}
		$this->init_query_parameters();
	}
	
	private function anycall_create($data = [])
	{
		if (!isset($this->data)) $this->data = new StdClass;
		foreach ($data as $field=>$value)
			if (in_array($field, $this->_autofill))
				$this->data->$field = $value;
		return $this;
	}
	
	private function init_query_parameters()
	{
		$this->data_result = [];
		$this->values = ($this->clamped_values ?: []);
		
		$this->select = '*';
		$this->where = ($this->clamped_where ?: '');
		$this->where_operator = 'AND';
		$this->order = [];
		$this->skip = 0;
		$this->take = 0;
		$this->opened_wheres = 0;
		$this->clamp_used = false;
	}
	
	private function make_placeholder($name)
	{
		$orig_name = $name;
		$index = 1;
		while (isset($this->values[$name]))
		{
			$name = $orig_name . '_' . $index;
			$index++;
		}
		return $name;
	}
	
	public function get_primary()
	{
		return $this->_primary;
	}
	
	public function anycall_exists()
	{
		return isset($this->data);
	}
	
	/* Queries */
	private function clamp()
	{
		$this->clamped_where = $this->where;
		$this->clamped_values = $this->values;
		return $this;
	}
	
	public function __get($field)
	{
		return $this->data->$field;
	}
	
	public function __set($field, $value)
	{
		return $this->data->$field = $value;
	}
	
	private function anycall_count()
	{
		$this->select = 'COUNT(*)';
		$query = $this->compile_get();
		$result = $this->db->query($query, $this->values);
		$this->select = '*';
		return $result->fetchColumn();
	}
	
	private function anycall_find($id)
	{
		$result = $this->db->query("SELECT * FROM {$this->_table} WHERE {$this->_primary}=:id", ['id'=>$id]);
		return self::instance($result->fetch());
	}
	
	private function anycall_all()
	{
		$result = $this->db->query("SELECT * FROM {$this->_table}");
		$rows = [];
		foreach ($result as $row)
			$rows[] = self::instance($row);
		return $rows;
	}
	
	private function anycall_delete()
	{
		if (isset($this->data_primary))
		{
			$this->db->query("DELETE FROM {$this->_table} WHERE {$this->_primary}=:id", ['id'=>$this->data_primary]);
		}
	}
	
	private function anycall_or()
	{
		$this->where_operator = 'OR';
		return $this;
	}
	
	private function anycall_where($p1, $p2 = null, $p3 = null)
	{
		if (!$this->clamp_used && $this->clamped_where)
		{
			$this->where = $this->clamped_where;
			$this->where_open();
			$this->clamp_used = true;
		}
		if (is_null($p2))
		{
			$this->where .= ($this->where ? " {$this->where_operator} " : " WHERE ") . $p1;
		}
		elseif (is_null($p3))
		{
			$this->values[$ph = $this->make_placeholder($p1)] = $p2;
			$this->where .= ($this->where ? " {$this->where_operator} " : " WHERE ") . "$p1=:$ph";
		}
		else
		{
			if (is_array($p3))
			{
				$p3_new = [];
				foreach ($p3 as $p)
				{
					$this->values[$ph = $this->make_placeholder($p1)] = $p;
					$p3_new[] = ":$ph";
				}
				$p3 = "(" . implode(", ", $p3_new) . ")";
			}
			else
			{
				$this->values[$ph = $this->make_placeholder($p1)] = $p3;
				$p3 = ":$ph";
			}
			$this->where .= ($this->where ? " {$this->where_operator} " : " WHERE ") . "$p1 $p2 $p3";
		}
		$this->where_operator = 'AND';
		return $this;
	}
	
	private function anycall_need($p1, $p2 = null, $p3 = null)
	{
		if (is_null($p2))
		{
			$this->need .= ($this->need ? " {$this->where_operator} " : " ") . $p1;
		}
		elseif (is_null($p3))
		{
			$this->values[$ph = $this->make_placeholder($p1)] = $p2;
			$this->need .= ($this->need ? " {$this->where_operator} " : " ") . "$p1=:$ph";
		}
		else
		{
			if (is_array($p3))
			{
				$p3_new = [];
				foreach ($p3 as $p)
				{
					$this->values[$ph = $this->make_placeholder($p1)] = $p;
					$p3_new[] = ":$ph";
				}
				$p3 = "(" . implode(", ", $p3_new) . ")";
			}
			else
			{
				$this->values[$ph = $this->make_placeholder($p1)] = $p3;
				$p3 = ":$ph";
			}
			$this->need .= ($this->need ? " {$this->where_operator} " : " ") . "$p1 $p2 $p3";
		}
		$this->where_operator = 'AND';
		return $this;
	}
	
	private function anycall_where_open()
	{
		$this->where .= ($this->where ? " {$this->where_operator} " : " WHERE ") . "(";
		$this->opened_wheres++;
		$this->where_operator = '';
		return $this;
	}
	
	private function anycall_where_close()
	{
		$this->where .= ")";
		$this->opened_wheres--;
		return $this;
	}
	
	private function anycall_order($order) { $this->order = $order; return $this; }
	private function anycall_skip($skip) { $this->skip = $skip; return $this; }
	private function anycall_take($take) { $this->take = $take; return $this; }
	
	private function query()
	{
		if ($this->skip && $this->take)
		{
			$placeholder_skip = $this->make_placeholder('skip');
			$placeholder_take = $this->make_placeholder('take');
			$this->query .= " LIMIT :$placeholder_skip, :$placeholder_take";
			$on_prepare = function ($stm) use ($placeholder_skip, $placeholder_take) {
				$stm->bindValue($placeholder_skip, $this->skip, PDO::PARAM_INT);
				$stm->bindValue($placeholder_take, $this->take, PDO::PARAM_INT);
			};
		}
		elseif ($this->take)
		{
			$placeholder_take = $this->make_placeholder('take');
			$this->query .= " LIMIT :$placeholder_take";
			$on_prepare = function ($stm) use ($placeholder_take) {
				$stm->bindValue($placeholder_take, $this->take, PDO::PARAM_INT);
			};
		}
		else
			$on_prepare = null;
		$result = $this->db->query($this->query, $this->values, $on_prepare);
		$this->init_query_parameters();
		return $result;
	}
	
	private function anycall_get_values()
	{
		return $this->values;
	}
	
	private function compile_get()
	{
		$where = $this->where;
		if ($this->opened_wheres)
			$where .= str_repeat(")", $this->opened_wheres);
		$query = "SELECT {$this->select} FROM {$this->_table} {$where}";
		if ($this->order)
		{
			$query .= " ORDER BY ";
			$order = [];
			foreach ($this->order as $field=>$dir)
				$order[] = " $field $dir ";
			$query .= implode(", ", $order);
		}
		return $query;
	}
	
	private function anycall_get()
	{
		$this->query = $this->compile_get();
		$result = $this->query();
		$rows = [];
		foreach ($result as $row)
			$rows[] = self::instance($row);
		return $rows;
	}
	
	private function anycall_first()
	{
		$this->query = $this->compile_get();
		$result = $this->query();
		return self::instance($result->fetch());
	}
	
	private function array_to_seq($array)
	{
		$seq = [];
		foreach ($array as $field=>$value)
		{
			$this->values[$ph = $this->make_placeholder($field)] = $value;
			$seq[] = "$field=:$ph";
		}
		return implode(", ", $seq);
	}
	
	private function compile_save()
	{
		if (isset($this->data_primary)) //UPDATE
		{
			$this->values[$ph = $this->make_placeholder('primary')] = $this->data_primary;
			$need = ($this->need ? " AND ({$this->need}) " : "");
			$query = "UPDATE {$this->_table} SET " . $this->array_to_seq($this->data) . " WHERE {$this->_primary}=:$ph $need";
		}
		else //INSERT
		{
			$this->values = [];
			if ($this->clamped_values)
				foreach ($this->clamped_values as $field=>$value)
					$this->data->$field = $value;
			$query = "INSERT INTO {$this->_table} SET " . $this->array_to_seq($this->data);
		}
		return $query;
	}
	
	private function anycall_save()
	{
		$this->query = $this->compile_save();
		$this->query();
		$this->data->{$this->_primary} = $this->data_primary = (isset($this->data_primary) ? $this->data->{$this->_primary} : $this->db->insert_id());
		$this->need = '';
		return $this->db->affected();
	}
	
	/* Relations */
	public function has_many($model, $outward_field = null, $inward_field = null)
	{
		if (!isset($this->data)) return false;
		$model_instance = $model::instance();
		if (!$inward_field)
			$inward_field = $this->get_primary();
		if (!$outward_field)
		{
			$segments = explode('\\', get_called_class());
			$outward_field = lcfirst(end($segments)) . '_id';
		}
		return $model_instance->where($outward_field, $this->data->$inward_field)->clamp();
	}
	
	public function belongs_to($model, $inward_field = null, $outward_field = null)
	{
		if (!isset($this->data)) return false;
		$model_instance = $model::instance();
		if (!$inward_field)
		{
			$segments = explode('\\', $model);
			$inward_field = lcfirst(end($segments)) . '_id';
		}
		if (!$outward_field)
			$outward_field = $model_instance->get_primary();
		return $model_instance->where($outward_field, $this->data->$inward_field)->first();
	}
	
	private function prepare_data_result()
	{
		if ($this->data_result) return false;
		
		$this->query = $this->compile_get();
		$result = $this->query();
		foreach ($result as $row)
			$this->data_result[] = self::instance($row);
	}
	
	/* Iterator */
	public function rewind()
    {
		$this->prepare_data_result();
        reset($this->data_result);
    }
  
    public function current()
    {
		$this->prepare_data_result();
        return current($this->data_result);
    }
  
    public function key() 
    {
		$this->prepare_data_result();
        return key($this->data_result);
    }
  
    public function next() 
    {
		$this->prepare_data_result();
        return next($this->data_result);
    }
  
    public function valid()
    {
		$this->prepare_data_result();
        return (isset($this->data_result[key($this->data_result)]));
    }
}

/* View Classes */
class TemplateView
{
	use Single;
	use AnyCall;
	
	private $vars;
	private $save_to;
	private $template;
	private $content;
	
	private function include_template($template, $save_to = null)
	{
		foreach ($this->vars as $var=>$value)
			$$var = $value;
		
		ob_start();
		include 'app/themes/' . Config::section('main')->get('theme') . '/' . $template . '.php';
		$this->content = ob_get_clean();
		if (isset($save_to))
			$this->vars[$save_to] = $this->content;
	}
	
	private function anycall_template($template)
	{
		$this->vars = [];
		$this->save_to = [];
		$this->template = $template;
		return $this;
	}
	
	private function anycall_bind($var, $value = null)
	{
		if (is_array($var))
			foreach ($var as $k=>$v)
				$this->vars[$k] = $v;
		else
			$this->vars[$var] = $value;
		return $this;
	}
	
	private function anycall_compile()
	{
		$this->content = '';
		if (is_array($this->template))
			foreach ($this->template as $k=>$t)
				$this->include_template($t, $k);
		else
			$this->include_template($this->template);
		return $this;
	}
	
	private function anycall_fetch()
	{
		return $this->content;
	}
	
	private function anycall_display()
	{
		echo $this->content;
	}
}

error_reporting(E_ALL | E_STRICT);

function __autoload($class)
{
	Application::autoload($class);
}

$app = Application::instance();