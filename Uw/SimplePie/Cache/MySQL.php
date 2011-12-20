<?php

class SimplePie_Cache_MySQL extends SimplePie_Cache_DB
{

    var $mysql;
    var $options;
    var $id;

    function SimplePie_Cache_MySQL($mysql_location, $name, $extension)
    {
        $host = $mysql_location->get_host();
        if (SimplePie_Misc::stripos($host, 'unix(') === 0 && substr($host, -1) === ')') {
            $server = ':' . substr($host, 5, -1);
        } else {
            $server = $host;
            if ($mysql_location->get_port() !== null) {
                $server .= ':' . $mysql_location->get_port();
            }
        }

        if (strpos($mysql_location->get_userinfo(), ':') !== false) {
            list($username, $password) = explode(':', $mysql_location->get_userinfo(), 2);
        } else {
            $username = $mysql_location->get_userinfo();
            $password = null;
        }

        if ($this->mysql = mysql_connect($server, $username, $password)) {
            $this->id = $name . $extension;
            $this->options = SimplePie_Misc::parse_str($mysql_location->get_query());
            if (!isset($this->options['prefix'][0])) {
                $this->options['prefix'][0] = '';
            }

            if (mysql_select_db(ltrim($mysql_location->get_path(), '/'))
                && mysql_query('SET NAMES utf8')
                && ($query = mysql_unbuffered_query('SHOW TABLES'))) {
                $db = array();
                while ($row = mysql_fetch_row($query)) {
                    $db[] = $row[0];
                }

                if (!in_array($this->options['prefix'][0] . 'cache_data', $db)) {
                    if (!mysql_query('CREATE TABLE `' . $this->options['prefix'][0] . 'cache_data` (`id` TEXT CHARACTER SET utf8 NOT NULL, `items` SMALLINT NOT NULL DEFAULT 0, `data` BLOB NOT NULL, `mtime` INT UNSIGNED NOT NULL, UNIQUE (`id`(125)))')) {
                        $this->mysql = null;
                    }
                }

                if (!in_array($this->options['prefix'][0] . 'items', $db)) {
                    if (!mysql_query('CREATE TABLE `' . $this->options['prefix'][0] . 'items` (`feed_id` TEXT CHARACTER SET utf8 NOT NULL, `id` TEXT CHARACTER SET utf8 NOT NULL, `data` TEXT CHARACTER SET utf8 NOT NULL, `posted` INT UNSIGNED NOT NULL, INDEX `feed_id` (`feed_id`(125)))')) {
                        $this->mysql = null;
                    }
                }
            } else {
                $this->mysql = null;
            }
        }

    }

    function save($data)
    {
        if ($this->mysql) {
            $feed_id = "'" . mysql_real_escape_string($this->id) . "'";

            if (is_a($data, 'SimplePie')) {
                if (SIMPLEPIE_PHP5) {
                    // This keyword needs to defy coding standards for PHP4 compatibility
                    $data = clone($data);
                }

                $prepared = $this->prepare_simplepie_object_for_cache($data);

                if ($query = mysql_query('SELECT `id` FROM `' . $this->options['prefix'][0] . 'cache_data` WHERE `id` = ' . $feed_id, $this->mysql)) {
                    if (mysql_num_rows($query)) {
                        $items = count($prepared[1]);
                        if ($items) {
                            $sql = 'UPDATE `' . $this->options['prefix'][0] . 'cache_data` SET `items` = ' . $items . ', `data` = \'' . mysql_real_escape_string($prepared[0]) . '\', `mtime` = ' . time() . ' WHERE `id` = ' . $feed_id;
                        } else {
                            $sql = 'UPDATE `' . $this->options['prefix'][0] . 'cache_data` SET `data` = \'' . mysql_real_escape_string($prepared[0]) . '\', `mtime` = ' . time() . ' WHERE `id` = ' . $feed_id;
                        }

                        if (!mysql_query($sql, $this->mysql)) {
                            return false;
                        }
                    } elseif (!mysql_query('INSERT INTO `' . $this->options['prefix'][0] . 'cache_data` (`id`, `items`, `data`, `mtime`) VALUES(' . $feed_id . ', ' . count($prepared[1]) . ', \'' . mysql_real_escape_string($prepared[0]) . '\', ' . time() . ')', $this->mysql)) {
                        return false;
                    }

                    $ids = array_keys($prepared[1]);
                    if (!empty($ids)) {
                        foreach ($ids as $id) {
                            $database_ids[] = mysql_real_escape_string($id);
                        }

                        if ($query = mysql_unbuffered_query('SELECT `id` FROM `' . $this->options['prefix'][0] . 'items` WHERE `id` = \'' . implode('\' OR `id` = \'', $database_ids) . '\' AND `feed_id` = ' . $feed_id, $this->mysql)) {
                            $existing_ids = array();
                            while ($row = mysql_fetch_row($query)) {
                                $existing_ids[] = $row[0];
                            }

                            $new_ids = array_diff($ids, $existing_ids);

                            foreach ($new_ids as $new_id) {
                                if (!($date = $prepared[1][$new_id]->get_date('U'))) {
                                    $date = time();
                                }

                                if (!mysql_query('INSERT INTO `' . $this->options['prefix'][0] . 'items` (`feed_id`, `id`, `data`, `posted`) VALUES(' . $feed_id . ', \'' . mysql_real_escape_string($new_id) . '\', \'' . mysql_real_escape_string(serialize($prepared[1][$new_id]->data)) . '\', ' . $date . ')', $this->mysql)) {
                                    return false;
                                }
                            }
                            return true;
                        }
                    } else {
                        return true;
                    }
                }
            } elseif ($query = mysql_query('SELECT `id` FROM `' . $this->options['prefix'][0] . 'cache_data` WHERE `id` = ' . $feed_id, $this->mysql)) {
                if (mysql_num_rows($query)) {
                    if (mysql_query('UPDATE `' . $this->options['prefix'][0] . 'cache_data` SET `items` = 0, `data` = \'' . mysql_real_escape_string(serialize($data)) . '\', `mtime` = ' . time() . ' WHERE `id` = ' . $feed_id, $this->mysql)) {
                        return true;
                    }
                } elseif (mysql_query('INSERT INTO `' . $this->options['prefix'][0] . 'cache_data` (`id`, `items`, `data`, `mtime`) VALUES(\'' . mysql_real_escape_string($this->id) . '\', 0, \'' . mysql_real_escape_string(serialize($data)) . '\', ' . time() . ')', $this->mysql)) {
                    return true;
                }
            }
        }
        return false;

    }

