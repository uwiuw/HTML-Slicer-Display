<?php

class SimplePie_Parser
{

    var $error_code;
    var $error_string;
    var $current_line;
    var $current_column;
    var $current_byte;
    var $separator = ' ';
    var $namespace = array('');
    var $element = array('');
    var $xml_base = array('');
    var $xml_base_explicit = array(false);
    var $xml_lang = array('');
    var $data = array();
    var $datas = array(array());
    var $current_xhtml_construct = -1;
    var $encoding;

    function parse(&$data, $encoding)
    {
        // Use UTF-8 if we get passed US-ASCII, as every US-ASCII character is a UTF-8 character
        if (strtoupper($encoding) === 'US-ASCII') {
            $this->encoding = 'UTF-8';
        } else {
            $this->encoding = $encoding;
        }

        // Strip BOM:
        // UTF-32 Big Endian BOM
        if (substr($data, 0, 4) === "\x00\x00\xFE\xFF") {
            $data = substr($data, 4);
        }
        // UTF-32 Little Endian BOM
        elseif (substr($data, 0, 4) === "\xFF\xFE\x00\x00") {
            $data = substr($data, 4);
        }
        // UTF-16 Big Endian BOM
        elseif (substr($data, 0, 2) === "\xFE\xFF") {
            $data = substr($data, 2);
        }
        // UTF-16 Little Endian BOM
        elseif (substr($data, 0, 2) === "\xFF\xFE") {
            $data = substr($data, 2);
        }
        // UTF-8 BOM
        elseif (substr($data, 0, 3) === "\xEF\xBB\xBF") {
            $data = substr($data, 3);
        }

        if (substr($data, 0, 5) === '<?xml' && strspn(substr($data, 5, 1), "\x09\x0A\x0D\x20") && ($pos = strpos($data, '?>')) !== false) {
            $declaration = & new SimplePie_XML_Declaration_Parser(substr($data, 5, $pos - 5));
            if ($declaration->parse()) {
                $data = substr($data, $pos + 2);
                $data = '<?xml version="' . $declaration->version . '" encoding="' . $encoding . '" standalone="' . (($declaration->standalone) ? 'yes' : 'no') . '"?>' . $data;
            } else {
                $this->error_string = 'SimplePie bug! Please report this!';
                return false;
            }
        }

        $return = true;

        static $xml_is_sane = null;
        if ($xml_is_sane === null) {
            $parser_check = xml_parser_create();
            xml_parse_into_struct($parser_check, '<foo>&amp;</foo>', $values);
            xml_parser_free($parser_check);
            $xml_is_sane = isset($values[0]['value']);
        }

        // Create the parser
        if ($xml_is_sane) {
            $xml = xml_parser_create_ns($this->encoding, $this->separator);
            xml_parser_set_option($xml, XML_OPTION_SKIP_WHITE, 1);
            xml_parser_set_option($xml, XML_OPTION_CASE_FOLDING, 0);
            xml_set_object($xml, $this);
            xml_set_character_data_handler($xml, 'cdata');
            xml_set_element_handler($xml, 'tag_open', 'tag_close');

            // Parse!
            if (!xml_parse($xml, $data, true)) {
                $this->error_code = xml_get_error_code($xml);
                $this->error_string = xml_error_string($this->error_code);
                $return = false;
            }
            $this->current_line = xml_get_current_line_number($xml);
            $this->current_column = xml_get_current_column_number($xml);
            $this->current_byte = xml_get_current_byte_index($xml);
            xml_parser_free($xml);
            return $return;
        } else {
            libxml_clear_errors();
            $xml = & new XMLReader();
            $xml->xml($data);
            while (@$xml->read()) {
                switch ($xml->nodeType)
                {

                    case constant('XMLReader::END_ELEMENT'):
                        if ($xml->namespaceURI !== '') {
                            $tagName = "{$xml->namespaceURI}{$this->separator}{$xml->localName}";
                        } else {
                            $tagName = $xml->localName;
                        }
                        $this->tag_close(null, $tagName);
                        break;
                    case constant('XMLReader::ELEMENT'):
                        $empty = $xml->isEmptyElement;
                        if ($xml->namespaceURI !== '') {
                            $tagName = "{$xml->namespaceURI}{$this->separator}{$xml->localName}";
                        } else {
                            $tagName = $xml->localName;
                        }
                        $attributes = array();
                        while ($xml->moveToNextAttribute()) {
                            if ($xml->namespaceURI !== '') {
                                $attrName = "{$xml->namespaceURI}{$this->separator}{$xml->localName}";
                            } else {
                                $attrName = $xml->localName;
                            }
                            $attributes[$attrName] = $xml->value;
                        }
                        $this->tag_open(null, $tagName, $attributes);
                        if ($empty) {
                            $this->tag_close(null, $tagName);
                        }
                        break;
                    case constant('XMLReader::TEXT'):

                    case constant('XMLReader::CDATA'):
                        $this->cdata(null, $xml->value);
                        break;
                }
            }
            if ($error = libxml_get_last_error()) {
                $this->error_code = $error->code;
                $this->error_string = $error->message;
                $this->current_line = $error->line;
                $this->current_column = $error->column;
                return false;
            } else {
                return true;
            }
        }

    }

    function get_error_code()
    {
        return $this->error_code;

    }

    function get_error_string()
    {
        return $this->error_string;

    }

    function get_current_line()
    {
        return $this->current_line;

    }

    function get_current_column()
    {
        return $this->current_column;

    }

    function get_current_byte()
    {
        return $this->current_byte;

    }

    function get_data()
    {
        return $this->data;

    }

    function tag_open($parser, $tag, $attributes)
    {
        list($this->namespace[], $this->element[]) = $this->split_ns($tag);

        $attribs = array();
        foreach ($attributes as $name => $value) {
            list($attrib_namespace, $attribute) = $this->split_ns($name);
            $attribs[$attrib_namespace][$attribute] = $value;
        }

        if (isset($attribs[SIMPLEPIE_NAMESPACE_XML]['base'])) {
            $this->xml_base[] = SimplePie_Misc::absolutize_url($attribs[SIMPLEPIE_NAMESPACE_XML]['base'], end($this->xml_base));
            $this->xml_base_explicit[] = true;
        } else {
            $this->xml_base[] = end($this->xml_base);
            $this->xml_base_explicit[] = end($this->xml_base_explicit);
        }

        if (isset($attribs[SIMPLEPIE_NAMESPACE_XML]['lang'])) {
            $this->xml_lang[] = $attribs[SIMPLEPIE_NAMESPACE_XML]['lang'];
        } else {
            $this->xml_lang[] = end($this->xml_lang);
        }

        if ($this->current_xhtml_construct >= 0) {
            $this->current_xhtml_construct++;
            if (end($this->namespace) === SIMPLEPIE_NAMESPACE_XHTML) {
                $this->data['data'] .= '<' . end($this->element);
                if (isset($attribs[''])) {
                    foreach ($attribs[''] as $name => $value) {
                        $this->data['data'] .= ' ' . $name . '="' . htmlspecialchars($value, ENT_COMPAT, $this->encoding) . '"';
                    }
                }
                $this->data['data'] .= '>';
            }
        } else {
            $this->datas[] = & $this->data;
            $this->data = & $this->data['child'][end($this->namespace)][end($this->element)][];
            $this->data = array('data' => '', 'attribs' => $attribs, 'xml_base' => end($this->xml_base), 'xml_base_explicit' => end($this->xml_base_explicit), 'xml_lang' => end($this->xml_lang));
            if ((end($this->namespace) === SIMPLEPIE_NAMESPACE_ATOM_03 && in_array(end($this->element), array('title', 'tagline', 'copyright', 'info', 'summary', 'content')) && isset($attribs['']['mode']) && $attribs['']['mode'] === 'xml')
                || (end($this->namespace) === SIMPLEPIE_NAMESPACE_ATOM_10 && in_array(end($this->element), array('rights', 'subtitle', 'summary', 'info', 'title', 'content')) && isset($attribs['']['type']) && $attribs['']['type'] === 'xhtml')) {
                $this->current_xhtml_construct = 0;
            }
        }

    }

    function cdata($parser, $cdata)
    {
        if ($this->current_xhtml_construct >= 0) {
            $this->data['data'] .= htmlspecialchars($cdata, ENT_QUOTES, $this->encoding);
        } else {
            $this->data['data'] .= $cdata;
        }

    }

    function tag_close($parser, $tag)
    {
        if ($this->current_xhtml_construct >= 0) {
            $this->current_xhtml_construct--;
            if (end($this->namespace) === SIMPLEPIE_NAMESPACE_XHTML && !in_array(end($this->element), array('area', 'base', 'basefont', 'br', 'col', 'frame', 'hr', 'img', 'input', 'isindex', 'link', 'meta', 'param'))) {
                $this->data['data'] .= '</' . end($this->element) . '>';
            }
        }
        if ($this->current_xhtml_construct === -1) {
            $this->data = & $this->datas[count($this->datas) - 1];
            array_pop($this->datas);
        }

        array_pop($this->element);
        array_pop($this->namespace);
        array_pop($this->xml_base);
        array_pop($this->xml_base_explicit);
        array_pop($this->xml_lang);

    }

    function split_ns($string)
    {
        static $cache = array();
        if (!isset($cache[$string])) {
            if ($pos = strpos($string, $this->separator)) {
                static $separator_length;
                if (!$separator_length) {
                    $separator_length = strlen($this->separator);
                }
                $namespace = substr($string, 0, $pos);
                $local_name = substr($string, $pos + $separator_length);
                if (strtolower($namespace) === SIMPLEPIE_NAMESPACE_ITUNES) {
                    $namespace = SIMPLEPIE_NAMESPACE_ITUNES;
                }

                // Normalize the Media RSS namespaces
                if ($namespace === SIMPLEPIE_NAMESPACE_MEDIARSS_WRONG) {
                    $namespace = SIMPLEPIE_NAMESPACE_MEDIARSS;
                }
                $cache[$string] = array($namespace, $local_name);
            } else {
                $cache[$string] = array('', $string);
            }
        }
        return $cache[$string];

    }

}