    function load()
    {
        if ($this->mysql && ($query = mysql_query('SELECT `items`, `data` FROM `' . $this->options['prefix'][0] . 'cache_data` WHERE `id` = \'' . mysql_real_escape_string($this->id) . "'", $this->mysql)) && ($row = mysql_fetch_row($query))) {
            $data = unserialize($row[1]);

            if (isset($this->options['items'][0])) {
                $items = (int) $this->options['items'][0];
            } else {
                $items = (int) $row[0];
            }

            if ($items !== 0) {
                if (isset($data['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['feed'][0])) {
                    $feed = & $data['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['feed'][0];
                } elseif (isset($data['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['feed'][0])) {
                    $feed = & $data['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['feed'][0];
                } elseif (isset($data['child'][SIMPLEPIE_NAMESPACE_RDF]['RDF'][0])) {
                    $feed = & $data['child'][SIMPLEPIE_NAMESPACE_RDF]['RDF'][0];
                } elseif (isset($data['child'][SIMPLEPIE_NAMESPACE_RSS_20]['rss'][0])) {
                    $feed = & $data['child'][SIMPLEPIE_NAMESPACE_RSS_20]['rss'][0];
                } else {
                    $feed = null;
                }

                if ($feed !== null) {
                    $sql = 'SELECT `data` FROM `' . $this->options['prefix'][0] . 'items` WHERE `feed_id` = \'' . mysql_real_escape_string($this->id) . '\' ORDER BY `posted` DESC';
                    if ($items > 0) {
                        $sql .= ' LIMIT ' . $items;
                    }

                    if ($query = mysql_unbuffered_query($sql, $this->mysql)) {
                        while ($row = mysql_fetch_row($query)) {
                            $feed['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['entry'][] = unserialize($row[0]);
                        }
                    } else {
                        return false;
                    }
                }
            }
            return $data;
        }
        return false;

    }

    function mtime()
    {
        if ($this->mysql && ($query = mysql_query('SELECT `mtime` FROM `' . $this->options['prefix'][0] . 'cache_data` WHERE `id` = \'' . mysql_real_escape_string($this->id) . "'", $this->mysql)) && ($row = mysql_fetch_row($query))) {
            return $row[0];
        } else {
            return false;
        }

    }

    function touch()
    {
        if ($this->mysql && ($query = mysql_query('UPDATE `' . $this->options['prefix'][0] . 'cache_data` SET `mtime` = ' . time() . ' WHERE `id` = \'' . mysql_real_escape_string($this->id) . "'", $this->mysql)) && mysql_affected_rows($this->mysql)) {
            return true;
        } else {
            return false;
        }

    }

    function unlink()
    {
        if ($this->mysql && ($query = mysql_query('DELETE FROM `' . $this->options['prefix'][0] . 'cache_data` WHERE `id` = \'' . mysql_real_escape_string($this->id) . "'", $this->mysql)) && ($query2 = mysql_query('DELETE FROM `' . $this->options['prefix'][0] . 'items` WHERE `feed_id` = \'' . mysql_real_escape_string($this->id) . "'", $this->mysql))) {
            return true;
        } else {
            return false;
        }

    }

}